<?php
namespace Superbalist\Money\Linter\Tests;

class IntParamDocBlockTest extends PHPDOcBlockTest
{

    /**
     * @return array
     */
    protected function getAnnotationCriteria()
    {
        return array(
            'annotation' => 'param',
            'type' => 'int'
        );
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'The line contains a PHPDoc "@param int" comment.';
    }
}
