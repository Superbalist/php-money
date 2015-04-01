<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class IntParamDocBlockTest extends PHPDOcBlockTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getAnnotationCriteria()
	{
		return array(
			'annotation' => 'param',
			'type' => 'int'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a PHPDoc "@param int" comment.';
	}
}