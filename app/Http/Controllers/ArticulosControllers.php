<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Mpdf\Mpdf;

use DB;

use Storage;
use  Session;
use DateTime;

class ArticulosControllers extends Controller
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

    public function get_articulos($id_permiso)
    {
        $json_data = DB::connection('pgsql')->select("select * from view_articulos where art_id_tipo_permiso = $id_permiso");
        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_articulo_tipo_permiso(request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $year = date('Y');

        $json[] = [
            'id_tipo_permiso' => $request->input('txt-id-tipo-permiso-articulo'),
            'articulo' => $request->input('txt-articulo')
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::Select('select public.procedimiento_registrar_datos_articulos_tipos_permisos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_articulos_tipos_permisos;
        }

        if ($sql != "[]") {
            return response()->json(['respuesta' => true, "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
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
    public function store(Request $request) {}

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
