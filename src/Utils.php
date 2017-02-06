<?php

namespace Superbalist\Money;

class Utils
{
    /**
     * @param mixed $value
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public static function toStringAmount($value)
    {
        if ($value instanceof Money) {
            $str = $value->getAmount();
        } elseif (is_int($value) || is_float($value)) {
            $str = strval($value);
        } elseif (is_string($value)) {
            $value = trim($value);
            if ($value === '' || preg_match('/^\-?(\d+)(\.\d+)?$/', $value)) {
                $str = $value;
            } else {
                throw new \InvalidArgumentException(
                    'The amount must be a valid string in the format; eg: (xx|xx.xx|xxx.xxxx|-xx)'
                );
            }
        } else {
            if ($value === null) {
                $str = '0';
            } else {
                throw new \InvalidArgumentException(sprintf(
                    'The amount must be a valid Money|int|float|string|null (value = "%s").',
                    $value
                ));
            }
        }
        $str = self::isZero($str) ? '0' : $str;
        if (($pos = strpos($str, '.')) !== false) {
            $int = substr($str, 0, $pos);
            $decimals = substr($str, $pos + 1);
            $decimals = rtrim($decimals, '0');
            if ($decimals === '') {
                $str = $int;
            } else {
                $str = $int . '.' . $decimals;
            }
        }
        return $str;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public static function isZero($value)
    {
        return strlen(trim($value, '0.-')) == 0;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function ceil($value)
    {
        $value = self::toStringAmount($value);
        if (($pos = strpos($value, '.')) !== false) {
            $int = substr($value, 0, $pos);
            if ($value[0] === '-') {
                $return = $int;
            } else {
                $return = bcadd($int, 1, 0); // add 1 to the integer portion with 0 precision
            }
        } else {
            $return = $value;
        }
        return self::isZero($return) ? '0' : $return;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public static function floor($value)
    {
        $value = self::toStringAmount($value);
        if (($pos = strpos($value, '.')) !== false) {
            $int = substr($value, 0, $pos);
            if ($value[0] === '-') {
                $return = bcsub($int, 1, 0); // subtract 1 from the integer portion with 0 precision
            } else {
                $return = $int;
            }
        } else {
            $return = $value;
        }
        return self::isZero($return) ? '0' : $return;
    }

    /**
     * @param string $value
     * @param int $precision
     *
     * @return string
     */
    public static function abs($value, $precision = Money::DEFAULT_SCALE_FACTOR)
    {
        $value = self::toStringAmount($value);
        if ($value[0] === '-') {
            $return = bcmul($value, '-1', $precision);
        } else {
            $return = $value;
        }
        return self::isZero($return) ? '0' : $return;
    }

    /**
     * @throws \RuntimeException
     *
     * @return string
     */
    public static function min()
    {
        $min = null;
        $args = func_get_args();
        if (count($args) == 0) {
            throw new \RuntimeException('The min function expects a minimum of 1 parameter or an array of values.');
        }
        if (is_array($args[0])) {
            $args = $args[0];
        }
        foreach ($args as $value) {
            $value = self::toStringAmount($value);
            if ($min === null || bccomp($value, $min, Money::DEFAULT_SCALE_FACTOR) < 0) {
                $min = $value;
            }
        }
        return $min;
    }

    /**
     * @throws \RuntimeException
     *
     * @return string
     */
    public static function max()
    {
        $max = null;
        $args = func_get_args();
        if (count($args) == 0) {
            throw new \RuntimeException('The max function expects a minimum of 1 parameter or an array of values.');
        }
        if (is_array($args[0])) {
            $args = $args[0];
        }
        foreach ($args as $value) {
            $value = self::toStringAmount($value);
            if ($max === null || bccomp($value, $max, Money::DEFAULT_SCALE_FACTOR) > 0) {
                $max = $value;
            }
        }
        return $max;
    }

    /**
     * @param mixed $value
     * @param int $precision
     * @param int $mode
     *
     * @return string
     */
    public static function round($value, $precision, $mode = PHP_ROUND_HALF_UP)
    {
        $value = self::toStringAmount($value);
        $n = round($value, $precision, $mode);
        return strval($n);
    }

    /**
     * @param mixed $gross
     * @param string $rate
     * @returns string
     */
    public static function calculateVat($gross, $rate = '0.14')
    {
        $gross = self::toStringAmount($gross);
        $divisor = bcadd('1', $rate, Money::DEFAULT_SCALE_FACTOR);
        $v = bcdiv($gross, $divisor, Money::DEFAULT_SCALE_FACTOR); // $gross / 1.14
        $vat = bcmul($v, $rate, Money::DEFAULT_SCALE_FACTOR); // $v * 0.14
        return self::round($vat, 2, PHP_ROUND_HALF_EVEN);
    }

    /**
     * @param mixed $gross
     * @param string $rate
     *
     * @return string
     */
    public static function calculateNetVatAmount($gross, $rate = '0.14')
    {
        $vat = self::calculateVat($gross, $rate);
        $net = bcsub($gross, $vat, Money::DEFAULT_SCALE_FACTOR);
        return self::round($net, 2, PHP_ROUND_HALF_EVEN);
    }
}
