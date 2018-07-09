<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayfortController extends Controller
{

    public function transaction(Request $request)
    {
        $request->all();
        $filename = storage_path('app/payfort_trans.txt');
        file_put_contents($filename, $request->all(), FILE_APPEND);
        file_put_contents($filename, json($request->all()), FILE_APPEND);
    }

    public function notification(Request $request)
    {
        $request->all();
        $filename = storage_path('app/payfort_notify.txt');
        file_put_contents($filename, $request->all(), FILE_APPEND);
        file_put_contents($filename, json($request->all()), FILE_APPEND);
    }
}
