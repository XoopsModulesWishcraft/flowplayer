<?php
	require_once (dirname(dirname(dirname(dirname(__FILE__)))).'/include/cp_header.php');
	
	if (!defined('_CHARSET'))
		define("_CHARSET","UTF-8");
	if (!defined('_CHARSET_ISO'))
		define("_CHARSET_ISO","ISO-8859-1");
		
	$GLOBALS['myts'] = MyTextSanitizer::getInstance();
	
	$module_handler = xoops_gethandler('module');
	$config_handler = xoops_gethandler('config');
	$GLOBALS['flowplayerModule'] = $module_handler->getByDirname('flowplayer');
	$GLOBALS['flowplayerModuleConfig'] = $config_handler->getConfigList($GLOBALS['flowplayerModule']->getVar('mid')); 
		
	xoops_load('pagenav');	
	xoops_load('xoopslists');
	xoops_load('xoopsformloader');
	
	include_once $GLOBALS['xoops']->path('class'.DS.'xoopsmailer.php');
	include_once $GLOBALS['xoops']->path('class'.DS.'xoopstree.php');
	
	if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
	        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
	        //return true;
	    }else{
	        echo flowplayer_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
	        //return false;
	    }
	$GLOBALS['flowplayerImageIcon'] = XOOPS_URL .'/'. $GLOBALS['flowplayerModule']->getInfo('icons16');
	$GLOBALS['flowplayerImageAdmin'] = XOOPS_URL .'/'. $GLOBALS['flowplayerModule']->getInfo('icons32');
	
	if ($GLOBALS['xoopsUser']) {
	    $moduleperm_handler =& xoops_gethandler('groupperm');
	    if (!$moduleperm_handler->checkRight('module_admin', $GLOBALS['flowplayerModule']->getVar( 'mid' ), $GLOBALS['xoopsUser']->getGroups())) {
	        redirect_header(XOOPS_URL, 1, _NOPERM);
	        exit();
	    }
	} else {
	    redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
	    exit();
	}
	
	if (!isset($GLOBALS['xoopsTpl']) || !is_object($GLOBALS['xoopsTpl'])) {
		include_once(XOOPS_ROOT_PATH."/class/template.php");
		$GLOBALS['xoopsTpl'] = new XoopsTpl();
	}
	
	$GLOBALS['xoopsTpl']->assign('pathImageIcon', $GLOBALS['flowplayerImageIcon']);
	$GLOBALS['xoopsTpl']->assign('pathImageAdmin', $GLOBALS['flowplayerImageAdmin']);
	
	
	require_once('../include/functions.php');
	require_once('../include/formobjects.flowplayer.php');
	require_once('../include/forms.flowplayer.php');
	
	include_once(dirname(dirname(__FILE__)).'/language/'.$GLOBALS['xoopsConfig']['language'].'/modinfo.php');
	include_once(dirname(dirname(__FILE__)).'/language/'.$GLOBALS['xoopsConfig']['language'].'/forms.php');

		
?>