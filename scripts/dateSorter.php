<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая получает список дат аналогично п. 2 и выводит корректные даты в хронологическом порядке
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\TextsTemplates;
use ELT\DateTools;

$userInput = array_slice($argv, 1);
if (!$userInput)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText'), TextsTemplates::getPhrase('example') . $argv[0] . TextsTemplates::getPhrase('dateFormatExample'));
	exit(1);
}

foreach ($userInput as $date)
{
	$formatValid = preg_match('/' . TextsTemplates::getRegex('dateTemplate') . '/', $date) ? true : false;
	if (!$formatValid || !DateTools::validateDateConsistent('.', $date))
		continue;
	$explodedDate = explode('.', $date);
	$correctDates[] = mktime(0,0,0, $explodedDate[1], $explodedDate[0], $explodedDate[2]);
}

sort($correctDates);
foreach ($correctDates as $date)
{
	$dateText = strftime('%d.%m.%Y', $date);
	InputOutputTools::sendDataToStdOut($dateText);
}