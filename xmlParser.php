<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая совершает обратные п.4 действия: считывает из файла xml-структуру и выводит значения
 * всех "листьев" (элементов, у которых нет дочерних элементов)
 */

include 'tools/inputOutputTools.php';
include 'tools/textsTemplates.php';
include 'oop/XML2NodeSpecConverter.class.php';



if (!isset($argv[1]))
{
	sendDataToStderr(getPhrase('noArgsText'));
	exit(1);
}

$userInput = $argv[1];

if (!file_exists($userInput))
{
	sendDataToStderr(getPhrase('noFile'));
	exit(1);
}

$text = file_get_contents($userInput);

$temporaryStructure = XML2NodeSpecConverter::getDeepArrayFromXML($text);
$xmlStructureText = XML2NodeSpecConverter::getStringFromDeepArray($temporaryStructure);

$resultFile = fopen('../result.txt', 'w');

fwrite($resultFile, $xmlStructureText);
fclose($resultFile);