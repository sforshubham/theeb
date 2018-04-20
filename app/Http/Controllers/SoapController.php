<?php

namespace App\Http\Controllers;

use Config;

use Illuminate\Http\Request;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Artisaninweb\SoapWrapper\Client;

class SoapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $soapWrapper;

    public function __construct(SoapWrapper $soapWrapper)
    {
        //ini_set('default_socket_timeout', 600);
        $this->soapWrapper = $soapWrapper;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllBranches()
    {
        $status_code = 200;
        $response = array();

        try {
            $this->soapWrapper->add('Dummy', function ($service) {
              $service
                ->wsdl(__DIR__.'/../../../resources/wsdl/BranchMaster.wsdl')
                ->trace(true);
            });

            $result = $this->soapWrapper->call('Dummy.BranchMasterWebService');
            $response['status'] = true;
            $response['message'] = '';
            $response['result'] = $result;
        } catch (Exception $e) {
            $status_code = 500;
            $response['status'] = false;
            $response['message'] = 'Server Error';
            $response['result'] = NULL;
        }
        finally {
            return response()->json($response, $status_code);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doLogin(Request $request)
    {
        $status_code = 200;
        $response = array();

        $username = $request->input('username');
        $password = $request->input('password');

        try {
            $this->soapWrapper->add('Dummy', function ($service) {
              $service
                ->wsdl(__DIR__.'/../../../resources/wsdl/LogInWS.wsdl')
                ->trace(true);
            });

            $result = $this->soapWrapper->call('Dummy.LogInWS', ['UserName' => $username, 'Password' => $password]);
            $response['status'] = true;
            $response['message'] = '';
            $response['result'] = $result;
        } catch (Exception $e) {
            $status_code = 500;
            $response['status'] = false;
            $response['message'] = 'Server Error';
            $response['result'] = NULL;
        }
        finally {
            return response()->json($response, $status_code);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
