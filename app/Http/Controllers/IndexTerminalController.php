<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Session;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Support\Str;

class IndexTerminalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function index_web()
    {
        return view('Pagina_web.web');
    }


    public function index_pagina()
    {
         /*$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_noticias()');*/

         $sql = DB::connection('pgsql_pag_web')->select("select * from view_noticias where no_tipo=2 and no_estado = 1");
       // return var_dump($sql);
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

        $result_array_1 = json_decode(json_encode($array_1));
        $result_array_2 = json_decode(json_encode($array_2));
        $result_array_3 = json_decode(json_encode($array_3));
        //return var_dump($result_array_1);
 
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
         $sql_slider = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_slider_index_terminal()');
 
         foreach ($sql_slider as $r) {
             $data_slider = $r->cursor_listar_slider_index_terminal;
         }
        $json_data_slider_slider = json_decode($data_slider);
        //return $result_array_1;
        return view('Pagina_web.Index_terminal.index_terminal_pagina', compact(
            'result_array_1',
            'result_array_2',
            'result_array_3',
            'json_data_slider_slider'
        ));
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
