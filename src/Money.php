<?php

namespace Superbalist\Money;

class Money
{
    const DEFAULT_SCALE_FACTOR = 4;

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
    protected $scaleFactor = self::DEFAULT_SCALE_FACTOR;

    /**
     * @var CurrencyConversionServiceInterface
     */
    protected $currencyConversionService;

    /**
     * @param Money|string|int|float $amount
     * @param Currency $currency
     * @param CurrencyConversionServiceInterface $currencyConversionService
     */
    public function __construct(
        $amount = '0',
        Currency $currency = null,
        CurrencyConversionServiceInterface $currencyConversionService = null
    ) {
        $this->amount = Utils::toStringAmount($amount);
        $this->currency = $currency === null ? CurrencyFactory::makeDefault() : $currency;
        $this->currencyConversionService = $currencyConversionService === null ?
            CurrencyConversionServiceProvider::getCurrencyConversionService() :
            $currencyConversionService;
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
     *
     * @return Money
     */
    public function add($money)
    {
        if ($money instanceof self) {
            $money = $this->getNormalisedMoney($money);
        }
        $amount = Utils::toStringAmount($money);
        $result = bcadd($this->amount, $amount, $this->scaleFactor);
        return new self($result, $this->currency);
    }

    /**
     * @param Money|string|int|float $money
     *
     * @return Money
     */
    public function subtract($money)
    {
        if ($money instanceof self) {
            $money = $this->getNormalisedMoney($money);
        }
        $amount = Utils::toStringAmount($money);
        $result = bcsub($this->amount, $amount, $this->scaleFactor);
        return new self($result, $this->currency);
    }

    /**
     * @param Money|string|int|float $multiplier
     *
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
     *
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
     *
     * @return string
     */
    public function mod($modulus)
    {
        $modulus = Utils::toStringAmount($modulus);
        return bcmod($this->amount, $modulus);
    }

    /**
     * @param Money|string|int|float $money
     *
     * @return bool
     */
    public function equals($money)
    {
        if ($money instanceof self) {
            if (!$this->isSameCurrencyAs($money)) {
                return false;
            }
        }
        return $this->compare($money) === 0;
    }

    /**
     * @param Money|string|int|float $money
     *
     * @throws CurrencyMismatchException
     *
     * @return int
     */
    public function compare($money)
    {
        if ($money instanceof self) {
            if (!$this->isSameCurrencyAs($money)) {
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
     *
     * @return bool
     */
    public function isGreaterThan($money)
    {
        return $this->compare($money) > 0;
    }

    /**
     * @param Money|string|int|float $money
     *
     * @return bool
     */
    public function isLessThan($money)
    {
        return $this->compare($money) < 0;
    }

    /**
     * @param Money|string|int|float $money
     *
     * @return bool
     */
    public function isGreaterThanOrEqualTo($money)
    {
        return $this->compare($money) >= 0;
    }

    /**
     * @param Money|string|int|float $money
     *
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
     *
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
     *
     * @return Money
     */
    public function toCurrency(Currency $currency)
    {
        $new = $this->currencyConversionService->convert($this->amount, $this->currency, $currency);
        return new self($new, $currency);
    }

    /**
     * @param int $precision
     * @param string $decPoint
     * @param string $thousandsSep
     * @param int $mode
     *
     * @return string
     */
    public function roundFormat($precision = 2, $decPoint = '.', $thousandsSep = '', $mode = PHP_ROUND_HALF_UP)
    {
        return $this->round($precision, $mode)->format($precision, $decPoint, $thousandsSep);
    }

    /**
     * @param int $precision
     * @param string $decPoint
     * @param string $thousandsSep
     *
     * @return string
     */
    public function format($precision = 2, $decPoint = '.', $thousandsSep = '')
    {
        $value = $this->amount;
        if (($pos = strpos($this->amount, '.')) !== false) {
            $int = substr($this->amount, 0, $pos);
            $decimals = substr($this->amount, $pos + 1, $precision);
            $value = $int . '.' . $decimals;
        }
        return strval(number_format($value, $precision, $decPoint, $thousandsSep));
    }

    /**
     * @param int $precision
     *
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
     * @param Money|string|int|float $money
     *
     * @return Money
     */
    public function min($money)
    {
        $money = Utils::toStringAmount($money);
        $amount = Utils::min($this->amount, $money);
        return new self($amount, $this->currency);
    }

    /**
     * @param Money|string|int|float $money
     *
     * @return Money
     */
    public function max($money)
    {
        $money = Utils::toStringAmount($money);
        $amount = Utils::max($this->amount, $money);
        return new self($amount, $this->currency);
    }

    /**
     * @return Money
     */
    public function negate()
    {
        $amount = $this->isNegative() ? $this->amount : '-' . $this->amount;
        return new self($amount, $this->currency);
    }

    /**
     * @param int $precision
     * @param int $mode
     *
     * @return Money
     */
    public function round($precision, $mode = PHP_ROUND_HALF_UP)
    {
        $amount = Utils::round($this->amount, $precision, $mode);
        return new self($amount, $this->currency);
    }

    /**
     * @param string $rate
     *
     * @return Money
     */
    public function calculateVat($rate = '0.14')
    {
        $vat = Utils::calculateVat($this->amount, $rate);
        return new self($vat, $this->currency);
    }

    /**
     * @param string $rate
     *
     * @return Money
     */
    public function calculateNetVatAmount($rate = '0.14')
    {
        $net = Utils::calculateNetVatAmount($this->amount, $rate);
        return new self($net, $this->currency);
    }

    /**
     * @return bool
     */
    public function hasDecimals()
    {
        if (($pos = strpos($this->amount, '.')) !== false) {
            $decimals = substr($this->amount, $pos + 1);
            $decimals = rtrim($decimals, '0');
            return $decimals !== '';
        }
        return false;
    }

    /**
     * @return int
     */
    public function toCents()
    {
        return $this->multiply('100')->toInt();
    }

    /**
     * @return int
     */
    public function toInt()
    {
        return intval($this->amount);
    }

    /**
     * @return float
     */
    public function toFloat()
    {
        return floatval($this->amount);
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
     *
     * @return Money
     */
    protected function getNormalisedMoney(Money $money)
    {
        return $money->isSameCurrencyAs($this) ? $money : $money->toCurrency($this->currency);
    }
}
