<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу для решения задачи о ханойских башнях (https://ru.wikipedia.org/wiki/Ханойская_башня).
 * Пусть есть стержни A, B, C, нам нужно перенести N дисков со стержня A на C. Число N вводит пользователь,
 * программа построчно должна распечатать последовательность перекладываний дисков (напр. "A to B; A to C; B to C"
 * для N = 2).
 */

require_once __DIR__ . '/../init.php';

use ELT\InputOutputTools;
use ELT\TextsTemplates;
use EL\TowerOfHanoi;

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

$fromPole = 'A';
$bufferPole = 'B';
$toPole = 'C';

$diskCount = $userInput;

InputOutputTools::sendDataToStdOut(TowerOfHanoi::getMovementsOrder($diskCount, $fromPole, $toPole, $bufferPole));