<?php

namespace Superbalist\Money\Linter\Tests;

class IntReturnDocBlockTest extends PHPDocBlockTest
{
    /**
     * @return array
     */
    protected function getAnnotationCriteria()
    {
        return [
            'annotation' => 'return',
            'type' => 'int',
        ];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a PHPDoc "@return int" comment.';
    }
}
