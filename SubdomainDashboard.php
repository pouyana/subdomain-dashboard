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
            'Menu.Admin.addItems'              => 'addMenu',
        );
    }

    public function getJsFiles(&$jsFiles)
    {
        $jsFiles[] = 'plugins/SubdomainDashboard/javascripts/plugin.js';
    }
    
    public function getReportingMenuItems()
    {
	\Piwik\Menu\MenuMain::getInstance()->add(
        $category = 'General_Visitors', 
        // this is a 'translation token'. it will be replaced by
        // a translated string based on the user's language preference.
        // read about internationalization below to learn more.
        $title = 'Real-time Reports',
        // these are the query parameters that will be used in the menu item link's URL
        $urlQueryParams = array('module' => $this->getPluginName(), 'action' => 'index')
    );
   }
   public function addMenu()
   {
	 MenuAdmin::getInstance()->add('CoreAdminHome_MenuManage', 'Subdomain Dashboard', array('module' => 'SubdomainDashboard', 'action' => 'index'),
         Piwik::hasUserSuperUserAccess(), $order = 3);	
   }
}
