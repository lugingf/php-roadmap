<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, считывающую из стандартного ввода целое число N и выдающую информацию, високосный ли год N.
 * доработать программу, чтобы она умела считывать число из аргументов командной строки, и в случае, если аргументы
 * были, уже не обращалась к стандартному вводу
 */


$exampleText = 'Пример: php leapYearChecker.php 2017';
$errorTextMapping = [
	0 => 'Вычисляем...',
	1 => 'Простите, но вы не ввели год.' . PHP_EOL . $exampleText,
	2 => 'Простите, но нулевой год и «нулевой год до н. э.» не существуют согласно григорианскому и юлианскому летоисчислениям',
	3 => 'Простите, но введенные символы не могут быть годом.' . PHP_EOL . $exampleText,
];

$leapText = 'високосный';
$notLeapText = 'не високосный';


$enteredYear = getYearFromUser($argv);
$errorCode = getYearValidatingError($enteredYear);
echo $errorTextMapping[$errorCode]. PHP_EOL;
if ($errorCode > 0)
	exit;


echo abs($enteredYear) . ' год ' . getEraText($enteredYear) . ' ';
echo isLeap($enteredYear) ? $leapText : $notLeapText;
echo PHP_EOL;


function getYearFromUser($data)
{
	$enteredYear = array_slice($data, 1, 1);
	if (!$enteredYear)
	{
		echo "Пожалуйста, укажите год: " . PHP_EOL;
		$enteredYear = trim(fgets(STDIN));
		return $enteredYear;
	}
	return is_array($enteredYear) ? $enteredYear[0] : $enteredYear;
}


function getYearValidatingError($year)
{
	$code = 0;
	if ($year == '' || is_null($year))
		$code = 1;
	elseif ($year == '0')
		$code = 2;
	elseif (!preg_match('/^[-]?[\d]+$/', $year))
		$code = 3;
	return $code;
}


function getEraText($year)
{
	return $year < 0 ? 'до н.э.' : 'н.э';
}


function isLeap($year)
{
	$leapYearsExceptions = [-45, -42, -39, -36, -33, -30, -27, -24, -21, -18, -15, -12, -9];
	if (in_array($year, $leapYearsExceptions))
		return true;
	// до 45г до н.э. не было високосных лет, 4 год н.э. так же не високосный
	if ($year < -45 || $year == 4)
		return false;
	// Смотрим Юлианский календарь
	if ($year < 1582)
		return $year % 4 == 0 ? true : false;
	// Смотрим Григорианский календарь
	if ($year % 400 == 0)
		return true;
	return $year % 4 == 0 && $year % 100 != 0 ? true : false;
}

