<?php

namespace App\Http\Controllers;

use Session;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;
use File;
use Carbon\Carbon;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use App\Helpers\DatesHelper;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Empleado.empleado', compact('menus_'));
    }

    public function index_registrar_empleado()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Empleado.registrar_empleado', compact('menus_'));
    }

    public function index_registrar_acuerdo_empleado()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Empleado.registrar_acuerdo_empleado', compact('menus_'));
    }

    public function index_modificar_empleado($id)
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Empleado.modificar_empleado', compact("id", 'menus_'));
    }

    public function get_empleados()
    {
        //$sql = DB::connection('pgsql')->Select('select public.cursor_listar_empleados()');
        $sql = DB::connection('pgsql')->select("select * from view_empleados_t");
        //return $sql;
        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados;
        }*/
        /*$json_data = json_decode($data);*/
        $json_data = $sql;
        foreach ($json_data as $value) {
            $nuevaruta = public_path('/imagenes_empleados/' . $value->emp_ruta_foto);
            if (File::exists($nuevaruta)) {
                $value->emp_estado_ruta_foto = true;
            } else {
                $value->emp_estado_ruta_foto = false;
            }
        }

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_direcciones()
    {
        $sql = DB::connection('pgsql')->Select('select public.cursor_listar_direcciones()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_direcciones;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_subdirecciones($id_direccion)
    {
        $sql = DB::connection('pgsql')->Select('select public.cursor_listar_jefaturas_subdirecciones(?)', [$id_direccion]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_jefaturas_subdirecciones;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_cargos_update($id_direccion, $id_jefatura, $id_cargo_superior)
    {
        /*$sql = DB::connection('pgsql')->Select('select public.cursor_listar_jefaturas_subdirecciones(?)', [$id_direccion,$id_jefatura]);*/
        $sql = DB::connection('pgsql')->select("select * from view_cargos where ca_id_direccion = " . $id_direccion . " and ca_id_jefatura = " . $id_jefatura . "");
        $cargo_superior = DB::connection('pgsql')->select("select * from view_cargos where ca_id = " . $id_cargo_superior . "");

        /* foreach ($sql as $r) {
             $data = $r->cursor_listar_jefaturas_subdirecciones;
         }
         $json_data = json_decode($data);*/
        foreach ($cargo_superior as $value) {
            array_push($sql, $value);
        }
        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_cargos($id_direccion, $id_jefatura)
    {
        /*$sql = DB::connection('pgsql')->Select('select public.cursor_listar_jefaturas_subdirecciones(?)', [$id_direccion,$id_jefatura]);*/
        $sql = DB::connection('pgsql')->select("select * from view_cargos where ca_id_direccion = " . $id_direccion . " and ca_id_jefatura = " . $id_jefatura . "");
        //$cargo_superior = DB::connection('pgsql')->select("select * from view_cargos where ca_id = " . $id_cargo_superior . "");

        /* foreach ($sql as $r) {
             $data = $r->cursor_listar_jefaturas_subdirecciones;
         }
         $json_data = json_decode($data);*/
        /*foreach ($cargo_superior as $value) {
            array_push($sql, $value);
        }*/
        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_cargos_superior($id_cargo)
    {
        $cargo_superior = DB::connection('pgsql')->select("select * from view_cargos where ca_id = " . $id_cargo . "");

        /* foreach ($sql as $r) {
             $data = $r->cursor_listar_jefaturas_subdirecciones;
         }
         $json_data = json_decode($data);*/
        foreach ($cargo_superior as $value) {
            $cargo_superior = DB::connection('pgsql')->select("select * from view_cargos where ca_id = " . $value->ca_id_cargo_superior . "");
        }
        $json_data = $cargo_superior;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }


    public function get_empleado_subdirecciones($id_direccion)
    {
        $sql = DB::connection('pgsql')->Select('select public.cursor_listar_empleado_jefaturas_subdirecciones(?)', [$id_direccion]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleado_jefaturas_subdirecciones;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_empleado(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $fecha_salida = "1000-01-01";
        $user_logueado = session::get('usuario');
        //return $user;

        if ($request->input('txt-fecha-salida') != "") {
            $fecha_salida = $request->input('txt-fecha-salida');
        }
        $data = $request->input('txt-prioridad');
        if ($data == "[]") {
            $data = null;
        }

        $imagen = $request->file('txt-ruta-foto');
        if ($imagen == "") {
            return response()->json(["respuesta" => "imagen_vacia"]);
        } else if ($imagen != null) {
            $nacimiento = new DateTime($request->input("txt-fecha-nacimiento"));
            $ahora = new DateTime(date("Y-m-d"));
            $diferencia = $ahora->diff($nacimiento);
            $edad_actual = $diferencia->format("%y");

            //$nombreimagen   =   Str::slug("") . $request->input('txt-cedula') . '.' . $imagen->getClientOriginalExtension();
            $nombreimagen = $request->input('txt-cedula') . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta = public_path('/imagenes_empleados/' . $nombreimagen);
            copy($imagen->getRealPath(), $nuevaruta);

            $json[] = [
                'cedula' => $request->input('txt-cedula'),
                'nombre' => $request->input('txt-nombre'),
                'apellido' => $request->input('txt-apellido'),
                'telefono' => $request->input('txt-telefono'),
                'sexo' => $request->input('select-sexo'),
                'direccion' => $request->input('select-direccion'),
                'jefatura_direccion' => $request->input('select-jefatura-subdireccion'),
                'tipo_contrato' => $request->input('select-tipo-contrato'),
                'regimen_contrato' => $request->input('select-regimen-contrato'),
                'remuneracion' => $request->input('txt-remuneracion'),
                'fecha_ingreso' => $request->input('txt-fecha-ingreso'),
                'fecha_salida' => $fecha_salida,
                'direccion_domicilio' => $request->input('txt-direccion-domicilio'),
                'observacion' => $request->input('txt-observacion'),
                'cargo_te' => $request->input('text-cargo'),
                'cargo' => $request->input('select-cargo'),
                //'cargo_superior' => $request->input('select-cargo-superior'),
                'edad' => $edad_actual,
                'titulo' => $request->input('txt-titulo'),
                'fecha_nacimiento' => $request->input("txt-fecha-nacimiento"),
                'ruta_foto' => $nombreimagen,
                'tipo_sangre' => $request->input('txt-tipo-sangre')
            ];
            $jsoninsert = json_encode($json);


            $sql = DB::connection('pgsql')->Select('select public.procedimiento_registrar_datos_empleado(?,?,?,?,?)', [$jsoninsert, $data, $ip, $user, 0]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_empleado;
            }

            if ($sql != "[]") {
                if ($id == "empleado_registrado") {
                    return response()->json(["data" => $id, ""]);
                } else {
                    $this->enviar_correo($id);
                    return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
                }
            } else {
                return response()->json(["respuesta" => "false"]);
            }

            /*$sql_biometrico = DB::connection('pgsqlBiometrico')->select('select public.procedimiento_registrar_datos_empleado_biometrico(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql_biometrico as $s) {
                $id_biometrico = $s->procedimiento_registrar_datos_empleado_biometrico;
            }

            if ($id_biometrico != []) {
                $sql = DB::Select('select public.procedimiento_registrar_datos_empleado(?,?,?,?,?)', [$jsoninsert, $data, $ip, $user, $id_biometrico]);

                //$sql_2 = DB::Select('select public.procedimiento_registrar_datos_empleado_prioritarios(?,?,?)', [$data, $ip, $user]);
                foreach ($sql as $s) {
                    $id = $s->procedimiento_registrar_datos_empleado;
                }
                if ($sql != "[]") {
                    if ($id == "empleado_registrado") {
                        return response()->json(["data" => $id,""]);
                    } else {
                        $this->enviar_correo($id);
                        return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
                    }
                } else {
                    return response()->json(["respuesta" => "false"]);
                }
            } else {
                return response()->json(['respuesta' => 'false_biometrico']);
            }*/
        }
    }

    public function enviar_correo($id_empleado)
    {
        $user_logueado = session::get('usuario');
        $json = $this->get_empleados_id($id_empleado);
        //$sql = DB::connection('pgsql')->Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);
        $array_data = [];
        $data = array_push($array_data, $json);
        $j = $json->original;
        $data = $j['data'];
        foreach ($data as $value) {
            $cedula = $value->emp_cedula;
            $nombres = $value->emp_nombre;
            $apellidos = $value->emp_apellido;
            $telefono = $value->emp_telefono;
            $direccion = $value->dep_departamento;
            $jefatura = $value->per_perfil;
            $cargo = $value->emp_cargo;
            $titulo = $value->emp_titulo;
        }
        $correos_users_1 = 'gema.molina@movilidadmanta.gob.ec';
        $correos_users_2 = 'joaquin.flores@movilidadmanta.gob.ec';
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
            'Administrador.Email.view_email_empleado',
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
                'titulo' => $titulo
            ),
            function ($msj) use ($correos_users_1, $correos_users_2, $correos_users_4, $correos_users_5, 
            $correos_users_6, $correos_users_7, $correos_users_8, 
            $correos_users_9, $correos_users_10, $correos_users_11, 
            $correos_users_12, $correos_users_13, $correos_users_14,
            $correos_users_15, $user_logueado) {
                //function ($msj) use ($correos_users_1, $user_logueado) {
                $msj->subject('CREACIÓN DE CORREO Y GESTOR DOCUMENTAL');
                $msj->from($user_logueado);
                $msj->to($correos_users_1);
                $msj->to($correos_users_2);
                $msj->to($correos_users_5);
                $msj->cc($correos_users_6);
                $msj->cc($correos_users_7);
                $msj->cc($correos_users_8);
                $msj->cc($correos_users_4);
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


    public function enviar_correo_cambio_cargo($id_empleado)
    {
        $user_logueado = session::get('usuario');
        $json = $this->get_empleados_id($id_empleado);
        //$sql = DB::connection('pgsql')->Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);
        $array_data = [];
        $data = array_push($array_data, $json);
        $j = $json->original;
        $data = $j['data'];
        foreach ($data as $value) {
            $cedula = $value->emp_cedula;
            $nombres = $value->emp_nombre;
            $apellidos = $value->emp_apellido;
            $telefono = $value->emp_telefono;
            $direccion = $value->dep_departamento;
            $jefatura = $value->per_perfil;
            $cargo = $value->emp_cargo;
            $titulo = $value->emp_titulo;
        }
        $correos_users_1 = 'gema.molina@movilidadmanta.gob.ec';
        $correos_users_2 = 'joaquin.flores@movilidadmanta.gob.ec';
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
            'Administrador.Email.view_email_cambio_cargo_empleado',
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
                'titulo' => $titulo
            ),
            function ($msj) use ($correos_users_1, $correos_users_2, $correos_users_4, $correos_users_5, 
            $correos_users_6, $correos_users_7, $correos_users_8, $correos_users_9, $correos_users_10, 
            $correos_users_11, $correos_users_12, $correos_users_13, $correos_users_14, $correos_users_15, 
            $user_logueado) {
                //function ($msj) use ($correos_users_1, $user_logueado) {
                $msj->subject('CAMBIO DE CARGO DE EMPLEADO');
                $msj->from($user_logueado);
                $msj->to($correos_users_1);
                $msj->to($correos_users_2);
                $msj->to($correos_users_5);
                $msj->cc($correos_users_6);
                $msj->cc($correos_users_7);
                $msj->cc($correos_users_8);
                $msj->cc($correos_users_4);
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

    public function reenviar_correo($id_empleado)
    {
        $user_logueado = session::get('usuario');
        $json = $this->get_empleados_id($id_empleado);
        //$sql = DB::connection('pgsql')->Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);
        $array_data = [];
        $data = array_push($array_data, $json);
        $j = $json->original;
        $data = $j['data'];
        foreach ($data as $value) {
            $cedula = $value->emp_cedula;
            $nombres = $value->emp_nombre;
            $apellidos = $value->emp_apellido;
            $telefono = $value->emp_telefono;
            $direccion = $value->dep_departamento;
            $jefatura = $value->per_perfil;
            $cargo = $value->emp_cargo;
            $titulo = $value->emp_titulo;
        }
        //$correos_users_1 = 'yandry.navarrete@movilidadmanta.gob.ec';
        $correos_users_2 = 'gema.molina@movilidadmanta.gob.ec';
        $correos_users_3 = 'genesis.zambrano@movilidadmanta.gob.ec';
        $correos_users_4 = 'freddy.cedeno@movilidadmanta.gob.ec';
        $correos_users_5 = 'yandry.macias@movilidadmanta.gob.ec';
        $correos_users_6 = 'virginia.torres@movilidadmanta.gob.ec';
        $correos_users_7 = 'maria.molina@movilidadmanta.gob.ec';
        $correos_users_8 = 'gustavo.coello@movilidadmanta.gob.ec';
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
            'Administrador.Email.view_email_empleado',
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
                'titulo' => $titulo
            ),
            function ($msj) use ($correos_users_2, $correos_users_3, $correos_users_4, $correos_users_5, $correos_users_6, $correos_users_7, $correos_users_8, $user_logueado) {
                //function ($msj) use ($correos_users_1, $user_logueado) {
                $msj->subject('CREACIÓN DE CORREO Y GESTOR DOCUMENTAL');
                $msj->from($user_logueado);
                //$msj->to($correos_users_1);
                $msj->to($correos_users_2);
                $msj->to($correos_users_5);
                $msj->cc($correos_users_6);
                $msj->cc($correos_users_7);
                $msj->cc($correos_users_8);
                $msj->cc($correos_users_3);
                $msj->cc($correos_users_4);
            }
        );
    }



    public function delete_empleado_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_empleado' => $request->input('txt-id-empleado')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql')->Select('select public.procedimiento_eliminar_datos_empleado(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_empleado;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_empleados_tipo($tipo, $valor)
    {
        /**if ($tipo == 1) {
            $sql = DB::Select('select public.cursor_listar_empleados_tipo_cedula(?)', [$valor]);
            foreach ($sql as $r) {
                $data = $r->cursor_listar_empleados_tipo_cedula;
            }
            $json_data = json_decode($data);
        } else if ($tipo == 2) {
            $sql = DB::Select('select public.cursor_listar_empleados_tipo_nombres(?)', [$valor]);
            foreach ($sql as $r) {
                $data = $r->cursor_listar_empleados_tipo_nombres;
            }
            $json_data = json_decode($data);
        }*/
        $sql = DB::connection('pgsql')->Select('select public.cursor_listar_empleados_tipo_nombres(?)', [$valor]);
        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_tipo_nombres;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => 'true']);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_empleados_id($id_empleado)
    {
        //$sql = DB::connection('pgsql')->Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);
        $sql = DB::connection('pgsql')->select("select * from view_empleados_t where emp_id= $id_empleado");

        /**foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id;
        }
        $json_data = json_decode($data);*/
        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_empleados_modificar_id($id_empleado)
    {
        $sql = DB::connection('pgsql')->select("select * from view_empleados_t where emp_id= $id_empleado");
        // $sql_2 = DB::connection('pgsql')->select("select * from view_empleados_t where emp_id= $id_empleado");
        //$sql = DB::connection('pgsql')->Select('select public.cursor_listar_empleados_modificar_id(?)', [$id_empleado]);
        $sql_2 = DB::connection('pgsql')->Select('select public.cursor_listar_empleados_modificar_id_prioridad(?)', [$id_empleado]);
        //return $sql;
        $array_prioritario = [];

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_modificar_id;
        }*/
        $json_data = $sql;
        $arra_da = [];
        if ($json_data != "[]") {
            if ($sql_2 == null) {
                $arra_da = "vacio";
            } else {
                foreach ($sql_2 as $r2) {
                    $data_prioridades = $r2->cursor_listar_empleados_modificar_id_prioridad;
                }
                $json_data_prioridades = json_decode($data_prioridades, true);
                if ($json_data_prioridades == "") {
                    $arra_da = "vacio";
                } else {
                    $array_u = [];
                    $array_pri = [];
                    for ($i = 0; $i < count($json_data_prioridades); $i++) {
                        array_push($array_u, $json_data_prioridades[$i]['gru_id_prioridad']);
                    }
                    $array_unique = array_unique($array_u);


                    $cont = 1;
                    $array_unique_ordenado = array_keys(array_count_values($array_unique));
                    for ($x = 0; $x < count($array_unique_ordenado); $x++) {
                        $array_pri = [];
                        for ($i = 0; $i < count($json_data_prioridades); $i++) {
                            if ($array_unique_ordenado[$x] == $json_data_prioridades[$i]['gru_id_prioridad']) {
                                array_push(
                                    $array_pri,
                                    $json_data_prioridades[$i]['gru_id_prioridad'],
                                    $json_data_prioridades[$i]['gru_id_empleado'],
                                    $json_data_prioridades[$i]['gru_descripcion'],
                                    $json_data_prioridades[$i]['gru_valor']
                                );
                            }
                        }
                        array_push($array_prioritario, $array_pri);
                        $cont = $cont + 1;
                    }
                }

                foreach ($array_prioritario as $value) {
                    $arr = array_keys(array_count_values($value));
                    $arra = implode(",", $arr);
                    $arra1 = explode(",", $arra);
                    $a = [
                        'id_prioridad' => $arra1[0],
                        'id_empleado' => $arra1[1],
                        'descripcion_1' => $arra1[2],
                        'valor_1' => $arra1[3],
                        'descripcion_2' => $arra1[4],
                        'valor_2' => $arra1[5]
                    ];
                    array_push($arra_da, $a);
                }
            }
            return response()->json(['data' => $json_data, 'data_prioridad' => $arra_da, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_empleado(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $fecha_salida = "1000-01-01";
        $nacimiento = new DateTime($request->input("txt-fecha-nacimiento"));
        $ahora = new DateTime(date("Y-m-d"));
        $diferencia = $ahora->diff($nacimiento);
        $edad_actual = $diferencia->format("%y");

        if ($request->input('txt-fecha-salida') != "") {
            $fecha_salida = $request->input('txt-fecha-salida');
        }

        $data = $request->input('txt-prioridad-modificar');
        if ($data == "") {
            $data = null;
        }
        $imagen = $request->file('txt-ruta-foto');

        if ($imagen != "") {
            //$nombreimagen   =   Str::slug("") . $request->input('txt-cedula') . '.' . $imagen->getClientOriginalExtension();
            $nombreimagen = $request->input('txt-cedula') . '.' . $imagen->getClientOriginalExtension();
            $nuevaruta = public_path('/imagenes_empleados/' . $nombreimagen);
            if (File::exists($nuevaruta)) {
                unlink($nuevaruta);
            }
            copy($imagen->getRealPath(), $nuevaruta);
            $json[] = [
                'id' => $request->input('txt-id-empleado'),
                'id_biometrico' => $request->input('txt-id-empleado-biometrico'),
                'cedula' => $request->input('txt-cedula'),
                'nombre' => $request->input('txt-nombre'),
                'apellido' => $request->input('txt-apellido'),
                'telefono' => $request->input('txt-telefono'),
                'sexo' => $request->input('select-sexo'),
                'direccion' => $request->input('select-direccion'),
                'jefatura_direccion' => $request->input('select-jefatura-subdireccion'),
                'tipo_contrato' => $request->input('select-tipo-contrato'),
                'regimen_contrato' => $request->input('select-regimen-contrato'),
                'remuneracion' => $request->input('txt-remuneracion'),
                'fecha_ingreso' => $request->input('txt-fecha-ingreso'),
                'fecha_salida' => $fecha_salida,
                'direccion_domicilio' => $request->input('txt-direccion-domicilio'),
                'observacion' => $request->input('txt-observacion'),
                'cargo_te' => $request->input('text-cargo-m'),
                'cargo' => $request->input('select-cargo-m'),
                'edad' => $edad_actual,
                'titulo' => $request->input('txt-titulo'),
                'fecha_nacimiento' => $request->input("txt-fecha-nacimiento"),
                'ruta_foto' => $nombreimagen,
                'tipo_sangre' => $request->input('txt-tipo-sangre')
            ];
            $jsoninsert = json_encode($json);

            return $jsoninsert;

            $sql = DB::connection('pgsql')->Select('select public.procedimiento_modificar_datos_empleado(?,?,?,?)', [$jsoninsert, $data, $ip, $user]);
            //$sql_2 = DB::Select('select public.procedimiento_registrar_datos_empleado_prioritarios(?,?,?)', [$data, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_modificar_datos_empleado;
            }
            if ($sql != "[]") {
                if($request->input('text-cargo-m') != $request->input('select-cargo-m')){
                    $this->enviar_correo_cambio_cargo($id_empleado);
                }
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
            /*$sql_biometrico = DB::connection('pgsqlBiometrico')->Select('select public.procedimiento_modificar_datos_empleado_biometrico(?,?,?)', [$jsoninsert, $ip, $user]);
            if ($sql_biometrico != []) {
                $sql = DB::Select('select public.procedimiento_modificar_datos_empleado(?,?,?,?)', [$jsoninsert, $data, $ip, $user]);
                //$sql_2 = DB::Select('select public.procedimiento_registrar_datos_empleado_prioritarios(?,?,?)', [$data, $ip, $user]);
                foreach ($sql as $s) {
                    $id = $s->procedimiento_modificar_datos_empleado;
                }
                if ($sql != "[]") {
                    return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
                } else {
                    return response()->json(["respuesta" => "false"]);
                }
            }*/
        } else {
            $json[] = [
                'id' => $request->input('txt-id-empleado'),
                'id_biometrico' => $request->input('txt-id-empleado-biometrico'),
                'cedula' => $request->input('txt-cedula'),
                'nombre' => $request->input('txt-nombre'),
                'apellido' => $request->input('txt-apellido'),
                'telefono' => $request->input('txt-telefono'),
                'sexo' => $request->input('select-sexo'),
                'direccion' => $request->input('select-direccion'),
                'jefatura_direccion' => $request->input('select-jefatura-subdireccion'),
                'tipo_contrato' => $request->input('select-tipo-contrato'),
                'regimen_contrato' => $request->input('select-regimen-contrato'),
                'remuneracion' => $request->input('txt-remuneracion'),
                'fecha_ingreso' => $request->input('txt-fecha-ingreso'),
                'fecha_salida' => $fecha_salida,
                'direccion_domicilio' => $request->input('txt-direccion-domicilio'),
                'observacion' => $request->input('txt-observacion'),
                'cargo_te' => $request->input('text-cargo-m'),
                'cargo' => $request->input('select-cargo-m'),
                'cargo_superior' => $request->input('select-cargo-superior-m'),
                'edad' => $edad_actual,
                'titulo' => $request->input('txt-titulo'),
                'fecha_nacimiento' => $request->input("txt-fecha-nacimiento"),
                'tipo_sangre' => $request->input('txt-tipo-sangre')
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql')->Select('select public.procedimiento_modificar_datos_empleado(?,?,?,?)', [$jsoninsert, $data, $ip, $user]);
            //$sql_2 = DB::Select('select public.procedimiento_registrar_datos_empleado_prioritarios(?,?,?)', [$data, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_modificar_datos_empleado;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
            /*$sql_biometrico = DB::connection('pgsqlBiometrico')->Select('select public.procedimiento_modificar_datos_empleado_biometrico(?,?,?)', [$jsoninsert, $ip, $user]);
            if ($sql_biometrico != []) {
                $sql = DB::Select('select public.procedimiento_modificar_datos_empleado(?,?,?,?)', [$jsoninsert, $data, $ip, $user]);
                //$sql_2 = DB::Select('select public.procedimiento_registrar_datos_empleado_prioritarios(?,?,?)', [$data, $ip, $user]);
                foreach ($sql as $s) {
                    $id = $s->procedimiento_modificar_datos_empleado;
                }
                if ($sql != "[]") {
                    return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
                } else {
                    return response()->json(["respuesta" => "false"]);
                }
            }*/
        }
    }

    public function get_verificar_empleado_id_p($id_empleado)
    {

        $hashids = new \Hashids\Hashids('app-100', 8);
        $id_ = substr(implode(" ", $hashids->decode($id_empleado)), 4);


        $sql = DB::connection('pgsql')->Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id;
        }
        $json_data = json_decode($data);

        foreach ($json_data as $value) {
            $id = $value->emp_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_empleado_hash = $id_;
        }
        return $json_data;
        return view('Administrador.Empleado.empleado_credencial', compact('json_data'));
    }

    public function get_verificar_empleado_id($id_empleado)
    {

        $hashids = new \Hashids\Hashids('app-100', 8);
        $id_ = substr(implode(" ", $hashids->decode($id_empleado)), 4);

        $sql = DB::connection('pgsql')->Select('select public.cursor_listar_empleados_id(?)', [$id_]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id;
        }
        $json_data = json_decode($data);

        foreach ($json_data as $value) {
            $id = $value->emp_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_empleado_hash = $id_;
        }
        return view('Administrador.Empleado.empleado_credencial', compact('json_data'));
    }


    public function get_vacaciones()
    {
        $empleados = DB::select("select e.emp_id, e.emp_id_regimen_contractual,e.emp_fecha_ingreso,e.emp_cedula, e.emp_nombre, e.emp_apellido, sum(ep.valor) as Dias from tbl_empleados e 
            LEFT JOIN tbl_empleados_periodos ep ON CAST(e.emp_cedula AS integer) = ep.id_empleado 
            where  e.emp_estado = 'A' GROUP BY e.emp_id, e.emp_id_regimen_contractual,e.emp_fecha_ingreso,e.emp_cedula, e.emp_nombre, e.emp_apellido   ORDER BY emp_fecha_ingreso ");

        return $empleados;
    }
    public function vacaciones()
    {
        $date = Carbon::now();
        $anio_anterior = 2023;
        $año_actual = 2024;
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            /* $datos = Excel::toArray(new UsersImport, public_path('saldo.xlsx'));
            $datos = $datos[0];
            $con = 0;
            for ($x = 29; $x < sizeof($datos); $x++) {
                //print_r($datos[$x][1] . "-" . $datos[$x][5] . "\n");
                $date = Carbon::now();

                $v_vac = DB::select("select * from tbl_empleados_periodos where id_empleado = ? and id_periodo=2", [$datos[$x][1]]);
                //return $v_vac;
                if ($v_vac == []) {
                    $e_periodo =  DB::table("tbl_empleados_periodos")->insertGetId([
                        "id_empleado" => $datos[$x][1],
                        "id_periodo" => 2,
                        "valor" => $datos[$x][7],
                        "estado" => 1,
                        "estado_activacion" => 0,
                        "created_at" => $date
                    ]);
                    if ($e_periodo > 0) {
                        $con++;
                    }
                } else {
                    print_r("cedula ya registrada: " . $datos[$x][1]);
                }
            }

            return $con;*/

            /*$empleados = DB::select("select  e.emp_id_regimen_contractual,e.emp_cedula,concat(e.emp_nombre,' ', e.emp_apellido) empleado,e.emp_fecha_ingreso, ep.id_periodo,ep.valor
            from tbl_empleados_periodos ep
            RIGHT JOIN tbl_empleados e ON CAST(e.emp_cedula as integer) = ep.id_empleado  where  e.emp_estado='A' and  (ep.id_periodo IS NULL or ep.id_periodo=1)");*/

            /* $empleados = DB::select("select  e.emp_id_regimen_contractual,e.emp_cedula,concat(e.emp_nombre,' ', e.emp_apellido) empleado,e.emp_fecha_ingreso, epp.id_periodo as p2022, epp.valor as v2022, ep.id_periodo as p2023, ep.valor as v2023,
            (select edd.valor from tbl_empleado_detalle_descuentos edd where edd.id_periodo = epp.id_periodo and edd.id_empleado=epp.id_empleado) as des2022,
            (select edd.valor from tbl_empleado_detalle_descuentos edd where edd.id_periodo = ep.id_periodo and edd.id_empleado=ep.id_empleado) as des2023
            from tbl_empleados_periodos ep
            INNER JOIN tbl_empleados_periodos epp ON  ep.id_empleado= epp.id_empleado 
            RIGHT JOIN tbl_empleados e ON CAST(e.emp_cedula as integer) = ep.id_empleado  where  e.emp_estado='A' and ep.id_periodo=2
            and epp.id_periodo=1 ");*/

            $empleados = DB::select("select e.emp_id, e.emp_id_regimen_contractual,e.emp_fecha_ingreso,e.emp_cedula, e.emp_nombre, e.emp_apellido, sum(ep.valor) as Dias from tbl_empleados e 
            LEFT JOIN tbl_empleados_periodos ep ON CAST(e.emp_cedula AS integer) = ep.id_empleado 
            where  e.emp_estado = 'A' GROUP BY e.emp_id, e.emp_id_regimen_contractual,e.emp_fecha_ingreso,e.emp_cedula, e.emp_nombre, e.emp_apellido   ORDER BY emp_fecha_ingreso ");

            $total = DB::select('select SUM(id) from tbl_empleados_periodos_temp where estado=0');
            $total = $total[0];

            $hoy = $date->format('Y-m-d');
            $total_hoy = Db::select("select sum(id) from tbl_empleados_periodos_temp where estado=0 and created_at BETWEEN '" . $hoy . " 0:00:01' and '" . $hoy . " 23:59:59'");
            if ($total_hoy == []) {
                $total_hoy = 0;
            } else {
                $total_hoy = $total_hoy[0];
            }
            return view('Administrador.Vacaciones.index', compact('menus_', 'empleados', 'total', 'total_hoy'));


            $periodos = DB::select("select * from tbl_periodos");

            $empleados = DB::select("select e.emp_id, e.emp_id_regimen_contractual,e.emp_fecha_ingreso,e.emp_cedula, e.emp_nombre, e.emp_apellido, ep.valor from tbl_empleados e 
            LEFT JOIN tbl_empleados_periodos ep ON CAST(e.emp_cedula AS integer) = ep.id_empleado 
            where (ep.id_periodo = 1 or ep.id_periodo IS NULL) and e.emp_estado = 'A' and e.emp_cedula in ('1315298347','1312320466')   ORDER BY emp_fecha_ingreso ASC LIMIT 10");

            $data = [];
            $cont = 0;
            foreach ($empleados as $e) {
                $intervalDias = 0;
                $intervalMeses = 0;
                $intervalAnos = 0;
                if ($e->emp_id_regimen_contractual != 4) {
                    $f = explode("-", $e->emp_fecha_ingreso);
                    if ($f[0] <= $anio_anterior) {
                        $datetime3 = new DateTime("2023-" . $f[1] . "-" . $f[2] . " 00:00:00");
                        $datetime4 = new DateTime($date);
                        $interval = $datetime4->diff($datetime3);
                        $intervalDias = $interval->format("%d");
                        $intervalMeses = $interval->format("%m");
                        # obtenemos la diferencia en años y la multiplicamos por 12 para tener los meses
                        $intervalAnos = $interval->format("%y") * 12;
                    } else {
                        $datetime1 = new DateTime($e->emp_fecha_ingreso . " 00:00:00");
                        $datetime2 = new DateTime($date);

                        $interval = $datetime2->diff($datetime1);
                        $intervalDias = $interval->format("%d");
                        $intervalMeses = $interval->format("%m");

                        $intervalAnos = $interval->format("%y") * 12;
                    }

                    if ($e->emp_id_regimen_contractual == 1) {
                        $dias_p = ($intervalMeses + $intervalAnos) * 1.25;
                    } else if ($e->emp_id_regimen_contractual == 2 || $e->emp_id_regimen_contractual == 3) {
                        $dias_p = ($intervalMeses + $intervalAnos) * 2.5;
                    }

                    $ff = explode("-", $e->emp_fecha_ingreso);
                    $datetimei = new DateTime($date);
                    $datetimef = new DateTime("2024-" . $f[1] . "-" . $f[2] . " 00:00:00");
                    $intervalf = $datetimef->diff($datetimei);
                    $intervalDiasf = $intervalf->format("%d");
                    $intervalMesesf = $intervalf->format("%m");
                    $intervalAnosf = $intervalf->format("%y") * 12;


                    $data[] = [
                        "cedula" => $e->emp_cedula,
                        "fecha_ingreso" => $e->emp_fecha_ingreso,
                        "empleado" => $e->emp_nombre . ' ' . $e->emp_apellido,
                        "tipo" => $e->emp_id_regimen_contractual,
                        "dias_proximo_acreditar" => $dias_p,
                        "dias_faltantes_para_acreditar" => $intervalDiasf . " Dias, " . $intervalMesesf . " Mes, " . $intervalAnosf . " Año",
                        "periodos" => ""
                    ];
                    $d_periodos = [];
                    foreach ($periodos as $p) {
                        $data_periodo = DB::select("select * from tbl_empleados_periodos where id_periodo = ? and id_empleado=?", [$p->id, $e->emp_cedula]);
                        if ($data_periodo != []) {
                            if ($f[0] == $año_actual && $p->id == 3) {
                                $d_periodos[] = [
                                    "periodo" => $p->periodo,
                                    "id_periodo" => $p->id,
                                    "valor" => $dias_p,
                                    "estado" => 0
                                ];
                            } else {
                                foreach ($data_periodo as $dp) {
                                    $d_periodos[] = [
                                        "periodo" => $p->periodo,
                                        "id_periodo" => $p->id,
                                        "valor" => $dp->valor
                                    ];
                                }
                            }
                        } else {
                            if ($p->id == 3) {
                                $d_periodos[] = [
                                    "periodo" => $p->periodo,
                                    "id_periodo" => $p->id,
                                    "valor" => $dias_p,
                                    "estado" => 0
                                ];
                            } else {
                                $d_periodos[] = [
                                    "periodo" => $p->periodo,
                                    "id_periodo" => $p->id,
                                    "valor" => "",
                                ];
                            }
                        }
                    }
                    $data[$cont]['periodos'] = $d_periodos;
                    $cont++;
                }
            }


            return $data;
            /*$empleados = DB::select("select  e.emp_id_regimen_contractual,e.emp_cedula,concat(e.emp_nombre,' ', e.emp_apellido) empleado,e.emp_fecha_ingreso, epp.id_periodo as p2022, epp.valor as v2022, ep.id_periodo as p2023, ep.valor as v2023,
            (select edd.valor from tbl_empleado_detalle_descuentos edd where edd.id_periodo = epp.id_periodo and edd.id_empleado=epp.id_empleado) as des2022,
            (select edd.valor from tbl_empleado_detalle_descuentos edd where edd.id_periodo = ep.id_periodo and edd.id_empleado=ep.id_empleado) as des2023,
						emp_t.valor as nuevo_periodo
            from tbl_empleados_periodos ep
            INNER JOIN tbl_empleados_periodos epp ON  ep.id_empleado= epp.id_empleado 
            RIGHT JOIN tbl_empleados e ON CAST(e.emp_cedula as integer) = ep.id_empleado  
						LEFT JOIN tbl_empleados_periodos_temp emp_t ON ep.id_empleado = emp_t.id_empleado
						where  e.emp_estado='A' and ep.id_periodo=2
            and epp.id_periodo=1 ");*/

            // return $empleados;
            /*foreach ($empleados as $e) {
                if ($e->emp_id_regimen_contractual != 4) {


                    $f = explode("-", $e->emp_fecha_ingreso);
                    $periodo = "";
                    $intervalDias = 0;
                    $intervalMeses1 = 0;
                    $intervalAnos1 = 0;
                    if ($f[0] <= 2022) {
                        $datetime1 = new DateTime("2022-" . $f[1] . "-" . $f[2] . " 00:00:00");
                        $datetime2 = new DateTime("2023-" . $f[1] . "-" . $f[2] . "23:59:59");

                        $datetime3 = new DateTime("2023-" . $f[1] . "-" . $f[2] . " 00:00:00");
                        $datetime4 = new DateTime($date);

                        $interval1 = $datetime4->diff($datetime3);
                        $intervalMeses1 = $interval1->format("%m");
                        # obtenemos la diferencia en años y la multiplicamos por 12 para tener los meses
                        $intervalAnos1 = $interval1->format("%y") * 12;

                        if ($e->emp_id_regimen_contractual == 1) {
                            $e->nuevo_periodo = ($intervalMeses1 + $intervalAnos1) * 1.25;
                            } else if ($e->emp_id_regimen_contractual == 2 || $e->emp_id_regimen_contractual == 3) {
                            $e->nuevo_periodo = ($intervalMeses1 + $intervalAnos1) * 2.5;
                            }
                    } else {
                        $datetime1 = new DateTime($e->emp_fecha_ingreso . " 00:00:00");
                        $datetime2 = new DateTime($date);

                        $interval = $datetime2->diff($datetime1);
                       
                        $intervalMeses = $interval->format("%m");
                        # obtenemos la diferencia en años y la multiplicamos por 12 para tener los meses
                        $intervalAnos = $interval->format("%y") * 12;
                            if ($e->emp_id_regimen_contractual == 1) {
                                $e->nuevo_periodo = ($intervalMeses + $intervalAnos) * 1.25;
                                } else if ($e->emp_id_regimen_contractual == 2 || $e->emp_id_regimen_contractual == 3) {
                                $e->nuevo_periodo = ($intervalMeses + $intervalAnos) * 2.5;
                                }
                       
                    }
                    $e->dias_proximos = $intervalDias." dias ".$intervalMeses1 ." meses ". $intervalAnos1." años";
                }
            }*/
            //return $empleados;
            return view('Administrador.Vacaciones.index', compact('menus_', 'data'));
        } else {
            return view("Administrador.Login.login");
        }
    }

    public function getperiodos($cedula)
    {
        $anio_anterior = 2022;
        $año_actual = 2023;
        $date = Carbon::now();


        $periodos = DB::select("select * from tbl_periodos");

        $empleados = DB::select("select e.emp_id, e.emp_id_regimen_contractual,e.emp_fecha_ingreso,e.emp_cedula, e.emp_nombre, e.emp_apellido, ep.valor from tbl_empleados e 
        LEFT JOIN tbl_empleados_periodos ep ON CAST(e.emp_cedula AS integer) = ep.id_empleado 
        where (ep.id_periodo = 1 or ep.id_periodo IS NULL) and e.emp_estado = 'A' and e.emp_cedula in (?)   ORDER BY emp_fecha_ingreso ASC LIMIT 10", [$cedula]);

        $data = [];
        $cont = 0;
        foreach ($empleados as $e) {
            $intervalDias = 0;
            $intervalMeses = 0;
            $intervalAnos = 0;
            if ($e->emp_id_regimen_contractual != 4) {
                $f = explode("-", $e->emp_fecha_ingreso);
                if ($f[0] <= $anio_anterior) {
                    $datetime3 = new DateTime("2023-" . $f[1] . "-" . $f[2] . " 00:00:00");
                    $datetime4 = new DateTime($date);
                    $interval = $datetime4->diff($datetime3);
                    $intervalDias = $interval->format("%d");
                    $intervalMeses = $interval->format("%m");
                    # obtenemos la diferencia en años y la multiplicamos por 12 para tener los meses
                    $intervalAnos = $interval->format("%y") * 12;
                } else {
                    $datetime1 = new DateTime($e->emp_fecha_ingreso . " 00:00:00");
                    $datetime2 = new DateTime($date);

                    $interval = $datetime2->diff($datetime1);
                    $intervalDias = $interval->format("%d");
                    $intervalMeses = $interval->format("%m");

                    $intervalAnos = $interval->format("%y") * 12;
                }

                if ($e->emp_id_regimen_contractual == 1) {
                    $dias_p = ($intervalMeses + $intervalAnos) * 1.25;
                } else if ($e->emp_id_regimen_contractual == 2 || $e->emp_id_regimen_contractual == 3) {
                    $dias_p = ($intervalMeses + $intervalAnos) * 2.5;
                }

                $ff = explode("-", $e->emp_fecha_ingreso);
                $datetimei = new DateTime($date);
                $datetimef = new DateTime("2024-" . $f[1] . "-" . $f[2] . " 00:00:00");
                $intervalf = $datetimef->diff($datetimei);
                $intervalDiasf = $intervalf->format("%d");
                $intervalMesesf = $intervalf->format("%m");
                $intervalAnosf = $intervalf->format("%y") * 12;


                $data = [
                    "cedula" => $e->emp_cedula,
                    "fecha_ingreso" => $e->emp_fecha_ingreso,
                    "empleado" => $e->emp_nombre . ' ' . $e->emp_apellido,
                    "tipo" => $e->emp_id_regimen_contractual,
                    "dias_proximo_acreditar" => $dias_p,
                    "dias_faltantes_para_acreditar" => $intervalDiasf . " Dias, " . $intervalMesesf . " Mes, " . $intervalAnosf . " Año",
                    "periodos" => "",
                    "descuentos" => ""
                ];
                $d_periodos = [];
                $f_periodos = [];
                foreach ($periodos as $p) {
                    $desc_periodo = DB::select("select * from tbl_empleado_detalle_descuentos where id_empleado = ? and id_periodo = ?", [$e->emp_cedula, $p->id]);
                    if ($desc_periodo != []) {
                        foreach ($desc_periodo as $dp1) {
                            $f_periodos[] = [
                                "id_periodo" => $dp1->id_periodo,
                                "valor" => $dp1->valor,
                                "observacion" => $dp1->observacion,
                                "estado" => 1
                            ];
                        }
                    }
                    $data_periodo = DB::select("select * from tbl_empleados_periodos where id_periodo = ? and id_empleado=?", [$p->id, $e->emp_cedula]);
                    if ($data_periodo != []) {
                        if ($f[0] == $año_actual && $p->id == 3) {
                            $d_periodos[] = [
                                "periodo" => $p->periodo,
                                "id_periodo" => $p->id,
                                "valor" => $dias_p,
                                "estado" => 0
                            ];
                        } else {
                            foreach ($data_periodo as $dp) {
                                $d_periodos[] = [
                                    "periodo" => $p->periodo,
                                    "id_periodo" => $p->id,
                                    "valor" => $dp->valor,
                                    "estado" => 1
                                ];
                            }
                        }
                    } else {
                        if ($p->id == 3) {
                            $d_periodos[] = [
                                "periodo" => $p->periodo,
                                "id_periodo" => $p->id,
                                "valor" => $dias_p,
                                "estado" => 0
                            ];
                        } else {
                            $d_periodos[] = [
                                "periodo" => $p->periodo,
                                "id_periodo" => $p->id,
                                "valor" => 0,
                                "estado" => 1
                            ];
                        }
                    }
                }
                $data['periodos'] = $d_periodos;
                $data['descuentos'] = $f_periodos;
                // $cont++;
            }
        }


        return $data;
    }

    public function getdias($cedula)
    {
        $dias = DB::select('select sum(valor) as saldo from tbl_empleados_periodos where id_empleado = ?', [$cedula]);

        $periodo_activo = DB::select('select * from tbl_empleados_periodos where id_empleado = ? and estado_activacion=1', [$cedula]);
        return response()->json(['respuesta' => "true", "dias" => $dias, "periodo_activo" => $periodo_activo]);
    }

    public function get_dias_periodos()
    {
        $dias = DB::select("select ep.id, ep.id_empleado, e.emp_nombre, e.emp_apellido,e.emp_fecha_ingreso,ep.id_periodo,ep.valor, ep.estado, e.emp_id_regimen_contractual from tbl_empleados_periodos_temp ep 
        INNER JOIN tbl_empleados e ON CAST(e.emp_cedula AS integer) = ep.id_empleado and estado=0");
        return $dias;
    }

    public function aprobar_dias(Request $r)
    {
        $date = Carbon::now();

        $periodo = DB::select('select * from tbl_empleados_periodos_temp where id=?', [$r->id]);

        if ($periodo != []) {
            foreach ($periodo as $p) {
                $id_periodo = DB::table('tbl_empleados_periodos')->insertGetId([
                    'id_empleado' => $p->id_empleado,
                    'id_periodo' => $p->id_periodo,
                    'valor' => $p->valor,
                    'created_at' => $date,
                    'estado' => 1,
                    'estado_activacion' => 0
                ]);
                if ($id_periodo > 0) {
                    //eliminar el 
                    $sal = DB::update('update tbl_empleados_periodos_temp set estado=1 where id=?', [$r->id]);
                    return response()->json(['respuesta' => true, "sms" => "se aprobo en nuevo periodo"]);
                }
            }
        }
    }


    public function denegar_dias(Request $r)
    {
        $date = Carbon::now();

        //eliminar el 
        $sal = DB::update('update tbl_empleados_periodos_temp set estado=2 where id=?', [$r->id]);
        return response()->json(['respuesta' => true, "sms" => "se rechazaron los dias"]);
    }


    /*public function Get_vacaciones()
    {
        $vacaciones = DB::select("select  e.emp_id_regimen_contractual,e.emp_cedula,concat(e.emp_nombre,' ', e.emp_apellido) empleado,e.emp_fecha_ingreso, epp.id_periodo as p2022, epp.valor as v2022, ep.id_periodo as p2023, ep.valor as v2023,
        (select edd.valor from tbl_empleado_detalle_descuentos edd where edd.id_periodo = epp.id_periodo and edd.id_empleado=epp.id_empleado) as des2022,
        (select edd.valor from tbl_empleado_detalle_descuentos edd where edd.id_periodo = ep.id_periodo and edd.id_empleado=ep.id_empleado) as des2023
        from tbl_empleados_periodos ep
        INNER JOIN tbl_empleados_periodos epp ON  ep.id_empleado= epp.id_empleado 
        RIGHT JOIN tbl_empleados e ON CAST(e.emp_cedula as integer) = ep.id_empleado  where  e.emp_estado='A' and ep.id_periodo=2
        and epp.id_periodo=1");
        return $vacaciones;
    }*/

    public function descontar_dias(Request $r)
    {
        $date = Carbon::now();

        $cedula = DB::select("select * from tbl_empleados_periodos where id_empleado = ? and estado=1 ORDER BY id_periodo asc", [$r->cedula]);
        //return $cedula;
        if ($cedula != []) {
            //$saldo = 0 ;
            $saldo = $r->dias_d; //
            foreach ($cedula as $c) {
                $dias = $c->valor; // 30 
                // 5 <  15 
                if ($dias <= $saldo) {
                    // 15 - 5  =  10
                    $saldo = $saldo - $dias;
                    // actualizar el saldo al periodo menor por quedar en cero y el estado 0
                    $sal = DB::update('update tbl_empleados_periodos set valor=0, estado=0 , estado_activacion=0 where id=?', [$c->id]);
                    $codigo = DB::table('tbl_empleado_detalle_descuentos')->insertGetId([
                        'id_empleado' => $r->cedula,
                        'id_periodo' => $c->id_periodo,
                        'valor' => $dias,
                        'observacion' => $r->observacion,
                        'created_at' => $date,
                        'estado' => 1,
                    ]);
                } else {
                    // 30 - 10
                    $codigo = DB::table('tbl_empleado_detalle_descuentos')->insertGetId([
                        'id_empleado' => $r->cedula,
                        'id_periodo' => $c->id_periodo,
                        'valor' => $saldo,
                        'observacion' => $r->observacion,
                        'created_at' => $date,
                        'estado' => 1,
                    ]);
                    $saldo =  $dias - $saldo;
                    $sal = DB::update('update tbl_empleados_periodos set valor=? where id=?', [$saldo, $c->id]);

                    return response()->json(['respuesta' => "true", "sms" => "se descontaron " . $r->dias]);

                    // actualizar el saldo al periodo actual 
                }
                //30 = 0
                if ($dias == 0) {
                    // actualizar el estado a 0
                    $sal = DB::update('update tbl_empleados_periodos set estado=0 , estado_activacion=0 where id=?', [$c->id]);
                }
                // $r->dias = $saldo;
            }
        }
    }

    public function enviar_correo_prueba()
    {
        $user_logueado = session::get('usuario');

        $correos_users_1 = 'jair_g.pazmino@movilidadmanta.gob.ec';

        //$correos_users_2 = 'yordy.almeida@movilidadmanta.gob.ec';
        $iptolocation = 'http://www.ip-api.com/json';
        $creatorlocation = file_get_contents($iptolocation);
        $usr = json_decode($creatorlocation);
        $country = $usr->country;
        $ip_publica = $usr->query;
        $host = $usr->isp;
        $city = $usr->city;


        $em = Mail::send(
            'Administrador.Email.view_email_empleado',
            array(
                'fecha' => date('d-m-Y h:s:m'),
                'country' => $country,
                'ip_publica' => $ip_publica,
                'host' => $host,
                'city' => $city,
                'cedula' => '0',
                'nombres' => '0',
                'telefono' => '0',
                'titulo' => '0',
                'direccion' => '0',
                'jefatura' => '0',
                'cargo' => '0'
            ),
            function ($msj) use ($correos_users_1) {
                //function ($msj) use ($correos_users_1, $user_logueado) {
                $msj->subject('GMAIL');
                $msj->from('movilidadmanta@gmail.com');
                $msj->to($correos_users_1);
            }
        );
    }

    public function get_empleados_search_busq($limit, $text)
    {
        $text = str_replace("'", "\'", $text);
        $sql = DB::connection('pgsql')->select("
        SELECT DISTINCT ve.emp_id, ve.emp_cedula, ve.emp_nombre, ve.emp_apellido, ve.emp_telefono, ve.emp_direccion, ve.emp_ruta_foto, ve.emp_sexo, 
        ve.emp_cargo, ve.emp_fecha_nacimiento, ve.emp_tipo_sangre, ve.dep_departamento, ve.ca_cargo, ve.emp_edad  
        FROM view_empleados_t as ve
        WHERE upper(concat(ve.emp_cedula, ' ', ve.emp_apellido, ' ', ve.emp_nombre)) like E'%" . strtoupper($text) . "%' AND 
        ve.emp_estado = 'A' LIMIT $limit");

        $json_data = $sql;

        foreach ($json_data as $value) {
            $nuevaruta = public_path('/imagenes_empleados/' . $value->emp_ruta_foto);
            if (File::exists($nuevaruta)) {
                $value->emp_estado_ruta_foto = true;
            } else {
                $value->emp_estado_ruta_foto = false;
            }
        }

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_empleados_search($limit, $text)
    {
        $text = str_replace("'", "\'", $text);
        $sql = DB::connection('pgsql')->select("
        SELECT DISTINCT ve.emp_id, ve.emp_cedula, ve.emp_nombre, ve.emp_apellido, ve.emp_telefono, ve.emp_direccion, ve.emp_ruta_foto, ve.emp_sexo, 
        ve.emp_cargo, ve.emp_fecha_nacimiento, ve.emp_tipo_sangre, ve.dep_departamento, ve.ca_cargo, ve.emp_edad  
        FROM view_empleados_t as ve
        INNER JOIN tbl_conf_empleado_remoto as er ON ve.emp_id = er.emp_id
        WHERE upper(concat(ve.emp_cedula, ' ', ve.emp_apellido, ' ', ve.emp_nombre)) like E'%" . strtoupper($text) . "%' AND 
        ve.emp_estado = 'A' LIMIT $limit");

        $json_data = $sql;

        foreach ($json_data as $value) {
            $nuevaruta = public_path('/imagenes_empleados/' . $value->emp_ruta_foto);
            if (File::exists($nuevaruta)) {
                $value->emp_estado_ruta_foto = true;
            } else {
                $value->emp_estado_ruta_foto = false;
            }
        }

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function acciones_personal()
    {
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            $tipos_acciones = DB::Select('SELECT * FROM view_tbl_tipo_accion_personal');
            return view('Administrador.Empleado.accion_personal', compact('menus_', 'tipos_acciones'));
        } else {
            return Redirect("/");
        }
    }

    public function get_acciones_personal($fecha_desde = null, $fecha_hasta = null, $tipo_accion = null)
    {
        $where = "";
        if ($fecha_desde) {
            $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " ap_fecha_accion_personal >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if ($fecha_hasta && $where != "") {
            $where .= " AND";
        }
        if ($fecha_hasta) {
            $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " ap_fecha_accion_personal <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if ($tipo_accion && $where != "") {
            $where .= " AND";
        }
        if ($tipo_accion) {
            $where .= " tap_id = {$tipo_accion}";
        }

        if ($where != "") {
            $where = "WHERE {$where}";
        }

        $acciones_personal = DB::Select("SELECT * FROM view_tbl_accion_personal {$where}");
        return $acciones_personal;
    }

    public function view_accion_personal($id_accion)
    {
        $accion_personal_data = DB::Select("SELECT * FROM view_tbl_accion_personal WHERE ap_id = {$id_accion}");
        $accion_personal = $accion_personal_data[0];

        $html = view(
            'Administrador.Empleado.Reportes.reporte_accion_personal',
            [
                'secuencial' => $accion_personal->ap_secuencial,
                'fecha_accion' => DatesHelper::FechaATexto("Y-m-d", $accion_personal->ap_fecha_accion_personal),
                'apellidos_empleado' => $accion_personal->apellido_empleado,
                'nombres_empleado' => $accion_personal->nombre_empleado,
                'apellidos_director' => $accion_personal->apellido_empleadoth,
                'nombres_director' => $accion_personal->nombre_empleadoth,
                "cedula_empleado" => $accion_personal->emp_cedula,
                "fecha_accion_personal" => DatesHelper::FechaATexto("Y-m-d", $accion_personal->fecha_inicio_permiso),
                "tipo_accion" => $accion_personal->tap_descripcion,
                "empresa" => "EMPRESA PÚBLICA MUNICIPAL MOVILIDAD DE MANTA - EP",
                "lugar_trabajo" => "MANTA",
                "departamento_empleado" => $accion_personal->departamento_empleado,
                "cargo_empleado" => $accion_personal->cargo_empleado,
                "remuneracion_empleado" => $accion_personal->remuneracion_empleado,
                "titulo_empleado" => $accion_personal->titulo_empleado,
                "departamento_director" => $accion_personal->departamento_empleadoth,
                "cargo_director" => $accion_personal->cargo_empleadoth,
                "remuneracion_director" => $accion_personal->remuneracion_empleadoth,
                "titulo_director" => $accion_personal->titulo_empleadoth,
            ]
        )->render();
        $namefile = 'Accion_personal.pdf';
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new Mpdf([
            'fontDir' => array_merge($fontDirs, [
                public_path() . '/fonts',
            ]),
            'fontdata' => $fontData + [
                'arial' => [
                    'R' => 'arial.ttf',
                    'B' => 'arialbd.ttf',
                ],
            ],
            'default_font' => 'arial',
            'orientation' => 'P'
        ]);
        $mpdf->SetDisplayMode('fullwidth');
        $mpdf->WriteHTML($html);
        $mpdf->debug = true;
        $mpdf->showImageErrors = true;
        $mpdf->Output($namefile, "I");
    }
}
