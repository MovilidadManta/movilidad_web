<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Carbon;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        date_default_timezone_set('America/Guayaquil');
        $codigo = date('dmYhsm');
        //return $codigo;
        $t_empleados = DB::connection('pgsql')->select("select * from view_total_empleados");
        $t_usuarios = DB::connection('pgsql')->select("select * from view_total_usuarios");
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();


        return view('Administrador.Inventario.inventario', compact('t_empleados', 't_usuarios', 'menus_'));
    }

    public function get_empleados_id($id_empleado)
    {
        $sql = DB::Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);
        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id;
        }
        $json_data = json_decode($data);

        $sql_2 = DB::Select('select public.cursor_listar_empleados_catalogo_id(?)', [$id_empleado]);
        foreach ($sql_2 as $r2) {
            $data_2 = $r2->cursor_listar_empleados_catalogo_id;
        }
        $json_data_2 = json_decode($data_2);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'data_2' => $json_data_2, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_catalogo_inventario(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $year = date('Y');

        $json[] = [
            'id_catalogo' => $request->input('txt-id-catalogo'),
            'id_empleado' => $request->input('txt-id-empleado')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_datos_catalogo_inventario(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_catalogo_inventario;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_catalogo_inventario_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-catalogo-inventario-e')
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::Select('select public.procedimiento_eliminar_datos_catalogo_inventarios(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_catalogo_inventarios;
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