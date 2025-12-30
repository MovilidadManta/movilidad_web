<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;
use Mpdf\Mpdf;
use App\Helpers\GuidHelper;

class LotaipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_empleado = session::get('id_empleado');
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Lotaip.lotaip', compact('menus_'));
    }

    public function index_solicitud_lotaip()
    {
        $id_empleado = session::get('id_empleado');
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Lotaip.solicitud_lotaip', compact('menus_'));
    }

    public function index_registrar($id, $year)
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Lotaip.registrar_lotaip', compact('id', 'year', 'menus_'));
    }

    public function index_registrarv2($id)
    {
        $meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
        $meses = json_encode($meses);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_literal_lotaips()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_literal_lotaips;
        }
        $literales = json_decode($data);
        //return $literales;
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Lotaip.registrar_lotaipv2', compact('id', 'menus_', 'meses', 'literales'));
    }

    public function index_pagina()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_lotaips()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_lotaips;
        }
        $json_data_year = json_decode($data);

        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_pagina_literales_id_lotaips()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_pagina_literales_id_lotaips;
        }
        $json_data_literales = json_decode($data, true);
        $json_data_literales_r = json_decode($data);

        $array_meses = '';
        if ($json_data_literales != '') {
            //MESES UNICOS
            $array_m = [];
            $cont = 0;
            $cont = count($json_data_literales);
            for ($i = 0; $i < $cont; $i++) {
                array_push($array_m, $json_data_literales[$i]['ldl_mes']);
            }
            $array_meses = array_keys(array_count_values($array_m));
        }

        //return $json_data_year;

        return view('Pagina_web.Lotaip.pagina_lotaip', compact('json_data_year', 'json_data_literales', 'json_data_literales_r'));
    }

    public function get_lotaips()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_lotaips()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_lotaips;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_lotaips_id($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_lotaips_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_lotaips_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_literales_lotaips()
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_literales_lotaips()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_literales_lotaips;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_lotaip(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'year' => $request->input('txt-year')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_lotaips(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_lotaips;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function save_solicitud_lotaip(Request $request)
    {
        $ip = request()->ip();
        $archivo = $request->file('txt-file');
        if ($archivo == "") {
            return response()->json(['respuesta' => 'file_vacio']);
        } else {
            $nombrearchivo = Str::slug("archivo-") . date("Ymdsm") . '.' . $archivo->getClientOriginalExtension();
            $nuevaruta = public_path('/archivos_solicitudes_lotaip/' . $nombrearchivo);
            copy($archivo->getRealPath(), $nuevaruta);

            $json[] = [
                'nombre' => $request->input('txt-nombre'),
                'cedula' => $request->input('txt-cedula'),
                'email' => $request->input('txt-email'),
                'mensaje' => $request->input('txt-mensaje'),
                'telefono' => $request->input('txt-telefono'),
                'archivo' => $nombrearchivo
            ];
            $jsoninsert = json_encode($json);
            return $jsoninsert;

            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_solicitud_lotaips(?,?)', [$jsoninsert, $ip]);

            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_solicitud_lotaips;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function update_lotaip(Request $request)
    {
        $date = Carbon::now();

        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-lotaip-m'),
            'year' => $request->input('txt-year-m')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_lotaips(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_lotaips;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_lotaip(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-lotaip')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_lotaip(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_lotaip;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }
    public function update_literal_lotaip(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $date = Carbon::now();
        $date = $date->format('Ymd') . $date->format('His');
        $archivo = $request->file('txt-ruta-archivo');
        if ($archivo != "") {
            $extension = $archivo->getClientOriginalExtension();
            $nombrearchivo = $request->input('txt-id-lotaip') . '_' . $request->input('select-mes') . '_' . $date . $archivo->getClientOriginalName() . '.' . $archivo->getClientOriginalExtension();
            $nuevaruta = public_path('/archivos_lotaip/' . $nombrearchivo);
            if (copy($archivo->getRealPath(), $nuevaruta)) {
                $json[] = [
                    //ID DEL LITERAL LOTAID DETALLE INGRESADO
                    'id_lotaip_detalle' => $request->input('ip_id_lotaip_datelle'),
                    'id_lotaip' => $request->input('txt-id-lotaip'),
                    'id_literal_lotaip' => $request->input('txt-id-literal-lotaip'),
                    'mes' => $request->input('select-mes'),
                    'ruta_archivo' => $nombrearchivo,
                    'id_select_literal_lotaip' => $request->input('select-literal-lotaip'),
                    'extension_archivo' => $extension
                ];
                $jsoninsert = json_encode($json);
                $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_modificar_datos_lotaips_detalles(?,?,?)', [$jsoninsert, $ip, $user]);
                foreach ($sql as $s) {
                    $id = $s->procedimiento_modificar_datos_lotaips_detalles;
                }
                if ($sql != "[]") {
                    return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
                } else {
                    return response()->json(["respuesta" => "false"]);
                }
            }
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function save_literal_lotaip(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $date = Carbon::now();
        $date = $date->format('Ymd') . $date->format('His');
        $archivo = $request->file('txt-ruta-archivo');
        if ($archivo != "") {
            $extension = $archivo->getClientOriginalExtension();
            //            $nombrearchivo = $archivo->getClientOriginalName() . '.' . $archivo->getClientOriginalExtension();
            $nombrearchivo = $request->input('txt-id-lotaip') . '_' . $request->input('select-mes') . '_' . $date . $archivo->getClientOriginalName() . '.' . $archivo->getClientOriginalExtension();
            $nuevaruta = public_path('/archivos_lotaip/' . $nombrearchivo);
            if (copy($archivo->getRealPath(), $nuevaruta)) {
                $json[] = [
                    'id_lotaip' => $request->input('txt-id-lotaip'),
                    'id_literal_lotaip' => $request->input('txt-id-literal-lotaip'),
                    'mes' => $request->input('select-mes'),
                    'ruta_archivo' => $nombrearchivo,
                    'id_select_literal_lotaip' => $request->input('select-literal-lotaip'),
                    'extension_archivo' => $extension
                ];
                $jsoninsert = json_encode($json);
                $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_lotaips_detalles(?,?,?)', [$jsoninsert, $ip, $user]);
                foreach ($sql as $s) {
                    $id = $s->procedimiento_registrar_datos_lotaips_detalles;
                }
                if ($sql != "[]") {
                    return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
                } else {
                    return response()->json(["respuesta" => "false"]);
                }
            }
        } else {
            $json[] = [
                'id_lotaip' => $request->input('txt-id-lotaip'),
                'id_literal_lotaip' => $request->input('txt-id-literal-lotaip'),
                'mes' => $request->input('select-mes'),
                'id_select_literal_lotaip' => $request->input('select-literal-lotaip'),
                'ruta_archivo' => null
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_lotaips_detalles(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_lotaips_detalles;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function get_literales_id_lotaips($id)
    {
        //$sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_literales_id_lotaips(?)', [$id]);
        $sql = DB::connection('pgsql_pag_web')->select("select * from view_literales_id_lotaips where ldl_id_lotaip = $id ");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_literales_id_lotaips;
        }
        $json_data = json_decode($data, true);*/

        $json_data = (array)$sql;

        if ($json_data != "") {
            //MESES UNICOS
            $array_m = [];
            foreach ($json_data as $r) {
                array_push($array_m, $r->ldl_mes);
            }

            /*for ($i = 0; $i < count($json_data); $i++) {
                array_push($array_m, $json_data[$i]['ldl_mes']);
            }*/
            $array_meses = array_keys(array_count_values($array_m));
            return response()->json(['data' => $json_data, 'data_meses' => $array_meses, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_literales_modificar_id_literal_lotaips($id)
    {
        $sql = DB::connection('pgsql_pag_web')->Select('select public.cursor_listar_literales_modificar_id_literales_lotaips(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_literales_modificar_id_literales_lotaips;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function delete_literal_lotaip_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_literal_lotaip' => $request->input('txt-id-literal-lotaip-e')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_eliminar_datos_literal_lotaip(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_literal_lotaip;
        }

        if ($sql != "[]") {
            return response()->json(['respuesta' => true, "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }


    public function get_solicitud_lotaips()
    {
        $json_data = DB::connection('pgsql_pag_web')->select("select * from view_solicitudes_lotaips");

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_solicitud_lotaips_id($id_solicitud)
    {
        $json_data = DB::connection('pgsql_pag_web')->select("select * from view_solicitudes_lotaips where sl_id = $id_solicitud ");

        if ($json_data != "[]") {
            foreach ($json_data as $da) {
                if ($da->csl_id > 0) {
                    $json_data_archivos = DB::connection('pgsql_pag_web')->Select("SELECT * FROM view_contestaciones_archivos_solicitudes_lotaip WHERE csl_id = $da->csl_id");
                    $da->archivos_adjuntos = $json_data_archivos;
                }
            }
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_contestacion_solicitud_lotaip_email(Request $request)
    {
        try {
            $ip = request()->ip();
            $user = session::get('id_users');
            $archivo = $request->file('txt-file-email-1');
            if ($archivo == "") {
                return response()->json(['respuesta' => 'file_vacio']);
            } else {
                $i = 1;
                $json_archivos = [];
                $guid = GuidHelper::GUIDv4();
                $rutas_archivos = [];
                while (1 == 1) {
                    if (!$request->hasFile('txt-file-email-' . $i)) {
                        break;
                    }
                    $archivo = $request->file('txt-file-email-' . $i);
                    $nombrearchivo = 'archivo' . $i . '-' . date("Ymdsm") . "-" . $guid . '.' . $archivo->getClientOriginalExtension();
                    $nuevaruta = public_path('/archivos_contestacion_solicitudes_lotaip/' . $nombrearchivo);
                    $rutas_archivos[] = [
                        'ruta' => $nuevaruta,
                        'name' => $archivo->getClientOriginalName(),
                        'mime' => $archivo->getMimeType(),
                    ];
                    copy($archivo->getRealPath(), $nuevaruta);
                    $json_archivos[] = [
                        'archivo_original' => $archivo->getClientOriginalName(),
                        'archivo_generado' => $nombrearchivo,
                        'descripcion_archivo' => $request->input('txt-descripcion-archivo-email-' . $i) ?? "",
                    ];
                    $i++;
                }

                $json[] = [
                    'id' => $request->input('hidden-id-solicitud'),
                    'respuesta' => $request->input('txt-respuesta'),
                    'archivo' => $guid,
                    'adjuntos' => $json_archivos
                ];
                $jsoninsert = json_encode($json);


                $respuesta = $request->input('txt-respuesta');
                $user_logueado = session::get('usuario');

                $correos_users_1 = 'yandry.navarrete@movilidadmanta.gob.ec';
                $correos_users_2 = $request->input('hidden-email-solicitud');
                $iptolocation = 'http://www.ip-api.com/json';
                $creatorlocation = file_get_contents($iptolocation);
                $usr = json_decode($creatorlocation);
                $country = $usr->country;
                $ip_publica = $usr->query;
                $host = $usr->isp;
                $city = $usr->city;
                $user_agent = $_SERVER['HTTP_USER_AGENT'];


                $em = Mail::send(
                    'Administrador.Correo.view_correo_constestacion_solicitud',
                    array(
                        'fecha' => date('d-m-Y h:s:m'),
                        'country' => $country,
                        'ip_publica' => $ip_publica,
                        'host' => $host,
                        'respuesta' => $respuesta,
                        'numero_solicitud' => $request->input('hidden-numero-solicitud')
                    ),
                    function ($msj) use ($correos_users_1, $correos_users_2, $rutas_archivos, $user_logueado) {
                        //function ($msj) use ($correos_users_1, $user_logueado) {
                        $msj->subject('RESPUESTA A SOLICITUD DE DOCUMENTOS - ACCESO A LA INFORMACIÓN PÚBLICA');
                        $msj->from('movilidadmanta@gmail.com');
                        $msj->to($correos_users_2);
                        $msj->cc($correos_users_1);
                        foreach ($rutas_archivos as $archivo) {
                            $msj->attach($archivo['ruta'], [
                                'as' => $archivo['name'],
                                'mime' => $archivo['mime']
                            ]);
                        }
                    }
                );


                $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_contestacion_solicitud_lotaips(?,?, ?)', [$jsoninsert, $ip, $user]);
                foreach ($sql as $s) {
                    $id = $s->procedimiento_registrar_datos_contestacion_solicitud_lotaips;
                }
                if ($sql != "[]") {
                    return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
                } else {
                    return response()->json(["respuesta" => "false"]);
                }
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }

    public function save_contestacion_solicitud_lotaip_fisico(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $archivo = $request->file('txt-file');
        if ($archivo == "") {
            return response()->json(['respuesta' => 'file_vacio']);
        } else {

            $nombrearchivo = $archivo->getClientOriginalExtension();
            $nombrearchivo = Str::slug("archivo-") . date("Ymdsm") . "-" . GuidHelper::GUIDv4() . '.' . $archivo->getClientOriginalExtension();
            $nuevaruta = public_path('/archivos_contestacion_solicitudes_lotaip/' . $nombrearchivo);
            copy($archivo->getRealPath(), $nuevaruta);

            $json[] = [
                'id' => $request->input('hidden-id-solicitud'),
                'respuesta' => $request->input('txt-respuesta'),
                'archivo' => $nombrearchivo
            ];
            $jsoninsert = json_encode($json);

            $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_contestacion_solicitud_lotaips(?,?, ?)', [$jsoninsert, $ip, $user]);

            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_contestacion_solicitud_lotaips;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function descargar_archivo_solicitud($file)
    {
        $pathtoFile = public_path() . '/archivos_solicitudes_lotaip/' . $file;
        return response()->download($pathtoFile);
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
    // FUNCION LITERAL LOTAIP 
    public function literal()
    {
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();

            //return $usuario;
            return view('Administrador.Literal_lotaip.literal_lotaip', compact('menus_'));
        } else {
            return view("Administrador.Login.login");
        }
    }

    public function send_solicitud_lotaip(Request $request)
    {


        $ip = request()->ip();

        $nombrearchivo = Str::slug("archivo-") . date("Ymdsm") . "-" . GuidHelper::GUIDv4() . '.PDF';
        $nuevaruta = public_path('/archivos_solicitudes_lotaip/' . $nombrearchivo);
        $data_secuencial = DB::connection('pgsql_pag_web')->select("select cf_valor from tbl_variables_configuraciones where cf_codigo = 'SECUENCIAL_SOLICITUD_LOTAIP'");

        $secuencial_value = $data_secuencial[0]->cf_valor;

        $html = view(
            'Administrador.Lotaip.documento_solicitud_acceso',
            [
                'city' => 'Manta',
                'institution' => 'Empresa Pública "Movilidad de Manta-EP"',
                'authority' => 'Lcdo. Gabriel German Alarcon Zambrano.',
                'nombre' => $request->input('txt-nombre'),
                'apellido' => $request->input('txt-apellido'),
                'cedula' => $request->input('txt-cedula'),
                'direccion' => $request->input('txt-direccion'),
                'telefono' => $request->input('txt-telefono'),
                'peticion' => $request->input('txt-peticion'),
                'forma_recepcion' => $request->input('select-forma-recepcion'),
                'email' => $request->input('txt-email'),
                'formato_entrega' => $request->input('select-formato-entrega'),
                'formato_digital' => $request->input('select-formato-digital'),
                'especificacion_otros' => $request->input('txt-otros-especifico'),
                'secuencial_numero' => $secuencial_value
            ]
        )->render();
        $namefile = GuidHelper::GUIDv4() . '.pdf';
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
        $mpdf->Output($nuevaruta, "F");

        $json[] = [
            'nombre' => $request->input('txt-nombre'),
            'apellido' => $request->input('txt-apellido'),
            'cedula' => $request->input('txt-cedula'),
            'email' => $request->input('txt-email') ?? "",
            'mensaje' => $request->input('txt-peticion'),
            'telefono' => $request->input('txt-telefono'),
            'direccion' => $request->input('txt-direccion'),
            'forma_recepcion' => $request->input('select-forma-recepcion'),
            'formato_entrega' => $request->input('select-formato-entrega'),
            'formato_digital' => $request->input('select-formato-digital'),
            'otros' => $request->input('txt-otros-especifico') ?? "",
            'archivo' => $nombrearchivo
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::connection('pgsql_pag_web')->Select('select public.procedimiento_registrar_datos_solicitud_lotaips(?,?)', [$jsoninsert, $ip]);

        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_solicitud_lotaips;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql, "archivo" => $nombrearchivo]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function ver_entrega_informacion_publica($id)
    {
        $json_data = DB::connection('pgsql_pag_web')->select("select * from view_solicitudes_lotaips where sl_id = $id");

        if ($json_data != "[]") {
            $data = $json_data[0];

            $html = view(
                'Administrador.Lotaip.documento_entrega_informacion_publica',
                [
                    'nombres' => $data->sl_nombres,
                    'apellidos' => $data->sl_apellidos,
                    'cedula' => $data->sl_cedula,
                    'fecha_recepcion' => $data->sl_fecha,
                    'direccion' => $data->sl_direccion,
                    'peticion' => $data->sl_descripcion,
                    'forma_recepcion' => $data->sl_forma_recepcion,
                    'email' => $data->sl_email,
                    'formato_digital' => $data->sl_formato_digital,
                    'formato_entrega' => $data->sl_formato_entrega,
                    'numero_solicitud' => $data->sl_numero_solicitud
                ]
            )->render();
            $namefile = GuidHelper::GUIDv4() . '.pdf';
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
        } else {
            return response()->json(['respuesta' => false]);
        }
    }
}
