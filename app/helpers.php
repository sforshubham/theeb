<?php

function pr($param)
{
    echo '<pre>';
    print_r($param);
    echo '</pre>';
}

function object_to_array($obj, $allowed_keys = [])
{
    if (is_object($obj)) {
    	$obj = (array) $obj;
    }
    if (is_array($obj)) {
        foreach ($obj as $key => $val) {
            if (is_int($key)) {
                $obj[$key] = object_to_array($val, $allowed_keys);
            } elseif (isset($allowed_keys[$key])) {
                if ($allowed_keys[$key] != '') {
                    $val = $allowed_keys[$key]($val);
                }
                $obj[$key] = object_to_array($val, $allowed_keys);
            } else {
                unset($obj[$key]);
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
        case 'V': //view driver
            $rules = [
                'IdNo' => 'required'
            ];
            break;
        case 'N':// create new driver
            $rules = [
                'IdType' => 'required|in:iqama,saudi id,passport',
                'IdNo' => 'required',
                'IdDoc' => 'image',
                'LastName' => 'required',
                'FirstName' => 'required',
                'DateOfBirth' => 'date_format:d/m/Y|before_or_equal:today',
                'Nationality' => 'required',
                'LicenseId' => 'required',
                'LicenseExpiryDate' => 'required|date_format:d/m/Y',
                'LicenseDoc' => 'image',
                'WorkTel' => 'numeric',
                'Mobile' => 'required|numeric|regex:/(05)[0-9]{8}/',
                'Email' => 'required|email',
                'WorkIdDoc' => 'image',
                'DriverImage' => 'image'
            ];
            break;
        case 'E': // update driver
            $rules = [
                'IdType' => 'in:iqama,saudi id,passport',
                'IdNo' => 'required',
                'IdDoc' => 'image',
                'LastName' => 'required',
                'FirstName' => 'required',
                'DateOfBirth' => 'date_format:d/m/Y|before_or_equal:today',
                'Nationality' => 'required',
                'LicenseId' => 'required',
                'LicenseExpiryDate' => 'required|date_format:d/m/Y',
                'LicenseDoc' => 'image',
                'WorkTel' => 'numeric',
                'Mobile' => 'required|numeric|regex:/(05)[0-9]{8}/',
                'Email' => 'required|email',
                'WorkIdDoc' => 'image',
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
    $input = [ //reservation
        'DriverCode' => '',
        'LicenseNo' => '',
        'LastName' => '',
        'FirstName' => '',
        'CDP' => '',
        'OutBranch' => '',
        'InBranch' => '',
        'OutDate' => '',
        'OutTime' => '',
        'InDate' => '',
        'InTime' => '',
        'RateNo' => '',
        'RentalSum' => '',
        'DepositAmount' => '',
        'ReservationNo' => '',
        'ReservationStatus' => '',
        'CarGroup' => '',
        'Currency' => '',
        'PaymentType' => '',
        'CreditCardNo' => '',
        'CarMake' => '',
        'CarModel' => '',
        'Remarks' => '',
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

function DMStoDD($input ='')
{
    $deg = '';
    $min = '';
    $sec = '';
    $inputM = '';
    $input = trim($input);
    if ($input == '') {
        return '0';
    }
    for ($i=0; $i < strlen($input); $i++)
    {
        $tempD = $input[$i];
        if ($tempD == iconv("UTF-8", "ISO-8859-1//TRANSLIT", '°'))
        {
            $newI = $i + 1;
            $inputM =  substr($input, $newI, -1);
            break;
        }
        $deg .= $tempD;
    }
    for ($j=0; $j < strlen($inputM); $j++)
    {
        $tempM = $inputM[$j];
        if ($tempM == "'")
        {
            $newI = $j + 1;
            $sec =  substr($inputM, $newI, -1);
            break;
        }
        $min .= $tempM;
    }
    $result =  floatval($deg)+(((floatval($min)*60)+floatval($sec)) / 3600);
    return $result;
}

function reservationRules($operation = '')
{
    $rules = [];
    switch ($operation) {
        case 'C': //cancel reservation
            $rules = [
                'ReservationNo' => 'required'
            ];
            break;
        case 'N'://new reservation
            $rules = [
                'DriverCode' => 'required',
                'OutBranch' => 'required',
                'InBranch' => 'required',
                'OutDate' => 'required|date_format:d/m/Y|after_or_equal:today',
                'OutTime' => 'required',
                'InDate' => 'date_format:d/m/Y|after_or_equal:OutDate',
                'InTime' => 'required',
                'RateNo' => 'required',
                'ReservationNo' => 'required',
                'CarGroup' => 'required',
            ];
            break;
        case 'A'://extend reservation
            $rules = [
                'DriverCode' => 'required',
                'OutBranch' => 'required',
                'InBranch' => 'required',
                'OutDate' => 'required|date_format:d/m/Y|after_or_equal:today',
                'OutTime' => 'required',
                'InDate' => 'date_format:d/m/Y|after_or_equal:OutDate',
                'InTime' => 'required',
                'RateNo' => 'required',
                'ReservationNo' => 'required',
                'CarGroup' => 'required',
            ];
            break;
    }
    return $rules;
}
