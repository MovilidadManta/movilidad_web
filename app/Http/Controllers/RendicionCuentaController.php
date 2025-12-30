<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RendicionCuentaController extends Controller
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
        return view('Administrador.Rendicion_cuenta.rendicion_cuenta', compact('menus_'));
    }

    public function index_registrar($id, $year)
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Rendicion_cuenta.registrar_rendicion_cuenta', compact('id', 'year', 'menus_'));
    }

    public function index_pagina()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_rendicion_cuenta()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_rendicion_cuenta;
        }
        $json_data_year = json_decode($data);

        return view('Pagina_web.Rendicion_Cuenta.pagina_rendicion_cuenta', compact('json_data_year'));
    }

    public function get_rendicion_cuenta()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_rendicion_cuenta()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_rendicion_cuenta;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_rendicion_cuenta(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'year' => $request->input('txt-year')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_rendicion_cuenta(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_rendicion_cuenta;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_rendicion_cuenta_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_rendicion_cuenta' => $request->input('txt-id-rendicion-cuenta')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_rendicion_cuenta(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_rendicion_cuenta;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_rendicion_cuenta_id($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_rendicion_cuenta_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_rendicion_cuenta_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_rendicion_cuenta(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('txt-id-rendicion-cuenta-m'),
            'year' => $request->input('txt-year-m')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_rendicion_cuenta(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_rendicion_cuenta;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_literal_rendicion_cuenta()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_literal_rendicion_cuenta()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_literal_rendicion_cuenta;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_literal_rendicion_cuenta_id($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_literal_rendicion_cuenta_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_literal_rendicion_cuenta_id;
        }
        $json_data = json_decode($data, true);

        if ($json_data != "") {
            //FASES UNICOS
            $array_m = [];
            for ($i = 0; $i < count($json_data); $i++) {
                array_push($array_m, $json_data[$i]['rcd_id_fase']);
            }
            $array_meses = array_keys(array_count_values($array_m));
            return response()->json(['data' => $json_data, 'data_meses' => $array_meses, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_literal_rendicion_cuenta(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $date = Carbon::now();
        $date = $date->format('Ymd') . $date->format('His');

        $archivo = $request->file('txt-ruta-archivo');

        if ($archivo != "") {
            $extension = $archivo->getClientOriginalExtension();
            $nombrearchivo = $request->input('select-literal-rendicion-cuenta') . '_' . $request->input('select-fase') . '_' . $date . $archivo->getClientOriginalName() . '.' . $archivo->getClientOriginalExtension();
            $nuevaruta = public_path('/archivos_rendicion_cuenta/' . $nombrearchivo);
            if (copy($archivo->getRealPath(), $nuevaruta)) {
                $json[] = [
                    'id_rendicion_cuenta' => $request->input('txt-id-rendicion-cuenta'),
                    'id_literal_rendicion_cuenta' => $request->input('txt-id-literal-rendicion-cuenta'),
                    'id_fase' => $request->input('select-fase'),
                    'ruta_archivo' => $nombrearchivo,
                    'id_select_literal_rendicion_cuenta' => $request->input('select-literal-rendicion-cuenta'),
                    'extension_archivo' => $extension
                ];
                $jsoninsert = json_encode($json);
                $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_literal_rendicion_cuenta(?,?,?)', [$jsoninsert, $ip, $user]);
                foreach ($sql as $s) {
                    $id = $s->procedimiento_registrar_datos_literal_rendicion_cuenta;
                }
                if ($sql != "[]") {
                    return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
                } else {
                    return response()->json(["respuesta" => "false"]);
                }
            }
        } else {
            $json[] = [
                'id_rendicion_cuenta' => $request->input('txt-id-rendicion-cuenta'),
                'id_literal_rendicion_cuenta' => $request->input('txt-id-literal-rendicion-cuenta'),
                'id_fase' => $request->input('select-fase'),
                'id_select_literal_rendicion_cuenta' => $request->input('select-literal-rendicion-cuenta'),
                'ruta_archivo' => null
            ];
            $jsoninsert = json_encode($json);

            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_literal_rendicion_cuenta(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_literal_rendicion_cuenta;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function get_literales_modificar_id_literal_rendicion_cuenta($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_literales_modificar_id_literales_rendicion_cuenta(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_literales_modificar_id_literales_rendicion_cuenta;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }


    public function delete_literal_rendicion_cuenta_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_literal_rendicion_cuenta' => $request->input('txt-id-literal-rendicion-cuenta-e')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_literal_rendicion_cuenta(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_literal_rendicion_cuenta;
        }

        if ($sql != "[]") {
            return response()->json(['respuesta' => true, "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => false]);
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
