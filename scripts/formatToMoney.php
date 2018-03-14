<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу, которая считывает из стандартного ввода число с плавающей точкой и выводит его в "денежном"
 * формате по принципу: "1234567.81 -> 1 234 567 рублей 81 копейка", "1263.34 -> 1 263 рубля 34 копейки" и т.д.
 * (обратить внимание на отделение разрядов пробелами и на форму слов в зависимости от числительного).
 * Если копеек нет, не выводить по ним инфу.
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\TextsTemplates;
use ELT\StringTools;

$userInput = InputOutputTools::getDataFromStdin(TextsTemplates::getPhrase('inviteText'));

if (!$userInput)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText'));
	exit(1);
}

if (!preg_match('/' . TextsTemplates::getRegex('moneyTemplate') . '/', $userInput))
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('badAgrs') . $userInput);
	exit(1);
}

InputOutputTools::sendDataToStdOut($userInput . ' -> ' . StringTools::getMoneyFormatText($userInput) . PHP_EOL);