<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use Session;

class SubmenuController extends Controller
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
        return view('Administrador.Submenus.index', compact('menus_'));
    }

    public function get_submenu()
    {
        $sql = DB::Select('select public.cursor_listar_submenus()');
        foreach ($sql as $r) {
            $data = $r->cursor_listar_submenus;
        }
        $json_data = json_decode($data);
        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_submenu_id($id_menu)
    {
        $sql = DB::Select('select public.cursor_listar_cbm_submenus_id(?)', [$id_menu]);
        foreach ($sql as $r) {
            $data = $r->cursor_listar_cbm_submenus_id;
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
            'sme_id_menu' => $request->id_menu,
            'sme_submenu' => $request->submenu,
            'sme_link' => $request->link,
            'sme_tipo_link' => $request->tipo
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_datos_submenus(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_submenus;
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
        $date = Carbon::now();
        $date = $date->format('Y-m-d');
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->id,
            'sme_id_menu' => $request->id_menu,
            'sme_submenu' => $request->submenu,
            'sme_link' => $request->link,
            'sme_tipo_link' => $request->tipo,
            'estado' => $request->estado
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_modificar_datos_submenus(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_submenus;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
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
            'id_submenu' => $request->id_submenu,
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_eliminar_datos_submenu(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_datos_submenu;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => true, "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => false]);
        }
    }
}