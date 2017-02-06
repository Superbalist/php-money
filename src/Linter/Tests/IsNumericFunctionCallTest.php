<?php

namespace Superbalist\Money\Linter\Tests;

class IsNumericFunctionCallTest extends FunctionCallTest
{
    /**
     * @return string
     */
    protected function getFunctionName()
    {
        return 'is_numeric';
    }
}
