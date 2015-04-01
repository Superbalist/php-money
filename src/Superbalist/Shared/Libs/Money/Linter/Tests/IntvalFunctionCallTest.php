<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class IntvalFunctionCallTest extends FunctionCallTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getFunctionName()
	{
		return 'intval';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a cast to a int.';
	}
}