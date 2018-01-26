<?php
declare(strict_types = 1);
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 * echo -en "\033[31m Внимание \033[0m"
 *
 * \033[30    чёрный цвет знаков
 * \033[31    красный цвет знаков
 * \033[32    зелёный цвет знаков
 * \033[33    желтый цвет знаков
 * \033[34    синий цвет знаков
 * \033[35    фиолетовый цвет знаков
 * \033[36    цвет морской волны знаков
 * \033[37    серый цвет знаков
 *
 */
namespace EL\TextPainter;

class Paints
{
	private $_currentColor = null;

	const COLOR_BLACK   = '\033[30m';
	const COLOR_RED     = '\033[31m';
	const COLOR_GREEN   = '\033[32m';
	const COLOR_YELLOW  = '\033[33m';
	const COLOR_ORANGE  = '\033[33m';
	const COLOR_BLUE    = '\033[34m';
	const COLOR_VIOLET  = '\033[35m';
	const COLOR_CYAN    = '\033[36m';
	const COLOR_GREY    = '\033[37m';
	const COLOR_DEFAULT = '';

	public function __construct($color)
	{
		$this->_currentColor = $color;
	}

	public function getColor()
	{
		return $this->_currentColor;
	}

}