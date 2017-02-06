<?php

class CurrencyTests extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testFactoryMakeCurrency()
    {
        $currency1 = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $this->assertInstanceOf('\Superbalist\Money\Currency', $currency1);
        $this->assertSame('ZAR', $currency1->getCode());

        $currency2 = \Superbalist\Money\CurrencyFactory::make('USD');
        $this->assertInstanceOf('\Superbalist\Money\Currency', $currency2);
        $this->assertSame('USD', $currency2->getCode());
    }

    /**
     *
     */
    public function testFactoryGetSetDefaultCurrency()
    {
        $default = 'ZAR';
        \Superbalist\Money\CurrencyFactory::setDefault($default);
        $actual = \Superbalist\Money\CurrencyFactory::getDefault();
        $this->assertSame($actual, $default);
    }

    /**
     *
     */
    public function testFactoryMakeDefaultCurrency()
    {
        $currency = \Superbalist\Money\CurrencyFactory::makeDefault();
        $this->assertInstanceOf('\Superbalist\Money\Currency', $currency);
        $this->assertSame('ZAR', $currency->getCode());
    }

    /**
     *
     */
    public function testFactoryMakeInvalidCurrency()
    {
        $this->setExpectedException('\Superbalist\Money\CurrencyNotSupportedException');
        \Superbalist\Money\CurrencyFactory::make('LOREM');
    }

    /**
     *
     */
    public function testGetSupportedCurrencies()
    {
        $currencies = \Superbalist\Money\CurrencyFactory::getAllSupported();
        $this->assertArrayHasKey('ZAR', $currencies);
    }

    /**
     *
     */
    public function testEquals()
    {
        $currency1 = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $currency2 = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $this->assertTrue($currency1->equals($currency2));

        $currency3 = \Superbalist\Money\CurrencyFactory::make('USD');
        $this->assertFalse($currency1->equals($currency3));
    }

    /**
     *
     */
    public function testDisplay()
    {
        $currency = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $actual = $currency->display('100');
        $this->assertSame('R100.00', $actual);

        $currency = \Superbalist\Money\CurrencyFactory::make('USD');
        $actual = $currency->display('55.67');
        $this->assertSame('$55.67', $actual);

        $currency = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $actual = $currency->display('-123.67', 0);
        $this->assertSame('-R123', $actual);
    }

    /**
     *
     */
    public function testToString()
    {
        $currency = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $str = (string) $currency;
        $this->assertSame('ZAR', $str);
    }
}
