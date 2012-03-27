<?php
/**
 * Private Messages
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         pm
 * @since           2.4.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: core.php 8066 2011-11-06 05:09:33Z beckmi $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * PM core preloads
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          trabis <lusopoemas@gmail.com>
 */
class FlowplayerCorePreload extends XoopsPreloadItem
{

    function eventCoreIncludeCommonEnd($args)
    {
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$player_handler = xoops_getmodulehandler('player', 'flowplayer');
			xoops_load('XoopsCache');
			$ret = XoopsCache::read('flowplayer_user_agents');
			$out=array();
			if (is_object($GLOBALS['xoopsUser']))
				$out[microtime(true)] = array('useragent'=>$_SERVER['HTTP_USER_AGENT'], 'player' => $player_handler->getBasicModeWithUserAgent($_SERVER['HTTP_USER_AGENT']), 'user' => '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$GLOBALS['xoopsUser']->getVar('uid').'">'.$GLOBALS['xoopsUser']->getVar('uname').'</a>');
			else 
				$out[microtime(true)] = array('useragent'=>$_SERVER['HTTP_USER_AGENT'], 'player' => $player_handler->getBasicModeWithUserAgent($_SERVER['HTTP_USER_AGENT']), 'user' => _GUESTS);
			foreach($ret as $time => $agent) {
				if (is_array($agent))
					if ($agent['useragent']!=$_SERVER['HTTP_USER_AGENT']) {
						$out[$time] = $agent;
					}
			}
			XoopsCache::write('flowplayer_user_agents', $out, 3600*24*7*4);
		}        
    }

}
?>