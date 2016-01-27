<?php

class UtilsTests extends PHPUnit_Framework_TestCase {

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
		return array(
			array(0, '0'),
			array('3', '3'),
			array('3.0', '3'),
			array(0.01, '0.01'),
			array(-15.38294, '-15.38294'),
			array(6, '6'),
			array(new \Superbalist\Money\Money('3.54'), '3.54'),
			array(new \Superbalist\Money\Money(3.54), '3.54'),
			array(new \Superbalist\Money\Money(3.50), '3.5'),
			array('4.3286183', '4.3286183'),
			array('4.32', '4.32'),
			array(0.0999999999999, '0.0999999999999'),
		);
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
			array('0.000001', false),
		);
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
		return array(
			array(4.3, '5'),
			array(9.999, '10'),
			array(-3.14, '-3'),
			array(4, '4'),
			array(3.00000, '3'),
			array(1.5, '2'),
			array(1.51, '2'),
			array('1.499', '2'),
			array('-31.01', '-31'),
			array('-9.87', '-9'),
			array('-0.01', '0'),
			array('-0.001', '0'),
			array('-1', '-1'),
			array('0', '0'),
			array('1', '1'),
			array('-0', '0'),
			array('-0', '0'),
		);
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
		return array(
			array(4.3, '4'),
			array(9.999, '9'),
			array(-3.14, '-4'),
			array(4, '4'),
			array(3.00000, '3'),
			array(2.15, '2'),
			array(4.455, '4'),
			array('-9.87', '-10'),
			array('-0.01', '-1'),
			array('-0.001', '-1'),
			array('-1', '-1'),
			array('0', '0'),
			array('1', '1'),
			array('-0', '0'),
		);
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
		return array(
			array(0, '0'),
			array('3', '3'),
			array('-3', '3'),
			array('-0', '0'),
			array(-27.22, '27.22'),
			array('-3.2861942', '3.2861'),
		);
	}

	/**
	 *
	 */
	public function testMin()
	{
		$actual = \Superbalist\Money\Utils::min('10.00', 9.99, new \Superbalist\Money\Money('3.26'), '-4.6594', '-4.6595', '0.11', '0');
		$this->assertSame('-4.6595', $actual);
	}

	/**
	 *
	 */
	public function testMinArray()
	{
		$values = array(
			'10.00',
			9.99,
			new \Superbalist\Money\Money('3.26'),
			'-4.6594',
			'-4.6595',
			'0.11',
			'0'
		);
		$this->assertSame('-4.6595', \Superbalist\Money\Utils::min($values));
	}

	/**
	 *
	 */
	public function testMax()
	{
		$actual = \Superbalist\Money\Utils::max('10.00', '10.01', 9.99, new \Superbalist\Money\Money('3.26'), '-4.6594', '-4.6595', '0.11', '0');
		$this->assertSame('10.01', $actual);
	}

	/**
	 *
	 */
	public function testMaxArray()
	{
		$values = array(
			'10.00',
			'10.01',
			9.99,
			new \Superbalist\Money\Money('3.26'),
			'-4.6594',
			'-4.6595',
			'0.11',
			'0'
		);
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