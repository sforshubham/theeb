<?php
return [
    'wsdl' => [
        'login' => resource_path().'/wsdl/Login/LogInWS.wsdl',
        'branches' => resource_path().'/wsdl/Branch&Schedule/BranchMaster.wsdl',
        'vehicle_type' => resource_path().'/wsdl/VehicleTypes/VehicleTypeWS.wsdl',
        'car_model' => resource_path().'/wsdl/VehicleTypes/CarGroupMaster.wsdl',
        'driver_profile' => resource_path().'/wsdl/DriverProfile/DriverProfileRequest.wsdl',
        'price_estimation' => resource_path().'/wsdl/PriceEstimation/PriceEstimationWS.wsdl',
        'driver_modify' => resource_path().'/wsdl/DriverCreateModify/DriverCreateWS.wsdl',
    ],
    'resp_msg' => [
        'invalid_input' => 'Please provide valid {tag}',
        'incorrect_input' => 'Incorrect {tag} entered',
        'auth_error' => 'Authentication Error',
        '500' => 'Server Error',

        'logout' => 'Logged out successfully'
    ],
    'operation' => [
        'view_driver' => 'V',
        'create_driver' => 'C',
        'modify_driver' => ''
    ],
];