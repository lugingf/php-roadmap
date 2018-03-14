<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */
namespace ELT;

class NumericTools
{
	/**
	 * @param integer $number
	 * @return array
	 */
	public static function getDigitsFromNumber($number)
	{
		$result = [];
		while ($number != 0)
		{
			$digit = $number % 10;
			$number = intdiv($number,10);
			$result[] = $digit;
		}
		return $result;
	}

	/**
	 * @param int $number
	 * @return int
	 */
	public static function getFactorial($number)
	{
		return ($number < 2) ? 1 : $number * self::getFactorial($number - 1);
	}
}
