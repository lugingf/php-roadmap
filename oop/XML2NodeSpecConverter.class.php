<?php

/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */
class XML2NodeSpecConverter
{
	/**
	 * @param array $array
	 * @return string
	 */
	public static function getStringFromDeepArray($array)
	{
		$arrayStrings = [];
		if (!is_null($array))
			$arrayStrings = self::_fillResultArrayByStringsConfig($array);

		$result = implode('', $arrayStrings);
		return $result;
	}

	/**
	 * @param array $array
	 * @param string $nodeString
	 * @param array $nodesBatchArray
	 * @return array
	 */
	private static function _fillResultArrayByStringsConfig($array, $nodeString = '', $nodesBatchArray = [])
	{
		foreach ($array as $nodeName => $value)
		{
			if(is_array($value))
				$nodesBatchArray = self::_fillResultArrayByStringsConfig($value, $nodeString . $nodeName . '.', $nodesBatchArray);
			else
				$nodesBatchArray[] = self::_getNode($value, $nodeName, $nodeString);
		}
		return $nodesBatchArray;
	}


	/**
	 * @param string $value
	 * @param string $lastTag
	 * @param string $nodeName
	 * @return string
	 */
	private static function _getNode($value, $lastTag, $nodeName = '')
	{
		return $nodeName . $lastTag . '=' . $value . '; ';
	}

	/**
	 * @param string $xml
	 * @return array|false
	 */
	public static function getDeepArrayFromXML($xml)
	{
		$xml ='<main_root_tag>' . $xml . '</main_root_tag>';
		if (($xmlOb = simplexml_load_string($xml)) !== false)
			return json_decode(json_encode($xmlOb), true);
	}
}