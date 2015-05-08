<?php namespace Superbalist\Shared\Libs\Money\Linter;

use Superbalist\Shared\Libs\Money\Linter\Tests\AbsFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\ArraySumFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\CeilFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\DivideOperatorTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\FloatCastTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\FloatParamDocBlockTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\FloatReturnDocBlockTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\FloatvalFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\FloatVarDocBlockTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\FloorFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\GreaterThanOperatorTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\GreaterThanOrEqualsOperatorTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\IntCastTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\IntParamDocBlockTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\IntReturnDocBlockTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\IntvalFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\IntVarDocBlockTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\IsFloatFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\IsIntegerFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\IsIntFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\IsNumericFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\MaxFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\MinFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\MinusOperatorTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\ModOperatorTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\MoneyFormatCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\MultiplyOperatorTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\NumberFloatTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\NumberFormatCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\NumberIntTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\PlusOperatorTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\PowFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\RoundFunctionCallTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\SmallerThanOperatorTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\SmallerThanOrEqualsOperatorTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\SprintfFormatFloatTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\VariableDecrementTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\VariableDivideEqualsTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\VariableIncrementTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\VariableMinusEqualsTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\VariableModEqualsTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\VariablePlusEqualsTest;
use Superbalist\Shared\Libs\Money\Linter\Tests\VariableTimesEqualsTest;

class TestFactory {

	/**
	 * @return array
	 */
	public static function makeAll()
	{
		return array(
			new AbsFunctionCallTest(),
			new ArraySumFunctionCallTest(),
			new CeilFunctionCallTest(),
			new DivideOperatorTest(),
			new FloatCastTest(),
			new FloatParamDocBlockTest(),
			new FloatReturnDocBlockTest(),
			new FloatvalFunctionCallTest(),
			new FloatVarDocBlockTest(),
			new FloorFunctionCallTest(),
			new GreaterThanOperatorTest(),
			new GreaterThanOrEqualsOperatorTest(),
			new IntCastTest(),
			new IntParamDocBlockTest(),
			new IntReturnDocBlockTest(),
			new IntvalFunctionCallTest(),
			new IntVarDocBlockTest(),
			new IsFloatFunctionCallTest(),
			new IsIntegerFunctionCallTest(),
			new IsIntFunctionCallTest(),
			new IsNumericFunctionCallTest(),
			new MaxFunctionCallTest(),
			new MinusOperatorTest(),
			new MinFunctionCallTest(),
			new ModOperatorTest(),
			new MoneyFormatCallTest(),
			new MultiplyOperatorTest(),
			new NumberFloatTest(),
			new NumberIntTest(),
			new NumberFormatCallTest(),
			new PlusOperatorTest(),
			new PowFunctionCallTest(),
			new RoundFunctionCallTest(),
			new SmallerThanOperatorTest(),
			new SmallerThanOrEqualsOperatorTest(),
			new SprintfFormatFloatTest(),
			new VariableDecrementTest(),
			new VariableDivideEqualsTest(),
			new VariableIncrementTest(),
			new VariableMinusEqualsTest(),
			new VariableModEqualsTest(),
			new VariablePlusEqualsTest(),
			new VariableTimesEqualsTest(),
		);
	}

	/**
	 * @param string $name
	 * @return Tests\LinterTestInterface
	 * @throws \RuntimeException
	 */
	public static function make($name)
	{
		$tests = self::makeAll();
		foreach ($tests as $test) {
			/** @var \Superbalist\Shared\Libs\Money\Linter\Tests\LinterTestInterface $test */
			if (strcasecmp($test->getName(), $name) === 0) {
				return $test;
			}
		}
		throw new \RuntimeException(sprintf('The test %s does not exist.', $name));
	}

	/**
	 * @param array $names
	 * @return array
	 */
	public static function makeFrom(array $names)
	{
		$matched = array();
		$tests = self::makeAll();
		foreach ($names as $name) {
			foreach ($tests as $test) {
				/** @var \Superbalist\Shared\Libs\Money\Linter\Tests\LinterTestInterface $test */
				if (strcasecmp($test->getName(), $name) === 0) {
					$matched[] = $test;
					break 2;
				}
			}
		}
		return $matched;
	}
}
