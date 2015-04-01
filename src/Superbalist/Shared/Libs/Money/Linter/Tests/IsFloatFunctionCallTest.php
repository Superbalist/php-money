<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class IsFloatFunctionCallTest extends FunctionCallTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getFunctionName()
	{
		return 'is_float';
	}
}