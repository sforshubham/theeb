<?php

namespace App\Http\Controllers;

use App\Models\Branches;
use App\Models\VehicleTypes;

class BaseController extends Controller
{
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
        $rows = VehicleTypes::getAll();
        return $rows;
    }

    /**
     * Update branches table
     * @param array $data list of branches
     *
     */
    public function updateBranches($data)
    {
        $status = Branches::updateAll($data);
        return $status;
    }

    /**
     * Update vehicles table
     * @param array $data list of vehicle types
     *
     */
    public function updateVehicles($data)
    {
        $status = VehicleTypes::updateAll($data);
        return $status;
    }

    public function getFileAndEncode($file_obj)
    {
        $info = ['file_base64'=> '','ext'=>''];
        if (!empty($file_obj)) {
            $info['file_base64'] = file_to_base64($file_obj->getPathName());
            $info['ext'] = $file_obj->getClientOriginalExtension();
        }
        return $info;
    }

    /**
     * List all distinct Vehicles types from DB
     *
     * @return \Illuminate\Http\Response
     */
    public function vehicleTypes()
    {
        $rows = VehicleTypes::vehicleType();
        return $rows;
    }

    /**
     * List all vehicle type against a vehicle code
     *
     * @return \Illuminate\Http\Response
     */
    public function getSelectedVehicles($code)
    {
        $rows = VehicleTypes::getSelectedVehicles($code);
        return $rows;
    }

    public function getSessionData()
    {
        $set_data = [
            'PickupLocation' => '',
            'DropLocation' => '',
            'PickupDate' => '',
            'PickupTime' => '',
            'DropDate' => '',
            'DropTime' => '',
            'CarCategory' => '',
            'CarGroup' => ''
        ];
        if (session()->has('price_estimation')) {
            $set_data['PickupLocation'] = session()->has('price_estimation.PickupLocation') ? session('price_estimation.PickupLocation') : '';
            $set_data['DropLocation'] = session()->has('price_estimation.DropLocation') ? session('price_estimation.DropLocation') : '';
            $set_data['PickupDate'] = session()->has('price_estimation.PickupDate') ? session('price_estimation.PickupDate') : '';
            $set_data['PickupTime'] = session()->has('price_estimation.PickupTime') ? session('price_estimation.PickupTime') : '';
            $set_data['DropDate'] = session()->has('price_estimation.DropDate') ? session('price_estimation.DropDate') : '';
            $set_data['DropTime'] = session()->has('price_estimation.DropTime') ? session('price_estimation.DropTime') : '';
            $set_data['CarCategory'] = session()->has('price_estimation.CarCategory') ? session('price_estimation.CarCategory') : '';
            $set_data['CarGroup'] = session()->has('price_estimation.CarGroup') ? session('price_estimation.CarGroup') : '';

            $client = new \GuzzleHttp\Client();
            $res = $client->request('POST', url('/price_estimation'), [
                'form_params' => $set_data
            ]);
        }
        return $set_data;
    }


}
