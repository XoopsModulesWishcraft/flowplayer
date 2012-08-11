<?php

	// XOOPS Version
	define('_MI_FLOWPLAYER_NAME','FlowPlayer');
	define('_MI_FLOWPLAYER_DESCRIPTION','Flow Player is for display a stream or block for a stream');
	define('_MI_FLOWPLAYER_DIRNAME','flowplayer');
	
	// Form langauges
	define('_MI_FLOWPLAYER_NONE','None');
	
	// Javascripts and style sheets
	define('_MI_FLOWPLAYER_JQUERY','/browse.php?Frameworks/jquery/jquery.js');
	define('_MI_FLOWPLAYER_FLOWPLAYER','/modules/'._MI_FLOWPLAYER_DIRNAME.'/js/flowplayer-3.2.8.min.js');
	define('_MI_FLOWPLAYER_CORE','/modules/'._MI_FLOWPLAYER_DIRNAME.'/js/core.js');
	define('_MI_FLOWPLAYER_JSON_FUNCTIONS','/modules/'._MI_FLOWPLAYER_DIRNAME.'/js/json_functions.js');
	define('_MI_FLOWPLAYER_FLOWPLAYER_STYLE','/modules/'._MI_FLOWPLAYER_DIRNAME.'/language/%s/style.css');
	
	//Preferences
	define('_MI_FLOWPLAYER_SALT','Salt for Encryption');
	define('_MI_FLOWPLAYER_SALT_DESC','This is the salt for encryption (do not change on production machines!)');
	define('_MI_FLOWPLAYER_FORCE_JQUERY','Force Jquery');
	define('_MI_FLOWPLAYER_FORCE_JQUERY_DESC','Forces the loading of jquery if not included in theme!');
	
	//Version 1.03
	//Preferences
	define('_MI_FLOWPLAYER_IFRAME','Display Default as IFrame in Index');
	define('_MI_FLOWPLAYER_IFRAME_DESC','Display the default iFrame in Index of module for this type of content!');
	
	//Version 1.06
	//Preferences
	$module_handler =& xoops_gethandler('module');
	$GLOBALS['flowplayerModule'] =& XoopsModule::getByDirname(_MI_FLOWPLAYER_DIRNAME);
	if (is_object($GLOBALS['flowplayerModule'])) {
		$GLOBALS['flowplayerImageAdmin'] = $GLOBALS['flowplayerModule']->getInfo('icons32');
	
		// Admin menu
		define('_MI_FLOWPLAYER_TITLE_ADMENU0','Video\'s Dashboard');
		define('_MI_FLOWPLAYER_ICON_ADMENU0','../../'.$GLOBALS['flowplayerImageAdmin'].'/home.png');
		define('_MI_FLOWPLAYER_LINK_ADMENU0','admin/index.php?op=dashboard');	
		define('_MI_FLOWPLAYER_TITLE_ADMENU1','Video\'s List');
		define('_MI_FLOWPLAYER_ICON_ADMENU1','../../'.$GLOBALS['flowplayerImageAdmin'].'/flowplayer.video.png');
		define('_MI_FLOWPLAYER_LINK_ADMENU1','admin/index.php?op=player&fct=list');
		define('_MI_FLOWPLAYER_TITLE_ADMENU2','Mimetype\'s List');
		define('_MI_FLOWPLAYER_ICON_ADMENU2','../../'.$GLOBALS['flowplayerImageAdmin'].'/flowplayer.mimetypes.png');
		define('_MI_FLOWPLAYER_LINK_ADMENU2','admin/index.php?op=mimetypes&fct=list');		
		define('_MI_FLOWPLAYER_TITLE_ADMENU3','User-agent Spy');
		define('_MI_FLOWPLAYER_ICON_ADMENU3','../../'.$GLOBALS['flowplayerImageAdmin'].'/flowplayer.useragents.png');
		define('_MI_FLOWPLAYER_LINK_ADMENU3','admin/index.php?op=agents');
		define('_MI_FLOWPLAYER_TITLE_ADMENU4','About Flowplayer');
		define('_MI_FLOWPLAYER_ICON_ADMENU4','../../'.$GLOBALS['flowplayerImageAdmin'].'/about.png');
		define('_MI_FLOWPLAYER_LINK_ADMENU4','admin/index.php?op=about');
	}
	
	// Version 1.03
	// Preferences
	define('_MI_FLOWPLAYER_PASSKEY_DIFF','Number of seconds of difference to weigh passkey by');
	define('_MI_FLOWPLAYER_PASSKEY_DIFF_DESC','Total number of seconds a passkey to load a video session');
	define('_MI_FLOWPLAYER_PASSKEY_WEIGHT','Number of seconds of weight variance to weigh passkey by');
	define('_MI_FLOWPLAYER_PASSKEY_WEIGHT_DESC','Total number of seconds a weighted variance is added to difference to load a video session');

	// Version 1.10
	// Preferences
	define('_MI_FLOWPLAYER_RTMP_USERAGENTS','RTMP Player User-agents');
	define('_MI_FLOWPLAYER_RTMP_USERAGENTS_DESC','Seperate with a pipe, ie. |');
	define('_MI_FLOWPLAYER_FLASH_USERAGENTS','Flash Player User-agents');
	define('_MI_FLOWPLAYER_FLASH_USERAGENTS_DESC','Seperate with a pipe, ie. |');
	define('_MI_FLOWPLAYER_IOS_USERAGENTS','iOS (Apple) Player User-agents');
	define('_MI_FLOWPLAYER_IOS_USERAGENTS_DESC','Seperate with a pipe, ie. |');
	define('_MI_FLOWPLAYER_SILVERLIGHT_USERAGENTS','Silverlight Player Useragents');
	define('_MI_FLOWPLAYER_SILVERLIGHT_USERAGENTS_DESC','Seperate with a pipe, ie. |');
	define('_MI_FLOWPLAYER_RTSP_USERAGENTS','RTSP Player Useragents');
	define('_MI_FLOWPLAYER_RTSP_USERAGENTS_DESC','Seperate with a pipe, ie. |');
	define('_MI_FLOWPLAYER_OTHER_USERAGENTS','Other Player Useragents');
	define('_MI_FLOWPLAYER_OTHER_USERAGENTS_DESC','Seperate with a pipe, ie. |');
	define('_MI_FLOWPLAYER_HTML5_USERAGENTS','HTML5 Player Useragents');
	define('_MI_FLOWPLAYER_HTML5_USERAGENTS_DESC','Seperate with a pipe, ie. |');
	define('_MI_FLOWPLAYER_DEFAULT_PLAYER','Default Player');
	define('_MI_FLOWPLAYER_DEFAULT_PLAYER_DESC','This is the default player selected when nothing with a useragent is specified');
	define('_MI_FLOWPLAYER_RTMP_PLAYER','RTMP Player');
	define('_MI_FLOWPLAYER_RTMP_PLAYER_DESC','This is the RTMP player selected when a useragent is specified');
	define('_MI_FLOWPLAYER_FLASH_PLAYER','Flash Video Player');
	define('_MI_FLOWPLAYER_FLASH_PLAYER_DESC','This is the Flash Video player selected when a useragent is specified');
	define('_MI_FLOWPLAYER_IOS_PLAYER','iOS (Apple) Player');
	define('_MI_FLOWPLAYER_IOS_PLAYER_DESC','This is the iOS player selected when a useragent is specified');
	define('_MI_FLOWPLAYER_SILVERLIGHT_PLAYER','Silverlight Player');
	define('_MI_FLOWPLAYER_SILVERLIGHT_PLAYER_DESC','This is the Silverlight player selected when a useragent is specified');
	define('_MI_FLOWPLAYER_RTSP_PLAYER','RTSP Player');
	define('_MI_FLOWPLAYER_RTSP_PLAYER_DESC','This is the RTSP player selected when a useragent is specified');
	define('_MI_FLOWPLAYER_HTML5_PLAYER','HTML5 Player');
	define('_MI_FLOWPLAYER_HTML5_PLAYER_DESC','This is the HTML5 player selected when a useragent is specified');
	define('_MI_FLOWPLAYER_OTHER_PLAYER','Other Player');
	define('_MI_FLOWPLAYER_OTHER_PLAYER_DESC','This is the Other player selected when a useragent is specified');
	define('_MI_FLOWPLAYER_LOAD_FLOWPLAYER','Load Flowplayer in these player sessions');
	define('_MI_FLOWPLAYER_LOAD_FLOWPLAYER_DESC','This is the intances that load flowplayer (Do not change unless you know what you are doing)');
	define('_MI_FLOWPLAYER_LOAD_VIDEOJS','Load Video-js in these player sessions');
	define('_MI_FLOWPLAYER_LOAD_VIDEOJS_DESC','This is the intances that load HTML5 Video-js (Do not change unless you know what you are doing)');
	
	//Enumerators
	define('_MI_FLOWPLAYER_FLASH','Flash Player (Flowplayer)');
	define('_MI_FLOWPLAYER_HTML5','HTML5 Player (Video-js)'); 
	define('_MI_FLOWPLAYER_IOS','Apple OS Player (Video-js)');
	define('_MI_FLOWPLAYER_RTMP','RTMP Stream Player (Flowplayer)');
	define('_MI_FLOWPLAYER_RTSP','RTSP Stream Player (Video-js)');
	define('_MI_FLOWPLAYER_OTHER','Other Player');
	define('_MI_FLOWPLAYER_SILVERLIGHT','Silverlight Player');
	
	// HTML5 Scripts URL
	define('_MI_FLOWPLAYER_VIDEOJS','/modules/'._MI_FLOWPLAYER_DIRNAME.'/js/video.js');
	define('_MI_FLOWPLAYER_VIDEOJS_STYLE','/modules/'._MI_FLOWPLAYER_DIRNAME.'/language/%s/video-js.css');
	
	// Version 1.11
	// Preferences
	define('_MI_FLOWPLAYER_FILESIZEUPLD','File Size Upload');
	define('_MI_FLOWPLAYER_FILESIZEUPLD_DESC','File size allowed to be uploaded of images');
	define('_MI_FLOWPLAYER_ALLOWEDMIMETYPE','Allowed Mimetypes');
	define('_MI_FLOWPLAYER_ALLOWEDMIMETYPE_DESC','Allowed mimetypes for file upload of images');
	define('_MI_FLOWPLAYER_ALLOWEDEXTENSIONS','Allowed Extensions');
	define('_MI_FLOWPLAYER_ALLOWEDEXTENSIONS_DESC','Allowed extensions for uploading images');
	define('_MI_FLOWPLAYER_UPLOADAREAS','Upload Area');
	define('_MI_FLOWPLAYER_UPLOADAREAS_DESC','Area to be uploaded to');
	define('_MI_FLOWPLAYER_UPLOADAREAS_UPLOADS','uploads/');
	define('_MI_FLOWPLAYER_UPLOADAREAS_UPLOADS_UITABS','uploads/flowplayer/');
	define('_MI_FLOWPLAYER_ORDER_RTMP','Order RTMP User-agents is checked for');
	define('_MI_FLOWPLAYER_ORDER_RTMP_DESC','This is the order which the useragents are stepped through for a RTMP player is selected when a useragent is found.');
	define('_MI_FLOWPLAYER_ORDER_FLASH','Order which Flash Video User-agents is check for');
	define('_MI_FLOWPLAYER_ORDER_FLASH_DESC','This is the order which the useragents are stepped through for a Flash Video player is selected when a useragent is found.');
	define('_MI_FLOWPLAYER_ORDER_IOS','Order which iOS (Apple) User-agents is checked for');
	define('_MI_FLOWPLAYER_ORDER_IOS_DESC','This is the order which the useragents are stepped through for a iOS player is selected when a useragent is found.');
	define('_MI_FLOWPLAYER_ORDER_SILVERLIGHT','Order which Silverlight User-agents is checked for');
	define('_MI_FLOWPLAYER_ORDER_SILVERLIGHT_DESC','This is the order which the useragents are stepped through for a Silverlight player is selected when a useragent is found.');
	define('_MI_FLOWPLAYER_ORDER_RTSP','Order which RTSP User-agents is Checked for');
	define('_MI_FLOWPLAYER_ORDER_RTSP_DESC','This is the order which the useragents are stepped through for a RTSP player is selected when a useragent is found.');
	define('_MI_FLOWPLAYER_ORDER_HTML5','Order which HTML5 User-agents is checked for');
	define('_MI_FLOWPLAYER_ORDER_HTML5_DESC','This is the order which the useragents are stepped through for a HTML5 player is selected when a useragent is found.');
	define('_MI_FLOWPLAYER_ORDER_OTHER','Order which Other User-agents is checked for');
	define('_MI_FLOWPLAYER_ORDER_OTHER_DESC','This is the order which the useragents are stepped through for a Other player is selected when a useragent is found.');
	
	//Enumerators
	define('_MI_FLOWPLAYER_PLAYER_FLASH','Flash Player (Flowplayer)');
	define('_MI_FLOWPLAYER_PLAYER_HTML5','HTML5 Player (Video-js)'); 
	define('_MI_FLOWPLAYER_PLAYER_IOS','Apple OS Player (Video-js)');
	define('_MI_FLOWPLAYER_PLAYER_RTMP','RTMP Stream Player (Flowplayer)');
	define('_MI_FLOWPLAYER_PLAYER_RTSP','RTSP Stream Player (Video-js)');
	define('_MI_FLOWPLAYER_PLAYER_OTHER','Other Player');
	define('_MI_FLOWPLAYER_PLAYER_SILVERLIGHT','Silverlight Player');
	define('_MI_FLOWORDER_ORDER_1ST','Check Useragent Type First');
	define('_MI_FLOWORDER_ORDER_2ND','Check Useragent Type Second'); 
	define('_MI_FLOWORDER_ORDER_3RD','Check Useragent Type Third');
	define('_MI_FLOWORDER_ORDER_4TH','Check Useragent Type Forth');
	define('_MI_FLOWORDER_ORDER_5TH','Check Useragent Type Fifth');
	define('_MI_FLOWORDER_ORDER_6TH','Check Useragent Type Sixth');
	define('_MI_FLOWORDER_ORDER_7TH','Check Useragent Type Seventh');
	
	// Version 1.13
	define('_MI_FLOWPLAYER_RTMP_PLAYER_SECURE','RTMP Player HTML is Secure?');
	define('_MI_FLOWPLAYER_RTMP_PLAYER_SECURE_DESC',' RTMP Player HTML is Secure when selected when a useragent is specified');
	define('_MI_FLOWPLAYER_FLASH_PLAYER_SECURE','Flash Video Player HTML is Secure?');
	define('_MI_FLOWPLAYER_FLASH_PLAYER_SECURE_DESC',' Flash Video Player HTML is Secure when selected when a useragent is specified');
	define('_MI_FLOWPLAYER_IOS_PLAYER_SECURE','iOS (Apple) Player HTML is Secure?');
	define('_MI_FLOWPLAYER_IOS_PLAYER_SECURE_DESC',' iOS Player HTML is Secure when selected when a useragent is specified');
	define('_MI_FLOWPLAYER_SILVERLIGHT_PLAYER_SECURE','Silverlight Player HTML is Secure?');
	define('_MI_FLOWPLAYER_SILVERLIGHT_PLAYER_SECURE_DESC',' Silverlight Player HTML is Secure when selected when a useragent is specified');
	define('_MI_FLOWPLAYER_RTSP_PLAYER_SECURE','RTSP Player HTML is Secure?');
	define('_MI_FLOWPLAYER_RTSP_PLAYER_SECURE_DESC',' RTSP Player HTML is Secure when selected when a useragent is specified');
	define('_MI_FLOWPLAYER_HTML5_PLAYER_SECURE','HTML5 Player HTML is Secure?');
	define('_MI_FLOWPLAYER_HTML5_PLAYER_SECURE_DESC',' HTML5 Player HTML is Secure when selected when a useragent is specified');
	define('_MI_FLOWPLAYER_OTHER_PLAYER_SECURE','Other Player HTML is Secure?');
	define('_MI_FLOWPLAYER_OTHER_PLAYER_SECURE_DESC',' Other Player HTML is Secure when selected when a useragent is specified');
	
	// Version 1.14
	define('_MI_FLOWPLAYER_SPECIALA_USERAGENTS','Special Functions Useragent Functions A');
	define('_MI_FLOWPLAYER_SPECIALA_USERAGENTS_DESC','Functions for special function A when selected when a useragent is specified');
	define('_MI_FLOWPLAYER_SPECIALB_USERAGENTS','Special Functions Useragent - Functions B');
	define('_MI_FLOWPLAYER_SPECIALB_USERAGENTS_DESC','Functions for special function B when selected when a useragent is specified');
	define('_MI_FLOWPLAYER_HTTP_USERAGENTS','HTTP(s) Video Useragent');
	define('_MI_FLOWPLAYER_HTTP_USERAGENTS_DESC','Functions for HTTP Sourced video when selected when a useragent is specified');
	define('_MI_FLOWPLAYER_HTTP_PLAYER_SECURE','HTTP(s) Player HTML is Secure?');
	define('_MI_FLOWPLAYER_HTTP_PLAYER_SECURE_DESC',' HTTP(s) Player HTML is Secure when selected when a useragent is specified');
	define('_MI_FLOWORDER_ORDER_8TH','Check Useragent Type Eighth');
	define('_MI_FLOWPLAYER_PLAYER_HTTP','HTTP(s) Player');
	define('_MI_FLOWPLAYER_ORDER_HTTP','Order which HTTP(s) User-agents is checked for');
	define('_MI_FLOWPLAYER_ORDER_HTTP_DESC','This is the order which the useragents are stepped through for a HTTP(s) player is selected when a useragent is found.');
	define('_MI_FLOWPLAYER_HTTP','HTTP(s) Player');
	define('_MI_FLOWPLAYER_HTTP_PLAYER','HTTP(s) Player');
	define('_MI_FLOWPLAYER_HTTP_PLAYER_DESC','This is the HTTP(s) player selected when a useragent is specified');
?>