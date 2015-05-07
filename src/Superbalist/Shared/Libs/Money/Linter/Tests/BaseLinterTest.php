<?php namespace Superbalist\Shared\Libs\Money\Linter\Tests;

abstract class BaseLinterTest implements LinterTestInterface {

	/**
	 * @return string
	 */
	public function getName()
	{
		$name = get_class($this);
		if (($p = strrpos($name, '\\')) !== false) {
			$name = substr($name, $p + 1);
		}
		return $name;
	}

	/**
	 * @param string $source
	 * @param int $number
	 * @return string
	 */
	protected function getLineFromSource($source, $number)
	{
		$source = preg_replace('~\R~u', "\n", $source);
		$lines = explode("\n", $source);
		$line = array_get($lines, $number - 1);
		if ($line === null) {
			return $line;
		}
		return trim($line);
	}
}