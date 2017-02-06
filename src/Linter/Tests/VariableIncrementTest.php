<?php

namespace Superbalist\Money\Linter\Tests;

class VariableIncrementTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_INC;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a "$variable++" operation.';
    }
}
