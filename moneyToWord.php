<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая получает на вход число аналогично п.6, но выводит сумму полностью словами,
 * "1263.34 -> одна тысяча двести шестьдесят три рубля тридцать четыре копейки".
 *  Программа должна осиливать суммы как минимум исчисляющиеся сотнями миллионов (улыбка)
 * (Обратить внимание на возможное отсутствие некоторых разрядов: 1000000 -> "один миллион рублей")
 */

include 'tools/inputOutputTools.php';
include 'tools/textsTemplates.php';
include 'tools/stringTools.php';
include 'tools/numericTools.php';

$userInput = getDataFromStdin(getPhrase('enterNumberLess'));

if (!$userInput)
{
	sendDataToStderr(getPhrase('noArgsText'));
	exit(1);
}

if (!preg_match('/' . getRegex('moneyTemplate') . '/', $userInput) || intval($userInput) >= 100000000000000)
{
	sendDataToStderr(getPhrase('badAgrs') . $userInput);
	exit(1);
}

sendDataToStdOut($userInput . ' -> ' . getMoneyWordFormatText($userInput));
