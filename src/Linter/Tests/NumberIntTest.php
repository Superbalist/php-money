<?php

namespace Superbalist\Money\Linter\Tests;

class NumberIntTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_LNUMBER;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a number of type int.';
    }
}
