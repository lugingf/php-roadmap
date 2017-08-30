<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

/**
 * @param string $textName
 * @return string
 */
function getPhrase($textName)
{
	$templates = [
		// common
		'noArgsText' => 'Не введены аргументы.',
		'example' => 'Пример: php ',

		// dates texts
		'wrongDateFormat' => ', неверный формат даты:',
		'dateFormatExample' => ' 31.12.2017 01.02.2000',

	];

	return $templates[$textName] ? $templates[$textName] : '' ;
}


/**
 * @param string $regexName
 * @return string|null
 */
function getRegex($regexName)
{
	$regexes = [
		'dateTemplate' => '^[\d]{1,2}\.[\d]{1,2}\.[\d]{1,4}$',
	];

	return $regexes[$regexName] ? $regexes[$regexName] : null;
}