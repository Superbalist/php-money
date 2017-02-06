<?php

namespace Superbalist\Money;

class CurrencyFactory
{
    /**
     * @var string
     */
    protected static $default = 'ZAR';

    /**
     * @var array
     *
     * The format is 'code' => array('sign', 'name') OR 'code' => array('sign', 'name', 'isLeftSign')
     */
    protected static $currencies = [
        'AUD' => ['$', 'Australian Dollar'],
        'BRL' => ['R$', 'Brazilian Real'],
        'CAD' => ['$', 'Canadian Dollar'],
        'CNY' => ['¥', 'Chinese Yuan'],
        'CHF' => ['Fr', 'Swiss Franc'],
        'DKK' => ['kr.', 'Danish Krone'],
        'EUR' => ['€', 'Euro'],
        'GBP' => ['£', 'British Pound Sterling'],
        'HKD' => ['$', 'Hong Kong Dollar'],
        'INR' => ['₹', 'Indian Rupee'],
        'ILS' => ['₪', 'Israeli New Shekel'],
        'JPY' => ['¥', 'Japanese Yen'],
        'KRW' => ['₩', 'South Korean Won'],
        'MXN' => ['$', 'Mexican Peso'],
        'NZD' => ['$', 'New Zealand Dollar'],
        'NOK' => ['kr', 'Norwegian Krone'],
        'RUB' => ['₽', 'Russian Ruble'],
        'SEK' => ['kr', 'Swedish Krona'],
        'SGD' => ['$', 'Singapore Dollar'],
        'TRY' => ['₺', 'Turkish Lira'],
        'USD' => ['$', 'United States Dollar'],
        'ZAR' => ['R', 'South African Rand'],
    ];

    /**
     * @param string $code
     * @param string $sign
     * @param string $name
     * @param bool $isLeftSign
     */
    public static function addCurrency($code, $sign, $name, $isLeftSign = true)
    {
        self::$currencies[$code] = [$sign, $name, $isLeftSign];
    }

    /**
     * @param string $code
     *
     * @throws CurrencyNotSupportedException
     *
     * @return Currency
     */
    public static function make($code)
    {
        $code = strtoupper($code);
        $supported = self::getAllSupported();
        if (isset($supported[$code])) {
            // code, sign, name, left sign
            $data = $supported[$code];
            $sign = isset($data[0]) ? strval($data[0]) : null;
            $name = isset($data[1]) ? strval($data[1]) : null;
            $isLeftSign = isset($data[2]) ? boolval($data[2]) : true;
            return new Currency($code, $sign, $name, $isLeftSign);
        }
        throw new CurrencyNotSupportedException(sprintf('The currency "%s" is not supported.', $code));
    }

    /**
     * @return Currency
     */
    public static function makeDefault()
    {
        return self::make(self::$default);
    }

    /**
     * @param string $default
     */
    public static function setDefault($default)
    {
        self::$default = $default;
    }

    /**
     * @return string
     */
    public static function getDefault()
    {
        return self::$default;
    }

    /**
     * @return array
     */
    public static function getAllSupported()
    {
        return self::$currencies;
    }
}
