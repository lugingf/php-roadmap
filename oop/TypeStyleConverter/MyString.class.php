<?php
declare(strict_types = 1);
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace EL\TypeStyleConverter;


class MyString
{
	private $_body = '';

	/**
	 * MyString constructor.
	 * @param string $text
	 */
	public function __construct(string $text)
	{
		$this->_body = $text;
	}

	/**
	 * @return string
	 */
	public function getBody(): string
	{
		return $this->_body;
	}

	/**
	 * @param MyString $text
	 * @return bool
	 */
	public function isEqual(MyString $text): bool
	{
		return $this->_body === $text->getBody() ? true : false;
	}

	/**
	 * @param string $glue
	 * @param MyString $text
	 * @param string $side
	 * @return MyString
	 * @throws \Exception
	 */
	public function concatenate(string $glue = '', MyString $text, string $side = 'right'): MyString
	{
		if (!isInstanceOf(MyString::class, $text) || gettype($glue) != "string")
		{
			throw new \Exception('wrong argument type');
		}
		if ($side != 'left')
		{
			return new MyString($this->_body . $glue . $text->getBody());
		}
		return new MyString($text->getBody() . $glue . $this->_body);
	}

	/**
	 * @param MyString $search
	 * @param MyString $replace
	 * @return MyString
	 */
	public function strReplace(MyString $search, MyString $replace): MyString
	{
		return new MyString(str_replace($search->getBody(), $replace->getBody(), $this->_body));
	}

	/**
	 * @param string $regex
	 * @param MyString $replace
	 * @return MyString
	 */
	public function pregReplace(string $regex, MyString $replace): MyString
	{
		return new MyString(preg_replace('/' . $regex . '/', $replace->getBody(), $this->_body));
	}

	/**
	 * @param string $delimeter
	 * @return MyString[]
	 */
	public function explode(string $delimeter = ' '): array
	{
		$newStringArray = [];
		foreach (explode($delimeter, $this->_body) as $newString)
		{
			$newStringArray[] = new MyString($newString);
		}
		return $newStringArray;
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->getBody();
	}

}