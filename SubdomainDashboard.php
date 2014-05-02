<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\SubdomainDashboard;

use Exception;
use Piwik\Menu\MenuAdmin;
use Piwik\Config;
use Piwik\Cookie;
use Piwik\Option;
use Piwik\Piwik;
use Piwik\Plugins\UsersManager\UsersManager;
use Piwik\Plugin\Manager;
use Piwik\Session;


/**
 */
class SubdomainDashboard extends \Piwik\Plugin
{
    /**
     * @see Piwik\Plugin::getListHooksRegistered
     */
    public function getListHooksRegistered()
    {
        return array(
            'AssetManager.getJavaScriptFiles' => 'getJsFiles',
            'AssetManager.getStylesheetFiles'        => 'getStylesheetFiles',
            'Menu.Admin.addItems'              => 'addMenu',
        );
    }

    public function getJsFiles(&$jsFiles)
    {
        //$jsFiles[] = 'plugins/SubdomainDashboard/javascripts/plugin.js';
        $jsFiles[] = "libs/jquery/jquery.truncate.js";
        $jsFiles[] = "libs/jquery/jquery.scrollTo.js";
        $jsFiles[] = "plugins/Zeitgeist/javascripts/piwikHelper.js";
        $jsFiles[] = "plugins/CoreHome/javascripts/dataTable.js";
    }

        public function getStylesheetFiles(&$stylesheets)
    {
        $stylesheets[] = "plugins/Widgetize/stylesheets/widgetize.less";
        $stylesheets[] = "plugins/CoreHome/stylesheets/coreHome.less";
        $stylesheets[] = "plugins/CoreHome/stylesheets/dataTable.less";
        $stylesheets[] = "plugins/CoreHome/stylesheets/cloud.less";
        $stylesheets[] = "plugins/Dashboard/stylesheets/dashboard.less";
    }
    
   public function addMenu()
   {
	 MenuAdmin::getInstance()->add('CoreAdminHome_MenuManage', 'Subdomain Dashboard', array('module' => 'SubdomainDashboard', 'action' => 'index'),
         Piwik::hasUserSuperUserAccess(), $order = 5);	
   }
}
