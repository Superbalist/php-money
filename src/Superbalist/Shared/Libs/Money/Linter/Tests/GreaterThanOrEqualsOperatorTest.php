<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class GreaterThanOrEqualsOperatorTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_IS_GREATER_OR_EQUAL;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a greater than or equals (>=) operator.';
	}
}