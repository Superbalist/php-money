<?php namespace Superbalist\Shared\Libs\Money;

use Cache;

class CachedCurrencyConversionService extends BaseCurrencyConversionService {

	/**
	 * @var CurrencyConversionServiceInterface
	 */
	protected $service;

	/**
	 * @var int
	 */
	protected $ttl;

	/**
	 * @param CurrencyConversionServiceInterface $service
	 * @param int $ttl
	 */
	public function __construct(CurrencyConversionServiceInterface $service, $ttl = 60)
	{
		$this->service = $service;
		$this->ttl = $ttl;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'Cached';
	}

	/**
	 * @param Currency $currency
	 * @return array
	 */
	public function getConversionRatesTable(Currency $currency)
	{
		$key = sprintf('currency_conversion_table_%s_%s', md5($this->service->getName()), $currency->getCode());
		return Cache::remember($key, $this->ttl, function() use ($currency) {
			return $this->service->getConversionRatesTable($currency);
		});
	}
}