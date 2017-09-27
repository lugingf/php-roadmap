<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая получает список дат аналогично п. 2 и выводит корректные даты в хронологическом порядке
 */

include 'tools/inputOutputTools.php';
include 'tools/validatingFormatTools.php';
include 'tools/dateTools.php';
include 'tools/textsTemplates.php';

$userInput = array_slice($argv, 1);
if (!$userInput)
{
	sendDataToStderr(getPhrase('noArgsText'), getPhrase('example') . $argv[0] . getPhrase('dateFormatExample'));
	exit(1);
}

foreach ($userInput as $date)
{
	$formatValid = preg_match('/' . getRegex('dateTemplate') . '/', $date) ? true : false;
	if (!$formatValid || !validateDateConsistent('.', $date))
		continue;
	$explodedDate = explode('.', $date);
	$correctDates[] = mktime(0,0,0, $explodedDate[1], $explodedDate[0], $explodedDate[2]);
}

sort($correctDates);
foreach ($correctDates as $date)
{
	$dateText = strftime('%d.%m.%Y', $date);
	sendDataToStdOut($dateText . PHP_EOL);
}