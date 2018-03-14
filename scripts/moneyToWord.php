<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая получает на вход число аналогично п.6, но выводит сумму полностью словами,
 * "1263.34 -> одна тысяча двести шестьдесят три рубля тридцать четыре копейки".
 *  Программа должна осиливать суммы как минимум исчисляющиеся сотнями миллионов (улыбка)
 * (Обратить внимание на возможное отсутствие некоторых разрядов: 1000000 -> "один миллион рублей")
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\TextsTemplates;
use ELT\StringTools;

$userInput = InputOutputTools::getDataFromStdin(TextsTemplates::getPhrase('enterNumberLess'));

if (!$userInput)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText'));
	exit(1);
}

if (!preg_match('/' . TextsTemplates::getRegex('moneyTemplate') . '/', $userInput) || intval($userInput) >= 100000000000000)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('badAgrs') . $userInput);
	exit(1);
}

InputOutputTools::sendDataToStdOut($userInput . ' -> ' . StringTools::getMoneyWordFormatText($userInput));
