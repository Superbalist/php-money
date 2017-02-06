<?php

namespace Superbalist\Money\Linter\Tests;

class MinFunctionCallTest extends FunctionCallTest
{
    /**
     * @return string
     */
    protected function getFunctionName()
    {
        return 'min';
    }
}
