<?php

namespace Superbalist\Money;

class OpenExchangeRatesCurrencyConversionService extends BaseCurrencyConversionService
{
    /**
     * @var string
     */
    protected $appId;

    /**
     * @param string $appId
     */
    public function __construct($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'OpenExchangeRates';
    }

    /**
     * @param Currency $currency
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    public function getConversionRatesTable(Currency $currency)
    {
        $ch = curl_init();
        $url = sprintf('http://openexchangerates.org/api/latest.json?app_id=%s', $this->appId);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        if ($response === false) {
            throw new \RuntimeException(
                sprintf(
                    'An error occurred querying %s for conversion rates - (%s - %d)',
                    $url,
                    curl_error($ch),
                    curl_errno($ch)
                )
            );
        }
        $result = json_decode($response, true);
        if (is_array($result) && isset($result['rates'])) {
            $rates = $result['rates'];
            // the free plan only supports a base currency of 'usd'
            // we therefore need to convert the table to our own base currency
            // first, our own base must be present in the conversion table
            if (!isset($rates[$currency->getCode()])) {
                return []; // nothing more to do
            }
            $usd2base = (string) $rates[$currency->getCode()];
            $table = [];
            foreach ($rates as $code => $rate) {
                if ($code === 'USD') {
                    $table[$code] = '1';
                } else {
                    $rate = (string) $rate;
                    $multiplier = bcdiv('1', $usd2base, 6);
                    $table[$code] = bcmul($rate, $multiplier, 6);
                }
            }
            return $table;
        } else {
            return []; // response isn't what we expected / missing rates
        }
    }
}
