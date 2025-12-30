<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class JefaturaOrganigramaController extends Controller
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
        return view('Administrador.Organigrama.Jefatura.index', compact('menus_'));
    }

    public function get_all()
    {
        $sql = DB::connection('pgsql')->select("SELECT * FROM view_tbl_jefaturas_subdirecciones");
        $json_data = $sql;
        return response()->json($json_data);
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
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'perfil' => strtoupper($request->perfil),
            'id_direccion' => $request->id_direccion,
            'estado_direccion' => $request->estado_direccion,
            'estado' => $request->estado
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->select('select public.procedimiento_registrar_jefatura_subdirecciones(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_jefatura_subdirecciones;
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
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->id,
            'perfil' => strtoupper($request->perfil),
            'id_direccion' => $request->id_direccion,
            'estado_direccion' => $request->estado_direccion,
            'estado' => $request->estado
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->select('select public.procedimiento_modificar_jefatura_subdirecciones(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_jefatura_subdirecciones;
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
    public function destroy($id)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $id
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_eliminar_jefatura_subdirecciones(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_jefatura_subdirecciones;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }
}
