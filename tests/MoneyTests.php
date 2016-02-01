<?php

class MoneyTests extends PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetAmount()
    {
        $a = new \Superbalist\Money\Money('100.34');
        $this->assertSame('100.34', $a->getAmount());
    }

    /**
     *
     */
    public function testGetSetCurrencyConversionService()
    {
        $service = new \Superbalist\Money\MockCurrencyConversionService();
        $money = new \Superbalist\Money\Money('100');
        $money->setCurrencyConversionService($service);
        $actual = $money->getCurrencyConversionService();
        $this->assertSame($actual, $service);
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param string $expectedValue
     * @dataProvider addProvider
     */
    public function testAdd($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->add($b);
        $this->assertTrue($actual->equals($expectedValue));
    }

    /**
     * @return array
     */
    public function addProvider()
    {
        return array(
            array('10', '3', '13'),
            array('10.35', '2', '12.35'),
            array(5.35, '35.50', '40.85'),
            array(6.9214, 23.3345, '30.2559'),
            array(3, 1, '4'),
            array(3, 6.33, '9.33'),
            array(56, '3', '59'),
            array(0.1, 0.2, '0.3'),
            array(0.15, 0.3333, '0.4833'),
            array(0.153, '0.3331', '0.4861'),
            array('0.1', '0.2', '0.3'),
            array('0.1', '-0.2', '-0.1'),
            array(0.1334, -3.2165, '-3.0831'),
            array(new \Superbalist\Money\Money('3.5'), new \Superbalist\Money\Money('2.1'), '5.6'),
            array(new \Superbalist\Money\Money('1.1'), 3, '4.1'),
        );
    }

    /**
     *
     */
    public function testAddDifferentCurrencies()
    {
        $service = new \Superbalist\Money\MockCurrencyConversionService();

        $zar = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $money1 = new \Superbalist\Money\Money('1', $zar);
        $money1->setCurrencyConversionService($service);

        $usd = \Superbalist\Money\CurrencyFactory::make('USD');
        $money2 = new \Superbalist\Money\Money('1', $usd); // 1 USD = 12.07682 ZAR
        $money2->setCurrencyConversionService($service);

        $actual = $money1->add($money2);
        $expected = '13.07682'; // 1 ZAR + 12.07682 ZAR

        $this->assertTrue($actual->equals($expected));
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param string $expectedValue
     * @dataProvider subtractProvider
     */
    public function testSubtract($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->subtract($b);
        $this->assertTrue($actual->equals($expectedValue));
    }

    /**
     * @return array
     */
    public function subtractProvider()
    {
        return array(
            array('10', '3', '7'),
            array('10.35', '2', '8.35'),
            array(35.50, '5.35', '30.15'),
            array(23.3345, 6.9214, '16.4131'),
            array(3, 1, '2'),
            array(3, 6.33, '-3.33'),
            array(56, '3', '53'),
            array(0.2, 0.1, '0.1'),
            array(0.15, 0.3333, '-0.1833'),
            array(0.3331, '0.153', '0.1801'),
            array('0.2', '0.1', '0.1'),
            array('0.1', '-0.2', '0.3'),
            array(0.1334, -3.2165, '3.3499'),
        );
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param string $expectedValue
     * @dataProvider multiplyProvider
     */
    public function testMultiply($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->multiply($b);
        $this->assertTrue($actual->equals($expectedValue));
    }

    /**
     * @return array
     */
    public function multiplyProvider()
    {
        return array(
            array(1, 3, '3'),
            array(0, 9, '0'),
            array(3.3, 4, '13.2'),
            array('4.612', 2.46, '11.34552'),
            array('0.156', '0.825482', '0.128775192'),
            array('0.156', '0.825482', '0.128775192'),
            array(-6.13, '0.2', '-1.226'),
            array('-8.4', '-3.652', '30.6768'),
            array(new \Superbalist\Money\Money('-8.4'), new \Superbalist\Money\Money('-3.652'), '30.6768'),
        );
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param string $expectedValue
     * @dataProvider divideProvider
     */
    public function testDivide($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->divide($b);
        $this->assertTrue($actual->equals($expectedValue));
    }

    /**
     * @return array
     */
    public function divideProvider()
    {
        return array(
            array(0, 1, '0'),
            array(3.5, 1.2, '2.91666666667'),
            array('6.81523', '-5.184', '-1.31466628086'),
            array(1, 3, '0.33333333333'),
            array('-5.872', '-0.2251', '26.0861839183'),
            array(new \Superbalist\Money\Money('-5.872'), new \Superbalist\Money\Money('-0.2251'), '26.0861839183'),
        );
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param string $expectedValue
     * @dataProvider modProvider
     */
    public function testMod($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->mod($b);
        $this->assertSame($actual, $expectedValue);
    }

    /**
     * @return array
     */
    public function modProvider()
    {
        return array(
            array('6', '2', '0'),
            array('6', '3', '0'),
            array('6', '4', '2'),
            array('6', '5', '1'),
        );
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param bool $expectedValue
     * @dataProvider isEqualsProvider
     */
    public function testIsEquals($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->equals($b);
        $this->assertSame($actual, $expectedValue);
    }

    /**
     * @return array
     */
    public function isEqualsProvider()
    {
        return array(
            array('1', '1', true),
            array('0.333333333', '0.3333', true),
            array('0.333333333', '0.33', false),
            array('0.369', 0.369, true),
            array(2.155555, 2.155555, true),
            array(2.155555, '2.155555', true),
            array(0, 0, true),
            array(0, 0.0, true),
            array(0, 0.00, true),
            array(0, '0.00', true),
            array(-0, 0, true),
            array('-0', '0', true),
            array('-0.18265', '-0.1826', true),
            array('-0.18265', '-0.1827', false),
        );
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param int $expectedValue
     * @dataProvider compareProvider
     */
    public function testCompare($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->compare($b);
        $this->assertSame($actual, $expectedValue);
    }

    /**
     * @return array
     */
    public function compareProvider()
    {
        return array(
            array(1, 1, 0),
            array(3, 1, 1),
            array(0.3, 0.1, 1),
            array(0.1, 0.3, -1),
            array(0, -0, 0),
            array('3.1567', '3.1567', 0),
            array('3.1567', '3.1566', 1),
            array('3.1567', '3.1568', -1),
            array('3.15677', '3.15676', 0),
        );
    }

    /**
     *
     */
    public function testCompareDifferentCurrencies()
    {
        $this->setExpectedException('\Superbalist\Money\CurrencyMismatchException');
        $a = new \Superbalist\Money\Money('10.50', \Superbalist\Money\CurrencyFactory::make('ZAR'));
        $b = new \Superbalist\Money\Money('10.50', \Superbalist\Money\CurrencyFactory::make('USD'));
        $a->compare($b);
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param bool $expectedValue
     * @dataProvider isGreaterThanProvider
     */
    public function testIsGreaterThan($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->isGreaterThan($b);
        $this->assertSame($actual, $expectedValue);
    }

    /**
     * @return array
     */
    public function isGreaterThanProvider()
    {
        return array(
            array(0, 1, false),
            array('1.56788', '1.56787', false),
            array('1.5678', '1.5677', true),
            array('1.5678', '1.5678', false),
            array('-1.5678', '0', false),
        );
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param bool $expectedValue
     * @dataProvider isLessThanProvider
     */
    public function testIsLessThan($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->isLessThan($b);
        $this->assertSame($actual, $expectedValue);
    }

    /**
     * @return array
     */
    public function isLessThanProvider()
    {
        return array(
            array(0, 1, true),
            array('1.56788', '1.56787', false),
            array('1.5678', '1.5677', false),
            array('1.5678', '1.5678', false),
            array('-1.5678', '0', true),
        );
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param bool $expectedValue
     * @dataProvider isGreaterThanOrEqualToProvider
     */
    public function testIsGreaterThanOrEqualTo($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->isGreaterThanOrEqualTo($b);
        $this->assertSame($actual, $expectedValue);
    }

    /**
     * @return array
     */
    public function isGreaterThanOrEqualToProvider()
    {
        return array(
            array(0, 1, false),
            array('1.56788', '1.56787', true),
            array('1.5678', '1.5677', true),
            array('1.5678', '1.5678', true),
            array('-1.5678', '0', false),
        );
    }

    /**
     * @param mixed $value1
     * @param mixed $value2
     * @param bool $expectedValue
     * @dataProvider isLessThanOrEqualToProvider
     */
    public function testIsLessThanOrEqualTo($value1, $value2, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value1);
        $b = new \Superbalist\Money\Money($value2);
        $actual = $a->isLessThanOrEqualTo($b);
        $this->assertSame($actual, $expectedValue);
    }

    /**
     * @return array
     */
    public function isLessThanOrEqualToProvider()
    {
        return array(
            array(0, 1, true),
            array('1.56788', '1.56787', true),
            array('1.5678', '1.5677', false),
            array('1.5678', '1.5678', true),
            array('-1.5678', '0', true),
        );
    }

    /**
     *
     */
    public function testIsSameCurrencyAs()
    {
        $currency1 = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $money1 = new \Superbalist\Money\Money('10.50', $currency1);
        $currency2 = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $money2 = new \Superbalist\Money\Money('13.50', $currency2);
        $this->assertTrue($money1->isSameCurrencyAs($money2));

        $currency3 = \Superbalist\Money\CurrencyFactory::make('USD');
        $money3 = new \Superbalist\Money\Money('2.75', $currency3);
        $this->assertFalse($money1->isSameCurrencyAs($money3));
    }

    /**
     * @param mixed $value
     * @param bool $expectedValue
     * @dataProvider isPositiveProvider
     */
    public function testIsPositive($value, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value);
        $actual = $a->isPositive();
        $this->assertSame($actual, $expectedValue);
    }

    /**
     * @return array
     */
    public function isPositiveProvider()
    {
        return array(
            array('1', true),
            array('0', true),
            array('0.015', true),
            array('-3', false),
            array('-0.002', false),
        );
    }

    /**
     * @param mixed $value
     * @param bool $expectedValue
     * @dataProvider isNegativeProvider
     */
    public function testIsNegative($value, $expectedValue)
    {
        $a = new \Superbalist\Money\Money($value);
        $actual = $a->isNegative();
        $this->assertSame($actual, $expectedValue);
    }

    /**
     * @return array
     */
    public function isNegativeProvider()
    {
        return array(
            array('1', false),
            array('0', false),
            array('0.015', false),
            array('-3', true),
            array('-0.002', true),
        );
    }

    /**
     * @param string $value
     * @param bool $expectedValue
     * @dataProvider isZeroProvider
     */
    public function testIsZero($value, $expectedValue)
    {
        $money = new \Superbalist\Money\Money($value);
        $this->assertSame($money->isZero(), $expectedValue);
    }

    /**
     * @return array
     */
    public function isZeroProvider()
    {
        return array(
            array('0', true),
            array('-0', true),
            array('-0.0', true),
            array('-0.0000', true),
            array('0.0', true),
            array('0.000', true),
            array('100', false),
            array('-100', false),
            array('-0.1', false),
            array('-0.001', false),
            array('0.001', false),
            array('0.0001', false),
            array('0.00001', true),
            array('0.000001', true),
        );
    }

    /**
     * @param string $value
     * @param bool $expectedValue
     * @dataProvider isEvenProvider
     */
    public function testIsEven($value, $expectedValue)
    {
        $money = new \Superbalist\Money\Money($value);
        $this->assertSame($money->isEven(), $expectedValue);
    }

    /**
     * @return array
     */
    public function isEvenProvider()
    {
        return array(
            array('-1', false),
            array('0', true),
            array('1', false),
            array('2', true),
            array('3', false),
            array('4', true),
            array('5', false),
        );
    }

    /**
     * @param string $value
     * @param bool $expectedValue
     * @dataProvider isOddProvider
     */
    public function testIsOdd($value, $expectedValue)
    {
        $money = new \Superbalist\Money\Money($value);
        $this->assertSame($money->isOdd(), $expectedValue);
    }

    /**
     * @return array
     */
    public function isOddProvider()
    {
        return array(
            array('-1', true),
            array('0', false),
            array('1', true),
            array('2', false),
            array('3', true),
            array('4', false),
            array('5', true),
        );
    }

    /**
     *
     */
    public function testToCurrency()
    {
        $from = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $money = new \Superbalist\Money\Money('1', $from);
        $money->setCurrencyConversionService(new \Superbalist\Money\MockCurrencyConversionService());
        $to = \Superbalist\Money\CurrencyFactory::make('USD');
        $new = $money->toCurrency($to);
        $this->assertTrue($new->equals('0.082776'));
        $this->assertSame('USD', $new->getCurrency()->getCode());
    }

    /**
     *
     */
    public function testFormat()
    {
        $money = new \Superbalist\Money\Money('150.36');
        $actual = $money->format(2);
        $this->assertSame('150.36', $actual);

        $money = new \Superbalist\Money\Money('150.3');
        $actual = $money->format(2);
        $this->assertSame('150.30', $actual);

        $money = new \Superbalist\Money\Money('150');
        $actual = $money->format(2);
        $this->assertSame('150.00', $actual);

        $money = new \Superbalist\Money\Money('150.59');
        $actual = $money->format(0);
        $this->assertSame('150', $actual);

        $money = new \Superbalist\Money\Money('10365.2');
        $actual = $money->format(2, '.', ',');
        $this->assertSame('10,365.20', $actual);

        $money = new \Superbalist\Money\Money('10365.2');
        $actual = $money->format(2, ',', '');
        $this->assertSame('10365,20', $actual);

        $money = new \Superbalist\Money\Money('10365.2598');
        $actual = $money->format(2);
        $this->assertSame('10365.25', $actual);
    }

    /**
     *
     */
    public function testDisplay()
    {
        $currency = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $money = new \Superbalist\Money\Money('150.36', $currency);
        $actual = $money->display();
        $this->assertSame('R150.36', $actual);

        $currency = \Superbalist\Money\CurrencyFactory::make('USD');
        $money = new \Superbalist\Money\Money('150.36', $currency);
        $actual = $money->display(0);
        $this->assertSame('$150', $actual);

        $currency = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $money = new \Superbalist\Money\Money('-53.87', $currency);
        $actual = $money->display();
        $this->assertSame('-R53.87', $actual);
    }

    /**
     *
     */
    public function testCeil()
    {
        $money = new \Superbalist\Money\Money('10.35');
        $money = $money->ceil();
        $this->assertTrue($money->equals('11'));

        $money = new \Superbalist\Money\Money('-11.66');
        $money = $money->ceil();
        $this->assertTrue($money->equals('-11'));

        $money = new \Superbalist\Money\Money('4.00');
        $money = $money->ceil();
        $this->assertTrue($money->equals('4'));
    }

    /**
     *
     */
    public function testFloor()
    {
        $money = new \Superbalist\Money\Money('10.35');
        $money = $money->floor();
        $this->assertTrue($money->equals('10'));

        $money = new \Superbalist\Money\Money('-11.66');
        $money = $money->floor();
        $this->assertTrue($money->equals('-12'));
    }

    /**
     *
     */
    public function testAbs()
    {
        $money = new \Superbalist\Money\Money('-10.35');
        $money = $money->abs();
        $this->assertTrue($money->equals('10.35'));

        $money = new \Superbalist\Money\Money('11.66');
        $money = $money->abs();
        $this->assertTrue($money->equals('11.66'));
    }

    /**
     *
     */
    public function testToString()
    {
        $money = new \Superbalist\Money\Money('10.35');
        $str = (string)$money;
        $this->assertSame('10.35', $str);
    }

    /**
     * @dataProvider testRoundProvider
     */
    public function testRound($value, $precision, $mode, $expectedValue)
    {
        $actual = (new \Superbalist\Money\Money($value))->round($precision, $mode);
        $this->assertTrue($actual->equals($expectedValue));
    }

    /**
     * @return array
     */
    public function testRoundProvider()
    {
        return array(

            // PHP_ROUND_HALF_UP

            // 0 precision
            array('0', 0, PHP_ROUND_HALF_UP, '0'),
            array('0.0', 0, PHP_ROUND_HALF_UP, '0'),
            array('1', 0, PHP_ROUND_HALF_UP, '1'),
            array('1.5', 0, PHP_ROUND_HALF_UP, '2'),
            array('1.6', 0, PHP_ROUND_HALF_UP, '2'),
            array('1.49', 0, PHP_ROUND_HALF_UP, '1'),
            array('1.995', 0, PHP_ROUND_HALF_UP, '2'),
            array('0.6', 0, PHP_ROUND_HALF_UP, '1'),
            // 2 precision
            array('1.58', 2, PHP_ROUND_HALF_UP, '1.58'),
            array('1.589', 2, PHP_ROUND_HALF_UP, '1.59'),
            array('1.599', 2, PHP_ROUND_HALF_UP, '1.6'),
            array('1.3', 2, PHP_ROUND_HALF_UP, '1.3'),
            array('1.495', 2, PHP_ROUND_HALF_UP, '1.5'),
            array('1.4949', 2, PHP_ROUND_HALF_UP, '1.49'),
            array('1.4958', 2, PHP_ROUND_HALF_UP, '1.5'),
            // negative - 0 precision
            array('-0', 0, PHP_ROUND_HALF_UP, '0'),
            array('-0.0', 0, PHP_ROUND_HALF_UP, '0'),
            array('-1', 0, PHP_ROUND_HALF_UP, '-1'),
            array('-1.5', 0, PHP_ROUND_HALF_UP, '-2'),
            array('-1.6', 0, PHP_ROUND_HALF_UP, '-2'),
            array('-1.49', 0, PHP_ROUND_HALF_UP, '-1'),
            array('-1.995', 0, PHP_ROUND_HALF_UP, '-2'),
            array('-0.6', 0, PHP_ROUND_HALF_UP, '-1'),
            // negative - 2 precision
            array('-1.58', 2, PHP_ROUND_HALF_UP, '-1.58'),
            array('-1.589', 2, PHP_ROUND_HALF_UP, '-1.59'),
            array('-1.599', 2, PHP_ROUND_HALF_UP, '-1.6'),
            array('-1.3', 2, PHP_ROUND_HALF_UP, '-1.3'),
            array('-1.495', 2, PHP_ROUND_HALF_UP, '-1.5'),
            array('-1.4949', 2, PHP_ROUND_HALF_UP, '-1.49'),
            array('-1.4958', 2, PHP_ROUND_HALF_UP, '-1.5'),
            // PHP_ROUND_HALF_DOWN

            // 0 precision
            array('0', 0, PHP_ROUND_HALF_DOWN, '0'),
            array('0.0', 0, PHP_ROUND_HALF_DOWN, '0'),
            array('1', 0, PHP_ROUND_HALF_DOWN, '1'),
            array('1.5', 0, PHP_ROUND_HALF_DOWN, '1'),
            array('1.6', 0, PHP_ROUND_HALF_DOWN, '2'),
            array('1.49', 0, PHP_ROUND_HALF_DOWN, '1'),
            array('1.995', 0, PHP_ROUND_HALF_DOWN, '2'),
            array('0.6', 0, PHP_ROUND_HALF_DOWN, '1'),
            // 2 precision
            array('1.58', 2, PHP_ROUND_HALF_DOWN, '1.58'),
            array('1.589', 2, PHP_ROUND_HALF_DOWN, '1.59'),
            array('1.599', 2, PHP_ROUND_HALF_DOWN, '1.6'),
            array('1.3', 2, PHP_ROUND_HALF_DOWN, '1.3'),
            array('1.495', 2, PHP_ROUND_HALF_DOWN, '1.49'),
            array('1.4949', 2, PHP_ROUND_HALF_DOWN, '1.49'),
            array('1.4958', 2, PHP_ROUND_HALF_DOWN, '1.5'),
            // negative - 0 precision
            array('-0', 0, PHP_ROUND_HALF_DOWN, '0'),
            array('-0.0', 0, PHP_ROUND_HALF_DOWN, '0'),
            array('-1', 0, PHP_ROUND_HALF_DOWN, '-1'),
            array('-1.5', 0, PHP_ROUND_HALF_DOWN, '-1'),
            array('-1.6', 0, PHP_ROUND_HALF_DOWN, '-2'),
            array('-1.49', 0, PHP_ROUND_HALF_DOWN, '-1'),
            array('-1.995', 0, PHP_ROUND_HALF_DOWN, '-2'),
            array('-0.6', 0, PHP_ROUND_HALF_DOWN, '-1'),
            // negative - 2 precision
            array('-1.58', 2, PHP_ROUND_HALF_DOWN, '-1.58'),
            array('-1.589', 2, PHP_ROUND_HALF_DOWN, '-1.59'),
            array('-1.599', 2, PHP_ROUND_HALF_DOWN, '-1.6'),
            array('-1.3', 2, PHP_ROUND_HALF_DOWN, '-1.3'),
            array('-1.495', 2, PHP_ROUND_HALF_DOWN, '-1.49'),
            array('-1.4949', 2, PHP_ROUND_HALF_DOWN, '-1.49'),
            array('-1.4958', 2, PHP_ROUND_HALF_DOWN, '-1.5'),
            // PHP_ROUND_HALF_EVEN

            // 0 precision
            array('0', 0, PHP_ROUND_HALF_EVEN, '0'),
            array('0.0', 0, PHP_ROUND_HALF_EVEN, '0'),
            array('1', 0, PHP_ROUND_HALF_EVEN, '1'),
            array('1.5', 0, PHP_ROUND_HALF_EVEN, '2'),
            array('1.6', 0, PHP_ROUND_HALF_EVEN, '2'),
            array('1.49', 0, PHP_ROUND_HALF_EVEN, '1'),
            array('1.995', 0, PHP_ROUND_HALF_EVEN, '2'),
            array('0.6', 0, PHP_ROUND_HALF_EVEN, '1'),
            // 2 precision
            array('1.58', 2, PHP_ROUND_HALF_EVEN, '1.58'),
            array('1.589', 2, PHP_ROUND_HALF_EVEN, '1.59'),
            array('1.599', 2, PHP_ROUND_HALF_EVEN, '1.6'),
            array('1.3', 2, PHP_ROUND_HALF_EVEN, '1.3'),
            array('1.495', 2, PHP_ROUND_HALF_EVEN, '1.5'),
            array('1.4949', 2, PHP_ROUND_HALF_EVEN, '1.49'),
            array('1.4958', 2, PHP_ROUND_HALF_EVEN, '1.5'),
            // negative - 0 precision
            array('-0', 0, PHP_ROUND_HALF_EVEN, '0'),
            array('-0.0', 0, PHP_ROUND_HALF_EVEN, '0'),
            array('-1', 0, PHP_ROUND_HALF_EVEN, '-1'),
            array('-1.5', 0, PHP_ROUND_HALF_EVEN, '-2'),
            array('-1.6', 0, PHP_ROUND_HALF_EVEN, '-2'),
            array('-1.49', 0, PHP_ROUND_HALF_EVEN, '-1'),
            array('-1.995', 0, PHP_ROUND_HALF_EVEN, '-2'),
            array('-0.6', 0, PHP_ROUND_HALF_EVEN, '-1'),
            // negative - 2 precision
            array('-1.58', 2, PHP_ROUND_HALF_EVEN, '-1.58'),
            array('-1.589', 2, PHP_ROUND_HALF_EVEN, '-1.59'),
            array('-1.599', 2, PHP_ROUND_HALF_EVEN, '-1.6'),
            array('-1.3', 2, PHP_ROUND_HALF_EVEN, '-1.3'),
            array('-1.495', 2, PHP_ROUND_HALF_EVEN, '-1.5'),
            array('-1.4949', 2, PHP_ROUND_HALF_EVEN, '-1.49'),
            array('-1.4958', 2, PHP_ROUND_HALF_EVEN, '-1.5'),
            // PHP_ROUND_HALF_ODD

            // 0 precision
            array('0', 0, PHP_ROUND_HALF_ODD, '0'),
            array('0.0', 0, PHP_ROUND_HALF_ODD, '0'),
            array('1', 0, PHP_ROUND_HALF_ODD, '1'),
            array('1.5', 0, PHP_ROUND_HALF_ODD, '1'),
            array('1.6', 0, PHP_ROUND_HALF_ODD, '2'),
            array('1.49', 0, PHP_ROUND_HALF_ODD, '1'),
            array('1.995', 0, PHP_ROUND_HALF_ODD, '2'),
            array('0.6', 0, PHP_ROUND_HALF_ODD, '1'),
            // 2 precision
            array('1.58', 2, PHP_ROUND_HALF_ODD, '1.58'),
            array('1.589', 2, PHP_ROUND_HALF_ODD, '1.59'),
            array('1.599', 2, PHP_ROUND_HALF_ODD, '1.6'),
            array('1.3', 2, PHP_ROUND_HALF_ODD, '1.3'),
            array('1.495', 2, PHP_ROUND_HALF_ODD, '1.49'),
            array('1.4949', 2, PHP_ROUND_HALF_ODD, '1.49'),
            array('1.4958', 2, PHP_ROUND_HALF_ODD, '1.5'),
            // negative - 0 precision
            array('-0', 0, PHP_ROUND_HALF_ODD, '0'),
            array('-0.0', 0, PHP_ROUND_HALF_ODD, '0'),
            array('-1', 0, PHP_ROUND_HALF_ODD, '-1'),
            array('-1.5', 0, PHP_ROUND_HALF_ODD, '-1'),
            array('-1.6', 0, PHP_ROUND_HALF_ODD, '-2'),
            array('-1.49', 0, PHP_ROUND_HALF_ODD, '-1'),
            array('-1.995', 0, PHP_ROUND_HALF_ODD, '-2'),
            array('-0.6', 0, PHP_ROUND_HALF_ODD, '-1'),
            // negative - 2 precision
            array('-1.58', 2, PHP_ROUND_HALF_ODD, '-1.58'),
            array('-1.589', 2, PHP_ROUND_HALF_ODD, '-1.59'),
            array('-1.599', 2, PHP_ROUND_HALF_ODD, '-1.6'),
            array('-1.3', 2, PHP_ROUND_HALF_ODD, '-1.3'),
            array('-1.495', 2, PHP_ROUND_HALF_ODD, '-1.49'),
            array('-1.4949', 2, PHP_ROUND_HALF_ODD, '-1.49'),
            array('-1.4958', 2, PHP_ROUND_HALF_ODD, '-1.5'),
        );
    }

    /**
     *
     */
    public function testCalculateVat()
    {
        $money = new \Superbalist\Money\Money('1264.46');
        $actual = $money->calculateVat()->format();
        $this->assertSame('155.28', $actual);
    }

    /**
     *
     */
    public function testCalculateNetVatAmount()
    {
        $money = new \Superbalist\Money\Money('1264.46');
        $actual = $money->calculateNetVatAmount()->format();
        $this->assertSame('1109.18', $actual);
    }

    /**
     *
     */
    public function testHasDecimals()
    {
        $money = new \Superbalist\Money\Money('69.46');
        $this->assertTrue($money->hasDecimals());

        $money = new \Superbalist\Money\Money('-3.0001');
        $this->assertTrue($money->hasDecimals());

        $money = new \Superbalist\Money\Money('0');
        $this->assertFalse($money->hasDecimals());

        $money = new \Superbalist\Money\Money('0.00');
        $this->assertFalse($money->hasDecimals());

        $money = new \Superbalist\Money\Money('-3.00');
        $this->assertFalse($money->hasDecimals());
    }

    /**
     *
     */
    public function testNegate()
    {
        $money = new \Superbalist\Money\Money('50.52');
        $money = $money->negate();
        $this->assertTrue($money->equals('-50.52'));

        $money = new \Superbalist\Money\Money('-50.52');
        $money = $money->negate();
        $this->assertTrue($money->equals('-50.52'));
    }

    /**
     *
     */
    public function testToInt()
    {
        $money = new \Superbalist\Money\Money('10.35');
        $this->assertSame(10, $money->toInt());

        $money = new \Superbalist\Money\Money('55.56');
        $this->assertSame(55, $money->toInt());

        $money = new \Superbalist\Money\Money('0.99999');
        $this->assertSame(0, $money->toInt());
    }
}
