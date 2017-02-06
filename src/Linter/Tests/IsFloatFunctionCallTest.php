<?php

namespace Superbalist\Money\Linter\Tests;

class IsFloatFunctionCallTest extends FunctionCallTest
{
    /**
     * @return string
     */
    protected function getFunctionName()
    {
        return 'is_float';
    }
}
