<?php
namespace Superbalist\Money\Linter\Tests;

class FloatVarDocBlockTest extends PHPDOcBlockTest
{

    /**
     * @return array
     */
    protected function getAnnotationCriteria()
    {
        return array(
            'annotation' => 'var',
            'type' => 'float'
        );
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a PHPDoc "@var float" comment.';
    }
}
