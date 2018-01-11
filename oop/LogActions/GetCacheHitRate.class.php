<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace EL\LogActions;


class GetCacheHitRate extends LogActionStrategy
{
	/**
	 * @return string
	 * @throws \Exception
	 */
	public function process()
	{
		if (!isset($this->_data[0]))
			throw new \Exception('Не указана дата');
		$checkDate = date_create($this->_data[0]);
		$dateInLogFormat = $checkDate->format('Y-m-d');
		$recordsCount = 0;
		$cachesCount = 0;
		$logDirectory = 'ryticketQueriesDetail';
		foreach ($this->_getFileLines($logDirectory) as $line)
		{
			$pattern = '(' . $dateInLogFormat . ')|(answer: cachedetail)';
			preg_match_all("/$pattern/", $line, $matches);
			if (isset($matches[0][0]) && $matches[0][0] == $dateInLogFormat)
				$recordsCount++;
			if (isset($matches[0][1]) && count($matches[0][1]) > 0)
				$cachesCount++;
		}
		if ($recordsCount > 0)
			$this->_result = round($cachesCount / $recordsCount * 100, 1) . "%\n";
		return 'Cache HitRate is ' . $this->_result;
	}

}