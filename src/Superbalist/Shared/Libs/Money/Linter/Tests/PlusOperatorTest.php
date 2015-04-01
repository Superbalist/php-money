<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class PlusOperatorTest extends ContainsSimpleTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return '+';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a plus (+) operator.';
	}
}