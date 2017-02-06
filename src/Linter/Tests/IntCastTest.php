<?php

namespace Superbalist\Money\Linter\Tests;

class IntCastTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_INT_CAST;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a cast to a int.';
    }
}
