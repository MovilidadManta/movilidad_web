<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use DateTime;
use File;
use Storage;
use Carbon\Carbon;

use Mpdf\Mpdf;
use App\Helpers\ExcelHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel_Cell_DataType;

class MarcacionesEmpleadosRemotoController extends Controller
{
    public function index()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.MarcacionesEmpleadosRemoto.index', compact('menus_'));
    }

    public function get_empleados_remotos()
    {
        $sql = "SELECT * FROM view_tbl_conf_empleado_remoto ORDER BY cer_id DESC";

        $list = DB::Select($sql);

        DB::disconnect();
        return $list;
    }

    public function store(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');
        $emp_id = $request->input('emp_id');
        $fecha_inicio = DateTime::createFromFormat('Y-m-d', $request->input('cer_fecha_inicio'));
        $fecha_fin = $request->filled('cer_fecha_fin') 
                        ? DateTime::createFromFormat('Y-m-d', $request->input('cer_fecha_fin')) 
                        : null;

        $sql = "SELECT * FROM view_tbl_conf_empleado_remoto 
                WHERE emp_id = {$emp_id} AND cer_estado = true AND (
                (cer_tiene_fecha_fin = FALSE AND TO_DATE('{$fecha_inicio->format("d/m/Y")}', 'DD/MM/YYYY') >= cer_fecha_inicio) OR 
                (cer_tiene_fecha_fin = TRUE AND TO_DATE('{$fecha_inicio->format("d/m/Y")}', 'DD/MM/YYYY') BETWEEN cer_fecha_inicio AND cer_fecha_fin)
                )
                ORDER BY cer_id DESC LIMIT 1";

        $list = DB::Select($sql);

        DB::disconnect();
        if(count($list) > 0){
            return response()->json(["respuesta" => "false", "cod" => "HAVE_ACTIVE"]);
        }

        $json[] = [
            'emp_id' => $emp_id,
            'cer_fecha_inicio' => $fecha_inicio->format("Y/m/d"),
            'cer_fecha_fin' => $fecha_fin ? $fecha_fin->format("Y/m/d") : null,
            'cer_tiene_fecha_fin' => $request->boolean('cer_tiene_fecha_fin')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_tbl_conf_empleado_remoto(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_conf_empleado_remoto;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function update(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');
        $fecha_inicio = DateTime::createFromFormat('Y-m-d', $request->input('cer_fecha_inicio'));
        $fecha_fin = $request->filled('cer_fecha_fin') 
                        ? DateTime::createFromFormat('Y-m-d', $request->input('cer_fecha_fin')) 
                        : null;

        $json[] = [
            'cer_id' => $request->input('cer_id'),
            'cer_fecha_inicio' => $fecha_inicio->format("Y/m/d"),
            'cer_fecha_fin' => $fecha_fin ? $fecha_fin->format("Y/m/d") : null,
            'cer_tiene_fecha_fin' => $request->boolean('cer_tiene_fecha_fin')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_modificar_tbl_conf_empleado_remoto(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_conf_empleado_remoto;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function change_state(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'cer_id' => $request->input('cer_id'),
            'cer_estado' => $request->boolean('cer_estado')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_des_hab_tbl_conf_empleado_remoto(?,?,?)', [$jsoninsert, $ip, $user]);
        DB::disconnect();
        foreach ($sql as $s) {
            $id = $s->procedimiento_des_hab_tbl_conf_empleado_remoto;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }


    public function indexMarcacionesEmpleadoRemoto()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.MarcacionesEmpleadosRemoto.reporte_marcaciones_empleado', compact('menus_'));
    }

    public function get_empleados_remotos_search($limit, $text)
    {
        $text = str_replace("'", "\'", $text);
        $sql = DB::connection('pgsql')->select("
        SELECT DISTINCT ve.emp_id, ve.emp_cedula, ve.emp_nombre, ve.emp_apellido, ve.emp_telefono, ve.emp_direccion, ve.emp_ruta_foto, 
        ve.emp_sexo, ve.emp_cargo, ve.emp_fecha_nacimiento, ve.emp_tipo_sangre, ve.dep_departamento, ve.ca_cargo, ve.emp_edad  
        from view_empleados_t as ve
        INNER JOIN tbl_conf_empleado_remoto as er ON ve.emp_id = er.emp_id
        WHERE upper(concat(ve.emp_cedula, ' ', ve.emp_apellido, ' ', ve.emp_nombre)) like E'%" . strtoupper($text) . "%' AND 
        ve.emp_estado = 'A' LIMIT $limit");

        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    private function get_conf_empleados_remoto_marcaciones_sql($fecha_inicio, $fecha_fin, $emp_id){
        $fecha_inicio = DateTime::createFromFormat('Ymd',  $fecha_inicio);
        $fecha_fin = DateTime::createFromFormat('Ymd',  $fecha_fin);
        $sql = "SELECT * FROM view_tbl_conf_empleado_remoto
        WHERE TO_DATE('{$fecha_inicio->format("d/m/Y")}', 'DD/MM/YYYY') >= cer_fecha_inicio  AND
        emp_id = {$emp_id} AND
        (
        cer_tiene_fecha_fin = false OR
         TO_DATE('{$fecha_fin->format("d/m/Y")}', 'DD/MM/YYYY') <= cer_fecha_fin 
        )
        ORDER BY cer_id DESC";

        $list = DB::Select($sql);

        DB::disconnect();
        return $list;
    }

    public function get_conf_empleados_remoto_marcaciones($fecha_inicio, $fecha_fin, $emp_id)
    {
        return $this->get_conf_empleados_remoto_marcaciones_sql($fecha_inicio, $fecha_fin, $emp_id);
    }

    public function get_excel_conf_remoto_empleado($fecha_desde, $fecha_hasta, $emp_id){

        $datos = $this->get_conf_empleados_remoto_marcaciones_sql($fecha_desde, $fecha_hasta, $emp_id);

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
            $fecha_fin = "INDEFINIDO";
            $estado_conf = "INACTIVO";

            if($dato->cer_tiene_fecha_fin){
                $fecha_fin = $dato->cer_fecha_fin;
            }

            if($dato->cer_estado){
                $estado_conf = "ACTIVO";
            }

            $dato->des_fecha_fin = $fecha_fin;
            $dato->des_estado = $estado_conf;
        }

        $arrayValues = [];
        $i = 8;

        foreach ($datos as &$dato) {
            $arrayValues[] = ['column'=>"A{$i}", 'value'=> $dato->cer_id, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"B{$i}", 'value'=> $dato->emp_cedula, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"C{$i}", 'value'=> "{$dato->emp_apellido} {$dato->emp_nombre}", 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"D{$i}", 'value'=> $dato->emp_fecha_nacimiento, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"E{$i}", 'value'=> $dato->dep_departamento, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"F{$i}", 'value'=> $dato->ca_cargo, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"G{$i}", 'value'=> $dato->cer_fecha_inicio, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"H{$i}", 'value'=> $dato->des_fecha_fin, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"I{$i}", 'value'=> $dato->des_estado, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $i++;
        }

        $spreadsheet = ExcelHelper::ContructSpreadsheet(
            [
                ['columns'=>'A1:I1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A2:I2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A3:I3', 'value'=> "REPORTE DE MARCACIONES", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A4:I4', 'value'=> "FECHA DESDE: {$fecha_desde} || FECHA HASTA: {$fecha_hasta}", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A5:I5', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
            ],
            [
                ['column' => 'A7', 'value' => 'ID'],
                ['column' => 'B7', 'value' => 'CÉDULA'],
                ['column' => 'C7', 'value' => 'EMPLEADO'],
                ['column' => 'D7', 'value' => 'FECHA DE NACIMIENTO'],
                ['column' => 'E7', 'value' => 'DEPARTAMENTO'],
                ['column' => 'F7', 'value' => 'CARGO'],
                ['column' => 'G7', 'value' => 'FECHA DE INICIO'],
                ['column' => 'H7', 'value' => 'FECHA DE FIN'],
                ['column' => 'I7', 'value' => 'ESTADO']
            ],
            $arrayValues,
            [
                ['columns'=> 'A7:I7', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
            ]
        );

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE MARCACIONES REMOTAS POR EMPLEADO.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function get_pdf_conf_remoto_empleado($fecha_inicio, $fecha_fin, $emp_id){

        $datos = $this->get_conf_empleados_remoto_marcaciones_sql($fecha_inicio, $fecha_fin, $emp_id);

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
            $fecha_fin = "INDEFINIDO";
            $estado_conf = "INACTIVO";

            if($dato->cer_tiene_fecha_fin){
                $fecha_fin = $dato->cer_fecha_fin;
            }

            if($dato->cer_estado){
                $estado_conf = "ACTIVO";
            }

            $dato->des_fecha_fin = $fecha_fin;
            $dato->des_estado = $estado_conf;
            $dato->nombres_completos = "{$dato->emp_apellido} {$dato->emp_nombre}";
        }

        $html = view('Generico.Reports.report_table_movilidad_manta', [
            'titleReport' => 'Reporte de Marcaciones de Marcaciones remotas por empleado',
            'titlesHeader' => ["<span class='titulo3'>Usuario: {$user} || Fecha: {$fecha} || Hora: {$hora}</span>"],
            'titlesHeaderTable' => ["#","CÉDULA", "EMPLEADO", "F. NACIMIENTO", "DEPARTAMENTO", "CARGO", "F. INICIO",
            "F. FIN", "ESTADO"],
            "columnsTable"=> ["cer_id","emp_cedula","nombres_completos", "emp_fecha_nacimiento","dep_departamento","ca_cargo","cer_fecha_inicio","des_fecha_fin", "des_estado"],
            'items'=>$datos
        ])->render();
        $namefile = 'ReporteConfMarcacionesEmpleadosRemoto_' . time() . '.pdf';
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

    private function get_empleados_remoto_marcaciones_sql($fecha_inicio, $fecha_fin , $cer_id = null){
        $fecha_inicio = DateTime::createFromFormat('Ymd',  $fecha_inicio);
        $fecha_fin = DateTime::createFromFormat('Ymd',  $fecha_fin);

        $whereCerId = "";
        if($cer_id != null){
            $whereCerId = "AND m.cer_id = {$cer_id}";
        }

        $sql = "SELECT er.emp_cedula, er.emp_nombre, er.emp_apellido, er.dep_departamento, er.ca_cargo,
        m.me_tipo_marcacion, m.me_fecha_marcacion, m.me_ip, m.me_id, m.me_archivo_evidencia_marca
        FROM view_tbl_conf_empleado_remoto AS er
        INNER JOIN tbl_marcacion_empleado_remoto AS m ON er.cer_id = m.cer_id
        WHERE m.me_fecha_marcacion::date >= TO_DATE('{$fecha_inicio->format("d/m/Y")}', 'DD/MM/YYYY') AND
        m.me_fecha_marcacion::date <= TO_DATE('{$fecha_fin->format("d/m/Y")}', 'DD/MM/YYYY')
        {$whereCerId}
        ORDER BY emp_apellido, me_fecha_marcacion DESC";

        

        $list = DB::Select($sql);

        DB::disconnect();
        return $list;
    }

    public function get_empleados_remoto_marcaciones($fecha_inicio, $fecha_fin, $cer_id = null)
    {
        return $this->get_empleados_remoto_marcaciones_sql($fecha_inicio, $fecha_fin, $cer_id);
    }

    public function get_excel_marcaciones_remotas_empleado($fecha_desde, $fecha_hasta, $cer_id = null){

        $datos = $this->get_empleados_remoto_marcaciones_sql($fecha_desde, $fecha_hasta, $cer_id);

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
            $tipo_marcacion = "SALIDA";
            if($dato->me_tipo_marcacion == 1){
                $tipo_marcacion = "ENTRADA";
            }
            if($dato->me_tipo_marcacion == 2){
                $tipo_marcacion = "SALIDA AL ALMUERZO";
            }
            if($dato->me_tipo_marcacion == 3){
                $tipo_marcacion = "ENTRADA DEL ALMUERZO";
            }
            $dato->tipo_marcacion = $tipo_marcacion;
        }

        $arrayValues = [];
        $i = 8;

        foreach ($datos as &$dato) {
            $arrayValues[] = ['column'=>"A{$i}", 'value'=> $dato->me_id, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"B{$i}", 'value'=> $dato->emp_cedula, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"C{$i}", 'value'=> "{$dato->emp_apellido} {$dato->emp_nombre}", 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"D{$i}", 'value'=> $dato->dep_departamento, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"E{$i}", 'value'=> $dato->ca_cargo, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"F{$i}", 'value'=> substr($dato->me_fecha_marcacion, 0, 19), 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"G{$i}", 'value'=> $dato->tipo_marcacion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $i++;
        }

        $spreadsheet = ExcelHelper::ContructSpreadsheet(
            [
                ['columns'=>'A1:G1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A2:G2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A3:G3', 'value'=> "REPORTE DE MARCACIONES", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A4:G4', 'value'=> "FECHA DESDE: {$fecha_desde} || FECHA HASTA: {$fecha_hasta}", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A5:G5', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
            ],
            [
                ['column' => 'A7', 'value' => 'ID'],
                ['column' => 'B7', 'value' => 'CÉDULA'],
                ['column' => 'C7', 'value' => 'EMPLEADO'],
                ['column' => 'D7', 'value' => 'DEPARTAMENTO'],
                ['column' => 'E7', 'value' => 'CARGO'],
                ['column' => 'F7', 'value' => 'FECHA DE MARCACIÓN'],
                ['column' => 'G7', 'value' => 'TIPO DE MARCACIÓN']
            ],
            $arrayValues,
            [
                ['columns'=> 'A7:G7', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
            ]
        );

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE MARCACIONES DE EMPLEADOS.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function get_pdf_marcaciones_remotas_empleado($fecha_inicio, $fecha_fin, $cer_id = null){

        $datos = $this->get_empleados_remoto_marcaciones_sql($fecha_inicio, $fecha_fin, $cer_id);

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
            $tipo_marcacion = "SALIDA";
            if($dato->me_tipo_marcacion == 1){
                $tipo_marcacion = "ENTRADA";
            }
            if($dato->me_tipo_marcacion == 2){
                $tipo_marcacion = "SALIDA AL ALMUERZO";
            }
            if($dato->me_tipo_marcacion == 3){
                $tipo_marcacion = "ENTRADA DEL ALMUERZO";
            }
            $dato->tipo_marcacion = $tipo_marcacion;
            $dato->nombres_completos = "{$dato->emp_apellido} {$dato->emp_nombre}";
            $dato->fecha_marcacion = substr($dato->me_fecha_marcacion, 0, 19);
        }

        $html = view('Generico.Reports.report_table_movilidad_manta', [
            'titleReport' => 'Reporte de Marcaciones de empleados',
            'titlesHeader' => ["<span class='titulo3'>Usuario: {$user} || Fecha: {$fecha} || Hora: {$hora}</span>"],
            'titlesHeaderTable' => ["#","CÉDULA", "EMPLEADO", "DEPARTAMENTO", "CARGO", "FECHA DE MARCACIÓN",
            "TIPO DE MARCACIÓN"],
            "columnsTable"=> ["me_id","emp_cedula","nombres_completos","dep_departamento","ca_cargo","fecha_marcacion","tipo_marcacion"],
            'items'=>$datos
        ])->render();
        $namefile = 'ReporteMarcacionesEmpleadosRemoto_' . time() . '.pdf';
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

    public function indexMarcacionesGeneralEmpleadoRemoto()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.MarcacionesEmpleadosRemoto.reporte_general_marcaciones_empleado', compact('menus_'));
    }

    public function descargar_evidencias_marcacion($archivo)
    {
        // Limpia comillas dobles si existen
        $archivo = trim($archivo, '"');

        $ruta = '/ftpEvidenciaEmpleadosRemoto/' . $archivo;

        if (!Storage::disk('ftp_movilidad')->exists($ruta)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        $contenido = Storage::disk('ftp_movilidad')->get($ruta);
        $mime = Storage::disk('ftp_movilidad')->mimeType($ruta) ?? 'application/octet-stream';

        return response($contenido, 200)->header('Content-Type', $mime);
    }
}