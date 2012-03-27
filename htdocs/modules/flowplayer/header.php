<?php
	require_once (dirname(dirname(dirname(__FILE__))).'/mainfile.php');
	
	require_once('include/functions.php');
	require_once('include/formobjects.flowplayer.php');
	require_once('include/forms.flowplayer.php');
	
	xoops_loadLanguage('modinfo', 'flowplayer');
	
	$config_handler = xoops_gethandler('config');
	$module_handler = xoops_gethandler('module');
	
	$GLOBALS['flowplayerModule'] = $module_handler->getByDirname('flowplayer');
	$GLOBALS['flowplayerModuleConfig'] = $config_handler->getConfigList($GLOBALS['flowplayerModule']->getVar('mid'));
	
	xoops_loadLanguage('main', 'flowplayer');
	
	if (isset($_GET['_returned']))
		$GLOBALS['_returned'] = unserialize($_GET['_returned']);
	else 
		$GLOBALS['_returned'] = array();
	$GLOBALS['_done'] = array();
?>