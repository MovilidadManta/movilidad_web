<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use DB;

use Session;

use App\Helpers\GuidHelper;
use Carbon\Carbon;

class EventosController extends Controller
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
        //return view('Administrador.Proyectos.index', compact('t_menu', 't_menu_empleado', 't_sub_menu_empleado'));
        return view('Administrador.Eventos.index', compact('menus_'));
    }

    public function get_eventos()
    {
        $eventos = DB::Select('SELECT * FROM public.view_tbl_intra_eventos');
        return $eventos;
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
        $date = $date->format('Y-m-d');
        $ip = request()->ip();
        $user = session::get('id_users');
        $guid = GuidHelper::GUIDv4();
        $archivo = $request->file('txt-ruta-foto');
        $nombreimagen = Str::slug("evento_") . date("Ymdsm") . "_" . $guid . '.' . $archivo->getClientOriginalExtension();
        $ruta = 'imagenes_eventos/' . $nombreimagen;
        $nuevaruta = public_path($ruta);
        copy($archivo->getRealPath(), $nuevaruta);
        $json[] = [
            'titulo' => $request->input('ip_titulo'),
            'evento' => $request->input('ip_contenido'),
            'fechai' => $request->input('ip_fini'),
            'fechaf' => $request->input('ip_ffin'),
            'ruta'   => $ruta,
            'estado' => $request->input('estado'),
            'tipo'   => $request->input('select-tipo')
        ];


        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_datos_eventos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_eventos;
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
    public function update(Request $request, $id)
    {
        
        $date = Carbon::now();
        $date = $date->format('Y-m-d');
        $ip = request()->ip();
        $user = session::get('id_users');
        $guid = GuidHelper::GUIDv4();
        $archivo = $request->file('txt-ruta-foto');
        $nombreimagen = '';
        $ruta = '';
        if($archivo){
            $nombreimagen = Str::slug("evento_") . date("Ymdsm") . "_" . $guid . '.' . $archivo->getClientOriginalExtension();
            $ruta = 'imagenes_eventos/' . $nombreimagen;
            $nuevaruta = public_path($ruta);
            copy($archivo->getRealPath(), $nuevaruta);
        }
        $json[] = [
            'id' => $id,
            'titulo' => $request->input('ip_titulo'),
            'evento' => $request->input('ip_contenido'),
            'fechai' => $request->input('ip_fini'),
            'fechaf' => $request->input('ip_ffin'),
            'ruta'   => $ruta,
            'estado' => $request->input('estado'),
            'tipo'   => $request->input('select-tipo')
        ];


        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_modificar_datos_eventos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_eventos;
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
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $id
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_eliminar_datos_eventos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_datos_eventos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }
}
