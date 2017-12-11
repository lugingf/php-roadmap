<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая построит аналогичное xml-представление для дерева файлов папки lib проекта tutu
 */

include 'tools/commonTools.php';
include 'tools/inputOutputTools.php';
include 'tools/textsTemplates.php';
include 'oop/XMLCreater.class.php';
include 'tools/stringTools.php';

$userInput = '/home/lugin/devel/projects/tutu/lib';

if (!$userInput)
{
	sendDataToStderr(getPhrase('noArgstext'));
	exit(1);
}

if (!file_exists($userInput))
{
	sendDataToStderr(getPhrase('noFile'));
	exit(1);
}


$explodedInput = getDirectoryContentInArray($userInput);
$temporaryStructure = XMLCreater::createDeepArray($explodedInput, '/', '+FILE_FROM_PATH_DIVIDER+', true);
$xmlStructure =  XMLCreater::createXMLFromArray($temporaryStructure);

$resultFile = fopen('../resultTutu.xml', 'w');
fwrite($resultFile, $xmlStructure);
fclose($resultFile);




