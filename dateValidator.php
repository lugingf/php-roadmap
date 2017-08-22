<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая получает аргументами список дат вида "31.12.2015" и проверяет их на корректность.
 * По каждому аргументу вывести результат проверки - ок или нет. Учитывать число дней в месяце и високосность года.
 */

include 'inputOutputTools.php';
include 'validatingFormatTools.php';

$noArgsText = "Не введены аргументы.";
$errorArgsText = "Неверный формат даты:";
$dateDelimeter = '.';
$templateForInputDataValidator = '^[\d]{1,2}[' . $dateDelimeter . '][\d]{1,2}[' . $dateDelimeter . '][\d]{1,4}$';
$exampleText = "Пример: php dateValidator.php 31.12.2017 01.02.2000";
$datesTexts = [];

$userInput = array_slice($argv, 1);
if (!$userInput)
{
	sendDataToStderr($noArgsText, $exampleText);
	exit(1);
}

foreach ($userInput as $date)
{
	$dateValid = true;
	$formatValid = true;
	$explodedDate = explode($dateDelimeter, $date);
	if (count($explodedDate) <> 3 || !checkdate($explodedDate[1], $explodedDate[0], $explodedDate[2]))
		$dateValid = false;
	if (!preg_match('/' . $templateForInputDataValidator . '/', $date))
		$formatValid = false;
	$datesTexts[] = "Дата " . $date . ($dateValid ? " корректна" : " не корректна") . (!$formatValid ? ", неверный формат записи" : null) . PHP_EOL;
}

foreach ($datesTexts as $dateText)
{
	 sendDataToStdOut($dateText);
}