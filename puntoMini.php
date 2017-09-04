<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, конвертирующую слова по принципу "Punto Switcher", т.е. из латиницы в кириллицу и наоборот.
 * Слова программа читает из стандартного ввода, раскладку каждого слова определяет автоматически по буквам в слове.
 * Конвертирует весь ввод вне зависимости от того, в правильной он раскладке или нет.
 */

include 'inputOutputTools.php';
include 'stringTools.php';
include 'textsTemplates.php';

$userInput = getDataFromStdin(getPhrase('inviteText'));
if (!$userInput)
{
	sendDataToStderr(getPhrase('noArgsText'));
	exit(1);
}

$userWords = explode(' ', $userInput);
$outputWords = [];
foreach ($userWords as $word)
{
	$switchDirection = getKeyboardSwitchFunction($word);
	if ($switchDirection)
		$word = call_user_func($switchDirection, $word);
	$outputWords[] = $word;
}
sendDataToStdOut(implode(' ', $outputWords) . PHP_EOL);
