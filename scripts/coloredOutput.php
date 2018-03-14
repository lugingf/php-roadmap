<?php
declare(strict_types = 1);
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 * Задача: Вывести фразу "Каждый охотник желает знать, где сидит фазан!" с использованием цветов радуги, которым
 * соответствуют слова в предложении. Знаки препинания выводить стандартным для консоли цветом.
 */
require_once __DIR__ . '/../init.php';

use EL\TextPainter\Device\Printer;
use EL\TextPainter\Device\Brush;
use EL\TextPainter\Device\Pen;
use EL\TextPainter\Paints;
use ELT\StringTools;

$baseText = 'Каждый охотник желает знать, где сидит фазан!';

$colorMap = [
	'Каждый' => Paints::COLOR_RED,
	'охотник' => Paints::COLOR_YELLOW,
	'желает' => Paints::COLOR_YELLOW,
	'знать' => Paints::COLOR_GREEN,
	'где' => Paints::COLOR_CYAN,
	'сидит' => Paints::COLOR_BLUE,
	'фазан' => Paints::COLOR_VIOLET,
];

$baseText = StringTools::getSeparatedPunctuation($baseText);
$printedTextElements = [];
$explodedBaseText = explode(' ', $baseText);

// Use Pen
foreach ($explodedBaseText as $textItem)
{
	if (!array_key_exists($textItem, $colorMap))
	{
		$color = (new Paints(Paints::COLOR_DEFAULT))->getColor();
		$pen = new Pen($color);
		$printedTextElements[] = $pen->getColoredText($textItem);
	}
	else
	{
		$color = (new Paints($colorMap[$textItem]))->getColor();
		$pen = new Pen($color);
		$printedTextElements[] = $pen->getColoredText($textItem);
	}
//	если у нас текст будет тысяч в двести слов, то мы без этого умрем по памяти :)
	unset($color);
}
$printText = StringTools::getNonSeparatedPunctuation(implode(' ', $printedTextElements));
$pen->writeText('By PENS: ' . $printText . "\n");

// Use Printer
$printedTextElements = [];
$printer = new Printer();
foreach ($explodedBaseText as $textItem)
{
	$color = (array_key_exists($textItem, $colorMap) ? $colorMap[$textItem] : Paints::COLOR_DEFAULT);
	$printedTextElements[] = $printer->getColoredTextToPrint($textItem, (new Paints($color))->getColor());
}
$printText = StringTools::getNonSeparatedPunctuation(implode(' ', $printedTextElements));
$printer->writeText('By PRINTER: ' . $printText . "\n");

// Use Brush
$printedTextElements = [];
$brush = new Brush();
foreach ($explodedBaseText as $textItem)
{
	$color = (array_key_exists($textItem, $colorMap) ? $colorMap[$textItem] : Paints::COLOR_DEFAULT);
	$brush->setColor((new Paints($color))->getColor());
	$printedTextElements[] = $brush->getColoredText($textItem);
	$brush->cleanColor();
	unset($color);
}
$printText = StringTools::getNonSeparatedPunctuation(implode(' ', $printedTextElements));
$brush->writeText('By BRUSHES: ' . $printText . "\n");

