<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая принимает в качестве аргументов основание системы счисления (число от 2 до 16) и
 * последовательность десятичных чисел, которые переводит в соответствующую систему счисления и выводит на экран
 * построчно в формате "<десятичное число> = <число в новой системе счисления>". Программа должна проверять аргументы
 * на корректность.
 */


$exampleText = "Например: php notationChanger.php --notation=8 1 2 3 4 5";
// Я решил, что если мы будем увеличивать число оснований для СС, но в любом случае придется дописывать им как минимум
// буквенные обозначения, поэтому вместо обычных проверок на целочисленность и т.д. есть смысл установить конечный список.
$basesCollection = ['2','3','4','5','6','7','8','9','10','11','12','13','14','15','16'];

$options = getopt('', ['notation::']);
$optionsCount =  count($options);
$userNumbers = array_slice($argv, $optionsCount+1);

if ($optionsCount < 1 || !isset($options['notation']) || !in_array($options['notation'], $basesCollection))
{
	$noNotationText = "Не указана требуемая система счисления (Принимается только число от 2 до 16)" . PHP_EOL .
					$exampleText . PHP_EOL;
	fwrite(STDERR, $noNotationText);
	exit;
}


if (!$userNumbers || getNotIntegers($userNumbers))
{
	$badArgsPresentText = "Не введены подходящие аргументы." . PHP_EOL . $exampleText . PHP_EOL;
	fwrite(STDERR, $badArgsPresentText);
	exit;
}


foreach ($userNumbers as $userNumber)
	echo $userNumber  . " = " . getNewBaseString($userNumber, $options['notation']) . PHP_EOL;


/**
 * @param $number integer
 * @param $base integer
 * @return string
 */
function getNewBaseString($number, $base)
{
	$negative = false;
	$moduloArray = [];
	$overTenthBaseSymbolsMap = [
		10 => 'A',
		11 => 'B',
		12 => 'C',
		13 => 'D',
		14 => 'E',
		15 => 'F'
	];
	if ($number == 0)
		return '0';
	if ($number < 0)
	{
		$negative = true;
		$number = str_replace("-", '', $number);
	}
	while ($number != 0)
	{
		$modulo = $number % $base;
		$moduloArray[] = ($modulo > 9) ? $overTenthBaseSymbolsMap[$modulo] : $modulo;
		$number = intdiv($number, $base);
	}
	$numberString = implode("", array_reverse($moduloArray));
	if ($negative)
		$numberString = '-' . $numberString;
	return $numberString;
}


/**
 * @param $items array
 * @return array
 */
function getNotIntegers($items)
{
	$badArguments = [];
	foreach ($items as $arrayElement)
	{
		if(!(is_numeric($arrayElement) &&  floor($arrayElement) == $arrayElement))
			array_push($badArguments, $arrayElement);
	}
	return $badArguments;
}
