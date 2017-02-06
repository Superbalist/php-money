<?php

namespace Superbalist\Money\Linter\Tests;

class IsIntFunctionCallTest extends FunctionCallTest
{
    /**
     * @return string
     */
    protected function getFunctionName()
    {
        return 'is_int';
    }
}
