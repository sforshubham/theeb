<?php

namespace App\Http\Controllers;

use Config;
use Validator;
use Illuminate\Http\Request;
use App\Models\Branches;

class GuestController extends SoapController
{
    /**
     * Returns a listing of the branches.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBranches()
    {
        $data = $this->listAllBranches();
        return $data;
    }

    /**
     * Returns a listing of the vehicle type.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllVehicleTypes()
    {
        $data = $this->listAllVehicles();
        return $data;
    }

    public function login(Request $request)
    {
        $result = (object)[];
        $input = array_map('trim', $request->all());
        $validator = Validator::make($input, [
            'emailId' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->all());
        } else {
            $result = $this->doLogin($input['emailId'], $input['password']);
            // if login is success, write IDNo in session
            if (isset($result->Success) && $result->Success == 'True') {
                $session_IDNo = $result->IDNo ? $result->IDNo : $result->LicenseNo;
                $request->session()->put('user.IDNo', $session_IDNo);
                $request->session()->put('user.DriverCode', $result->DriverCode);
                return redirect('/');
            } else {
                $msg = str_replace('{tag}', 'username/password', Config::get('settings.resp_msg.incorrect_input'));
                return back()->with('error', $msg);
            }
        }
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
        $operation = Config::get('settings.cmd_operation')[$request->segment(1)];
        $rules = createModifyDriverRules($operation);
        $request_body = driverRequestBody();
        $input = [];
        foreach ($request->all() as $key => $val) {
            if (isset($request_body[$key])) {
                $input[$key] = $request_body[$key] = is_object($val) ? $val : trim($val);
            }
        }
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = $validator->errors()->all();
            $response['result'] = null;
            return response()->json($response, $status_code);
        }

        if ($operation != 'V') {
            $id_doc = $this->getFileAndEncode($request->file('IdDoc'));
            $license_doc = $this->getFileAndEncode($request->file('LicenseDoc'));
            $work_id_doc = $this->getFileAndEncode($request->file('WorkIdDoc'));
            $driver_img = $this->getFileAndEncode($request->file('DriverImage'));
        } else {
            $id_doc = $license_doc = $work_id_doc = $driver_img = ['file_base64'=> '','ext'=>''];
            $request_body['Operation'] = $operation;
        }
        $request_body['LicenseDoc'] = $license_doc['file_base64'];
        $request_body['LicenseDocFileExt'] = $license_doc['ext'];
        $request_body['IdDoc'] = $id_doc['file_base64'];
        $request_body['IdDocFileExt'] = $id_doc['ext'];
        $request_body['WorkIdDoc'] = $work_id_doc['file_base64'];
        $request_body['WorkIdDocFileExt'] = $work_id_doc['ext'];
        $request_body['DriverImage'] = $driver_img['file_base64'];
        $request_body['DriverImageFileExt'] = $driver_img['ext'];

        $data = $this->getDriverCreateModify($request_body);

        if (empty((array) $data) || $data->Success != 'Y') {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.processing_error');
            $response['result'] = NULL;
        } else {
            $data->IdDoc = $data->IdDoc != '' ? base64_encode($data->IdDoc): '';
            $data->LicenseDoc = $data->LicenseDoc != '' ? base64_encode($data->LicenseDoc): '';
            $data->WorkIdDoc = $data->WorkIdDoc != '' ? base64_encode($data->WorkIdDoc): '';
            $data->DriverImage = $data->DriverImage != '' ? base64_encode($data->DriverImage): '';
            $response['status'] = true;
            $response['message'] = '';
            $response['result'] = $data;
        }
        /**
         * @todo For users having base64 encoded file handle the case
         *
         * "Malformed UTF-8 characters, possibly incorrectly encoded"
         */
        return response()->json($response, $status_code);
    }

    public function forgotPassword(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        $input = array_map('trim', $request->all());
        $validator = Validator::make($input, [
            'Email' => 'required|email'
        ]);
        if ($validator->fails()) {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = $validator->errors()->all();
            $response['result'] = null;
        } else {
            $request_body = passwordRequestBody();
            $request_body['Mode'] = 'S';
            $request_body['Email'] = $input['Email'];

            $result = $this->password($request_body);
            if (empty((array) $result) || $result->Success != 'Y') {
                $status_code = 400;
                $response['status'] = false;
                $response['message'] = $result->VarianceReason;
                $response['result'] = null;
            } else {
                $response['status'] = true;
                $response['message'] = Config::get('settings.resp_msg.new_password');
                $response['result'] = null;
            }
        }
        return response()->json($response, $status_code);
    }

    public function maps()
    {
        $allbranches = Branches::all()->toArray();
        return view('gmap', ['allbranches' => $allbranches]);

    }

    public function sharer()
    {
        return view('sharer');
    }
}
