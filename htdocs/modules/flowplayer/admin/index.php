<?php
	
	include('header.php');
		
	xoops_loadLanguage('admin', 'flowplayer');
	
	xoops_cp_header();
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:"dashboard";
	$fct = isset($_REQUEST['fct'])?$_REQUEST['fct']:"";
	$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
	$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
	$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
	$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
	$filter = !empty($_REQUEST['filter'])?''.$_REQUEST['filter'].'':'1,1';
	
	switch($op) {
	case "dashboard":
	default:
		echo flowplayer_adminMenu(0);
		error_reporting(E_ALL);
		$player_handler = xoops_getmodulehandler('player', 'flowplayer');
		$mimetypes_handler = xoops_getmodulehandler('mimetypes', 'flowplayer');
	 	$indexAdmin = new ModuleAdmin();
	    $indexAdmin->addInfoBox(_AM_FLOWPLAYER_ADMIN_COUNTS);
	    $indexAdmin->addInfoBoxLine(_AM_FLOWPLAYER_ADMIN_COUNTS, "<label>"._AM_FLOWPLAYER_ADMIN_THEREARE_FLATFILES."</label>", $player_handler->getCount(new Criteria('stream', '0', '=')), 'Green');
	    $indexAdmin->addInfoBoxLine(_AM_FLOWPLAYER_ADMIN_COUNTS, "<label>"._AM_FLOWPLAYER_ADMIN_THEREARE_RTMPSTREAMS."</label>", $player_handler->getCount(new Criteria('LENGTH(`rtmp`)', '0', '>')), 'Green');
	    $indexAdmin->addInfoBoxLine(_AM_FLOWPLAYER_ADMIN_COUNTS, "<label>"._AM_FLOWPLAYER_ADMIN_THEREARE_RTSPSTREAMS."</label>", $player_handler->getCount(new Criteria('LENGTH(`rtsp`)', '0', '>')), 'Green');
	    $indexAdmin->addInfoBoxLine(_AM_FLOWPLAYER_ADMIN_COUNTS, "<label>"._AM_FLOWPLAYER_ADMIN_THEREARE_FLASHSTREAMS."</label>", $player_handler->getCount(new Criteria('LENGTH(`flash`)', '0', '>')), 'Green');
	    $indexAdmin->addInfoBoxLine(_AM_FLOWPLAYER_ADMIN_COUNTS, "<label>"._AM_FLOWPLAYER_ADMIN_THEREARE_SILVERLIGHTSTREAMS."</label>", $player_handler->getCount(new Criteria('LENGTH(`silverlight`)', '0', '>')), 'Green');
	    $indexAdmin->addInfoBoxLine(_AM_FLOWPLAYER_ADMIN_COUNTS, "<label>"._AM_FLOWPLAYER_ADMIN_THEREARE_IOSSTREAMS."</label>", $player_handler->getCount(new Criteria('LENGTH(`ios`)', '0', '>')), 'Green');
	    $indexAdmin->addInfoBoxLine(_AM_FLOWPLAYER_ADMIN_COUNTS, "<label>"._AM_FLOWPLAYER_ADMIN_THEREARE_HTTPSTREAMS."</label>", $player_handler->getCount(new Criteria('LENGTH(`http`)', '0', '>')), 'Green');
	    $indexAdmin->addInfoBoxLine(_AM_FLOWPLAYER_ADMIN_COUNTS, "<label>"._AM_FLOWPLAYER_ADMIN_THEREARE_MIMETYPES."</label>", $mimetypes_handler->getCount(), 'Purple');
	    $players = $player_handler->getObjects(new Criteria('`default`', '1'), false);
		if (isset($players[0])) {
		    if (is_object($players[0])) {
				$player = $players[0];
			    $indexAdmin->addInfoBox(_AM_FLOWPLAYER_ADMIN_DEFAULT);
			    $indexAdmin->addInfoBoxLine(_AM_FLOWPLAYER_ADMIN_DEFAULT, "<iframe src='".XOOPS_URL.'/modules/flowplayer/?fid='.$player->getVar('fid')."&iframe=1&width=320px&height=200px' style='width:320px;height:200px;'></iframe>", '', 'Green');
			}
		}
	    echo $indexAdmin->renderIndex();
		break;	
	case "about":
		echo flowplayer_adminMenu(4);
		$paypalitemno='FLOWPLAYER106';
		$aboutAdmin = new ModuleAdmin();
		$about = $aboutAdmin->renderabout($paypalitemno, false);
		$donationform = array(	0 => '<form name="donation" id="donation" action="http://www.chronolabs.coop/modules/xpayment/" method="post" onsubmit="return xoopsFormValidate_donation();">',
								1 => '<table class="outer" cellspacing="1" width="100%"><tbody><tr><th colspan="2">'.constant('_AM_FLOWPLAYER_ABOUT_MAKEDONATE').'</th></tr><tr align="left" valign="top"><td class="head"><div class="xoops-form-element-caption-required"><span class="caption-text">Donation Amount</span><span class="caption-marker">*</span></div></td><td class="even"><select size="1" name="item[A][amount]" id="item[A][amount]" title="Donation Amount"><option value="5">5.00 AUD</option><option value="10">10.00 AUD</option><option value="20">20.00 AUD</option><option value="40">40.00 AUD</option><option value="60">60.00 AUD</option><option value="80">80.00 AUD</option><option value="90">90.00 AUD</option><option value="100">100.00 AUD</option><option value="200">200.00 AUD</option></select></td></tr><tr align="left" valign="top"><td class="head"></td><td class="even"><input class="formButton" name="submit" id="submit" value="'._SUBMIT.'" title="'._SUBMIT.'" type="submit"></td></tr></tbody></table>',
								2 => '<input name="op" id="op" value="createinvoice" type="hidden"><input name="plugin" id="plugin" value="donations" type="hidden"><input name="donation" id="donation" value="1" type="hidden"><input name="drawfor" id="drawfor" value="Chronolabs Co-Operative" type="hidden"><input name="drawto" id="drawto" value="%s" type="hidden"><input name="drawto_email" id="drawto_email" value="%s" type="hidden"><input name="key" id="key" value="%s" type="hidden"><input name="currency" id="currency" value="AUD" type="hidden"><input name="weight_unit" id="weight_unit" value="kgs" type="hidden"><input name="item[A][cat]" id="item[A][cat]" value="XDN%s" type="hidden"><input name="item[A][name]" id="item[A][name]" value="Donation for %s" type="hidden"><input name="item[A][quantity]" id="item[A][quantity]" value="1" type="hidden"><input name="item[A][shipping]" id="item[A][shipping]" value="0" type="hidden"><input name="item[A][handling]" id="item[A][handling]" value="0" type="hidden"><input name="item[A][weight]" id="item[A][weight]" value="0" type="hidden"><input name="item[A][tax]" id="item[A][tax]" value="0" type="hidden"><input name="return" id="return" value="http://www.chronolabs.coop/modules/donations/success.php" type="hidden"><input name="cancel" id="cancel" value="http://www.chronolabs.coop/modules/donations/success.php" type="hidden"></form>',																'D'=>'',
								3 => '',
								4 => '<!-- Start Form Validation JavaScript //-->
<script type="text/javascript">
<!--//
function xoopsFormValidate_donation() { var myform = window.document.donation; 
var hasSelected = false; var selectBox = myform.item[A][amount];for (i = 0; i < selectBox.options.length; i++ ) { if (selectBox.options[i].selected == true && selectBox.options[i].value != \'\') { hasSelected = true; break; } }if (!hasSelected) { window.alert("Please enter Donation Amount"); selectBox.focus(); return false; }return true;
}
//--></script>
<!-- End Form Validation JavaScript //-->');
	$paypalform = array(	0 => '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">',
								1 => '<input name="cmd" value="_s-xclick" type="hidden">',
								2 => '<input name="hosted_button_id" value="%s" type="hidden">',
								3 => '<img alt="" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" height="1" border="0" width="1">',
								4 => '<input src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" border="0" type="image">',
								5 => '</form>');
		for($key=0;$key<=4;$key++) {
			switch ($key) {
				case 2:
					$donationform[$key] =  sprintf($donationform[$key], $GLOBALS['xoopsConfig']['sitename'] . ' - ' . (strlen($GLOBALS['xoopsUser']->getVar('name'))>0?$GLOBALS['xoopsUser']->getVar('name'). ' ['.$GLOBALS['xoopsUser']->getVar('uname').']':$GLOBALS['xoopsUser']->getVar('uname')), $GLOBALS['xoopsUser']->getVar('email'), XOOPS_LICENSE_KEY, strtoupper($GLOBALS['flowplayerModule']->getVar('dirname')),  strtoupper($GLOBALS['flowplayerModule']->getVar('dirname')). ' '.$GLOBALS['flowplayerModule']->getVar('name'));
					break;
			}
		}
		
		$istart = strpos($about, ($paypalform[0]), 1);
		$iend = strpos($about, ($paypalform[5]), $istart+1)+strlen($paypalform[5])-1;
		echo (substr($about, 0, $istart-1));
		echo implode("\n", $donationform);
		echo (substr($about, $iend+1, strlen($about)-$iend-1));
		break;
	case "agents":	
		flowplayer_adminMenu(3);
		
		include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
		xoops_load('XoopsCache');
		$ret = XoopsCache::read('flowplayer_user_agents');
		asort($ret, SORT_DESC);
		$ttl = count($ret);
		$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
		$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
		foreach (array(	'time','player','agents','user') as $id => $key) {
			$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="#">'.(defined('_AM_FLOWPLAYER_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_FLOWPLAYER_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_FLOWPLAYER_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
		}
		$GLOBALS['xoopsTpl']->assign('limit', $limit);
		$GLOBALS['xoopsTpl']->assign('start', $start);
		$GLOBALS['xoopsTpl']->assign('order', $order);
		$GLOBALS['xoopsTpl']->assign('sort', $sort);
		$GLOBALS['xoopsTpl']->assign('filter', $filter);
		$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['flowplayerModuleConfig']);
		$s=0;
		$i=0;
		foreach($ret as $time => $agent) {
			if (is_array($agent)&&$s>=$start&&$i<=$limit) {
				$GLOBALS['xoopsTpl']->append('useragents', array('time'=>date(_DATESTRING, $time), 'player'=>$agent['player'], 'user'=>$agent['user'], 'useragent'=>$agent['useragent']));
				$i++;
			}
			$s++;
		}
		$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
		$GLOBALS['xoopsTpl']->display('db:flowplayer_cpanel_useragents_list.html');
		break;		
		
		
	case "player":	
			switch ($fct)
			{
				default:
				case "list":				
					flowplayer_adminMenu(1);

					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
					$player_handler =& xoops_getmodulehandler('player', 'flowplayer');
					$criteria = $player_handler->getFilterCriteria($filter);
					$ttl = $player_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
					
					foreach (array(	'fid','name','raw','reference','height','width','default','created','updated') as $id => $key) {
						$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_FLOWPLAYER_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_FLOWPLAYER_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_FLOWPLAYER_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $player_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('filter', $filter);
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['flowplayerModuleConfig']);
					
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
					
					$players = $player_handler->getObjects($criteria, true);
					foreach($players as $cid => $player) {
						if (is_object($player))
							$GLOBALS['xoopsTpl']->append('players', $player->toArray());
					}
					
					$GLOBALS['xoopsTpl']->assign('form', flowplayer_player_get_form(false));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:flowplayer_cpanel_player_list.html');
					break;		
					
				case "new":
				case "edit":
					
					flowplayer_adminMenu(1);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
										
					$player_handler =& xoops_getmodulehandler('player', 'flowplayer');
					if (isset($_REQUEST['id'])) {
						$player = $player_handler->get(intval($_REQUEST['id']));
					} else {
						$player = $player_handler->create();
					}
					
					$GLOBALS['xoopsTpl']->assign('form', flowplayer_player_get_form($player));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:flowplayer_cpanel_player_edit.html');
					break;
				case "save":
					
					$player_handler =& xoops_getmodulehandler('player', 'flowplayer');
					$id=0;
					if ($id=intval($_REQUEST['id'])) {
						$player = $player_handler->get($id);
					} else {
						$player = $player_handler->create();
					}
					$player->setVars($_POST[$id]);
					if (!$id=$player_handler->insert($player)) {
						redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_PLAYER_FAILEDTOSAVE);
						exit(0);
					} else {
						if (isset($_FILES['image'])&&!empty($_FILES['image']['name'])) {
							if (!is_dir($GLOBALS['xoops']->path($GLOBALS['flowplayerModuleConfig']['upload_areas']))) {
								foreach(explode('\\', $GLOBALS['xoops']->path($GLOBALS['flowplayerModuleConfig']['upload_areas'])) as $folders)
									foreach(explode('/', $folders) as $folder) {
										$path .= DS . $folder;
										mkdir($path, 0777);
									}
							}
							include_once($GLOBALS['xoops']->path('modules/flowplayer/include/uploader.php'));
							$player = $player_handler->get($id);
							$uploader = new FlowplayerMediaUploader($GLOBALS['xoops']->path($GLOBALS['flowplayerModuleConfig']['upload_areas']), explode('|', $GLOBALS['flowplayerModuleConfig']['allowed_mimetype']), $GLOBALS['flowplayerModuleConfig']['filesize_upload'], 0, 0, explode('|', $GLOBALS['flowplayerModuleConfig']['allowed_extensions']));
							$uploader->setPrefix(substr(md5(microtime(true)), mt_rand(0,20), 13));
							if ($uploader->fetchMedia('image')) {
							  	if (!$uploader->upload()) {
							    	flowplayer_adminMenu(1);
							    	echo $uploader->getErrors();
									flowplayer_footer_adminMenu();
									xoops_cp_footer();
									exit(0);
						  	    } else {
						  	    	
							      	if (strlen($player->getVar('poster')))
							      		unlink($GLOBALS['xoops']->path($player->getVar('path')).$player->getVar('poster'));
							      	
							      	$player->setVar('path', $GLOBALS['flowplayerModuleConfig']['upload_areas']);
							      	$player->setVar('poster', $uploader->getSavedFileName());
							      	@$player_handler->insert($player);
							    }      	
						  	} else {
						  		flowplayer_adminMenu(1);
						       	echo $uploader->getErrors();
								flowplayer_footer_adminMenu();
								xoops_cp_footer();
								exit(0);
						   	}
						}	
						switch($_REQUEST['mode']) {
							case 'new':
								redirect_header('index.php?op='.$op.'&fct=edit&id='.$id, 10, _AM_MSG_PLAYER_SAVEDOKEY);
								break;
							default:
							case 'edit':
								redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_PLAYER_SAVEDOKEY);
								break;
						}
						exit(0);					
					}
					break;
				case "savelist":
					
					$player_handler =& xoops_getmodulehandler('player', 'flowplayer');
					foreach($_REQUEST['id'] as $id) {
						$player = $player_handler->get($id);
						$player->setVars($_POST[$id]);
						if (!$player_handler->insert($player)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_PLAYER_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_PLAYER_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$player_handler =& xoops_getmodulehandler('player', 'flowplayer');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$player = $player_handler->get($id);
						if (!$player_handler->delete($player)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_PLAYER_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_PLAYER_DELETED);
							exit(0);
						}
					} else {
						$player = $player_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'], 'limit'=>$_REQUEST['limit'], 'start'=>$_REQUEST['start'], 'order'=>$_REQUEST['order'], 'sort'=>$_REQUEST['sort'], 'filter'=>$_REQUEST['filter']), 'index.php', sprintf(_AM_MSG_PLAYER_DELETE, $player->getVar('name')));
					}
					break;
			}
			break;
		case "mimetypes":	
			switch ($fct)
			{
				default:
				case "list":				
					flowplayer_adminMenu(2);

					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
					$mimetypes_handler =& xoops_getmodulehandler('mimetypes', 'flowplayer');
					$criteria = $mimetypes_handler->getFilterCriteria($filter);
					$ttl = $mimetypes_handler->getCount($criteria);
					$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
					
					$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
					$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
					
					foreach (array(	'mid','support','name','mimetype','codecs','default','created','updated') as $id => $key) {
						$GLOBALS['xoopsTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.str_replace('_','-',$key).'&order='.((str_replace('_','-',$key)==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&filter='.$filter.'">'.(defined('_AM_FLOWPLAYER_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_AM_FLOWPLAYER_TH_'.strtoupper(str_replace('-','_',$key))):'_AM_FLOWPLAYER_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
						$GLOBALS['xoopsTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $mimetypes_handler->getFilterForm($filter, $key, $sort, $op, $fct));
					}
					
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('filter', $filter);
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['flowplayerModuleConfig']);
					
					$criteria->setStart($start);
					$criteria->setLimit($limit);
					$criteria->setSort('`'.$sort.'`');
					$criteria->setOrder($order);
					
					$mimetypess = $mimetypes_handler->getObjects($criteria, true);
					foreach($mimetypess as $cid => $mimetypes) {
						if (is_object($mimetypes))
							$GLOBALS['xoopsTpl']->append('mimetypes', $mimetypes->toArray());
					}
					
					$GLOBALS['xoopsTpl']->assign('form', flowplayer_mimetypes_get_form(false));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:flowplayer_cpanel_mimetypes_list.html');
					break;		
					
				case "new":
				case "edit":
					
					flowplayer_adminMenu(2);
					
					include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
					
										
					$mimetypes_handler =& xoops_getmodulehandler('mimetypes', 'flowplayer');
					if (isset($_REQUEST['id'])) {
						$mimetypes = $mimetypes_handler->get(intval($_REQUEST['id']));
					} else {
						$mimetypes = $mimetypes_handler->create();
					}
					
					$GLOBALS['xoopsTpl']->assign('form', flowplayer_mimetypes_get_form($mimetypes));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->display('db:flowplayer_cpanel_mimetypes_edit.html');
					break;
				case "save":
					
					$mimetypes_handler =& xoops_getmodulehandler('mimetypes', 'flowplayer');
					$id=0;
					if ($id=intval($_REQUEST['id'])) {
						$mimetypes = $mimetypes_handler->get($id);
					} else {
						$mimetypes = $mimetypes_handler->create();
					}
					$mimetypes->setVars($_POST[$id]);
					if (!$id=$mimetypes_handler->insert($mimetypes)) {
						redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_MIMETYPES_FAILEDTOSAVE);
						exit(0);
					} else {
						switch($_REQUEST['mode']) {
							case 'new':
								redirect_header('index.php?op='.$op.'&fct=edit&id='.$id, 10, _AM_MSG_MIMETYPES_SAVEDOKEY);
								break;
							default:
							case 'edit':
								redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_MIMETYPES_SAVEDOKEY);
								break;
						}
						exit(0);					
					}
					break;
				case "savelist":
					
					$mimetypes_handler =& xoops_getmodulehandler('mimetypes', 'flowplayer');
					foreach($_REQUEST['id'] as $id) {
						$mimetypes = $mimetypes_handler->get($id);
						$mimetypes->setVars($_POST[$id]);
						if (!$mimetypes_handler->insert($mimetypes)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_MIMETYPES_FAILEDTOSAVE);
							exit(0);
						} 
					}
					redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_MIMETYPES_SAVEDOKEY);
					exit(0);
					break;				
				case "delete":	
								
					$mimetypes_handler =& xoops_getmodulehandler('mimetypes', 'flowplayer');
					$id=0;
					if (isset($_POST['id'])&&$id=intval($_POST['id'])) {
						$mimetypes = $mimetypes_handler->get($id);
						if (!$mimetypes_handler->delete($mimetypes)) {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_MIMETYPES_FAILEDTODELETE);
							exit(0);
						} else {
							redirect_header('index.php?op='.$op.'&fct=list&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter, 10, _AM_MSG_MIMETYPES_DELETED);
							exit(0);
						}
					} else {
						$mimetypes = $mimetypes_handler->get(intval($_REQUEST['id']));
						xoops_confirm(array('id'=>$_REQUEST['id'], 'op'=>$_REQUEST['op'], 'fct'=>$_REQUEST['fct'], 'limit'=>$_REQUEST['limit'], 'start'=>$_REQUEST['start'], 'order'=>$_REQUEST['order'], 'sort'=>$_REQUEST['sort'], 'filter'=>$_REQUEST['filter']), 'index.php', sprintf(_AM_MSG_MIMETYPES_DELETE, $mimetypes->getVar('name')));
					}
					break;
			}
			break;			
	}
	
	flowplayer_footer_adminMenu();
	xoops_cp_footer();
?>