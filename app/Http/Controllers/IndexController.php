<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use File;
use Hashids\Hashids;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_noticias()');*/
        $sql = DB::connection('pgsql_pag_web')->select("select * from view_noticias");


        /* foreach ($sql as $r) {
             $data = $r->cursor_listar_noticias;
         }
         $json_data = json_decode($data);*/

        $cont = 4;
        $array_1 = [];
        $array_2 = [];
        $array_3 = [];
        $nu = count($sql) / 4;
        for ($i = 0; $i < count($sql); $i++) {
            if ($i < 4) {
                array_push($array_1, $sql[$i]);
            } else if ($i < 8) {
                array_push($array_2, $sql[$i]);
            } else if ($i < 12) {
                array_push($array_3, $sql[$i]);
            }
        }

        $result_array_1 = (array) json_decode(json_encode($array_1));
        $result_array_2 = (array) json_decode(json_encode($array_2));
        $result_array_3 = (array) json_decode(json_encode($array_3));
        //return $result;

        foreach ($result_array_1 as $value) {
            $id = $value->no_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_noticia_hash = $id_;
        }

        foreach ($result_array_2 as $value) {
            $id = $value->no_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_noticia_hash = $id_;
        }

        foreach ($result_array_3 as $value) {
            $id = $value->no_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_noticia_hash = $id_;
        }

        $json_data_slider_slider = [];
        $sql_slider = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_slider_index_movilidad()');

        foreach ($sql_slider as $r) {
            $data_slider = $r->cursor_listar_slider_index_movilidad;
        }
        $json_data_slider_slider = json_decode($data_slider);


        return view('Administrador.Layout.index', compact('result_array_1', 'result_array_2', 'result_array_3', 'json_data_slider_slider'));
    }

    public function index_p()
    {
        //$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_noticias()');
        $sql = DB::connection('pgsql_pag_web')->select("select * from view_noticias");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_noticias;
        }
        $json_data = json_decode($data);*/

        $cont = 4;
        $array_1 = [];
        $array_2 = [];
        $array_3 = [];
        $nu = count($sql) / 4;
        for ($i = 0; $i < count($sql); $i++) {
            if ($i < 4) {
                array_push($array_1, $sql[$i]);
            } else if ($i < 8) {
                array_push($array_2, $sql[$i]);
            } else if ($i < 12) {
                array_push($array_3, $sql[$i]);
            }
        }

        $result_array_1 = (array) json_decode(json_encode($array_1));
        $result_array_2 = (array) json_decode(json_encode($array_2));
        $result_array_3 = (array) json_decode(json_encode($array_3));
        //return $result;

        foreach ($result_array_1 as $value) {
            $id = $value->no_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_noticia_hash = $id_;
        }

        foreach ($result_array_2 as $value) {
            $id = $value->no_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_noticia_hash = $id_;
        }

        foreach ($result_array_3 as $value) {
            $id = $value->no_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_noticia_hash = $id_;
        }

        $sql_slider = DB::connection('pgsql_pag_web')->select("select * from view_slider_index_movilidad");
        /*foreach ($sql_slider as $r) {
            $data_slider = $r->cursor_listar_slider_index_movilidad;
        }*/
        $json_data_slider_slider = $sql_slider;
        //return $json_data_slider_slider;
        return view('Administrador.Layout.index_transito', compact('result_array_1', 'result_array_2', 'result_array_3', 'json_data_slider_slider'));
    }

    public function registrar_aporte_ciudadano(Request $request)
    {

        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'apellidos_nombres' => strtoupper($request->input('txt_apellidos_nombres')),
            'cedula' => strtoupper($request->input('txt_cedula')),
            'organizacion_representa' => strtoupper($request->input('txt_organizacion_representa')),
            'direccion_domiciliaria' => strtoupper($request->input('txt_direccion_domiciliaria')),
            'correo_electronico' => $request->input('txt_correo_electronico'),
            'celular' => strtoupper($request->input('txt_celular')),
            'aporte_ciudadano' => strtoupper($request->input('txt_aporte_ciudadano')),
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_tbl_aporte_ciudadano(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_aporte_ciudadano;
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


    public function normativas()
    {
        return view('Pagina_web.Normativas.index');
    }
}
