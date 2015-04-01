<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class VariableTimesEqualsTest extends ContainsTokenTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getToken()
	{
		return T_MUL_EQUAL;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a "$variable *=" operation.';
	}
}