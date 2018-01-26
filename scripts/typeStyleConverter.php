<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

use \EL\TypeStyleConverter\MyString;

require_once __DIR__ . '/../init.php';

$userInput = InputOutputTools::getDataFromStdin(TextsTemplates::getPhrase('typeText'));

if (!$userInput)
{
	InputOutputTools::sendDataToStderr(TextsTemplates::getPhrase('noArgsText'));
	exit(1);
}

const INVALID_WORDS = [
	'do_not_convert_me',
	'DoNotConvertMe',
];

$myString = new MyString($userInput);
$convertedWords = [];

/* @var $word MyString*/
foreach ($myString->explode() as $word)
{
	if (in_array($word->getBody(), INVALID_WORDS))
	{
		$convertedWords[] = $word;
	}
	elseif (preg_match('/_/', $word->getBody()))
	{
		$convertedWords[] = new MyString(StringTools::underscoreToCamel($word->getBody()));
	}
	elseif (preg_match('/[A-Z]/', $word->getBody()))
	{
		$convertedWords[] = new MyString(StringTools::camelCaseToUnderscore($word->getBody()));
	}
	else
	{
		$convertedWords[] = $word;
	}
}

InputOutputTools::sendDataToStdOut(implode(' ', $convertedWords));