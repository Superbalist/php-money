<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class NumberFloatTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_DNUMBER;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a number of type float.';
	}
}