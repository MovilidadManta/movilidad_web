<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Session;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;
use File;
use Image;

class BiometricoController extends Controller
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

    public function save_empleado()
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $fecha_salida = "1000-01-01";
        $user_logueado = session::get('usuario');
        //return $user;
        $json_data = DB::select("SELECT * from public.tbl_empleados where emp_id !=1");


        $data = json_decode(json_encode($json_data), true);

        for ($i=0; $i < count($data); $i++) {
            $encode = $data[$i]['emp_id'];

            $ruta = $data[$i]['emp_ruta_foto'];
            $ruta_ = explode(" - ", $ruta);

            $nuevaruta = public_path('/imagenes_empleados/' . $ruta);
            if (is_file($nuevaruta)) {
                
            }

            $id_biometrico = DB::connection('pgsqlBiometrico')->table('personnel_employee')->insertGetId(
                [
                    'create_time' => now(),
                    'create_user' => null,
                    'change_time' => now(),
                    'status' => 0,
                    'emp_code' => $data[$i]['emp_cedula'],
                    'first_name' => $data[$i]['emp_nombre'],
                    'last_name' => $data[$i]['emp_apellido'],
                    'is_admin' => false,
                    'enable_payroll' => true,
                    'deleted' => false,
                    'is_active' => true,
                    'app_status' => 0,
                    'gender' => $data[$i]['emp_sexo'],
                    'emp_type' => 1,
                    'app_role' => 1,
                    'department_id' => $data[$i]['emp_id_perfil'],
                    'acc_group' => 1,
                    'update_time' => now(),
                    'hire_date' => now(),
                    'position_id' => 1,
                    'photo' => 'photo/'.$ruta_[1]
                ]
            );

            $insert_att_attemploye = DB::connection('pgsqlBiometrico')->table('att_attemployee')->insertGetId(
                [
                    'create_time' => now(),
                    'create_user' => null,
                    'change_time' => now(),
                    'status' => 0,
                    'enable_attendance' => true,
                    'enable_schedule' => true,
                    'enable_overtime' => true,
                    'enable_holiday' => true,
                    'emp_id' => $id_biometrico
                ]
            );

            $insert_payroll_emppayrollprofile = DB::connection('pgsqlBiometrico')->table('payroll_emppayrollprofile')->insertGetId(
                [
                    'payment_mode' => 1,
                    'payment_type' => 1,
                    'employee_id' => $id_biometrico
                ]
            );



            echo(' codigo '.$encode.'  ||  Id Biometrico '.$id_biometrico.' || cedula'.$data[$i]['emp_cedula'].'    || Nombres y Apellidos '.$data[$i]['emp_apellido'].' '.$data[$i]['emp_nombre'].'<br>');
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
