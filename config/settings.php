<?php
return [
    'wsdl' => [
        'login' => resource_path().'/wsdl/Login/LogInWS.wsdl',
        'branches' => resource_path().'/wsdl/Branch&Schedule/BranchMaster.wsdl',
        //'vehicle_type' => resource_path().'/wsdl/VehicleTypes/VehicleTypeWS.wsdl',
        'car_model' => resource_path().'/wsdl/VehicleTypes/CarGroupMaster.wsdl',
        'driver_profile' => resource_path().'/wsdl/DriverProfile/DriverProfileRequest.wsdl',
        'price_estimation' => resource_path().'/wsdl/PriceEstimation/PriceEstimationWS.wsdl',
        'driver_modify' => resource_path().'/wsdl/DriverCreateModify/DriverCreateWS.wsdl',
        'password' => resource_path().'/wsdl/DriverPasswordReset/DriverPasswordReset.wsdl',
        'payment' => resource_path().'/wsdl/Payment/PaymentCreateRequest.wsdl',
        'doc_print' => resource_path().'/wsdl/DocumentPrint/RentProPrint.wsdl',
        'transaction' => resource_path().'/wsdl/Transaction/TransactionData.WSDL',
        'booking' => resource_path().'/wsdl/MyBooking/ReservationsBookingRequest.wsdl',
        //'car_group' => resource_path().'/wsdl/VehicleTypes/CarGroupMaster.wsdl',
        'car_model' => resource_path().'/wsdl/VehicleTypes/CarModelWS.wsdl',
        'reservation' => resource_path().'/wsdl/Reservation/CarProReservationWS.wsdl',
        'extend_booking' => resource_path().'/wsdl/ExtendBooking/ReservationModify.wsdl',
    ],
    'resp_msg' => [
        'invalid_input' => 'Please provide valid {tag}',
        'incorrect_input' => 'Incorrect {tag} entered',
        'auth_error' => 'Authentication Error',
        '500' => 'Server Error',
        'payment_fail' => 'Payment Failed',
        'processing_error' => 'Error processing request',
        'no_data' => 'No data found',
        'no_cars' => 'No cars available for given details',
        'no_document' => 'Document not available',
        'branch_unavailable' => 'This {tag} is not available on selected date and time',

        'logout' => 'Logged out successfully',
        'new_password' => 'Email with new password has been sent to given email address',
        'reset_password' => 'Password changed successfully. Please login with new password',
        'incorrect_password' => 'Incorrect password entered',
        'payment_success' => 'Payment is successful',
        'cancel_reservation' => 'Booking has been cancelled successfully',
        'new_reservation' => 'Reservation created successfully',
        'extend_reservation' => 'Booking details updated successfully',
    ],
    'cmd_operation' => [
        'view_driver' => 'V',
        'create_driver' => 'N',
        'signup' => 'N',
        'modify_driver' => 'E'
    ],
    'trans_master' => [
        'agreement' => [
            'operation' => 'A',
            'view' => 'agreement',
            'labels' => [
                'CheckOutBranch' => 'Check Out Branch',
                'CheckInBranch' => 'Check In Branch',
                'CheckOutDate' => 'Check Out Date',
                'CheckInDate' => 'Check In Date',
                'ReservationNo' => 'Reservation No',
                'StatusCode' => 'Status Code',
                'AgreementNo' => 'Agreement No',
                'ChrageGroup' => 'Chrage Group',
                'LicenseNo' => 'License No',
                'TOTALAMOUNT' => 'Total Amount',
                'TOTALPAID' => 'Total Paid',
                'TOTALBALANCE' => 'Total Balance',
                'CheckOutBranchContact' => 'Check Out Branch Contact',
                'CheckInBranchContact' => 'Check In Branch Contact',
                'DriverId' => 'Driver Id',
                'DriverName' => 'Driver Name',
                'DriverLicenseNo' => 'Driver License No',
                'DriverLicenseExpiryDate' => 'Driver License Expiry Date',
                'DriverNationality' => 'Driver Nationality',
                'DriverMembershipNo' => 'Driver Membership No',
                'DriverMembershipType' => 'Driver Membership Type',
                'DriverContactNo' => 'Driver Contact No',
                'DebitorCode' => 'Debitor Code',
                'DebitorName' => 'Debitor Name',
                'AgreementUser' => 'Agreement User',
                'AgreementDays' => 'Agreement Days',
                'AgreementPackage' => 'Agreement Package',
                'AgreementPackagePrice' => 'Agreement Package Price',
                'AgreementCheckOutTime' => 'Agreement Check Out Time',
                'AgreementChargeGroup' => 'Agreement Charge Group',
                'AgreementOutKm' => 'Agreement Out Km',
                'AgreementModelName' => 'Agreement Model Name',
                'AgreementTotalRental' => 'Agreement Total Rental',
                'AgreementDiscount' => 'Agreement Discount',
                'AgreementFreeKm' => 'Agreement Free Km',
                'AgreementFreeHr' => 'Agreement Free Hr',
                'AgreementExtraKmCharge' => 'Agreement Extra Km Charge',
                'AgreementExtraHourCharge' => 'Agreement Extra Hour Charge',
                'AgreementExtras' => 'Agreement Extras',
                'AgreementInsurance' => 'Agreement Insurance',
            ],
        ],
        'invoice' => [
            'operation' => 'I',
            'view' => 'invoice',
            'labels' => [
                'InvoiceNo' => 'Invoice No',
                'InvoiceType' => 'Invoice Type',
                'AgreementNo' => 'Agreement No',
                'InvoiceDate' => 'Invoice Date',
                'InvoiceRental' => 'Invoice Rental',
                'InvoiceOther' => 'Invoice Other',
                'InvoiceTotal' => 'Invoice Total',
                'InvoiceTime' => 'Invoice Time',
                'InvoiceBranchName' => 'Invoice Branch Name',
                'InvoiceAgrOutDate' => 'Invoice Agr Out Date',
                'InvoiceAgrOutTime' => 'Invoice Agr Out Time',
                'InvoiceAgrInDate' => 'Invoice Agr In Date',
                'InvoiceAgrInTime' => 'Invoice Agr In Time',
                'InvoiceAgrOutBranch' => 'Invoice Agr Out Branch',
                'InvoiceAgrInBranch' => 'Invoice Agr In Branch',
                'InvoiceAgrOutKm' => 'Invoice Agr Out Km',
                'InvoiceAgrInKm' => 'Invoice Agr In Km',
                'InvoiceAgrChargeGroup' => 'Invoice Agr Charge Group',
                'InvoiceAgrCarModel' => 'Invoice Agr Car Model',
                'InvoiceAgrVehicleNo' => 'Invoice Agr Vehicle No',
                'DriverBillingName' => 'Driver Billing Name',
                'DriverDOB' => 'Driver DOB',
                'DriverMembershipNo' => 'Driver Membership No',
                'DriverPassportNo' => 'Driver Passport No',
                'DriverNationality' => 'Driver Nationality',
                'DriverLicenseNo' => 'Driver License No',
                'DriverLicenseExpiryDate' => 'Driver License Expiry Date',
                'DriverAddress' => 'Driver Address',
                'DriverCity' => 'Driver City',
                'DriverContactNo' => 'Driver Contact No',
                'AgreementTariff' => 'Agreement Tariff',
                'AgreementRateNo' => 'Agreement Rate No',
                'AgreementCurrency' => 'Agreement Currency',
                'SoldDays' => 'Sold Days',
                'AgreementFreeKm' => 'Agreement Free Km',
                'AgreementChargableKm' => 'Agreement Chargable Km',
                'AgreementDiscountPercent' => 'Agreement Discount Percent',
                'InvoiceDiscountAmount' => 'Invoice Discount Amount',
                'InvoiceOtherAmount' => 'Invoice Other Amount',
                'InvoiceDropOff' => 'Invoice Drop Off',
                'InvoiceAmountPaid' => 'Invoice Amount Paid',
                'InvoiceBalance' => 'Invoice Balance',
                'InvoiceReservation' => 'Invoice Reservation',
            ],
        ],
        'payment' => [
            'operation' => 'P',
            'view' => 'payment',
            'labels' => [
                'ReceiptNo' => 'Receipt No',
                'PaymentMethod' => 'Payment Method',
                'InvoiceNo' => 'Invoice No',
                'ReceiptDate' => 'Receipt Date',
                'ReceiptAmount' => 'Receipt Amount',
                'AgreementNo' => 'Agreement No',
                'BranchCode' => 'Branch Code',
                'BranchName' => 'Branch Name',
                'CustomerName' => 'Customer Name',
                'CustomerAddress' => 'Customer Address',
                'PaymentMode' => 'Payment Mode',
                'PaymentUser' => 'Payment User',
            ],
        ],
        'reservation' => [
            'operation' => 'R',
            'view' => 'reservation',
            'labels' => [
                'ReservationNo' => 'Reservation No',
                'CheckOutBranch' => 'Check Out Branch',
                'CheckInBranch' => 'Check In Branch',
                'CheckOutDateTime' => 'Check Out Date Time',
                'CheckInDateTime' => 'Check In Date Time',
                'Status' => 'Status',
            ],
        ],
    ],
    'reservation_operation' => [
        'new_reservation' => 'N',
        'modify_reservation' => 'A',
        'cancel_reservation' => 'C'
    ],
    'branches_db_fields' => ['BranchCode' => '', 'BranchName' => '', 'DistArea' => '', 'DistAreaName' => '', 'OpArea' => '', 'OpAreaName' => '', 'Country' => '', 'CountryName' => '', 'BranchLat' => 'DMStoDD', 'BranchLong' => 'DMStoDD', 'City' => '', 'State' => '', 'Telephone' => '', 'Telephone1' => '', 'Fax' => '', 'Telex' => '', 'Email' => '', 'Schedule' => 'json_encode', 'ArabicBranchName' => '', 'OperationAreaName' => ''],

    'vehicles_db_fields' => ['VTHCode' => '', 'VTHDesc' => '', 'VTHType' => '', 'Group' => '', 'VehTypeDesc' => '', 'ImageUrl' => '', 'VTHDescription' => ''],

    'reservation' => [
        'init_no' => rand(110000000, 119000000),
        'file_path' => storage_path('app/res_no.txt'),
    ]

];
