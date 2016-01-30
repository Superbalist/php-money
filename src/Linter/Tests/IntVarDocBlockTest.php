<?php
namespace Superbalist\Money\Linter\Tests;

class IntVarDocBlockTest extends PHPDOcBlockTest
{

    /**
     * @return array
     */
    protected function getAnnotationCriteria()
    {
        return array(
            'annotation' => 'var',
            'type' => 'int'
        );
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a PHPDoc "@var int" comment.';
    }
}
