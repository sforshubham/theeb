<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Artisaninweb\SoapWrapper\SoapWrapper;

use App\Soap\Request\GetSoapRequest;

class SoapController extends BaseController
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
            $result = object_to_array($result->Branch, ['Schedule' => '']);
            $status = $this->updateBranches($result);
        } else {
            $result = [];
        }
        return $result;
    }

    /**
     * Get all the vehicle types from ERP api
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllVehicleTypes()
    {
        try {
            $this->soapWrapper->add('VehicleTypes', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.vehicle_type'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('VehicleTypes.VehicletypeWS', [
                new GetSoapRequest(['VehicleType' => ''])
            ]);
        } catch (Exception $e) {
            //Log::info('Exception: '.$e->getMessage());
        }

        if (!empty((array) $result) && isset($result->VehicleTypes)) {
            $result = object_to_array($result->VehicleTypes);
            $status = $this->updateVehicles($result);
        } else {
            $result = [];
        }
        return $result;
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
            $result = $this->soapWrapper->call('Login.LogInWS', [
                new GetSoapRequest(['UserName' => $username, 'Password' => $password])
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }

    public function getDriverProfile($IDNo)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Profile', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.driver_profile'))
                ->trace(true);
            });

            $result = $this->soapWrapper->call('Profile.LoadDriverProfileWS', [
                new GetSoapRequest(['IDNo' => $IDNo])
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }

    public function getPriceEstimation($input)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Price', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.price_estimation'))
                ->trace(true);
            });
            $input = array_to_object($input);
            $result = $this->soapWrapper->call('Price.PriceEstimationWS', [
                new GetSoapRequest(['Price' => $input])
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }

    public function getDriverCreateModify($input)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Driver', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.driver_modify'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Driver.CarProDriverWS', [
                new GetSoapRequest($input)
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }

    public function password($input)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Password', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.password'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Password.DriverPasswordResetWS', [
                new GetSoapRequest($input)
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }

    public function payment($input)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Payment', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.payment'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Payment.CreatePaymentMobileApp', [
                new GetSoapRequest($input)
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }




    public function noshow()
    {
        ini_set("soap.wsdl_cache_enabled", 0);
        $input = [
            'MembershipNo' => '',
            'Operation' => 'V',
            'Password' => '',
            'IDSerialNo' => '',
            'WorkIdDoc' => '',
            'WorkIdDocFileExt' => '',
            'DriverImage' => '',
            'DriverImageFileExt' => ''
        ];
        $client = new \SoapClient(Config::get('settings.wsdl.payment'), array('trace' => 1));
        try {
            $a = $client->CreatePaymentMobileApp(['PAYMENTOPTION' => 'Master Card', 'MERCHANTREFERENCE' => 'CPUAT1201', 'AMOUNT' => '125', 'CARDNUMBER' => '1111222233334444', 'EXPIRYDATE' => '20170501', 'AUTHORIZATIONCODE' => 'AUTH1257', 'RESERVATIONNO' => '009700970327', 'DRIVERCODE' => '9800004012', 'CURRENCY' => 'SAR', 'INVOICE' => '']);
            pr($a);
        } catch (Exception $e){
            var_dump($e->getMessage());
            pr($client->__getLastResponse());
            echo PHP_EOL;
            pr($client->__getLastRequest());
        }
        //pr($client->__getLastRequest());
    }



}
