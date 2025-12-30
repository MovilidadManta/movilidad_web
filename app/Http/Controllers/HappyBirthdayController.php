<?php

namespace App\Http\Controllers;

use Session;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HappyBirthdayController extends Controller
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

    public function index_cumple()
    {
        $sql = DB::Select('select public.cursor_listar_empleados()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_usuarios;
        }
        $json_data = json_decode($data);

        $fecha_actual = date('Y-m-d');
        $fe_nac_actual_ = explode("-", $fecha_actual);
        $mes_dia_actual = $fe_nac_actual_[1] . '-' . $fe_nac_actual_[2];

        $data_cumple = [];
        foreach ($json_data as $value) {
            $fe_na = $value->emp_fecha_nacimiento;
            $fe_nac_ = explode("-", $fe_na);
            $mes_dia_nacimiento = $fe_nac_[1] . '-' . $fe_nac_[2];
            if ($mes_dia_nacimiento == $mes_dia_actual) {
                array_push($data_cumple, $value);
            }
        }
        return view('Administrador.Email.view_email_happy_birthday', compact('data_cumple'));
    }

    public function enviar_correo_happy_birthday()
    {
        //$sql = DB::Select('select public.cursor_listar_usuarios()');
        //$sql = DB::Select('select public.cursor_listar_usuarios()');
        $sql_empleados = DB::connection('pgsql')->select("select * from view_listar_empleados");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_usuarios;
        }
        $json_data = json_decode($data);*/

        $fecha_actual = date('Y-m-d');
        $fe_nac_actual_ = explode("-", $fecha_actual);
        $mes_dia_actual = $fe_nac_actual_[1] . '-' . $fe_nac_actual_[2];

        // return $mes_dia_actual;

        $data_cumple = [];
        foreach ($sql_empleados as $value) {
            $fe_na = $value->emp_fecha_nacimiento;
            $fe_nac_ = explode("-", $fe_na);
            $mes_dia_nacimiento = $fe_nac_[1] . '-' . $fe_nac_[2];
            if ($mes_dia_nacimiento == $mes_dia_actual) {
                array_push($data_cumple, $value);
            }
        }

        $json_data_cumple = json_decode(json_encode($data_cumple));
        $correos_users_1 = 'yandry.navarrete@movilidadmanta.gob.ec';

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
        if ($data_cumple != '[]') {
            $em = Mail::send(
                'Administrador.Email.view_email_happy_birthday',
                array(
                    'fecha' => date('d-m-Y h:s:m'),
                    'country' => $country,
                    'ip_publica' => $ip_publica,
                    'host' => $host,
                    'city' => $city,
                    'data_cumple' => $data_cumple
                ),
                function ($msj) use ($correos_users_1, $sql_empleados) {
                    $msj->subject('HAPPY BIRTHDAY');
                    $msj->from($correos_users_1);
                    foreach ($sql_empleados as $data) {
                        $msj->to($data->correo);
                    }
                    //$msj->to($correos_users_1);
                }
            );

            foreach ($data_cumple as $data) {
                $correo = $data->correo;
                $nuevaruta = public_path('/imagenes_empleados/' . $value->emp_ruta_foto);
                if (File::exists($nuevaruta)) {
                    $value->emp_estado_ruta_foto = true;
                } else {
                    $value->emp_estado_ruta_foto = false;
                }
                $estado_ruta_foto = $value->emp_estado_ruta_foto;
                $ruta_foto = $data->emp_ruta_foto;
                $nombre = $data->emp_nombre;
                $apellido = $data->emp_apellido;

                $em = Mail::send(
                    'Administrador.Email.view_email_happy_birthday_individual',
                    array(
                        'fecha' => date('d-m-Y h:s:m'),
                        'country' => $country,
                        'ip_publica' => $ip_publica,
                        'host' => $host,
                        'city' => $city,
                        'data_cumple' => $data_cumple,
                        'nombre' => $nombre,
                        'apellido' => $apellido,
                        'ruta_foto' => $ruta_foto,
                        'estado_ruta_foto' => $estado_ruta_foto
                    ),
                    function ($msj) use ($correos_users_1, $correo) {
                        $msj->subject('HAPPY BIRTHDAY');
                        $msj->from($correos_users_1);
                        $msj->to($correo);
                        //$msj->to($correos_users_1);
                    }
                );
            }
            return $data_cumple;
        } else {
            return 'No se ha enviado correos de cumpleaños';
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