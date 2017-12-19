<?php

/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace oop\LogActions;

abstract class LogActionStrategy
{
	private $_logPath = '/home/lugin/devel/rm_logs/testlogsforphprodmap/';

	protected $_data;

	protected $_result = '';

	public function __construct($data)
	{
		$this->_data = $data;
	}

	/**
	 * @param $action
	 * @param $data
	 * @return null
	 */
	public static function getAction($action, $data)
	{
		$className = 'oop\\LogActions\\' . $action;
		if (!class_exists($className))
			return null;
		return new $className($data);
	}

	/**
	 * @param string $path
	 * @return array
	 */
	protected function _getFilesList($path)
	{
		$filesList = getDirectoryContentInArray($this->_logPath . $path);
		return $filesList;
	}

	/**
	 * @param string $logDirectory
	 * @return \Generator
	 */
	protected function _getFileLines($logDirectory)
	{
		$logLines = [];
		$logFiles = $this->_getFilesList($logDirectory);
		foreach ($logFiles as $file)
		{
			$fileIterator = new \oop\FileStringIterator($file);
			foreach ($fileIterator as $line)
				yield $line;
		}
	}

	/**
	 * @return mixed
	 */
	abstract function process();
}