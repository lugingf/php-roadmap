<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая считывает из стандартного ввода целое число и выводит число Фибоначчи с соответствующим
 * порядковым номером.
 */



include 'oop/Fibonachchi.class.php';
include 'tools/inputOutputTools.php';
include 'tools/textsTemplates.php';
include 'tools/numericTools.php';

$userInput = getDataFromStdin(getPhrase('enterIntNumber'));

if (!$userInput)
{
	sendDataToStderr(getPhrase('noArgsText'));
	exit(1);
}

if (preg_match('/\D/', $userInput))
{
	sendDataToStderr(getPhrase('badAgrs') . $userInput);
	exit(1);
}

$fibonachchiNumber = (new Fibonachchi())->getFibonachchiNumber($userInput);
sendDataToStdOut($fibonachchiNumber . PHP_EOL);