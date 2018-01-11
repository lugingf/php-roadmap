<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

class ValidatingFormatTools
{
	/**
	 * @param array $items
	 * @param string $format
	 * @return array
	 */
	public static function getNoFormatItems($items, $format = '.*')
	{
		$badAdruments = [];
		foreach ($items as $arrayElement)
		{
			if (!preg_match('/' . $format . '/', $arrayElement))
				array_push($badAdruments, $arrayElement ? $arrayElement : 'пустой ввод');
		}
		return $badAdruments;
	}
}

