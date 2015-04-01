<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class VariableModEqualsTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_MOD_EQUAL;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a "$variable %=" operation.';
	}
}