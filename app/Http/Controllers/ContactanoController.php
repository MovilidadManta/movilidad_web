<?php

namespace App\Http\Controllers;

use  Session;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ContactanoController extends Controller
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


        return view('Administrador.Contactano.contactano', compact('menus_'));
    }

    public function index_pagina()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Pagina_web.Contactanos.pagina_contactano', compact('menus_'));
    }

    public function get_contactanos()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_contactanos()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_contactanos;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_contactanos_paginas(Request $request)
    {
        $ip = request()->ip();
        // $user = session::get('id_users');

        $json[] = [
            'nombre' => $request->input('txt-nombre'),
            'apellido' => $request->input('txt-apellido'),
            'correo' => $request->input('txt-correo'),
            'mensaje' => $request->input('txt-mensaje')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_contactanos_pagina(?,?)', [$jsoninsert, $ip]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_contactanos_pagina;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function save_contactanos(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'nombre' => $request->input('txt-nombre'),
            'apellido' => $request->input('txt-apellido'),
            'correo' => $request->input('txt-correo'),
            'mensaje' => $request->input('txt-mensaje')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_contactanos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_contactanos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_contactanos_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_contactano' => $request->input('txt-id-contactano')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_contactanos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_contactanos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_contactanos_id($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_contactanos_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_contactanos_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_contactanos(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('txt-id-modificar-contactano'),
            'nombre' => $request->input('txt-nombre-m'),
            'apellido' => $request->input('txt-apellido-m'),
            'correo' => $request->input('txt-correo-m'),
            'mensaje' => $request->input('txt-mensaje-m')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_contactanos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_contactanos;
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
