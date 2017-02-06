<?php

namespace Superbalist\Money\Linter\Tests;

class AbsFunctionCallTest extends FunctionCallTest
{
    /**
     * @return string
     */
    protected function getFunctionName()
    {
        return 'abs';
    }
}
