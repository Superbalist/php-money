<?php

namespace Superbalist\Money\Linter\Tests;

class VariablePlusEqualsTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_PLUS_EQUAL;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a "$variable +=" operation.';
    }
}
