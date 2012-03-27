<?php


function xoops_module_update_flowplayer(&$module) {
	
	$sql = array();
	
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `stream` TINYINT(2) UNSIGNED DEFAULT '0'";
	//$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `clipsource` VARCHAR(500) DEFAULT ''";
	//$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `netsource` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `level` INT(5) UNSIGNED DEFAULT '100'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `autoplay` TINYINT(2) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `muted` TINYINT(2) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `play` TINYINT(2) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `volume` TINYINT(2) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `mute` TINYINT(2) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `time` TINYINT(2) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `stop` TINYINT(2) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `fullscreen` TINYINT(2) UNSIGNED DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `scrubber` TINYINT(2) UNSIGNED DEFAULT '0'";

	// Version 1.10
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` CHANGE COLUMN `clipsource` `rtmp_server` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` CHANGE COLUMN `netsource` `rtmp` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `rtmp_server` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `rtmp` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `flash` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `ios` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `silverlight` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `rtsp` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `path` VARCHAR(255) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `poster` VARCHAR(255) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `controls` TINYINT(2) UNSIGNED DEFAULT '0'";
	
	$question = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_mimetypes')."` (  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,  `support` enum('_MI_FLOWPLAYER_FLASH', '_MI_FLOWPLAYER_HTML5', '_MI_FLOWPLAYER_HTTP', '_MI_FLOWPLAYER_IOS', '_MI_FLOWPLAYER_RTMP', '_MI_FLOWPLAYER_RTSP', '_MI_FLOWPLAYER_SILVERLIGHT', '_MI_FLOWPLAYER_OTHER') DEFAULT '_MI_FLOWPLAYER_FLASH',  `name` varchar(128) DEFAULT '',  `mimetype` varchar(128) DEFAULT '',  `codecs` varchar(500) DEFAULT '',  `default` int(1) DEFAULT '0',  `created` int(13) DEFAULT '0',  `updated` int(13) DEFAULT '0',  PRIMARY KEY (`mid`)) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	if ($GLOBALS['xoopsDB']->queryF($question)) {
		xoops_error($question, 'SQL Executed Successfully!!!');
		$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix('flowplayer_mimetypes')."` (`mid`,`support`,`name`,`mimetype`,`codecs`,`default`,`created`) values (1,'_MI_FLOWPLAYER_HTTP','MP4','video/mp4','avc1.42E01E, mp4a.40.2',1,UNIX_TIMESTAMP())";
		$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix('flowplayer_mimetypes')."` (`mid`,`support`,`name`,`mimetype`,`codecs`,`default`,`created`) values (2,'_MI_FLOWPLAYER_HTML5','WEBM','video/webm','vp8, vorbis',0,UNIX_TIMESTAMP())";
		$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix('flowplayer_mimetypes')."` (`mid`,`support`,`name`,`mimetype`,`codecs`,`default`,`created`) values (3,'_MI_FLOWPLAYER_HTML5','OGG','video/ogg','theora, vorbis',0,UNIX_TIMESTAMP())";
		$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix('flowplayer_mimetypes')."` (`mid`,`support`,`name`,`mimetype`,`codecs`,`default`,`created`) values (4,'_MI_FLOWPLAYER_FLASH','FLASH','video/x-flv','',0,UNIX_TIMESTAMP())";
	} else {
		xoops_error($question, 'Error Number: '.$GLOBALS['xoopsDB']->errno().' - SQL Did Not Executed! ('.$GLOBALS['xoopsDB']->error().'!!!)');
	}
	
	$question = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `mid` INT(10) UNSIGNED DEFAULT '0'";
	if ($GLOBALS['xoopsDB']->queryF($question)) {
		xoops_error($question, 'SQL Executed Successfully!!!');
		$sql[] = "UPDATE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` SET `mid` = '1' WHERE `rtmp` LIKE '%.mp4%' or  `source` LIKE '%.mp4'";
		$sql[] = "UPDATE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` SET `mid` = '3' WHERE `rtmp` LIKE '%.ogg%' or  `source` LIKE '%.ogg'";
		$sql[] = "UPDATE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` SET `mid` = '4' WHERE `rtmp` LIKE '%.flv%' or  `source` LIKE '%.flv'";
	} else {
		xoops_error($question, 'Error Number: '.$GLOBALS['xoopsDB']->errno().' - SQL Did Not Executed! ('.$GLOBALS['xoopsDB']->error().'!!!)');
	}

	// Version 1.13
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `speciala_width` varchar(64) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `speciala_height` varchar(64) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `specialb_width` varchar(64) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `specialb_height` varchar(64) DEFAULT NULL";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `speciala_autoplay` tinyint(2) unsigned DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `specialb_autoplay` tinyint(2) unsigned DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `speciala_controls` tinyint(2) unsigned DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `specialb_controls` tinyint(2) unsigned DEFAULT '0'";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` ADD COLUMN `http` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_player')."` CHANGE COLUMN `source` `raw` VARCHAR(500) DEFAULT ''";
	$sql[] = "ALTER TABLE `".$GLOBALS['xoopsDB']->prefix('flowplayer_mimetypes')."` CHANGE COLUMN `support` `support` enum('_MI_FLOWPLAYER_FLASH', '_MI_FLOWPLAYER_HTML5', '_MI_FLOWPLAYER_HTTP', '_MI_FLOWPLAYER_IOS', '_MI_FLOWPLAYER_RTMP', '_MI_FLOWPLAYER_RTSP', '_MI_FLOWPLAYER_SILVERLIGHT', '_MI_FLOWPLAYER_OTHER') DEFAULT '_MI_FLOWPLAYER_FLASH'";
	
	
	foreach($sql as $id => $question) {
		if ($GLOBALS['xoopsDB']->queryF($question)) {
			xoops_error($question, 'SQL Executed Successfully!!!');
		} else {
			//xoops_error($question, 'Error Number: '.$GLOBALS['xoopsDB']->errno().' - SQL Did Not Executed! ('.$GLOBALS['xoopsDB']->error().'!!!)');
		}
	}
	return true;
	
}

?>