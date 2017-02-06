<?php

namespace Superbalist\Money\Linter\Tests;

class ModOperatorTest extends ContainsSimpleTokenTest
{
    /**
     * @return string
     */
    protected function getToken()
    {
        return '%';
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a mod (%) operator.';
    }
}
