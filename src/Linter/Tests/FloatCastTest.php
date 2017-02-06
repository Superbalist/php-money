<?php

namespace Superbalist\Money\Linter\Tests;

class FloatCastTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_DOUBLE_CAST;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a cast to a float, real or double.';
    }
}
