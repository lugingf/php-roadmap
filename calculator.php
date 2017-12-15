<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая считывает из стандартного ввода арифметическое выражение и выводит его результат.
 * Считать, что арифметическое выражение может состоять из целых чисел, знаков "+", "-", "*" и скобок произвольной
 * вложенности.
 */

include 'tools/inputOutputTools.php';
include 'tools/textsTemplates.php';
include 'oop/CalculatorString.class.php';

if (!isset($argv[1]))
{
	sendDataToStderr(getPhrase('noArgsText') ."\n". getPhrase('example') . $argv[0] . ' ' . getPhrase('arithmeticExample'));
	exit(1);
}

$userInput = trim(implode("", array_slice($argv, 1)), '"\'');

try
{
	$calculationResult = CalculatorString::calculateString($userInput);
}
catch (\Exception $e)
{
	sendDataToStderr($e);
	exit();
}
sendDataToStdOut($userInput . ' = ' . $calculationResult);


