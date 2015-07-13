<?php namespace Superbalist\Shared\Libs\Money\Linter;

class Linter {

	/**
	 * @var array
	 */
	protected $tests = array();

	/**
	 * @param array $tests
	 */
	public function __construct(array $tests = array())
	{
		$this->tests = count($tests) > 0 ? $tests : TestFactory::makeAll();
	}

	/**
	 * @param string $dir
	 * @return IndexResult
	 */
	public function lintDir($dir)
	{
		$index = FileIndex::make($dir);
		$indexResult = new IndexResult($index);
		foreach ($index->getFiles() as $filename) {
			$sourceResult = $this->lintFile($filename);
			if ($sourceResult->hasWarnings()) {
				$indexResult->addSourceResult($sourceResult);
			}
		}
		return $indexResult;
	}

	/**
	 * @param string $filename
	 * @return SourceResult
	 */
	public function lintFile($filename)
	{
		$source = file_get_contents($filename);
		if (preg_match('/\.blade\.php$/i', $filename)) {
			$source = \Blade::compileString($source);
		}
		$key = sprintf('linter_%s_%s', md5($filename), md5($source));
		return \Cache::remember($key, 1440, function() use ($source, $filename) {
			return $this->lintSource($source, $filename);
		});
	}

	/**
	 * @param string $source
	 * @param string $filename
	 * @return SourceResult
	 */
	public function lintSource($source, $filename = null)
	{
		$result = new SourceResult($filename);
		$timings = array();
		foreach ($this->tests as $test) {
			/** @var \Superbalist\Shared\Libs\Money\Linter\Tests\LinterTestInterface $test */
			$start = microtime(true);
			$warnings = $test->analyse($source);
			$result->addWarnings($warnings);
			$end = microtime(true);
			$timings[$test->getName()] = $end - $start;
		}
		$result->setDebugTimings($timings);
		return $result;
	}
}
