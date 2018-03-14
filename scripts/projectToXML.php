<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая построит аналогичное xml-представление для дерева файлов папки lib проекта tutu
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\TextsTemplates;
use ELT\CommonTools;
use EL\XMLCreater;

$userInput = '/home/lugin/devel/projects/tutu/lib';

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


$explodedInput = CommonTools::getDirectoryContentInArray($userInput);
$temporaryStructure = XMLCreater::createDeepArray($explodedInput, '/', '+FILE_FROM_PATH_DIVIDER+', true);
$xmlStructure =  XMLCreater::createXMLFromArray($temporaryStructure);

$resultFile = fopen('../resultTutu.xml', 'w');
fwrite($resultFile, $xmlStructure);
fclose($resultFile);




