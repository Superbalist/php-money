<?php namespace Superbalist\Shared\Libs\Money;

class Money {

	/**
	 * @var string
	 */
	protected $amount;

	/**
	 * @var Currency
	 */
	protected $currency;

	/**
	 * @var int
	 */
	protected $scaleFactor = 4;

	/**
	 * @var CurrencyConversionServiceInterface
	 */
	protected $currencyConversionService;

	/**
	 * @param Money|string|int|float $amount
	 * @param Currency $currency
	 */
	public function __construct($amount, Currency $currency = null)
	{
		$this->amount = Utils::toStringAmount($amount);
		if ($currency === null) {
			$currency = CurrencyFactory::makeDefault();
		}
		$this->currency = $currency;
		$this->currencyConversionService = CurrencyConversionServiceFactory::makeDefault();
	}

	/**
	 * @return CurrencyConversionServiceInterface
	 */
	public function getCurrencyConversionService()
	{
		return $this->currencyConversionService;
	}

	/**
	 * @param CurrencyConversionServiceInterface $service
	 */
	public function setCurrencyConversionService(CurrencyConversionServiceInterface $service)
	{
		$this->currencyConversionService = $service;
	}

	/**
	 * @return string
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @param Money|string|int|float $money
	 * @return Money
	 */
	public function add($money)
	{
		if ($money instanceof Money) {
			$money = $this->getNormalisedMoney($money);
		}
		$amount = Utils::toStringAmount($money);
		$result = bcadd($this->amount, $amount, $this->scaleFactor);
		return new self($result, $this->currency);
	}

	/**
	 * @param Money $money
	 * @return Money
	 */
	public function subtract(Money $money)
	{
		if ($money instanceof Money) {
			$money = $this->getNormalisedMoney($money);
		}
		$amount = Utils::toStringAmount($money);
		$result = bcsub($this->amount, $amount, $this->scaleFactor);
		return new self($result, $this->currency);
	}

	/**
	 * @param Money|string|int|float $multiplier
	 * @return Money
	 */
	public function multiply($multiplier)
	{
		$multiplier = Utils::toStringAmount($multiplier);
		$amount = bcmul($this->amount, $multiplier, $this->scaleFactor);
		return new self($amount, $this->currency);
	}

	/**
	 * @param Money|string|int|float $divisor
	 * @return Money
	 */
	public function divide($divisor)
	{
		$divisor = Utils::toStringAmount($divisor);
		$amount = bcdiv($this->amount, $divisor, $this->scaleFactor);
		return new self($amount, $this->currency);
	}

	/**
	 * @param Money|string|int|float $modulus
	 * @return string
	 */
	public function mod($modulus)
	{
		$modulus = Utils::toStringAmount($modulus);
		return bcmod($this->amount, $modulus);
	}

	/**
	 * @param Money|string|int|float $money
	 * @return bool
	 */
	public function equals($money)
	{
		if ($money instanceof Money) {
			if ( ! $this->isSameCurrencyAs($money)) {
				return false;
			}
		}
		return $this->compare($money) === 0;
	}

	/**
	 * @param Money|string|int|float $money
	 * @return int
	 * @throws CurrencyMismatchException
	 */
	public function compare($money)
	{
		if ($money instanceof Money) {
			if ( ! $this->isSameCurrencyAs($money)) {
				throw new CurrencyMismatchException(
					sprintf(
						'The monetary values being compared must be of the same currency (%s !== %s).',
						$this->currency->getCode(),
						$money->getCurrency()->getCode()
					)
				);
			}
		}
		$amount = Utils::toStringAmount($money);
		return bccomp($this->amount, $amount, $this->scaleFactor);
	}

	/**
	 * @param Money|string|int|float $money
	 * @return bool
	 */
	public function isGreaterThan($money)
	{
		return $this->compare($money) > 0;
	}

	/**
	 * @param Money|string|int|float $money
	 * @return bool
	 */
	public function isLessThan($money)
	{
		return $this->compare($money) < 0;
	}

	/**
	 * @param Money|string|int|float $money
	 * @return bool
	 */
	public function isGreaterThanOrEqualTo($money)
	{
		return $this->compare($money) >= 0;
	}

	/**
	 * @param Money|string|int|float $money
	 * @return bool
	 */
	public function isLessThanOrEqualTo($money)
	{
		return $this->compare($money) <= 0;
	}

	/**
	 * @return Currency
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @param Money $money
	 * @return bool
	 */
	public function isSameCurrencyAs(Money $money)
	{
		return $this->currency->equals($money->getCurrency());
	}

	/**
	 * @return bool
	 */
	public function isPositive()
	{
		return $this->compare('0') >= 0;
	}

	/**
	 * @return bool
	 */
	public function isNegative()
	{
		return $this->compare('0') < 0;
	}

	/**
	 * @return bool
	 */
	public function isZero()
	{
		return $this->compare('0') === 0;
	}

	/**
	 * @return bool
	 */
	public function isEven()
	{
		return $this->mod('2') === '0';
	}

	/**
	 * @return bool
	 */
	public function isOdd()
	{
		return $this->mod('2') !== '0';
	}

	/**
	 * @param Currency $currency
	 * @return Money
	 */
	public function toCurrency(Currency $currency)
	{
		$new = $this->currencyConversionService->convert($this->amount, $this->currency, $currency);
		return new Money($new, $currency);
	}

	/**
	 * @param int $precision
	 * @return string
	 */
	public function format($precision = 2)
	{
		// TODO: the value returned should be to precision decimal places
		return $this->amount;
	}

	/**
	 * @param int $precision
	 * @return string
	 */
	public function display($precision = 2)
	{
		return $this->currency->display($this->amount, $precision);
	}

	/**
	 * @return Money
	 */
	public function ceil()
	{
		$amount = Utils::ceil($this->amount);
		return new self($amount, $this->currency);
	}

	/**
	 * @return Money
	 */
	public function floor()
	{
		$amount = Utils::floor($this->amount);
		return new self($amount, $this->currency);
	}

	/**
	 * @return Money
	 */
	public function abs()
	{
		$amount = Utils::abs($this->amount, $this->scaleFactor);
		return new self($amount, $this->currency);
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->amount;
	}

	/**
	 * Returns the given money in the same currency as the current instance.
	 *
	 * @param Money $money
	 * @return Money
	 */
	protected function getNormalisedMoney(Money $money)
	{
		return $money->isSameCurrencyAs($this) ? $money : $money->toCurrency($this->currency);
	}
}
