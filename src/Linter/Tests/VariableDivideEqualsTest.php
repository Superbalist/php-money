<?php

namespace Superbalist\Money\Linter\Tests;

class VariableDivideEqualsTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_DIV_EQUAL;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a "$variable /=" operation.';
    }
}
