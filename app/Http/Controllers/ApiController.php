<?php

namespace App\Http\Controllers;

use Config;
use Validator;
use Illuminate\Http\Request;

class ApiController extends SoapController
{
    /**
     * Returns a listing of the branches.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBranches()
    {
        $status_code = 200;
        $response = array();

        $data = $this->listAllBranches();
        $response['status'] = true;
        $response['message'] = '';
        $response['result'] = $data;
        return response()->json($response, $status_code);
    }

    /**
     * Returns a listing of the vehicle type.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllVehicleTypes()
    {
        $status_code = 200;
        $response = array();

        $data = $this->listAllVehicles();
        $response['status'] = true;
        $response['message'] = '';
        $response['result'] = $data;
        return response()->json($response, $status_code);
    }

    
    public function login(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = $validator->errors()->all();
            $response['result'] = null;
        } else {
            $result = $this->doLogin($request->input('username'), $request->input('password'));
            // if login is success, write IDNo in session
            if (empty((array) $result) && !isset($result->IDNo)) {
                $status_code = 401;
                $response['status'] = false;
                $response['message'] = str_replace('{tag}', 'username/password', Config::get('settings.resp_msg.incorrect_input'));
                $response['result'] = null;
            } else {
                $session_IDNo = (int)$result->IDNo ? $result->IDNo : $result->LicenseNo;
                $request->session()->put('user.IDNo', $session_IDNo);
                $response['status'] = true;
                $response['message'] = '';
                $response['result'] = $result;
            }
        }
        return response()->json($response, $status_code);
    }

    public function logout(Request $request)
    {

        $status_code = 200;
        $response = [];

        $request->session()->flush();
        session()->flush();
        $response['status'] = true;
        $response['message'] = Config::get('settings.resp_msg.logout');
        $response['result'] = null;
        return response()->json($response, $status_code);
    }

    public function createModifyDriver(Request $request)
    {
        $status_code = 200;
        $response = array();
        $operation = Config::get('settings.operation')[$request->segment(3)];
        $rules = createModifyDriverRules($operation);
        if (!empty($rules)) {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $status_code = 400;
                $response['status'] = false;
                $response['message'] = $validator->errors()->all();
                $response['result'] = null;
                return response()->json($response, $status_code);
            }

        }
        $input = [
            'LastName' => $request->input('LastName'),
            'FirstName' => $request->input('FirstName'),
            'DateOfBirth' => $request->input('DateOfBirth'),
            'Nationality' => $request->input('Nationality'),
            'LicenseId' => $request->input('LicenseId'),
            'LicenseExpiryDate' => $request->input('LicenseExpiryDate'),
            'LicenseDoc' => '',
            'LicenseDocFileExt' => '',
            'Address1' => $request->input('Address1'),
            'Address2' => $request->input('Address2'),
            'WorkTel' => $request->input('WorkTel'),
            'Mobile' => $request->input('Mobile'),
            'Email' => $request->input('Email'),
            'IdType' => $request->input('IdType'),
            'IdNo' => $request->input('IdNo'),
            'IdDoc' => '',
            'IdDocFileExt' => '',
            'MembershipNo' => $request->input('MembershipNo'),
            'Operation' =>  $operation,
            'Password' => $request->input('Password'),
            'IDSerialNo' => $request->input('IDSerialNo'),
            'WorkIdDoc' => '',
            'WorkIdDocFileExt' => '',
            'DriverImage' => '',
            'DriverImageFileExt' => '',
            'HomeTel' => '',
            'LicenseIssuedBy' => '',
        ];
        $data = $this->getDriverCreateModify($input);
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
