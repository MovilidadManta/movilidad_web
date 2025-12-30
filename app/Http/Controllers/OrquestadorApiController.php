<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use Session;

use Illuminate\Http\Request;

class OrquestadorApiController extends Controller
{
    public function  viewUsers()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.OrquestadorApi.users.index', compact('menus_'));
    }

    public function get_lista_users($e_id)
    {
        $usuarios = DB::Select("SELECT u_id, u_username, orquestador.pgp_sym_decrypt(u_password::bytea, '" . env('DB_USERS_ENCRYPTION_KEY_API_MOVILIDAD') . "') AS u_password, u_estado, u_control_peticiones, u_control_ips FROM orquestador.view_tbl_users WHERE e_id = $e_id ORDER BY u_id DESC");
        return $usuarios;
    }

    public function store_user(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'e_id' => $request->input('e_id'),
            'u_username' => $request->input('txt_username'),
            'u_password' => $request->input('txt_password'),
            'clave_secreta' => env('DB_USERS_ENCRYPTION_KEY_API_MOVILIDAD'),
            'u_control_peticiones' => boolval($request->input('u_control_peticiones')),
            'u_control_ips' => boolval($request->input('u_control_ips'))
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_registrar_tbl_users(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_users;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function update_users(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'u_id' => $request->input('id'),
            'u_username' => $request->input('txt_username'),
            'u_password' => $request->input('txt_password'),
            'clave_secreta' => env('DB_USERS_ENCRYPTION_KEY_API_MOVILIDAD'),
            'u_control_peticiones' => boolval($request->input('u_control_peticiones')),
            'u_control_ips' => boolval($request->input('u_control_ips'))
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_modificar_tbl_users(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_users;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_users($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'u_id' => $id,
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_eliminar_tbl_users(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_users;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function  viewPeticiones()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.OrquestadorApi.peticiones.index', compact('menus_'));
    }

    public function get_lista_peticiones($id)
    {
        $peticiones = DB::Select("SELECT * FROM orquestador.view_tbl_conf_peticiones WHERE pa_id = $id ORDER BY p_id DESC");
        return $peticiones;
    }

    public function get_search_peticiones_active($limit, $text = '')
    {
        $text = str_replace("'", "\'", $text);

        $sql = DB::Select("select * from orquestador.view_tbl_conf_peticiones WHERE (upper(p_modulo) like E'%". strtoupper($text) ."%' OR upper(p_peticion) like E'%" . strtoupper($text) ."%')  ORDER BY p_id " . ($limit == -1 ? "" : "LIMIT $limit"));   

        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_peticion($id)
    {
        $peticion = DB::Select("SELECT * FROM orquestador.tbl_conf_peticiones WHERE p_id = {$id}");
        return $peticion[0];
    }

    public function get_responses_peticion($id){
        $responses = DB::Select("SELECT * FROM orquestador.tbl_conf_peticiones_response WHERE p_id = {$id}");
        return $responses;
    }

    public function store_peticion(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'ps_id' => $request->input('ps_id'),
            'p_peticion' => strtoupper($request->input('txt_peticion')),
            'p_verb_send' => $request->input('select_verb_send'),
            'p_request' => $request->input('txt_request'),
            'p_request_api' => $request->input('txt_request_api')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_registrar_tbl_conf_peticiones(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_conf_peticiones;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function update_peticion(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'p_id' => $request->input('id'),
            'ps_id' => $request->input('ps_id'),
            'p_peticion' => strtoupper($request->input('txt_peticion')),
            'p_verb_send' => $request->input('select_verb_send'),
            'p_request' => $request->input('txt_request'),
            'p_request_api' => $request->input('txt_request_api')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_modificar_tbl_conf_peticiones(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_conf_peticiones;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_peticion($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'p_id' => $id,
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_eliminar_tbl_conf_peticiones(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_conf_peticiones;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function store_respuesta_peticion(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'p_id' => $request->input('p_id'),
            'r_codigo' => $request->input('r_codigo'),
            'r_codigo_response' => $request->input('r_codigo_response'),
            'r_response_api' => $request->input('r_response_api'),
            'r_format_api' => $request->input('r_format_api'),
            'r_orden' => $request->input('r_orden'),
            'r_estado' => boolval($request->input('r_estado')),
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_registrar_tbl_conf_peticiones_response(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_conf_peticiones_response;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function update_respuesta_peticion(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'p_id' => $request->input('p_id'),
            'r_codigo' => $request->input('r_codigo'),
            'r_codigo_response' => $request->input('r_codigo_response'),
            'r_response_api' => $request->input('r_response_api'),
            'r_format_api' => $request->input('r_format_api'),
            'r_orden' => $request->input('r_orden'),
            'r_estado' => boolval($request->input('r_estado')),
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_modificar_tbl_conf_peticiones_response(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_conf_peticiones_response;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_respuesta_peticion($id, $r_codigo, $r_codigo_response, $r_orden)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'p_id' => $id,
            'r_codigo' => $r_codigo,
            'r_codigo_response' => $r_codigo_response,
            'r_orden' => $r_orden
        ];

        $jsoninsert = json_encode($json);

        $sql = DB::Select('select orquestador.procedimiento_eliminar_tbl_conf_peticiones_response(?,?,?)', [$jsoninsert, $ip, $user]);
        
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_conf_peticiones_response;
        }

        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }


    public function viewTransacciones()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.OrquestadorApi.transacciones.index', compact('menus_'));
    }

    public function getTransacciones($fecha_desde, $fecha_hasta, $username = "")
    {
        $usuario = "";

        if(trim($username) != ""){
            $usuario = " u_username = '{$username}' AND ";
        }

        // Convertir las fechas a objetos DateTime
        $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
        $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);

        // Sumar un día a $fecha_hasta
        $fecha_hasta->modify('+1 day');

        // Ejecutar la consulta con la fecha modificada
        $peticiones = DB::Select("SELECT * FROM orquestador.view_tbl_transacciones WHERE {$usuario} t_fecha >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY') AND t_fecha < TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY') ORDER BY t_fecha DESC");

        return $peticiones;
    }

    public function store_control_peticion(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'u_id' => $request->input('u_id'),
            'p_id' => $request->input('p_id')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_registrar_tbl_conf_control_peticiones_users(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_conf_control_peticiones_users;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function delete_control_peticion(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'u_id' => $request->input('u_id'),
            'p_id' => $request->input('p_id')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_eliminar_tbl_conf_control_peticiones_users(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_conf_control_peticiones_users;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function get_lista_control_peticiones($u_id)
    {
        $peticiones = DB::Select("SELECT * FROM orquestador.view_tbl_conf_control_peticiones_users WHERE u_id = {$u_id} ORDER BY p_id DESC");
        return $peticiones;
    }


    public function store_control_ip(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'u_id' => $request->input('u_id'),
            'ui_ip' => $request->input('ui_ip')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_registrar_tbl_users_ip(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_users_ip;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function delete_control_ip(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'u_id' => $request->input('u_id'),
            'ui_ip' => $request->input('ui_ip')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_eliminar_tbl_users_ip(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_users_ip;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function get_lista_control_ips($u_id)
    {
        $peticiones = DB::Select("SELECT * FROM orquestador.tbl_users_ip WHERE u_id = {$u_id} ORDER BY ui_ip DESC");
        return $peticiones;
    }

    public function store_empresa(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'nombre_empresa' => strtoupper($request->input('nombre_empresa')),
            'e_ruc' => $request->input('e_ruc'),
            'e_ip' => $request->input('e_ip')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_registrar_tbl_empresas(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_empresas;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function update_empresa(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'e_id' => $request->input('e_id'),
            'nombre_empresa' => strtoupper($request->input('nombre_empresa')),
            'e_ruc' => $request->input('e_ruc'),
            'e_ip' => $request->input('e_ip')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_modificar_tbl_empresas(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_empresas;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_empresa($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'e_id' => $id,
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_eliminar_tbl_empresas(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_empresas;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function store_proveedor_api_service($p_id, $ps_name, $ps_url, $ps_format_api, $ps_headers_api)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'p_id' => $p_id,
            'ps_name' => strtoupper($ps_name),
            'ps_url' => $ps_url,
            'ps_format_api' => $ps_format_api,
            'ps_headers_api' => $ps_headers_api,
            'clave_secreta' => env('DB_USERS_ENCRYPTION_KEY_API_MOVILIDAD')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_registrar_proveedor_api_service(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_proveedor_api_service;
        }
        if ($sql != "[]") {
            return ['respuesta' => "true", "data" => $id, "sql" => $sql];
        } else {
            return ["respuesta" => "false"];
        } return ["respuesta" => "false"];
    }

    public function update_proveedor_api_service($ps_id, $p_id, $ps_name, $ps_url, $ps_format_api, $ps_headers_api)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'ps_id' => $ps_id,
            'p_id' => $p_id,
            'ps_name' => strtoupper($ps_name),
            'ps_url' => $ps_url,
            'ps_format_api' => $ps_format_api,
            'ps_headers_api' => $ps_headers_api,
            'clave_secreta' => env('DB_USERS_ENCRYPTION_KEY_API_MOVILIDAD')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_modificar_proveedor_api_service(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_proveedor_api_service;
        }
        if ($sql != "[]") {
            return ['respuesta' => "true", "data" => $id, "sql" => $sql];
        } else {
            return ["respuesta" => "false"];
        }
    }

    public function delete_proveedor_api_service($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'ps_id' => $id,
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_eliminar_proveedor_api_service(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_proveedor_api_service;
        }
        if ($sql != "[]") {
            return ['respuesta' => "true", "data" => $id, "sql" => $sql];
        } else {
            return ["respuesta" => "false"];
        }
    }

    public function get_lista_empresas()
    {
        $usuarios = DB::Select("SELECT e_id, e_nombre_empresa, e_ruc, COALESCE(e_ip, '') AS e_ip FROM orquestador.view_tbl_empresas ORDER BY e_id DESC");
        return $usuarios;
    }

    public function get_proveedores_api()
    {
        $services = DB::Select("SELECT * FROM orquestador.view_tbl_proveedor_api");
        return $services;
    }

    public function get_proveedores_service($id_proveedor)
    {
        $services = DB::select("
            SELECT ps_id, p_id, ps_name, ps_url, ps_format_api,
                orquestador.pgp_sym_decrypt(ps_headers_api::bytea, '" . env('DB_USERS_ENCRYPTION_KEY_API_MOVILIDAD') . "') as ps_headers_api,
                ps_fecha, ps_fecha_update, ps_id_usuario, ps_estado
            FROM orquestador.view_tbl_proveedor_api_service
            WHERE p_id = $id_proveedor
        ");
        
        foreach ($services as $service) {
            if (!empty($service->ps_headers_api)) {
                $headers = json_decode($service->ps_headers_api, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($headers)) {
                    foreach ($headers as $key => $value) {
                        if (!in_array(strtolower($key), ['content-type', 'accept'])) {
                            $headers[$key] = '';
                        }
                    }
                    $service->ps_headers_api = json_encode($headers, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                }
            }
        }

        return $services;
    }

    public function store_proveedor_api(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $services = json_decode($request->services);

        $json[] = [
            'nombre_empresa' => strtoupper($request->input('p_nombre_empresa')),
            'p_ruc' => $request->input('p_ruc'),
            'p_modulo' => strtoupper($request->input('p_modulo'))
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_registrar_proveedor_api(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_proveedor_api;
        }
        if ($sql != "[]") {
            foreach($services as $s){
                if($s->action == "ADD"){
                    $this->store_proveedor_api_service($id, $s->name, $s->url, $s->select_tipo_api, $s->headers);
                }
                
                if($s->action == "MOD"){
                    $this->update_proveedor_api_service($s->ps_id, $id, $s->name, $s->url, $s->select_tipo_api, $s->headers);
                }

                if($s->action == "ELI"){
                    $this->delete_proveedor_api_service($s->ps_id);
                }
            }
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function update_proovedor_api(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $services = json_decode($request->services);

        $json[] = [
            'p_id' => $request->input('id'),
            'nombre_empresa' => strtoupper($request->input('p_nombre_empresa')),
            'p_ruc' => $request->input('p_ruc'),
            'p_modulo' => strtoupper($request->input('p_modulo'))
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_modificar_proveedor_api(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_proveedor_api;
        }
        if ($sql != "[]") {
            foreach($services as $s){
                if($s->action == "ADD"){
                    $this->store_proveedor_api_service($id, $s->name, $s->url, $s->select_tipo_api, $s->headers);
                }
                
                if($s->action == "MOD"){
                    $this->update_proveedor_api_service($s->ps_id, $id, $s->name, $s->url, $s->select_tipo_api, $s->headers);
                }

                if($s->action == "ELI"){
                    $this->delete_proveedor_api_service($s->ps_id);
                }
            }
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function delete_peticion_proveedor_api($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'p_id' => $id,
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select orquestador.procedimiento_eliminar_proveedor_api(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_proveedor_api;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_lista_peticion_services($id)
    {
        $peticiones = DB::Select("SELECT * FROM orquestador.tbl_proveedor_api_service WHERE p_id = $id AND ps_estado = TRUE ORDER BY ps_id DESC");
        return $peticiones;
    }

    public function store_orden(Request $request)
    {

        $json[] = [
            'ord_number' => $request->input('ord_number')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_tbl_ordenes_secuencial(?)', [$jsoninsert]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_ordenes_secuencial;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function update_orden(Request $request)
    {

        $json[] = [
            'ord_id' => $request->input('ord_id'),
            'ord_resultado' => $request->input('ord_resultado')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_actualizar_tbl_ordenes_secuencial(?)', [$jsoninsert]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_actualizar_tbl_ordenes_secuencial;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        } return response()->json(["respuesta" => "false"]);
    }

    public function get_ordenes_pendientes()
    {
        $ordenes = DB::Select("SELECT ord_id, ord_number FROM public.tbl_ordenes_secuencial WHERE ord_estado = FALSE");
        return $ordenes;
    }

    public function get_ordenes_all()
    {
        $ordenes = DB::Select("SELECT * FROM public.tbl_ordenes_secuencial WHERE ord_fecha::date = now()::date");
        return $ordenes;
    }

}
