<?php

class LinterTests extends PHPUnit_Framework_TestCase
{
    /**
     * @param string $source
     * @param \Superbalist\Money\Linter\Tests\LinterTestInterface $test
     */
    protected function assertLinterThrowsWarnings($source, \Superbalist\Money\Linter\Tests\LinterTestInterface $test)
    {
        $result = $test->analyse($source);
        $this->assertNotEmpty($result);
    }

    /**
     *
     */
    public function testMatchesAbsFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo abs(-37);',
            new \Superbalist\Money\Linter\Tests\AbsFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesArraySumFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $values = array(0, 1, 2, 3); $sum = array_sum($values);',
            new \Superbalist\Money\Linter\Tests\ArraySumFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesCeilFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo ceil(3.3);',
            new \Superbalist\Money\Linter\Tests\CeilFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesDivideOperatorTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $test = 1 / 0.1;',
            new \Superbalist\Money\Linter\Tests\DivideOperatorTest()
        );
    }

    /**
     *
     */
    public function testMatchesFloatCastTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $test = "3.3"; echo (float) $test;',
            new \Superbalist\Money\Linter\Tests\FloatCastTest()
        );
    }

    /**
     *
     */
    public function testMatchesFloatParamDocBlockTest()
    {
        $source = <<<'EOT'
<?php

/**
 * @param float $number this is a test
 * @return float test
 */
public function getFloatNumber($number)
{
	return $number;
}
EOT;
        $this->assertLinterThrowsWarnings($source, new \Superbalist\Money\Linter\Tests\FloatParamDocBlockTest());
    }

    /**
     *
     */
    public function testMatchesFloatReturnDocBlockTest()
    {
        $source = <<<'EOT'
<?php

/**
 * @param float $number this is a test
 * @return float test
 */
public function getFloatNumber($number)
{
	return $number;
}
EOT;
        $this->assertLinterThrowsWarnings($source, new \Superbalist\Money\Linter\Tests\FloatReturnDocBlockTest());
    }

    /**
     *
     */
    public function testMatchesFloatvalFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo floatval("3.3");',
            new \Superbalist\Money\Linter\Tests\FloatvalFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesFloatVarDocBlockTest()
    {
        $source = <<<'EOT'
<?php

/**
 * @var float
 */
protected $number = 0.0;
EOT;
        $this->assertLinterThrowsWarnings($source, new \Superbalist\Money\Linter\Tests\FloatVarDocBlockTest());
    }

    /**
     *
     */
    public function testMatchesFloorFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo floor(3.3);',
            new \Superbalist\Money\Linter\Tests\FloorFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesGreaterThanOperatorTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php if (4 > 3) { echo "true"; } else { echo "false"; }',
            new \Superbalist\Money\Linter\Tests\GreaterThanOperatorTest()
        );
    }

    /**
     *
     */
    public function testMatchesGreaterThanOrEqualsOperatorTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php if (4 >= 3) { echo "true"; } else { echo "false"; }',
            new \Superbalist\Money\Linter\Tests\GreaterThanOrEqualsOperatorTest()
        );
    }

    /**
     *
     */
    public function testMatchesIntCastTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $test = "3.3"; echo (int) $test;',
            new \Superbalist\Money\Linter\Tests\IntCastTest()
        );
    }

    /**
     *
     */
    public function testMatchesIntParamDocBlockTest()
    {
        $source = <<<'EOT'
<?php

/**
 * @param int $number this is a test
 * @return int test
 */
public function getIntNumber($number)
{
	return $number;
}
EOT;
        $this->assertLinterThrowsWarnings($source, new \Superbalist\Money\Linter\Tests\IntParamDocBlockTest());
    }

    /**
     *
     */
    public function testMatchesIntReturnDocBlockTest()
    {
        $source = <<<'EOT'
<?php

/**
 * @param int $number this is a test
 * @return int test
 */
public function getIntNumber($number)
{
	return $number;
}
EOT;
        $this->assertLinterThrowsWarnings($source, new \Superbalist\Money\Linter\Tests\IntReturnDocBlockTest());
    }

    /**
     *
     */
    public function testMatchesIntvalFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo intval("3.3");',
            new \Superbalist\Money\Linter\Tests\IntvalFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesIntVarDocBlockTest()
    {
        $source = <<<'EOT'
<?php

/**
 * @var int
 */
protected $number = 0;
EOT;
        $this->assertLinterThrowsWarnings($source, new \Superbalist\Money\Linter\Tests\IntVarDocBlockTest());
    }

    /**
     *
     */
    public function testMatchesIsFloatFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $a = 3.3; var_dump(is_float($a));',
            new \Superbalist\Money\Linter\Tests\IsFloatFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesIsIntegerFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $a = 3; var_dump(is_integer($a));',
            new \Superbalist\Money\Linter\Tests\IsIntegerFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesIsIntFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $a = 3; var_dump(is_int($a));',
            new \Superbalist\Money\Linter\Tests\IsIntFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesIsNumericFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $a = 3; var_dump(is_numeric($a));',
            new \Superbalist\Money\Linter\Tests\IsNumericFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesMaxFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo max(0, 3.3);',
            new \Superbalist\Money\Linter\Tests\MaxFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesMinFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo min(0, 3.3);',
            new \Superbalist\Money\Linter\Tests\MinFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesMinusOperatorTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $test = 1 - 0.1;',
            new \Superbalist\Money\Linter\Tests\MinusOperatorTest()
        );
    }

    /**
     *
     */
    public function testMatchesModOperatorTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $test = 4 % 2;',
            new \Superbalist\Money\Linter\Tests\ModOperatorTest()
        );
    }

    /**
     *
     */
    public function testMatchesMoneyFormatCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo money_format("%.2n", 2.4562)',
            new \Superbalist\Money\Linter\Tests\MoneyFormatCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesMultiplyOperatorTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $test = 1 * 0.1;',
            new \Superbalist\Money\Linter\Tests\MultiplyOperatorTest()
        );
    }

    /**
     *
     */
    public function testMatchesNumberFloatTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $test = 0.2 + 0.1;',
            new \Superbalist\Money\Linter\Tests\NumberFloatTest()
        );
    }

    /**
     *
     */
    public function testMatchesNumberFormatCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo number_format(1.3, 2)',
            new \Superbalist\Money\Linter\Tests\NumberFormatCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesNumberIntTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $test = 1 + 0.1;',
            new \Superbalist\Money\Linter\Tests\NumberIntTest()
        );
    }

    /**
     *
     */
    public function testMatchesPlusOperatorTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $test = 1 + 0.1;',
            new \Superbalist\Money\Linter\Tests\PlusOperatorTest()
        );
    }

    /**
     *
     */
    public function testMatchesPowFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo pow(2, 8);',
            new \Superbalist\Money\Linter\Tests\PowFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesRoundFunctionCallTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo round(9.93434, 2);',
            new \Superbalist\Money\Linter\Tests\RoundFunctionCallTest()
        );
    }

    /**
     *
     */
    public function testMatchesSmallerThanOperatorTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php if (4 < 3) { echo "true"; } else { echo "false"; }',
            new \Superbalist\Money\Linter\Tests\SmallerThanOperatorTest()
        );
    }

    /**
     *
     */
    public function testMatchesSmallerThanOrEqualsOperatorTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php if (4 <= 3) { echo "true"; } else { echo "false"; }',
            new \Superbalist\Money\Linter\Tests\SmallerThanOrEqualsOperatorTest()
        );
    }

    /**
     *
     */
    public function testMatchesSprintfFormatFloatTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php echo sprintf("%f", 4.55555);',
            new \Superbalist\Money\Linter\Tests\SprintfFormatFloatTest()
        );
        $this->assertLinterThrowsWarnings(
            '<?php echo sprintf("%.2f %s", 4.55555, "test");',
            new \Superbalist\Money\Linter\Tests\SprintfFormatFloatTest()
        );
        $this->assertLinterThrowsWarnings(
            '<?php echo sprintf("%.2f %s", 4.55555, sprintf("%s", "test")); $test = intval(1.1);',
            new \Superbalist\Money\Linter\Tests\SprintfFormatFloatTest()
        );
    }

    /**
     *
     */
    public function testMatchesVariableDecrementTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $n = 3; $n--;',
            new \Superbalist\Money\Linter\Tests\VariableDecrementTest()
        );
    }

    /**
     *
     */
    public function testMatchesVariableDivideEqualsTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $n = 21; $n /= 3;',
            new \Superbalist\Money\Linter\Tests\VariableDivideEqualsTest()
        );
    }

    /**
     *
     */
    public function testMatchesVariableIncrementTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $n = 3; $n++;',
            new \Superbalist\Money\Linter\Tests\VariableIncrementTest()
        );
    }

    /**
     *
     */
    public function testMatchesVariableMinusEqualsTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $n = 21; $n -= 2;',
            new \Superbalist\Money\Linter\Tests\VariableMinusEqualsTest()
        );
    }

    /**
     *
     */
    public function testMatchesVariableModEqualsTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $n = 24; $n %= 2;',
            new \Superbalist\Money\Linter\Tests\VariableModEqualsTest()
        );
    }

    /**
     *
     */
    public function testMatchesVariablePlusEqualsTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $n = 21; $n += 2;',
            new \Superbalist\Money\Linter\Tests\VariablePlusEqualsTest()
        );
    }

    /**
     *
     */
    public function testMatchesVariableTimesEqualsTest()
    {
        $this->assertLinterThrowsWarnings(
            '<?php $n = 21; $n *= 2;',
            new \Superbalist\Money\Linter\Tests\VariableTimesEqualsTest()
        );
    }
}
