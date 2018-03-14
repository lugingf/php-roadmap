<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */
namespace ELT;

class TextsTemplates
{
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
	public static function getPhrase($textName)
	{
		$templates = [
			// common
			'typeText' => 'Введите текст',
			'noArgsText' => 'Не введены аргументы.',
			'example' => 'Пример: php ',
			'logScannerExample' =>
				"php tasksFromBashRoadmap.php a \t\t\t- статистика числа ошибок за вчерашний день с группировкой по серверам\n" .
				"php tasksFromBashRoadmap.php b Москва Питер \t- необходимо указать города - раскупаемость направлений\n" .
				"php tasksFromBashRoadmap.php c 12.07.2016 \t- процент ответов кэша на detail-запросы\n" .
				"php tasksFromBashRoadmap.php d 4.10.2017 \t- кол-во чашек чая на бою за последние 2 недели\n" .
				"php tasksFromBashRoadmap.php e \t\t\t- статистика по обращениям к deprecated",
			'inviteTranslit' => 'Введите текст кирилицей: ',
			'inviteText' => 'Введите текст: ',
			'enterIntNumber' => 'Введите положительное целое число',
			'noFile' => 'Файл не найден',
			'noLogAction' => 'Операция не определена',

			// dates texts
			'wrongDateFormat' => ', неверный формат даты:',
			'dateFormatExample' => ' 31.12.2017 01.02.2000',
			'badAgrs' => 'Неверные аргументы: ',
			// money
			'enterNumberLess' => 'Введите число менее 99999999999999:',
			// about arithmetic
			'arithmeticExample' => '"2+2*(-1)" -отрицательные числа обязательно писать в скобках, если используете скобки, ' .
				'то весь пример заключайте в кавычки',

		];

		return $templates[$textName] ?? '';
	}

	/**
	 * @param string $regexName
	 * @return string|null
	 */
	public static function getRegex($regexName)
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
	public static function getNameForm($word, $form)
	{
		$words = [
			self::ROUBLES   =>  ['рубль',     'рубля',     'рублей'],
			self::KOPEKS    =>  ['копейка',   'копейки',   'копеек'],
			self::THOUSAND  =>  ['тысяча',    'тысячи',    'тысяч'],
			self::MILLION   =>  ['миллион',   'миллиона',  'миллионов'],
			self::BILLION   =>  ['милиард',   'милиарда',  'миллиардов'],
			self::TRILLION  =>  ['триллион',  'триллиона', 'триллионов'],
		];
		return $words[$word][$form] ?? '';
	}

}

