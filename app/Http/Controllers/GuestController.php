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
            return back()->with('error', $validator->errors()->all())->with('data',$input);
        } else {
            $result = $this->doLogin($input['emailId'], $input['password']);
            // if login is success, write IDNo in session
            if (isset($result->Success) && $result->Success == 'True') {
                $session_IDNo = $result->IDNo ? $result->IDNo : $result->LicenseNo;
                $request->session()->put('user.IDNo', $session_IDNo);
                $request->session()->put('user.DriverCode', $result->DriverCode);
                $request->session()->put('user.Email', $result->Email);
                $request->session()->put('user.FirstName', $result->FirstName);

                if (session()->has('booking_form')) {
                    $form_data = session('booking_form');
                    session()->forget('booking_form');
                    return redirect('/price_estimation?'.http_build_query($form_data));
                }
                return redirect('/');
            } else {
                $msg = str_replace('{tag}', 'username/password', Config::get('settings.resp_msg.incorrect_input'));
                return back()->with('error', $msg)->with('data',$input);
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        session()->flush();
        return redirect('/')->with('success', Config::get('settings.resp_msg.logout'));
    }

    public function createModifyDriver(Request $request)
    {
        if (session()->has('user.IDNo')) {
            return redirect('/book');
        }
        $requester = $request->route()->getAction('as');
        if ($request->isMethod('post') || $requester == 'view_driver') {

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
            $input['id_version'] = $request->get('id_version');
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                $response['status'] = false;
                $response['message'] = $validator->errors()->all();
                $response['result'] = null;
                return view('app.signup', [
                    'status' => $response['status'] ?? '',
                    'response' => $response['message'] ?? '',
                    'IdType' => $request_body['IdType'] ?? '',
                    'IdNo' => $request_body['IdNo'] ?? '',
                    'IdDoc' => $request_body['IdDoc'] ?? '',
                    'id_version' => $input['id_version'] ?? '',
                    'LicenseId' => $request_body['LicenseId'] ?? '',
                    'LicenseDoc' => $request_body['LicenseDoc'] ?? '',
                    'LicenseExpiryDate' => $request_body['LicenseExpiryDate'] ?? '',
                    'Nationality' => $request_body['Nationality'] ?? '',
                    'FirstName' => $request_body['FirstName'] ?? '',
                    'LastName' => $request_body['LastName'] ?? '',
                    'Address1' => $request_body['Address1'] ?? '',
                    'Address2' => $request_body['Address2'] ?? '',
                    'DateOfBirth' => $request_body['DateOfBirth'] ?? '',
                    'Mobile' => $request_body['Mobile'] ?? '',
                    'Email' => $request_body['Email'] ?? '',
                    'Password' => $request_body['Password'] ?? '',
                ]);
            }

            $request_body['Operation'] = $operation;
            if ($operation != 'V') {
                $id_doc = $this->getFileAndEncode($request->file('IdDoc'));
                $license_doc = $this->getFileAndEncode($request->file('LicenseDoc'));
                // $work_id_doc = $this->getFileAndEncode($request->file('WorkIdDoc'));
                // $driver_img = $this->getFileAndEncode($request->file('DriverImage'));
            } else {
                $id_doc = $license_doc = $work_id_doc = $driver_img = ['file_base64'=> '','ext'=>''];
            }
            $request_body['LicenseDoc'] = $license_doc['file_base64'];
            $request_body['LicenseDocFileExt'] = '.' . strtoupper($license_doc['ext']);
            $request_body['IdDoc'] = $id_doc['file_base64'];
            $request_body['IdDocFileExt'] = '.' . strtoupper($id_doc['ext']);
            $request_body['IDSerialNo'] = $input['id_version'] ?? '1';

            $data = $this->getDriverCreateModify($request_body);
            if (empty((array) $data) || !isset($data->Success)) {
                $response['status'] = false;
                $response['message'] = [Config::get('settings.resp_msg.processing_error')];
                $response['result'] = NULL;
            } elseif($data->Success != 'Y') {
                $response['status'] = false;
                $response['message'] = [$data->VarianceReason];
                $response['result'] = NULL;
            } else {
                $response['status'] = true;
                $response['message'] = '';
                $response['result'] = $data;
                $request_body = array_replace($request_body, (array)$response['result']);
                if ($requester != 'view_driver') {
                    return redirect('/')->with('success', Config::get('settings.resp_msg.signup_success'));
                }
            }
            /**
             * @todo For users having base64 encoded file handle the case
             *
             * "Malformed UTF-8 characters, possibly incorrectly encoded"
             */
        }

        if ($requester == 'view_driver') {
            unset(
                $request_body['LicenseDoc'],
                $request_body['LicenseDocExt'],
                $request_body['IdDoc'],
                $request_body['IdDocExt'],
                $request_body['IDSerialNo'],
                $request_body['DriverImage'],
                $request_body['DriverImageExt'],
                $request_body['DriverImageFileExt'],
                $request_body['WorkIdDoc'],
                $request_body['WorkIdDocExt'],
                $request_body['WorkIdDocFileExt'],
                $request_body['WorkTel'],
                $request_body['LicenseDocFileExt'],
                $request_body['LicenseIssuedBy'],
                $request_body['IdDocFileExt'],
                $request_body['DriverCode'],
                $request_body['HomeTel'],
                $request_body['MembershipNo'],
                $request_body['Operation'],
                $request_body['VarianceReason'],
                $request_body['Password']
            );
            return response()->json($request_body, 200);
        }

        return view('app.signup', [
            'status' => $response['status'] ?? '',
            'response' => $response['message'] ?? '',
            'IdType' => $request_body['IdType'] ?? '',
            'IdNo' => $request_body['IdNo'] ?? '',
            'IdDoc' => $request_body['IdDoc'] ?? '',
            'id_version' => $input['id_version'] ?? '',
            'LicenseId' => $request_body['LicenseId'] ?? '',
            'LicenseDoc' => $request_body['LicenseDoc'] ?? '',
            'LicenseExpiryDate' => $request_body['LicenseExpiryDate'] ?? '',
            'Nationality' => $request_body['Nationality'] ?? '',
            'FirstName' => $request_body['FirstName'] ?? '',
            'LastName' => $request_body['LastName'] ?? '',
            'Address1' => $request_body['Address1'] ?? '',
            'Address2' => $request_body['Address2'] ?? '',
            'DateOfBirth' => $request_body['DateOfBirth'] ?? '',
            'Mobile' => $request_body['Mobile'] ?? '',
            'Email' => $request_body['Email'] ?? '',
            'Password' => $request_body['Password'] ?? '',
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $input = array_map('trim', $request->all());
        $validator = Validator::make($input, [
            'Email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->all())->with('data', $input);
        } else {
            $request_body = passwordRequestBody();
            $request_body['Mode'] = 'S';
            $request_body['Email'] = $input['Email'];

            $result = $this->password($request_body);
            if (!isset($result->Success) || $result->Success != 'Y') {
                return back()->with('error', $result->VarianceReason)->with('data', $input);
            } else {
                return back()->with('success', Config::get('settings.resp_msg.new_password'));
            }
        }
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

    public function requestPassword()
    {
        if ($this->checkLogin()) {
            return redirect('/');
        } else {
            return view('app.forgot_password');
        }
    }

    public function guest()
    {
        if (session()->has('user.IDNo')) {
            return redirect('/book');
        } else {
            return view('app.login');
        }
    }
}
