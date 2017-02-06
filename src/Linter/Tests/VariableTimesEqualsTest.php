<?php

namespace Superbalist\Money\Linter\Tests;

class VariableTimesEqualsTest extends ContainsTokenTest
{
    /**
     * @return int
     */
    protected function getToken()
    {
        return T_MUL_EQUAL;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a "$variable *=" operation.';
    }
}
