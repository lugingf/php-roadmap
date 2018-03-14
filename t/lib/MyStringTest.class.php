<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace ET;

require_once __DIR__ . '/../../init.php';

use EL\TypeStyleConverter\MyString;

class MyStringTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider providerText
	 */
	public function testGetBody($testBodyText)
	{
		$myString = new MyString($testBodyText);

		$this->assertEquals($testBodyText, $myString->getBody());
	}

	/**
	 * @dataProvider providerText
	 */
	public function testIsEqual($textBodyToCompareOne, $textBodyToCompareThree)
	{
		$textBodyToCompareOne = new MyString($textBodyToCompareOne);
		$textBodyToCompareTwo = new MyString($textBodyToCompareOne);
		$textBodyToCompareThree = new MyString($textBodyToCompareThree);

		$this->assertTrue($textBodyToCompareOne->isEqual($textBodyToCompareTwo));
		$this->assertFalse($textBodyToCompareOne->isEqual($textBodyToCompareThree));
	}

	/**
	 * @dataProvider providerText
	 */
	public function testConcatenate($textConcatenatedPartOne, $textConcatenatedPartTwo)
	{
		$concatenatedStringOne = new MyString($textConcatenatedPartOne);
		$concatenatedStringTwo = new MyString($textConcatenatedPartTwo);

		$this->assertEquals($textConcatenatedPartOne . ' ' . $textConcatenatedPartTwo, $concatenatedStringOne->concatenate(' ', $concatenatedStringTwo));
		$this->assertEquals($textConcatenatedPartOne . ' ' . $textConcatenatedPartTwo, $concatenatedStringOne->concatenate(' ', $concatenatedStringTwo, 'right'));
		$this->assertEquals($textConcatenatedPartTwo . $textConcatenatedPartOne , $concatenatedStringOne->concatenate('', $concatenatedStringTwo, 'left'));
	}

	/**
	 * @dataProvider providerText
	 */
	public function testConcatenateThrow($textConcatenatedPartOne, $textConcatenatedPartTwo)
	{
		$this->setExpectedException('TypeError');
		$stringOne = new MyString($textConcatenatedPartOne);

		$result = $stringOne->concatenate(' ', $textConcatenatedPartTwo);
	}

	/**
	 * @dataProvider providerText
	 */
	public function testStrReplace($textBody)
	{
		$patternText = 'one';
		$replace = 'two';

		$string = new MyString($textBody);
		$pattern = new MyString($patternText);
		$replacingString = new MyString($replace);

		$this->assertEquals('text two', $string->strReplace($pattern, $replacingString));
	}

	/**
	 * @dataProvider providerText
	 */
	public function testPregReplace($textBody)
	{
		$patternText = 'one';
		$replace = 'two';

		$string = new MyString($textBody);
		$replacingString = new MyString($replace);

		$this->assertEquals('text two', $string->pregReplace($patternText, $replacingString));
	}

	public function testExplode()
	{
		$text = 'text; to; explode;';

		$string = new MyString($text);

		$this->assertEquals(['text;', 'to;', 'explode;'], $string->explode());
		$this->assertEquals(['text', ' to', ' explode', ''], $string->explode(';'));
	}

	public function providerText()
	{
		return [
			['text one', 'text two', 'text three']
		];
	}

}