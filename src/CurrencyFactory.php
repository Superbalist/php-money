<?php namespace Superbalist\Money;

class CurrencyFactory {

	/**
	 * @param string $code
	 * @return Currency
	 * @throws CurrencyNotSupportedException
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
		return self::make('ZAR');
	}

	/**
	 * @return array
	 */
	public static function getAllSupported()
	{
		// format is:
		// 'code' => array('sign', 'name')
		// OR
		// 'code' => array('sign', 'name', 'isLeftSign')
		return array(
			'AUD' => array('$', 'Australian Dollar'),
			'BRL' => array('R$', 'Brazilian Real'),
			'CAD' => array('$', 'Canadian Dollar'),
			'CNY' => array('¥', 'Chinese Yuan'),
			'CHF' => array('Fr', 'Swiss Franc'),
			'DKK' => array('kr.', 'Danish Krone'),
			'EUR' => array('€', 'Euro'),
			'GBP' => array('£', 'British Pound Sterling'),
			'HKD' => array('$', 'Hong Kong Dollar'),
			'INR' => array('₹', 'Indian Rupee'),
			'ILS' => array('₪', 'Israeli New Shekel'),
			'JPY' => array('¥', 'Japanese Yen'),
			'KRW' => array('₩', 'South Korean Won'),
			'MXN' => array('$', 'Mexican Peso'),
			'NZD' => array('$', 'New Zealand Dollar'),
			'NOK' => array('kr', 'Norwegian Krone'),
			'RUB' => array('₽', 'Russian Ruble'),
			'SEK' => array('kr', 'Swedish Krona'),
			'SGD' => array('$', 'Singapore Dollar'),
			'TRY' => array('₺', 'Turkish Lira'),
			'USD' => array('$', 'United States Dollar'),
			'ZAR' => array('R', 'South African Rand'),
		);
	}
}
