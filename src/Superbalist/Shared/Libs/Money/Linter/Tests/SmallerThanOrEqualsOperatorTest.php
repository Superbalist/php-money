<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class SmallerThanOrEqualsOperatorTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_IS_SMALLER_OR_EQUAL;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a smaller than or equals (<=) operator.';
	}
}