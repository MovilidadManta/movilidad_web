<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function GET_icons()
    {
        $iconos = DB::connection('pgsql')->select("select * from tbl_intra_iconos");
        return $iconos;
    }
    public function index()
    {
        $cl = new HomeController();
        $iconos = $this->GET_icons();
        $menus_ = $cl->GET_menus_asign();
        $t_empleados = DB::connection('pgsql')->select("select * from view_total_empleados");
        $t_usuarios = DB::connection('pgsql')->select("select * from view_total_usuarios");

        return view('Administrador.Menu.menu', compact('menus_', 'iconos'));
    }

    public function get_menu()
    {
        $sql = DB::connection('pgsql')->Select('select public.cursor_listar_menus()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_menus;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_menu_id($id)
    {
        $sql = DB::connection('pgsql')->Select('select public.cursor_listar_cbm_menus_id(?)', [$id]);
        //return $sql;
        foreach ($sql as $r) {
            $data = $r->cursor_listar_cbm_menus_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_menu(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id_proyecto' => $request->input('select-proyecto'),
            'menu' => $request->input('txt-menu'),
            'id_estado' => $request->input('select-estado'),
            'icono' => $request->input('select-icono')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->Select('select public.procedimiento_registrar_datos_menu(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_menu;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_menu_id_($id)
    {
        $sql = DB::connection('pgsql')->Select('select public.cursor_listar_menus_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_menus_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_menu(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id_menu' => $request->input('txt-id-menu-m'),
            'id_proyecto' => $request->input('select-proyecto-m'),
            'menu' => $request->input('txt-menu-m'),
            'id_estado' => $request->input('select-estado-m')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->Select('select public.procedimiento_modificar_datos_menu(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_menu;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_menu_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_menu' => $request->input('txt-id-menu-e')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->Select('select public.procedimiento_eliminar_datos_menu(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_menu;
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
