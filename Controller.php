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
use Piwik\Common;
use Piwik\Config;
use Piwik\Cookie;
use Piwik\Date;
use Piwik\IP;
use Piwik\Mail;
use Piwik\Nonce;
use Piwik\Notification;
use Piwik\Piwik;
use Piwik\Plugins\UsersManager\API as APIUsersManager;
use Piwik\Plugins\SitesManager\API as APISitesManager;
use Piwik\Plugins\UsersManager\UsersManager;
use Piwik\ProxyHttp;
use Piwik\QuickForm2;
use Piwik\Session;
use Piwik\SettingsPiwik;
use Piwik\Url;
use Piwik\View;
use Piwik\Site;

require_once PIWIK_INCLUDE_PATH . '/core/Config.php';


/**
 * The Subdomain Dashboard must be shown in the Admin Controller
 */
class Controller extends \Piwik\Plugin\ControllerAdmin
{

    public function index()
    {
		Piwik::checkUserHasSuperUserAccess();
        
        $view = new View('@SubdomainDashboard/index.twig');
        
        $this->setGeneralVariablesView($view);
        
        $period = Common::getRequestVar('period');
        $date = Common::getRequestVar('date');
        $idSite = Common::getRequestVar('idSite');
        
        $domains =  API::getInstance()->getCustomVariableDomains(
        $idSite,
        $period,
        $date,
        $segment=false,
        $expanded = true
        );

        $view->domains = $domains;
        return $view->render();
    }

}
