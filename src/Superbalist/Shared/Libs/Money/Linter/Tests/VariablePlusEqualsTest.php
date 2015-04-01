<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class VariablePlusEqualsTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_PLUS_EQUAL;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a "$variable +=" operation.';
	}
}