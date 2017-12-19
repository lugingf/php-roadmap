<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace oop\LogActions;


class TeacupCount extends LogActionStrategy
{

	/**
	 * @return string
	 * @throws \Exception
	 */
	public function process()
	{
		if (!isset($this->_data[0]))
			throw new \Exception('Не указана дата');
		$checkDateEnd = date_create($this->_data[0]);
		$checkDateBegin = date_create($this->_data[0])->modify("-2 week");
		$statistic = [];
		$logDirectory = 'teacup';
		foreach ($this->_getFileLines($logDirectory) as $line)
		{
			$logDate = explode(' ', $line)[0];
			$logDateObj = date_create($logDate);
			if ($logDateObj >= $checkDateBegin && $logDateObj <= $checkDateEnd)
				isset($statistic[$logDate]) ? $statistic[$logDate]++ : $statistic[$logDate] = 1;
		}
		if (count($statistic) > 0)
			foreach ($statistic as $date => $errorsCount)
				$this->_result .= $date . ' teacup count: ' . $errorsCount . "\n";
		return $this->_result == '' ? " No errors found\n" : $this->_result;
	}
}