<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class FloatParamDocBlockTest extends PHPDOcBlockTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getAnnotationCriteria()
	{
		return array(
			'annotation' => 'param',
			'type' => 'float'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a PHPDoc "@param float" comment.';
	}
}