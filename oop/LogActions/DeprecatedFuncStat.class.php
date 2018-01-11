<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace EL\LogActions;


class DeprecatedFuncStat extends LogActionStrategy
{
	/**
	 * @return string
	 */
	public function process()
	{
		$logDirectory = 'deprecated';
		$statistic = [];
		foreach ($this->_getFileLines($logDirectory) as $line)
		{
			$explodedLine = explode(' ', $line);
			if ($explodedLine[0] == "#3")
			{
				$usedFunction = explode("(", $explodedLine[2])[0];
				isset($statistic[$usedFunction]) ? $statistic[$usedFunction]++ : $statistic[$usedFunction] = 1;
			}
		}
		if (count($statistic) > 0)
			foreach ($statistic as $function => $errorsCount)
				$this->_result .= $function . ' was used: ' . $errorsCount . "\n";
		return $this->_result == '' ? " No depredcated usage found\n" : $this->_result;
	}
}