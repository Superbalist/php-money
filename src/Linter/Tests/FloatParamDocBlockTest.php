<?php

namespace Superbalist\Money\Linter\Tests;

class FloatParamDocBlockTest extends PHPDocBlockTest
{
    /**
     * @return array
     */
    protected function getAnnotationCriteria()
    {
        return [
            'annotation' => 'param',
            'type' => 'float',
        ];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a PHPDoc "@param float" comment.';
    }
}
