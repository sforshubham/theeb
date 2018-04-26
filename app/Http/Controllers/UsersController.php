<?php

namespace App\Http\Controllers;

use Config;
use Validator;
use Illuminate\Http\Request;

class UsersController extends SoapController
{
    // This controller requires user session id

    /**
     * Returns a listing of the branches.
     *
     * @return \Illuminate\Http\Response
     */
    public $IDNo = '';

    public function checkLogin()
    {
        if (session('user.IDNo')) {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
            return response()->json($response, $status_code);
        }
        $this->IDNo = session('user.IDNo');
    }

    public function driverProfile(Request $request)
    {
        $status_code = 200;
        $response = array();
        $this->checkLogin();
        $data = $this->getDriverProfile($this->IDNo);
        if (empty((array) $data) || $data->Success != 'Y') {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
        } else {
            $response['status'] = true;
            $response['message'] = '';
            $response['result'] = $data;
        }
        return response()->json($response, $status_code);
    }

    public function priceEstimation(Request $request)
    {
        $status_code = 200;
        $response = array();
        $this->checkLogin();
        $validator = Validator::make($request->all(), [
            'PickupLocation' => 'required',
            'DropLocation' => 'required',
            'PickupDate' => 'required|date_format:d/m/Y|after_or_equal:today',
            'PickupTime' => 'required',
            'DropDate' => 'required|date_format:d/m/Y|after_or_equal:PickupDate',
            'DropTime' => 'required',
            'CarCategory' => 'required',
        ]);
        if ($validator->fails()) {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = $validator->errors()->all();
            $response['result'] = null;
            return response()->json($response, $status_code);
        }
        $input = [
            'CDP' => '',
            'OutBranch' => $request->input('PickupLocation'),
            'InBranch' => $request->input('DropLocation'),
            'OutDate' => $request->input('PickupDate'),
            'OutTime' => $request->input('PickupTime'),
            'InDate' => $request->input('DropDate'),
            'InTime' => $request->input('DropTime'),
            'CarGroup' => $request->input('CarCategory'),
            'Currency' => 'SAR',
            'DebitorCode' => '',
            'VoucherType' => '',
            'VoucherNo' => '',
            'Booked' => [
                'Insurance' => ['Code' => '', 'Name' => '', 'Quantity' => ''],
                'Extra' => ['Code' => '', 'Name' => '', 'Quantity' => '']
            ],
        ];
        $data = $this->getPriceEstimation($input);
        if (empty((array) $data) || $data->Success != 'Y') {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
        } else {
            $response['status'] = true;
            $response['message'] = '';
            $response['result'] = $data;
        }
        return response()->json($response, $status_code);

    }
}
