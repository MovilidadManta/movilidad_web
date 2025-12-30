<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use DB;
use DateTime;
use File;
use Storage;

use Carbon\Carbon;
use Mpdf\Mpdf;
use App\Helpers\GuidHelper;
use App\Helpers\ExcelHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel_Cell_DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class GaritaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function IndexTipoVehiculo()
    {
        $id_empleado = session::get('id_empleado');
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Garita.Tipo_de_vehiculo.index', compact('menus_'));
    }

    public function get_lista_tipo_vehiculo()
    {
        $tiposVehiculos = DB::Select("SELECT * FROM garita.view_tbl_conf_tipo_vehiculo ORDER BY tv_id");
        DB::disconnect();
        return $tiposVehiculos;
    }

    public function store_tipo_vehiculo(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'nombre' => strtoupper($request->input('nombre')),
            'valor' => $request->input('valor'),
            'observacion' => strtoupper($request->input('observacion')) ?? '',
            'estado' => boolval($request->input('estado')),
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_registrar_tbl_conf_tipo_vehiculo(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_conf_tipo_vehiculo;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function update_tipo_vehiculo(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('id'),
            'nombre' => strtoupper($request->input('nombre')),
            'valor' => $request->input('valor'),
            'observacion' => strtoupper($request->input('observacion')) ?? '',
            'estado' => boolval($request->input('estado')),
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_modificar_tbl_conf_tipo_vehiculo(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_conf_tipo_vehiculo;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_tipo_vehiculo($id, Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $id
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_eliminar_tbl_conf_tipo_vehiculo(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_conf_tipo_vehiculo;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function IndexTipoIngresoVehicular()
    {
        $id_empleado = session::get('id_empleado');
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Garita.Tipo_de_ingreso_vehicular.index', compact('menus_'));
    }

    public function get_lista_tipo_ingreso_vehicular()
    {
        $TiposIngreso = DB::Select("SELECT * FROM garita.view_tbl_conf_tipo_ingreso_vehicular ORDER BY tiv_id");
        DB::disconnect();
        return $TiposIngreso;
    }

    public function get_lista_tipo_ingreso_vehicular_habilitados()
    {
        $TiposIngreso = DB::Select("SELECT * FROM garita.view_tbl_conf_tipo_ingreso_vehicular WHERE tiv_estado = true ORDER BY tiv_id");
        DB::disconnect();
        return $TiposIngreso;
    }

    public function store_tipo_ingreso_vehicular(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'nombre' => strtoupper($request->input('nombre')),
            'dias_retencion' => $request->input('dias_retencion'),
            'observacion' => strtoupper($request->input('observacion')) ?? '',
            'estado' => boolval($request->input('estado')),
            'campos' => $request->input('campos')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_registrar_tbl_conf_tipo_ingreso_vehicular(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_conf_tipo_ingreso_vehicular;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function update_tipo_ingreso_vehicular(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('id'),
            'nombre' => strtoupper($request->input('nombre')),
            'dias_retencion' => $request->input('dias_retencion'),
            'observacion' => strtoupper($request->input('observacion')) ?? '',
            'estado' => boolval($request->input('estado')),
            'campos' => $request->input('campos')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_modificar_tbl_tipo_ingreso_vehicular(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_tipo_ingreso_vehicular;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_tipo_ingreso_vehicular($id, Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $id
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_eliminar_tbl_conf_tipo_ingreso_vehicular(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_conf_tipo_ingreso_vehicular;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function IndexDocumentosRequeridos()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Garita.Documentos_requeridos.index', compact('menus_'));
    }

    public function get_lista_documentos_requeridos()
    {
        $DocumentosRequerido = DB::Select("SELECT * FROM garita.view_tbl_documentos_requeridos ORDER BY d_id");
        DB::disconnect();
        return $DocumentosRequerido;
    }

    public function store_documento_requerido(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'nombre' => strtoupper($request->input('nombre')),
            'observacion' => strtoupper($request->input('observacion')) ?? '',
            'es_requerido' => boolval($request->input('es_requerido')),
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_registrar_tbl_documentos_requeridos(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_documentos_requeridos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function update_documento_requerido(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('id'),
            'nombre' => strtoupper($request->input('nombre')),
            'observacion' => strtoupper($request->input('observacion')) ?? '',
            'es_requerido' => boolval($request->input('es_requerido')),
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_modificar_tbl_documentos_requeridos(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_documentos_requeridos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_documento_requerido($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $id
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_eliminar_tbl_documentos_requeridos(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_documentos_requeridos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function IndexConfInventarioVehiculo()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Garita.Inventario_vehiculo.index', compact('menus_'));
    }

    public function get_ConfInventarioVehiculo()
    {
        $inventario_vehiculos = DB::Select("SELECT * FROM garita.view_tbl_inventario_vehiculo_ingreso");
        DB::disconnect();
        return $inventario_vehiculos;
    }

    public function storeConfInventarioVehiculo(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'iv_title' => strtoupper($request->input('txt_titulo')),
            'iv_descripcion' => strtoupper($request->input('txt_descripcion')),
            'detalle_inventario' => $request->input('detalle_inventario')
        ];


        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_registrar_tbl_inventario_vehiculo_ingreso(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_inventario_vehiculo_ingreso;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function updateConfInventarioVehiculo(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'iv_id' => $request->input('id'),
            'iv_title' => strtoupper($request->input('txt_titulo')),
            'iv_descripcion' => strtoupper($request->input('txt_descripcion')),
            'detalle_inventario' => $request->input('detalle_inventario')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_modificar_tbl_inventario_vehiculo_ingreso(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_inventario_vehiculo_ingreso;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function destroyConfInventarioVehiculo($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'iv_id' => $id
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_eliminar_tbl_inventario_vehiculo_ingreso(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_inventario_vehiculo_ingreso;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function IndexIngresoVehiculoPatio()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        $tipo_ingreso = collect(DB::Select("SELECT tiv_id, tiv_nombre, tiv_observacion, ruta_imagen FROM garita.tbl_conf_tipo_ingreso_vehicular WHERE tiv_estado = TRUE"));
        DB::disconnect();
        return view('Administrador.Garita.Ingreso_vehiculo_patio.index', compact('menus_', 'tipo_ingreso'));
    }

    public function get_IngresoVehiculoPatio()
    {
        $ingreso_patio_vehiculos = DB::Select("SELECT * FROM garita.view_tbl_ingreso_vehiculo_patio");
        DB::disconnect();
        return $ingreso_patio_vehiculos;
    }

    public function get_one_IngresoVehiculoPatio($id)
    {
        $data = DB::Select("SELECT * FROM garita.view_tbl_ingreso_vehiculo_patio WHERE ivp_id = {$id}");
        DB::disconnect();
        return $data[0];
    }

    public function get_DetalleInventarioVehiculo($iv_id)
    {
        $inventario_vehiculos = DB::Select("SELECT * FROM garita.tbl_inventario_vehiculo_ingreso_detalle WHERE iv_id = {$iv_id} ORDER BY ivd_orden, ivd_orden");
        DB::disconnect();
        return $inventario_vehiculos;
    }

    public function get_detalle_documentos_vehiculo($tiv_id)
    {
        $DocumentosVehiculos = DB::Select("SELECT uiv.div_id, d.d_id, d.d_nombre, d.d_es_requerido, d.d_observacion
                                    FROM garita.tbl_documentos_ingreso_vehicular AS uiv
                                    INNER JOIN garita.tbl_documentos_requeridos AS d ON uiv.d_id = d.d_id
                                    WHERE d.d_estado = TRUE
                                    AND tiv_id = $tiv_id");
        DB::disconnect();
        return $DocumentosVehiculos;
    }

    public function storeIngresoVehiculoPatio(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'tiv_id' => $request->input('tiv_id'), //Por ahora 1 que es ordenanza
            'ivp_descripcion' => strtoupper($request->input('ivp_descripcion')), //Por ahora vacio
            'ivp_articulo' => strtoupper($request->input('ivp_articulo')),
            'ivp_numeral' => strtoupper($request->input('ivp_numeral')),
            'ivp_literal' => strtoupper($request->input('ivp_literal')),
            'ivp_resolucion' => strtoupper($request->input('ivp_resolucion')),
            'ivp_autoridad' => strtoupper($request->input('ivp_autoridad')),
            'ivp_oficio' => strtoupper($request->input('ivp_oficio')),

            'ivp_conductor_identificacion' => strtoupper($request->input('ivp_conductor_identificacion')),
            'ivp_conductor_nombres' => strtoupper($request->input('ivp_conductor_nombres')),
            'ivp_conductor_tipo_licencia' => $request->input('ivp_conductor_tipo_licencia'),

            'ivp_vehiculo_placa' => strtoupper($request->input('ivp_vehiculo_placa')),
            'ivp_vehiculo_tipo' => $request->input('ivp_vehiculo_tipo'),
            'ivp_vehiculo_marca' => strtoupper($request->input('ivp_vehiculo_marca')),
            'ivp_vehiculo_modelo' => strtoupper($request->input('ivp_vehiculo_modelo')),
            'ivp_vehiculo_color1' => strtoupper($request->input('ivp_vehiculo_color1')),
            'ivp_vehiculo_ramv' => strtoupper($request->input('ivp_vehiculo_ramv')),
            'ivp_vehiculo_chasis' => strtoupper($request->input('ivp_vehiculo_chasis')),
            'ivp_vehiculo_motor' => strtoupper($request->input('ivp_vehiculo_motor')),
            'ivp_vehiculo_servicio' => $request->input('ivp_vehiculo_servicio'),

            'ivp_medio_ingreso' => $request->input('ivp_medio_ingreso'),
            'ivp_medio_ingreso_empresa' => strtoupper($request->input('ivp_medio_ingreso_empresa')),
            'ivp_medio_ingreso_datos_translado' => strtoupper($request->input('ivp_medio_ingreso_datos_translado')),

            'ivp_agente_retiene_cedula' => $request->input('ivp_agente_retiene_cedula'), //Vacio por ahora
            'ivp_agente_retiene_nombre' => strtoupper($request->input('ivp_agente_retiene_nombre')), //Vacio por ahora
            'ivp_agente_retiene_email' => strtoupper($request->input('ivp_agente_retiene_email')), //Vacio por ahora

            'ivp_agente_ingresa_cedula' => $request->input('ivp_agente_ingresa_cedula'), //Vacio por ahora
            'ivp_agente_ingresa_nombre' => strtoupper($request->input('ivp_agente_ingresa_nombre')), //Vacio por ahora

            'ivp_responsable_cedula' => $request->input('ivp_responsable_cedula'), //Vacio por ahora
            'ivp_responsable_nombre' => strtoupper($request->input('ivp_responsable_nombre')), //Vacio por ahora
            'ivp_responsable_email' => strtoupper($request->input('ivp_responsable_email')), //Vacio por ahora

            'ivp_agente_devuelve_cedula' => '', //Vacio por ahora
            'ivp_agente_devuelve_nombre' => '', //Vacio por ahora

            'ivp_responsable_retira_cedula' => '', //Vacio por ahora
            'ivp_responsable_retira_nombre' => '', //Vacio por ahora

            'ivp_control_ingreso' => 1, //Por ahora 1

            'detalle_inventario_vehiculos' => $request->input('detalle_inventario_vehiculo'), //Json vacio
            'detalle_documentos' => $this->storeDocumentsVehiculoPatio_documentos($request->documentos, $request->input('tiv_id')), //Json vacio
            'detalle_evidencias_vehiculos' => $this->storeEvidenciasVehiculoPatio($request->imagenes), //Json vacio

        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_registrar_tbl_ingreso_vehiculo_patio(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_ingreso_vehiculo_patio;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function updateIngresoVehiculoPatio(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');
        $ivp_id = $request->input('ivp_id');

        $this->deleteFilesEvidencias_ingreso_vehiculo_patio($ivp_id);
        $this->deleteFilesDocuments_ingreso_vehiculo_patio($ivp_id);

        $json[] = [
            'ivp_id' => $ivp_id, //Por ahora 1 que es ordenanza
            'tiv_id' => $request->input('tiv_id'), //Por ahora 1 que es ordenanza
            'ivp_descripcion' => strtoupper($request->input('ivp_descripcion')), //Por ahora vacio
            'ivp_articulo' => strtoupper($request->input('ivp_articulo')),
            'ivp_numeral' => strtoupper($request->input('ivp_numeral')),
            'ivp_literal' => strtoupper($request->input('ivp_literal')),
            'ivp_resolucion' => strtoupper($request->input('ivp_resolucion')),
            'ivp_autoridad' => strtoupper($request->input('ivp_autoridad')),
            'ivp_oficio' => strtoupper($request->input('ivp_oficio')),

            'ivp_conductor_identificacion' => strtoupper($request->input('ivp_conductor_identificacion')),
            'ivp_conductor_nombres' => strtoupper($request->input('ivp_conductor_nombres')),
            'ivp_conductor_tipo_licencia' => $request->input('ivp_conductor_tipo_licencia'),

            'ivp_vehiculo_placa' => strtoupper($request->input('ivp_vehiculo_placa')),
            'ivp_vehiculo_tipo' => $request->input('ivp_vehiculo_tipo'),
            'ivp_vehiculo_marca' => strtoupper($request->input('ivp_vehiculo_marca')),
            'ivp_vehiculo_modelo' => strtoupper($request->input('ivp_vehiculo_modelo')),
            'ivp_vehiculo_color1' => strtoupper($request->input('ivp_vehiculo_color1')),
            'ivp_vehiculo_ramv' => strtoupper($request->input('ivp_vehiculo_ramv')),
            'ivp_vehiculo_chasis' => strtoupper($request->input('ivp_vehiculo_chasis')),
            'ivp_vehiculo_motor' => strtoupper($request->input('ivp_vehiculo_motor')),
            'ivp_vehiculo_servicio' => $request->input('ivp_vehiculo_servicio'),

            'ivp_medio_ingreso' => $request->input('ivp_medio_ingreso'),
            'ivp_medio_ingreso_empresa' => strtoupper($request->input('ivp_medio_ingreso_empresa')),
            'ivp_medio_ingreso_datos_translado' => strtoupper($request->input('ivp_medio_ingreso_datos_translado')),

            'ivp_agente_retiene_cedula' => $request->input('ivp_agente_retiene_cedula'), //Vacio por ahora
            'ivp_agente_retiene_nombre' => strtoupper($request->input('ivp_agente_retiene_nombre')), //Vacio por ahora
            'ivp_agente_retiene_email' => strtoupper($request->input('ivp_agente_retiene_email')), //Vacio por ahora

            'ivp_agente_ingresa_cedula' => $request->input('ivp_agente_ingresa_cedula'), //Vacio por ahora
            'ivp_agente_ingresa_nombre' => strtoupper($request->input('ivp_agente_ingresa_nombre')), //Vacio por ahora

            'ivp_responsable_cedula' => $request->input('ivp_responsable_cedula'), //Vacio por ahora
            'ivp_responsable_nombre' => strtoupper($request->input('ivp_responsable_nombre')), //Vacio por ahora
            'ivp_responsable_email' => strtoupper($request->input('ivp_responsable_email')), //Vacio por ahora

            'ivp_agente_devuelve_cedula' => '', //Vacio por ahora
            'ivp_agente_devuelve_nombre' => '', //Vacio por ahora

            'ivp_responsable_retira_cedula' => '', //Vacio por ahora
            'ivp_responsable_retira_nombre' => '', //Vacio por ahora

            'ivp_control_ingreso' => 1, //Por ahora 1

            'detalle_inventario_vehiculos' => $request->input('detalle_inventario_vehiculo'), //Json vacio
            'detalle_documentos' => $this->storeDocumentsVehiculoPatio_documentos($request->documentos, $request->input('tiv_id')), //Json vacio
            'detalle_evidencias_vehiculos' => $this->storeEvidenciasVehiculoPatio($request->imagenes), //Json vacio

        ];

        $jsoninsert = json_encode($json);

        $sql = DB::Select('select garita.procedimiento_modificar_tbl_ingreso_vehiculo_patio(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_ingreso_vehiculo_patio;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function deleteIngresoVehiculoPatio($id)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'ivp_id' => $id,
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select garita.procedimiento_eliminar_tbl_ingreso_vehiculo_patio(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_ingreso_vehiculo_patio;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    function deleteFilesDocuments_ingreso_vehiculo_patio($ivp_id) {
        $documentos = DB::select(
            "SELECT ivd_archivo_generado FROM garita.tbl_ingreso_vehiculo_patio_documentos WHERE ivp_id = ?", 
            [$ivp_id]
        );

        foreach ($documentos as $doc) {
            $path = '/ftpGarita/documentos_vehiculo/' . $doc->ivd_archivo_generado;
            if (Storage::disk('ftp_movilidad')->exists($path)) {
                Storage::disk('ftp_movilidad')->delete($path);
            }
        }
    }

    function  storeDocumentsVehiculoPatio_documentos($documentos, $tiv_id){
        $jsonResultado = []; // Aquí guardaremos los datos para armar el JSON

        if($documentos == null){
            return $jsonResultado;
        }

        foreach ($documentos as $doc) {

            $guid = GuidHelper::GUIDv4();
            $archivo = $doc['file'];
            $nombrearchivo = $guid . '.' . $archivo->getClientOriginalExtension();
            $nuevaruta = public_path('/archivos_documentos_vehiculo/' . $nombrearchivo);
            copy($archivo->getRealPath(), $nuevaruta);
            Storage::disk('ftp_movilidad')->put('/ftpGarita/documentos_vehiculo/' . $nombrearchivo , File::get($nuevaruta));

            // Eliminar archivo local
            if (file_exists($nuevaruta)) {
                unlink($nuevaruta);
            }

            $documento_id = $doc['id'];

             // Añadir al array
            $jsonResultado[] = [
                'tiv_id' => $tiv_id,
                'd_id' => $documento_id,
                'ivd_archivo_original' => $archivo->getClientOriginalName(),
                'ivd_archivo_generado' => $nombrearchivo
            ];
        }
        // Al final puedes:
        return json_encode($jsonResultado);
    }

    function deleteFilesEvidencias_ingreso_vehiculo_patio($ivp_id) {
        $documentos = DB::select(
            "SELECT ive_archivo_generado FROM garita.tbl_evidencias_vehiculo_patio WHERE ivp_id = ?", 
            [$ivp_id]
        );

        foreach ($documentos as $doc) {
            $path = '/ftpGarita/evidencias_vehiculo/' . $doc->ive_archivo_generado;
            if (Storage::disk('ftp_movilidad')->exists($path)) {
                Storage::disk('ftp_movilidad')->delete($path);
            }
        }
    }

    public function storeEvidenciasVehiculoPatio($imagenes)
    {
        $jsonResultado = [];

        if($imagenes == null){
            return $jsonResultado;
        }

        foreach ($imagenes as $img) {
            $guid = GuidHelper::GUIDv4();
            $archivo = $img;
            $nombrearchivo = $guid . '.' . $archivo->getClientOriginalExtension();
            $nuevaruta = public_path('/archivos_evidencias_vehiculo/' . $nombrearchivo);

            // Guarda temporalmente en public
            copy($archivo->getRealPath(), $nuevaruta);

            // Luego se sube al FTP
            Storage::disk('ftp_movilidad')->put('/ftpGarita/evidencias_vehiculo/' . $nombrearchivo, File::get($nuevaruta));

             // Eliminar archivo local
            if (file_exists($nuevaruta)) {
                unlink($nuevaruta);
            }

            // Agrega al JSON de respuesta
            $jsonResultado[] = [
                'ive_archivo_original' => $archivo->getClientOriginalName(),
                'ive_archivo_generado' => $nombrearchivo
            ];
        }

        return json_encode($jsonResultado);
    }

    public function descargar_documento_vehiculo($archivo)
    {
        $archivo = trim($archivo, '"'); // decode + limpiar comillas dobles si existen
        $ruta = '/ftpGarita/documentos_vehiculo/' . $archivo;
        
        if (!Storage::disk('ftp_movilidad')->exists($ruta)) {
            return response()->json(['error' => 'Archivo no encontrado.'], 404);
        }

        $contenidoPDF = Storage::disk('ftp_movilidad')->get($ruta);
        return response($contenidoPDF, 200)->header('Content-Type', 'application/pdf');
    }

    public function descargar_evidencias_vehiculo($archivo)
    {
        // Limpia comillas dobles si existen
        $archivo = trim($archivo, '"');

        $ruta = '/ftpGarita/evidencias_vehiculo/' . $archivo;

        if (!Storage::disk('ftp_movilidad')->exists($ruta)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        $contenido = Storage::disk('ftp_movilidad')->get($ruta);
        $mime = Storage::disk('ftp_movilidad')->mimeType($ruta) ?? 'application/octet-stream';

        return response($contenido, 200)->header('Content-Type', $mime);
    }

    public function IndexRetiroVehiculoPatio()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        $tipo_ingreso = collect(DB::Select("SELECT tiv_id, tiv_nombre, tiv_observacion, ruta_imagen FROM garita.tbl_conf_tipo_ingreso_vehicular WHERE tiv_estado = TRUE"));
        DB::disconnect();
        return view('Administrador.Garita.Retiro_vehiculo_patio.index', compact('menus_', 'tipo_ingreso'));
    }

    public function get_RetiroVehiculoPatio($fecha_desde = null, $fecha_hasta = null, $tipo_ingreso = null)
    {
        $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
        $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
        $fecha_hasta->modify('+1 day');

        $sql = "
        SELECT rvp_id, ivp_id, ivp_descripcion,tiv_id,tiv_nombre,
            tv_nombre,tv_valor, ivp_vehiculo_placa,ivp_conductor_identificacion,
            ivp_conductor_nombres, ivp_fecha, ivp_fecha_update, rvp_fecha_retiro 
        FROM garita.view_tbl_retirar_vehiculo_patio
        WHERE ivp_fecha >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY') AND
        ivp_fecha < TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY') ";

        if($tipo_ingreso > 0)
            $sql .= "AND tiv_id = {$tipo_ingreso}";

        $retiro_patio_vehiculos = DB::Select($sql);

        DB::disconnect();
        return $retiro_patio_vehiculos;
    }
    
}