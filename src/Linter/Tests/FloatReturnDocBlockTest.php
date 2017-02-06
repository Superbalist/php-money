<?php

namespace Superbalist\Money\Linter\Tests;

class FloatReturnDocBlockTest extends PHPDocBlockTest
{
    /**
     * @return array
     */
    protected function getAnnotationCriteria()
    {
        return [
            'annotation' => 'return',
            'type' => 'float',
        ];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a PHPDoc "@return float" comment.';
    }
}
