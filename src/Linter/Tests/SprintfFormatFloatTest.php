<?php

namespace Superbalist\Money\Linter\Tests;

use Superbalist\Money\Linter\LintWarning;

class SprintfFormatFloatTest extends BaseLinterTest
{
    /**
     * @param string $source
     *
     * @return array
     */
    public function analyse($source)
    {
        $warnings = [];
        $functions = $this->extractSprintfFloatFormatFunctionCalls($source);
        foreach ($functions as $function) {
            $token = $function['token'];
            if (!isset($warnings[$token[2]])) {
                $warnings[$token[2]] = LintWarning::make($source, $token[2], $this);
            }
        }
        return array_values($warnings);
    }

    /**
     * @param string $source
     *
     * @return array
     */
    protected function extractSprintfFloatFormatFunctionCalls($source)
    {
        $matching = [];
        $functions = $this->extractMatchingFunctionCallsFromSource($source, 'sprintf');
        foreach ($functions as $function) {
            // format argument should be in position 0
            if (count($function['args']) > 0) {
                $arg = array_shift($function['args']);
                if ($arg['type'] === 'argument' && preg_match('/%(\.[0-9]+)?f/', $arg['token'][1])) {
                    $matching[] = $function;
                }
            }
        }
        return $matching;
    }

    /**
     * @param string $source
     * @param string $function
     *
     * @return array
     */
    protected function extractMatchingFunctionCallsFromSource($source, $function)
    {
        $tokens = token_get_all($source);
        return $this->extractMatchingFunctionCallsFromTokens($tokens, $function);
    }

    /**
     * @param array $tokens
     * @param string $function
     *
     * @return array
     */
    protected function extractMatchingFunctionCallsFromTokens($tokens, $function)
    {
        $functions = $this->extractFunctionCallsFromTokens($tokens);
        return $this->extractMatchingFunctionCallsFromFunctions($functions, $function);
    }

    /**
     * @param array $functions
     * @param string $function
     *
     * @return array
     */
    protected function extractMatchingFunctionCallsFromFunctions(array $functions, $function)
    {
        $matching = [];
        foreach ($functions as $f) {
            if (strcasecmp($f['name'], $function) === 0) {
                // found a matching function
                $matching[] = $f;
                // check if any of this function's arguments contain this function
                $subfunctions = array_filter(
                    $f['args'],
                    function ($arg) {
                        return $arg['type'] === 'function';
                    }
                );
                $matching = array_merge(
                    $matching,
                    $this->extractMatchingFunctionCallsFromFunctions($subfunctions, $function)
                );
            }
        }
        return $matching;
    }

    /**
     * @param array $tokens
     * @param bool $inRecursiveFunction
     *
     * @return array
     */
    protected function extractFunctionCallsFromTokens(array &$tokens, $inRecursiveFunction = false)
    {
        $isInFunction = false;
        $functions = [];
        $function = null;
        while (count($tokens) > 0) {
            // grab the next token off the top of the stack
            $token = array_shift($tokens);
            if ($isInFunction) {
                if (is_string($token)) {
                    if ($token === ')') {
                        // we're done with this function
                        $isInFunction = false;
                        $functions[] = $function;
                        $function = null;
                        if ($inRecursiveFunction) {
                            return $functions;
                        }
                    }
                } else {
                    if ($token[0] === T_STRING && $this->isFunction($token[1])) {
                        // we found a call to a function within an argument of the current function
                        array_unshift($tokens, $token);
                        $function['args'] = array_merge(
                            $function['args'],
                            $this->extractFunctionCallsFromTokens($tokens, true)
                        );
                    } else {
                        if ($token[0] !== T_WHITESPACE) {
                            $function['args'][] = [
                                'type' => 'argument',
                                'token' => $token,
                            ];
                        }
                    }
                }
            } else {
                // check if we're starting a function call
                if (is_array($token) && $token[0] === T_STRING && $this->isFunction($token[1])) {
                    // we're starting a function!
                    $isInFunction = true;
                    $function = [
                        'name' => $token[1],
                        'type' => 'function',
                        'token' => $token,
                        'args' => [],
                    ];
                }
            }
        }
        return $functions;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    protected function isFunction($name)
    {
        return function_exists($name);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'This line contains a call to sprintf() with the format "%.2f".';
    }
}
