<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая считывает из стандартного ввода целое число и выводит его факториал
 */

require_once __DIR__ . '/../init.php';

$userInput = InputOutputTools::getDataFromStdin(TextsTemplates::getPhrase('enterIntNumber'));

if (!$userInput && $userInput != 0)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText'));
	exit(1);
}

if (preg_match('/\D/', $userInput))
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('badAgrs') . $userInput);
	exit(1);
}

InputOutputTools::sendDataToStdOut(NumericTools::getFactorial($userInput) . PHP_EOL);