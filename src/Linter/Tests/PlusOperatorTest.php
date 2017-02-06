<?php

namespace Superbalist\Money\Linter\Tests;

class PlusOperatorTest extends ContainsSimpleTokenTest
{
    /**
     * @return string
     */
    protected function getToken()
    {
        return '+';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a plus (+) operator.';
    }
}
