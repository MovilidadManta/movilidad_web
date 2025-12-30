<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use  Session;


class ProyectosController extends Controller
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
        return view('Administrador.Proyectos.index', compact('menus_'));
    }

    public function get_project()
    {
        $sql = DB::Select('select public.cursor_listar_proyectos()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_proyectos;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
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
        $date = Carbon::now();
        $date = $date->format('Y-m-d');
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'pro_nombre' => $request->project,
            'pro_estado' => 1
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_datos_proyectos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_proyectos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
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
    public function update(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id_proyecto' => $request->ip_id_proyecto_edit,
            'proyecto' => $request->ip_proyecto_edit,
            'estado' => $request->estado_edit
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_modificar_datos_proyecto_id(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_proyecto_id;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => true, "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => false]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id_proyecto' => $request->id_proyecto,
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_eliminar_datos_proyecto(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_datos_proyecto;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => true, "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => false]);
        }
    }
}