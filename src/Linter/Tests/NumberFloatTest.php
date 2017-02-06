<?php

namespace Superbalist\Money\Linter\Tests;

class NumberFloatTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_DNUMBER;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a number of type float.';
    }
}
