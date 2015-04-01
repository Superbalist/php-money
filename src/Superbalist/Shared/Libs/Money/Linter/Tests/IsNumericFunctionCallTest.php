<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class IsNumericFunctionCallTest extends FunctionCallTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getFunctionName()
	{
		return 'is_numeric';
	}
}