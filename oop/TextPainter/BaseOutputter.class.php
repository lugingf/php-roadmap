<?php
declare(strict_types = 1);
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace EL\TextPainter;


class BaseOutputter
{
	protected $_currentColor = null;

	/**
	 * @param string $text
	 * @return string
	 * @throws \Exception
	 */
	public function getColoredText(string $text): string
	{
		if (is_null($this->_currentColor))
			throw new \Exception('no color');
		$coloredText = exec('echo -en "' . $this->_currentColor . $text . '\033[0m"');
		return $coloredText;
	}

	/**
	 * @param string $text
	 */
	public function writeText(string $text)
	{
		\InputOutputTools::sendDataToStdOut($text, '');
	}
}