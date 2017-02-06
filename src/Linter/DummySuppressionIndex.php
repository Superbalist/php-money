<?php

namespace Superbalist\Money\Linter;

class DummySuppressionIndex implements SuppressionIndexInterface
{
    /**
     * @param string $filename
     * @param int $number
     * @param string $line
     *
     * @return bool
     */
    public function isSuppressed($filename, $number, $line)
    {
        return false;
    }

    /**
     * @param string $filename
     * @param int $number
     * @param string $line
     */
    public function add($filename, $number, $line)
    {
    }

    /**
     *
     */
    public function wipe()
    {
    }
}
