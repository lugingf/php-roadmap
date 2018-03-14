<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая считывает из стандартного ввода целое число и выводит число Фибоначчи с соответствующим
 * порядковым номером.
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\TextsTemplates;
use EL\Fibonachchi;

$userInput = InputOutputTools::getDataFromStdin(TextsTemplates::getPhrase('enterIntNumber'));

if (!$userInput)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText'));
	exit(1);
}

if (preg_match('/\D/', $userInput))
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('badAgrs') . $userInput);
	exit(1);
}

$fibonachchiNumber = (new Fibonachchi())->getFibonachchiNumber($userInput);
InputOutputTools::sendDataToStdOut($fibonachchiNumber . PHP_EOL);