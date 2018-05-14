<?php

namespace App\Http\Controllers;

use Config;
use Validator;
use Illuminate\Http\Request;
use Payfort;

class UsersController extends SoapController
{
    // This controller requires user session id

    public function checkLogin()
    {
        if (session()->has('user.IDNo')) {
            return true;
        } else {
            return false;
        }
    }

    public function driverProfile(Request $request)
    {
        $data = (object)[];
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $IDNo = session('user.IDNo');
            $data = $this->getDriverProfile($IDNo);
            if (empty((array) $data) || $data->Success != 'Y') {
                return back()->with('error', Config::get('settings.resp_msg.processing_error'));
            } else {
                return view('app.profile')->with('data', $data);
            }
        }
    }

    public function tariff()
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $veh_type = $this->vehicleTypes();
            $data = $this->listAllVehicles();
            return view('app.tariff')->with('data', $data)->with('veh_type', $veh_type);
        }
    }

    public function priceEstimation(Request $request)
    {
        $status_code = 200;
        $response = array();
        if (!$this->checkLogin()) {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
        } else {
            $input = array_map('trim', $request->all());
            $validator = Validator::make($input, [
                'PickupLocation' => 'required',
                'DropLocation' => 'required',
                'PickupDate' => 'required|date_format:d/m/Y|after:tomorrow',
                'PickupTime' => 'required',
                'DropDate' => 'required|date_format:d/m/Y|after:PickupDate',
                'DropTime' => 'required',
                'CarCategory' => 'required',
            ]);
            if ($validator->fails()) {
                $status_code = 400;
                $response['status'] = false;
                $response['message'] = $validator->errors()->all();
                $response['result'] = null;
            } else {
                $input = [
                    'CDP' => '',
                    'OutBranch' => $input['PickupLocation'],
                    'InBranch' => $input['DropLocation'],
                    'OutDate' => $input['PickupDate'],
                    'OutTime' => $input['PickupTime'],
                    'InDate' => $input['DropDate'],
                    'InTime' => $input['DropTime'],
                    'CarGroup' => $input['CarCategory'],
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
            }
        }
        return response()->json($response, $status_code);
    }

    public function resetPassword(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        if (!$this->checkLogin()) {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
        } else {
            $input = array_map('trim', $request->all());
            $validator = Validator::make($input, [
                'Email' => 'required|email',
                'Password' => 'required',
                'NewPassword' => 'required|size:8'
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
        }
        return response()->json($response, $status_code);
    }

    public function makePayment(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        if (!$this->checkLogin()) {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
        } else {
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
        }
        return response()->json($response, $status_code);
    }

    public function documentPrint(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        if (!$this->checkLogin()) {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
        } else {
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
        }
        return response()->json($response, $status_code);
    }

    public function getTransDetails(Request $request)
    {
        $requester = $request->route()->getAction('as');
        $status_code = 200;
        $result = (object)[];
        $response = [];
        if (!$this->checkLogin()) {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
        } else {
            $operation = Config::get('settings.trans_master')[$requester]['operation'];
            $input = array_map('trim', $request->all());
            $validator = Validator::make($input, [
                'StartDate' => 'nullable|date_format:d/m/Y',
                'EndDate' => 'nullable|date_format:d/m/Y'
            ]);
            if ($validator->fails()) {
                $status_code = 400;
                $response['status'] = false;
                $response['message'] = $validator->errors()->all();
                $response['result'] = null;
            } else {
                $request_body = [];
                $request_body['TransactionFor'] = $operation;
                $request_body['StartDate'] = isset($input['StartDate']) ? $input['StartDate'] : (new \DateTime("-3 months"))->format('d/m/Y');
                $request_body['EndDate'] = isset($input['EndDate']) ? $input['EndDate'] : (new \DateTime())->format('d/m/Y');
                $request_body['DriverCode'] = session('user.DriverCode');

                $result = $this->transaction($request_body);
                if (empty((array) $result)) {
                    $status_code = 200;
                    $response['status'] = true;
                    $response['message'] = Config::get('settings.resp_msg.no_data');
                    $response['result'] = null;
                } else {
                    $response['status'] = true;
                    $response['message'] = '';
                    $response['result'] = $result;
                }
                return view(
                    'app.' . config('settings.trans_master')[$requester]['view'],
                    [
                        'result' => $result,
                        'labels' => config('settings.trans_master')[$requester]['labels'],
                        'start_date' => $request_body['StartDate'],
                        'end_date' => $request_body['EndDate'],
                    ]
                );

            }
        }
    }

    public function myBooking()
    {
        $result = (object)[];

        if (!$this->checkLogin()) {
            return redirect('/')->with('msg', Config::get('settings.resp_msg.auth_error'));
        } else {
            $IDNo = session('user.IDNo');
            $result = $this->booking(['PassportID' => $IDNo]);
            if (empty((array) $result) || $result->Success != 'Y') {
                return redirect('/')->with('msg', $result->VarianceReason);
            } else {
                return view('app.booking')->with('result', $result);
            }
        }
    }

    public function manageReservation(Request $request)
    {
        $status_code = 200;
        $result = (object)[];
        $response = [];
        if (!$this->checkLogin()) {
            $status_code = 401;
            $response['status'] = false;
            $response['message'] = Config::get('settings.resp_msg.auth_error');
            $response['result'] = NULL;
        } else {
            $operation = Config::get('settings.reservation_operation')[$request->segment(3)];
            $rules = reservationRules($operation);
            $request_body = reservationBody();
            $input = [];
            foreach ($request->all() as $key => $val) {
                if (isset($request_body[$key])) {
                    $input[$key] = $request_body[$key] = (is_object($val) || is_array($val)) ? $val : trim($val);
                }
            }
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                $status_code = 400;
                $response['status'] = false;
                $response['message'] = $validator->errors()->all();
                $response['result'] = null;
            } else {
                $request_body['ReservationStatus'] = $operation;
                $result = $this->reservation(['Reservation' => $request_body]);
                if (empty((array) $result) || $result->Success != 'Y') {
                    $status_code = 400;
                    $response['status'] = false;
                    $response['message'] = $result->VarianceReason;
                    $response['result'] = null;
                } else {
                    $response['status'] = true;
                    $response['message'] = $result->VarianceReason;
                    $response['result'] = $result;
                }
            }
        }
        return response()->json($response, $status_code);
    }

    public function payFortPay()
    {
        return Payfort::redirection()->displayRedirectionPage([
            'command' => 'AUTHORIZATION',              # AUTHORIZATION/PURCHASE according to your operation.
            'merchant_reference' => 'ORDR.'.rand(),   # You reference id for this operation (Order id for example).
            'amount' => 230,                           # The operation amount.
            'currency' => 'SAR',                       # Optional if you need to use another currenct than set in config.
            'customer_email' => 'shubhamgoeloctane@gmail.com'  # Customer email.
        ]);
    }
}
