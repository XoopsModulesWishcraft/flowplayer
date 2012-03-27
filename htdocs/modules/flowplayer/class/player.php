<?php

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

include_once $GLOBALS['xoops']->path('modules/flowplayer/include/functions.php');
include_once $GLOBALS['xoops']->path('modules/flowplayer/include/formobjects.flowplayer.php');
include_once $GLOBALS['xoops']->path('modules/flowplayer/include/forms.flowplayer.php');
/**
 * Class for Blue Room Xcenter
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class FlowplayerPlayer extends XoopsObject
{
	var $_ModConfig = NULL;
	var $_Mod = NULL;
	
    function FlowplayerPlayer($id = null)
    {
        $this->initVar('fid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('mid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('reference', XOBJ_DTYPE_TXTBOX, 'player_%fid%', false, 128);
		$this->initVar('raw', XOBJ_DTYPE_TXTBOX, '', false, 500);
		$this->initVar('stream', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('rtmp_server', XOBJ_DTYPE_TXTBOX, '', false, 500);		
		$this->initVar('rtmp', XOBJ_DTYPE_TXTBOX, '', false, 500);
		$this->initVar('flash', XOBJ_DTYPE_TXTBOX, '', false, 500);
		$this->initVar('ios', XOBJ_DTYPE_TXTBOX, '', false, 500);
		$this->initVar('silverlight', XOBJ_DTYPE_TXTBOX, '', false, 500);
		$this->initVar('rtsp', XOBJ_DTYPE_TXTBOX, '', false, 500);
		$this->initVar('path', XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar('poster', XOBJ_DTYPE_TXTBOX, '', false, 255);
		$this->initVar('width', XOBJ_DTYPE_TXTBOX, '', false, 64);
		$this->initVar('height', XOBJ_DTYPE_TXTBOX, '', false, 64);
		$this->initVar('speciala_width', XOBJ_DTYPE_TXTBOX, '', false, 64);
		$this->initVar('speciala_height', XOBJ_DTYPE_TXTBOX, '', false, 64);
		$this->initVar('specialb_width', XOBJ_DTYPE_TXTBOX, '', false, 64);
		$this->initVar('specialb_height', XOBJ_DTYPE_TXTBOX, '', false, 64);
		$this->initVar('level', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('autoplay', XOBJ_DTYPE_INT, true, false);
		$this->initVar('speciala_autoplay', XOBJ_DTYPE_INT, true, false);
		$this->initVar('specialb_autoplay', XOBJ_DTYPE_INT, true, false);
		$this->initVar('controls', XOBJ_DTYPE_INT, true, false);
		$this->initVar('speciala_controls', XOBJ_DTYPE_INT, true, false);
		$this->initVar('specialb_controls', XOBJ_DTYPE_INT, true, false);
		$this->initVar('muted', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('play', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('volume', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('mute', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('time', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('stop', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('fullscreen', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('scrubber', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('default', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('created', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
		
		$config_handler = xoops_gethandler('config');
		$module_handler = xoops_gethandler('module');
		$this->_Mod = $module_handler->getByDirname('flowplayer');
		$this->_ModConfig = $config_handler->getConfigList($this->_Mod->getVar('mid'));
    
    }
    
    function getImage($state=false) {
    	if (strlen($this->getVar('poster'))==0)
    		return false;
    	if (file_exists(XOOPS_ROOT_PATH.DS.$this->getVar('path').$this->getVar('poster'))==false)
    		return false;
    	if ($state==true) 
    		return XOOPS_ROOT_PATH.DS.$this->getVar('path').$this->getVar('poster');
    	else 
    		return XOOPS_URL.'/'.str_replace(DS, '/', $this->getVar('path')).$this->getVar('poster');
    }	
    
    function getIP() {
    	static $ret = array();
    	if (empty($ret))
    		$ret = flowplayer_getIPData(false);
    	return $ret['ip'];
    }
    
    function getForm() {
    	return flowplayer_player_get_form($this, false);
    }
    
    function getVar($field, $mode = '') {
    	$fields = array('width', 'height', 'autoplay', 'control');
    	if (in_array($field, $fields)&&$mode!='no') {
	    	switch ($this->getSpecialWithUserAgent("")) {
	    		case "A":
	    			return parent::getVar('speciala_'.$field, $mode);
	    			break;
	    		case "B":
	    			return parent::getVar('specialb_'.$field, $mode);
	    			break;
	    		default:
	    			return parent::getVar($field, $mode);
	    			break;
	    	}
    	}
    	return parent::getVar($field, ($mode!='no' ? $mode : ''));
    }
    
    function toArray() {
    	$ret = parent::toArray();
    	if ($this->getVar('mid')>0) {
    		$mimetypes_handler = xoops_getmodulehandler('mimetypes', 'flowplayer');
    		$mimetype = $mimetypes_handler->get($this->getVar('mid'));
    		if (is_object($mimetype))
    			$ret['mimetype'] = $mimetype->toArray();
    	}
    	$ret['image'] = $this->getImage();
    	$fields = array('width', 'height', 'autoplay', 'control');
    	switch ($this->getSpecialWithUserAgent("")) {
    		case "A":
    			foreach($fields as $field) {
    				$ret[$field] = $ret['speciala_'.$field];
    			}
    			break;
    		case "B":
    			foreach($fields as $field) {
    				$ret[$field] = $ret['specialb_'.$field];
    			}
    			break;
    		default:
    			break;
    	}
    	$ele = flowplayer_player_get_form($this, true);
    	foreach($ele as $key => $field)
    		$ret['form'][$key] = $field->render();
    	return $ret;
    }   
    
    function getHTML($block = false, $width=0, $height=0, $agent = '', $ip = '') {
    	if (empty($ip))
    		$ip = $this->getIP();
    	if (empty($agent))
    		$agent = $_SERVER['HTTP_USER_AGENT'];
    	$mode = $this->getModeWithUserAgent($agent);
    	include_once ($GLOBALS['xoops']->path('class/template.php'));
    	if (!isset($GLOBALS['xoopsTpl']))
    		$GLOBALS['xoopsTpl'] = new XoopsTpl();
    	$player = array();
    	$player = $this->toArray();
    	$player['mode'] = $mode;
    	$player['source'] = $this->getSource($mode);
    	$player['id'] = $this->getReference($block);
    	$player['width'] = (!empty($height)&&!empty($width)&&$width&&$height?$width:($this->getSpecialWithUserAgent($agent)=='A'?$this->getVar('speciala_width'):($this->getSpecialWithUserAgent($agent)=='B'?$this->getVar('specialb_width'):($this->getVar('width')))));
    	$player['height'] = (!empty($height)&&!empty($height)&&$height&&$height?$height:($this->getSpecialWithUserAgent($agent)=='A'?$this->getVar('speciala_height'):($this->getSpecialWithUserAgent($agent)=='B'?$this->getVar('specialb_height'):($this->getVar('height')))));
    	$GLOBALS['xoopsTpl']->assign('player', $player);
    	if (isset($player['mimetype']))
    		$GLOBALS['xoopsTpl']->assign('mimetype', $player['mimetype']);
    	$GLOBALS['xoopsTpl']->assign('xoConfig', $this->_ModConfig);
    	$GLOBALS['xoopsTpl']->assign('iframe', isset($_REQUEST['iframe']));
    	ob_start();
    	if ($block == false)
    		$GLOBALS['xoopsTpl']->display('db:flowplayer_json_'.$mode.'_player.html');
    	else 
    		$GLOBALS['xoopsTpl']->display('db:flowplayer_json_block_'.$mode.'_player.html');
    	$data = ob_get_contents();
    	ob_end_clean();
    	return $data;
    }
    
    function getJS($block=false, $width = '', $height = '') {
    	static $_loadedJS = false;
    	xoops_loadLanguage('modinfo', 'flowplayer');
		$mode = $this->getModeWithUserAgent($_SERVER['HTTP_USER_AGENT']);
		if (is_object($GLOBALS['xoTheme'])&&$_loadedJS==false) {
			if ($this->_ModConfig['force_jquery']&&!isset($GLOBALS['loaded_jquery'])) {
				$GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_JQUERY, array('type'=>'text/javascript'));
				$GLOBALS['loaded_jquery']=true;
			}
			if (in_array($mode, $this->_ModConfig['load_flowplayer'])) {
				$GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_FLOWPLAYER, array('type'=>'text/javascript'));
				$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL.sprintf(_MI_FLOWPLAYER_FLOWPLAYER_STYLE, $GLOBALS['xoopsConfig']['language']), array('type'=>'text/css'));
			}
			if (in_array($mode, $this->_ModConfig['load_videojs'])) {
				$GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_VIDEOJS, array('type'=>'text/javascript'));
				$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL.sprintf(_MI_FLOWPLAYER_VIDEOJS_STYLE, $GLOBALS['xoopsConfig']['language']), array('type'=>'text/css'));
			}	
			$GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_CORE, array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_JSON_FUNCTIONS, array('type'=>'text/javascript'));
			
			$_loadedJS = true;
		}
		if (empty($width))
			$width = ($this->getSpecialWithUserAgent($_SERVER['HTTP_USER_AGENT'])=='A'?$this->getVar('speciala_width'):($this->getSpecialWithUserAgent($_SERVER['HTTP_USER_AGENT'])=='B'?$this->getVar('specialb_width'):($this->getVar('width'))));
		if (empty($height))
			$height = ($this->getSpecialWithUserAgent($_SERVER['HTTP_USER_AGENT'])=='A'?$this->getVar('speciala_height'):($this->getSpecialWithUserAgent($_SERVER['HTTP_USER_AGENT'])=='B'?$this->getVar('specialb_height'):($this->getVar('height'))));
		$uid = 0;
		if (is_object($GLOBALS['xoopsUser']))
			$uid = $GLOBALS['xoopsUser']->getVar('uid');
		
		if ($block==false) {
			$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)]['passkey'] = sha1(XOOPS_LICENSE_KEY.$this->_ModConfig['salt'].$this->getIP().date('Ymdhis'));
			$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)][$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)]['passkey']]['fid'] = $this->getVar('fid');
			$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)][$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)]['passkey']][$this->getVar('fid')]['block'] = ($block==true?'1':'0');
			$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)][$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)]['passkey']][$this->getVar('fid')]['width'] = $width;
			$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)][$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)]['passkey']][$this->getVar('fid')]['height'] = $height;
			$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)][$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)]['passkey']][$this->getVar('fid')]['resolve'] = 'div_'.$this->getReference($block);
		}
		return 'flowplayer_dojson_player("'.XOOPS_URL.'","'._MI_FLOWPLAYER_DIRNAME.'","'.($block==false?$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)][$_SESSION['flowplayer'][$this->getIP()]['div_'.$this->getReference($block)]['passkey']][$this->getVar('fid')]['resolve']:'%resolve%').'", "");';
    }

    function getInsecureJS($block=false, $width = '', $height = '') {
    	static $_loadedJS = false;
    	xoops_loadLanguage('modinfo', 'flowplayer');
		$mode = $this->getModeWithUserAgent($_SERVER['HTTP_USER_AGENT']);
		if (is_object($GLOBALS['xoTheme'])&&$_loadedJS==false) {
			if ($this->_ModConfig['force_jquery']&&!isset($GLOBALS['loaded_jquery'])) {
				$GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_JQUERY, array('type'=>'text/javascript'));
				$GLOBALS['loaded_jquery']=true;
			}
			if (in_array($mode, $this->_ModConfig['load_flowplayer'])) {
				$GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_FLOWPLAYER, array('type'=>'text/javascript'));
				$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL.sprintf(_MI_FLOWPLAYER_FLOWPLAYER_STYLE, $GLOBALS['xoopsConfig']['language']), array('type'=>'text/css'));
			}
			if (in_array($mode, $this->_ModConfig['load_videojs'])) {
				$GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_VIDEOJS, array('type'=>'text/javascript'));
				$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL.sprintf(_MI_FLOWPLAYER_VIDEOJS_STYLE, $GLOBALS['xoopsConfig']['language']), array('type'=>'text/css'));
			}	
			$GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_JSON_FUNCTIONS, array('type'=>'text/javascript'));
			$GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_CORE, array('type'=>'text/javascript'));
			
			$_loadedJS = true;
		}
		$out = array();
		if (in_array($mode, $GLOBALS['flowplayerModuleConfig']['load_flowplayer'])) {
			if ($this->getVar('stream')==true&&$mode=='rtmp') {
				$out[0] = XOOPS_URL."/modules/flowplayer/swf/flowplayer-3.2.8.swf";
				$out[1] = ($this->getVar('autoplay')==true?'true':'false');
				$out[2] = ($this->getVar('muted')==true?0:$this->getVar('level'));
				$out[3] = $this->getVar('rtmp_server');
				$out[4] = $this->getVar('rtmp');
				$out[5] = XOOPS_URL."/modules/flowplayer/swf/flowplayer.controls-3.2.8.swf";
				$out[6] = ($this->getVar('play')==true&&$this->getVar('controls')==true?'true':'false');
				$out[7] = ($this->getVar('volume')==true&&$this->getVar('controls')==true?'true':'false');
				$out[8] = ($this->getVar('mute')==true&&$this->getVar('controls')==true?'true':'false');
				$out[9] = ($this->getVar('time')==true&&$this->getVar('controls')==true?'true':'false');
				$out[10] = ($this->getVar('stop')==true&&$this->getVar('controls')==true?'true':'false');
				$out[11] = ($this->getVar('fullscreen')==true&&$this->getVar('controls')==true?'true':'false');
				$out[12] = ($this->getVar('scrubber')==true&&$this->getVar('controls')==true?'true':'false');
				$out[13] = XOOPS_URL."/modules/flowplayer/swf/flowplayer.rtmp-3.2.8.swf";
				$action = 'flowplayer_rtmp';
			} else {
				$out[0] = XOOPS_URL.dirname($_SERVER['PHP_SELF'])."/swf/flowplayer-3.2.8.swf";
				$out[1] = ($this->getVar('autoplay')==true?'true':'false');
				$out[2] = ($this->getVar('muted')==true?0:$this->getVar('level'));
				$out[3] = $this->getSource($mode);
				$out[5] = XOOPS_URL."/modules/flowplayer/swf/flowplayer.controls-3.2.8.swf";
				$out[6] = ($this->getVar('play')==true&&$this->getVar('controls')==true?'true':'false');
				$out[7] = ($this->getVar('volume')==true&&$this->getVar('controls')==true?'true':'false');
				$out[8] = ($this->getVar('mute')==true&&$this->getVar('controls')==true?'true':'false');
				$out[9] = ($this->getVar('time')==true&&$this->getVar('controls')==true?'true':'false');
				$out[10] = ($this->getVar('stop')==true&&$this->getVar('controls')==true?'true':'false');
				$out[11] = ($this->getVar('fullscreen')==true&&$this->getVar('controls')==true?'true':'false');
				$out[12] = ($this->getVar('scrubber')==true&&$this->getVar('controls')==true?'true':'false');
				$action = 'flowplayer_file';
			}
		} elseif (in_array($mode, $GLOBALS['flowplayerModuleConfig']['load_videojs'])) {
			if ($this->getVar('stream')==false) {
				$out[0] = $this->getVar('controls')==true?'true':'false';
				$out[1] = $this->getVar('level')/100;
				$out[2] = $this->getVar('autoplay')==true?'true':'false';
				$action = 'videojs_file'; 		
		 	} else {
				$out[0] = $this->getVar('controls')==true?'true':'false';
				$out[1] = $this->getVar('level')/100;
				$out[2] = $this->getVar('autoplay')==true?'true':'false';
				$action = 'videojs_stream';
		 	}
		} else {
			if ($this->getVar('stream')==false) {
				$action = 'other_file'; 		
		 	} else {
				$action = 'other_stream';
		 	}
		}
		$out[20] = $this->getVar('width');
		$out[21] = $this->getVar('height');
		switch ($action) {
			case 'flowplayer_file':
			return "flowplayer('".$this->getReference($block)."', {src: '".$out[0]."', wmode: 'opaque', width: '".$out[20]."', height: '".$out[21]."'}, {
	                clip: {
	                    url: '".$out[3]."',
	            	    autoPlay: ".$out[1].",
	            	    onBegin: function () {
	            	        this.setVolume(".$out[2].");
	            	    }
	                },
	                plugins: {
	                	controls: {
	                        url: '".$out[5]."', 
	                        play:".$out[6].",
		                	volume:".$out[7].",
		                	mute:".$out[8].",
		                	time:".$out[9].",
		                	stop:".$out[10].",
		                	playlist:false,
		                	fullscreen:".$out[11].",
		                 	scrubber: ".$out[12]."
		                }
	                }
});";
			break;
		case 'videojs_file':
		case 'videojs_stream':
			return "var myPlayer = VideoJS.setup('".$this->getReference($block)."', {
					controlsBelow: true, // Display control bar below video instead of in front of
					controlsHiding: ".$out[0].", // Hide controls when mouse is not over the video
					defaultVolume: ".$out[1].", // Will be overridden by user's last volume if available
					flashVersion: 9, // Required flash version for fallback
					linksHiding: true // Hide download links when video is supported
				});
				if (".$out[2].")
					myPlayer.play();";
			break;
		case 'flowplayer_rtmp':
			return "flowplayer('".$this->getReference($block)."', {src: '".$out[0]."', wmode: 'opaque', width: '".$out[20]."', height: '".$out[21]."'}, {
	                clip: {
	                    url: '".$out[3]."',
	                    provider: 'rtmp',
	            	    autoPlay: ".$out[1].",
	            	    onBegin: function () {
	            	        this.setVolume(".$out[2].");
	            	    }
	                },
	                plugins: {
	                	controls: {
	                        url: '".$out[5]."', 
	                        play:".$out[6].",
		                	volume:".$out[7].",
		                	mute:".$out[8].",
		                	time:".$out[9].",
		                	stop:".$out[10].",
		                	playlist:false,
		                	fullscreen:".$out[11].",
		                 	scrubber: ".$out[12]."
		                },
	                	rtmp: {
	                		url: '".$out[13]."',
	                		netConnectionUrl: '".$out[4]."'
	                	}
	                }
});";
			break;				
		case 'other_file':
			return "";
			break;						
		case 'other_stream':
			return "";
			break;				
			
		}
	}
    
    function getReference($block=false) {
    	if ($block==true)
    		return str_replace('%fid%', $this->getVar('fid'), 'block_'.$this->getVar('reference'));
    	else
    		return str_replace('%fid%', $this->getVar('fid'), $this->getVar('reference'));
    }
    
    function getSource($mode='flash') {
    	if ($this->getVar('stream')==false)
    		return $this->getVar('raw');
    	switch ($mode) {
    		case 'rtmp':
    			return '#';
    			break;
    		case 'rtsp':
    			return (strlen($this->getVar('rtsp'))>0&&$this->getVar('stream')==true?$this->getVar('rtsp'):$this->getVar('raw'));
    			break;
    		case 'flash':
    			return (strlen($this->getVar('flash'))>0&&$this->getVar('stream')==true?$this->getVar('flash'):$this->getVar('raw'));
    			break;
    		case 'silverlight':
    			return (strlen($this->getVar('silverlight'))>0&&$this->getVar('stream')==true?$this->getVar('silverlight'):$this->getVar('raw'));
    			break;
    		case 'ios':
    			return (strlen($this->getVar('ios'))>0&&$this->getVar('stream')==true?$this->getVar('ios'):$this->getVar('raw'));
    			break;
			case 'http':
    			return (strlen($this->getVar('http'))>0&&$this->getVar('stream')==true?$this->getVar('http'):$this->getVar('raw'));
    			break;    			
    		case 'other':
    			return $this->getVar('source');
    			break;
    	}
    }
    
    function getSpecialWithUserAgent($agent = '') {
    	if (empty($agent)) {
    		$agent = $_SERVER['HTTP_USER_AGENT'];
    	}
    	$components = array('A' => 'speciala', 'B' => 'specialb');
    	foreach($components as $mode => $component) {
    		foreach(explode('|', $this->_ModConfig[$component.'_agents']) as $useragent) {
				if (!empty($useragent)) {
		    		if (strpos(strtolower(' '.$agent), strtolower($useragent))>0) {
		    			return $mode;
		    		}
				}
	    	}
    	}
    	return false;
    }
    
    function getModeWithUserAgent($agent='') {
    	if (empty($agent)) {
    		$agent = $_SERVER['HTTP_USER_AGENT'];
    	}
    	$components = array('ios', 'rtmp', 'http', 'html5', 'rtsp', 'flash', 'silverlight', 'other');
    	for($pos=1;$pos<=8;$pos++) {
    		foreach($components as $component) {
    			if (isset($this->_ModConfig['order_'.$component])) {
	    			if ($this->_ModConfig['order_'.$component]==$pos) {
	    				foreach(explode('|', $this->_ModConfig[$component.'_agents']) as $useragent) {
				    		if (!empty($useragent))
					    		if (strpos(strtolower(' '.$agent), strtolower($useragent))>0||strpos(strtolower($useragent), strtolower(' '.$agent))>0) {
					    			return $this->_ModConfig[$component.'_player'];
					    		}
				    	}			
	    			}
    			}
    		}
    	}
    	if ($this->getVar('mid')>0) {
    		$mimetypes_handler = xoops_getmodulehandler('mimetypes', 'flowplayer');
    		$mimetype = $mimetypes_handler->get($this->getVar('mid'));
    		if (is_object($mimetype))
    			switch( $mimetype->getVar('support') ) {
    				case '_MI_FLOWPLAYER_FLASH':
    					return $this->_ModConfig['flash_player'];
    					break;
    				case '_MI_FLOWPLAYER_HTML5':
    					return $this->_ModConfig['html5_player'];
    					break;
    				case '_MI_FLOWPLAYER_IOS':
    					return $this->_ModConfig['ios_player'];
    					break;
    				case '_MI_FLOWPLAYER_RTMP':
    					return $this->_ModConfig['rtmp_player'];
    					break;
    				case '_MI_FLOWPLAYER_RTSP':
    					return $this->_ModConfig['rstp_player'];
    					break;
    				case '_MI_FLOWPLAYER_SILVERLIGHT':
    					return $this->_ModConfig['silverlight_player'];
    					break;
    				case '_MI_FLOWPLAYER_HTTP':
    					return $this->_ModConfig['http_player'];
    					break;
    				case '_MI_FLOWPLAYER_OTHER':
    					return $this->_ModConfig['other_player'];
    					break;
    			}
    	}
    	return $this->_ModConfig['default_player'];
    }

}


/**
* XOOPS policies handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@chronolabs.coop>
* @package kernel
*/
class FlowplayerPlayerHandler extends XoopsPersistableObjectHandler
{

	var $_ModConfig = NULL;
	var $_Mod = NULL;
	
	function __construct(&$db) 
    {
    	$config_handler = xoops_gethandler('config');
		$module_handler = xoops_gethandler('module');
		$this->_Mod = $module_handler->getByDirname('flowplayer');
		if (is_object($this->_Mod))
			$this->_ModConfig = $config_handler->getConfigList($this->_Mod->getVar('mid'));

		$this->db = $db;
        parent::__construct($db, 'flowplayer_player', 'FlowplayerPlayer', "fid", "name");
    	
    }

	private function resetDefault() {
		$sql = "UPDATE " . $GLOBALS['xoopsDB']->prefix('flowplayer_player') . ' SET `default` = 0 WHERE 1 = 1';
		return $GLOBALS['xoopsDB']->queryF($sql);
	}
    
    function insert($obj, $force=true, $run_plugin = false) {
    	if ($obj->isNew()) {
    		$obj->setVar('created', time());
    	} else {
    		$obj->setVar('updated', time());
    	}
    	if ($obj->vars['default']['changed']==true&&$obj->getVar('default')==true) {
    		$this->resetDefault();
    	}
   		return parent::insert($obj, $force);
    }
    
    function getFilterCriteria($filter) {
    	$parts = explode('|', $filter);
    	$criteria = new CriteriaCompo();
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (!empty($var[1])&&!is_numeric($var[0])) {
    			$object = $this->create();
    			if (		$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTBOX || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTAREA) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%'.$var[1].'%', (isset($var[2])?$var[2]:'LIKE')));
    			} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_INT || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_DECIMAL || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_FLOAT ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));			
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ENUM ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));    				
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ARRAY ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%"'.$var[1].'";%', (isset($var[2])?$var[2]:'LIKE')));    				
				}
    		} elseif (!empty($var[1])&&is_numeric($var[0])) {
    			$criteria->add(new Criteria("'".$var[0]."'", $var[1]));
    		}
    	}
    	return $criteria;
    }
        
	function getFilterForm($filter, $field, $sort='created', $op = '', $fct = '') {
    	$ele = flowplayer_getFilterElement($filter, $field, $sort, $op, $fct);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }
    
	function getIP() {
    	static $ret = array();
    	if (empty($ret))
    		$ret = flowplayer_getIPData(false);
    	return $ret['ip'];
	}
	
	function getBasicModeWithUserAgent($agent='') {
    	if (empty($agent)) {
    		$agent = $_SERVER['HTTP_USER_AGENT'];
    	}
    	$components = array('ios', 'rtmp', 'http', 'html5', 'rtsp', 'flash', 'silverlight', 'other');
    	for($pos=1;$pos<=7;$pos++) {
    		foreach($components as $component) {
    			if (isset($this->_ModConfig['order_'.$component])) {
	    			if ($this->_ModConfig['order_'.$component]==$pos) {
	    				foreach(explode('|', $this->_ModConfig[$component.'_agents']) as $useragent) {
				    		if (!empty($useragent))
					    		if (strpos(strtolower(' '.$agent), strtolower($useragent))>0) {
					    			return $this->_ModConfig[$component.'_player'];
					    		}
				    	}			
	    			}
    			}
    		}
    	}
    	return $this->_ModConfig['default_player'];
    }
}

?>