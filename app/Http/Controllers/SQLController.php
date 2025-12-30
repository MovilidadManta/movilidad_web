<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SQLController extends Controller
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

    public function save_usuarios_masivos()
    {
        $sql = DB::connection('pgsql')->select("select * from view_listar_empleados");
        foreach ($sql as $value) {
            $cedula = $value->cedula;
            $value->clave = Hash::make($cedula);
            $insert = DB::connection('pgsql')->insert('insert into tbl_usuarios (
                usu_correo,
                usu_clave,
                usu_id_tipo, 
                usu_id_empleado, 
                usu_fecha, 
                usu_fecha_update,
                usu_estado,
                usu_cedula
                ) values (?,?,?,?,?,?,?,?)',
                array(
                    $value->correo,
                    $value->clave,
                    $value->emp_id_perfil,
                    $value->emp_id,
                    now(),
                    now(),
                    'A',
                    $value->cedula
                )
            );
            echo $value->cedula;
        }
        return $sql;
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