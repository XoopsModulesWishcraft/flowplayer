<?php
	include ('header.php');
	
	if (empty($agent))
    	$agent = $_SERVER['HTTP_USER_AGENT'];
    		
	$fid = isset($_GET['fid'])?intval($_GET['fid']):0;
	$width = isset($_GET['width'])?intval($_GET['width']):'';
	$height = isset($_GET['height'])?intval($_GET['height']):'';
	
	$player_handler = xoops_getmodulehandler('player', 'flowplayer');
	if ($fid!=0) {
		$player = $player_handler->get($fid);
	} else {
		$players = $player_handler->getObjects(new Criteria('`default`', '1'), false);
		if (is_object($players[0]))
			$player = $players[0];
	}
	$mode = $player->getModeWithUserAgent();
	if (!$GLOBALS['flowplayerModuleConfig']['iframe']&&(!isset($_GET['iframe']))) {
		if (is_object($player)) {
			if ($GLOBALS['flowplayerModuleConfig'][$mode.'_secure']==true) {
				$xoopsOption['template_main'] = 'flowplayer_index_'.$mode.'_player.html';
				include($GLOBALS['xoops']->path('/header.php'));
				$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$data = array();
				$data = $player->toArray();
				$data['mode'] = $mode;
				$data['width'] = (!empty($height)&&!empty($width)&&$width&&$height?$width:($player->getSpecialWithUserAgent($agent)=='A'?$player->getVar('speciala_width'):($player->getSpecialWithUserAgent($agent)=='B'?$player->getVar('specialb_width'):($player->getVar('width')))));
    			$data['height'] = (!empty($height)&&!empty($height)&&$width&&$height?$height:($player->getSpecialWithUserAgent($agent)=='A'?$player->getVar('speciala_height'):($player->getSpecialWithUserAgent($agent)=='B'?$player->getVar('specialb_height'):($player->getVar('height')))));
    			$data['source'] = $player->getSource($mode);
				$data['id'] = $player->getReference(false);
				$GLOBALS['xoopsTpl']->assign('player', $data);
				if (isset($data['mimetype']))
	    			$GLOBALS['xoopsTpl']->assign('mimetype', $data['mimetype']);
				$GLOBALS['xoTheme']->addScript('', array('type'=>'text/javascript'), $player->getJS(false, (empty($width)?$player->getVar('width'):$width), (empty($height)?$player->getVar('height'):$height)));
				include($GLOBALS['xoops']->path('/footer.php'));
			} else {
				$xoopsOption['template_main'] = 'flowplayer_json_'.$mode.'_player.html';
				include($GLOBALS['xoops']->path('/header.php'));
				$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$data = array();
				$data = $player->toArray();
				$data['mode'] = $mode;
				$data['width'] = (!empty($height)&&!empty($width)&&$width&&$height?$width:($player->getSpecialWithUserAgent($agent)=='A'?$player->getVar('speciala_width'):($player->getSpecialWithUserAgent($agent)=='B'?$player->getVar('specialb_width'):($player->getVar('width')))));
    			$data['height'] = (!empty($height)&&!empty($height)&&$width&&$height?$height:($player->getSpecialWithUserAgent($agent)=='A'?$player->getVar('speciala_height'):($player->getSpecialWithUserAgent($agent)=='B'?$player->getVar('specialb_height'):($player->getVar('height')))));
				$data['source'] = $player->getSource($mode);
				$data['id'] = $player->getReference(false);
				$GLOBALS['xoopsTpl']->assign('player', $data);
				if (isset($data['mimetype']))
	    			$GLOBALS['xoopsTpl']->assign('mimetype', $data['mimetype']);
				$GLOBALS['xoTheme']->addScript('', array('type'=>'text/javascript'), $player->getInsecureJS(false, (empty($width)?$player->getVar('width'):$width), (empty($height)?$player->getVar('height'):$height)));
				include($GLOBALS['xoops']->path('/footer.php'));
			}
		} else {
			$xoopsOption['template_main'] = 'flowplayer_index.html';
			include($GLOBALS['xoops']->path('/header.php'));
			xoops_error(_MN_FLOWPLAYER_NO_DEFAULT, _MN_FLOWPLAYER_NO_DEFAULT_TITLE);
			$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
			include($GLOBALS['xoops']->path('/footer.php'));
		}
	} else {
		if (is_object($player)) {
			$mode = $player->getModeWithUserAgent();
			$xoopsOption['template_main'] = 'flowplayer_index_iframe_'.$mode.'_player.html';
			global $xoopsOption, $xoopsConfig, $flowplayerModule;
			
		    // include Smarty template engine and initialize it
		    require_once $GLOBALS['xoops']->path('class/template.php');
		    require_once $GLOBALS['xoops']->path('class/theme.php');
		    require_once $GLOBALS['xoops']->path('class/theme_blocks.php');
			
		    if (@$xoopsOption['template_main']) {
		        if (false === strpos($xoopsOption['template_main'], ':')) {
		            $xoopsOption['template_main'] = 'db:' . $xoopsOption['template_main'];
		        }
		    }
			
		    $xoopsThemeFactory = null;
		    $xoopsThemeFactory = new xos_opal_ThemeFactory();
		    $xoopsThemeFactory->allowedThemes = $xoopsConfig['theme_set_allowed'];
		    $xoopsThemeFactory->defaultTheme = $xoopsConfig['theme_set'];
			
		    /**
		     * @var xos_opal_Theme
		     */
		    $xoTheme  =& $xoopsThemeFactory->createInstance(array('contentTemplate' => @$xoopsOption['template_main']));
		    $GLOBALS['xoopsTpl'] =& $xoTheme->template;
			
		    $GLOBALS['xoTheme']->addScript(XOOPS_URL._MI_FLOWPLAYER_JQUERY, array('type'=>'text/javascript'));
			$GLOBALS['loaded_jquery']=true;
			
			$data = array();
			$data = $player->toArray();
			$data['mode'] = $mode;
			$data['width'] = (!empty($height)&&!empty($width)&&$width&&$height?$width:($player->getSpecialWithUserAgent($agent)=='A'?$player->getVar('speciala_width'):($player->getSpecialWithUserAgent($agent)=='B'?$player->getVar('specialb_width'):($player->getVar('width')))));
    		$data['height'] = (!empty($height)&&!empty($height)&&$width&&$height?$height:($player->getSpecialWithUserAgent($agent)=='A'?$player->getVar('speciala_height'):($player->getSpecialWithUserAgent($agent)=='B'?$player->getVar('specialb_height'):($player->getVar('height')))));
			$data['source'] = $player->getSource($mode);
			$data['id'] = $player->getReference(false);
			$html = $player->getHTML(false, $data['width'], $data['height']);
			$GLOBALS['xoopsTpl']->assign('player', $data);
			$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
			if (isset($data['mimetype']))
    			$GLOBALS['xoopsTpl']->assign('mimetype', $data['mimetype']);
    		if ($GLOBALS['flowplayerModuleConfig'][$mode.'_secure']==true) {
    			$GLOBALS['xoopsTpl']->assign('contents', '');
				$GLOBALS['xoTheme']->addScript('', array('type'=>'text/javascript'), $player->getJS(false, (empty($width)?$player->getVar('width'):$width), (empty($height)?$player->getVar('height'):$height)));
    		} else { 
				$html .= "\n<script type='text/javascript'>\n".$player->getInsecureJS(false, (empty($width)?$player->getVar('width'):$width), (empty($height)?$player->getVar('height'):$height))."\n</script>";
				$GLOBALS['xoopsTpl']->assign('contents', $html);
    		}
			$GLOBALS['xoTheme']->addStylesheet('', array('type'=>'text/css'), 'body { margin: 0 0 0 0; padding: 0 0 0 0;}
html { margin: 0 0 0 0; padding: 0 0 0 0;}');

			$xoopsPreload =& XoopsPreload::getInstance();
			$xoopsPreload->triggerEvent('core.header.addmeta');
			
		    $old = array(
	            'robots',
	            'keywords',
	            'description',
	            'rating',
	            'author',
	            'copyright');
	        
	        foreach ($GLOBALS['xoTheme']->metas['meta'] as $name => $value) {
	            if (in_array($name, $old)) {
	                $GLOBALS['xoopsTpl']->assign("xoops_meta_$name", htmlspecialchars($value, ENT_QUOTES));
	                unset($GLOBALS['xoTheme']->metas['meta'][$name]);
	            }
	        }
	        
	        // We assume no overlap between $GLOBALS['xoopsOption']['xoops_module_header'] and $GLOBALS['xoopsTpl']->get_template_vars( 'xoops_module_header' ) ?
	        $header = empty($GLOBALS['xoopsOption']['xoops_module_header']) ? $GLOBALS['xoopsTpl']->get_template_vars('xoops_module_header') : $GLOBALS['xoopsOption']['xoops_module_header'];
	        $GLOBALS['xoopsTpl']->assign('xoops_module_header', $GLOBALS['xoTheme']->renderMetas(null, true) . "\n" . $header);
	        $GLOBALS['xoopsTpl']->assign('xoops_pagetitle', $player->getVar('name'));
		    $GLOBALS['xoopsTpl']->xoops_setCaching(0);
            $GLOBALS['xoopsTpl']->display($xoopsOption['template_main']);
            
		} else {
			$xoopsOption['template_main'] = 'flowplayer_index_iframe.html';
			global $xoopsOption, $xoopsConfig, $flowplayerModule;
	
		    $xoopsOption['theme_use_smarty'] = 0;
		
		    // include Smarty template engine and initialize it
		    require_once $GLOBALS['xoops']->path('class/template.php');
		    require_once $GLOBALS['xoops']->path('class/theme.php');
		    require_once $GLOBALS['xoops']->path('class/theme_blocks.php');
		
		    if (@$xoopsOption['template_main']) {
		        if (false === strpos($xoopsOption['template_main'], ':')) {
		            $xoopsOption['template_main'] = 'db:' . $xoopsOption['template_main'];
		        }
		    }
		
		    $xoopsThemeFactory = null;
		    $xoopsThemeFactory = new xos_opal_ThemeFactory();
		    $xoopsThemeFactory->allowedThemes = $xoopsConfig['theme_set_allowed'];
		    $xoopsThemeFactory->defaultTheme = $xoopsConfig['theme_set'];
		
		    /**
		     * @var xos_opal_Theme
		     */
		    $xoTheme  =& $xoopsThemeFactory->createInstance(array('contentTemplate' => @$xoopsOption['template_main']));
		    $GLOBALS['xoopsTpl'] =& $xoTheme->template;
		
		    
			xoops_error(_MN_FLOWPLAYER_NO_DEFAULT, _MN_FLOWPLAYER_NO_DEFAULT_TITLE);
			$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
			
            $GLOBALS['xoopsTpl']->xoops_setCaching(0);
            $GLOBALS['xoopsTpl']->display($xoopsOption['template_main']);
		}		
	}