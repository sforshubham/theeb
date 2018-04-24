<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Artisaninweb\SoapWrapper\SoapWrapper;

use App\Models\Branches;
use App\Models\Vehicles;

class SoapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $soapWrapper;

    public function __construct(SoapWrapper $soapWrapper)
    {
        ini_set('soap.wsdl_cache_enabled',0);
        ini_set('soap.wsdl_cache_ttl',0);
        //ini_set('default_socket_timeout', 600);
        $this->soapWrapper = $soapWrapper;
    }

    /**
     * Get all the branches from ERP api
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBranches()
    {
        $result = (object)[];
        try {
            $this->soapWrapper->add('Branches', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.branches'))
                ->trace(true);
            });

            $result = $this->soapWrapper->call('Branches.BranchMasterWebService');
        } catch (Exception $e) {
            //Log::info('Exception: '.$e->getMessage());
        }
        if (!empty((array) $result) && isset($result->Branch)) {
            $result = object_to_array($result->Branch, ['Schedule']);
            $status = Branches::updateAll($result);
        }
    }

    /**
     * Get all the vehicle types from ERP api
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllVehicleTypes()
    {
        $result = (object)[];
        try {
            $this->soapWrapper->add('Dummy', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.vehicle_type'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Dummy.VehicletypeWS');
        } catch (Exception $e) {
            //Log::info('Exception: '.$e->getMessage());
        }

        if (!empty((array) $result) && isset($result->Vehicles)) {
            $result = object_to_array($result->Vehicles);
            $status = Vehicles::updateAll($result);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $username user name
     * @param $password password
     * @return \Illuminate\Http\Response
     */
    public function doLogin($username, $password)
    {
        $result = (object)[];
        try {
            $this->soapWrapper->add('Login', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.login'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Login.LogInWS', ['UserName' => $username, 'Password' => $password]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }

    public function getDriverProfile($IDNo)
    {
        $result = (object)[];

        try {
            $this->soapWrapper->add('Dummy', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.driver_profile'))
                ->trace(true);
            });

            $result = $this->soapWrapper->call('Dummy.LoadDriverProfileWS', ['IDNo' => '22323'.$IDNo]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }






    /**
     * List all the Branches from DB
     *
     * @return \Illuminate\Http\Response
     */
    public function listAllBranches()
    {
        $rows = Branches::getAll();
        return $rows;
    }

    /**
     * List all the Vehicles from DB
     *
     * @return \Illuminate\Http\Response
     */
    public function listAllVehicles()
    {
        $rows = Vehicles::getAll();
        return $rows;
    }


}
