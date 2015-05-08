<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

use Superbalist\Shared\Libs\Money\Linter\LintWarning;

abstract class ContainsTokenTest extends BaseLinterTest {

	/**
	 * @return int
	 */
	abstract protected function getToken();

	/**
	 * @param string $source
	 * @return array
	 */
	public function analyse($source)
	{
		$warnings = array();
		$tokens = token_get_all($source);
		foreach ($tokens as $token) {
			if (is_array($token)) {
				if ($token[0] === $this->getToken()) {
					// we found the token
					// only need to create a new warning if one doesn't already exist for this line
					if ( ! isset($warnings[$token[2]])) {
						$warnings[$token[2]] = new LintWarning($token[2], $this->getLineFromSource($source, $token[2]), $this);
					}
				}
			}
		}
		return array_values($warnings);
	}
}
