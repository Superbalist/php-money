<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class IntCastTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_INT_CAST;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a cast to a int.';
	}
}