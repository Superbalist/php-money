<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class FloatReturnDocBlockTest extends PHPDOcBlockTest {

	/**
	 * @return array
	 */
	protected function getAnnotationCriteria()
	{
		return array(
			'annotation' => 'return',
			'type' => 'float'
		);
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return 'The line contains a PHPDoc "@return float" comment.';
	}
}