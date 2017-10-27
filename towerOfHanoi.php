<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * Написать программу для решения задачи о ханойских башнях (https://ru.wikipedia.org/wiki/Ханойская_башня).
 * Пусть есть стержни A, B, C, нам нужно перенести N дисков со стержня A на C. Число N вводит пользователь,
 * программа построчно должна распечатать последовательность перекладываний дисков (напр. "A to B; A to C; B to C"
 * для N = 2).
 */

include 'tools/inputOutputTools.php';
include 'tools/textsTemplates.php';
include 'oop/TowerOfHanoi.class.php';

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

$fromPole = 'A';
$bufferPole = 'B';
$toPole = 'C';

$diskCount = $userInput;

sendDataToStdOut(TowerOfHanoi::getMovementsOrder($diskCount, $fromPole, $toPole, $bufferPole));