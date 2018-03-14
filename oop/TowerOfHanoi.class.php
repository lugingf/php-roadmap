<?php

/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace EL;

class TowerOfHanoi
{
	/**
	 * @param int $count
	 * @param string $sourcePole
	 * @param string $targetPole
	 * @param string $bufferPole
	 * @param string $movements
	 * @return string
	 */
	static function getMovementsOrder($count, $sourcePole, $targetPole, $bufferPole, $movements = '')
	{
		if ($count >= 1)
		{
			$movements = TowerOfHanoi::getMovementsOrder($count-1, $sourcePole, $bufferPole, $targetPole, $movements);
			$movements .= $sourcePole . ' to ' . $targetPole . PHP_EOL;
			$movements = TowerOfHanoi::getMovementsOrder($count-1, $bufferPole, $targetPole, $sourcePole, $movements);
		}
		return $movements;
	}
}