<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use File;

use Illuminate\Http\Request;

class DestinoController extends Controller
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

        $t_menu = DB::connection('pgsql')->table("public.view_menu")->get();
        $t_menu_empleado = DB::connection('pgsql')->select("select * from public.view_menu_empleado where emp_id = " . session::get('id_empleado') . "");
        $t_sub_menu_empleado = DB::connection('pgsql')->table("public.view_sub_menu_empleado")->where("emp_id", "=", session::get('id_empleado'))->get();
        return view('Administrador.Destino.destino', compact('t_empleados', 't_usuarios', 't_menu', 't_menu_empleado', 't_sub_menu_empleado', 'menus_'));
    }

    public function index_search_destino()
    {
        return view('Pagina_web.Destino.buscar_destino');
    }

    public function get_destino()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_destinos()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_destinos;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_destino(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'destino' => $request->input('txt-destino'),
            'latitud' => $request->input('txt-latitud'),
            'longitud' => $request->input('txt-longitud'),
            'observacion' => $request->input('txt-observacion'),
            'estado' => $request->input('select-estado')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_destino(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_destino;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_destino_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-destino')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_destino(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_destino;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_destino_id($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_destinos_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_destinos_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_destino(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-destino-m'),
            'destino' => $request->input('txt-destino-m'),
            'latitud' => $request->input('txt-latitud-m'),
            'longitud' => $request->input('txt-longitud-m'),
            'observacion' => $request->input('txt-observacion-m'),
            'estado' => $request->input('select-estado-m')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_destino(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_destino;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_destino_cooperativa($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_destino_cooperativa_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_destino_cooperativa_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function admin_get_destino_cooperativa($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_admin_listar_destino_cooperativa_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_admin_listar_destino_cooperativa_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_search_destino($id_destino, $id_coopera)
    {
        if ($id_destino == 0) {
            $destino = "";
        } else {
            $destino = "AND dc.dc_id_destino = $id_destino";
        }

        if ($id_coopera == 0) {
            $cooperativa = '';
        } else {
            $cooperativa = "AND dc.dc_id_cooperativa = $id_coopera";
        }

        $json_data = DB::connection('pgsql_pag_web')->Select("			
            SELECT 
                dc.dc_id,
                dc.dc_id_cooperativa,
                dc.dc_id_destino,
                dc.dc_precio,
                c.co_id, 
                c.co_nombre,
                c.co_celular,
                c.co_convencional,
                c.co_abreviatura,
                c.co_correo,
                c.co_observacion,
                c.co_ruta_foto ,
                c.co_tipo_cooperativa,
                c.co_ubicacion,
                c.co_estado ,
                c.co_estado_encomienda,
                c.co_ubicacion_encomienda,
                c.co_codigo,
                d.de_id,
                d.de_destino,
                d.de_estado,
                d.de_latitud,
                d.de_longitud
            FROM 
                public.tbl_destinos_cooperativas dc, 
                public.tbl_cooperativas c,
                public.tbl_destinos d
            WHERE c.co_id = dc.dc_id_cooperativa
            AND d.de_id = dc.dc_id_destino
            AND c.co_estado ='A'
            $destino
            $cooperativa
	    ");
        foreach ($json_data as $da) {
            $json_data_hora = DB::connection('pgsql_pag_web')->Select("SELECT * FROM public.tbl_horas_salidas_cooperativas where hs_id_destino = $da->dc_id");
            $horarios_encomienda = DB::connection('pgsql_pag_web')->select("select * from view_horarios_encomienda_cooperativas where co_id = " . $da->co_id . "");
            $da->data_hora_salida = $json_data_hora;
            $da->data_horarios_encomienda = $horarios_encomienda;
        }

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_destino_cooperativa(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_destino_cooperativa' => $request->input('txt-id-destino'),
            'id_cooperativa' => $request->input('txt-id-cooperativa-destino'),
            'id_destino' => $request->input('select-destino'),
            'precio' => $request->input('txt-precio')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_destino_cooperativa(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_destino_cooperativa;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_destino_cooperativa_id($id_dest_coop)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_destinos_cooperativas_id_destino(?)', [$id_dest_coop]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_destinos_cooperativas_id_destino;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function delete_destino_cooperativa_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-destino-cooperativa')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_destino_cooperativa(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_destino_cooperativa;
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