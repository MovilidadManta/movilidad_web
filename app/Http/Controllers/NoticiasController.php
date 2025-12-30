<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use File;

class NoticiasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_DTM()
    {
        /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_noticias()');*/

        $sql = DB::connection('pgsql_pag_web')->select("select * from view_noticias where no_tipo = 1 and no_estado= 1");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_noticias;
        }*/
        $json_data = $sql;
        $json_data2 = $sql;

        $no_tipo = 1;
        $contador = count($sql);
        $filas_e = $contador / 4;
        //$filas = ceil($contador / 4);
        $filas = ceil($contador / 4);

        $final = $contador - 1;
        $cont = 0;
        $array_fila = [];
        $desde = 0;
        $hasta = 4;
        for ($i = 0; $i < $filas; $i++) {
            $cont = $cont + 1;
            array_push($array_fila, array('fila' => $filas, 'desde' => $desde, 'hasta' => $hasta));
            $desde = $desde + 4;
            $hasta = $hasta + 4;
            if ($hasta > $contador) {
                //$hasta = 10;
                $res = $hasta - ($hasta - $contador);
                $hasta = $res;
            }
        }
        return view('Pagina_web.Noticia.noticias_index', compact('json_data', 'json_data2', 'filas', 'array_fila', 'contador', 'no_tipo'));
    }

    public function index_TTM()
    {
        /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_noticias()');*/

        $sql = DB::connection('pgsql_pag_web')->select("select * from view_noticias where no_tipo = 2 and no_estado = 1");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_noticias;
        }*/
        $json_data = $sql;
        $json_data2 = $sql;

        $no_tipo = 2;

        $contador = count($sql);
        $filas_e = $contador / 4;
        //$filas = ceil($contador / 4);
        $filas = ceil($contador / 4);

        $final = $contador - 1;
        $cont = 0;
        $array_fila = [];
        $desde = 0;
        $hasta = 4;
        for ($i = 0; $i < $filas; $i++) {
            $cont = $cont + 1;
            array_push($array_fila, array('fila' => $filas, 'desde' => $desde, 'hasta' => $hasta));
            $desde = $desde + 4;
            $hasta = $hasta + 4;
            if ($hasta > $contador) {
                //$hasta = 10;
                $res = $hasta - ($hasta - $contador);
                $hasta = $res;
            }
        }
        return view('Pagina_web.Noticia.noticias_index', compact('json_data', 'json_data2', 'filas', 'array_fila', 'contador', 'no_tipo'));
    }

    public function index_id($id, $tipo)
    {
        $hashids = new \Hashids\Hashids('app-100', 8);
        $id_ = substr(implode(" ", $hashids->decode($id)), 4);

        // $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_noticias_id(?)', [$id_]);

        $sql = DB::connection('pgsql_pag_web')->select("select * from view_noticias where no_id = " . $id_ . "");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_noticias_id;
        }
        $json_data = json_decode($data);*/
        $json_data = $sql;
        return view('Pagina_web.Noticia.noticias_index_id', compact('json_data', 'tipo'));
    }


    public function index_administrador()
    {
        $t_empleados = DB::connection('pgsql')->select("select * from view_total_empleados");
        $t_usuarios = DB::connection('pgsql')->select("select * from view_total_usuarios");
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();

        return view('Administrador.Noticia.noticia', compact('t_empleados', 't_usuarios', 'menus_'));
    }


    public function get_noticias()
    {
        //$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_noticias()');
        $sql = DB::connection('pgsql_pag_web')->select("select * from view_noticias");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_noticias;
        }
        $json_data = json_decode($data);*/


        if ($sql != "[]") {
            return response()->json(['data' => $sql, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_noticia_paginacion($id, $de, $ha, $tipo)
    {
        /* $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_noticias()');*/

        $sql = DB::connection('pgsql_pag_web')->select("select * from view_noticias where no_tipo = $tipo  and no_estado= 1");
        
        /* foreach ($sql as $r) {
             $data = $r->cursor_listar_noticias;
         }*/

        $json_data = $sql;
        $json_data2 = $sql;

        $contador = count($json_data);
        $filas_e = $contador / 4;
        //$filas = ceil($contador / 4);
        $filas = ceil($contador / 4);

        $ha = $contador >= $ha ? $ha : $contador;

        $final = $contador - 1;
        $cont = 0;
        $array_fila = [];
        $desde = 0;
        $hasta = 4;
        for ($i = 0; $i < $filas; $i++) {
            $cont = $cont + 1;
            array_push($array_fila, array('fila' => $filas, 'desde' => $desde, 'hasta' => $hasta));
            $desde = $desde + 4;
            $hasta = $hasta + 4;
            if ($hasta > $contador) {
                //$hasta = 10;
                $res = $hasta - ($hasta - $contador);
                $hasta = $res;
            }
        }

        $array_noticia = [];
        for ($x = 0; $x < count($array_fila); $x++) {
            if ($x + 1 == $id) {
                for ($i = $de; $i < $ha; $i++) {
                    array_push($array_noticia, $json_data[$i]);
                }
            }
        }
        $array_noticia = (array) json_decode(json_encode($array_noticia));

        foreach ($array_noticia as $value) {
            $id = $value->no_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_noticia_hash = $id_;
        }

        if ($json_data2 != "[]") {
            return response()->json(['data' => $array_noticia, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_noticias(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $imagen = $request->file('txt-file-foto');
        if ($imagen == "") {
            return response()->json(["respuesta" => "imagen_vacia"]);
        } else if ($imagen != null) {
            $nombreimagen = Str::slug("NOTICIA-") . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta = public_path('/imagenes_noticias/' . $nombreimagen);
            copy($imagen->getRealPath(), $nuevaruta);
            $json[] = [
                'titulo' => $request->input('txt-titulo'),
                'ubicacion' => $request->input('select-ubicacion'),
                'estado' => $request->input('select-estado'),
                'descripcion' => $request->input('txt-descripcion'),
                'ruta_foto' => $nombreimagen
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_noticias(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_noticias;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => true, "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function delete_noticias_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_noticia' => $request->input('txt-id-noticia')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_noticias(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_noticias;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_noticias_id($id)
    {
        /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_noticias_id(?)', [$id]);*/
        $sql = DB::connection('pgsql_pag_web')->select("select * from view_noticias where no_id = " . $id . "");
        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_noticias_id;
        }
        $json_data = json_decode($data);*/
        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_noticias(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $imagen = $request->file('txt-file-foto-m');
        $imagen_anterior = $request->input('txt-ruta-anterior');
        if ($imagen != "") {
            $imagePath = public_path('/imagenes_noticias/' . $imagen_anterior);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            $nombreimagen = Str::slug("NOTICIA-") . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta = public_path('/imagenes_noticias/' . $nombreimagen);
            copy($imagen->getRealPath(), $nuevaruta);
            $json[] = [
                'id' => $request->input('txt-id-modificar-noticia'),
                'titulo' => $request->input('txt-titulo-m'),
                'ubicacion' => $request->input('select-ubicacion-m'),
                'estado' => $request->input('select-estado-m'),
                'descripcion' => $request->input('txt-descripcion-m'),
                'ruta_foto' => $nombreimagen
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_noticias(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_modificar_datos_noticias;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        } else {
            $json[] = [
                'id' => $request->input('txt-id-modificar-noticia'),
                'titulo' => $request->input('txt-titulo-m'),
                'ubicacion' => $request->input('select-ubicacion-m'),
                'estado' => $request->input('select-estado-m'),
                'descripcion' => $request->input('txt-descripcion-m')
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_noticias(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_modificar_datos_noticias;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
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