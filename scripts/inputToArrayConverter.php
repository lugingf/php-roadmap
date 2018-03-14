<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая считывает из стандартного ввода строку вида: "a=1; b=2; c=agfda; derp=; eee=" (
 * в конце строки точка с запятой не обязательна, ключи и значения могут содержать любые символы, кроме ";" и "=",
 * значения могут быть пустыми) и формирует массив ключ-значение, соответствующий переданной строке.
 * Результирующий массив вывести любой отладочной функцией.
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\ValidatingFormatTools;

$noArgsText = "Не введены аргументы.";
$errorArgsText = "Не подходящие аргументы:";
$templateForInputDataValidator = ".+=";
$exampleText = "Пример ввода: a=1; b=2; c=agfda; d=";
$inviteMessage = "Пожалуйста, введите значения: " . $exampleText;

$userInput = InputOutputTools::getDataFromStdin($inviteMessage);
if (!$userInput)
{
	InputOutputTools::sendDataToStderr($noArgsText, $exampleText);
	exit(1);
}

$explodedInput = explode(';', str_replace(' ', '', $userInput));
if (preg_match('/;$/', $userInput))
	$explodedInput = array_slice($explodedInput, 0, count($explodedInput)-1);
$invalidArguments = ValidatingFormatTools::getNoFormatItems( $explodedInput, $templateForInputDataValidator);
if (count($invalidArguments) > 0)
{
	$errorArgsText = $errorArgsText . ' ' . implode(', ', $invalidArguments);
	InputOutputTools::sendDataToStderr($errorArgsText, $exampleText);
	exit(1);
}

foreach ($explodedInput as $item)
{
	$explodedItem = explode("=", $item );
	$explodedItemArray[$explodedItem[0]] = $explodedItem[1];
}

foreach ($explodedItemArray as $key => $value)
{
	echo $key . ' => ' . $value . PHP_EOL;
}