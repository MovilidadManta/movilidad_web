<?php

namespace App\Http\Controllers;

use  Session;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use File;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function get_categoria()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_categorias()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_categorias;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_categoria_turismo()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_categorias_turismo()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_categorias_turismo;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_categoria_comercial()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_categorias_comercial()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_categorias_comercial;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
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
