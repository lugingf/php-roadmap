<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, которая переводит слова в underscore-нотации в CamelCase (a_set_of_words -> ASetOfWords)
 * и наоборот. Слова считывать из стандартного ввода, для каждого слова выбирать подходящий режим
 * (т.е. "a_word AnotherWord" - корректный ввод, должен преобразоваться в "AWord another_word").
 *
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\StringTools;

$noArgsText = "Не введены аргументы.";

$userInput = InputOutputTools::getDataFromStdin('Введите текст: ');

if (!$userInput)
{
	InputOutputTools::sendDataToStderr($noArgsText);
	exit(1);
}

foreach (explode(" ", $userInput) as $word)
{
	// Если в строке есть подчеркивание, то однозначно считаем что это underscore нотация. Плюс занижаем все заглавные.
	if (preg_match('/_/', $word))
		InputOutputTools::sendDataToStdOut(StringTools::underscoreToCamel($word) . PHP_EOL);
	elseif (preg_match('/[A-Z]/', $word))
		InputOutputTools::sendDataToStdOut(StringTools::camelCaseToUnderscore($word) . PHP_EOL);
	else
		InputOutputTools::sendDataToStdOut($word . PHP_EOL);
}
