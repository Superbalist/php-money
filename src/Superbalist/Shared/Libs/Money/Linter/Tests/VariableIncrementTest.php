<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class VariableIncrementTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_INC;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a "$variable++" operation.';
	}
}