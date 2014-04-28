<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\SubdomainDashboard;

use Piwik\View;

/**
 *
 */
class Controller extends \Piwik\Plugin\Controller
{

    public function index()
    {
        $view = new View('@SubdomainDashboard/index.twig');
        $this->setBasicVariablesView($view);
        $view->answerToLife = '42';

        return $view->render();
    }
}
