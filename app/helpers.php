<?php

function pr($param)
{
    echo '<pre>';
    print_r($param);
    echo '</pre>';
}

function object_to_array($obj, $escape_keys = [])
{
    if (is_object($obj)) {
    	$obj = (array) $obj;
    }
    if (is_array($obj)) {
        foreach ($obj as $key => $val) {
            if (array_key_exists($key, $escape_keys)) {
                unset($obj[$key]);
            } else {
                $obj[$key] = object_to_array($val, $escape_keys);
            }
        }
    }
    return $obj; 
}

function array_to_object($array)
{
  $obj = new stdClass;
  foreach($array as $k => $v) {
     if(strlen($k)) {
        if(is_array($v)) {
           $obj->{$k} = array_to_object($v); //RECURSION
        } else {
           $obj->{$k} = $v;
        }
     }
  }
  return $obj;
}

function file_to_base64($filepath)
{
    $path = $filepath;
    $type = mime_content_type($path);
    $data = file_get_contents($path);
    $base64 = 'data:' . $type . ';base64,' . base64_encode($data);
    return $base64;
}

function no_trim_object($array = [])
{
    $result = array_map(function ($val) {
        if (is_object($val)) {
            return $val;
        } else {
            return trim($val);
        }
    }, $array);
    return $result;
}

function createModifyDriverRules($operation = '')
{
    $rules = [];
    switch ($operation) {
        case 'V':
            $rules = [
                'IdNo' => 'required'
            ];
            break;
        case 'N':
            $rules = [
                'IdType' => 'required|in:iqama,saudi id,passport',
                'IdNo' => 'required',
                'IdDoc' => 'file',
                'LastName' => 'required',
                'FirstName' => 'required',
                'DateOfBirth' => 'date_format:d/m/Y|before_or_equal:today',
                'Nationality' => 'required',
                'LicenseId' => 'required',
                'LicenseExpiryDate' => 'required|date_format:d/m/Y',
                'LicenseDoc' => 'file',
                'WorkTel' => 'numeric',
                'Mobile' => 'required|numeric|regex:/(05)[0-9]{8}/',
                'Email' => 'required|email',
                'WorkIdDoc' => 'file',
                'DriverImage' => 'image'
            ];
            break;
        case 'E':
            $rules = [
                'IdType' => 'in:iqama,saudi id,passport',
                'IdNo' => 'required',
                'IdDoc' => 'file',
                'LastName' => 'required',
                'FirstName' => 'required',
                'DateOfBirth' => 'date_format:d/m/Y|before_or_equal:today',
                'Nationality' => 'required',
                'LicenseId' => 'required',
                'LicenseExpiryDate' => 'required|date_format:d/m/Y',
                'LicenseDoc' => 'required|file',
                'WorkTel' => 'numeric',
                'Mobile' => 'required|numeric|regex:/(05)[0-9]{8}/',
                'Email' => 'required|email',
                'WorkIdDoc' => 'file',
                'DriverImage' => 'image'
            ];
            break;
    }
    return $rules;
}

function driverRequestBody()
{
    $input = [
        'LastName' => '',
        'FirstName' => '',
        'DateOfBirth' => '',
        'Nationality' => '',
        'LicenseId' => '',
        'LicenseExpiryDate' => '',
        'LicenseDoc' => '',
        'LicenseDocFileExt' => '',
        'Address1' => '',
        'Address2' => '',
        'WorkTel' => '',
        'Mobile' => '',
        'Email' => '',
        'IdType' => '',
        'IdNo' => '',
        'IdDoc' => '',
        'IdDocFileExt' => '',
        'MembershipNo' => '',
        'Operation' => '',
        'Password' => '',
        'IDSerialNo' => '',
        'WorkIdDoc' => '',
        'WorkIdDocFileExt' => '',
        'DriverImage' => '',
        'DriverImageFileExt' => '',
        'HomeTel' => '',
        'LicenseIssuedBy' => '',
    ];
    return $input;
}

function passwordRequestBody()
{
    $input = [
        'Mode' => '',
        'Email' => '',
        'Password' => '',
        'NewPassword' => '',
    ];
    return $input;
}

function reservationBody()
{
    $input = [
        'DriverCode' => '9900000023',
        'LicenseNo' => '1003282780',
        'LastName' => '',
        'FirstName' => '',
        'CDP' => '',
        'OutBranch' => '5',
        'InBranch' => '5',
        'OutDate' => '23/08/2017',
        'OutTime' => '16:49',
        'InDate' => '30/08/2017',
        'InTime' => '16:49',
        'RateNo' => '302',
        'RentalSum' => '',
        'DepositAmount' => '',
        'ReservationNo' => '8983302639',
        'ReservationStatus' => 'N',
        'CarGroup' => 'PR38',
        'Currency' => 'SAR',
        'PaymentType' => '4',
        'CreditCardNo' => '',
        'CarMake' => '',
        'CarModel' => '',
        'Remarks' => 'Testing',
        'Booked' => [
            'Insurance' => ['Code' => '', 'Name' => '', 'Quantity' => ''],
            'Extra' => ['Code' => '', 'Name' => '', 'Quantity' => '']
        ],
        'included' => [
            'Insurance' => ['Code' => '', 'Name' => '', 'Quantity' => ''],
            'Extra' => ['Code' => '', 'Name' => '', 'Quantity' => '']
        ],
    ];
    return $input;
}
