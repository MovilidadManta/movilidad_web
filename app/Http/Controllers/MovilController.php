<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MovilController extends Controller
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

    public function login(Request $request)
    {
        $consulta = DB::table('view_usuarios')
            ->where('correo', '=', $request->get('email'))
            ->get();
        $v_correo = "";
        foreach ($consulta as $mail) {
            $v_correo = $mail->correo;
            $id = $mail->usu_id;
            $verifi_pass = $mail->contraseña;
        }
        if ($v_correo) {
            if (Hash::check($request->get('password'), $verifi_pass)) {
                $datosUsers = array(  'id'=>  $id, ); 
                return response()->json(
                    [   'success'=> true,
                         'message'=> 'logeo correcto',
                        'data' => $datosUsers], 200);
            } else {
                return response()->json(['error' => 'correo y/o contraseña incorrecta', 200]);
            }
        } else {
            return response()->json(['error' => 'Correo No Registrado', 200]);
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

     public function ListarEmpleados()
    {
        $consulta = DB::table('view_personal ')->get();
        return $consulta;
    }

    public function ListarEmpleadosCount()  
    {
        $consulta = DB::table('view_salario_mayor')->get();
        return $consulta;
    }


}
