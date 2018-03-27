<?php
/**
 * Created by PhpStorm.
 * User: evert
 * Date: 27/09/2017
 * Time: 09:38
 */

namespace PragmaBroadvertising\SolarEdge\Models;

use Ixudra\Curl\Facades\Curl;
use PragmaBroadvertising\SolarEdge\Interfaces\ApiConnectorInterface;

class SolarEdgeClient implements ApiConnectorInterface
{
    public function __construct()
    {
        $this->key = '?api_key=' . config('laravel-solaredge-api.key');
        $this->id = config('laravel-solaredge-api.installation_id');
        $this->endpoint = config('laravel-solaredge-api.endpoint');
    }

    /**
     * Get from Site
     * - endpoint
     * - id
     * - key
     * @param $siteProperty
     * @return mixed
     */
    function getFromSite($siteProperty)
    {
        $request = Curl::to($this->endpoint . 'site/' . $this->id . '/' . $siteProperty . $this->key)->asJson()->get()->{$siteProperty};
        return $request;
    }

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
    function getFromSiteWithStartAndEnd($siteProperty, $startDate, $endDate, $timeUnit, $withTime)
    {

        // Fucking APIs
        $startVarName = "startDate";
        $endVarName = "endDate";
        if($withTime) {
            $startVarName = "startTime";
            $endVarName = "endTime";
        }
        //dd($this->endpoint . 'site/' . $this->id . '/' . $siteProperty . $this->key . '&'.$startVarName.'='.$startDate.'&'.$endVarName.'='.$endDate.'&timeUnit=' .$timeUnit);
        $request = Curl::to($this->endpoint.'site/'.$this->id.'/'.$siteProperty.$this->key.'&'.$startVarName.'='.$startDate.'&'.$endVarName.'='.$endDate.'&timeUnit='.$timeUnit)->asJson()->get()->{$siteProperty};
        return $request;
    }
}