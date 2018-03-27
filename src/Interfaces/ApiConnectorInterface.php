<?php
/**
 * Created by PhpStorm.
 * User: evert
 * Date: 27/09/2017
 * Time: 09:28
 */

namespace PragmaBroadvertising\SolarEdge\Interfaces;


interface ApiConnectorInterface
{
    /**
     * Get from Site
     * - endpoint
     * - id
     * - key
     * @param $siteProperty
     * @return mixed
     */
    public function getFromSite($siteProperty);

    /**
     * Get from Site with start- and end date
     * - endpoint
     * - id
     * - key
     * - timeUnit
     * - startDate
     * - endDate
     * - withTime
     * @param $siteProperty
     * @return mixed
     */
    public function getFromSiteWithStartAndEnd($siteProperty,$startDate,$endDate,$timeUnit,$withTime);
}