<?php

	function flowplayer_player_get_form($object, $as_array=false) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('player', 'flowplayer');
			$object = $handler->create(); 
		}
		
		xoops_loadLanguage('forms', 'flowplayer');
		$ele = array();
		
		if ($object->isNew()) {
			$sform = new XoopsThemeForm(_FRM_FLOWPLAYER_FORM_ISNEW_FLOWPLAYER, 'maquee', $_SERVER['PHP_SELF'], 'post');
			$ele['mode'] = new XoopsFormHidden('mode', 'new');
		} else {
			$sform = new XoopsThemeForm(_FRM_FLOWPLAYER_FORM_EDIT_FLOWPLAYER, 'maquee', $_SERVER['PHP_SELF'], 'post');
			$ele['mode'] = new XoopsFormHidden('mode', 'edit');
		}
		
		$sform->setExtra( "enctype='multipart/form-data'" ) ;
		
		$id = $object->getVar('fid');
		if (empty($id)) $id = '0';
		
		$ele['op'] = new XoopsFormHidden('op', 'player');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		if ($as_array==false)
			$ele['id'] = new XoopsFormHidden('id', $id);
		else 
			$ele['id'] = new XoopsFormHidden('id['.$id.']', $id);
		$ele['sort'] = new XoopsFormHidden('sort', isset($_REQUEST['sort'])?$_REQUEST['sort']:'created');
		$ele['order'] = new XoopsFormHidden('order', isset($_REQUEST['order'])?$_REQUEST['order']:'DESC');
		$ele['start'] = new XoopsFormHidden('start', isset($_REQUEST['start'])?intval($_REQUEST['start']):0);
		$ele['limit'] = new XoopsFormHidden('limit', isset($_REQUEST['limit'])?intval($_REQUEST['limit']):0);
		$ele['filter'] = new XoopsFormHidden('filter', isset($_REQUEST['filter'])?$_REQUEST['filter']:'1,1');

		$ele['name'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_NAME:''), $id.'[name]', ($as_array==false?55:21),128, $object->getVar('name'));
		$ele['name']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_NAME_DESC:''));
		$ele['reference'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_ID:''), $id.'[reference]', ($as_array==false?55:21), 128, $object->getVar('reference'));
		$ele['reference']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_ID_DESC:''));
		$ele['mid'] = new FlowplayerFormSelectMimetype(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_MIMETYPE:''), $id.'[mid]', $object->getVar('mid'));
		$ele['mid']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_MIMETYPE_DESC:''));
		$ele['raw'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_RAW:''), $id.'[raw]', ($as_array==false?55:21), 500, $object->getVar('raw'));
		$ele['raw']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_RAW_DESC:''));
		$ele['stream'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_STREAM:''), $id.'[stream]', $object->getVar('stream'));
		$ele['stream']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_STREAM_DESC:''));
		$ele['rtmp_server'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_RTMP_SERVER:''), $id.'[rtmp_server]', ($as_array==false?55:21), 500, $object->getVar('rtmp_server'));
		$ele['rtmp_server']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_RTMP_SERVER_DESC:''));
		$ele['rtmp'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_RTMP:''), $id.'[rtmp]', ($as_array==false?55:21), 500, $object->getVar('rtmp'));
		$ele['rtmp']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_RTMP_DESC:''));
		$ele['flash'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_FLASH:''), $id.'[flash]', ($as_array==false?55:21), 500, $object->getVar('flash'));
		$ele['flash']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_FLASH_DESC:''));
		$ele['ios'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_IOS:''), $id.'[ios]', ($as_array==false?55:21), 500, $object->getVar('ios'));
		$ele['ios']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_IOS_DESC:''));
		$ele['silverlight'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SILVERLIGHT:''), $id.'[silverlight]', ($as_array==false?55:21), 500, $object->getVar('silverlight'));
		$ele['silverlight']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SILVERLIGHT_DESC:''));
		$ele['rtsp'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_RTSP:''), $id.'[rtsp]', ($as_array==false?55:21), 500, $object->getVar('rtsp'));
		$ele['rtsp']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_RTSP_DESC:''));
		$ele['http'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_HTTP:''), $id.'[http]', ($as_array==false?55:21), 500, $object->getVar('http'));
		$ele['http']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_HTTP_DESC:''));
		
		$ele['level'] = new XoopsFormSelect(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_LEVEL:''), $id.'[level]', $object->getVar('level'));
		$ele['level']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_LEVEL_DESC:''));
		for($i=1;$i<=100;$i++) {
			$ele['level']->addOption($i, $i.'%');
		}
		$ele['autoplay'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_AUTOPLAY:''), $id.'[autoplay]', $object->getVar('autoplay'));
		$ele['autoplay']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_AUTOPLAY_DESC:''));
		$ele['speciala_autoplay'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALA_AUTOPLAY:''), $id.'[speciala_autoplay]', $object->getVar('speciala_autoplay', 'no'));
		$ele['speciala_autoplay']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALA_AUTOPLAY_DESC:''));
		$ele['specialb_autoplay'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALB_AUTOPLAY:''), $id.'[specialb_autoplay]', $object->getVar('specialb_autoplay', 'no'));
		$ele['specialb_autoplay']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALB_AUTOPLAY_DESC:''));
		$ele['controls'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_CONTROLS:''), $id.'[controls]', $object->getVar('controls'));
		$ele['controls']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_CONTROLS_DESC:''));
		$ele['speciala_controls'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALA_CONTROLS:''), $id.'[speciala_controls]', $object->getVar('speciala_controls', 'no'));
		$ele['speciala_controls']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALA_CONTROLS_DESC:''));
		$ele['specialb_controls'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALB_CONTROLS:''), $id.'[specialb_controls]', $object->getVar('specialb_controls', 'no'));
		$ele['specialb_controls']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALB_CONTROLS_DESC:''));
		$ele['muted'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_MUTED:''), $id.'[muted]', $object->getVar('muted'));
		$ele['muted']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_MUTED_DESC:''));
		$ele['play'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_PLAY:''), $id.'[play]', $object->getVar('play'));
		$ele['play']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_PLAY_DESC:''));
		$ele['volume'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_VOLUME:''), $id.'[volume]', $object->getVar('volume'));
		$ele['volume']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_VOLUME_DESC:''));
		$ele['mute'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_MUTE:''), $id.'[mute]', $object->getVar('mute'));
		$ele['mute']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_MUTE_DESC:''));
		$ele['time'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_TIME:''), $id.'[time]', $object->getVar('time'));
		$ele['time']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_TIME_DESC:''));
		$ele['stop'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_STOP:''), $id.'[stop]', $object->getVar('stop'));
		$ele['stop']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_STOP_DESC:''));
		$ele['fullscreen'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_FULLSCREEN:''), $id.'[fullscreen]', $object->getVar('fullscreen'));
		$ele['fullscreen']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_FULLSCREEN_DESC:''));
		$ele['scrubber'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SCRUBBER:''), $id.'[scrubber]', $object->getVar('scrubber'));
		$ele['scrubber']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SCRUBBER_DESC:''));
		
		$ele['width'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_WIDTH:''), $id.'[width]', ($as_array==false?15:10),12, $object->getVar('width'));
		$ele['width']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_WIDTH_DESC:''));
		$ele['speciala_width'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALA_WIDTH:''), $id.'[speciala_width]', ($as_array==false?15:10),12, $object->getVar('speciala_width', 'no'));
		$ele['speciala_width']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALA_WIDTH_DESC:''));
		$ele['specialb_width'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALB_WIDTH:''), $id.'[specialb_width]', ($as_array==false?15:10),12, $object->getVar('specialb_width', 'no'));
		$ele['specialb_width']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALB_WIDTH_DESC:''));
		$ele['height'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_HEIGHT:''), $id.'[height]', ($as_array==false?15:10),12, $object->getVar('height'));
		$ele['height']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_HEIGHT_DESC:''));
		$ele['speciala_height'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALA_HEIGHT:''), $id.'[speciala_height]', ($as_array==false?15:10),12, $object->getVar('speciala_height', 'no'));
		$ele['speciala_height']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALA_HEIGHT_DESC:''));
		$ele['specialb_height'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALB_HEIGHT:''), $id.'[specialb_height]', ($as_array==false?15:10),12, $object->getVar('specialb_height', 'no'));
		$ele['specialb_height']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_SPECIALB_HEIGHT_DESC:''));
		$ele['default'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_DEFAULT:''), $id.'[default]', $object->getVar('default'));
		$ele['default']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_DEFAULT_DESC:''));
		$ele['file'] = new XoopsFormFile(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_UPLOAD:''), 'image', $GLOBALS['flowplayerModuleConfig']['filesize_upload']);
		$ele['file']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_UPLOAD_DESC:''));
		if (strlen($object->getVar('poster'))>0&&file_exists($GLOBALS['xoops']->path($object->getVar('path').$object->getVar('poster')))) {
			$ele['poster'] = new XoopsFormLabel(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_POSTER:''), '<img src="'.XOOPS_URL.'/'.$object->getVar('path').$object->getVar('poster').'" width="340px" />' );
			$ele['poster']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_POSTER_DESC:''));
		}
		
		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_CREATED:''), date(_DATESTRING, $object->getVar('created')));
		}
		
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(($as_array==false?_FRM_FLOWPLAYER_FORM_FLOWPLAYER_UPDATED:''), date(_DATESTRING, $object->getVar('updated')));
		}
		
		if ($as_array==true)
			return $ele;
		
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('name', 'id', 'source');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
		
		return $sform->render();
		
	}

	function flowplayer_mimetypes_get_form($object, $as_array=false) {
		
		if (!is_object($object)) {
			$handler = xoops_getmodulehandler('mimetypes', 'flowplayer');
			$object = $handler->create(); 
		}
		
		xoops_loadLanguage('forms', 'flowplayer');
		$ele = array();
		
		if ($object->isNew()) {
			$sform = new XoopsThemeForm(_FRM_FLOWPLAYER_FORM_ISNEW_MIMETYPES, 'mimetypes', $_SERVER['PHP_SELF'], 'post');
			$ele['mode'] = new XoopsFormHidden('mode', 'new');
		} else {
			$sform = new XoopsThemeForm(_FRM_FLOWPLAYER_FORM_EDIT_MIMETYPES, 'mmimetypes', $_SERVER['PHP_SELF'], 'post');
			$ele['mode'] = new XoopsFormHidden('mode', 'edit');
		}
		
		$id = $object->getVar('mid');
		if (empty($id)) $id = '0';
		
		$ele['op'] = new XoopsFormHidden('op', 'mimetypes');
		$ele['fct'] = new XoopsFormHidden('fct', 'save');
		if ($as_array==false)
			$ele['id'] = new XoopsFormHidden('id', $id);
		else 
			$ele['id'] = new XoopsFormHidden('id['.$id.']', $id);
		$ele['sort'] = new XoopsFormHidden('sort', isset($_REQUEST['sort'])?$_REQUEST['sort']:'created');
		$ele['order'] = new XoopsFormHidden('order', isset($_REQUEST['order'])?$_REQUEST['order']:'DESC');
		$ele['start'] = new XoopsFormHidden('start', isset($_REQUEST['start'])?intval($_REQUEST['start']):0);
		$ele['limit'] = new XoopsFormHidden('limit', isset($_REQUEST['limit'])?intval($_REQUEST['limit']):0);
		$ele['filter'] = new XoopsFormHidden('filter', isset($_REQUEST['filter'])?$_REQUEST['filter']:'1,1');

		$ele['support'] = new FlowplayerFormSelectSupport(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_SUPPORT:''), $id.'[support]', $object->getVar('support'));
		$ele['support']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_SUPPORT_DESC:''));
		$ele['name'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_NAME:''), $id.'[name]', ($as_array==false?55:21),128, $object->getVar('name'));
		$ele['name']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_NAME_DESC:''));
		$ele['mimetype'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_MIMETYPE:''), $id.'[mimetype]', ($as_array==false?55:21), 128, $object->getVar('mimetype'));
		$ele['mimetype']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_MIMETYPE_DESC:''));
		$ele['codecs'] = new XoopsFormText(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_CODECS:''), $id.'[codecs]', ($as_array==false?55:21), 500, $object->getVar('codecs'));
		$ele['codecs']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_CODECS_DESC:''));
		$ele['default'] = new XoopsFormRadioYN(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_DEFAULT:''), $id.'[default]', $object->getVar('default'));
		$ele['default']->setDescription(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_DEFAULT_DESC:''));

		if ($object->getVar('created')>0) {
			$ele['created'] = new XoopsFormLabel(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_CREATED:''), date(_DATESTRING, $object->getVar('created')));
		}
		
		if ($object->getVar('updated')>0) {
			$ele['updated'] = new XoopsFormLabel(($as_array==false?_FRM_FLOWPLAYER_FORM_MIMETYPES_UPDATED:''), date(_DATESTRING, $object->getVar('updated')));
		}
		
		if ($as_array==true)
			return $ele;
		
		$ele['submit'] = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
		
		$required = array('name', 'mimetype', 'support');
		
		foreach($ele as $id => $obj)			
			if (in_array($id, $required))
				$sform->addElement($ele[$id], true);			
			else
				$sform->addElement($ele[$id], false);
		
		return $sform->render();
		
	}
	
?>