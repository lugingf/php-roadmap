<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace EL;

/**
 * Class FileStringIterator
 * @package EL
 */
class FileStringIterator implements \Iterator
{
	private $_descriptor;

	private $_key = -1;

	private $_line;

	public function __construct($path)
	{
		$path = '/' . $path;
		if (!is_file($path))
			throw new \Exception("Файл $path не найден");
		$this->_descriptor = fopen($path, 'r');
		$this->next();
	}

	public function next()
	{
		if (($this->_line = fgets($this->_descriptor)) !== false)
			$this->_key++;
	}

	public function current()
	{
		return $this->_line;
	}
	public function key()
	{
		return $this->_key;
	}
	public function rewind()
	{
		$this->_key = -1;
	}
	public function valid()
	{
		return !feof($this->_descriptor);
	}

	public function __destruct()
	{
		if ($this->_descriptor)
			fclose($this->_descriptor);
	}
}