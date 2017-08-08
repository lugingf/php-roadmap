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
 * К программе из п. 6 добавить возможность управлять выводом с помощью опций
 * -p - если задана эта опция, выводить доли из п. 5, иначе - только числа
 * --order=<reverse|asc|desc> - если задана такая опция, выводить числа соответственно как в 4a, 4b, 4c. Если не задана,
 * выводить в исходном порядке.
 *
 */


$options = getopt('p', ['order::']);
$optionsCount =  count($options);
$userNumbers = array_slice($argv, $optionsCount+1);
$returnText = '';

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

if (isset($options['order']))
{
	switch ($options['order'])
	{
		case 'reverse':
			$userNumbersReversed = array_reverse($userNumbers);
			$returnText = $returnText . getReversedString($userNumbers);
			break;
		case 'asc':
			asort($userNumbers);
			$returnText = $returnText . getIncreasingString($userNumbers);
			break;
		case 'desc':
			arsort($userNumbers);
			$returnText = $returnText . getDecreasingString($userNumbers);
			break;
		default:
			$orderNotRecognisedText = "Значение параметра order не опознано. Пожалуйста используйте reverse|asc|desc" . PHP_EOL;
			fwrite(STDERR, $orderNotRecognisedText);
	}
}
else
{
	$returnText = $returnText .  "Введенные числа: " . implode(" ", $userNumbers) . PHP_EOL;
}

if (isset($options['p']))
{
	$returnText = $returnText . getPercentageString(getPercentageTable($userNumbers));
}

echo $returnText;


/**
 * @param $userNumbers array
 *
 * @return string
 */
function getReversedString($userNumbers)
{
	$reversedString = implode(" ", $userNumbers);
	return "Обратный порядок: " . $reversedString . PHP_EOL;
}

/**
 * @param $userNumbers array
 *
 * @return string
 */
function getIncreasingString($userNumbers)
{
	$increasingString = implode(" ", $userNumbers);
	return "По возрастанию: " . $increasingString . PHP_EOL;
}

/**
 * @param $userNumbers array
 *
 * @return string
 */
function getDecreasingString($userNumbers)
{
	$decreasingString = implode(" ", $userNumbers);
	return "По убыванию: " . $decreasingString . PHP_EOL;
}

/**
 * @param $userNumbers
 *
 * @return array
 */
function getPercentageTable($userNumbers)
{
	$percentageTable = [];
	$numbersSum = array_sum($userNumbers);
	if ($numbersSum <= 0)
	{
		$totalSumLessThanZeroText = "Сумма всех элементов меньше или равна нулю. Корректно посчитать процент каждого числа от суммы всех введенных чисел нельзя" . PHP_EOL;
		fwrite(STDERR,$totalSumLessThanZeroText);
		exit;
	}
	foreach ($userNumbers as $number)
	{
		if ($number < 0)
			fwrite(STDERR, "Корретно посчитать процент отрицательного числа " . $number . " от суммы всех введенных чисел нельзя" . PHP_EOL);
		else
		{
			$percentage = round(($number / $numbersSum) * 100, 2);
			$percentageTable[$number] = $percentage;
		}
	}
	var_dump($percentageTable);
	return $percentageTable;
}

/**
 * @param $percentageTable array
 *
 * @return string
 */
function getPercentageString($percentageTable)
{
	$percentageString = '';
	foreach ($percentageTable as $number => $percentage)
		$percentageString =$percentageString . "Число " . $number . " составляет " . $percentage . "% от общей суммы" . PHP_EOL;
	return $percentageString;
}

/**
 * @param $items array
 * 
 * @return array
 */
function getNotIntegers($items)
{
	$badAdruments = [];
	foreach ($items as $arrayElement)
	{
		if(!preg_match('/^[-]?[\d]+$/', $arrayElement))
    		array_push($badAdruments, $arrayElement);
	}
	return $badAdruments;
}