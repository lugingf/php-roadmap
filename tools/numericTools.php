<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

/**
 * @param integer $number
 * @return array
 */
function getDigitsFromNumber($number)
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
function getFactorial($number)
{
	return ($number < 2) ? 1 : $number * getFactorial($number - 1);
}