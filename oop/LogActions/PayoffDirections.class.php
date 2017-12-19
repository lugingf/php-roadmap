<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Москва - Питер vs Москва - Челябинск
 * 200000[0-3] - 200400[016] vs 200000[0-3] - 2040000
 */

namespace oop\LogActions;


class PayoffDirections extends LogActionStrategy
{

	const DAYS_DIFF = [45, 40, 30, 20, 10];
	const CITIES_IDS = [
		'Москва' => ['2000000', '2000001', '2000002', '2000003'],
		'Санкт-Петербург' => ['2004000', '2004001', '2004006'],
		'Питер' => ['2004000', '2004001', '2004006'],
		'Челябинск' => ['2040000'],
	];

	/**
	 * @return string
	 * @throws \Exception
	 */
	public function process()
	{
		if (!isset($this->_data[1]))
			throw new \Exception('Не указаны города');
		$seatsHistory = [];
		if (!$this->_isCitiesKnown($this->_data))
			return $this->_result;
		$logDirectory = 'ryticketQueriesDetail';
		foreach ($this->_getFileLines($logDirectory) as $line)
		{
			// Я хз, как правильно определять нужные нам строки, если в логе будет записи с другим форматом. Пока так.
			if (preg_match('/([\d]+ - [\d]+)/', $line))
			{
				$seatsInfo = $this->_getDirectionSeats($this->_data[0], $this->_data[1], $line);
				if (is_null($seatsInfo))
					continue;
				$seatsHistory[] = $seatsInfo;
			}
		}
		$meanStatistic = $this->_getMeanStatistic($this->_mergeData($seatsHistory));
		$this->_result = $this->_getStringPayoffResult($meanStatistic);
		return $this->_result == '' ? " Информации по направлениям не найдено\n" : $this->_result;
	}

	/**
	 * @param string $fromCity
	 * @param string $toCity
	 * @param string $logLine
	 * @return array
	 */
	private function _getDirectionSeats($fromCity, $toCity, $logLine)
	{
		$explodedLine = explode(' ', $logLine);
		if (in_array($explodedLine[14], self::CITIES_IDS[$fromCity]) && in_array($explodedLine[16], self::CITIES_IDS[$toCity]))
		{
			$searchDate = date_create($explodedLine[18]);
			$logDate = date_create($explodedLine[0]);
			$searchTerm = $searchDate->diff($logDate)->days;
			if (in_array($searchTerm, self::DAYS_DIFF))
			{
				$day = $fromCity . ' -> ' . $toCity . " за $searchTerm дней";
				$seatsCount = (is_numeric($explodedLine[31]) ? intval($explodedLine[31]) : 0);
				$result[$day] = $seatsCount;
				return $result ?? [];
			}
		}
	}

	/**
	 * @param array $data
	 * @return bool
	 */
	private function _isCitiesKnown($data)
	{
		if (isset($data[0]) &&
			isset($data[1]) &&
			array_key_exists($data[0], self::CITIES_IDS) &&
			array_key_exists($data[1], self::CITIES_IDS))
			return true;
		return false;
	}

	/**
	 * @param array $arrayOfSeats
	 * @return array
	 */
	private function _mergeData($arrayOfSeats)
	{
		$mergedData = [];
		if (!is_array($arrayOfSeats))
			return $mergedData;
		for ($i = 0; $i < count($arrayOfSeats); $i++)
			$mergedData = array_merge_recursive($mergedData, $arrayOfSeats[$i]);
		return $mergedData;
	}

	/**
	 * @param array $array
	 * @return array
	 */
	private function _getMeanStatistic($array)
	{
		$meanStatistic = [];
		if (!is_array($array))
			return $meanStatistic;
		foreach ($array as $direction => $seatsData)
			$meanStatistic[$direction] = round(array_sum($seatsData) / count($seatsData));
		return $meanStatistic;
	}

	/**
	 * @param array $statistic
	 * @return string
	 */
	private function _getStringPayoffResult($statistic)
	{
		$result = '';
		foreach ($statistic as $direction => $meanPayoff)
			$result .= "$direction среднее количество мест: $meanPayoff\n";
		return $result;
	}
}