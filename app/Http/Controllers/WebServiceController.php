<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;


class WebServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function get_web_service()
    {
        // $url = "http://ws.cdyne.com/ip2geo/ip2geo.asmx?wsdl";
        $url = "https://sistematransitolocal.ant.gob.ec:6131/ANTPersonaVehiculoWS/ANTPersonaVehiculoWS";
        try {
            $client = new SoapClient($url, ["trace" => 1]);
            $result = $client->ResolveIP(["ipAddress" => $argv[1], "licenseKey" => "0"]);
            print_r($result);
        } catch (SoapFault $e) {
            echo $e->getMessage();
        }
        echo PHP_EOL;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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