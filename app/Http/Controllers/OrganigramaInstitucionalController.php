<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class OrganigramaInstitucionalController extends Controller
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
        return view('Administrador.Organigrama.organigrama', compact('menus_'));
    }



    public function get_organigrama()
    {
        $json_data = DB::connection('pgsql')->select("select * from view_organigramas");

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_organigrama(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $year = date('Y');
        $json[] = [
            'id_direccion' => $request->input('select-direccion'),
            'id_jefatura' => $request->input('select-jefatura-subdireccion'),
            'id_cargo' => $request->input('select-cargo'),
            'nivel' => $request->input('select-nivel'),
            'year' => $year,
            'descripcion' => strtoupper($request->input('txt-descripcion')),
            'estado' => $request->input('select-estado')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->Select('select public.procedimiento_registrar_datos_organigramas(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_organigramas;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_organigrama_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-organigrama')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->Select('select public.procedimiento_eliminar_datos_organigramas(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_organigramas;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }


    public function get_organigrama_id($id_organigrama)
    {
        $sql = DB::connection('pgsql')->select("select * from view_organigramas where eo_id = " . $id_organigrama . "");

        if ($sql != "[]") {
            return response()->json(['data' => $sql, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_organigrama(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $year = date('Y');
        $json[] = [

            'id' => $request->input('txt-id-organigrama-m'),
            'id_direccion' => $request->input('select-direccion-m'),
            'id_jefatura' => $request->input('select-jefatura-subdireccion-m'),
            'id_cargo' => $request->input('select-cargo-m'),
            'nivel' => $request->input('select-nivel-m'),
            'year' => $year,
            'descripcion' => strtoupper($request->input('txt-descripcion-m')),
            'estado' => $request->input('select-estado-m')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->Select('select public.procedimiento_modificar_datos_organigramas(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_organigramas;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    /*public function update_cargo(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id'),
            'id_direccion' => $request->input('select-direccion-m'),
            'id_jefatura' => $request->input('select-jefatura-subdireccion-m'),
            'id_cargo_superior' => $request->input('select-cargo-superior-m'),
            'cargo' => $request->input('txt-cargo-m'),
            'estado' => $request->input('select-estado-m')
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::connection('pgsql')->Select('select public.procedimiento_modificar_datos_cargos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_cargos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }*/

    public function graficar()
    {
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();

            $sql = DB::Select('select public.cursor_listar_usuarios()');
            foreach ($sql as $r) {
                $data = $r->cursor_listar_usuarios;
            }
            $usuario = json_decode($data);

            $orga = DB::select('select * from view_organigrama');
            //$json[] = null;
            foreach ($orga as $o) {
                if ($o->nivel_jefe == 1) {
                    $json[] = [
                        'key' => $o->id_cargo,
                        'name' => $o->name,
                        'title' => $o->title,
                        'pic' => "/imagenes_empleados/" . $o->pic . ".jpeg"

                    ];
                } else {
                    $json[] = [
                        'key' => $o->id_cargo,
                        'name' => $o->name,
                        'title' => $o->title,
                        'pic' => '/imagenes_empleados/' . $o->pic . '.jpeg',
                        'parent' => $o->cargo_jefe
                    ];
                }
            }
            // return $json;
            $or = [
                "class" => "go.TreeModel",
                "nodeDataArray" => $json
            ];
            $json_orga = json_encode($or);
            //return $jsoninsert;
            //return $usuario;
            return view('Administrador.Organigrama.grafico_organigrama', compact('menus_', 'usuario', 'json_orga'));
        } else {
            return view("Administrador.Login.login");
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