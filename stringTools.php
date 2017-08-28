<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */


/**
 * @param string $name
 * @return string
 */
function underscoreToCamel($word)
{
	$explodedWord = explode('_', $word);
	foreach ($explodedWord as $wordPart)
		$camelCaseExplodedWord[] = ucfirst(strtolower($wordPart));
	return implode('', $camelCaseExplodedWord);
}


/**
 * @param string $name
 * @return string
 */
function camelCaseToUnderscore($word)
{
	$word = lcfirst($word);
	return	strtolower(preg_replace('/([A-Z])/', '_\\1', $word));
}