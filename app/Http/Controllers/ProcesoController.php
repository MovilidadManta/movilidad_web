<?php

namespace App\Http\Controllers;

use  Session;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use File;
use Illuminate\Http\Request;

class ProcesoController extends Controller
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
        return view('Administrador.Proceso.proceso', compact('menus_'));
    }

    public function get_proceso()
    {
        //$sql = DB::Select('select public.cursor_listar_procesos()');

        if(Session::get('id_jefatura')==3 || Session::get('id_jefatura') == 23){
            $sql = DB::Select('select public.cursor_listar_procesos()');
        }else{
            $sql = DB::Select('select public.cursor_listar_procesos(?)',[Session::get('id_jefatura')]);
        }


        foreach ($sql as $r) {
            $data = $r->cursor_listar_procesos;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_proceso(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $year = date('Y');

        $numero_orden = $request->input('txt-numero-orden');
        if($numero_orden==''){
            $numero_orden=null;
        }

        $archivo = $request->file('txt-file-proceso');
        if ($archivo == "") {
            return response()->json(["respuesta" => "archivo_vacia"]);
        } else if ($archivo  != null) {
            $nombrearchivo   =   'PROCESO' . date("Ymdsm") . '.' . $archivo->getClientOriginalExtension();
            $nuevaruta      =   public_path('/archivos_procesos/' . $nombrearchivo);
            copy($archivo->getRealPath(), $nuevaruta);
            $json[] = [
                'ruta_archivo' => $nombrearchivo,
                'numero_orden' => $numero_orden,
                'identificador' => $request->input('txt-identificacion'),
                'fecha' => $request->input('txt-fecha'),
                'year' => $year,
                'tipo_proceso' => $request->input('select-tipo-proceso'),
                'id_jefatura' => $request->input('select-jefatura-subdireccion'),
                'digitador' => $request->input('select-digitador'),
                'descripcion' => $request->input('txt-descripcion')
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::Select('select public.procedimiento_registrar_datos_proceso(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_proceso;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function descargar_archivo_proceso($file)
    {
        $pathtoFile = public_path() . '/archivos_procesos/' . $file;
        return response()->download($pathtoFile);
    }


    public function delete_proceso_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-proceso')
        ];
        $jsoninsert = json_encode($json);
        $nombrearchivo = $request->input('txt-archivo-anterior-e');
        $nuevaruta      =   public_path('/archivos_procesos/' . $nombrearchivo);
        if (File::exists($nuevaruta)) {
            unlink($nuevaruta);
            $sql = DB::Select('select public.procedimiento_eliminar_datos_procesos(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $data = $s->procedimiento_eliminar_datos_procesos;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
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
