<?php
header('Content-type: application/json');

include ('header.php');
$GLOBALS['xoopsLogger']->activated = false;
xoops_loadLanguage('main', 'flowplayer');

$user = flowplayer_getIPData(false);

$resolve = $_GET['resolve'];
$agent = (empty($_GET['useragent'])?$_SERVER["HTTP_USER_AGENT"]:$_GET['useragent']);
			
$passkey = isset($_SESSION['flowplayer'][$user['ip']][$resolve]['passkey'])?$_SESSION['flowplayer'][$user['ip']][$resolve]['passkey']:'';
$fid = $_SESSION['flowplayer'][$user['ip']][$resolve][$_SESSION['flowplayer'][$user['ip']][$resolve]['passkey']]['fid'];
$width = $_SESSION['flowplayer'][$user['ip']][$resolve][$_SESSION['flowplayer'][$user['ip']][$resolve]['passkey']][$fid]['width'];
$height = $_SESSION['flowplayer'][$user['ip']][$resolve][$_SESSION['flowplayer'][$user['ip']][$resolve]['passkey']][$fid]['height'];
$block = $_SESSION['flowplayer'][$user['ip']][$resolve][$_SESSION['flowplayer'][$user['ip']][$resolve]['passkey']][$fid]['block'];

$values = array();
$submit = true;

// Checks Passkey
$diff=$GLOBALS['flowplayerModuleConfig']['passkey_diff'];
$start=$GLOBALS['flowplayerModuleConfig']['passkey_weight'];
$passed=false;
for($t=time()-$start;$t<=time()+$diff+$start;$t++) {
	if ($passkey==sha1(XOOPS_LICENSE_KEY.$GLOBALS['flowplayerModuleConfig']['salt'].$user['ip'].date('Ymdhis', $t))) {
		$passed=true;
		continue;	
	}
}

if ($passed==false) {
	$values['innerhtml'][$resolve] = _MN_FLOWPLAYER_TOKEN_KEY_EXPIRED;
} else {
	
	$player_handler = xoops_getmodulehandler('player', 'flowplayer');
	$player = $player_handler->get($fid);
	if (!is_object($player)) {
		$values['innerhtml'][$resolve] = _MN_FLOWPLAYER_SESSION_EXPIRED;
	} else {
		switch ($player->getSpecialWithUserAgent($agent)) {
			case 'A':
			case 'B':
				$width = $player->getVar('width');
				$height = $player->getVar('height');
			default:
				if (empty($width)) 
					$width = $player->getVar('width');
				if (empty($height)) 
					$height = $player->getVar('height');
				break;		
		}
		 
		$mode = $player->getModeWithUserAgent($agent);
		$out = array();
		if (in_array($mode, $GLOBALS['flowplayerModuleConfig']['load_flowplayer'])) {
			if ($player->getVar('stream')==true&&$mode=='rtmp') {
				$out[0] = XOOPS_URL."/modules/flowplayer/swf/flowplayer-3.2.8.swf";
				$out[1] = ($player->getVar('autoplay')==true?true:false);
				$out[2] = ($player->getVar('muted')==true?0:$player->getVar('level'));
				$out[3] = $player->getVar('rtmp_server');
				$out[4] = $player->getVar('rtmp');
				$out[5] = XOOPS_URL."/modules/flowplayer/swf/flowplayer.controls-3.2.8.swf";
				$out[6] = ($player->getVar('play')==true&&$player->getVar('controls')==true?true:false);
				$out[7] = ($player->getVar('volume')==true&&$player->getVar('controls')==true?true:false);
				$out[8] = ($player->getVar('mute')==true&&$player->getVar('controls')==true?true:false);
				$out[9] = ($player->getVar('time')==true&&$player->getVar('controls')==true?true:false);
				$out[10] = ($player->getVar('stop')==true&&$player->getVar('controls')==true?true:false);
				$out[11] = ($player->getVar('fullscreen')==true&&$player->getVar('controls')==true?true:false);
				$out[12] = ($player->getVar('scrubber')==true&&$player->getVar('controls')==true?true:false);
				$out[13] = XOOPS_URL."/modules/flowplayer/swf/flowplayer.rtmp-3.2.8.swf";
				$action = 'flowplayerrtmp';
			} else {
				$out[0] = XOOPS_URL.dirname($_SERVER['PHP_SELF'])."/swf/flowplayer-3.2.8.swf";
				$out[1] = ($player->getVar('autoplay')==true?true:false);
				$out[2] = ($player->getVar('muted')==true?0:$player->getVar('level'));
				$out[3] = $player->getSource($mode);
				$out[5] = XOOPS_URL."/modules/flowplayer/swf/flowplayer.controls-3.2.8.swf";
				$out[6] = ($player->getVar('play')==true&&$player->getVar('controls')==true?true:false);
				$out[7] = ($player->getVar('volume')==true&&$player->getVar('controls')==true?true:false);
				$out[8] = ($player->getVar('mute')==true&&$player->getVar('controls')==true?true:false);
				$out[9] = ($player->getVar('time')==true&&$player->getVar('controls')==true?true:false);
				$out[10] = ($player->getVar('stop')==true&&$player->getVar('controls')==true?true:false);
				$out[11] = ($player->getVar('fullscreen')==true&&$player->getVar('controls')==true?true:false);
				$out[12] = ($player->getVar('scrubber')==true&&$player->getVar('controls')==true?true:false);
				$action = 'flowplayerfile';
			}
		} elseif (in_array($mode, $GLOBALS['flowplayerModuleConfig']['load_videojs'])) {
			if ($player->getVar('stream')==false) {
				$out[0] = $player->getVar('controls');
				$out[1] = $player->getVar('level')/100;
				$out[2] = $player->getVar('autoplay');
				$action = 'videojsfile'; 		
		 	} else {
				$out[0] = $player->getVar('controls');
				$out[1] = $player->getVar('level')/100;
				$out[2] = $player->getVar('autoplay');
				$action = 'videojsstream';
		 	}
		} else {
			if ($player->getVar('stream')==false) {
				$action = 'otherfile'; 		
		 	} else {
				$action = 'otherstream';
		 	}
		}
		$out[20] = $width;
		$out[21] = $height;
		$values['innerhtml'][$resolve] = ($player->getHTML($block, $width, $height, $agent, $user['ip'], $resolve, $passkey));
		$values[$action][$player->getReference($block)] = $out;
	}
}

if (!function_exists('json_encode')) {
	if (!class_exists('Services_JSON'))
		include ($GLOBALS['xoops']->path('/modules/flowplayer/include/JSON.php'));
	$json = new services_JSON();
	print $json->encode($values);
} else {
	print json_encode($values);
}
?>