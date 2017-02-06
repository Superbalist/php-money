<?php

namespace Superbalist\Money\Linter\Tests;

class FloatvalFunctionCallTest extends FunctionCallTest
{
    /**
     * @return string
     */
    protected function getFunctionName()
    {
        return 'floatval';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a cast to a float, real or double.';
    }
}
