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

function createModifyDriverRules($operation = '')
{
    $rules = [];
    switch ($operation) {
        case 'V':
            $rules = [
                'IdNo' => 'required'
            ];
            break;
        case 'C':
            $rules = [
                'IdType' => 'required|in:iqama,saudi id,passport',
                'IdNo' => 'required',
                'IdDoc' => 'required|file',
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
        case '':
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

