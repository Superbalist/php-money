<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class FloatVarDocBlockTest extends PHPDOcBlockTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getAnnotationCriteria()
	{
		return array(
			'annotation' => 'var',
			'type' => 'float'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a PHPDoc "@var float" comment.';
	}
}