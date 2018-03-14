<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая получает аргументами список дат вида "31.12.2015" и проверяет их на корректность.
 * По каждому аргументу вывести результат проверки - ок или нет. Учитывать число дней в месяце и високосность года.
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\TextsTemplates;
use ELT\DateTools;

$datesTexts = [];
$userInput = array_slice($argv, 1);
if (!$userInput)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText'), TextsTemplates::getPhrase('example') . $argv[0] . TextsTemplates::getPhrase('dateFormatExample'));
	exit(1);
}

foreach ($userInput as $date)
{
	$formatValid = preg_match('/' . TextsTemplates::getRegex('dateTemplate') . '/', $date) ? true : false;
	$dateValid = ($formatValid && DateTools::validateDateConsistent('.', $date));
	$datesTexts[] = "Дата " . $date . ($dateValid ? " корректна" : " не корректна") . (!$formatValid ? TextsTemplates::getPhrase('wrongDateFormat') : null) . PHP_EOL;
}

foreach ($datesTexts as $dateText)
{
	 InputOutputTools::sendDataToStdOut($dateText);
}