<?php

namespace Superbalist\Money\Linter\Tests;

class MinusOperatorTest extends ContainsSimpleTokenTest
{
    /**
     * @return string
     */
    protected function getToken()
    {
        return '-';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a minus (-) operator.';
    }
}
