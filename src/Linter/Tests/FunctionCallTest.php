<?php

namespace Superbalist\Money\Linter\Tests;

use Superbalist\Money\Linter\LintWarning;

abstract class FunctionCallTest extends BaseLinterTest
{
    /**
     * @return string
     */
    abstract protected function getFunctionName();

    /**
     * @param string $source
     *
     * @return array
     */
    public function analyse($source)
    {
        $warnings = [];
        $tokens = token_get_all($source);
        foreach ($tokens as $token) {
            if (is_array($token)) {
                if ($token[0] === T_STRING && strcasecmp($token[1], $this->getFunctionName()) === 0) {
                    // we found a call to the function
                    // only need to create a new warning if one doesn't already exist for this line
                    if (!isset($warnings[$token[2]])) {
                        $warnings[$token[2]] = LintWarning::make($source, $token[2], $this);
                    }
                }
            }
        }
        return array_values($warnings);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return sprintf('The line contains a call to the %s() function.', $this->getFunctionName());
    }
}
