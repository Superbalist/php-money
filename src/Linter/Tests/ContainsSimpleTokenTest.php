<?php

namespace Superbalist\Money\Linter\Tests;

use Superbalist\Money\Linter\LintWarning;

abstract class ContainsSimpleTokenTest extends BaseLinterTest
{
    /**
     * @return string
     */
    abstract protected function getToken();

    /**
     * @param string $source
     *
     * @return array
     */
    public function analyse($source)
    {
        // simple tokens come back as strings and don't contain any line data
        // therefore, we keep track of line numbers separately and assume that if a simple token is found, it must
        // appear on the last recorded line numbers
        $warnings = [];
        $tokens = token_get_all($source);
        $line = 1;
        foreach ($tokens as $token) {
            if (is_array($token)) {
                $line = $token[2]; // keep track of line number
            } else {
                if ($token === $this->getToken()) {
                    // we found the token
                    // only need to create a new warning if one doesn't already exist for this line
                    if (!isset($warnings[$line])) {
                        $warnings[$line] = LintWarning::make($source, $line, $this);
                    }
                }
            }
        }
        return array_values($warnings);
    }
}
