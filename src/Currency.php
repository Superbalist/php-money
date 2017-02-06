<?php

namespace Superbalist\Money;

class Currency
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $sign;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var bool
     */
    protected $isLeftSign;

    /**
     * @param string $code
     * @param string $sign
     * @param string $name
     * @param bool $isLeftSign
     */
    public function __construct($code, $sign, $name, $isLeftSign = true)
    {
        $this->code = $code;
        $this->sign = $sign;
        $this->name = $name;
        $this->isLeftSign = $isLeftSign;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isLeftSign()
    {
        return $this->isLeftSign;
    }

    /**
     * @param Currency $currency
     *
     * @return bool
     */
    public function equals(Currency $currency)
    {
        return $this->code === $currency->getCode();
    }

    /**
     * @param Money|string|int|float $amount
     * @param int $precision
     *
     * @return string
     */
    public function display($amount, $precision = 2)
    {
        $amount = Utils::toStringAmount($amount);
        $money = new Money($amount);
        if ($this->isLeftSign) {
            if ($money->isLessThan('0')) {
                return '-' . $this->sign . $money->abs()->format($precision);
            } else {
                return $this->sign . $money->format($precision);
            }
        } else {
            return $money->format($precision) . $this->sign;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->code;
    }
}
