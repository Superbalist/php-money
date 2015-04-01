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
		$this->tests = $tests;
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
		return $this->lintSource($source, $filename);
	}

	/**
	 * @param string $source
	 * @param array $tests
	 * @param string $filename (optional)
	 * @return SourceResult
	 */
	public function lintSource($source, $filename = null)
	{
		$result = new SourceResult($filename);
		$tests = count($this->tests) > 0 ? $this->tests : TestFactory::makeAll();
		$timings = array();
		foreach ($tests as $test) { /** @var \Superbalist\Shared\Libs\Money\Linter\Tests\LinterTestInterface $test */
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