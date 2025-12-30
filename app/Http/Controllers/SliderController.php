<?php

namespace App\Http\Controllers;

use  Session;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Storage;

use Carbon\Carbon;

class SliderController extends Controller
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
        return view('Administrador.Slider.slider', compact('menus_'));
    }

    public function get_slider_index()
    {
        //$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_slider_index()');
        $sql = DB::connection('pgsql_pag_web')->select("select * from view_slider_index");

        if ($sql != "[]") {
            return response()->json(['data' => $sql, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_slider_index(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $imagen = $request->file('txt-file-foto');
        if ($imagen == "") {
            return response()->json(["respuesta" => "imagen_vacia"]);
        } else if ($imagen  != null) {
            $nombreimagen   =   Str::slug("INDEX-") . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta      =   public_path('/imagenes_slider/' . $nombreimagen);
            copy($imagen->getRealPath(), $nuevaruta);
            $json[] = [
                'titulo' => $request->input('txt-titulo'),
                'descripcion' => $request->input('txt-descripcion'),
                'tipo' => $request->input('select-tipo'),
                'estado' => $request->input('select-estado'),
                'ruta_foto' => $nombreimagen
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_slider(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_slider;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function save_slider_intranet(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $imagen = $request->file('txt-file-foto');

        if ($imagen == "") {
            return response()->json(["respuesta" => "imagen_vacia"]);
        } else if ($imagen  != null) {
            /*$nombreimagen   =   Str::slug("INDEX-") . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta      =   public_path('/imagenes_slider/' . $nombreimagen);
            copy($imagen->getRealPath(), $nuevaruta);*/
            $nombre_original = $imagen->getClientOriginalName();
            $ftp = Storage::disk('ftp')->put('sliders/' . $nombre_original, File::get($imagen));

            $json[] = [
                'titulo' => $request->input('txt-titulo'),
                'descripcion' => $request->input('txt-descripcion'),
                'tipo' => $request->input('select-tipo'),
                'estado' => $request->input('select-estado'),
                'ruta_foto' => 'sliders/' . $nombre_original
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_slider(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_slider;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function get_slider_id($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_slider_index_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_slider_index_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }


    public function update_slider_index_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $imagen = $request->file('txt-file-foto-m');
        $imagen_anterior = $request->input('txt-ruta-anterior-m');
        if ($imagen  != "") {
            $imagePath = public_path('/imagenes_slider/' . $imagen_anterior);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            $nombreimagen   =   Str::slug("SLIDER-") . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta      =   public_path('/imagenes_slider/' . $nombreimagen);
            copy($imagen->getRealPath(), $nuevaruta);
            $json[] = [
                'id' => $request->input('txt-id-modificar-slider'),
                'titulo' => $request->input('txt-titulo-m'),
                'descripcion' => $request->input('txt-descripcion-m'),
                'tipo' => $request->input('select-tipo-m'),
                'estado' => $request->input('select-estado-m'),
                'ruta_foto' => $nombreimagen
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_slider(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_modificar_datos_slider;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        } else {
            $json[] = [
                'id' => $request->input('txt-id-modificar-slider'),
                'titulo' => $request->input('txt-titulo-m'),
                'descripcion' => $request->input('txt-descripcion-m'),
                'tipo' => $request->input('select-tipo-m'),
                'estado' => $request->input('select-estado-m')
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_slider(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_modificar_datos_slider;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function delete_slider_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-slider-e')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_slider(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_slider;
        }
        $imagePath = public_path('/imagenes_slider/' . $data);
        if (File::exists($imagePath)) {
            unlink($imagePath);
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => "eliminado", "ruta" => $data, "sql" => $sql]);
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
