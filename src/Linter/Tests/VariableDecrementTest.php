<?php

namespace Superbalist\Money\Linter\Tests;

class VariableDecrementTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_DEC;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a "$variable--" operation.';
    }
}
