<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

class IntReturnDocBlockTest extends PHPDOcBlockTest {

	/**
	 * @return array
	 */
	protected function getAnnotationCriteria()
	{
		return array(
			'annotation' => 'return',
			'type' => 'int'
		);
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return 'The line contains a PHPDoc "@return int" comment.';
	}
}
