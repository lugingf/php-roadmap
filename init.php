<?php
/**
 * @author Evgeniy Lugin <lugin@tutu.ru>
 *
 */

spl_autoload_register('autoloader', false);
spl_autoload_register('autoloaderTools', false);
spl_autoload_register('autoloaderLogActions', false);



function autoloader($aClassName)
{
	$aClassFilePath = __DIR__ . '/oop' . DIRECTORY_SEPARATOR . str_replace('\\','/', str_replace('EL\\', '', $aClassName)) . '.class.php';
	if (file_exists($aClassFilePath))
	{
		require_once $aClassFilePath;
		return true;
	}
	return false;
}

function autoloaderTools($aClassName)
{
	$aClassFilePath =  __DIR__ . '/tools' . DIRECTORY_SEPARATOR . $aClassName . '.php';
	if (file_exists($aClassFilePath))
	{
		require_once $aClassFilePath;
		return true;
	}
	return false;
}

function autoloaderLogActions($aClassName)
{
	$aClassFilePath =  __DIR__ . '/oop/' . str_replace('\\','/', str_replace('EL\\', '', $aClassName)) . '.class.php';
	if (file_exists($aClassFilePath))
	{
		require_once $aClassFilePath;
		return true;
	}
	return false;
}
