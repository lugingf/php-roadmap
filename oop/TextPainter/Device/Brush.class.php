<?php
declare(strict_types = 1);
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

namespace EL\TextPainter\Device;


use EL\TextPainter\BaseOutputter;

class Brush extends BaseOutputter
{
	/**
	 * @param string $color
	 * @throws \Exception
	 */
	public function setColor(?string $color)
	{
		if (!is_null($this->_currentColor))
			throw new \Exception('Error: Brush already has a color');
		$this->_currentColor = $color;
	}

	public function cleanColor()
	{
		$this->_currentColor = null;
	}

}