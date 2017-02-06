<?php

namespace Superbalist\Money\Linter\Tests;

class GreaterThanOrEqualsOperatorTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_IS_GREATER_OR_EQUAL;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a greater than or equals (>=) operator.';
    }
}
