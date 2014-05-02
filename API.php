<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\SubdomainDashboard;
use \Piwik\Plugins\Actions;
/**
 * API for plugin SubdomainDashboard
 *
 * @method static \Piwik\Plugins\SubdomainDashboard\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
    *
    *   Get the subdomians with the help of page urls.
    *   @param integer $idSite idSite can be choosen
    *   @param string $period (day,week,month,year,range)
    *   @param date (yyyy-mm-dd) $date can also be a range (2014-05-01,2014-05-02)
    *   @param string $segment to filter the statement
    *   
    *   @return array of string $domains.
    */
    public function getAllSubdomain($idSite, $period, $date, $segment = false)
    {
        $data = \Piwik\Plugins\Actions\API::getInstance()->getPageUrls(
        $idSite,
        $period,
        $date,
        $segment,
        $flat = false,
        $doNotFetchActions = true
    );
        $domains = array();
        foreach ($data->getRows() as $row) {
            if (array_key_exists("url", $row->c[1]))
            {
                $domain_string = explode("/",implode(explode("http://",$row->c[1]["url"])));
                if(!in_array($domain_string[0],$allData))
                {
                    array_push($domains, $domain_string[0]);  
                }
            }
        }
        return $domains;
    }

    /**
    *
    *   Get the subdomians with the help of page Custom variable set in Javascript here "Domain".
    *   This method is eaiser to impliment.
    *   JavaSript code for page Views:
    *   _paq.push(['setCustomVariable', 1, 'Domain', document.domain, 'page']);
    *   JavaScript code for views:
    *   _paq.push(['setCustomVariable', 1, 'Domain', document.domain, 'view']);
    *
    *   @param integer $idSite idSite can be choosen
    *   @param string $period (day,week,month,year,range)
    *   @param date (yyyy-mm-dd) $date can also be a range (2014-05-01,2014-05-02)
    *   @param string $segment to filter the statement
    *   
    *   @return array of string $domains.
    */
    public function getCustomVariableDomains($idSite, $period, $date, $segment = false)
    {
        //get the subtables whch are needed for the getCustomVariablesValuesFromNameId.
        $allVariables = \Piwik\Plugins\CustomVariables\API::getInstance()->getCustomVariables(
        $idSite,
        $period,
        $date,
        $segment,
        $expanded = true
        );
        $idSubtable = 0;
        foreach ($allVariables->getRows() as $row) {
            if($row->getColumn("label")=="Domain"){
                            $idSubtable = $row->c[1]["idsubdatatable_in_db"];
            }
        }
        //get the sub domains recored in the database.
        $data = \Piwik\Plugins\CustomVariables\API::getInstance()->getCustomVariablesValuesFromNameId(
        $idSite,
        $period,
        $date,
        $idSubtable,
        $segment 
        );
        return $data;
    }
}