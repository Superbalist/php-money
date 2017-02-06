<?php

class CurrencyConversionTests extends PHPUnit_Framework_TestCase
{
    /**
     * @return \Superbalist\Money\MockCurrencyConversionService
     */
    protected function makeMockService()
    {
        return new \Superbalist\Money\MockCurrencyConversionService();
    }

    /**
     *
     */
    public function testServiceProviderGetSetCurrencyConversionService()
    {
        $service = new \Superbalist\Money\MockCurrencyConversionService();
        \Superbalist\Money\CurrencyConversionServiceProvider::setCurrencyConversionService($service);
        $actual = \Superbalist\Money\CurrencyConversionServiceProvider::getCurrencyConversionService();
        $this->assertSame($actual, $service);
    }

    /**
     *
     */
    public function testGetConversionRatesTable()
    {
        $service = $this->makeMockService();
        $currency = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $rates = $service->getConversionRatesTable($currency);
        $this->assertArrayHasKey('ZAR', $rates);
    }

    /**
     *
     */
    public function testGetConversionMultiplier()
    {
        $service = $this->makeMockService();
        $from = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $to = \Superbalist\Money\CurrencyFactory::make('USD');
        $multiplier = $service->getConversionMultiplier($from, $to);
        $this->assertSame('0.082776', $multiplier);
    }

    /**
     *
     */
    public function testConvert()
    {
        $service = $this->makeMockService();
        $from = \Superbalist\Money\CurrencyFactory::make('ZAR');
        $to = \Superbalist\Money\CurrencyFactory::make('USD');

        $actual = $service->convert('1', $from, $to);
        $this->assertSame('0.082776', $actual);
    }
}
