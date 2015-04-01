<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class SmallerThanOperatorTest extends ContainsSimpleTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return '<';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a smaller than (<) operator.';
	}
}