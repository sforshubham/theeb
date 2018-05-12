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
        'password' => resource_path().'/wsdl/DriverPasswordReset/DriverPasswordReset.wsdl',
        'payment' => resource_path().'/wsdl/Payment/PaymentCreateRequest.wsdl',
        'doc_print' => resource_path().'/wsdl/DocumentPrint/RentProPrint.wsdl',
        'transaction' => resource_path().'/wsdl/Transaction/TransactionData.WSDL',
        'booking' => resource_path().'/wsdl/MyBooking/ReservationsBookingRequest.wsdl',
        'car_group' => resource_path().'/wsdl/VehicleTypes/CarGroupMaster.wsdl',
        'car_model' => resource_path().'/wsdl/VehicleTypes/CarModelWS.wsdl',
        'reservation' => resource_path().'/wsdl/Reservation/CarProReservationWS.wsdl',
    ],
    'resp_msg' => [
        'invalid_input' => 'Please provide valid {tag}',
        'incorrect_input' => 'Incorrect {tag} entered',
        'auth_error' => 'Authentication Error',
        '500' => 'Server Error',
        'payment_fail' => 'Payment Failed',
        'processing_error' => 'Error processing request',
        'no_data' => 'No data found',

        'logout' => 'Logged out successfully',
        'new_password' => 'Email with new password has been sent to given email address',
        'reset_password' => 'Password reset has been successful',
        'payment_success' => 'Payment is successful'
    ],
    'cmd_operation' => [
        'view_driver' => 'V',
        'create_driver' => 'N',
        'modify_driver' => 'E'
    ],
    'trans_operation' => [
        'agreement' => 'A',
        'invoice' => 'I',
        'payment' => 'P',
        'reservation' => 'R',
    ],
    'reservation_operation' => [
        'new_reservation' => 'N',
        'modify_reservation' => 'A',
        'cancel_reservation' => 'C'
    ],
    'branches_db_fields' => ['BranchCode' => '', 'BranchName' => '', 'DistArea' => '', 'DistAreaName' => '', 'OpArea' => '', 'OpAreaName' => '', 'Country' => '', 'CountryName' => '', 'BranchLat' => 'DMStoDD', 'BranchLong' => 'DMStoDD', 'City' => '', 'State' => '', 'Telephone' => '', 'Telephone1' => '', 'Fax' => '', 'Telex' => '', 'Email' => '', 'Schedule' => 'json_encode'],

    'vehicles_db_fields' => ['VTHCode' => '', 'VTHDesc' => '', 'VTHType' => '', 'Group' => '', 'VehTypeDesc' => '', 'ImageUrl' => ''],

    'defaults' => [
        'car_img' => '/../public/images/no-car-image-large.png',
        'car_desc' => 'Default text',
    ]
];