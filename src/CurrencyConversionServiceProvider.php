<?php

namespace Superbalist\Money;

class CurrencyConversionServiceProvider
{
    /**
     * @var CurrencyConversionServiceInterface
     */
    protected static $service;

    /**
     * @param CurrencyConversionServiceInterface $service
     */
    public static function setCurrencyConversionService(CurrencyConversionServiceInterface $service)
    {
        self::$service = $service;
    }

    /**
     * @return CurrencyConversionServiceInterface
     */
    public static function getCurrencyConversionService()
    {
        return self::$service;
    }
}
