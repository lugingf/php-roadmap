<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая получает в качестве аргумента имя файла, откуда считывает пары ключ-значение вида:
 * "a.b.c=1; a.b.d=2; a.c.e=3; a.c.f=4; b=5" и преобразует их в xml-документ соответствующей структуры
 * (точки задают уровень вложенности узла). Считать, что нельзя задать значение a.b, если задано, например, a.b.c.
 */

require_once __DIR__ . '/../init.php';

$userInput = $argv[1];

if (!$userInput)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgstext'));
	exit(1);
}

if (!file_exists($userInput))
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noFile'));
	exit(1);
}

$sourceFile = file_get_contents($userInput);
$explodedInput = explode(';', str_replace(' ', '', trim($sourceFile, ";")));

$temporaryStructure = XMLCreater::createDeepArray($explodedInput, '.', '=');
$xmlStructure =  XMLCreater::createXMLFromArray($temporaryStructure);
$resultFile = fopen('../result.xml', 'w');

fwrite($resultFile, $xmlStructure);
fclose($resultFile);