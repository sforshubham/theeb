<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionFeedback;
use App\Models\TransactionNotification;

class PayfortController extends Controller
{

    public function transaction(Request $request)
    {
        TransactionFeedback::insertIntoDB($request->all());
    }

    public function notification(Request $request)
    {
        TransactionNotification::insertIntoDB($request->all());
    }
}
