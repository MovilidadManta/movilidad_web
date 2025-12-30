<?php

namespace App\Http\Controllers;

use Session;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UsuarioController extends Controller
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
        return view('Administrador.Usuario.usuario', compact('menus_'));
    }

    public function asignacion($ced)
    {
        // $cedula =  base64_decode($ced);
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();

        
        $user_menus = DB::Select('select public.cursor_listar_submenus_asignados(?)', [$ced]);
        foreach ($user_menus as $r) {
            $data = $r->cursor_listar_submenus_asignados;
        }
        $umenus = $data;

        //return $data;
        $sql = DB::Select('select public.cursor_listar_usuarios_id(?)', [$ced]);
        foreach ($sql as $r) {
            $data = $r->cursor_listar_usuarios_id;
        }
        $json_data = json_decode($data);

        $proyectos = DB::Select('select public.cursor_listar_proyectos()');

        foreach ($proyectos as $p) {
            $pp = $p->cursor_listar_proyectos;
        }

        $proyectos = json_decode($pp);

        //return $json_data;
        return view('Administrador.Usuario.user_asignacion', compact('menus_', 'json_data', 'proyectos', 'umenus', 'ced'));
    }

    public function store_asignacion(Request $r)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $jsoninsert = json_encode($r->dat);
        $sql = DB::Select('select public.procedimiento_registrar_datos_asignacion_submenu(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_asignacion_submenu;
        }
        if ($sql != "[]") {
            $user_menus = DB::Select('select public.cursor_listar_submenus_asignados(?)', [$r->ced]);
            foreach ($user_menus as $r) {
                $data = $r->cursor_listar_submenus_asignados;
            }
            $umenus = $data;

            return response()->json(['respuesta' => "true", "data" => $umenus, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }
    public function get_usuarios()
    {
        $sql = DB::Select('select public.cursor_listar_usuarios()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_usuarios;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_subdirecciones()
    {
        $sql = DB::Select('select public.cursor_listar_jefaturas_subdirecciones()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_jefaturas_subdirecciones;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_usuarios(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id_empleado' => $request->input('txt-id-empleado'),
            'correo' => $request->input('txt-correo'),
            'clave' => Hash::make($request->input('txt-clave')),
            'tipo' => $request->input('select-jefatura-subdireccion'),
            'estado' => $request->input('select-estado'),
            'cedula' => $request->input('txt-cedula')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_datos_usuario(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_usuario;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_usuarios_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_usuario' => $request->input('txt-id-usuario')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_eliminar_datos_usuarios(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_usuarios;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_usuarios_id($id)
    {
        $sql = DB::Select('select public.cursor_listar_usuarios_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_usuarios_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_usuarios(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id_usuario' => $request->input('txt-id-modificar-usuario'),
            'correo' => $request->input('txt-correo-m'),
            'tipo' => $request->input('select-jefatura-subdireccion-m'),
            'estado' => $request->input('select-estado-m')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_modificar_datos_usuario_id(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_usuario_id;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function update_clave_usuario(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id_usuario' => $request->input('txt-id-cambiar-clave-usuario'),
            'clave' => Hash::make($request->input('txt-clave-nueva-m'))
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_modificar_clave_datos_usuario_id(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_clave_datos_usuario_id;
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