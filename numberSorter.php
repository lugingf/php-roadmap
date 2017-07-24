<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, принимающую в качестве аргументов произвольную последовательность целых чисел и выводящую эти числа
 * в обратном порядке
 * в порядке возрастания
 * в порядке убывания
 *
 * К программе из п. 4 добавить вывод доли (в %) каждого числа от суммы всех введенных чисел. Дробные числа округлять до 2 знаков после запятой
 *
 */

$userNumbers = array_slice($argv,1);
if (!containsOnlyIntegers($userNumbers))
{
    echo "Не введены подходящие аргументы. Пример: php numberSorter.php 1 2 3 4 5 6" . PHP_EOL;
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
	{
		echo "Корретно посчитать процент отрицательного числа " . $number . " от суммы всех введенных чисел нельзя" . PHP_EOL;
	}
	else
	{
		$percentage = round(($number/$numbersSum)*100, 2);
		echo "Число " . $number . " составляет " . $percentage . "% от общей суммы" . PHP_EOL;
	}
}




function containsOnlyIntegers($data)
{
    if (!$data)
    {
        return false;
    }
    foreach ($data as $arrayElement)
    {
        if(!preg_match('/^[-]?[\d]+$/', $arrayElement))
        {
            return false;
        }
    }
    return true;
}