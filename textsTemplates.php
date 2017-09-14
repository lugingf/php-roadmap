<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */


const ROUBLES = 'RUB';
const KOPEKS = 'KOP';


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
		'inviteTranslit' => 'Введите текст кирилицей: ',
		'inviteText' => 'Введите текст: ',

		// dates texts
		'wrongDateFormat' => ', неверный формат даты:',
		'dateFormatExample' => ' 31.12.2017 01.02.2000',
		'badAgrs' => 'Неверные аргументы: ',

	];

	return $templates[$textName] ?? '';
}

/**
 * @param string $regexName
 * @return string|null
 */
function getRegex($regexName)
{
	$regexes = [
		'dateTemplate' => '^[\d]{1,2}\.[\d]{1,2}\.[\d]{1,4}$',
		'moneyTemplate' => '^[ \d]+(\.[\d]+)?',
		'moneyGroups' => '^([ \d]+)\.?([\d]{0,2})?',
	];

	return $regexes[$regexName] ?? null;
}

/**
 * @param string $currency
 * @param integer $form
 * @return string
 */
function getCurrencyName($currency, $form)
{
	$currencies = [
		ROUBLES => ['рубль','рубля','рублей'],
		KOPEKS => ['копейка','копейки','копеек'],
	];
	return $currencies[$currency][$form] ?? '';
}