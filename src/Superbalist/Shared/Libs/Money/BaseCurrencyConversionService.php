<?php namespace Superbalist\Shared\Libs\Money;

abstract class BaseCurrencyConversionService implements CurrencyConversionServiceInterface {

	/**
	 * {@inheritdoc}
	 */
	public function convert($amount, Currency $from, Currency $to)
	{
		$amount = Utils::toStringAmount($amount);
		$multiplier = $this->getConversionMultiplier($from, $to);
		return bcmul($amount, $multiplier, 6);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getConversionMultiplier(Currency $from, Currency $to)
	{
		$rates = $this->getConversionRatesTable($from);
		if ( ! isset($rates[$to->getCode()])) {
			throw new \RuntimeException(sprintf('The target currency "%s" is not present in the conversion rates table.', $to->getCode()));
		}
		return $rates[$to->getCode()];
	}
}