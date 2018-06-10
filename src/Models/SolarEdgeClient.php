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
<<<<<<< HEAD
    function getFromSite($siteProperty)
    {
        $request = null;
        try {
            $request = Curl::to($this->endpoint . 'site/' . $this->id . '/' . $siteProperty . $this->key)->asJson()->get()->{$siteProperty};
        } catch(Exception $e) {
            // There was an error    
        }
=======
    function getFromSite($siteProperty){
        $url = $this->endpoint . 'site/' . $this->id . '/' . $siteProperty . $this->key;
        $request = Curl::to($url)->asJson()->get()->{$siteProperty};
>>>>>>> 66e0bb5ac466a82886302c6c01f206fb9609f46b
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
    function getFromSiteWithStartAndEnd($siteProperty,$timeUnit,$startDate,$endDate,$withTime = false){
        if(!$withTime) {
            $url = $this->endpoint . 'site/' . $this->id . '/' . $siteProperty .
 $this->key .'&startDate=' . $startDate . '&endDate=' . $endDate . '&timeUnit=' . $timeUnit;
            $request =
                Curl::to($url)
                        ->asJson()
                        ->get()
                        ->{$siteProperty};
        }
        else {
            $url = $this->endpoint . 'site/' . $this->id . '/' . $siteProperty . $this->key . '&startTime=' . $startDate .'&endTime=' . $endDate;

            $request =
                Curl::to($url)
                        ->asJson()
                        ->get()
                        ->{$siteProperty};
        }
<<<<<<< HEAD
        //dd($this->endpoint . 'site/' . $this->id . '/' . $siteProperty . $this->key . '&'.$startVarName.'='.$startDate.'&'.$endVarName.'='.$endDate.'&timeUnit=' .$timeUnit);
        $request = null;
        try {
            $request = Curl::to($this->endpoint.'site/'.$this->id.'/'.$siteProperty.$this->key.'&'.$startVarName.'='.$startDate.'&'.$endVarName.'='.$endDate.'&timeUnit='.$timeUnit)->asJson()->get()->{$siteProperty};
        } catch(Exception $e) {
            // There was an error    
        }
=======

>>>>>>> 66e0bb5ac466a82886302c6c01f206fb9609f46b
        return $request;
    }
}