<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class FloatvalFunctionCallTest extends FunctionCallTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getFunctionName()
	{
		return 'floatval';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a cast to a float, real or double.';
	}
}