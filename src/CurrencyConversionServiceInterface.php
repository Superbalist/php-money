<?php

namespace Superbalist\Money;

interface CurrencyConversionServiceInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param mixed $amount
     * @param Currency $from
     * @param Currency $to
     *
     * @return string
     */
    public function convert($amount, Currency $from, Currency $to);

    /**
     * @param Currency $from
     * @param Currency $to
     *
     * @return string
     */
    public function getConversionMultiplier(Currency $from, Currency $to);

    /**
     * @param Currency $currency
     *
     * @return array
     */
    public function getConversionRatesTable(Currency $currency);
}
