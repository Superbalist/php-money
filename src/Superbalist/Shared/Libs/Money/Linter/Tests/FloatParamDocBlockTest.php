<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class FloatParamDocBlockTest extends PHPDOcBlockTest {

	/**
	 * @return array
	 */
	protected function getAnnotationCriteria()
	{
		return array(
			'annotation' => 'param',
			'type' => 'float'
		);
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return 'The line contains a PHPDoc "@param float" comment.';
	}
}