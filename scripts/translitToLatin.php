<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая транслитерирует кириллический текст, читая его из стандартного ввода и выплевывая результат в стандартный вывод.
 */

require_once __DIR__ . '/../init.php';

use \ELT\InputOutputTools;
use \ELT\TextsTemplates;

$userText = InputOutputTools::getDataFromStdin(TextsTemplates::getPhrase('inviteTranslit'));
if (!$userText)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText'));
	exit(1);
}

echo transliterator_transliterate("Any-Latin", $userText) . PHP_EOL;