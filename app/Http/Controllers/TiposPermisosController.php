<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Mpdf\Mpdf;

use DB;

use Storage;
use  Session;
use DateTime;

class TiposPermisosController extends Controller
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
        return view('Administrador.Permisos.tipos_permisos', compact('menus_'));
    }

    public function get_tipo_permiso()
    {
        //$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_slider_index()');
        $json_data = DB::connection('pgsql')->select("select * from view_tipos_permisos");

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_campos()
    {
        if (Session::get('usuario')) {

            $json_data =  DB::connection('pgsql')->select("select * from view_campos");
            if ($json_data != "[]") {
                return response()->json(['data' => $json_data, 'respuesta' => true]);
            } else {
                return response()->json(['respuesta' => false]);
            }
        } else {
            return Redirect::to('/');
        }
    }

    public function get_campo_tipo_permiso($id_permiso)
    {
        if (Session::get('usuario')) {

            $json_data = DB::connection('pgsql')->select("select * from view_tipos_permisos_campos where tpc_id_tipo_permiso = $id_permiso");
            if ($json_data != "[]") {
                return response()->json(['data' => $json_data, 'respuesta' => true]);
            } else {
                return response()->json(['respuesta' => false]);
            }
        } else {
            return Redirect::to('/');
        }
    }

    public function save_campo_tipo_permiso(request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $year = date('Y');

        $json[] = [
            'id_tipo_permiso' => $request->input('txt-id-tipo-permiso'),
            'id_campo' => $request->input('select-campo-tipo-permiso')
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::Select('select public.procedimiento_registrar_datos_campos_tipos_permisos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_campos_tipos_permisos;
        }

        if ($sql != "[]") {
            return response()->json(['respuesta' => true, "data" => $id, "sql" => $sql]);
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
