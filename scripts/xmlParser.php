<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая совершает обратные п.4 действия: считывает из файла xml-структуру и выводит значения
 * всех "листьев" (элементов, у которых нет дочерних элементов)
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\TextsTemplates;
use EL\XML2NodeSpecConverter;

if (!isset($argv[1]))
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText'));
	exit(1);
}

$userInput = $argv[1];

if (!file_exists($userInput))
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noFile'));
	exit(1);
}

$text = file_get_contents($userInput);

$temporaryStructure = XML2NodeSpecConverter::getDeepArrayFromXML($text);
$xmlStructureText = XML2NodeSpecConverter::getStringFromDeepArray($temporaryStructure);

$resultFile = fopen('../result.txt', 'w');

fwrite($resultFile, $xmlStructureText);
fclose($resultFile);