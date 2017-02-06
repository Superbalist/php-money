<?php

namespace Superbalist\Money\Linter\Tests;

class VariableModEqualsTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_MOD_EQUAL;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a "$variable %=" operation.';
    }
}
