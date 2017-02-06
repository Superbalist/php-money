<?php

namespace Superbalist\Money\Linter;

use Superbalist\Money\Linter\Tests\AbsFunctionCallTest;
use Superbalist\Money\Linter\Tests\ArraySumFunctionCallTest;
use Superbalist\Money\Linter\Tests\CeilFunctionCallTest;
use Superbalist\Money\Linter\Tests\DivideOperatorTest;
use Superbalist\Money\Linter\Tests\FloatCastTest;
use Superbalist\Money\Linter\Tests\FloatParamDocBlockTest;
use Superbalist\Money\Linter\Tests\FloatReturnDocBlockTest;
use Superbalist\Money\Linter\Tests\FloatvalFunctionCallTest;
use Superbalist\Money\Linter\Tests\FloatVarDocBlockTest;
use Superbalist\Money\Linter\Tests\FloorFunctionCallTest;
use Superbalist\Money\Linter\Tests\GreaterThanOperatorTest;
use Superbalist\Money\Linter\Tests\GreaterThanOrEqualsOperatorTest;
use Superbalist\Money\Linter\Tests\IntCastTest;
use Superbalist\Money\Linter\Tests\IntParamDocBlockTest;
use Superbalist\Money\Linter\Tests\IntReturnDocBlockTest;
use Superbalist\Money\Linter\Tests\IntvalFunctionCallTest;
use Superbalist\Money\Linter\Tests\IntVarDocBlockTest;
use Superbalist\Money\Linter\Tests\IsFloatFunctionCallTest;
use Superbalist\Money\Linter\Tests\IsIntegerFunctionCallTest;
use Superbalist\Money\Linter\Tests\IsIntFunctionCallTest;
use Superbalist\Money\Linter\Tests\IsNumericFunctionCallTest;
use Superbalist\Money\Linter\Tests\MaxFunctionCallTest;
use Superbalist\Money\Linter\Tests\MinFunctionCallTest;
use Superbalist\Money\Linter\Tests\MinusOperatorTest;
use Superbalist\Money\Linter\Tests\ModOperatorTest;
use Superbalist\Money\Linter\Tests\MoneyFormatCallTest;
use Superbalist\Money\Linter\Tests\MultiplyOperatorTest;
use Superbalist\Money\Linter\Tests\NumberFloatTest;
use Superbalist\Money\Linter\Tests\NumberFormatCallTest;
use Superbalist\Money\Linter\Tests\NumberIntTest;
use Superbalist\Money\Linter\Tests\PlusOperatorTest;
use Superbalist\Money\Linter\Tests\PowFunctionCallTest;
use Superbalist\Money\Linter\Tests\RoundFunctionCallTest;
use Superbalist\Money\Linter\Tests\SmallerThanOperatorTest;
use Superbalist\Money\Linter\Tests\SmallerThanOrEqualsOperatorTest;
use Superbalist\Money\Linter\Tests\SprintfFormatFloatTest;
use Superbalist\Money\Linter\Tests\VariableDecrementTest;
use Superbalist\Money\Linter\Tests\VariableDivideEqualsTest;
use Superbalist\Money\Linter\Tests\VariableIncrementTest;
use Superbalist\Money\Linter\Tests\VariableMinusEqualsTest;
use Superbalist\Money\Linter\Tests\VariableModEqualsTest;
use Superbalist\Money\Linter\Tests\VariablePlusEqualsTest;
use Superbalist\Money\Linter\Tests\VariableTimesEqualsTest;

class TestFactory
{
    /**
     * @return array
     */
    public static function makeAll()
    {
        return [
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
        ];
    }

    /**
     * @param string $name
     *
     * @throws \RuntimeException
     *
     * @return Tests\LinterTestInterface
     */
    public static function make($name)
    {
        $tests = self::makeAll();
        foreach ($tests as $test) {
            /** @var \Superbalist\Money\Linter\Tests\LinterTestInterface $test */
            if (strcasecmp($test->getName(), $name) === 0) {
                return $test;
            }
        }
        throw new \RuntimeException(sprintf('The test %s does not exist.', $name));
    }

    /**
     * @param array $names
     *
     * @return array
     */
    public static function makeFrom(array $names)
    {
        $matched = [];
        $tests = self::makeAll();
        foreach ($names as $name) {
            foreach ($tests as $test) {
                /** @var \Superbalist\Money\Linter\Tests\LinterTestInterface $test */
                if (strcasecmp($test->getName(), $name) === 0) {
                    $matched[] = $test;
                    break 2;
                }
            }
        }
        return $matched;
    }
}
