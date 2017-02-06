<?php

namespace Superbalist\Money;

class MockCurrencyConversionService extends BaseCurrencyConversionService
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Mock';
    }

    /**
     * @param Currency $currency
     *
     * @return array
     */
    public function getConversionRatesTable(Currency $currency)
    {
        switch ($currency->getCode()) {
            case 'USD':
                return [
                    'USD' => '1',
                    'ZAR' => '12.07682',
                ];
            default: // ZAR
                return [
                    'USD' => '0.082776',
                    'ZAR' => '1',
                ];
        }
    }
}
