<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class CargosController extends Controller
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
        return view('Administrador.Cargos.cargo', compact('menus_'));
    }

    public function get_cargo()
    {
        $sql = DB::connection('pgsql')->select("select * from view_cargos");
        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_cargo(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_direccion' => $request->input('select-direccion'),
            'id_jefatura' => $request->input('select-jefatura-subdireccion'),
            'id_cargo_superior' => $request->input('select-cargo-superior'),
            'cargo' => strtoupper($request->input('txt-cargo')),
            'estado' => $request->input('select-estado')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->Select('select public.procedimiento_registrar_datos_cargos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_cargos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_cargo_id($id_cargo)
    {
        $sql = DB::connection('pgsql')->select("select * from view_cargos where ca_id = " . $id_cargo . "");

        if ($sql != "[]") {
            return response()->json(['data' => $sql, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_cargo(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id'),
            'id_direccion' => $request->input('select-direccion-m'),
            'id_jefatura' => $request->input('select-jefatura-subdireccion-m'),
            'id_cargo_superior' => $request->input('select-cargo-superior-m'),
            'cargo' => strtoupper($request->input('txt-cargo-m')),
            'estado' => $request->input('select-estado-m')
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::connection('pgsql')->Select('select public.procedimiento_modificar_datos_cargos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_cargos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_cargo_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-cargo')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->Select('select public.procedimiento_eliminar_datos_cargos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_cargos;
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