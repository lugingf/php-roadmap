<?php

/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * https://ru.wikipedia.org/wiki/Обратная_польская_запись
 *
 */
class CalculatorString
{
	private static $_operatorPriority = [
		'(' => 0,
		')' => 0,
		'+' => 1,
		'-' => 1,
		'*' => 2,
		'/' => 2,
	];

	/**
	 * @param string $mathExample
	 * @return string
	 */
	public static function calculateString($mathExample)
	{
		$reversePolishNotationArray = self::_getReversePolishNotation($mathExample);
		$calculationResult = self::_getResultFromReversePolishNotation($reversePolishNotationArray);
		return $calculationResult ?? '';
	}

	/**
	 * @param string $infixNotationExmaple
	 * @return array
	 * @throws Exception
	 */
	private static function _getReversePolishNotation($infixNotationExmaple)
	{
		$calculationQueue = [];
		$operatorsBuffer = [];
		$number = '';

		$infixNotationExmaple = str_replace('(-', '(0-', $infixNotationExmaple);

		$explodedLine = str_split($infixNotationExmaple);
		$explodedLine = array_diff($explodedLine, [' ']);
		foreach ($explodedLine as $char)
		{
			if (is_numeric($char))
				$number .= $char;
			else
			{
				if (strlen($number))
				{
					array_push($calculationQueue, $number);
					$number = '';
				}
				if (!isset(self::$_operatorPriority[$char]))
					throw new \Exception('Обнаружен неверный символ: "' . $char . '"');
				if ($char == ')')
				{
					while (!empty($operatorsBuffer))
					{
						$lastStackedOperator = array_pop($operatorsBuffer);
						if ($lastStackedOperator == '(')
							break;
						array_push($calculationQueue, $lastStackedOperator);
					}
					if ($lastStackedOperator != '(')
						throw new \Exception('Закрывающая скобка без открывающей ")"');
				}
				else
				{
					while (!empty($operatorsBuffer) && $char != '(')
					{
						$lastStackedOperator = array_pop($operatorsBuffer);
						if (self::$_operatorPriority[$char] > self::$_operatorPriority[$lastStackedOperator])
						{
							array_push($operatorsBuffer, $lastStackedOperator);
							break;
						}
						if ($lastStackedOperator != '(')
							array_push($calculationQueue, $lastStackedOperator);
					}
					array_push($operatorsBuffer, $char);
				}
			}
		}
		if (strlen($number))
		{
			array_push($calculationQueue, $number);
			$number = '';
		}
		if (!empty($operatorsBuffer))
		{
			while ($lastStackedOperator = array_pop($operatorsBuffer))
			{
				if ($lastStackedOperator == '(')
					throw new \Exception('Присутствует незакрытая скобка "("');
				array_push($calculationQueue, $lastStackedOperator);
			}
		}
		return $calculationQueue;
	}

	/**
	 * @param array $calculationQueue
	 * @return string
	 * @throws Exception
	 */
	private static function _getResultFromReversePolishNotation($calculationQueue)
	{
		$calculationStack = [];
		foreach ($calculationQueue as $queueElement)
		{
			switch ($queueElement)
			{
				case '+':
					$rightNumber = array_pop($calculationStack);
					$leftNumber = array_pop($calculationStack);
					array_push($calculationStack, $leftNumber + $rightNumber);
					break;
				case '-':
					$rightNumber = array_pop($calculationStack);
					$leftNumber = array_pop($calculationStack);
					array_push($calculationStack, $leftNumber - $rightNumber);
					break;
				case '*':
					$rightNumber = array_pop($calculationStack);
					$leftNumber = array_pop($calculationStack);
					array_push($calculationStack, $leftNumber * $rightNumber);
					break;
				case '/':
					$rightNumber = array_pop($calculationStack);
					$leftNumber = array_pop($calculationStack);
					if ($rightNumber == '0')
						throw new \Exception("На ноль делить нельзя (ну иногда можно, но не сегодня) $leftNumber/$rightNumber");
					array_push($calculationStack, $leftNumber / $rightNumber);
					break;
				default:
					array_push($calculationStack, $queueElement);
			}
		}
		$result = $calculationStack[0] ?? '';
		return $result;
	}
}