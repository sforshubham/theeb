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
        ini_set('default_socket_timeout', 600);
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
            $db_columns = Config::get('settings.branches_db_fields');
            $result = object_to_array($result->Branch, $db_columns);
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
                ->wsdl(Config::get('settings.wsdl.car_model'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('VehicleTypes.CarModelWS', [
                new GetSoapRequest(['VehicleType' => ''])
            ]);
        } catch (Exception $e) {
            //Log::info('Exception: '.$e->getMessage());
        }

        if (!empty((array) $result) && !empty($result->Model)) {
            $result = object_to_array($result->Model, Config::get('settings.vehicles_db_fields'));
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

    public function getDriverView($input)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Driverview', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.driver_modify'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Driverview.CarProDriverWS', [
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

    public function docuPrint($input)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Print', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.doc_print'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Print.GetRentProPrint', [
                new GetSoapRequest($input)
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }

    public function transaction($input)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Trans', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.transaction'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Trans.GetTransactionData', [
                new GetSoapRequest($input)
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }

    public function booking($input)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Booking', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.booking'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Booking.GetReservationBookingData', [
                new GetSoapRequest($input)
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }

    public function reservation($input)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Reservation', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.reservation'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Reservation.CarProReservationWS', [
                new GetSoapRequest($input)
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }

    public function extendBooking($input)
    {
        $result = [];

        try {
            $this->soapWrapper->add('Reservation', function ($service) {
              $service
                ->wsdl(Config::get('settings.wsdl.extend_booking'))
                ->trace(true);
            });
            $result = $this->soapWrapper->call('Reservation.TheebReservationModifyWebServi', [
                new GetSoapRequest($input)
            ]);
        } catch (Exception $e) {
            //
        }
        return $result;
    }




    public function noshow()
    {
        ini_set('soap.wsdl_cache_ttl',0);
        ini_set("soap.wsdl_cache_enabled", 0);
        /*$input = [
            'MembershipNo' => '',
            'Operation' => 'V',
            'Password' => '',
            'IDSerialNo' => '',
            'WorkIdDoc' => '',
            'WorkIdDocFileExt' => '',
            'DriverImage' => '',
            'DriverImageFileExt' => ''
        ];*/
        $input = [ //reservation
            'OutBranch' => '2',
            'InBranch' => '2',
            'OutDate' => '03/06/2018',
            'OutTime' => '11:03',
            'InDate' => '08/06/2018',
            'InTime' => '11:02',
            'ReservationNo' => '22472585',
            'ReservationStatus' => 'A',
        ];
        /*$input = [ // Price estimation
            'CDP' => '',
            'OutBranch' => '19',
            'InBranch' => '19',
            'OutDate' => '11/05/2018',
            'OutTime' => '11:00',
            'InDate' => '13/05/2018',
            'InTime' => '15:00',
            'CarGroup' => '',
            'VEHICLETYPE' => '3',
            'Currency' => env('APP_CURRENCY'),
            'DebitorCode' => '',
            'VoucherType' => '',
            'VoucherNo' => '',
            'Booked' => [
                'Insurance' => ['Code' => '', 'Name' => '', 'Quantity' => ''],
                'Extra' => ['Code' => '', 'Name' => '', 'Quantity' => '']
            ],
        ];*/
        $client = new \SoapClient(Config::get('settings.wsdl.extend_booking'), array('trace' => 1));
        $a = $client->TheebReservationModifyWebServi(['Reservation' => $input]);
        //pr($client->__getLastRequest());
        //pr($a);
        //throw new \Exception('hi');
        pr($client->__getLastResponse());
    }



}
