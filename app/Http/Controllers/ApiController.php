<?php

namespace App\Http\Controllers;

use Config;
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
        $username = trim($request->input('username'));
        $password = trim($request->input('password'));

        if ($username == '' || $password == '') {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = str_replace('{tag}', 'username/password', Config::get('settings.resp_msg.invalid_input'));
            $response['result'] = null;
        } else {
            $result = $this->doLogin($username, $password);
            // if login is success, write IDNo in session
            if (empty((array) $result) && !isset($result->IDNo)) {
                $status_code = 401;
                $response['status'] = false;
                $response['message'] = str_replace('{tag}', 'username/password', Config::get('settings.resp_msg.incorrect_input'));
                $response['result'] = null;
            } else {
                $request->session()->put('user.IDNo', $result->IDNo);
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
}
