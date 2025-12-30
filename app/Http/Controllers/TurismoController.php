<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use File;

class TurismoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $t_empleados = DB::connection('pgsql')->select("select * from view_total_empleados");
        $t_usuarios = DB::connection('pgsql')->select("select * from view_total_usuarios");
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Turismo.turismo', compact('t_empleados', 't_usuarios', 'menus_'));
    }

    public function index_pagina()
    {
        return view('Pagina_web.Turismo.turismo_pagina');
    }

    public function index_pagina_id($id)
    {
        //$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_turismos_id(?)', [$id]);
        $sql = DB::connection('pgsql_pag_web')->select("select * from view_turismos_centro_comerciales where tu_id = " . $id . " and tu_estado = 'A'");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_turismos_id;
        }
        $json_data = json_decode($data);*/
        $json_data = $sql;
        return view('Pagina_web.Turismo.turismo_pagina_id', compact('json_data'));
    }

    public function index_centro_comercial_pagina_id($id)
    {
        //$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_turismos_id(?)', [$id]);
        $sql = DB::connection('pgsql_pag_web')->select("select * from view_turismos_centro_comerciales where tu_id = " . $id . " and tu_estado = 'A'");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_turismos_id;
        }
        $json_data = json_decode($data);*/
        $json_data = $sql;
        return view('Pagina_web.Centro_comercial.centro_comercial_pagina_id', compact('json_data'));
    }

    public function get_turismo()
    {
        /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_turismos()');*/
        $estado = "A";
        $sql = DB::connection('pgsql_pag_web')->Select("select * from view_turismos_centro_comerciales");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_turismos;
        }
        $json_data = json_decode($data);*/
        $json_data = $sql;

        //return $json_data;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }


    public function save_turismo(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $imagen = $request->file('txt-file-foto');
        if ($imagen == "") {
            return response()->json(["respuesta" => "imagen_vacia"]);
        } else if ($imagen != null) {
            $nombreimagen = Str::slug("TURISMO-") . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta = public_path('/imagenes_turismo/' . $nombreimagen);
            copy($imagen->getRealPath(), $nuevaruta);
            $json[] = [
                'ruta_foto' => $nombreimagen,
                'titulo' => $request->input('txt-titulo'),
                'descripcion' => $request->input('txt-descripcion'),
                'categoria' => $request->input('select-categoria'),
                'estado' => $request->input('select-estado'),
                'tipo' => $request->input('select-tipo')
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_turismo(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_turismo;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function delete_turismo_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-turismo')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_turismos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_turismos;
        }
        if ($sql != "[]") {
            unlink(public_path('/imagenes_turismo/' . $request->input('txt-foto-anterior-e')));
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_turismo_id($id)
    {
        /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_turismos_id(?)', [$id]);*/
        $sql = DB::connection('pgsql_pag_web')->Select("select * from view_turismos_centro_comerciales where tu_id = " . $id);

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_turismos_id;
        }
        $json_data = json_decode($data);*/
        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_turismo(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $imagen = $request->file('txt-file-foto-m');
        if ($imagen == "") {
            $nombreimagen = null;
        } else if ($imagen != null) {
            $nombreimagen = Str::slug("TURISMO-") . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta = public_path('/imagenes_turismo/' . $nombreimagen);
            unlink(public_path('/imagenes_turismo/' . $request->input('txt-foto-anterior')));
            copy($imagen->getRealPath(), $nuevaruta);
        }
        $json[] = [
            'id' => $request->input('txt-id-turismo-m'),
            'ruta_foto' => $nombreimagen,
            'titulo' => $request->input('txt-titulo-m'),
            'descripcion' => $request->input('txt-descripcion-m'),
            'categoria' => $request->input('select-categoria-m'),
            'estado' => $request->input('select-estado-m'),
            'tipo' => $request->input('select-tipo-m')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_turismo(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_turismo;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_turismo_categoria($id_categoria)
    {
        if ($id_categoria == 0) {
            $sql = DB::connection('pgsql_pag_web')->Select("select * from view_turismos_centro_comerciales where tu_estado = 'A'");
            /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_turismos()');
            foreach ($sql as $r) {
                $data = $r->cursor_listar_turismos;
            }*/
        } else {
            $sql = DB::connection('pgsql_pag_web')->Select("select * from view_turismos_centro_comerciales where tu_id_categoria = " . $id_categoria . " and tu_estado = 'A'");

            /* $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_turismos_id_categoria(?)', [$id_categoria]);
             foreach ($sql as $r) {
                 $data = $r->cursor_listar_turismos_id_categoria;
             }*/
        }
        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_turismo_categoria_t($id_categoria)
    {
        if ($id_categoria == 0) {
            $sql = DB::connection('pgsql_pag_web')->Select("select * from view_turismos_centro_comerciales where tu_tipo = 'T' and tu_estado = 'A'");
            /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_turismos_t()');
            foreach ($sql as $r) {
                $data = $r->cursor_listar_turismos_t;
            }*/
        } else {
            $sql = DB::connection('pgsql_pag_web')->Select("select * from view_turismos_centro_comerciales where tu_id_categoria = " . $id_categoria . " and tu_estado = 'A'");
            /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_turismos_id_categoria(?)', [$id_categoria]);
            foreach ($sql as $r) {
                $data = $r->cursor_listar_turismos_id_categoria;
            }*/
        }
        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_turismo_categoria_c($id_categoria)
    {
        if ($id_categoria == 0) {
            $sql = DB::connection('pgsql_pag_web')->Select("select * from view_turismos_centro_comerciales where tu_tipo = 'C' and tu_estado = 'A'");
            /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_turismos_c()');
            foreach ($sql as $r) {
                $data = $r->cursor_listar_turismos_c;
            }*/
        } else {
            $sql = DB::connection('pgsql_pag_web')->Select("select * from view_turismos_centro_comerciales where tu_id_categoria = " . $id_categoria . " and tu_estado = 'A'");

            /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_turismos_id_categoria(?)', [$id_categoria]);
            foreach ($sql as $r) {
                $data = $r->cursor_listar_turismos_id_categoria;
            }*/
        }
        $json_data = $sql;

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