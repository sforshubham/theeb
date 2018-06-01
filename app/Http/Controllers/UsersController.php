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
                $countries = $this->listAllCountries();
                return view('app.profile')->with('data', $data)->with('countries', $countries);
            }
        }
    }

    public function tariff()
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $request_body = priceEstimationBody();
            $prices = $this->getPriceEstimation($request_body);
            if (!isset($prices->Success) || empty($prices->Price) || $prices->Success != 'Y') {
                return back()->with('error', Config::get('settings.resp_msg.no_cars'));
            } else {
                if (isset($prices->Price->CarGroupPrice) && is_object($prices->Price->CarGroupPrice)) {
                    $prices->Price->CarGroupPrice = [$prices->Price->CarGroupPrice];
                }
                $veh_type = $this->vehicleTypes();
                $car_models = $this->listAllVehicles();
                $data = [];
                foreach ($car_models as $car) {
                    $data[$car['Group']] = $car;
                }
                return view('app.tariff')
                    ->with('data', $data)
                    ->with('veh_type', $veh_type)
                    ->with('prices', $prices);
            }
        }
    }

    public function priceEstimation(Request $request)
    {
        $input = array_map('trim', $request->all());
        $validator = Validator::make($input, [
            'PickupLocation' => 'required',
            'DropLocation' => 'required',
            'PickupDate' => 'required|date_format:d/m/Y|after:today',
            'PickupTime' => 'required',
            'DropDate' => 'required|date_format:d/m/Y|after_or_equal:PickupDate',
            'DropTime' => 'required',
            'CarCategory' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->all())->with('data',$input);
        } elseif (!$this->checkLogin()) {
            $request->session()->put('booking_form', $input);
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $request_body = priceEstimationBody();
            $request_body['OutBranch'] = $input['PickupLocation'];
            $request_body['InBranch'] = $input['DropLocation'];
            $request_body['OutDate'] = $input['PickupDate'];
            $request_body['OutTime'] = $input['PickupTime'];
            $request_body['InDate'] = $input['DropDate'];
            $request_body['InTime'] = $input['DropTime'];
            $request_body['VEHICLETYPE'] = $input['CarGroup'] ? '' : $input['CarCategory'];
            $request_body['CarGroup'] = $input['CarGroup'] ? $input['CarGroup'] : '';

            $data = $this->getPriceEstimation($request_body);
            if (!isset($data->Success) || empty($data->Price) || $data->Success != 'Y') {
                return back()->with('error', Config::get('settings.resp_msg.no_cars'))->with('data',$input);
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
                    $request->session()->flush();
                    session()->flush();
                    return redirect('/')->with('success', Config::get('settings.resp_msg.reset_password'));
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
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $input = array_map('trim', $request->all());
            $validator = Validator::make($input, [
                'DocumentNumber' => 'required',
            ]);
            if ($validator->fails()) {
                return back()->with('error', $validator->errors()->all());
            } else {
                $request_body['PrintFor'] = 'R';
                $request_body['DocumentNumber'] = $input['DocumentNumber'];

                $result = $this->docuPrint($request_body);
                if (!isset($result->Success)) {
                    return back()->with('error', Config::get('settings.resp_msg.processing_error'));
                } elseif ($result->Success != 'Y') {
                    return back()->with('error', $result->VarianceReason);
                } else {
                    $file_url = $result->DocumentPrint;
                    if(@get_headers($file_url)[0] == 'HTTP/1.1 404 Not Found') {
                        return back()->with('error', Config::get('settings.resp_msg.no_document'));
                    } else {
                        header('Content-Type: application/octet-stream');
                        header("Content-Transfer-Encoding: Binary"); 
                        header("Content-disposition: attachment; filename=\"".basename($file_url)."\""); 
                        readfile($file_url);
                        exit;
                    }
                }
            }
        }
        return response()->json($response, $status_code);
    }

    public function getTransDetails(Request $request)
    {
        $requester = $request->route()->getAction('as');
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $operation = Config::get('settings.trans_master')[$requester]['operation'];
            $input = array_map('trim', $request->all());
            $validator = Validator::make($input, [
                'StartDate' => 'nullable|date_format:d/m/Y',
                'EndDate' => 'nullable|date_format:d/m/Y'
            ]);
            if ($validator->fails()) {
                return back()->with('error', $validator->errors()->all());
            } else {
                $request_body = [];
                $request_body['TransactionFor'] = $operation;
                $request_body['StartDate'] = isset($input['StartDate']) ? $input['StartDate'] : (new \DateTime("-3 months"))->format('d/m/Y');
                $request_body['EndDate'] = isset($input['EndDate']) ? $input['EndDate'] : (new \DateTime())->format('d/m/Y');
                $request_body['DriverCode'] = session('user.DriverCode');

                $result = $this->transaction($request_body);
                if (!isset($result->Success)) {
                    return back()->with('error', Config::get('settings.resp_msg.processing_error'));
                } elseif ($result->Success != 'Y') {
                    return back()->with('error', Config::get('settings.resp_msg.no_data'));
                } else {
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
                return redirect('/payment_mode')->with('success', Config::get('settings.resp_msg.new_reservation'));
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
                $request_body['ReservationStatus'] = $operation;
                $request_body['DriverCode'] = session('user.DriverCode');
                $result = $this->reservation(['Reservation' => $request_body]);

                if (!isset($result->Success)) {
                    return back()->with('error', Config::get('settings.resp_msg.processing_error'));
                } elseif ($result->Success != 'Y') {
                    return back()->with('error', $result->VarianceReason);
                } else {
                    return redirect('/booking')->with('success', Config::get('settings.resp_msg.extend_reservation'));
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
                    return redirect('/booking')->with('success', Config::get('settings.resp_msg.cancel_reservation'));
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

    public function paymentMode(Request $request)
    {
        if (!$this->checkLogin()) {
            return redirect('/')->with('error', Config::get('settings.resp_msg.auth_error'));
        } else {
            $requester = $request->route()->getAction('as');
            if ($requester == 'payment_request_route') {
                // Handle payment request -- Redirect to PayFort
                
                $payfortIntegration = new \PayfortIntegration();
                $payfortIntegration->amount = $request->paymentAmount;
                return $payfortIntegration->processRequest($request->paymentMethod);
            } else if ($requester == 'payment_response_route') {
                // Handle payment response -- Validate and submit to Payment API & then redirect to a view
                $status = false;
                $payfortIntegration = new \PayfortIntegration();
                $validated_response = $payfortIntegration->processResponse();

                if ($validated_response['status'] === true) {
                    // Payment has successfully been captured
                    $validated_response = $validated_response['params'];
                    $validated_response['amount'] = $payfortIntegration->castAmountFromFort($validated_response['amount'], $validated_response['currency']);
                    $request_body = [
                        'PAYMENTOPTION' => $validated_response['payment_option'],
                        'MERCHANTREFERENCE' => $validated_response['merchant_reference'],
                        'AMOUNT' => $validated_response['amount'],
                        'CARDNUMBER' => $validated_response['card_number'],
                        'EXPIRYDATE' => $validated_response['expiry_date'],
                        'AUTHORIZATIONCODE' => $validated_response['authorization_code'],
                        'RESERVATIONNO' => $validated_response['merchant_reference'],
                        'DRIVERCODE' => session('user.DriverCode'),
                        'CURRENCY' => $validated_response['currency'],
                        'INVOICE' => ''
                    ];
                    $result = $this->payment($request_body);
                    if (!isset($result->SUCCESS) || $result->SUCCESS != 'Y') {
                        $message = 'Payment processed but could not register with us.';
                    } else {
                        $status = true;
                    }
                } else {
                    $message = 'Not able to validate the payment';
                }
                return redirect()->route('payment_result',['status'=>(int)$status, ]);
                
            } else if ($requester == 'payment_result') {
                // Handle payment response view -- Show relevant details
                
                $booking_data = session('reserved_car');
                $car_group = $booking_data->Price->CarGroupPrice->CarGrop;
                $group_detail = $this->getVehCode($car_group);

                return view('app.payment_result')
                    ->with('status', $request->status)
                    ->with('group_detail', $group_detail)
                    ->with('booking_data', $booking_data);
            
            }
            $booking_data = session('reserved_car');
            $car_group = $booking_data->Price->CarGroupPrice->CarGrop;
            $group_detail = $this->getVehCode($car_group);

            return view('app.payment_mode')
                ->with('group_detail', $group_detail)
                ->with('booking_data', $booking_data);
        }
    }
}
