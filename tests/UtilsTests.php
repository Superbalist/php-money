<?php

class UtilsTests extends PHPUnit_Framework_TestCase
{
    /**
     * @param mixed $value
     * @param string $expectedValue
     * @dataProvider convertToStringAmountProvider
     */
    public function testConvertToStringAmount($value, $expectedValue)
    {
        $value = \Superbalist\Money\Utils::toStringAmount($value);
        $this->assertSame($expectedValue, $value);
    }

    /**
     * @return array
     */
    public function convertToStringAmountProvider()
    {
        return [
            [0, '0'],
            ['3', '3'],
            ['3.0', '3'],
            [0.01, '0.01'],
            [-15.38294, '-15.38294'],
            [6, '6'],
            [new \Superbalist\Money\Money('3.54'), '3.54'],
            [new \Superbalist\Money\Money(3.54), '3.54'],
            [new \Superbalist\Money\Money(3.50), '3.5'],
            ['4.3286183', '4.3286183'],
            ['4.32', '4.32'],
            [0.0999999999999, '0.0999999999999'],
        ];
    }

    /**
     * @param string $value
     * @param bool $expectedValue
     * @dataProvider isZeroProvider
     */
    public function testIsZero($value, $expectedValue)
    {
        $this->assertSame(\Superbalist\Money\Utils::isZero($value), $expectedValue);
    }

    /**
     * @return array
     */
    public function isZeroProvider()
    {
        return [
            ['0', true],
            ['-0', true],
            ['-0.0', true],
            ['-0.0000', true],
            ['0.0', true],
            ['0.000', true],
            ['100', false],
            ['-100', false],
            ['-0.1', false],
            ['-0.001', false],
            ['0.001', false],
            ['0.000001', false],
        ];
    }

    /**
     * @param mixed $value
     * @param string $expectedValue
     * @dataProvider ceilProvider
     */
    public function testCeil($value, $expectedValue)
    {
        $value = \Superbalist\Money\Utils::ceil($value);
        $this->assertSame($expectedValue, $value);
    }

    /**
     * @return array
     */
    public function ceilProvider()
    {
        return [
            [4.3, '5'],
            [9.999, '10'],
            [-3.14, '-3'],
            [4, '4'],
            [3.00000, '3'],
            [1.5, '2'],
            [1.51, '2'],
            ['1.499', '2'],
            ['-31.01', '-31'],
            ['-9.87', '-9'],
            ['-0.01', '0'],
            ['-0.001', '0'],
            ['-1', '-1'],
            ['0', '0'],
            ['1', '1'],
            ['-0', '0'],
            ['-0', '0'],
        ];
    }

    /**
     * @param mixed $value
     * @param string $expectedValue
     * @dataProvider floorProvider
     */
    public function testFloor($value, $expectedValue)
    {
        $value = \Superbalist\Money\Utils::floor($value);
        $this->assertSame($expectedValue, $value);
    }

    /**
     * @return array
     */
    public function floorProvider()
    {
        return [
            [4.3, '4'],
            [9.999, '9'],
            [-3.14, '-4'],
            [4, '4'],
            [3.00000, '3'],
            [2.15, '2'],
            [4.455, '4'],
            ['-9.87', '-10'],
            ['-0.01', '-1'],
            ['-0.001', '-1'],
            ['-1', '-1'],
            ['0', '0'],
            ['1', '1'],
            ['-0', '0'],
        ];
    }

    /**
     * @param mixed $value
     * @param string $expectedValue
     * @dataProvider absProvider
     */
    public function testsAbs($value, $expectedValue)
    {
        $this->assertSame(\Superbalist\Money\Utils::abs($value), $expectedValue);
    }

    /**
     * @return array
     */
    public function absProvider()
    {
        return [
            [0, '0'],
            ['3', '3'],
            ['-3', '3'],
            ['-0', '0'],
            [-27.22, '27.22'],
            ['-3.2861942', '3.2861'],
        ];
    }

    /**
     *
     */
    public function testMin()
    {
        $actual = \Superbalist\Money\Utils::min(
            '10.00',
            9.99,
            new \Superbalist\Money\Money('3.26'),
            '-4.6594',
            '-4.6595',
            '0.11',
            '0'
        );
        $this->assertSame('-4.6595', $actual);
    }

    /**
     *
     */
    public function testMinArray()
    {
        $values = [
            '10.00',
            9.99,
            new \Superbalist\Money\Money('3.26'),
            '-4.6594',
            '-4.6595',
            '0.11',
            '0',
        ];
        $this->assertSame('-4.6595', \Superbalist\Money\Utils::min($values));
    }

    /**
     *
     */
    public function testMax()
    {
        $actual = \Superbalist\Money\Utils::max(
            '10.00',
            '10.01',
            9.99,
            new \Superbalist\Money\Money('3.26'),
            '-4.6594',
            '-4.6595',
            '0.11',
            '0'
        );
        $this->assertSame('10.01', $actual);
    }

    /**
     *
     */
    public function testMaxArray()
    {
        $values = [
            '10.00',
            '10.01',
            9.99,
            new \Superbalist\Money\Money('3.26'),
            '-4.6594',
            '-4.6595',
            '0.11',
            '0',
        ];
        $this->assertSame('10.01', \Superbalist\Money\Utils::max($values));
    }

    /**
     *
     */
    public function testCalculateVat()
    {
        $actual = \Superbalist\Money\Utils::calculateVat('1264.46');
        $this->assertSame('155.28', $actual);
    }

    /**
     *
     */
    public function testCalculateNetVatAmount()
    {
        $actual = \Superbalist\Money\Utils::calculateNetVatAmount('1264.46');
        $this->assertSame('1109.18', $actual);
    }
}
