<?php namespace Superbalist\Shared\Libs\Money;

class Utils {

	/**
	 * @param mixed $value
	 * @return string
	 * @throws \InvalidArgumentException
	 */
	public static function toStringAmount($value)
	{
		if ($value instanceof Money) {
			$str = $value->getAmount();
		} else if (is_int($value) || is_float($value)) {
			$str = strval($value);
		} else if (is_string($value)) {
			if (preg_match('/^\-?(\d+)(\.\d+)?$/', $value)) {
				$str = $value;
			} else {
				throw new \InvalidArgumentException('The amount must be a valid string in the format; eg: (xx|xx.xx|xxx.xxxx|-xx)');
			}
		} else {
			throw new \InvalidArgumentException('The amount must be a valid Money|int|float|string.');
		}
		return self::isZero($str) ? '0' : $str;
	}

	/**
	 * @param string $value
	 * @return bool
	 */
	public static function isZero($value)
	{
		return strlen(trim($value, '0.-')) == 0;
	}

	/**
	 * @param mixed $value
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
	 * @return string
	 */
	public static function floor($value)
	{
		$value = self::toStringAmount($value);
		if (($pos = strpos($value, '.')) !== false) {
			$int = substr($value, 0, $pos);
			if ($value[0] === '-') {
				$return = bcsub($int, 1, 0);  // subtract 1 from the integer portion with 0 precision
			} else {
				$return = $int;
			}
		} else {
			$return =  $value;
		}
		return self::isZero($return) ? '0' : $return;
	}

	/**
	 * @param string $value
	 * @param int $precision
	 * @return string
	 */
	public static function abs($value, $precision = 4)
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
	 * @return string
	 * @throws \RuntimeException
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
			if ($min === null || bccomp($value, $min, 4) < 0) {
				$min = $value;
			}
		}
		return $min;
	}

	/**
	 * @return string
	 * @throws \RuntimeException
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
			if ($max === null || bccomp($value, $max, 4) > 0) {
				$max = $value;
			}
		}
		return $max;
	}
}
