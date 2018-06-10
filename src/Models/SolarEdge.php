<?php

namespace PragmaBroadvertising\SolarEdge\Models;

use App;
use Carbon\Carbon;
use PragmaBroadvertising\SolarEdge\Interfaces\ApiConnectorInterface;


class SolarEdge
{
    protected $connector;

    public function __construct(ApiConnectorInterface $connector) {
        $this->connector = $connector;
    }

    /**
     * Get Site details
     * @return mixed
     */
    function details(){
        $request = $this->connector->getFromSite('details');
        if( null == $request ) {
            return array();
        }

        $details = collect();

        $details->id                = $request->id;
        $details->name              = $request->name;
        $details->accountId         = $request->accountId;
        $details->status            = $request->status;
        $details->peakPower         = $request->peakPower;
        $details->lastUpdateTime    = $request->lastUpdateTime;
        $details->installationDate  = $request->installationDate;
        $details->ptoDate           = $request->ptoDate;
        $details->notes             = $request->notes;
        $details->type              = $request->type;
        $details->location          = $request->location;
        $details->primaryModule     = $request->primaryModule;
        $details->uris              = $request->uris;
        $details->publicSettings    = $request->publicSettings;

        return $details;
    }

    /**
     * Get Site energy
     * @return mixed
     */
    function energy(Carbon $startDate, Carbon $endDate, $order)
    {
        $start = $startDate->format('Y-m-d');
        $end = $endDate->format('Y-m-d');

        $request = $this->connector->getFromSiteWithStartAndEnd('energy', $start, $end, 'DAY');

        $energy = collect();
        if( !isset($request->measuredBy) || !isset($request->unit) ) {
            print_r("SolareEdge energy() -- could not read energy data from generator");
            print_r($request);
            return $energy;
        }

        $energy->measured_by = $request->measuredBy;
        $energy->unit = $request->unit;

        switch ($order) {
            case 'asc':
                $energy->readings = collect($request->values)->sortBy('date')->reverse();
                break;
            case 'desc':
                $energy->readings = collect($request->values)->sortBy('date');
                break;
        }

        return $energy;
    }

    /**
     * Get Site power
     * @return mixed
     */
    function power(Carbon $startDate, Carbon $endDate, $order)
    {
        $start = $startDate->format('Y-m-d%20H:i:s');
        $end = $endDate->format('Y-m-d%20H:i:s');
        $request = $this->connector->getFromSiteWithStartAndEnd('power', $start , $end, 'QUARTER_OF_AN_HOUR', true); // true == with Time var names
        
        $power = collect();
        if( empty($request) ) {
            print_r("SolareEdge power() -- could not read power data from generator");
            return $power;
        }

        $power->interval    = $request->timeUnit;
        $power->unit        = $request->unit;

        switch ($order) {
            case 'asc':
                $power->readings    = collect($request->values)->sortBy('date')->reverse();
                break;
            case 'desc':
                $power->readings    = collect($request->values)->sortBy('date');
                break;
        }

        return $power;
    }

    /**
     * Get Site overview
     * @return mixed
     */
    function overview(){
        $request = $this->connector->getFromSite('overview');
        if( null == $request ) {
            return array();
        }

        $overview = collect();

        $overview->measuredBy   = $request->measuredBy;
        $overview->lastUpdate   = $request->lastUpdateTime;
        $overview->lifeTime     = $request->lifeTimeData->energy;
        $overview->lastYear     = $request->lastYearData->energy;
        $overview->lastMonth    = $request->lastMonthData->energy;
        $overview->lastDay      = $request->lastDayData->energy;
        $overview->currentPower = $request->currentPower->power;
        $overview->powerUnit    = 'W';
        $overview->energyUnit   = 'Wh';

        return $overview;
    }
}
