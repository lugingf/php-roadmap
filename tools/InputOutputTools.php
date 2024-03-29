<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */
namespace ELT;

class InputOutputTools
{
	/**
	 * @param string $inviteMessage
	 * @return string
	 */
	public static function getDataFromStdin($inviteMessage)
	{
		echo $inviteMessage . PHP_EOL;
		$userInput = trim(fgets(STDIN));
		return $userInput;
	}

	/**
	 * @param string $errorText
	 * @param string $exampleText
	 */
	public static function sendDataToStderr($errorText = 'error', $exampleText = '')
	{
		$errorMessageTotal = $errorText . PHP_EOL . $exampleText . PHP_EOL;
		fwrite(STDERR, $errorMessageTotal);
	}

	/**
	 * @param string $text
	 */
	public static function sendDataToStdOut($text, $lineBreak = "\n")
	{
		fwrite(STDOUT, $text . $lineBreak);
	}
}