<?php namespace Superbalist\Shared\Libs\Money\Linter;

class DummySuppressionIndex implements SuppressionIndexInterface {

	/**
	 * {@inheritdoc}
	 */
	public function isSuppressed($filename, $number, $line)
	{
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function add($filename, $number, $line)
	{

	}

	/**
	 * {@inheritdoc}
	 */
	public function wipe()
	{

	}
}