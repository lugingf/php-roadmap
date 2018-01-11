<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, конвертирующую слова по принципу "Punto Switcher", т.е. из латиницы в кириллицу и наоборот.
 * Слова программа читает из стандартного ввода, раскладку каждого слова определяет автоматически по буквам в слове.
 * Конвертирует весь ввод вне зависимости от того, в правильной он раскладке или нет.
 */

require_once __DIR__ . '/../init.php';

$userInput = InputOutputTools::getDataFromStdin(TextsTemplates::getPhrase('inviteText'));
if (!$userInput)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText'));
	exit(1);
}

$userWords = explode(' ', $userInput);
$outputWords = [];
foreach ($userWords as $word)
{
	$switchDirection = StringTools::getKeyboardSwitchFunction($word);
	if ($switchDirection)
		$word = call_user_func($switchDirection, $word);
	$outputWords[] = $word;
}
InputOutputTools::sendDataToStdOut(implode(' ', $outputWords) . PHP_EOL);
