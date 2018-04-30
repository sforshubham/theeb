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
    'operation' => [
        'view_driver' => 'V',
        'create_driver' => 'C',
        'modify_driver' => ''
    ],
    'transaction' => [
        'trans_reservation' => 'R',
        'trans_payment' => 'P',
        'trans_agreement' => 'A',
        'trans_invoice' => 'I',
    ],
];