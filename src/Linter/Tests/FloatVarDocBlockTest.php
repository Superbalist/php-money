<?php

namespace Superbalist\Money\Linter\Tests;

class FloatVarDocBlockTest extends PHPDocBlockTest
{
    /**
     * @return array
     */
    protected function getAnnotationCriteria()
    {
        return [
            'annotation' => 'var',
            'type' => 'float',
        ];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a PHPDoc "@var float" comment.';
    }
}
