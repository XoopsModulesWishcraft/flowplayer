<?php

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Blue Room Xcenter
 * @author Simon Roberts <simon@xoops.org>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class FlowplayerMimetypes extends XoopsObject
{
	var $_ModConfig = NULL;
	var $_Mod = NULL;
	
    function FlowplayerMimetypes($id = null)
    {
        $this->initVar('mid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('support', XOBJ_DTYPE_ENUM, null, false, false, false, array('_MI_FLOWPLAYER_FLASH', '_MI_FLOWPLAYER_HTTP', '_MI_FLOWPLAYER_HTML5', '_MI_FLOWPLAYER_IOS', '_MI_FLOWPLAYER_RTMP', '_MI_FLOWPLAYER_RTSP', '_MI_FLOWPLAYER_SILVERLIGHT', '_MI_FLOWPLAYER_OTHER'));
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, '', false, 128);
		$this->initVar('mimetype', XOBJ_DTYPE_TXTBOX, '', false, 128);
		$this->initVar('codecs', XOBJ_DTYPE_TXTBOX, '', false, 500);		
		$this->initVar('default', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('created', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
		
		$config_handler = xoops_gethandler('config');
		$module_handler = xoops_gethandler('module');
		$this->_Mod = $module_handler->getByDirname('flowplayer');
		$this->_ModConfig = $config_handler->getConfigList($this->_Mod->getVar('mid'));
    
    }
    
    function toArray() {
    	$ret = parent::toArray();
    	$ele = flowplayer_mimetypes_get_form($this, true);
    	foreach($ele as $key => $field)
    		$ret['form'][$key] = $field->render();
    	return $ret;
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
class FlowplayerMimetypesHandler extends XoopsPersistableObjectHandler
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
        parent::__construct($db, 'flowplayer_mimetypes', 'FlowplayerMimetypes', "mid", "name");
    	
    }

	private function resetDefault() {
		$sql = "UPDATE " . $GLOBALS['xoopsDB']->prefix('flowplayer_mimetypes') . ' SET `default` = 0 WHERE 1 = 1';
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
    
}

?>