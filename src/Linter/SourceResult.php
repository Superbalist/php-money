<?php

namespace Superbalist\Money\Linter;

class SourceResult
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $warnings = [];

    /**
     * @var array
     */
    protected $timings = [];

    /**
     * @param string $filename
     */
    public function __construct($filename = null)
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return array
     */
    public function getWarnings()
    {
        return $this->warnings;
    }

    /**
     * @param LintWarning $warning
     */
    public function addWarning(LintWarning $warning)
    {
        $this->warnings[] = $warning;
    }

    /**
     * @param array $warnings
     */
    public function addWarnings(array $warnings)
    {
        foreach ($warnings as $warning) {
            $this->addWarning($warning);
        }
    }

    /**
     * @return bool
     */
    public function hasWarnings()
    {
        return count($this->warnings) > 0;
    }

    /**
     * @return int
     */
    public function countWarnings()
    {
        return count($this->warnings);
    }

    /**
     * @param array $timings
     */
    public function setDebugTimings($timings)
    {
        arsort($timings);
        $this->timings = $timings;
    }

    /**
     * @return array
     */
    public function getDebugTimings()
    {
        return $this->timings;
    }

    /**
     * @return float
     */
    public function getTotalTestRunTime()
    {
        return array_sum($this->timings);
    }
}
