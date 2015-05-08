<?php namespace Superbalist\Shared\Libs\Money\Linter;

use Cache;

class FileIndex {

	/**
	 * @var array
	 */
	protected $files;

	/**
	 * @param array $files
	 */
	public function __construct(array $files)
	{
		$this->files = $files;
	}

	/**
	 * @return array
	 */
	public function getFiles()
	{
		return $this->files;
	}

	/**
	 * @param string $dir
	 * @return FileIndex
	 */
	public static function make($dir)
	{
		$key = sprintf('money_linter_file_index_%s', md5($dir));
		$files = Cache::remember($key, 5, function() use ($dir) {
			$dirIterator = new \RecursiveDirectoryIterator($dir);
			$dirIterator->setFlags(\RecursiveDirectoryIterator::SKIP_DOTS);
			$recursiveIterator = new \RecursiveIteratorIterator($dirIterator, \RecursiveIteratorIterator::SELF_FIRST);
			$results = array();
			foreach ($recursiveIterator as $file) {
				/** @var \SplFileInfo $file */
				// ignore non files
				if ( ! $file->isFile()) {
					continue;
				}
				// ignore non php files
				$ext = strtolower($file->getExtension());
				if ($ext !== 'php') {
					continue;
				}
				// ignore files in the money namespace
				if (preg_match('#src/Superbalist/Shared/Libs/Money#i', $file->getPath())) {
					continue;
				}
				$results[] = $file->getPathname();
			}
			return $results;
		});
		return new self($files);
	}
}
