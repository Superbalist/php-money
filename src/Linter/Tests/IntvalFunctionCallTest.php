<?php

namespace Superbalist\Money\Linter\Tests;

class IntvalFunctionCallTest extends FunctionCallTest
{
    /**
     * @return string
     */
    protected function getFunctionName()
    {
        return 'intval';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a cast to a int.';
    }
}
