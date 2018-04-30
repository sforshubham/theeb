<?php

namespace App\Http\Controllers;

use Config;
use Validator;
use Illuminate\Http\Request;

class UsersController extends SoapController
{
    // This controller requires user session id

    public function checkLogin()
    {
        if (!session('user.IDNo')) {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
            return response()->json($response, $status_code);
        }
    }

    public function driverProfile(Request $request)
    {
        $status_code = 200;
        $response = array();
        $this->checkLogin();
        $IDNo = session('user.IDNo');
        $data = $this->getDriverProfile($IDNo);
        if (empty((array) $data) || $data->Success != 'Y') {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.processing_error');
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
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.processing_error');
            $response['result'] = NULL;
        } else {
            $response['status'] = true;
            $response['message'] = '';
            $response['result'] = $data;
        }
        return response()->json($response, $status_code);
    }

    public function resetPassword(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        $this->checkLogin();
        $input = array_map('trim', $request->all());
        $validator = Validator::make($input, [
            'Email' => 'required|email',
            'Password' => 'required',
            'NewPassword' => 'required'
        ]);
        if ($validator->fails()) {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = $validator->errors()->all();
            $response['result'] = null;
        } else {
            $request_body = passwordRequestBody();
            $request_body['Mode'] = 'R';
            $request_body['Email'] = $input['Email'];
            $request_body['Password'] = $input['Password'];
            $request_body['NewPassword'] = $input['NewPassword'];

            $result = $this->password($request_body);
            if (empty((array) $result) || $result->Success != 'Y') {
                $status_code = 400;
                $response['status'] = false;
                $response['message'] = $result->VarianceReason;
                $response['result'] = null;
            } else {
                $response['status'] = true;
                $response['message'] = Config::get('settings.resp_msg.reset_password');
                $response['result'] = null;
            }
        }
        return response()->json($response, $status_code);
    }

    public function makePayment(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        $this->checkLogin();
        $input = array_map('trim', $request->all());
        $validator = Validator::make($input, [
            'PaymentOption' => 'required',
            'MerchantReference' => 'required',
            'Amount' => 'required',
            'CardNumber' => 'required',
            'ExpiryDate' => 'required',
            'AuthorizationCode' => 'required',
            'ReservationNo' => 'required_without:Invoice',
            'DriverCode' => 'required',
            'Invoice' => 'required_without:ReservationNo',
        ]);
        if ($validator->fails()) {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = $validator->errors()->all();
            $response['result'] = null;
        } else {
            $request_body = [
                'PAYMENTOPTION' => ($input['PaymentOption']) ? $input['PaymentOption'] : '',
                'MERCHANTREFERENCE' => ($input['MerchantReference']) ? $input['MerchantReference'] : '',
                'AMOUNT' => ($input['Amount']) ? $input['Amount'] : '',
                'CARDNUMBER' => ($input['CardNumber']) ? $input['CardNumber'] : '',
                'EXPIRYDATE' => ($input['ExpiryDate']) ? $input['ExpiryDate'] : '',
                'AUTHORIZATIONCODE' => ($input['AuthorizationCode']) ? $input['AuthorizationCode'] : '',
                'RESERVATIONNO' => ($input['ReservationNo']) ? $input['ReservationNo'] : '',
                'DRIVERCODE' => ($input['DriverCode']) ? $input['DriverCode'] : '',
                'INVOICE' => ($input['Invoice']) ? $input['Invoice'] : '',
                'CURRENCY' => 'SAR'
            ];
            $result = $this->payment($request_body);
            if (empty((array) $result) || $result->SUCCESS != 'Y') {
                $status_code = 400;
                $response['status'] = false;
                $response['message'] = Config::get('settings.resp_msg.processing_error');
                $response['result'] = null;
            } else {
                $response['status'] = true;
                $response['message'] = Config::get('settings.resp_msg.payment_success');
                $response['result'] = null;
            }
        }
        return response()->json($response, $status_code);
    }

    public function documentPrint(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        $this->checkLogin();
        $input = array_map('trim', $request->all());
        $validator = Validator::make($input, [
            'DocumentNumber' => 'required',
        ]);
        if ($validator->fails()) {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = $validator->errors()->all();
            $response['result'] = null;
        } else {
            $request_body['PrintFor'] = 'R';
            $request_body['DocumentNumber'] = $input['DocumentNumber'];

            $result = $this->docuPrint($request_body);
            if (empty((array) $result) || $result->Success != 'Y') {
                $status_code = 400;
                $response['status'] = false;
                $response['message'] = $result->VarianceReason;
                $response['result'] = null;
            } else {
                $response['status'] = true;
                $response['message'] = '';
                $response['result'] = $result;
            }
        }
        return response()->json($response, $status_code);
    }

    public function getTransDetails(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        $this->checkLogin();
        $operation = Config::get('settings.transaction')[$request->segment(3)];
        $input = array_map('trim', $request->all());
        $validator = Validator::make($input, [
            'StartDate' => 'required|date_format:d/m/Y',
            'EndDate' => 'required|date_format:d/m/Y',
            'DriverCode' => 'required'
        ]);
        if ($validator->fails()) {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = $validator->errors()->all();
            $response['result'] = null;
        } else {
            $request_body['TransactionFor'] = $operation;
            $request_body['StartDate'] = $input['StartDate'];
            $request_body['EndDate'] = $input['EndDate'];
            $request_body['DriverCode'] = $input['DriverCode'];

            $result = $this->transaction($request_body);
            if (empty((array) $result)) {
                $status_code = 200;
                $response['status'] = true;
                $response['message'] = Config::get('settings.resp_msg.no_data');;
                $response['result'] = null;
            } else {
                $response['status'] = true;
                $response['message'] = '';
                $response['result'] = $result;
            }
        }
        return response()->json($response, $status_code);
    }

    public function myBooking(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        $this->checkLogin();
        $input = array_map('trim', $request->all());
        $validator = Validator::make($input, [
            'PassportID' => 'required',
        ]);
        if ($validator->fails()) {
            $status_code = 400;
            $response['status'] = false;
            $response['message'] = $validator->errors()->all();
            $response['result'] = null;
        } else {
            $result = $this->booking($input);
            if (empty((array) $result) || $result->Success != 'Y') {
                $status_code = 400;
                $response['status'] = true;
                $response['message'] = $result->VarianceReason;
                $response['result'] = null;
            } else {
                $response['status'] = true;
                $response['message'] = '';
                $response['result'] = $result;
            }
        }
        return response()->json($response, $status_code);
    }
}
