<?php

namespace Superbalist\Money;

abstract class BaseCurrencyConversionService implements CurrencyConversionServiceInterface
{
    /**
     * @param mixed $amount
     * @param Currency $from
     * @param Currency $to
     *
     * @return string
     */
    public function convert($amount, Currency $from, Currency $to)
    {
        $amount = Utils::toStringAmount($amount);
        $multiplier = $this->getConversionMultiplier($from, $to);
        return bcmul($amount, $multiplier, 6);
    }

    /**
     * @param Currency $from
     * @param Currency $to
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    public function getConversionMultiplier(Currency $from, Currency $to)
    {
        $rates = $this->getConversionRatesTable($from);
        if (!isset($rates[$to->getCode()])) {
            throw new \RuntimeException(sprintf(
                'The target currency "%s" is not present in the conversion rates table.',
                $to->getCode()
            ));
        }
        return $rates[$to->getCode()];
    }
}
