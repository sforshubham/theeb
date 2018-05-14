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


}
