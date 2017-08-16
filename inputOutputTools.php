<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */


/**
 * @param string $inviteMessage
 * @return string
 */
function getDataFromStdin($inviteMessage)
{
	echo $inviteMessage . PHP_EOL;
	$userInput = trim(fgets(STDIN));
	return $userInput;
}


/**
 * @param string $errorText
 * @param string $exampleText
 * @param int $errorCode
 */
function sendDataToStderr($errorText = 'error', $exampleText = '')
{
	$errorMessageTotal = $errorText . PHP_EOL . $exampleText . PHP_EOL;
	fwrite(STDERR, $errorMessageTotal);
}
