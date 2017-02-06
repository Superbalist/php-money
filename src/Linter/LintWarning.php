<?php

namespace Superbalist\Money\Linter;

use Superbalist\Money\Linter\Tests\LinterTestInterface;

class LintWarning
{
    /**
     * @var int
     */
    protected $number;

    /**
     * @var string
     */
    protected $line;

    /**
     * @var string
     */
    protected $snippet;

    /**
     * @var Tests\LinterTestInterface
     */
    protected $test;

    /**
     * @param int $number
     * @param string $line
     * @param string $snippet
     * @param LinterTestInterface $test
     */
    public function __construct($number, $line, $snippet, LinterTestInterface $test)
    {
        $this->number = $number;
        $this->line = $line;
        $this->snippet = $snippet;
        $this->test = $test;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @return string
     */
    public function getSnippet()
    {
        return $this->snippet;
    }

    /**
     * @return LinterTestInterface
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param string $source
     * @param int $number
     * @param LinterTestInterface $test
     *
     * @return LintWarning
     */
    public static function make($source, $number, LinterTestInterface $test)
    {
        $line = self::getLineFromSource($source, $number);
        $snippet = self::getCodeSnippet($source, $number);
        return new self($number, $line, $snippet, $test);
    }

    /**
     * @param string $source
     * @param int $number
     *
     * @return string
     */
    protected static function getLineFromSource($source, $number)
    {
        $source = preg_replace('~\R~u', "\n", $source);
        $lines = explode("\n", $source);
        $line = isset($lines[$number - 1]) ? $lines[$number - 1] : null;
        if ($line === null) {
            return $line;
        }
        return trim($line);
    }

    /**
     * @param string $source
     * @param int $number
     *
     * @return string
     */
    protected static function getCodeSnippet($source, $number)
    {
        $source = preg_replace('~\R~u', "\n", $source);
        $lines = explode("\n", $source);
        $index = $number - 1;
        $nPreviousLines = 2;
        $nAfterLines = 2;
        $start = max(0, $index - $nPreviousLines);
        $end = min(count($lines) - 1, $index + $nAfterLines);
        $preview = array_slice($lines, $start, $end - $start + 1);
        $l = $start;
        foreach ($preview as &$part) {
            $prefix = ++$l;
            if ($l == $number) {
                $prefix .= '*';
            }
            $prefix = str_pad($prefix, 6, ' ');
            $part = str_replace("\t", '   ', $part);
            $part = $prefix . $part;
        }
        return implode("\n", $preview);
    }
}
