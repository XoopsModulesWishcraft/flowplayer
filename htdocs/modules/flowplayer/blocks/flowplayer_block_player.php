<?php
require_once(dirname(dirname(__FILE__)).'/include/functions.php');

function b_flowplayer_block_player_show( $options )
{
	if (!isset($GLOBALS['_done']))
		$GLOBALS['_done'] = array();
		
	$player_handler = xoops_getmodulehandler('player', 'flowplayer');
	if (!$player = $player_handler->get($options[0]))
		return false;
	
	$mode = $player->getModeWithUserAgent();
	$block = array();
	$block['width'] = ($player->getSpecialWithUserAgent($_SERVER['HTTP_USER_AGENT'])=='A'?$player->getVar('speciala_width'):($player->getSpecialWithUserAgent($_SERVER['HTTP_USER_AGENT'])=='B'?$player->getVar('specialb_width'):($options[1]))); 
	$block['height'] = ($player->getSpecialWithUserAgent($_SERVER['HTTP_USER_AGENT'])=='A'?$player->getVar('speciala_height'):($player->getSpecialWithUserAgent($_SERVER['HTTP_USER_AGENT'])=='B'?$player->getVar('specialb_height'):($options[2])));
	$block['id'] = $options[3];
	
	if (!isset($GLOBALS['_done'][$block['id']])) {
		
		$config_handler = xoops_gethandler('config');
		$module_handler = xoops_gethandler('module');
		$GLOBALS['flowplayerModule'] = $module_handler->getByDirname('flowplayer');
		$GLOBALS['flowplayerModuleConfig'] = $config_handler->getConfigList($GLOBALS['flowplayerModule']->getVar('mid'));
		if ($GLOBALS['flowplayerModuleConfig'][$mode.'_secure']==true) {
			$_SESSION['flowplayer'][$player->getIP()][$block['id']]['passkey'] = sha1(XOOPS_LICENSE_KEY.$GLOBALS['flowplayerModuleConfig']['salt'].$player->getIP().date('Ymdhis'));
			$_SESSION['flowplayer'][$player->getIP()][$block['id']][$_SESSION['flowplayer'][$player->getIP()][$block['id']]['passkey']]['fid'] = $player->getVar('fid');
			$_SESSION['flowplayer'][$player->getIP()][$block['id']][$_SESSION['flowplayer'][$player->getIP()][$block['id']]['passkey']][$player->getVar('fid')]['block'] = '1';
			$_SESSION['flowplayer'][$player->getIP()][$block['id']][$_SESSION['flowplayer'][$player->getIP()][$block['id']]['passkey']][$player->getVar('fid')]['width'] = $block['width'];
			$_SESSION['flowplayer'][$player->getIP()][$block['id']][$_SESSION['flowplayer'][$player->getIP()][$block['id']]['passkey']][$player->getVar('fid')]['height'] = $block['height'];
			$_SESSION['flowplayer'][$player->getIP()][$block['id']][$_SESSION['flowplayer'][$player->getIP()][$block['id']]['passkey']][$player->getVar('fid')]['resolve'] = $block['id'];
			
			$GLOBALS['xoTheme']->addScript('', array('type'=>'text/javascript'), str_replace('%resolve%', $block['id'], $player->getJS(true)));
			$block['html'] = false;
		} else {
			$block['js'] = $player->getInsecureJS(true);
			$block['html'] = $player->getHTML(true, $block['width'], $block['height']);
		}
		$GLOBALS['_done'][$block['id']]=true;
		return $block;
	}
	return false;
}


function b_flowplayer_block_player_edit( $options )
{
	xoops_loadLanguage('blocks', 'flowplayer');
	
	include_once($GLOBALS['xoops']->path('/modules/flowplayer/include/formobjects.flowplayer.php'));

	$fid = new FlowplayerFormSelectPlayer('', 'options[0]', $options[0]);
	$width = new XoopsFormText('', 'options[1]', 15, 10, $options[1]);
	$height = new XoopsFormText('', 'options[2]', 15, 10, $options[2]);
	$reference = new XoopsFormText('', 'options[3]', 25, 40, $options[3]);
	$form = constant('_BL_FLOWPLAYER_BLOCK_FID').$fid->render()."<br/>".constant('_BL_FLOWPLAYER_BLOCK_WIDTH').$width->render()."<br/>".constant('_BL_FLOWPLAYER_BLOCK_HEIGHT').$height->render().'<br/>'.constant('_BL_FLOWPLAYER_BLOCK_REFERENCE').$reference->render();
	return $form ;
}
?>