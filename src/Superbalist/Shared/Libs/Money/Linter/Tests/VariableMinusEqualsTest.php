<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class VariableMinusEqualsTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_MINUS_EQUAL;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a "$variable -=" operation.';
	}
}