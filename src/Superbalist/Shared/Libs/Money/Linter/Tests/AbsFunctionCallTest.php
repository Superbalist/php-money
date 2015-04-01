<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class AbsFunctionCallTest extends FunctionCallTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getFunctionName()
	{
		return 'abs';
	}
}