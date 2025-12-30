<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Session;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Codedge\Fpdf\Fpdf\Fpdf;
use Mpdf\Mpdf;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class ConsolidadoController extends Controller
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
        return view('Administrador.Consolidado.consolidado', compact('menus_'));
    }

    public function get_indicadores()
    {
        $sql = DB::Select('select public.cursor_listar_indicadores()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_indicadores;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_indicadores_id($id)
    {
        $sql = DB::Select('select public.cursor_listar_indicador_id_jefatura(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_indicador_id_jefatura;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_tipos_indicadores_id($id)
    {
        $sql = DB::Select('select public.cursor_listar_tipo_indicador_id_indicador(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_tipo_indicador_id_indicador;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_indicador(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $fecha_salida = "1000-01-01";
        $año = date('Y');
        $mes = date('m');
        $dia = date('d');

        $data = $request->input('txt-json-indicador');
        if ($data == "[]") {
            $data = null;
        }

        $json[] = [
            'id_direccion' => $request->input('select-direccion'),
            'id_jefatura' => $request->input('select-jefatura-subdireccion'),
            'id_indicador' => $request->input('select-indicador'),
            'year' => $año,
            'mes' => $mes,
            'dia' => $dia
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::Select('select public.procedimiento_registrar_datos_indicadores(?,?,?,?)', [$jsoninsert, $data, $ip, $user]);
        //$sql_2 = DB::Select('select public.procedimiento_registrar_datos_empleado_prioritarios(?,?,?)', [$data, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_indicadores;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_indicadores_modificar_id($id)
    {
        $sql = DB::Select('select public.cursor_listar_indicador_modificar_id(?)', [$id]);
        foreach ($sql as $r) {
            $data = $r->cursor_listar_indicador_modificar_id;
        }
        $json_data = json_decode($data);

        $sql_detalle = DB::Select('select public.cursor_listar_indicador_detalle_modificar_id(?)', [$id]);
        foreach ($sql_detalle as $r) {
            $data_detalle = $r->cursor_listar_indicador_detalle_modificar_id;
        }
        $json_data_detalle = json_decode($data_detalle);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data,'data_detalle'=>$json_data_detalle, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_indicador_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $fecha_salida = "1000-01-01";
        $año = date('Y');
        $mes = date('m');
        $dia = date('d');

        $data = $request->input('txt-json-indicador-m');
        if ($data == "[]") {
            $data = null;
        }

        $json[] = [
            'id_consolidado' => $request->input('txt-id-indicador-m'),
            'id_direccion' => $request->input('select-direccion-m'),
            'id_jefatura' => $request->input('select-jefatura-subdireccion-m'),
            'id_indicador' => $request->input('select-indicador-m'),
            'year' => $año,
            'mes' => $mes,
            'dia' => $dia
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::Select('select public.procedimiento_modificar_datos_indicadores(?,?,?,?)', [$jsoninsert, $data, $ip, $user]);
        //$sql_2 = DB::Select('select public.procedimiento_modificar_datos_empleado_prioritarios(?,?,?)', [$data, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_indicadores;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_indicador_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_indicador' => $request->input('txt-id-indicador')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_eliminar_datos_indicador(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_indicador;
        }
        
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
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
