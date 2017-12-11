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

/**
 * @param string $number
 * @param string $currencyMain
 * @param string $currencySecondary
 * @return string
 */
function getMoneyFormatText($number, $currencyMain = ROUBLES, $currencySecondary = KOPEKS)
{
	$moneyParts = getMoneyParts($number);
	$mainMoneyText = $moneyParts[0] . ' ' . getCurrencyWordForm($moneyParts[0], $currencyMain);
	$secondaryMoneyText = '';
	if (strlen($moneyParts[1]) > 0 && $moneyParts[1] != '00')
		$secondaryMoneyText = ' ' . $moneyParts[1] . ' ' . getCurrencyWordForm($moneyParts[1], $currencySecondary);
	return $mainMoneyText . $secondaryMoneyText;
}

/**
 * @param string $number
 * @param string $currency
 * @return string
 */
function getCurrencyWordForm($number, $currency = ROUBLES)
{
	$twoLastNumbers = mb_substr(strval($number), -2, 2);
	$lastNumber = mb_substr(strval($twoLastNumbers), -1, 1);
	$teens = ['11', '12', '13', '14'];
	if ($lastNumber == '1' && !in_array($twoLastNumbers, $teens))
		$form = 0;
	elseif (in_array($lastNumber, ['2','3','4']) && !in_array($twoLastNumbers, $teens))
		$form = 1;
	else
		$form = 2;
	return getNameForm($currency, $form);
}

/**
 * @param string $number
 * @return array
 */
function getMoneyParts($number, $separateThousands = true)
{
	$thousandsSeparator = $separateThousands ? ' ' : '';
	$number = number_format($number, 2, '.', $thousandsSeparator);
	preg_match_all('/' . getRegex('moneyGroups') . '/', $number, $matches, PREG_PATTERN_ORDER);
	return [$matches[1][0], $matches[2][0]];
}


/**
 * @param string $number
 * @param string $currencyMain
 * @param string $currencySecondary
 * @return string
 */
function getMoneyWordFormatText($number, $currencyMain = ROUBLES, $currencySecondary = KOPEKS)
{
	$moneyParts = getMoneyParts($number);
	$mainMoneyWord = getNumberWords($moneyParts[0]);
	$secondaryMoneyWord = getNumberWords($moneyParts[1]);
	$mainCurrencyText = getCurrencyWordForm($moneyParts[0], $currencyMain);
	$secondaryMoneyText = '';
	if (strlen($moneyParts[1]) > 0 && $moneyParts[1] != '00')
		$secondaryMoneyText = getCurrencyWordForm($moneyParts[1], $currencySecondary);
	return correctFemaleGender($mainMoneyWord . ' ' . $mainCurrencyText . ' ' . $secondaryMoneyWord . ' ' . $secondaryMoneyText . PHP_EOL);
}

/**
 * @param string $text
 * @return string
 */
function correctFemaleGender($text)
{
	$correctionTable = [
		'один тысяча' => 'одна тысяча',
		'два тысячи' => 'две тысячи',
		'один копейка' => 'одна копейка',
		'два копейки' => 'две копейки',
	];
	return strtr($text, $correctionTable);
}

/**
 * @param string $number
 * @return string
 */
function getNumberWords($number)
{
	if (!isset($number))
		return '';
	$result = [];
	$explodedMain = explode(' ', $number);
	$thousandsPower = count($explodedMain);
	foreach ($explodedMain as $numberParts)
	{
		$littleNumbers[] = getLittleNumberInWords($numberParts);
	}
	$bigNumbers = getBigNumberInWords($explodedMain, $thousandsPower);
	for ($i = 0; $i < count($bigNumbers); $i++)
	{
		if ($littleNumbers[$i] != '')
		{
			$result[] = $littleNumbers[$i];
			$result[] = $bigNumbers[$i];
		}

	}
	$result = array_diff($result, ['']);
	return implode(' ', $result);
}

/**
 * @param array $dividedByThousandsNumber
 * @param integer $thousandsPower
 * @return array
 */
function getBigNumberInWords($dividedByThousandsNumber, $thousandsPower)
{
	$numbersNames = [TRILLION, BILLION, MILLION, THOUSAND, ''];
	$text = [];
	$neededNumberNames = array_slice($numbersNames, 0 - $thousandsPower);
	for ($i = 0; $i < $thousandsPower; $i++)
	{
		$text[] = getCurrencyWordForm($dividedByThousandsNumber[$i], $neededNumberNames[$i]);
	}
	return $text;
}

/**
 * Именует числа, до 999
 * @param string $number
 * @return string
 */
function getLittleNumberInWords($number)
{
	$textsNumbersArray = [];
	$digits = getDigitsFromNumber($number);
	$twoLastNumbers = mb_substr(strval($number), -2, 2);
	if (isset($digits[2]))
		$textsNumbersArray[] = HUNDRETS[$digits[2]];
	if (array_key_exists($twoLastNumbers, TEENS))
	{
		$textsNumbersArray[] = TEENS[$twoLastNumbers];
		$textsNumbersArray = array_diff($textsNumbersArray, array(''));
		return implode(' ', $textsNumbersArray);
	}
	if (isset($digits[1]))
		$textsNumbersArray[] = TENS[$digits[1]];
	if (isset($digits[0]))
		$textsNumbersArray[] = ONES[$digits[0]];
	$textsNumbersArray = array_diff($textsNumbersArray, array(''));
	return implode(' ', $textsNumbersArray);
}

/**
 * @param string $search
 * @param string $replace
 * @param string $subject
 * @return string
 */
function strLastReplace($search, $replace, $subject)
{
	$result = '';
	$lastPosition = strrpos($subject, $search);
	if($lastPosition !== false)
		$result = substr_replace($subject, $replace, $lastPosition, strlen($search));
	return $result;
}