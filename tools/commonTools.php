<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

/**
 * @param string $scanDir
 * @param array $result
 * @return array
 */
function getDirectoryContentInArray($scanDir, $result = [])
{
	$handle = opendir($scanDir);
	while (($fileItem = readdir($handle)) !== false)
	{
		if (($fileItem == '.' || $fileItem == '..'))
			continue;
		$fileItem = $scanDir . '/' . $fileItem;
		if (is_dir($fileItem))
			$result = getDirectoryContentInArray($fileItem, $result);
		else
			$result[] = ltrim($fileItem, '/');
	}
	closedir($handle);
	return $result;
}


/**
 * @deprecated Use getDirectoryContentInArray
 *
 * @param string $path
 * @return array
 */
function getDirectoryContentInArrayGenerator($path)
{
	$result = [];
	foreach (readSubDirFilesGenerator($path) as $fileItem)
		$result[] = ltrim($fileItem, '/');
	return $result;
}

/**
 * @deprecated
 *
 * @param string $scanDir
 * @return Generator
 */
function readSubDirFilesGenerator($scanDir)
{
	$handle = opendir($scanDir);
	while (($fileItem = readdir($handle)) !== false)
	{
		if (($fileItem == '.' || $fileItem == '..'))
			continue;
		$fileItem = rtrim($scanDir,'/') . '/' . $fileItem;
		if (is_dir($fileItem))
		{
			foreach (readSubDirFilesGenerator($fileItem) as $childFileItem)
				yield $childFileItem;
		}
		else
			yield $fileItem;
	}
	closedir($handle);
}

/**
 * @deprecated use \oop\ReadFile
 * 
 * @param string $path
 * @return Generator
 */
function readFileByLines($path)
{
	$fileDescriptor = fopen('/' . $path, 'r');
	while (($buffer = fgets($fileDescriptor)) !== false)
		yield $buffer;
	fclose($fileDescriptor);
}
