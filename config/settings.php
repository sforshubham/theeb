<?php
return [
    'wsdl' => [
        'login' => resource_path().'/wsdl/Login/LogInWS.wsdl',
        'branches' => resource_path().'/wsdl/Branch&Schedule/BranchMaster.wsdl',
        'vehicle_type' => resource_path().'/wsdl/VehicleTypes/VehicleTypeWS.wsdl',
        'car_model' => resource_path().'/wsdl/VehicleTypes/CarGroupMaster.wsdl',
        'driver_profile' => resource_path().'/wsdl/DriverProfile/DriverProfileRequest.wsdl',
    ],
    'resp_msg' => [
        'invalid_input' => 'Please provide valid {tag}',
        'incorrect_input' => 'Incorrect {tag} entered',
        'auth_error' => 'Authentication Error',
        '500' => 'Server Error',

        'logout' => 'Logged out successfully'
    ]
];