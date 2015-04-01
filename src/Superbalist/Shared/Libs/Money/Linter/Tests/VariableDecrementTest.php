<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class VariableDecrementTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_DEC;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a "$variable--" operation.';
	}
}