<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

use Superbalist\Shared\Libs\Money\Linter\LintWarning;

abstract class FunctionCallTest extends BaseLinterTest {

	/**
	 * @return string
	 */
	abstract protected function getFunctionName();

	/**
	 * {@inheritdoc}
	 */
	public function analyse($source)
	{
		$warnings = array();
		$tokens = token_get_all($source);
		foreach ($tokens as $token) {
			if (is_array($token)) {
				if ($token[0] === T_STRING && strcasecmp($token[1], $this->getFunctionName()) === 0) {
					// we found a call to the function
					// only need to create a new warning if one doesn't already exist for this line
					if ( ! isset($warnings[$token[2]])) {
						$warnings[$token[2]] = new LintWarning($token[2], $this->getLineFromSource($source, $token[2]), $this);
					}
				}
			}
		}
		return array_values($warnings);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return sprintf('The line contains a call to the %s() function.', $this->getFunctionName());
	}
}