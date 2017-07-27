<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, принимающую в качестве аргументов произвольную последовательность целых чисел и выводящую эти числа
 * в обратном порядке
 * в порядке возрастания
 * в порядке убывания
 * К программе из п. 4 добавить вывод доли (в %) каждого числа от суммы всех введенных чисел. Дробные числа округлять
 * до 2 знаков после запятой
 *
 * К программе из п. 5 добавить проверку, что все, что вводит пользователь, является целым числом.
 * В случае ошибки программа должна сообщать, какой именно аргумент плохой (выводить его значение) и завершаться без
 * дальнейших вычислений. Вывод информации об ошибке должен происходить в стандартный поток ошибок (STDERR)
 *
 */

$userNumbers = array_slice($argv,1);

if (!$userNumbers)
{
	$badArgsPresentText = "Не введены подходящие аргументы. Пример: php numberSorter.php 1 2 3 4 5 6" . PHP_EOL;
	fwrite(STDERR, $badArgsPresentText);
	exit;
}

if ($badElements = implode(" ", getNotIntegers($userNumbers)))
{
	$badArgsListText = "Неверные аргументы: " . $badElements . PHP_EOL;
	fwrite(STDERR, $badArgsListText);
	exit;
}


$reversedString = implode(" ", array_reverse($userNumbers));
asort($userNumbers);
$increasingString = implode(" ", $userNumbers);
arsort($userNumbers);
$decreasingString = implode(" ", $userNumbers);

echo "Обратный порядок: " . $reversedString . PHP_EOL;
echo "По возрастанию: " . $increasingString . PHP_EOL;
echo "По убыванию: " . $decreasingString . PHP_EOL;

$numbersSum = array_sum($userNumbers);
if ($numbersSum <= 0)
{
	echo "Сумма всех элементов меньше или равна нулю. Корректно посчитать процент каждого числа от суммы всех введенных чисел нельзя" . PHP_EOL;
	exit;
}


foreach ($userNumbers as $number)
{
	if ($number < 0)
		echo "Корретно посчитать процент отрицательного числа " . $number . " от суммы всех введенных чисел нельзя" . PHP_EOL;
	else
	{
		$percentage = round(($number / $numbersSum) * 100, 2);
		echo "Число " . $number . " составляет " . $percentage . "% от общей суммы" . PHP_EOL;
	}
}


function getNotIntegers($arr)
{
	$res_arr = [];
	foreach ($arr as $arrayElement)
	{
		if(!preg_match('/^[-]?[\d]+$/', $arrayElement))
    		array_push($res_arr, $arrayElement);
	}
	return $res_arr;
}