<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class MultiplyOperatorTest extends ContainsSimpleTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return '*';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a multiply (*) operator.';
	}
}