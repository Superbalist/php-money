<?php

namespace Superbalist\Money\Linter\Tests;

class IntVarDocBlockTest extends PHPDocBlockTest
{
    /**
     * @return array
     */
    protected function getAnnotationCriteria()
    {
        return [
            'annotation' => 'var',
            'type' => 'int',
        ];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a PHPDoc "@var int" comment.';
    }
}
