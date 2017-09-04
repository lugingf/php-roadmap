<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

const DEFAULT_KEYBOARD = [
	'й' => 'q', 'ц' => 'w', 'у' => 'e',
	'к' => 'r', 'е' => 't', 'н' => 'y',
	'г' => 'u', 'ш' => 'i', 'щ' => 'o',
	'з' => 'p', 'х' => '[', 'ъ' => ']',
	'ф' => 'a', 'ы' => 's', 'в' => 'd',
	'а' => 'f', 'п' => 'g', 'р' => 'h',
	'о' => 'j', 'л' => 'k', 'д' => 'l',
	'ж' => ';', 'э' => '\'', 'я' => 'z',
	'ч' => 'x', 'с' => 'c', 'м' => 'v',
	'и' => 'b', 'т' => 'n', 'ь' => 'm',
	'б' => ',', 'ю' => '.', 'Й' => 'Q',
	'Ц' => 'W', 'У' => 'E', 'К' => 'R',
	'Е' => 'T', 'Н' => 'Y', 'Г' => 'U',
	'Ш' => 'I', 'Щ' => 'O', 'З' => 'P',
	'Х' => '{', 'Ъ' => '}', 'Ф' => 'A',
	'Ы' => 'S', 'В' => 'D', 'А' => 'F',
	'П' => 'G', 'Р' => 'H', 'О' => 'J',
	'Л' => 'K', 'Д' => 'L', 'Ж' => ':',
	'Э' => '\"', 'Я' => 'Z', 'Ч' => 'X',
	'С' => 'C', 'М' => 'V', 'И' => 'B',
	'Т' => 'N', 'Ь' => 'M', 'Б' => '<',
	'Ю' => '>'
];

/**
 * @param string $name
 * @return string
 */
function underscoreToCamel($word)
{
	$explodedWord = explode('_', $word);
	foreach ($explodedWord as $wordPart)
		$camelCaseExplodedWord[] = ucfirst(strtolower($wordPart));
	return implode('', $camelCaseExplodedWord);
}


/**
 * @param string $name
 * @return string
 */
function camelCaseToUnderscore($word)
{
	$word = lcfirst($word);
	return	strtolower(preg_replace('/([A-Z])/', '_\\1', $word));
}

/**
 * @param string $text
 * @return null|string
 */
function getKeyboardSwitchFunction($text)
{
	if (preg_match('/[А-Яа-яЁё]/u', $text))
		return 'switchToEng';
	if (preg_match('/[A-Za-z]/', $text))
		return 'switchToRus';
	return null;
}

/**
 * @param string $word
 * @param array $keyboard
 * @return string
 */
function switchToEng($word)
{
	return strtr($word, DEFAULT_KEYBOARD);
}

/**
 * @param string $word
 * @param array $keyboard
 * @return string
 */
function switchToRus($word)
{
	return strtr($word, array_flip(DEFAULT_KEYBOARD));
}