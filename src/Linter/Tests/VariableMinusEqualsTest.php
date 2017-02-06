<?php

namespace Superbalist\Money\Linter\Tests;

class VariableMinusEqualsTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_MINUS_EQUAL;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a "$variable -=" operation.';
    }
}
