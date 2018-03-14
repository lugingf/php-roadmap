<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая считывает из стандартного ввода арифметическое выражение и выводит его результат.
 * Считать, что арифметическое выражение может состоять из целых чисел, знаков "+", "-", "*" и скобок произвольной
 * вложенности.
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\TextsTemplates;
use EL\CalculatorString;

if (!isset($argv[1]))
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText') ."\n". TextsTemplates::getPhrase('example') . $argv[0] . ' ' . TextsTemplates::getPhrase('arithmeticExample'));
	exit(1);
}

$userInput = trim(implode("", array_slice($argv, 1)), '"\'');

try
{
	$calculationResult = CalculatorString::calculateString($userInput);
}
catch (\Exception $e)
{
	InputOutputTools::sendDataToStderr($e);
	exit();
}
InputOutputTools::sendDataToStdOut($userInput . ' = ' . $calculationResult);


