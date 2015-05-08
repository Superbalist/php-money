<?php namespace Superbalist\Shared\Libs\Money\Linter;

class IndexResult {

	/**
	 * @var FileIndex
	 */
	protected $fileIndex;

	/**
	 * @var array
	 */
	protected $sourceResults;

	/**
	 * @param FileIndex $fileIndex
	 * @param array $sourceResults
	 */
	public function __construct(FileIndex $fileIndex, array $sourceResults = array())
	{
		$this->fileIndex = $fileIndex;
		$this->sourceResults = $sourceResults;
	}

	/**
	 * @return FileIndex
	 */
	public function getFileIndex()
	{
		return $this->fileIndex;
	}

	/**
	 * @return array
	 */
	public function getSourceResults()
	{
		return $this->sourceResults;
	}

	/**
	 * @param SourceResult $sourceResult
	 */
	public function addSourceResult(SourceResult $sourceResult)
	{
		$this->sourceResults[] = $sourceResult;
	}

	/**
	 * @param string $filename
	 */
	public function save($filename)
	{
		$fp = fopen($filename, 'w');
		fputcsv($fp, array('filename', 'line_number', 'line', 'description'));
		foreach ($this->sourceResults as $sourceResult) {
			/** @var \Superbalist\Shared\Libs\Money\Linter\SourceResult $sourceResult */
			foreach ($sourceResult->getWarnings() as $warning) {
				/** @var \Superbalist\Shared\Libs\Money\Linter\LintWarning $warning */
				$data = array(
					$sourceResult->getFilename(),
					$warning->getNumber(),
					$warning->getLine(),
					$warning->getTest()->getDescription()
				);
				fputcsv($fp, $data);
			}
		}
		fclose($fp);
	}
}
