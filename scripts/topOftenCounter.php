<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 *
 * Написать программу, принимающую на вход последовательность аргументов. Программа должна вывести 5 наиболее
 * часто встречающихся аргументов (или меньше, если было введено менее 5 различных аргументов) и кол-ва повторений
 * для них.
 */

$topNumber = 5;
$userInput = array_slice($argv,1);

if (!$userInput)
{
	echo "Не введено агрументов." . PHP_EOL . "Пример: \n\tphp topOftenCounter.php 1 2 a b fff 23 1 2" . PHP_EOL;
	exit;
}

$countedElements = array_count_values($userInput);
arsort($countedElements);

foreach (array_slice($countedElements, 0, $topNumber, $preserve_keys=true) as $element => $elementCount)
{
	echo  "Argument '" . $element . "' count: " . $elementCount . PHP_EOL;
}
