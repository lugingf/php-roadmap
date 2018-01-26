<?php
declare(strict_types = 1);
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace EL\TextPainter\Device;


use EL\TextPainter\BaseOutputter;

class Pen extends BaseOutputter
{
	/**
	 * Pen constructor.
	 * @param string $color
	 */
	public function __construct(?string $color)
	{
		$this->_currentColor = $color;
	}

}