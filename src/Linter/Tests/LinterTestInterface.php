<?php

namespace Superbalist\Money\Linter\Tests;

interface LinterTestInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $source
     *
     * @return array
     */
    public function analyse($source);

    /**
     * @return string
     */
    public function getDescription();
}
