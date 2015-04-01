<?php namespace Superbalist\Shared\Libs\Money\Linter;

use Superbalist\Shared\Libs\Money\Linter\Tests\LinterTestInterface;

class LintWarning {

	/**
	 * @var int
	 */
	protected $number;

	/**
	 * @var string
	 */
	protected $line;

	/**
	 * @var Tests\LinterTestInterface
	 */
	protected $test;

	/**
	 * @param SourceResult $sourceResult
	 * @param int $number
	 * @param string $line
	 * @param LinterTestInterface $test
	 */
	public function __construct($number, $line, LinterTestInterface $test)
	{
		$this->number = $number;
		$this->line = $line;
		$this->test = $test;
	}

	/**
	 * @return int
	 */
	public function getNumber()
	{
		return $this->number;
	}

	/**
	 * @return string
	 */
	public function getLine()
	{
		return $this->line;
	}

	/**
	 * @return LinterTestInterface
	 */
	public function getTest()
	{
		return $this->test;
	}
}