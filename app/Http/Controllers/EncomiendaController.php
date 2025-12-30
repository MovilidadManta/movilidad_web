<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use File;

use Illuminate\Http\Request;

class EncomiendaController extends Controller
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

    public function index_pagina()
    {
        //$sql = DB::connection('pgsql_pag_web')->Select('select public.view__encomiendas');
        $sql = DB::connection('pgsql_pag_web')->select("select * from view_encomiendas");

        /* foreach ($sql as $r) {
             $data = $r->cursor_listar_encomienda_pagina;
         }*/
        $json_data = $sql;
        return view('Pagina_web.Encomienda.encomienda_pagina', compact('json_data'));
    }

    public function index_pagina_id($id)
    {
        //$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_encomiendas_id_pagina(?)', [$id]);
        $sql = DB::connection('pgsql_pag_web')->select("select * from view_encomiendas_id_pagina");
        $json_data = $sql;

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_encomiendas_id_pagina;
        }
        $json_data = json_decode($data);*/

        return view('Pagina_web.Encomienda.encomienda_pagina_id', compact('json_data'));
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