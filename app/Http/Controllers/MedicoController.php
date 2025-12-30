<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use DB;
use DateTime;
use File;

use Carbon\Carbon;
use Mpdf\Mpdf;
use App\Helpers\GuidHelper;
use App\Helpers\ExcelHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel_Cell_DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();

            $sql = DB::Select('select public.cursor_listar_usuarios()');
            foreach ($sql as $r) {
                $data = $r->cursor_listar_usuarios;
            }
            $usuario = json_decode($data);

            $enfermedades = DB::select("SELECT e.id, t.categoria, e.enfermedad, e.estado, e.created_at FROM medico.tbl_enfermedades e INNER JOIN medico.tbl_categorias_enfermedades t ON e.id_categoria = t.id");
            $tipos = DB::select("Select * from medico.tbl_categorias_enfermedades where estado =true order by id asc");

            //return $usuario;
            return view('Administrador.Medico.index', compact('menus_', 'usuario', 'enfermedades', 'tipos'));
        } else {
            return view("Administrador.Login.login");
        }
    }

    public function index_tipos_enfermedades()
    {
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();

            $sql = DB::Select('select public.cursor_listar_usuarios()');
            foreach ($sql as $r) {
                $data = $r->cursor_listar_usuarios;
            }
            $usuario = json_decode($data);

            $tipos = DB::select("Select * from medico.tbl_categorias_enfermedades");
            //return $usuario;
            return view('Administrador.Medico.tipos_enfermedades', compact('menus_', 'usuario', 'tipos'));
        } else {
            return view("Administrador.Login.login");
        }
    }

    public function GET_tipos()
    {
        $tipos_enfermedades = DB::select("select * from medico.tbl_categorias_enfermedades");
        return response()->json(["respuesta" => true, "data" => $tipos_enfermedades]);
    }

    public function store_categoria(Request $r)
    {

        $date = Carbon::now();
        $categoria = DB::table('medico.tbl_categorias_enfermedades')->insertGetId([
            'categoria' => $r->categoria,
            'estado' => true,
            'created_at' => $date
        ]);
        if ($categoria > 0) {
            return response()->json(["respuesta" => true, "data" => "OK"]);
        } else {
            return response()->json(["respuesta" => false, "data" => "ERROR"]);
        }
    }

    public function store_e(Request $r)
    {
        $date = Carbon::now();
        $enfermedad = DB::table('medico.tbl_enfermedades')->insertGetId([
            'id_categoria' => $r->categoria,
            'enfermedad' => $r->enfermedad,
            'estado' => true,
            'created_at' => $date
        ]);
        if ($enfermedad > 0) {
            return response()->json(["respuesta" => true, "data" => "OK"]);
        } else {
            return response()->json(["respuesta" => false, "data" => "ERROR"]);
        }
    }

    public function lista_enf()
    {
        $enfermedades = DB::select("select * from medico.tbl_enfermedades");
        return response()->json(["respuesta" => true, "data" => $enfermedades]);
    }

    public function delete_categoria(Request $r)
    {
        $dele = DB::update('update medico.tbl_categorias_enfermedades set estado=false where id=?', [$r->id_categoria]);
        if ($dele > 0) {
            return response()->json(["res" => true, "sms" => "9999"]);
        } else {
            return response()->json(["res" => false, "sms" => "9998"]);
        }
    }

    public function edit_categoria(Request $r)
    {
        $dele = DB::update('update medico.tbl_categorias_enfermedades set categoria=? where id=?', [$r->categoria, $r->id_categoria]);
        if ($dele > 0) {
            return response()->json(["res" => true, "sms" => "9999"]);
        } else {
            return response()->json(["res" => false, "sms" => "9998"]);
        }
    }

    public function consulta()
    {
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();

            $sql = DB::Select('select public.cursor_listar_usuarios()');
            foreach ($sql as $r) {
                $data = $r->cursor_listar_usuarios;
            }
            $usuario = json_decode($data);

            //return $usuario;
            return view('Administrador.Medico.consulta', compact('menus_', 'usuario'));
        } else {
            return view("Administrador.Login.login");
        }
    }

    public function lista_pacientes(Request $r)
    {
        $sql = DB::Select("select * from view_usuarios where emp_cedula = '$r->paciente' OR emp_apellido ilike '%$r->paciente%'");
        if ($sql == []) {
            return response()->json(["respuesta" => true, "data" => 0]);
        } else {
            return response()->json(["respuesta" => true, "data" => $sql]);
        }
    }

    public function form_consulta($cedula)
    {
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();

            $sql = DB::Select('select public.cursor_listar_usuarios()');
            foreach ($sql as $r) {
                $data = $r->cursor_listar_usuarios;
            }
            $usuario = json_decode($data);

            $paciente = DB::Select("select * from view_usuarios where emp_cedula = '$cedula'");
            $signos_vitales = DB::select("select * from medico.tbl_signos_vitales where estado = true");
            // return $signos_vitales;
            return view('Administrador.Medico.form_consulta', compact('menus_', 'usuario', 'paciente', 'signos_vitales'));
        } else {
            return view("Administrador.Login.login");
        }
    }

    public function ficha_medica()
    {
        if (Session::get('usuario')) {
            $id_empleado = session::get('id_empleado');
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            return view('Administrador.Medico.ficha_medica', compact('menus_'));
        } else {
            return view("Administrador.Login.login");
        }
    }

    public function registrar_ficha_medica()
    {
        if (Session::get('usuario')) {
            $id_empleado = session::get('id_empleado');
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            return view('Administrador.Medico.registrar_ficha_medica', compact('menus_'));
        } else {
            return view("Administrador.Login.login");
        }
    }

    public function modificar_ficha_medica($id)
    {
        if (Session::get('usuario')) {
            $id_empleado = session::get('id_empleado');
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            $sql = $this->obtener_vista_ficha_medica("*",$id,"");

            if(count($sql) > 0){
                $certificado = $sql[0];
                $nuevaruta = public_path('/imagenes_empleados/' . $certificado->emp_ruta_foto);
                if (File::exists($nuevaruta)) {
                    $certificado->emp_estado_ruta_foto = true;
                } else {
                    $certificado->emp_estado_ruta_foto = false;
                }
                return view('Administrador.Medico.registrar_ficha_medica', compact('menus_', 'certificado'));
            } else {
                return view("Administrador.Login.login");
            }
            
        } else {
            return view("Administrador.Login.login");
        }
    }

    public function get_causas_consulta_medicas($coincidenciaTotal,$limit, $text = '')
    {
        $text = str_replace("'", "\'", $text);
        if($coincidenciaTotal == 1){
            $coincidenciaTotal = '%';
        }else{
            $coincidenciaTotal = '';
        }
        $sql = DB::Select("select * from medico.view_tbl_causas_consulta_medica WHERE upper(cm_descripcion) like E'" . trim($coincidenciaTotal) . strtoupper($text) ."%' ORDER BY cm_descripcion " . ($limit == -1 ? "" : "LIMIT $limit"));

        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_diagnostico_consulta_medicas($coincidenciaTotal,$limit, $text = '')
    {
        $text = str_replace("'", "\'", $text);
        if($coincidenciaTotal == 1){
            $coincidenciaTotal = '%';
        }else{
            $coincidenciaTotal = '';
        }
        $sql = DB::Select("select * from medico.view_tbl_diagnostico_consulta_medica WHERE upper(dm_descripcion) like E'" . trim($coincidenciaTotal) . strtoupper($text) ."%' OR upper(dm_cie10) like E'%" . strtoupper($text) ."%'  ORDER BY dm_orden desc, dm_cie10 " . ($limit == -1 ? "" : "LIMIT $limit"));

        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function modify_causa_medica(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('hidden-id'),
            'descripcion' => strtoupper($request->input('txt-descripcion'))
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select medico.procedimiento_modificar_tbl_causas_consulta_medica(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_causas_consulta_medica;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function agregar_causa_medica(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'descripcion' => strtoupper($request->input('txt-descripcion'))
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select medico.procedimiento_registrar_tbl_causas_consulta_medica(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_causas_consulta_medica;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function deshabilitar_causa_medica(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('id')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select medico.procedimiento_deshabilitar_tbl_causas_consulta_medica(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_deshabilitar_tbl_causas_consulta_medica;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function modify_diagnostico_medico(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('hidden-id'),
            'cie10' => trim($request->input('txt-cie10')) ?: '',
            'descripcion' => strtoupper($request->input('txt-descripcion')),
            'requiere_cie10' => $request->input('check-requiere-cie10') == 'SI'
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select medico.procedimiento_modificar_tbl_diagnostico_consulta_medica(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_diagnostico_consulta_medica;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function agregar_diagnostico_medico(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'cie10' => trim($request->input('txt-cie10')) ?: '',
            'descripcion' => strtoupper($request->input('txt-descripcion')),
            'requiere_cie10' => $request->input('check-requiere-cie10') == 'SI'
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select medico.procedimiento_registrar_tbl_diagnostico_consulta_medica(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_diagnostico_consulta_medica;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function deshabilitar_diagnostico_medico(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('id')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select medico.procedimiento_deshabilitar_tbl_diagnostico_consulta_medica(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_deshabilitar_tbl_diagnostico_consulta_medica;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_medicos_consulta_medicas($coincidenciaTotal,$limit, $text = '')
    {
        $text = str_replace("'", "\'", $text);
        if($coincidenciaTotal == 1){
            $coincidenciaTotal = '%';
        }else{
            $coincidenciaTotal = '';
        }
        $sql = DB::Select("select * from medico.view_tbl_medicos WHERE upper(me_cedula) like E'" . trim($coincidenciaTotal) . strtoupper($text) ."%' OR upper(concat(me_apellidos, ' ', me_nombres)) like E'%" . strtoupper($text) ."%'  ORDER BY me_apellidos " . ($limit == -1 ? "" : "LIMIT $limit"));

        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function modify_medico_ficha(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('hidden-id'),
            'cedula' => trim($request->input('txt-cedula')) ?: '',
            'sexo' => strtoupper($request->input('select-sexo')),
            'nombres' => strtoupper($request->input('txt-nombres')) ?: '',
            'apellidos' => strtoupper($request->input('txt-apellidos')),
            'centro_medico' => strtoupper($request->input('txt-centro_medico')) ?: ''
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select medico.procedimiento_modificar_tbl_medicos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_medicos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function deshabilitar_medico_ficha(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('id')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select medico.procedimiento_deshabilitar_tbl_medicos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_deshabilitar_tbl_medicos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function agregar_medico_ficha(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'cedula' => trim($request->input('txt-cedula')) ?: '',
            'sexo' => strtoupper($request->input('select-sexo')),
            'nombres' => strtoupper($request->input('txt-nombres')) ?: '',
            'apellidos' => strtoupper($request->input('txt-apellidos')),
            'centro_medico' => strtoupper($request->input('txt-centro_medico')) ?: ''
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select medico.procedimiento_registrar_tbl_medicos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_medicos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function agregar_certificado_medico(Request $request)
    {
        
        $ip = request()->ip();
        $user = session::get('id_users');
        //return response()->json(['respuesta' => "true", "fechaInicio" => $request->input('txt-fecha-inicio-certificado'), "fechaFin" => $request->input('txt-fecha-fin-certificado'), "fecharecepcion" => $request->input('txt-fecha-ficha')]);
        $fecha_inicio_certificado = DateTime::createFromFormat('Y-m-d', $request->input('txt-fecha-inicio-certificado'));
        $fecha_fin_certificado = DateTime::createFromFormat('Y-m-d', $request->input('txt-fecha-fin-certificado'));
        $fecha_recepcion = DateTime::createFromFormat('Y-m-d', $request->input('txt-fecha-ficha'));
        $diferenciaFechas = $fecha_inicio_certificado->diff($fecha_fin_certificado);
        
        $json[] = [
            'emp_id' => $request->input('emp_id'),
            'tipo_certificado' => $request->input('select-certificado-ficha'),
            'horas_ficha' => 0,
            'dias_certificado' => $diferenciaFechas->days + 1,
            'fecha_recepcion' => $fecha_recepcion->format("Y/m/d"),
            'fecha_inicio_certificado' => $fecha_inicio_certificado->format("Y/m/d"),
            'fecha_fin_certificado' => $fecha_fin_certificado->format("Y/m/d"),
            'hora_inicio_certificado' => $request->input('txt-hora-inicio-certificado') ?: '00:00',
            'hora_fin_certificado' => $request->input('txt-hora-fin-certificado') ?: '00:00',
            'observacion' => strtoupper($request->input('txt-observacion-ficha')),
            'medico' => strtoupper($request->input('txt-medico')) ?: 'NO ASIGNADO',
            'me_id' => $request->input('me_id') ?: 0,
            'cm_id' => $request->input('cm_id'),
            'dm_id' => $request->input('dm_id')
        ];
        $jsoninsert = json_encode($json);
        //return response()->json(['respuesta' => "true", "jsoninsert" => $jsoninsert]);
        $sql = DB::Select('select medico.procedimiento_registrar_tbl_ficha_medica(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_ficha_medica;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function modificar_certificado_medico(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        //return response()->json(['respuesta' => "true", "fechaInicio" => $request->input('txt-fecha-inicio-certificado'), "fechaFin" => $request->input('txt-fecha-fin-certificado'), "fecharecepcion" => $request->input('txt-fecha-ficha')]);
        $fecha_inicio_certificado = DateTime::createFromFormat('Y-m-d', $request->input('txt-fecha-inicio-certificado'));
        $fecha_fin_certificado = DateTime::createFromFormat('Y-m-d', $request->input('txt-fecha-fin-certificado'));
        $fecha_recepcion = DateTime::createFromFormat('Y-m-d', $request->input('txt-fecha-ficha'));
        $diferenciaFechas = $fecha_inicio_certificado->diff($fecha_fin_certificado);
        
        $json[] = [
            'id' => $request->input('fm_id'),
            'emp_id' => $request->input('emp_id'),
            'tipo_certificado' => $request->input('select-certificado-ficha'),
            'horas_ficha' => 0,
            'dias_certificado' => $diferenciaFechas->days + 1,
            'fecha_recepcion' => $fecha_recepcion->format("Y/m/d"),
            'fecha_inicio_certificado' => $fecha_inicio_certificado->format("Y/m/d"),
            'fecha_fin_certificado' => $fecha_fin_certificado->format("Y/m/d"),
            'hora_inicio_certificado' => $request->input('txt-hora-inicio-certificado') ?: '00:00',
            'hora_fin_certificado' => $request->input('txt-hora-fin-certificado') ?: '00:00',
            'observacion' => strtoupper($request->input('txt-observacion-ficha')),
            'medico' => strtoupper($request->input('txt-medico')) ?: 'NO ASIGNADO',
            'me_id' => $request->input('me_id') ?: 0,
            'cm_id' => $request->input('cm_id'),
            'dm_id' => $request->input('dm_id')
        ];
        $jsoninsert = json_encode($json);
        //return response()->json(['respuesta' => "true", "jsoninsert" => $jsoninsert]);
        $sql = DB::Select('select medico.procedimiento_modificar_tbl_ficha_medica(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_ficha_medica;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function show_certificado_medico($id, $approve = 0)
    {
        $apellidos_firma = session::get('apellidos');
        $nombres_firma = session::get('nombres');
        $sql = $this->obtener_vista_ficha_medica("*",$id,"");
        
        if(count($sql) >0){
            $datos = $sql[0];
            $fecha_inicio_certificado = DateTime::createFromFormat('Y-m-d', $datos->fm_fecha_inicio_certificado);
            $fecha_fin_certificado = DateTime::createFromFormat('Y-m-d', $datos->fm_fecha_fin_certificado);
            $fecha_recepcion = DateTime::createFromFormat('Y-m-d', $datos->fm_fecha_recepcion);
            $html = view('Administrador.Medico.Reportes.certificado_medico', 
            [
                'dia_emision'=>$fecha_recepcion->format("d"),
                'mes_emision'=>$fecha_recepcion->format("m"),
                'anio_emision'=>$fecha_recepcion->format("Y"),
                'cedula'=>$datos->emp_cedula,
                'apellidos'=>$datos->emp_apellido,
                'nombres'=>$datos->emp_nombre,
                'diagnostico_medico'=>$datos->dm_descripcion,
                'diagnostico_cie10'=>$datos->dm_cie10,
                'tipo_certificado'=>$datos->fm_tipo_certificado,
                'fecha_inicio_certificado'=>$fecha_inicio_certificado->format("d/m/Y"),
                'fecha_fin_certificado'=>$fecha_fin_certificado->format("d/m/Y"),
                'hora_inicio_certificado'=>$datos->fm_hora_inicio_certificado,
                'hora_fin_certificado'=>$datos->fm_hora_fin_certificado,
                'observacion'=>$datos->fm_observacion,
                'apellidos_firma'=>$apellidos_firma,
                'nombres_firma'=>$nombres_firma,
                'approve' => $approve
            ])->render();
            $namefile = 'Prueba.pdf';
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
        }else{
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_certificados_medicos($fecha_desde = null, $fecha_hasta = null, $tipo_certificado = null)
    {
        $where = "";
        if($fecha_desde){
            $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " fm_fecha_recepcion >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($fecha_hasta && $where != ""){
            $where .= " AND";
        }
        if($fecha_hasta){
            $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " fm_fecha_recepcion <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($tipo_certificado && $where != ""){
            $where .= " AND";
        }
        if($tipo_certificado){
            $where .= " fm_tipo_certificado = {$tipo_certificado}";
        }

        $sql = $this->obtener_vista_ficha_medica("*","","fm_fecha_recepcion desc, fm_id desc", $where);
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

    public function get_certificados_medicos_page_principal()
    {
        $where = "";

        $sql = $this->obtener_vista_ficha_medica("*","","fm_fecha_recepcion desc, fm_id desc", "fm_id != 0");
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

    public function save_aprobacion_certificado_medico(Request $request)
    {
        try{
            $ip = request()->ip();
            $user = session::get('id_users');
            $archivo = $request->file('txt-file');
            $id = $request->input('hidden-id-ficha-medica');
            if ($archivo == "") {
                return response()->json(['respuesta' => 'file_vacio']);
            } else {
                $guid = GuidHelper::GUIDv4();
                $archivo = $request->file('txt-file');
                $nombrearchivo = 'archivo' . date("Ymdsm") . "-" . $guid . '.' . $archivo->getClientOriginalExtension();
                $nuevaruta = public_path('/archivos_aprobacion_certificados_medicos/' . $nombrearchivo);
                copy($archivo->getRealPath(), $nuevaruta);

                $json[] = [
                    'id' => $id,
                    'archivo_original' => $archivo->getClientOriginalName(),
                    'archivo_generado' => $nombrearchivo,
                ];
                $jsoninsert = json_encode($json);

                $sql = DB::Select('select medico.procedimiento_modificar_aprobar_tbl_ficha_medica(?,?, ?)', [$jsoninsert, $ip, $user]);
                
                foreach ($sql as $s) {
                    $id = $s->procedimiento_modificar_aprobar_tbl_ficha_medica;
                }

                /* Ficha Medica obtener */
                $sql = $this->obtener_vista_ficha_medica("fm_id, emp_cedula, fm_fecha_inicio_certificado, fm_fecha_fin_certificado, fm_hora_inicio_certificado, fm_hora_fin_certificado, fm_tipo_certificado, dm_cie10, dm_descripcion, fm_dias_certificado, cm_descripcion, fm_fecha_recepcion, enviar_certificado, dm_id",$id,"");
                $ficha = $sql[0];
                $sql = DB::Select("SELECT id, tipo_permiso, estado_documento FROM public.tbl_tipos_permisos WHERE id = " . env('ID_TIPO_PERMISO_MEDICO') ?: 4); //Aqui va el codigo de permiso
                $tipo_permiso = $sql[0];
                /* */

                if ($sql != "[]") {
                    return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql, 'ficha' => $ficha, 'tipo_permiso' => $tipo_permiso, 'url_permiso_medico' => ((env('API_REST_INTRANET') ?: '') . (env('API_REST_INTRANET_ENDPOINT_SEND_PERMISO_MEDICO') ?: ''))]);
                } else {
                    return response()->json(["respuesta" => "false"]);
                }
        }
        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }

    private function obtener_vista_ficha_medica($select = "*",$id = "", $orderBy = "", $whereConsult = "")
    {
        $where = "";
        $order = "";
        $where = "";
        if($id != ""){
            $where .= "WHERE fm_id = {$id}";
        }
        if($orderBy != ""){
            $order = "ORDER BY {$orderBy}";
        }
        if($whereConsult != ""){
            $where = trim($where) == "" ? "WHERE {$whereConsult}" : $where . " AND {$whereConsult}";
        }
        $certificados = DB::select("select {$select} from medico.view_tbl_ficha_medica {$where} {$order}");
        return $certificados;
    }

    public function reporte_excel_certificados_medicos($fecha_desde = null, $fecha_hasta = null, $tipo_certificado = null){
        $where = "";
        if($fecha_desde){
            $fecha_desdeV = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " fm_fecha_recepcion >= TO_DATE('{$fecha_desdeV->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($fecha_hasta && $where != ""){
            $where .= " AND";
        }
        if($fecha_hasta){
            $fecha_hastaV = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " fm_fecha_recepcion <= TO_DATE('{$fecha_hastaV->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($tipo_certificado && $where != ""){
            $where .= " AND";
        }
        if($tipo_certificado){
            $where .= " fm_tipo_certificado = {$tipo_certificado}";
        }

        $datos = $this->obtener_vista_ficha_medica("*","","fm_fecha_recepcion desc, fm_id desc", $where);
        date_default_timezone_set('America/Guayaquil');
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();
        
        $a = date("Y");
        $m = date("m");
        $d = date("d");
        $h = date("H");
        $ii = date("i");
        $s = date("s");
        $mes = '';

        switch ($m) {
            case '1':
                $mes = "Enero";
                break;

            case '2':
                $mes = "Febrero";
                break;

            case '3':
                $mes = "Marzo";
                break;

            case '4':
                $mes = "Abril";
                break;

            case '5':
                $mes = "Mayo";
                break;

            case '6':
                $mes = "Junio";
                break;

            case '7':
                $mes = "Julio";
                break;
            case '8':
                $mes = "Agosto";
                break;
            case '9':
                $mes = "Septiembre";
                break;
            case '10':
                $mes = "Octubre";
                break;
            case '11':
                $mes = "Noviembre";
                break;
            case '12':
                $mes = "Diciembre";
                break;

                $mes = "";
        }

        $fecharepo = $a . '-' . $mes . '-' . $d;

        foreach($datos as $dato){
            $tipo_certificado_dato = "CERTIFICADO POR DÍAS";
            if($dato->fm_tipo_certificado == 2){
                $tipo_certificado_dato = "CERTIFICADO POR HORAS";
            }
            if($dato->fm_tipo_certificado == 3){
                $tipo_certificado_dato = "REVISIÓN MÉDICA";
            }
            $dato->tipo_certificado = $tipo_certificado_dato;

            $medico_certifica = "";
            if (trim($dato->me_apellidos) != "NO ASIGNADO"){
                $medico_certifica = "{$dato->me_apellidos} {$dato->me_nombres}";
            }
            $dato->medico_certifica = $medico_certifica;

            $fecha_inicio_certificado = "-";
            $fecha_fin_certificado = "-";

            if ($dato->fm_tipo_certificado == 1){
                $fecha_inicio_certificado = $dato->fm_fecha_inicio_certificado;
                $fecha_fin_certificado = $dato->fm_fecha_fin_certificado;
            }
            
            if ($dato->fm_tipo_certificado == 2){
                $fecha_inicio_certificado = "{$dato->fm_fecha_inicio_certificado} {$dato->fm_hora_inicio_certificado}";
                $fecha_fin_certificado = "{$dato->fm_fecha_fin_certificado} {$dato->fm_hora_fin_certificado}";
            }

            $entidad_certifica = '';

            if ($dato->entidad_certifica == 1){
                $entidad_certifica = 'IESS';
            }
            
            if ($dato->entidad_certifica == 2){
                $entidad_certifica = 'PARTICULAR';
            }

            if ($dato->entidad_certifica == 3){
                $entidad_certifica = 'MINISTERIO DE SALUD';
            }

            $dato->fecha_inicio_certificado = $fecha_inicio_certificado;
            $dato->fecha_fin_certificado = $fecha_fin_certificado;
            $dato->entidad_certifica = $entidad_certifica;
        }

        $arrayValues = [];
        $i = 8;
        foreach ($datos as &$dato) {
            $arrayValues[] = ['column'=>"A{$i}", 'value'=> $dato->fm_fecha_recepcion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"B{$i}", 'value'=> $dato->emp_cedula, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"C{$i}", 'value'=> "{$dato->emp_apellido} {$dato->emp_nombre}", 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"D{$i}", 'value'=> $dato->jefe, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"E{$i}", 'value'=> $dato->tipo_certificado, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"F{$i}", 'value'=> $dato->tipo_permiso, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"G{$i}", 'value'=> $dato->dep_departamento, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"H{$i}", 'value'=> $dato->emp_cargo, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"I{$i}", 'value'=> $dato->fecha_inicio_certificado, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"J{$i}", 'value'=> $dato->fecha_fin_certificado, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"K{$i}", 'value'=> $dato->total_horas, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"L{$i}", 'value'=> $dato->entidad_certifica, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"M{$i}", 'value'=> $dato->medico_certifica, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"N{$i}", 'value'=> $dato->cm_descripcion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"O{$i}", 'value'=> $dato->dm_cie10, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"P{$i}", 'value'=> $dato->dm_descripcion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"Q{$i}", 'value'=> $dato->fm_observacion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $i++;
        }

        $spreadsheet = ExcelHelper::ContructSpreadsheet(
            [
                ['columns'=>'A1:K1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A2:K2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A3:K3', 'value'=> "REPORTE DE CERTIFICADOS MÉDICOS", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A4:K4', 'value'=> "FECHA DESDE: {$fecha_desde} || FECHA HASTA: {$fecha_hasta}", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A5:K5', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
            ],
            [
                ['column' => 'A7', 'value' => 'FECHA DE RECEPCIÓN'],
                ['column' => 'B7', 'value' => 'CÉDULA'],
                ['column' => 'C7', 'value' => 'EMPLEADO'],
                ['column' => 'D7', 'value' => 'JEFE'],
                ['column' => 'E7', 'value' => 'TIPO DE CERTIFICADO'],
                ['column' => 'F7', 'value' => 'TIPO DE PERMISO'],
                ['column' => 'G7', 'value' => 'DEPARTAMENTO'],
                ['column' => 'H7', 'value' => 'CARGO'],
                ['column' => 'I7', 'value' => 'FECHA INICIO CERTIFICADO'],
                ['column' => 'J7', 'value' => 'FECHA FIN CERTIFICADO'],
                ['column' => 'K7', 'value' => 'TIEMPO DE PERMISO'],
                ['column' => 'L7', 'value' => 'ENTIDAD QUE CERTIFICA'],
                ['column' => 'M7', 'value' => 'MEDICO QUE CERTIFICA'],
                ['column' => 'N7', 'value' => 'CAUSA'],
                ['column' => 'O7', 'value' => 'CIE 10'],
                ['column' => 'P7', 'value' => 'DIAGNOSTICO'],
                ['column' => 'Q7', 'value' => 'OBSERVACIÓN'],
            ],
            $arrayValues,
            [
                ['columns'=> 'A7:Q7', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
            ]
        );

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE CERTIFICADOS MEDICOS.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function reporte_pdf_certificados_medicos($fecha_desde = null, $fecha_hasta = null, $tipo_certificado = null){
        $where = "";
        if($fecha_desde){
            $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " fm_fecha_recepcion >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($fecha_hasta && $where != ""){
            $where .= " AND";
        }
        if($fecha_hasta){
            $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " fm_fecha_recepcion <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($tipo_certificado && $where != ""){
            $where .= " AND";
        }
        if($tipo_certificado){
            $where .= " fm_tipo_certificado = {$tipo_certificado}";
        }

        $datos = $this->obtener_vista_ficha_medica("*","","fm_fecha_recepcion desc, fm_id desc", $where);
        //return $datos[0];
        date_default_timezone_set('America/Guayaquil');
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();
        
        $a = date("Y");
        $m = date("m");
        $d = date("d");
        $h = date("H");
        $ii = date("i");
        $s = date("s");
        $mes = '';

        foreach($datos as $dato){
            $tipo_certificado_dato = "CERTIFICADO POR DÍAS";
            if($dato->fm_tipo_certificado == 2){
                $tipo_certificado_dato = "CERTIFICADO POR HORAS";
            }
            if($dato->fm_tipo_certificado == 3){
                $tipo_certificado_dato = "REVISIÓN MÉDICA";
            }
            $dato->tipo_certificado = $tipo_certificado_dato;

            $medico_certifica = "";
            if (trim($dato->me_apellidos) != "NO ASIGNADO"){
                $medico_certifica = "{$dato->me_apellidos} {$dato->me_nombres}";
            }
            $dato->medico_certifica = $medico_certifica;
            $dato->nombre_empleado = "{$dato->emp_apellido} {$dato->emp_nombre}";

            $fecha_inicio_certificado = "-";
            $fecha_fin_certificado = "-";

            if ($dato->fm_tipo_certificado == 1){
                $fecha_inicio_certificado = $dato->fm_fecha_inicio_certificado;
                $fecha_fin_certificado = $dato->fm_fecha_fin_certificado;
            }
            
            if ($dato->fm_tipo_certificado == 2){
                $fecha_inicio_certificado = "{$dato->fm_fecha_inicio_certificado} {$dato->fm_hora_inicio_certificado}";
                $fecha_fin_certificado = "{$dato->fm_fecha_fin_certificado} {$dato->fm_hora_fin_certificado}";
            }

            $entidad_certifica = '';

            if ($dato->entidad_certifica == 1){
                $entidad_certifica = 'IESS';
            }
            
            if ($dato->entidad_certifica == 2){
                $entidad_certifica = 'PARTICULAR';
            }

            if ($dato->entidad_certifica == 3){
                $entidad_certifica = 'MINISTERIO DE SALUD';
            }

            $dato->fecha_inicio_certificado = $fecha_inicio_certificado;
            $dato->fecha_fin_certificado = $fecha_fin_certificado;
            $dato->entidad_certifica = $entidad_certifica;
        }

        $html = view('Generico.Reports.report_table_movilidad_manta', [
            'titleReport' => 'Reporte de Certificados Médicos',
            'titlesHeader' => ["<span class='titulo3'>Usuario: {$user} || Fecha: {$fecha} || Hora: {$hora}</span>"],
            'titlesHeaderTable' => ["FECHA RECEPCIÓN","CÉDULA", "EMPLEADO", "JEFE", "TIPO DE CERTIFICADO", "TIPO DE PERMISO", "DEPARTAMENTO", "CARGO", "FECHA INICIO CERTIFICADO",
            "FECHA FIN CERTIFICADO","TIEMPO DE PERMISO", "ENTIDAD QUE CERTIFICA", "MEDICO QUE CERTIFICA", "CAUSA", "CIE 10", "DIAGNOSTICO","OBSERVACIÓN"],
            "columnsTable"=> ["fm_fecha_recepcion","emp_cedula","nombre_empleado","jefe","tipo_certificado", "tipo_permiso","dep_departamento","emp_cargo","fecha_inicio_certificado","fecha_fin_certificado","total_horas", "entidad_certifica", "medico_certifica","cm_descripcion","dm_cie10","dm_descripcion","fm_observacion"],
            'items'=>$datos
        ])->render();
        $namefile = 'ReporteCertificadosMedicos_' . time() . '.pdf';
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
            // "format" => "A4",
            "format" => [264.8, 188.9],
        ]);
        // $mpdf->SetTopMargin(5);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->debug = true;
        $mpdf->showImageErrors = true;
        $mpdf->Output($namefile, "D");
    }

    public function get_certificados_medicos_data($fecha_desde = null, $fecha_hasta = null, $tipo_certificado = null)
    {
        $where = "";
        if($fecha_desde){
            $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " fm_fecha_recepcion >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($fecha_hasta && $where != ""){
            $where .= " AND";
        }
        if($fecha_hasta){
            $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " fm_fecha_recepcion <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($tipo_certificado && $where != ""){
            $where .= " AND";
        }
        if($tipo_certificado){
            $where .= " fm_tipo_certificado = {$tipo_certificado}";
        }

        $certificado = $this->obtener_vista_ficha_medica("*","","fm_fecha_recepcion desc, fm_id desc", $where);
        return $certificado;
    }

    public function create_reporte_certificados()
    {
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            return view('Administrador.Medico.reporte_solicitud_permiso_medico', compact('menus_'));
        } else {
            return Redirect("/");
        }
    }

    public function reportes_graficos()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();

        //return $usuario;
        return view('Administrador.Medico.Reportes.reportes_graficos', compact('menus_'));
    }

    public function certificado_getExcel()
    {
        $spreadsheet = new Spreadsheet();

        // Obtener la hoja activa
        $sheet = $spreadsheet->getActiveSheet();

        // Definir los datos para el gráfico de pastel
        $data = [
            ['Categoria', 'Cantidad'],
            ['Categoría 1', 100],
            ['Categoría 2', 200],
            ['Categoría 3', 300],
        ];

        // Agregar los datos a la hoja de cálculo
        $sheet->fromArray($data, null, 'A1');

        ExcelHelper::AddPieChart($sheet, 'sampleChart',
        'Test Pie Chart', 'Value ($k)', 
        \PhpOffice\PhpSpreadsheet\Chart\Legend::POSITION_RIGHT, 
        'A7', 'H20', false,
        [
            [
                'tipo'=>\PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_STRING, 
                'hojas'=>'Worksheet!$A$2:$A$4',
                'num_hojas'=>3
            ]
        ], 
        [
            [
                'tipo'=>\PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_NUMBER, 
                'hojas'=>'Worksheet!$B$2:$B$4',
                'num_hojas'=>3
            ]
        ], 
        [
            [
                'tipo'=>\PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_STRING, 
                'hojas'=>'Worksheet!$A$2:$A$4',
                'num_hojas'=>1
            ]
        ]);

        // Guardar el archivo Excel
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $fileName = 'excel_with_pie_chart.xlsx';
        $writer->setIncludeCharts(true);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        exit;

    }

    public function get_report($tipo_reporte, $fecha_desde, $fecha_hasta, $limit, $tipo_certificado = "")
    {
        $select = "";
        $groupBy = "";
        $orderBy = "";

        $where = "";
        $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
        $where .= " fm_fecha_recepcion >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        $where .= " AND";
        $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
        $where .= " fm_fecha_recepcion <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        if($tipo_certificado != "" && $where != ""){
            $where .= " AND";
        }
        if($tipo_certificado != ""){
            $where .= " fm_tipo_certificado = {$tipo_certificado}";
        }

        if($tipo_reporte == 0){
            $select = "dm_cie10, dm_descripcion, COUNT(*) AS conteo";
            $groupBy = "dm_cie10, dm_descripcion";
            $orderBy = "conteo DESC";
        }

        if($tipo_reporte == 1){
            $select = "emp_cedula, concat(emp_apellido, ' ', emp_nombre) AS empleado, COUNT(*) AS conteo";
            $groupBy = "emp_cedula, concat(emp_apellido, ' ', emp_nombre)";
            $orderBy = "conteo DESC";
        }

        if($tipo_reporte == 2){
            $select = "ROUND(SUM(EXTRACT(EPOCH FROM (
                CONCAT(
                    TO_CHAR(fm_fecha_fin_certificado + CASE WHEN fm_tipo_certificado = 1 THEN INTERVAL '1 day' ELSE INTERVAL '0 day' END, 'YYYY-MM-DD'), 
                    ' ', 
                    fm_hora_fin_certificado
                )::timestamp - CONCAT(TO_CHAR(fm_fecha_inicio_certificado, 'YYYY-MM-DD'), ' ', fm_hora_inicio_certificado)::timestamp)) / 86400), 0) as horas, emp_cedula, CONCAT(emp_apellido, ' ', emp_nombre) as empleado";

             if($tipo_certificado == ""){
                $where .= " AND fm_tipo_certificado IN (1,2)";
             }

            $groupBy = "emp_cedula, concat(emp_apellido, ' ', emp_nombre)";
            $orderBy = "horas desc";
        }

        $datos = $this->obtener_vista_registros_medicos($select,$where,$groupBy,$orderBy,$limit);
        return $datos;
    }

    public function get_report_details($tipo, $cedula, $tipo_reporte, $fecha_desde, $fecha_hasta, $limit, $tipo_certificado = "")
    {
        $select = "";
        $groupBy = "";
        $orderBy = "";

        $where = "";
        $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
        $where .= " fm_fecha_recepcion >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        $where .= " AND";
        $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
        $where .= " fm_fecha_recepcion <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        if($tipo_certificado != "" && $where != ""){
            $where .= " AND";
        }
        if($tipo_certificado != ""){
            $where .= " fm_tipo_certificado = {$tipo_certificado}";
        }

        if($tipo_reporte == 0){
            $select = "*";
            $where .= " AND dm_cie10 = '$cedula'";
            $orderBy = "fm_id DESC";
        }

        if($tipo_reporte == 1){
            $select = "*";
            $where .= " AND emp_cedula = '$cedula'";
            $orderBy = "fm_id DESC";
        }

        if($tipo_reporte == 2){
            $select = "*";
            $where .= " AND fm_tipo_certificado IN (1,2) AND emp_cedula = '$cedula'";
            $orderBy = "fm_id desc";
        }

        $datos = $this->obtener_vista_registros_medicos($select,$where,$groupBy,$orderBy,$limit);
        return $datos;
    }

    public function get_report_details_report_excel($tipo, $cedula, $tipo_reporte, $fecha_desde, $fecha_hasta, $limit, $tipo_certificado = ""){
        $select = "";
        $groupBy = "";
        $orderBy = "";

        $where = "";
        $fecha_desdeV = DateTime::createFromFormat('Ymd',  $fecha_desde);
        $where .= " fm_fecha_recepcion >= TO_DATE('{$fecha_desdeV->format("d/m/Y")}', 'DD/MM/YYYY')";
        $where .= " AND";
        $fecha_hastaV = DateTime::createFromFormat('Ymd',  $fecha_hasta);
        $where .= " fm_fecha_recepcion <= TO_DATE('{$fecha_hastaV->format("d/m/Y")}', 'DD/MM/YYYY')";
        if($tipo_certificado != "" && $where != ""){
            $where .= " AND";
        }
        if($tipo_certificado != ""){
            $where .= " fm_tipo_certificado = {$tipo_certificado}";
        }

        if($tipo_reporte == 0){
            $select = "*";
            $where .= " AND dm_cie10 = '$cedula'";
            $orderBy = "fm_id DESC";
        }

        if($tipo_reporte == 1){
            $select = "*";
            $where .= " AND emp_cedula = '$cedula'";
            $orderBy = "fm_id DESC";
        }

        if($tipo_reporte == 2){
            $select = "*";
            $where .= " AND fm_tipo_certificado IN (1,2) AND emp_cedula = '$cedula'";
            $orderBy = "fm_id desc";
        }

        $datos = $this->obtener_vista_registros_medicos($select,$where,$groupBy,$orderBy,$limit);

        date_default_timezone_set('America/Guayaquil');
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();
        
        $a = date("Y");
        $m = date("m");
        $d = date("d");
        $h = date("H");
        $ii = date("i");
        $s = date("s");
        $mes = '';

        switch ($m) {
            case '1':
                $mes = "Enero";
                break;

            case '2':
                $mes = "Febrero";
                break;

            case '3':
                $mes = "Marzo";
                break;

            case '4':
                $mes = "Abril";
                break;

            case '5':
                $mes = "Mayo";
                break;

            case '6':
                $mes = "Junio";
                break;

            case '7':
                $mes = "Julio";
                break;
            case '8':
                $mes = "Agosto";
                break;
            case '9':
                $mes = "Septiembre";
                break;
            case '10':
                $mes = "Octubre";
                break;
            case '11':
                $mes = "Noviembre";
                break;
            case '12':
                $mes = "Diciembre";
                break;

                $mes = "";
        }

        $fecharepo = $a . '-' . $mes . '-' . $d;

        foreach($datos as $dato){
            $tipo_certificado_dato = "CERTIFICADO POR DÍAS";
            if($dato->fm_tipo_certificado == 2){
                $tipo_certificado_dato = "CERTIFICADO POR HORAS";
            }
            if($dato->fm_tipo_certificado == 3){
                $tipo_certificado_dato = "REVISIÓN MÉDICA";
            }
            $dato->tipo_certificado = $tipo_certificado_dato;

            $medico_certifica = "";
            if (trim($dato->me_apellidos) != "NO ASIGNADO"){
                $medico_certifica = "{$dato->me_apellidos} {$dato->me_nombres}";
            }
            $dato->medico_certifica = $medico_certifica;

            $fecha_inicio_certificado = "-";
            $fecha_fin_certificado = "-";

            if ($dato->fm_tipo_certificado == 1){
                $fecha_inicio_certificado = $dato->fm_fecha_inicio_certificado;
                $fecha_fin_certificado = $dato->fm_fecha_fin_certificado;
            }
            
            if ($dato->fm_tipo_certificado == 2){
                $fecha_inicio_certificado = "{$dato->fm_fecha_inicio_certificado} {$dato->fm_hora_inicio_certificado}";
                $fecha_fin_certificado = "{$dato->fm_fecha_fin_certificado} {$dato->fm_hora_fin_certificado}";
            }

            $entidad_certifica = '';

            if ($dato->entidad_certifica == 1){
                $entidad_certifica = 'IESS';
            }
            
            if ($dato->entidad_certifica == 2){
                $entidad_certifica = 'PARTICULAR';
            }

            if ($dato->entidad_certifica == 3){
                $entidad_certifica = 'MINISTERIO DE SALUD';
            }

            $dato->fecha_inicio_certificado = $fecha_inicio_certificado;
            $dato->fecha_fin_certificado = $fecha_fin_certificado;
            $dato->entidad_certifica = $entidad_certifica;
        }

        $arrayValues = [];
        $i = 8;
        foreach ($datos as &$dato) {
            $arrayValues[] = ['column'=>"A{$i}", 'value'=> $dato->fm_fecha_recepcion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"B{$i}", 'value'=> $dato->emp_cedula, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"C{$i}", 'value'=> "{$dato->emp_apellido} {$dato->emp_nombre}", 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"D{$i}", 'value'=> $dato->jefe, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"E{$i}", 'value'=> $dato->tipo_certificado, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"F{$i}", 'value'=> $dato->tipo_permiso, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"G{$i}", 'value'=> $dato->dep_departamento, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"H{$i}", 'value'=> $dato->emp_cargo, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"I{$i}", 'value'=> $dato->fecha_inicio_certificado, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"J{$i}", 'value'=> $dato->fecha_fin_certificado, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"K{$i}", 'value'=> $dato->total_horas, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"L{$i}", 'value'=> $dato->entidad_certifica, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"M{$i}", 'value'=> $dato->medico_certifica, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"N{$i}", 'value'=> $dato->cm_descripcion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"O{$i}", 'value'=> $dato->dm_cie10, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"P{$i}", 'value'=> $dato->dm_descripcion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"Q{$i}", 'value'=> $dato->fm_observacion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $i++;
        }

        $spreadsheet = ExcelHelper::ContructSpreadsheet(
            [
                ['columns'=>'A1:K1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A2:K2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A3:K3', 'value'=> "REPORTE DE CERTIFICADOS MÉDICOS", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A4:K4', 'value'=> "FECHA DESDE: {$fecha_desde} || FECHA HASTA: {$fecha_hasta}", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A5:K5', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
            ],
            [
                ['column' => 'A7', 'value' => 'FECHA DE RECEPCIÓN'],
                ['column' => 'B7', 'value' => 'CÉDULA'],
                ['column' => 'C7', 'value' => 'EMPLEADO'],
                ['column' => 'D7', 'value' => 'JEFE'],
                ['column' => 'E7', 'value' => 'TIPO DE CERTIFICADO'],
                ['column' => 'F7', 'value' => 'TIPO DE PERMISO'],
                ['column' => 'G7', 'value' => 'DEPARTAMENTO'],
                ['column' => 'H7', 'value' => 'CARGO'],
                ['column' => 'I7', 'value' => 'FECHA INICIO CERTIFICADO'],
                ['column' => 'J7', 'value' => 'FECHA FIN CERTIFICADO'],
                ['column' => 'K7', 'value' => 'TIEMPO DE PERMISO'],
                ['column' => 'L7', 'value' => 'ENTIDAD QUE CERTIFICA'],
                ['column' => 'M7', 'value' => 'MEDICO QUE CERTIFICA'],
                ['column' => 'N7', 'value' => 'CAUSA'],
                ['column' => 'O7', 'value' => 'CIE 10'],
                ['column' => 'P7', 'value' => 'DIAGNOSTICO'],
                ['column' => 'Q7', 'value' => 'OBSERVACIÓN'],
            ],
            $arrayValues,
            [
                ['columns'=> 'A7:Q7', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
            ]
        );

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE CERTIFICADOS MEDICOS.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    private function obtener_vista_registros_medicos($select = "*", $whereConsult = "", $groupByConsult = "", $orderBy = "", $limitConsult = "")
    {
        $where = "";
        $order = "";
        $groupBy ="";
        $limit = "";
        if($orderBy != ""){
            $order = "ORDER BY {$orderBy}";
        }
        if($whereConsult != ""){
            $where = "WHERE {$whereConsult}";
        }
        if($groupByConsult != ""){
            $groupBy = "GROUP BY {$groupByConsult}";
        }
        if($limitConsult != ""){
            $limit = "LIMIT {$limitConsult}";
        }
        $datos = DB::select("select {$select} from medico.view_reporte_medico {$where} {$groupBy} {$order} {$limit}");
        return $datos;
    }

    public function get_excel_report($tipo_reporte, $fecha_desde, $fecha_hasta, $limit, $tipo_certificado = ""){

        $select = "";
        $groupBy = "";
        $orderBy = "";

        $where = "";
        $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
        $where .= " fm_fecha_recepcion >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        $where .= " AND";
        $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
        $where .= " fm_fecha_recepcion <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        if($tipo_certificado != "" && $where != ""){
            $where .= " AND";
        }
        if($tipo_certificado != ""){
            $where .= " fm_tipo_certificado = {$tipo_certificado}";
        }

        if($tipo_reporte == 0){
            $select = "dm_cie10, dm_descripcion, COUNT(*) AS conteo";
            $groupBy = "dm_cie10, dm_descripcion";
            $orderBy = "conteo DESC";
        }
        if($tipo_reporte == 1){
            $select = "emp_cedula, concat(emp_apellido, ' ', emp_nombre) AS empleado, COUNT(*) AS conteo";
            $groupBy = "emp_cedula, concat(emp_apellido, ' ', emp_nombre)";
            $orderBy = "conteo DESC";
        }
        if($tipo_reporte == 2){
            $select = "ROUND(SUM(EXTRACT(EPOCH FROM (
                CONCAT(
                    TO_CHAR(fm_fecha_fin_certificado + CASE WHEN fm_tipo_certificado = 1 THEN INTERVAL '1 day' ELSE INTERVAL '0 day' END, 'YYYY-MM-DD'), 
                    ' ', 
                    fm_hora_fin_certificado
                )::timestamp - CONCAT(TO_CHAR(fm_fecha_inicio_certificado, 'YYYY-MM-DD'), ' ', fm_hora_inicio_certificado)::timestamp)) / 86400), 0) as horas, emp_cedula, CONCAT(emp_apellido, ' ', emp_nombre) as empleado";
            if($tipo_certificado == ""){
                $where .= " AND fm_tipo_certificado IN (1,2)";
             }
            $groupBy = "emp_cedula, concat(emp_apellido, ' ', emp_nombre)";
            $orderBy = "horas desc";
        }

        $datos = $this->obtener_vista_registros_medicos($select,$where,$groupBy,$orderBy,$limit);

        date_default_timezone_set('America/Guayaquil');
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();
        
        $a = date("Y");
        $m = date("m");
        $d = date("d");
        $h = date("H");
        $ii = date("i");
        $s = date("s");
        $mes = '';

        switch ($m) {
            case '1':
                $mes = "Enero";
                break;

            case '2':
                $mes = "Febrero";
                break;

            case '3':
                $mes = "Marzo";
                break;

            case '4':
                $mes = "Abril";
                break;

            case '5':
                $mes = "Mayo";
                break;

            case '6':
                $mes = "Junio";
                break;

            case '7':
                $mes = "Julio";
                break;
            case '8':
                $mes = "Agosto";
                break;
            case '9':
                $mes = "Septiembre";
                break;
            case '10':
                $mes = "Octubre";
                break;
            case '11':
                $mes = "Noviembre";
                break;
            case '12':
                $mes = "Diciembre";
                break;

                $mes = "";
        }

        $fecharepo = $a . '-' . $mes . '-' . $d;

        $arrayValues = [];

        $i = 23;

        if($tipo_reporte == 0){

            foreach ($datos as &$dato) {
                $arrayValues[] = ['column'=>"A{$i}", 'value'=> $dato->dm_cie10, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
                $arrayValues[] = ['column'=>"B{$i}", 'value'=> $dato->dm_descripcion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
                $arrayValues[] = ['column'=>"C{$i}", 'value'=> $dato->conteo, 'type' =>PHPExcel_Cell_DataType::TYPE_NUMERIC];
                $i++;
            }

            $spreadsheet = ExcelHelper::ContructSpreadsheet(
                [
                    ['columns'=>'A1:C1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                    ['columns'=>'A2:C2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                    ['columns'=>'A3:C3', 'value'=> "REPORTE DE DIAGNOSTICOS MEDICOS", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                    ['columns'=>'A4:C4', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
                ],
                [
                    ['column' => 'A22', 'value' => 'CÓDIGO CIE10'],
                    ['column' => 'B22', 'value' => 'DIAGNOSTICO'],
                    ['column' => 'C22', 'value' => 'CANTIDAD'],
                ],
                $arrayValues,
                [
                    ['columns'=> 'A22:C22', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
                ]
            );
        }

        if($tipo_reporte == 1){

            foreach ($datos as &$dato) {
                $arrayValues[] = ['column'=>"A{$i}", 'value'=> $dato->emp_cedula, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
                $arrayValues[] = ['column'=>"B{$i}", 'value'=> $dato->empleado, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
                $arrayValues[] = ['column'=>"C{$i}", 'value'=> $dato->conteo, 'type' =>PHPExcel_Cell_DataType::TYPE_NUMERIC];
                $i++;
            }

            $spreadsheet = ExcelHelper::ContructSpreadsheet(
                [
                    ['columns'=>'A1:C1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                    ['columns'=>'A2:C2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                    ['columns'=>'A3:C3', 'value'=> "REPORTE DE EMPELADOS ATENDIDOS", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                    ['columns'=>'A4:C4', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
                ],
                [
                    ['column' => 'A22', 'value' => 'CÉDULA'],
                    ['column' => 'B22', 'value' => 'APELLIDOS Y NOMBRES'],
                    ['column' => 'C22', 'value' => 'CANTIDAD'],
                ],
                $arrayValues,
                [
                    ['columns'=> 'A22:C22', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
                ]
            );
        }

        if($tipo_reporte == 2){

            foreach ($datos as &$dato) {
                $arrayValues[] = ['column'=>"A{$i}", 'value'=> $dato->emp_cedula, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
                $arrayValues[] = ['column'=>"B{$i}", 'value'=> $dato->empleado, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
                $arrayValues[] = ['column'=>"C{$i}", 'value'=> $dato->horas, 'type' =>PHPExcel_Cell_DataType::TYPE_NUMERIC];
                $i++;
            }

            $spreadsheet = ExcelHelper::ContructSpreadsheet(
                [
                    ['columns'=>'A1:C1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                    ['columns'=>'A2:C2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                    ['columns'=>'A3:C3', 'value'=> "REPORTE DE PERMISOS MEDICOS", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                    ['columns'=>'A4:C4', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
                ],
                [
                    ['column' => 'A22', 'value' => 'CÉDULA'],
                    ['column' => 'B22', 'value' => 'APELLIDOS Y NOMBRES'],
                    ['column' => 'C22', 'value' => 'DÍAS DE PERMISO'],
                ],
                $arrayValues,
                [
                    ['columns'=> 'A22:C22', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
                ]
            );
        }

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }

         $titulo = "TOP DE DIAGNOSTICOS";
         if($tipo_reporte == 1){
            $titulo = "TOP DE ATENCIONES MÉDICAS";
         }
         if($tipo_reporte == 2){
            $titulo = "TOP DE PERMISOS MEDICOS";
         }

         ExcelHelper::AddPieChart($sheet, 'sampleChart',
            $titulo, 'Value ($k)', 
            \PhpOffice\PhpSpreadsheet\Chart\Legend::POSITION_RIGHT, 
            'A7', 'D20', false,
            [
                [
                    'tipo'=>\PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_STRING, 
                    'hojas'=>'Worksheet!$B$23:$B$' . $i -1,
                    'num_hojas'=>3
                ]
            ], 
            [
                [
                    'tipo'=>\PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_NUMBER, 
                    'hojas'=>'Worksheet!$C$23:$C$' . $i -1,
                    'num_hojas'=>3
                ]
            ], 
            [
                [
                    'tipo'=>\PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_STRING, 
                    'hojas'=>'Worksheet!$B$23:$B$' . $i -1,
                    'num_hojas'=>1
                ]
            ]);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->setIncludeCharts(true);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE MEDICO.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        exit;
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
