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
use Piwik\IP;
use Piwik\Mail;
use Piwik\Nonce;
use Piwik\Notification;
use Piwik\Piwik;
use Piwik\Plugins\UsersManager\API as APIUsersManager;
use Piwik\Plugins\UsersManager\UsersManager;
use Piwik\ProxyHttp;
use Piwik\QuickForm2;
use Piwik\Session;
use Piwik\SettingsPiwik;
use Piwik\Url;
use Piwik\View;

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
        $this->setBasicVariablesView($view);
        
        $view->answerToLife = '42';

        return $view->render();
    }
}
