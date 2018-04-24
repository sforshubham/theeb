<?php

namespace App\Http\Controllers;

use Config;
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
        $this->IDNo = session('user.IDNo');
        $data = $this->getDriverProfile($this->IDNo);
        if (empty((array) $data)) {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
            return response()->json($response, $status_code);
        }
        return $data;
    }

    public function driverProfile(Request $request)
    {
        $data = $this->checkLogin();

    }
}
