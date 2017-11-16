<?php

/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */
class XMLCreater
{
	/**
	 * @deprecated use createDeepArray() instead
	 * @param array $node
	 * @param int $nextTagIndex
	 * @param array $resultArray
	 * Оставил функцию для истории
	 *
	 * @return array
	 */
	public static function createDeepArrayLink($node, $nextTagIndex = 0, $resultArray = [])
	{
		if(!isset($node[$nextTagIndex]))
			return $resultArray;
		list($path, $value) = explode('=', $node[$nextTagIndex]);
		$isRootTag = true;
		foreach(explode('.', $path) as $tag)
		{
			if($isRootTag)
			{
				$bufferLink = &$resultArray[$tag];
				$isRootTag = false;
			}
			else
				$bufferLink = &$bufferLink[$tag];
		}
		$bufferLink = $value;
		unset($bufferLink);
		return self::createDeepArrayLink($node,$nextTagIndex + 1, $resultArray);
	}

	/**
	 * @param array $nodes
	 * @return array
	 */
	public static function createDeepArray($nodes)
	{
		$result = [];
		foreach ($nodes as $node)
		{
			$data = explode('=', $node);
			$tags = explode('.', $data[0]);
			$result[] = self::fillArraysByKeys($tags, 0, $data[1]);
		}
		$deepArray = [];
		foreach ($result as $array)
			$deepArray = array_merge_recursive($deepArray, $array);

		return $deepArray;
	}

	/**
	 * @param array $tags
	 * @param int $tagIndex
	 * @param mixed $value
	 * @return array
	 */
	public static function fillArraysByKeys($tags, $tagIndex = 0, $value = null)
	{
		if (isset($tags[$tagIndex + 1]))
			return array_fill_keys([$tags[$tagIndex]], self::fillArraysByKeys($tags, ($tagIndex + 1), $value));
		return array_fill_keys(([$tags[$tagIndex]]), $value);
	}

	/**
	 * @param array $input
	 * @param int $tagTab
	 * @return string
	 */
	public static function createXMLFromArray($input, $tagTab = 0)
	{
		$result = '';
		foreach ($input as $tagName => $value)
		{
			if (is_array($value))
			{
				$result .= self::_getOpenXMLTag($tagName, $tagTab);
				$result .= self::createXMLFromArray($value, $tagTab + 1);
				$result .= self::_getCloseXMLTag($tagName, $tagTab);
			}
			else
				$result .= self::_getFinalTag($tagName, $value, $tagTab);
		}
		return $result;
	}

	/**
	 * @param string $tagName
	 * @param int $tagDepth
	 * @return string
	 */
	private static function _getOpenXMLTag($tagName, $tagDepth = 0)
	{
		return str_repeat("\t", $tagDepth) . '<' . $tagName . '>' . "\n";
	}

	/**
	 * @param string $tagName
	 * @param int $tagDepth
	 * @return string
	 */
	private static function _getCloseXMLTag($tagName, $tagDepth = 0)
	{
		return str_repeat("\t", $tagDepth) . '</' . $tagName . '>' . "\n";
	}

	/**
	 * @param string $tagName
	 * @param $value
	 * @param int $tagDepth
	 * @return string
	 */
	private static function _getFinalTag($tagName, $value, $tagDepth = 0)
	{
		return str_repeat("\t", $tagDepth) . '<' . $tagName . '>' . $value . '</' . $tagName . '>' . "\n";
	}
}