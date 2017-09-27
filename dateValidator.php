<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая получает аргументами список дат вида "31.12.2015" и проверяет их на корректность.
 * По каждому аргументу вывести результат проверки - ок или нет. Учитывать число дней в месяце и високосность года.
 */

include 'tools/inputOutputTools.php';
include 'tools/validatingFormatTools.php';
include 'tools/dateTools.php';
include 'tools/textsTemplates.php';

$datesTexts = [];
$userInput = array_slice($argv, 1);
if (!$userInput)
{
	sendDataToStderr(getPhrase('noArgsText'), getPhrase('example') . $argv[0] . getPhrase('dateFormatExample'));
	exit(1);
}

foreach ($userInput as $date)
{
	$formatValid = preg_match('/' . getRegex('dateTemplate') . '/', $date) ? true : false;
	$dateValid = ($formatValid && validateDateConsistent('.', $date));
	$datesTexts[] = "Дата " . $date . ($dateValid ? " корректна" : " не корректна") . (!$formatValid ? getPhrase('wrongDateFormat') : null) . PHP_EOL;
}

foreach ($datesTexts as $dateText)
{
	 sendDataToStdOut($dateText);
}