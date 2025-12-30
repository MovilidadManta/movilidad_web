<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class NosotroController extends Controller
{
    public function index()
    {
        $t_empleados = DB::connection('pgsql')->select("select * from view_total_empleados");
        $t_usuarios = DB::connection('pgsql')->select("select * from view_total_usuarios");

        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Nosotro.nosotro', compact('t_empleados', 't_usuarios', 'menus_'));
    }

    public function index_pagina()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_nosotros()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_nosotros;
        }
        $json_data = json_decode($data);

        return view('Pagina_web.Nosotro.pagina_nosotro', compact('json_data'));
    }

    public function index_pagina_quienes_somos()
    {
        return view('Pagina_web.Nosotro.pagina_quienes_somos');
    }

    public function get_nosotros()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_nosotros()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_nosotros;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_nosotros(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'mision' => $request->input('txt-mision'),
            'vision' => $request->input('txt-vision')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_nosotro(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_nosotro;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_nosotro_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_nosotro' => $request->input('txt-id-nosotro')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_nosotros(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_nosotros;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_nosotros_id($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_nosotros_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_nosotros_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_nosotros(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('txt-id-modificar-nosotro'),
            'mision' => $request->input('txt-m-mision'),
            'vision' => $request->input('txt-m-vision')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_nosotro(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_nosotro;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

}