<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */
namespace ELT;

class StringTools
{
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
	public static function underscoreToCamel($word)
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
	public static function camelCaseToUnderscore($word)
	{
		$word = lcfirst($word);
		return	strtolower(preg_replace('/([A-Z])/', '_\\1', $word));
	}

	/**
	 * @param string $text
	 * @return null|string
	 */
	public static function getKeyboardSwitchFunction($text)
	{
		if (preg_match('/[А-Яа-яЁё]/u', $text))
			return 'self::switchToEng';
		if (preg_match('/[A-Za-z]/', $text))
			return 'self::switchToRus';
		return null;
	}

	/**
	 * @param string $word
	 * @param array $keyboard
	 * @return string
	 */
	public static function switchToEng($word)
	{
		return strtr($word, self::DEFAULT_KEYBOARD);
	}

	/**
	 * @param string $word
	 * @param array $keyboard
	 * @return string
	 */
	public static function switchToRus($word)
	{
		return strtr($word, array_flip(self::DEFAULT_KEYBOARD));
	}

	/**
	 * @param string $number
	 * @param string $currencyMain
	 * @param string $currencySecondary
	 * @return string
	 */
	public static function getMoneyFormatText($number, $currencyMain = TextsTemplates::ROUBLES, $currencySecondary = TextsTemplates::KOPEKS)
	{
		$moneyParts = self::getMoneyParts($number);
		$mainMoneyText = $moneyParts[0] . ' ' . self::getCurrencyWordForm($moneyParts[0], $currencyMain);
		$secondaryMoneyText = '';
		if (strlen($moneyParts[1]) > 0 && $moneyParts[1] != '00')
			$secondaryMoneyText = ' ' . $moneyParts[1] . ' ' . self::getCurrencyWordForm($moneyParts[1], $currencySecondary);
		return $mainMoneyText . $secondaryMoneyText;
	}

	/**
	 * @param string $number
	 * @param string $currency
	 * @return string
	 */
	public static function getCurrencyWordForm($number, $currency = TextsTemplates::ROUBLES)
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
		return TextsTemplates::getNameForm($currency, $form);
	}

	/**
	 * @param string $number
	 * @return array
	 */
	public static function getMoneyParts($number, $separateThousands = true)
	{
		$thousandsSeparator = $separateThousands ? ' ' : '';
		$number = number_format($number, 2, '.', $thousandsSeparator);
		preg_match_all('/' . TextsTemplates::getRegex('moneyGroups') . '/', $number, $matches, PREG_PATTERN_ORDER);
		return [$matches[1][0], $matches[2][0]];
	}


	/**
	 * @param string $number
	 * @param string $currencyMain
	 * @param string $currencySecondary
	 * @return string
	 */
	public static function getMoneyWordFormatText($number, $currencyMain = TextsTemplates::ROUBLES, $currencySecondary = TextsTemplates::KOPEKS)
	{
		$moneyParts = self::getMoneyParts($number);
		$mainMoneyWord = self::getNumberWords($moneyParts[0]);
		$secondaryMoneyWord = self::getNumberWords($moneyParts[1]);
		$mainCurrencyText = self::getCurrencyWordForm($moneyParts[0], $currencyMain);
		$secondaryMoneyText = '';
		if (strlen($moneyParts[1]) > 0 && $moneyParts[1] != '00')
			$secondaryMoneyText = self::getCurrencyWordForm($moneyParts[1], $currencySecondary);
		return self::correctFemaleGender($mainMoneyWord . ' ' . $mainCurrencyText . ' ' . $secondaryMoneyWord . ' ' . $secondaryMoneyText . PHP_EOL);
	}

	/**
	 * @param string $text
	 * @return string
	 */
	public static function correctFemaleGender($text)
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
	public static function getNumberWords($number)
	{
		if (!isset($number))
			return '';
		$result = [];
		$explodedMain = explode(' ', $number);
		$thousandsPower = count($explodedMain);
		foreach ($explodedMain as $numberParts)
		{
			$littleNumbers[] = self::getLittleNumberInWords($numberParts);
		}
		$bigNumbers = self::getBigNumberInWords($explodedMain, $thousandsPower);
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
	public static function getBigNumberInWords($dividedByThousandsNumber, $thousandsPower)
	{
		$numbersNames = [TextsTemplates::TRILLION, TextsTemplates::BILLION, TextsTemplates::MILLION, TextsTemplates::THOUSAND, ''];
		$text = [];
		$neededNumberNames = array_slice($numbersNames, 0 - $thousandsPower);
		for ($i = 0; $i < $thousandsPower; $i++)
		{
			$text[] = self::getCurrencyWordForm($dividedByThousandsNumber[$i], $neededNumberNames[$i]);
		}
		return $text;
	}

	/**
	 * Именует числа, до 999
	 * @param string $number
	 * @return string
	 */
	public static function getLittleNumberInWords($number)
	{
		$textsNumbersArray = [];
		$digits = NumericTools::getDigitsFromNumber($number);
		$twoLastNumbers = mb_substr(strval($number), -2, 2);
		if (isset($digits[2]))
			$textsNumbersArray[] = TextsTemplates::HUNDRETS[$digits[2]];
		if (array_key_exists($twoLastNumbers, TextsTemplates::TEENS))
		{
			$textsNumbersArray[] = TextsTemplates::TEENS[$twoLastNumbers];
			$textsNumbersArray = array_diff($textsNumbersArray, array(''));
			return implode(' ', $textsNumbersArray);
		}
		if (isset($digits[1]))
			$textsNumbersArray[] = TextsTemplates::TENS[$digits[1]];
		if (isset($digits[0]))
			$textsNumbersArray[] = TextsTemplates::ONES[$digits[0]];
		$textsNumbersArray = array_diff($textsNumbersArray, array(''));
		return implode(' ', $textsNumbersArray);
	}

	/**
	 * @param string $search
	 * @param string $replace
	 * @param string $subject
	 * @return string
	 */
	public static function strLastReplace($search, $replace, $subject)
	{
		$result = '';
		$lastPosition = strrpos($subject, $search);
		if($lastPosition !== false)
			$result = substr_replace($subject, $replace, $lastPosition, strlen($search));
		return $result;
	}

	/**
	 * @param string $text
	 * @return string
	 */
	static function getSeparatedPunctuation(string $text): string
	{
		// для простоты эксперимента я введу два нужных нам символа для фильтра. Потому что при использовании \W
		// из-за кирилицы плывет кодировка
		return preg_filter(['/[,!]/'], ' $0', $text);
	}

	/**
	 * @param string $text
	 * @return string
	 */
	static function getNonSeparatedPunctuation(string $text): string
	{
		return preg_filter(['/ ([,!])/'], '$1', $text);
	}


}

