<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;
use File;

class NotificacionEmpleadoController extends Controller
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

    public function save_notificacion_controller(request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $year = date('Y');

        $json[] = [
            'id_empleado' => $request->input('txt-id-empleado'),
            'fecha_terminacion' => $request->input('txt-fecha-terminacion'),
            'causa_salida' => $request->input('select-causa')
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::Select('select public.procedimiento_registrar_datos_notificacion_empleado(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_notificacion_empleado;
        }

        if ($sql != "[]") {
            $fecha_salida = DB::connection('pgsql')->select("SELECT ne_fecha_terminacion from tbl_notificaciones_empleados where ne_id_empleado =" . $request->input('txt-id-empleado'));
            foreach ($fecha_salida as $value) {
                $fecha_salida = $value->ne_fecha_terminacion;
            }
            $this->enviar_correo($request->input('txt-id-empleado'), $fecha_salida);
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function enviar_correo($id_empleado, $fecha_salida)
    {
        $user_logueado = session::get('usuario');
        //$json = $this->get_empleados_id($id_empleado);
        $json = DB::connection('pgsql')->select("select * from view_empleados where emp_id = " . $id_empleado);

        //$sql = DB::Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);

        /* $array_data = [];
         $data = array_push($array_data, $json);
         $j = $json->original;
         $data = $j['data'];*/
        foreach ($json as $value) {
            $cedula = $value->emp_cedula;
            $nombres = $value->emp_nombre;
            $apellidos = $value->emp_apellido;
            $telefono = $value->emp_telefono;
            $direccion = $value->dep_departamento;
            $jefatura = $value->per_perfil;
            $cargo = $value->emp_cargo;
            $titulo = $value->emp_titulo;
            $fecha_ingreso = $value->emp_fecha_ingreso;
        }

        $correos_users_1 = 'joaquin.flores@movilidadmanta.gob.ec';
        $correos_users_2 = 'gema.molina@movilidadmanta.gob.ec';
        //$correos_users_3 = 'genesis.zambrano@movilidadmanta.gob.ec';
        $correos_users_4 = 'freddy.cedeno@movilidadmanta.gob.ec';
        $correos_users_5 = 'edison.benitez@movilidadmanta.gob.ec';
        $correos_users_6 = 'virginia.torres@movilidadmanta.gob.ec';
        $correos_users_7 = 'maria.molina@movilidadmanta.gob.ec';
        $correos_users_8 = 'esteban.pena@movilidadmanta.gob.ec';
        $correos_users_9 = 'nelly.lugo@movilidadmanta.gob.ec';
        $correos_users_10 = 'tecnologia.intervencion@movilidadmanta.gob.ec';
        $correos_users_11 = 'elizabeth.godoy@movilidadmanta.gob.ec';
        $correos_users_12 = 'christian.villagomez@movilidadmanta.gob.ec';
        $correos_users_13 = 'maria.acosta@movilidadmanta.gob.ec';
        $correos_users_14 = 'maria.ponce@movilidadmanta.gob.ec';
        $correos_users_15 = 'maria.sanchez@movilidadmanta.gob.ec';
        $iptolocation = 'http://www.ip-api.com/json';
        $creatorlocation = file_get_contents($iptolocation);
        $usr = json_decode($creatorlocation);
        $country = $usr->country;
        $ip_publica = $usr->query;
        $host = $usr->isp;
        $city = $usr->city;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        /*$cedula = $request->input('txt-cedula');
        $nombre_apellido = $request->input('txt-nombre').' '.$request->input('txt-apellido');
        $telefono = $request->input('txt-telefono');
        $direccion = $request->input('txt-telefono');*/


        $em = Mail::send(
            'Administrador.Email.view_email_notificacion_empleado',
            array(
                'fecha' => date('d-m-Y h:s:m'),
                'country' => $country,
                'ip_publica' => $ip_publica,
                'host' => $host,
                'city' => $city,
                'nombres' => $apellidos . ' ' . $nombres,
                'cedula' => $cedula,
                'telefono' => $telefono,
                'direccion' => $direccion,
                'jefatura' => $jefatura,
                'cargo' => $cargo,
                'user_agent' => $user_agent,
                'titulo' => $titulo,
                'fecha_ingreso' => $fecha_ingreso,
                'fecha_salida' => $fecha_salida
            ),
            function ($msj) use ($correos_users_1 ,$correos_users_2, $correos_users_4, $correos_users_5, $correos_users_7, 
            $correos_users_8, $correos_users_9, $correos_users_10, $correos_users_6, $correos_users_11, $correos_users_12, 
            $correos_users_13, $correos_users_14, $correos_users_15, 
            $user_logueado) {
                $msj->subject('NOTIFICACIÓN DE SALIDA');
                $msj->from($correos_users_6);
                $msj->to($correos_users_1);
                $msj->to($correos_users_2);
                $msj->cc($correos_users_4);
                $msj->cc($correos_users_5);
                $msj->cc($correos_users_7);
                $msj->cc($correos_users_8);
                $msj->cc($correos_users_9);
                $msj->cc($correos_users_10);
                $msj->cc($correos_users_11);
                $msj->cc($correos_users_12);
                $msj->cc($correos_users_13);
                $msj->cc($correos_users_14);
                $msj->cc($correos_users_15);
                $msj->cc($correos_users_6);
            }
        );
    }

    public function enviar_correo_reingreso($id_empleado)
    {
        $user_logueado = session::get('usuario');
        //$json = $this->get_empleados_id($id_empleado);
        $json = DB::connection('pgsql')->select("select * from view_empleados where emp_id = " . $id_empleado);

        //$sql = DB::Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);

        /* $array_data = [];
         $data = array_push($array_data, $json);
         $j = $json->original;
         $data = $j['data'];*/
        foreach ($json as $value) {
            $cedula = $value->emp_cedula;
            $nombres = $value->emp_nombre;
            $apellidos = $value->emp_apellido;
            $telefono = $value->emp_telefono;
            $direccion = $value->dep_departamento;
            $jefatura = $value->per_perfil;
            $cargo = $value->emp_cargo;
            $titulo = $value->emp_titulo;
            $fecha_ingreso = $value->emp_fecha_ingreso;
        }

        $correos_users_1 = 'joaquin.flores@movilidadmanta.gob.ec';
        $correos_users_2 = 'gema.molina@movilidadmanta.gob.ec';
        //$correos_users_3 = 'genesis.zambrano@movilidadmanta.gob.ec';
        $correos_users_4 = 'freddy.cedeno@movilidadmanta.gob.ec';
        $correos_users_5 = 'edison.benitez@movilidadmanta.gob.ec';
        $correos_users_6 = 'virginia.torres@movilidadmanta.gob.ec';
        $correos_users_7 = 'maria.molina@movilidadmanta.gob.ec';
        $correos_users_8 = 'esteban.pena@movilidadmanta.gob.ec';
        $correos_users_9 = 'nelly.lugo@movilidadmanta.gob.ec';
        $correos_users_10 = 'tecnologia.intervencion@movilidadmanta.gob.ec';
        $correos_users_11 = 'elizabeth.godoy@movilidadmanta.gob.ec';
        $correos_users_12 = 'christian.villagomez@movilidadmanta.gob.ec';
        $correos_users_13 = 'maria.acosta@movilidadmanta.gob.ec';
        $correos_users_14 = 'maria.ponce@movilidadmanta.gob.ec';
        $correos_users_15 = 'maria.sanchez@movilidadmanta.gob.ec';
        $iptolocation = 'http://www.ip-api.com/json';
        $creatorlocation = file_get_contents($iptolocation);
        $usr = json_decode($creatorlocation);
        $country = $usr->country;
        $ip_publica = $usr->query;
        $host = $usr->isp;
        $city = $usr->city;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        /*$cedula = $request->input('txt-cedula');
        $nombre_apellido = $request->input('txt-nombre').' '.$request->input('txt-apellido');
        $telefono = $request->input('txt-telefono');
        $direccion = $request->input('txt-telefono');*/


        $em = Mail::send(
            'Administrador.Email.view_email_notificacion_reingreso_empleado',
            array(
                'fecha' => date('d-m-Y h:s:m'),
                'country' => $country,
                'ip_publica' => $ip_publica,
                'host' => $host,
                'city' => $city,
                'nombres' => $apellidos . ' ' . $nombres,
                'cedula' => $cedula,
                'telefono' => $telefono,
                'direccion' => $direccion,
                'jefatura' => $jefatura,
                'cargo' => $cargo,
                'user_agent' => $user_agent,
                'titulo' => $titulo,
                'fecha_ingreso' => $fecha_ingreso
            ),
            function ($msj) use ($correos_users_1 ,$correos_users_2, $correos_users_4, $correos_users_5, $correos_users_7, $correos_users_8, $correos_users_9, $correos_users_10, $correos_users_6, $correos_users_11, $correos_users_12, $user_logueado) {
                $msj->subject('NOTIFICACIÓN DE REINGRESO');
                $msj->from($correos_users_6);
                $msj->to($correos_users_1);
                $msj->to($correos_users_2);
                $msj->cc($correos_users_4);
                $msj->cc($correos_users_5);
                $msj->cc($correos_users_7);
                $msj->cc($correos_users_8);
                $msj->cc($correos_users_9);
                $msj->cc($correos_users_10);
                $msj->cc($correos_users_11);
                $msj->cc($correos_users_12);
                $msj->cc($correos_users_13);
                $msj->cc($correos_users_14);
                $msj->cc($correos_users_15);
            }
        );
    }

    public function get_empleados_id($id_empleado)
    {
        $sql = DB::Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }


    public function delete_notificacion(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-empleado-e')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_eliminar_notificacion(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_notificacion;
        }
        if ($sql != "[]") {
            $this->enviar_correo_reingreso($request->input('txt-id-empleado-e'));
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
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
