<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */


const ROUBLES = 'RUB';
const KOPEKS = 'KOP';
const THOUSAND = 'THS';
const MILLION = 'MIL';
const BILLION = 'BIL';
const TRILLION = 'TRL';

const ONES = [
	'0' =>'',
	'1' =>'один',
	'2' =>'два',
	'3' =>'три',
	'4' =>'четыре',
	'5' =>'пять',
	'6' =>'шесть',
	'7' =>'семь',
	'8' =>'восемь',
	'9' =>'девять',
];
const TEENS = [
	'11' =>'одиннадцать',
	'12' =>'двенадцать',
	'13' =>'тринадцать',
	'14' =>'четырнадцать',
	'15' =>'пятнадцать',
	'16' =>'шестнадцать',
	'17' =>'семнадцать',
	'18' =>'восемнадцать',
	'19' =>'девятнадцать',
];
const HUNDRETS = [
	'0' => '',
	'1' => 'сто',
	'2' => 'двести',
	'3' => 'триста',
	'4' => 'четыреста',
	'5' => 'пятьсот',
	'6' => 'шестьсот',
	'7' => 'семьсот',
	'8' => 'восемьсот',
	'9' => 'девятьсот',
];
const TENS = [
	'0' =>'',
	'1' =>'десять',
	'2' =>'двадцать',
	'3' =>'тридцать',
	'4' =>'сорок',
	'5' =>'пятьдесят',
	'6' =>'шестьдесят',
	'7' =>'семьдесят',
	'8' =>'восемьдесят',
	'9' =>'девяносто',
];

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
		'enterIntNumber' => 'Введите положительное целое число',

		// dates texts
		'wrongDateFormat' => ', неверный формат даты:',
		'dateFormatExample' => ' 31.12.2017 01.02.2000',
		'badAgrs' => 'Неверные аргументы: ',
		// money
		'enterNumberLess' => 'Введите число менее 99999999999999:',

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
 * @param string $word
 * @param integer $form
 * @return string
 */
function getNameForm($word, $form)
{
	$words = [
		ROUBLES   =>  ['рубль',     'рубля',     'рублей'],
		KOPEKS    =>  ['копейка',   'копейки',   'копеек'],
		THOUSAND  =>  ['тысяча',    'тысячи',    'тысяч'],
		MILLION   =>  ['миллион',   'миллиона',  'миллионов'],
		BILLION   =>  ['милиард',   'милиарда',  'миллиардов'],
		TRILLION  =>  ['триллион',  'триллиона', 'триллионов'],
	];
	return $words[$word][$form] ?? '';
}
