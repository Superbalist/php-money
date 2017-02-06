<?php

namespace Superbalist\Money\Linter;

class Linter
{
    /**
     * @var array
     */
    protected $tests = [];

    /**
     * @param array $tests
     */
    public function __construct(array $tests = [])
    {
        $this->tests = count($tests) > 0 ? $tests : TestFactory::makeAll();
    }

    /**
     * @param string $dir
     *
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
     *
     * @return SourceResult
     */
    public function lintFile($filename)
    {
        $source = file_get_contents($filename);
        return $this->lintSource($source, $filename);
    }

    /**
     * @param string $source
     * @param string $filename
     *
     * @return SourceResult
     */
    public function lintSource($source, $filename = null)
    {
        $result = new SourceResult($filename);
        $timings = [];
        foreach ($this->tests as $test) {
            /** @var \Superbalist\Money\Linter\Tests\LinterTestInterface $test */
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
