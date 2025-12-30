<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use File;

class CooperativaController extends Controller
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

        return view('Administrador.Cooperativa.cooperativa', compact('t_empleados', 't_usuarios', 'menus_'));
    }

    public function index_pagina()
    {
        /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_cooperativas_pagina()');*/

        $sql = DB::connection('pgsql_pag_web')->select("select * from view_cooperativas");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_cooperativas_pagina;
        }
        $json_data = json_decode($data);*/
        $json_data = $sql;


        return view('Pagina_web.Cooperativa.cooperativa_pagina', compact('json_data'));
    }

    public function index_pagina_id($id)
    {
        /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_cooperativas_id_pagina(?)', [$id]);*/

        $sql = DB::connection('pgsql_pag_web')->select("select * from view_cooperativas_id_pagina where dc_id_cooperativa = " . $id . "");
        $horarios_encomienda = DB::connection('pgsql_pag_web')->select("select * from view_horarios_encomienda_cooperativas where co_id = " . $id . "");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_cooperativas_id_pagina;
        }
        $json_data = json_decode($data);*/
        $json_data = $sql;

        foreach ($json_data as $da) {
            $json_data_hora = DB::connection('pgsql_pag_web')->Select("SELECT * FROM public.tbl_horas_salidas_cooperativas where hs_id_destino = $da->dc_id");
            $da->data_hora_salida = $json_data_hora;
        }
        

        // return $json_data;
        return view('Pagina_web.Cooperativa.cooperativa_pagina_id', compact('json_data', 'horarios_encomienda'));
    }

    public function get_cooperativa()
    {
        /* $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_cooperativas()');*/

        $sql = DB::connection('pgsql_pag_web')->select("select * from view_cooperativas");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_cooperativas;
        }
        $json_data = json_decode($data);*/
        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_cooperativa(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $estado_encomienda = $request->input('select-estado-encomienda');
        $ubicacion_encomienda = $request->input('txt-ubicacion-encomienda');
        if ($estado_encomienda == '0') {
            $estado_encomienda = 'SI';
        }
        if ($ubicacion_encomienda == '') {
            $ubicacion_encomienda = 'SI';
        }

        $imagen = $request->file('txt-file-foto');
        if ($imagen == "") {
            return response()->json(["respuesta" => "imagen_vacia"]);
        } else if ($imagen != null) {
            $nombreimagen = Str::slug("COOPERATIVA-") . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta = public_path('/imagenes_cooperativa/' . $nombreimagen);
            copy($imagen->getRealPath(), $nuevaruta);
            $json[] = [
                'ruta_foto' => $nombreimagen,
                'nombre' => $request->input('txt-nombre'),
                'codigo' => $request->input('txt-codigo'),
                'abreviatura' => $request->input('txt-abreviatura'),
                'tipo' => $request->input('select-tipo'),
                'estado' => $request->input('select-estado'),
                'correo' => $request->input('txt-correo'),
                'convencional' => $request->input('txt-convencional'),
                'celular' => $request->input('txt-celular'),
                'estado_encomienda' => $request->input('select-estado-encomienda'),
                'ubicacion' => $request->input('txt-ubicacion'),
                'ubicacion_encomienda' => $request->input('txt-ubicacion-encomienda') ?? 'SI',
                'observacion' => $request->input('txt-observacion'),
                'horario_encomienda' => $request->input('horario-encomienda')
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_cooperativa(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_cooperativa;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function delete_cooperativa_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-cooperativa')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_cooperativas(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_cooperativas;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_cooperativas_id($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_cooperativas_id(?)', [$id]);
        
        foreach ($sql as $r) {
            $data = $r->cursor_listar_cooperativas_id;
        }
        $json_data = json_decode($data);
        
        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_cooperativa(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $estado_encomienda = $request->input('select-estado-encomienda-m');
        $ubicacion_encomienda = $request->input('txt-ubicacion-encomienda-m');
        if ($estado_encomienda == '0') {
            $estado_encomienda = 'SI';
        }
        if ($ubicacion_encomienda == '') {
            $ubicacion_encomienda = 'SI';
        }

        $imagen = $request->file('txt-file-foto-m');
        if ($imagen == "") {
            $nombreimagen = null;
        } else if ($imagen != null) {
            $nombreimagen = Str::slug("COOPERATIVA-") . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta = public_path('/imagenes_cooperativa/' . $nombreimagen);
            $ruta_anterior = public_path('/imagenes_cooperativa/' . $request->input('txt-foto-anterior'));

            if (File::exists($ruta_anterior)) {
                unlink($ruta_anterior);
            }
            copy($imagen->getRealPath(), $nuevaruta);
        }
        $json[] = [
            'id' => $request->input('txt-id-cooperativa-m'),
            'ruta_foto' => $nombreimagen,
            'nombre' => $request->input('txt-nombre-m'),
            'codigo' => $request->input('txt-codigo-m'),
            'abreviatura' => $request->input('txt-abreviatura-m'),
            'tipo' => $request->input('select-tipo-m'),
            'estado' => $request->input('select-estado-m'),
            'correo' => $request->input('txt-correo-m'),
            'convencional' => $request->input('txt-convencional-m'),
            'celular' => $request->input('txt-celular-m'),
            'estado_encomienda' => $estado_encomienda,
            'ubicacion' => $request->input('txt-ubicacion-m'),
            'ubicacion_encomienda' => $ubicacion_encomienda,
            'observacion' => $request->input('txt-observacion-m'),
            'horario_encomienda' => $request->input('horario-encomienda-m')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_cooperativa(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_cooperativa;
        }

        if ($sql != "[]") {


            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
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