<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class FloatReturnDocBlockTest extends PHPDOcBlockTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getAnnotationCriteria()
	{
		return array(
			'annotation' => 'return',
			'type' => 'float'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a PHPDoc "@return float" comment.';
	}
}