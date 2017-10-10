<?php

/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

class Fibonachchi
{
	/**
	 * @param int $number
	 * @param int $previousNum
	 * @param int $beforePreviousNum
	 * @return int
	 */
	public function getFibonachchiNumber($number, $previousNum = 1, $beforePreviousNum = 0)
	{
		if ($number == 1)
			return 1;
		if ($number == 2)
			return $previousNum;
		$result = $this->getFibonachchiNumber($number - 1, $previousNum + $beforePreviousNum, $previousNum);
		return $result;
	}
}