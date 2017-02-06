<?php

namespace Superbalist\Money\Linter\Tests;

use Superbalist\Money\Linter\LintWarning;

abstract class PHPDocBlockTest extends BaseLinterTest
{
    /**
     * @return array
     */
    abstract protected function getAnnotationCriteria();

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
                if ($token[0] === T_DOC_COMMENT) {
                    // we found a doc style comment
                    // find matching phpdoc annotations
                    $annotations = $this->getMatchingAnnotationsFromComment($token[1], $this->getAnnotationCriteria());
                    if (count($annotations) > 0) {
                        // only need to create a new warning if one doesn't already exist for this line
                        if (!isset($warnings[$token[2]])) {
                            $warnings[$token[2]] = LintWarning::make($source, $token[2], $this);
                        }
                    }
                }
            }
        }
        return array_values($warnings);
    }

    /**
     * @param string $comment
     *
     * @return array
     */
    protected function getAnnotationsFromComment($comment)
    {
        // normalise new line chars
        $comment = preg_replace('~\R~u', "\n", $comment);
        $lines = explode("\n", $comment);
        $annotations = [];
        foreach ($lines as $line) {
            if (preg_match('/^\s\*\s@(param)\s([a-z0-9]+)\s(\$[a-z0-9_]+)(\s(.+))?$/i', $line, $matches)) {
                $annotations[] = [
                    'annotation' => 'param',
                    'type' => strtolower($matches[2]),
                    'variable' => $matches[3],
                    'description' => isset($matches[5]) ? $matches[5] : null,
                ];
            } elseif (preg_match('/^\s\*\s@(return)\s([a-z0-9]+)(\s(.+))?$/i', $line, $matches)) {
                $annotations[] = [
                    'annotation' => 'return',
                    'type' => strtolower($matches[2]),
                    'description' => isset($matches[4]) ? $matches[4] : null,
                ];
            } else {
                if (preg_match('/^\s\*\s@(var)\s([a-z0-9]+)(\s(.+))?$/i', $line, $matches)) {
                    $annotations[] = [
                        'annotation' => 'var',
                        'type' => strtolower($matches[2]),
                        'description' => isset($matches[4]) ? $matches[4] : null,
                    ];
                }
            }
        }
        return $annotations;
    }

    /**
     * @param string $comment
     * @param array $criteria
     *
     * @return array
     */
    protected function getMatchingAnnotationsFromComment($comment, array $criteria)
    {
        $matching = [];
        $annotations = $this->getAnnotationsFromComment($comment);
        foreach ($annotations as $annotation) {
            foreach ($criteria as $k => $v) {
                if (!isset($annotation[$k]) || $annotation[$k] != $v) {
                    continue 2;
                }
            }
            $matching[] = $annotation;
        }
        return $matching;
    }
}
