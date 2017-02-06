<?php

namespace Superbalist\Money\Linter\Tests;

abstract class BaseLinterTest implements LinterTestInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        $name = get_class($this);
        if (($p = strrpos($name, '\\')) !== false) {
            $name = substr($name, $p + 1);
        }
        return $name;
    }
}
