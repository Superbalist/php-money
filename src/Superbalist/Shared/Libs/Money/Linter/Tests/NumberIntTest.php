<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class NumberIntTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_LNUMBER;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a number of type int.';
	}
}