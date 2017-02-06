<?php

namespace Superbalist\Money\Linter\Tests;

class SmallerThanOrEqualsOperatorTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_IS_SMALLER_OR_EQUAL;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a smaller than or equals (<=) operator.';
    }
}
