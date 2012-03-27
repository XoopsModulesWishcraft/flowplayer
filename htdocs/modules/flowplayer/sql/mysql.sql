
CREATE TABLE `flowplayer_player` (
  `fid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) DEFAULT '0',
  `name` varchar(128) DEFAULT NULL,
  `reference` varchar(128) DEFAULT 'player_%fid%',
  `raw` varchar(500) DEFAULT NULL,
  `width` varchar(64) DEFAULT NULL,
  `height` varchar(64) DEFAULT NULL,
  `speciala_width` varchar(64) DEFAULT NULL,
  `speciala_height` varchar(64) DEFAULT NULL,
  `specialb_width` varchar(64) DEFAULT NULL,
  `specialb_height` varchar(64) DEFAULT NULL,
  `default` int(1) DEFAULT '0',
  `created` int(13) DEFAULT '0',
  `updated` int(13) DEFAULT '0',
  `stream` tinyint(2) unsigned DEFAULT '0',
  `rtmp_server` varchar(500) DEFAULT '',
  `rtmp` varchar(500) DEFAULT '',
  `flash` varchar(500) DEFAULT '',
  `ios` varchar(500) DEFAULT '',
  `silverlight` varchar(500) DEFAULT '',
  `rtsp` varchar(500) DEFAULT '',
  `http` varchar(500) DEFAULT '',
  `path` varchar(255) DEFAULT '',
  `poster` varchar(255) DEFAULT '',
  `level` int(5) unsigned DEFAULT '100',
  `autoplay` tinyint(2) unsigned DEFAULT '0',
  `speciala_autoplay` tinyint(2) unsigned DEFAULT '0',
  `specialb_autoplay` tinyint(2) unsigned DEFAULT '0',
  `controls` tinyint(2) unsigned DEFAULT '0',
  `speciala_controls` tinyint(2) unsigned DEFAULT '0',
  `specialb_controls` tinyint(2) unsigned DEFAULT '0',
  `muted` tinyint(2) unsigned DEFAULT '0',
  `play` tinyint(2) unsigned DEFAULT '0',
  `volume` tinyint(2) unsigned DEFAULT '0',
  `mute` tinyint(2) unsigned DEFAULT '0',
  `time` tinyint(2) unsigned DEFAULT '0',
  `stop` tinyint(2) unsigned DEFAULT '0',
  `fullscreen` tinyint(2) unsigned DEFAULT '0',
  `scrubber` tinyint(2) unsigned DEFAULT '0',
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `flowplayer_mimetypes` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `support` enum('_MI_FLOWPLAYER_FLASH', '_MI_FLOWPLAYER_HTML5', '_MI_FLOWPLAYER_HTTP', '_MI_FLOWPLAYER_IOS', '_MI_FLOWPLAYER_RTMP', '_MI_FLOWPLAYER_RTSP', '_MI_FLOWPLAYER_SILVERLIGHT', '_MI_FLOWPLAYER_OTHER') DEFAULT '_MI_FLOWPLAYER_FLASH',
  `name` varchar(128) DEFAULT '',
  `mimetype` varchar(128) DEFAULT '',
  `codecs` varchar(500) DEFAULT '',
  `default` int(1) DEFAULT '0',
  `created` int(13) DEFAULT '0',
  `updated` int(13) DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert  into `flowplayer_mimetypes` (`mid`,`support`,`name`,`mimetype`,`codecs`,`default`,`created`) values (1,'_MI_FLOWPLAYER_HTML5','MP4','video/mp4','avc1.42E01E, mp4a.40.2',0,UNIX_TIMESTAMP());
insert  into `flowplayer_mimetypes` (`mid`,`support`,`name`,`mimetype`,`codecs`,`default`,`created`) values (2,'_MI_FLOWPLAYER_HTML5','WEBM','video/webm','vp8, vorbis',0,UNIX_TIMESTAMP());
insert  into `flowplayer_mimetypes` (`mid`,`support`,`name`,`mimetype`,`codecs`,`default`,`created`) values (3,'_MI_FLOWPLAYER_HTML5','OGG','video/ogg','theora, vorbis',0,UNIX_TIMESTAMP());
insert  into `flowplayer_mimetypes` (`mid`,`support`,`name`,`mimetype`,`codecs`,`default`,`created`) values (4,'_MI_FLOWPLAYER_FLASH','FLASH VIDEO','video/x-flv','',1,UNIX_TIMESTAMP());
