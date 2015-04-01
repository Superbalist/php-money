<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class FloatCastTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_DOUBLE_CAST;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a cast to a float, real or double.';
	}
}