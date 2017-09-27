<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая транслитерирует кириллический текст, читая его из стандартного ввода и выплевывая результат в стандартный вывод.
 */

include 'tools/inputOutputTools.php';
include 'tools/stringTools.php';
include 'tools/textsTemplates.php';

$userText = getDataFromStdin(getPhrase('inviteTranslit'));
if (!$userText)
{
	sendDataToStderr(getPhrase('noArgsText'));
	exit(1);
}

echo transliterator_transliterate("Any-Latin", $userText) . PHP_EOL;