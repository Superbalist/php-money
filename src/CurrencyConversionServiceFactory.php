<?php
namespace Superbalist\Money;

class CurrencyConversionServiceFactory
{

    /**
     * @param string $name
     * @return CurrencyConversionServiceInterface
     * @throws \RuntimeException
     */
    public static function make($name)
    {
        $name = strtoupper($name);
        switch ($name) {
            case 'OPENEXCHANGERATES':
                // FIXME: app id is currently hardcoded below - should config
                return new OpenExchangeRatesCurrencyConversionService('534b91f9907243f680e290f8c442df40');
        }
        throw new \RuntimeException(sprintf('The currency conversion service "%s" is not supported.', $name));
    }

    /**
     * @return CurrencyConversionServiceInterface
     */
    public static function makeDefault()
    {
        return self::make('OPENEXCHANGERATES');
    }
}
