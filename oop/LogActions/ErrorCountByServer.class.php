<?php

/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */
namespace EL\LogActions;

class ErrorCountByServer extends LogActionStrategy
{
	/**
	 * @return string
	 */
	public function process()
	{
		$logDirectory = 'phpErrorLog';
		$statistic = [];
		foreach ($this->_getFileLines($logDirectory) as $line)
			// дату можем в переменных передавать в принципе, не знаю, сильно ли это надо сейчас для этого задания
			if (preg_match('/18-May-2016/', $line))
			{
				$logData = explode(' ', $line);
				$key = implode(" ", [$logData[0], $logData[4], $logData[5]]);
				if (!isset($statistic[$key]))
					$statistic[$key] = 0;
				$statistic[$key]++;
			}
		if (count($statistic) > 0)
			foreach ($statistic as $server => $errorsCount)
				$this->_result .= $server . ' errors count: ' . $errorsCount . "\n";
		return $this->_result == '' ? " No errors found\n" : $this->_result;
	}

}