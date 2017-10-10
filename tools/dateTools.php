<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

/**
 * @param string $dateDelimeter
 * @param string $date
 * @return bool
 */
function validateDateConsistent($dateDelimeter, $date)
{
	$dateValid = true;
	$explodedDate = explode($dateDelimeter, $date);
	if (count($explodedDate) <> 3 || !checkdate($explodedDate[1], $explodedDate[0], $explodedDate[2]))
		$dateValid = false;
	return $dateValid;
}