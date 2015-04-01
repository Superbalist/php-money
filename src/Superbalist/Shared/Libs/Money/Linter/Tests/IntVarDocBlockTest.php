<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class IntVarDocBlockTest extends PHPDOcBlockTest {

	/**
	 * {@inheritdoc}
	 */
	protected function getAnnotationCriteria()
	{
		return array(
			'annotation' => 'var',
			'type' => 'int'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDescription()
	{
		return 'The line contains a PHPDoc "@var int" comment.';
	}
}