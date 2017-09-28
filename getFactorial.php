<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая считывает из стандартного ввода целое число и выводит его факториал
 */

include 'tools/inputOutputTools.php';
include 'tools/textsTemplates.php';
include 'tools/numericTools.php';

$userInput = getDataFromStdin(getPhrase('enterIntNumber'));

if (!$userInput && $userInput != 0)
{
	sendDataToStderr(getPhrase('noArgsText'));
	exit(1);
}

if (preg_match('/\D/', $userInput))
{
	sendDataToStderr(getPhrase('badAgrs') . $userInput);
	exit(1);
}

sendDataToStdOut(getFactorial($userInput) . PHP_EOL);