<?php

namespace App\Http\Controllers;

use  Session;
use Mail;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HojaRutaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();

        return view('Administrador.Hoja_ruta.hoja_ruta', compact('menus_'));
    }

    public function get_paz_salvo_empleados_id($id_empleado)
    {
        $sql_empleado = DB::Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);
        foreach ($sql_empleado as $r) {
            $data = $r->cursor_listar_empleados_id;
        }
        $json_data = json_decode($data);

        /*$sql_jefe_inmediato = DB::Select('select public.cursor_listar_jefe_inmediato_empleados_id(?)', [$id_empleado]);
        foreach ($sql_jefe_inmediato as $r) {
            $data_1 = $r->cursor_listar_jefe_inmediato_empleados_id;
        }
        $json_data_jefe_inmediato = json_decode($data_1);

        $sql_tthh = DB::Select('select public.cursor_listar_tthh_empleados_id(?)', [$id_empleado]);
        foreach ($sql_tthh as $r) {
            $data_2 = $r->cursor_listar_tthh_empleados_id;
        }
        $json_data_tthh = json_decode($data_2);

        $sql_contabilidad = DB::Select('select public.cursor_listar_contabilidad_empleados_id(?)', [$id_empleado]);
        foreach ($sql_contabilidad as $r) {
            $data_3 = $r->cursor_listar_contabilidad_empleados_id;
        }
        $json_data_contabilidad = json_decode($data_3);

        $sql_bienes = DB::Select('select public.cursor_listar_bienes_empleados_id(?)', [$id_empleado]);
        foreach ($sql_bienes as $r) {
            $data_4 = $r->cursor_listar_bienes_empleados_id;
        }
        $json_data_bienes = json_decode($data_4);

        $sql_tics = DB::Select('select public.cursor_listar_tics_empleados_id(?)', [$id_empleado]);
        foreach ($sql_tics as $r) {
            $data_4 = $r->cursor_listar_tics_empleados_id;
        }
        $json_data_tics = json_decode($data_4);*/

        if ($json_data != "[]") {
            return response()->json([
                'data' => $json_data,
                'respuesta' => true
            ]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_paz_salvo_empleados_jefe_inmediato_id($id_empleado)
    {
        $sql_jefe_inmediato = DB::Select('select public.cursor_listar_jefe_inmediato_empleados_id(?)', [$id_empleado]);
        foreach ($sql_jefe_inmediato as $r) {
            $data_1 = $r->cursor_listar_jefe_inmediato_empleados_id;
        }
        $json_data_jefe_inmediato = json_decode($data_1);

        if ($json_data_jefe_inmediato != "[]") {
            return response()->json([
                'data' => $json_data_jefe_inmediato,
                'respuesta' => true
            ]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_paz_salvo_empleados_jefe_inmediato(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $user_logueado = session::get('usuario');
        //return $user;

        $archivo = $request->file('txt-ruta-informe-final');
        if ($archivo == '') {
            $nombrearchivo = null;
        } else {
            //$nombrearchivo   =   Str::slug("") . $request->input('txt-cedula') . '.' . $archivo->getClientOriginalExtension();
            $nombrearchivo   =   'INFORME_FINAL_' . date("Ymdsm") . '.' . $archivo->getClientOriginalExtension();
            $nuevaruta      =   public_path('/paz_salvo/archivos_informe_final/' . $nombrearchivo);
            copy($archivo->getRealPath(), $nuevaruta);
        }

        $json[] = [
            'id_empleado_jefe_inmediato' => $request->input('txt-id-empleado-jefe-inmediato'),
            'id_empleado' => $request->input('txt-id-empleado-ji'),
            'archivo_fisico' => $request->input('select-entrega-archivo-fisico'),
            'fecha_entrega' => $request->input('txt-fecha-entrega'),
            'informe_final' => $request->input('select-informe-final'),
            'ruta_informe_final' =>$nombrearchivo,
            'observacion' => $request->input('txt-observacion-ji')
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::Select('select public.procedimiento_registrar_datos_empleado_jefe_inmediato(?,?,?)', [$jsoninsert, $ip, $user]);

        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_empleado_jefe_inmediato;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true","id"=> $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function save_paz_salvo_empleados_jefe_inmediato_yyyyyyyy(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $user_logueado = session::get('usuario');
        //return $user;

        $archivo = $request->file('txt-ruta-informe-final');

        if ($archivo == "") {
            $json[] = [
                'id_empleado_jefe_inmediato' => $request->input('txt-id-empleado-jefe-inmediato'),
                'id_empleado' => $request->input('txt-id-empleado-ji'),
                'archivo_fisico' => $request->input('select-entrega-archivo-fisico'),
                'fecha_entrega' => $request->input('txt-fecha-entrega'),
                'informe_final' => $request->input('select-informe-final'),
                'ruta_informe_final' =>null,
                'observacion' => $request->input('txt-observacion-ji')
            ];
            $jsoninsert = json_encode($json);
        } elseif ($archivo  != null) {
            //$nombrearchivo   =   Str::slug("") . $request->input('txt-cedula') . '.' . $archivo->getClientOriginalExtension();
            $nombrearchivo   =   'INFORME_FINAL_' . date("Ymdsm") . '.' . $archivo->getClientOriginalExtension();
            $nuevaruta      =   public_path('/paz_salvo/archivos_informe_final/' . $nombrearchivo);
            copy($archivo->getRealPath(), $nuevaruta);
            $json[] = [
                'id_empleado_jefe_inmediato' => $request->input('txt-id-empleado-jefe-inmediato'),
                'id_empleado' => $request->input('txt-id-empleado-ji'),
                'archivo_fisico' => $request->input('select-entrega-archivo-fisico'),
                'fecha_entrega' => $request->input('txt-fecha-entrega'),
                'informe_final' => $request->input('select-informe-final'),
                'ruta_informe_final' =>$nombrearchivo,
                'observacion' => $request->input('txt-observacion-ji')
            ];
            $jsoninsert = json_encode($json);
        }

        $sql = DB::Select('select public.procedimiento_registrar_datos_empleado_jefe_inmediato(?,?,?)', [$jsoninsert, $ip, $user]);

        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_empleado_jefe_inmediato;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true","id"=> $id, "sql" => $sql]);
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
