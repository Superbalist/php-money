<?php

namespace Superbalist\Money\Linter\Tests;

class IsIntegerFunctionCallTest extends FunctionCallTest
{
    /**
     * @return string
     */
    protected function getFunctionName()
    {
        return 'is_integer';
    }
}
