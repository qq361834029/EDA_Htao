<?php
	// please specify the folder INTO which the
	// package was placed. You will need an ABSOLUTE path here
	// so starting with / (on Unix or \ on Windows)
	//$incPath = "/var/www/ZL/zh_framework/library/ebayapi";
	$incPath = dirname(__FILE__);
	if (preg_match('/WIN/i',PHP_OS))
	{
		$incPath = substr($incPath,0,strrpos($incPath,'\ORG')).'\ebayapi';
		$pathConcatSeparator = ';';
		
	}
	else
	{
		$incPath = substr($incPath,0,strrpos($incPath,'/ORG')).'/ebayapi';
		$pathConcatSeparator = ':';
	}
    set_include_path($incPath.$pathConcatSeparator.get_include_path());
?>