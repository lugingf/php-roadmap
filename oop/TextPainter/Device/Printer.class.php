<?php
declare(strict_types = 1);
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace EL\TextPainter\Device;


use EL\TextPainter\BaseOutputter;

class Printer extends BaseOutputter
{
	/**
	 * @param string $text
	 * @param string $color
	 * @return string
	 */
	public function getColoredTextToPrint(string $text, ?string $color): string
	{
		$this->_currentColor = $color;
		return $this->getColoredText($text);
	}
}