<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Написать программу, принимающую в качестве аргументов произвольную последовательность целых чисел и выводящую эти числа
 * в обратном порядке
 * в порядке возрастания
 * в порядке убывания
 *
 */

$userNumbers = array_slice($argv,1);
if (!isOnlyIntegers($userNumbers))
{
    echo "Не введены подходящие аргументы. Пример: php numberSorter.php 1 2 3 4 5 6" . PHP_EOL;
}
else
{
    $reversedStr = implode(" ", array_reverse($userNumbers));
    asort($userNumbers);
    $increasingStr = implode(" ", $userNumbers);
    arsort($userNumbers);
    $decreasingStr = implode(" ", $userNumbers);

    echo "Обратный порядок: " . $reversedStr . PHP_EOL;
    echo "По возрастанию: " . $increasingStr . PHP_EOL;
    echo "По убыванию: " . $decreasingStr . PHP_EOL;
}


function isOnlyIntegers($arr)
{
    if (!$arr)
    {
        return False;
    }
    foreach ($arr as $arrElement)
    {
        if(!preg_match('/^[-?\d]+$/', $arrElement))
        {
            return False;
        }
    }
    return True;
}