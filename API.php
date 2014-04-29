<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\SubdomainDashboard;

/**
 * API for plugin SubdomainDashboard
 *
 * @method static \Piwik\Plugins\SubdomainDashboard\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
     * Example method. Please remove if you do not need this API method.
     * You can call this API method like this:
     * /index.php?module=API&method=SubdomainDashboard.getAnswerToLife
     * /index.php?module=API&method=SubdomainDashboard.getAnswerToLife&truth=0
     *
     * @param  bool $truth
     *
     * @return bool
     */
    public function getAnswerToLife($truth = true)
    {
        if ($truth) {
            return 42;
        }

        return 24;
    }


    /*
    *
    *
    *
    *
    */
    public function getAllSiteids()
    {
	$data = \Piwik\Plugins\SitesManager\API::getInstance()->getAllSitesId();
	return $data;
    }

    /**
    * 
    * Gives back a list of subdomains with the help of segmentation command.
    * 
    *
    * @param string $domains
    * @return array subdomains
    */
    public function getAllSubdomains($idSite, $period, $date)
    {
	 $data = \Piwik\Plugins\Actions\API::getInstance()->getPageTitles(
		$idSite, 
		$period, 
		$date, 
		$segment = $subdomain, 
		$expanded = false, 
		$idSubtable = false);
	$result = $data->getEmptyClone($keepFilters = false); // we could create a new instance by using new DataTable(),
                                                              // but that wouldn't copy DataTable metadata, which can be
                                                              // useful.
	foreach ($data->getRows() as $visitRow) {
        	$browserName = $visitRow->getColumn('browserName');

        	// try and get the row in the result DataTable for the browser used in this visit
        	$resultRowForBrowser = $result->getRowFromLabel($browserName);

        	// if there is no row for this browser, create it
        if ($resultRowForBrowser === false) {
            $result->addRowFromSimpleArray(array(
                'label' => $browserName,
                'nb_visits' => 1
            ));
        } else { // if there is a row, increment the visit count
            $resultRowForBrowser->setColumn('nb_visits', $resultRowForBrowser->getColumn('nb_visits') + 1);
        }
    }

    return $result;
    }
}
