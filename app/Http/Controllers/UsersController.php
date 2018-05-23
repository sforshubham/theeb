<?php

namespace App\Http\Controllers;

use Config;
use Validator;
use Illuminate\Http\Request;
use Payfort;

class UsersController extends SoapController
{
    // This controller requires user session id

    public function driverProfile(Request $request)
    {
        $data = (object)[];
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $IDNo = session('user.IDNo');
            $data = $this->getDriverProfile($IDNo);
            if (!isset($data->Success) || $data->Success != 'Y') {
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
        $input = array_map('trim', $request->all());
        $validator = Validator::make($input, [
            'PickupLocation' => 'required',
            'DropLocation' => 'required',
            'PickupDate' => 'required|date_format:d/m/Y|after:tomorrow',
            'PickupTime' => 'required',
            'DropDate' => 'required|date_format:d/m/Y|after_or_equal:PickupDate',
            'DropTime' => 'required',
            'CarCategory' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->all());
        } elseif (!$this->checkLogin()) {
            $request->session()->put('booking_form', $input);
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $input = [
                'CDP' => '',
                'OutBranch' => $input['PickupLocation'],
                'InBranch' => $input['DropLocation'],
                'OutDate' => $input['PickupDate'],
                'OutTime' => $input['PickupTime'],
                'InDate' => $input['DropDate'],
                'InTime' => $input['DropTime'],
                'VEHICLETYPE' => $input['CarGroup'] ? '' : $input['CarCategory'],
                'CarGroup' => $input['CarGroup'] ? $input['CarGroup'] : '',
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
            if (!isset($data->Success) || $data->Success != 'Y') {
                return back()->with('error', Config::get('settings.resp_msg.processing_error'));
            } else {
                $veh_types = $this->getSelectedVehicles($request->get('CarCategory'));
                if (isset($data->Price->CarGroupPrice) && is_object($data->Price->CarGroupPrice)) {
                    $data->Price->CarGroupPrice = [$data->Price->CarGroupPrice];
                }
                $request->session()->put('price_estimation', $data);
                $car_groups = [];
                foreach ($veh_types as $veh) {
                    $car_groups[$veh['Group']] = $veh;
                }
                unset($veh_types);
                return view('app.select_car')->with('data', $data)->with('car_groups', $car_groups);
            }
        }
    }

    public function resetPassword(Request $request)
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $input = array_map('trim', $request->all());
            $validator = Validator::make($input, [
                'OldPassword' => 'required',
                'NewPassword' => 'required|between:8,16',
                'ConfirmPassword' => 'required|same:NewPassword',
            ]);
            if ($validator->fails()) {
                return back()->with('error', $validator->errors()->all());
            } else {
                $request_body = passwordRequestBody();
                $request_body['Mode'] = 'R';
                $request_body['Email'] = session('user.Email');
                $request_body['Password'] = $input['OldPassword'];
                $request_body['NewPassword'] = $input['NewPassword'];
                $result = $this->password($request_body);
                if (!isset($result->Success)) {
                    return back()->with('error', Config::get('settings.resp_msg.processing_error'));
                } elseif ($result->Success != 'Y') {
                    return back()->with('error', Config::get('settings.resp_msg.incorrect_password'));
                } else {
                    return back()->with('success', Config::get('settings.resp_msg.reset_password'));
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
                if (!isset($result->SUCCESS) || $result->SUCCESS != 'Y') {
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
                if (!isset($result->Success)) {
                    return back()->with('error', Config::get('settings.resp_msg.processing_error'));
                } elseif ($result->Success != 'Y') {
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
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $IDNo = session('user.IDNo');
            $result = $this->booking(['PassportID' => $IDNo]);
            if (!isset($result->Success)) {
                return back()->with('error', Config::get('settings.resp_msg.processing_error'));
            } elseif ($result->Success != 'Y') {
                return back()->with('error', $result->VarianceReason);
            } else {
                return view('app.booking')->with('result', $result);
            }
        }
    }

    public function newReservation(Request $request)
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $operation = Config::get('settings.reservation_operation')['new_reservation'];
            $request_body = reservationBody();
            $input = [];

            $request_body['ReservationStatus'] = $operation;
            $index =  (int) $request->get('index') ?? 0;
            if (session()->has('price_estimation')) {
                $sess_data = session('price_estimation');
            } else {
                return redirect('/')->with('error', Config::get('settings.resp_msg.processing_error'));
            }
            if (file_exists(Config::get('settings.reservation.file_path'))) {
                $res_no = file_get_contents(Config::get('settings.reservation.file_path')) + 1;
            } else {
                $res_no = Config::get('settings.reservation.init_no');
            }
            file_put_contents(Config::get('settings.reservation.file_path'), $res_no);
            $request_body['DriverCode'] = session('user.DriverCode');
            $request_body['OutBranch'] = $sess_data->Price->OutBranch;
            $request_body['CDP'] = $sess_data->Price->CDP;
            $request_body['InBranch'] = $sess_data->Price->InBranch;
            $request_body['OutDate'] = $sess_data->Price->OutDate;
            $request_body['OutTime'] = $sess_data->Price->OutTime;
            $request_body['InDate'] = $sess_data->Price->InDate;
            $request_body['InTime'] = $sess_data->Price->InTime;
            $request_body['RateNo'] = $sess_data->Price->CarGroupPrice[$index]->RateNo;
            $request_body['CarGroup'] = $sess_data->Price->CarGroupPrice[$index]->CarGrop;

            $request_body['ReservationNo'] = $res_no;
            $result = $this->reservation(['Reservation' => $request_body]);
            if (!isset($result->Success)) {
                return back()->with('error', Config::get('settings.resp_msg.processing_error'));
            } elseif ($result->Success != 'Y') {
                return back()->with('error', $result->VarianceReason);
            } else {
                $sess_data->Price->CarGroupPrice = $sess_data->Price->CarGroupPrice[$index];
                $lw = explode(' ', $result->VarianceReason);
                $lw = end($lw);
                session()->put('ReservationNo', $lw);
                session()->put('reserved_car', $sess_data);
                session()->forget('price_estimation');
                return redirect('/payment_mode')->with('success', $result->VarianceReason);
            }
        }
    }

    public function modifyReservation(Request $request)
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $operation = Config::get('settings.reservation_operation')['modify_reservation'];
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
                return back()->with('error', $validator->errors()->all());
            } else {
                $result = $this->reservation(['Reservation' => $request_body]);

                if (!isset($result->Success)) {
                    return back()->with('error', Config::get('settings.resp_msg.processing_error'));
                } elseif ($result->Success != 'Y') {
                    return back()->with('error', $result->VarianceReason);
                } else {
                    return redirect('/booking')->with('success', $result->VarianceReason);
                }
            }
        }
    }

    public function cancelReservation(Request $request)
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $operation = Config::get('settings.reservation_operation')['cancel_reservation'];
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
                return back()->with('error', $validator->errors()->all());
            } else {
                $request_body['ReservationStatus'] = $operation;

                $result = $this->reservation(['Reservation' => $request_body]);

                if (!isset($result->Success)) {
                    return back()->with('error', Config::get('settings.resp_msg.processing_error'));
                } elseif ($result->Success != 'Y') {
                    return back()->with('error', $result->VarianceReason);
                } else {
                    return redirect('/booking')->with('success', $result->VarianceReason);
                }
            }
        }
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

    public function rentACar(Request $request)
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $car_group = $request->get('g');
            $selected = ['CarCategory' => '', 'CarGroup' => ''];
            if ($car_group) {
                $vth_code = $this->getVehCode($car_group);
                if ($vth_code) {
                    $selected['CarCategory'] = $vth_code->VTHCode;
                    $selected['CarGroup'] = $car_group;
                }
            }
            $branches = $this->listAllBranches();
            $vehicles = $this->vehicleTypes();
            return view('app.rentacar')->with('branches', $branches)->with('vehicles', $vehicles)->with('selected', $selected);
        }
    }

    public function changePassword()
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            return view('app.change_password');
        }
    }

    public function viewCarDetail(Request $request, $index)
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $data = session('price_estimation');
            if (isset($data->Price->CarGroupPrice[$index])) {
                $car_group = $data->Price->CarGroupPrice[$index]->CarGrop;
                $more_detail = $this->getVehCode($car_group);
                $selected_branches = $this->getBranchName([$data->Price->OutBranch, $data->Price->InBranch]);
            } else {
                return back()->with('error', Config::get('settings.resp_msg.no_data'));
            }
            return view('app.car_detail')
                ->with('index',$index)
                ->with('data',$data)
                ->with('selected_branches',$selected_branches)
                ->with('more_detail',$more_detail);
        }
    }

    public function paymentMode()
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $booking_data = session('reserved_car');
            $car_group = $booking_data->Price->CarGroupPrice->CarGrop;
            $group_detail = $this->getVehCode($car_group);

            return view('app.payment_mode')
                ->with('group_detail', $group_detail)
                ->with('booking_data', $booking_data);
        }
    }
}
