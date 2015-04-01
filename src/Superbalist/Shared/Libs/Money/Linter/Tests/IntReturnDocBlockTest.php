<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class IntReturnDocBlockTest extends PHPDOcBlockTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getAnnotationCriteria()
	{
		return array(
			'annotation' => 'return',
			'type' => 'int'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a PHPDoc "@return int" comment.';
	}
}