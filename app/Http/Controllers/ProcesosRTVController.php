<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use DateTime;
use Carbon\Carbon;
use App\Helpers\ExcelHelper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel_Cell_DataType;


class ProcesosRTVController extends Controller
{
    public function index()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        $user_id = session::get('id_users');
        $result_usuario = $this->verificar_usuario($user_id);
        if(count($result_usuario) == 0){
            return redirect()->route('login');
        }
        return view('Administrador.ProcesosRTV.index', compact('menus_'));
    }

    public function  get_vehiculo($placa)
    {
        $objeto_Api = new ApiControllers();
        $repeat = false;
        $contador = 0;
        $message = "OK";
        $data = [];
        $ip = request()->ip();
        $user = session::get('id_users');

        do{
            $json_consultar_placa = $objeto_Api->consultar_vehiculo_rtv($placa);

            $data_consultar_placa = $json_consultar_placa->getData(true);
            $body_consultar_placa = $data_consultar_placa["body"];
    
            if($data_consultar_placa["statusCode"] == 500){
                $message = $body_consultar_placa["message"];
                break;
            }
    
            if ($data_consultar_placa["statusCode"] != 200)
            {
                if (strpos($body_consultar_placa['data']['mensaje'], 'CLK_TRX_CLIENTE') !== false)
                {
                    $repeat = true;
                    $contador++;
                    if ($contador == 10)
                    {
                        $message = "Muchos intentos fallidos para consulta de la misma placa";
                        break;
                    }
                    continue;
                }
                else
                {
                    $message =$body_consultar_placa["data"]["mensaje"];
                    break;
                }
            }
            $repeat = false;

        }while($repeat);

        if($message == "OK"){
            $data = $body_consultar_placa;
        }

        return response()->json(["message" => $message, "data" => $data]);
    }

    public function aprobar_vehiculo(Request $request)
    {
        try{
            $ip = request()->ip();
            $user = session::get('id_users');
            $objeto_Api = new ApiControllers();

            $orden_generada = "";
            $mensaje_orden = "";
            $message = "OK";

            $placa = $request->input('placa');
            $claseServicio = $request->input('clase_servicio');
            $numeroRevision = $request->input('numero_revision');
            $solicitud = $this->get_last_secuencial_valor();
            $tipoServicio = $request->input('tipo_servicio');
            $claseTransporte = $request->input('clase_transporte');
            $vin = $request->input('vin');
            $comment = $request->input('comment');

            $json_solicitar_orden = $this->solicitar_orden($placa, $claseServicio, $numeroRevision, $solicitud, $tipoServicio, $claseTransporte, $vin);

            $data_solicitar_orden = $json_solicitar_orden->getData(true);

            $body_solicitar_orden = $data_solicitar_orden["body"];

            if ($data_solicitar_orden["statusCode"] == 500)
            {
                $message = $body_solicitar_orden["message"];
                $this->save_process_rtv(7, $placa, $message, false, $comment, $ip, $user);
                return response()->json(["message" => $message, "orden_generada" => $orden_generada, "mensaje_orden" => $mensaje_orden]);
            }

            if ($data_solicitar_orden["statusCode"] == 422)
            {
                $message = $body_solicitar_orden["message"];
                $this->save_process_rtv(7, $placa, $message, false, $comment, $ip, $user);
                return response()->json(["message" => $message, "orden_generada" => $orden_generada, "mensaje_orden" => $mensaje_orden]);
            }

            if ($data_solicitar_orden["statusCode"] != 200)
            {
                $message = $body_solicitar_orden["data"]["mensaje"];
            }

            if($message != "OK"){
                $this->save_process_rtv(7, $placa, $message, false, $comment, $ip, $user);
                return response()->json(["message" => $message, "orden_generada" => $orden_generada, "mensaje_orden" => $mensaje_orden]);
            }else{
                $orden_generada = $body_solicitar_orden["data"]["numeroOrden"];
                $result = $this->save_process_rtv(7, $placa, $orden_generada, true, $comment, $ip, $user);
            }

            //Aqui incrementar en 1 el numero de solicitud
            $this->update_last_secuencial();

            $json_finalizar_orden = $objeto_Api->finalizar_orden($orden_generada);

            $data_finalizar_orden = $json_finalizar_orden->getData(true);

            $body_finalizar_orden = $data_finalizar_orden["body"];

            if ($data_finalizar_orden["statusCode"] == 500)
            {
                $message = $body_finalizar_orden["message"];
            }

            if ($data_finalizar_orden["statusCode"] != 200)
            {
                $message = $body_finalizar_orden["data"]["mensaje"];
            }

            $mensaje_orden = $body_finalizar_orden["data"]["resultado"]["mensaje"] ?? "ANT NO FINALIZO";

            $this->save_process_rtv(8, $orden_generada, $mensaje_orden, $mensaje_orden != "ANT NO FINALIZO", $comment, $ip, $user);

            return response()->json(["message" => $message, "orden_generada" => $orden_generada, "mensaje_orden" => $mensaje_orden]);

        
        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }

    public function aprobar_numero_orden(Request $request)
    {
        try{
            $ip = request()->ip();
            $user = session::get('id_users');
            $objeto_Api = new ApiControllers();

            $mensaje_orden = "";
            $message = "OK";

            $numero_orden = $request->input('numero_orden');
            $comment = $request->input('comment');

            $json_finalizar_orden = $objeto_Api->finalizar_orden($numero_orden);

            $data_finalizar_orden = $json_finalizar_orden->getData(true);

            $body_finalizar_orden = $data_finalizar_orden["body"];

            if ($data_finalizar_orden["statusCode"] == 500)
            {
                $message = $body_finalizar_orden["message"];
            }

            if ($data_finalizar_orden["statusCode"] != 200)
            {
                $message = $body_finalizar_orden["data"]["mensaje"];
            }

            $mensaje_orden = $body_finalizar_orden["data"]["resultado"]["mensaje"] ?? "ANT NO FINALIZO";

            if($message == "OK"){
                $this->save_process_rtv(8, $numero_orden, $mensaje_orden, true, $comment, $ip, $user);
            }else{
                $this->save_process_rtv(8, $numero_orden, $message, false, $comment, $ip, $user);
            }

            return response()->json(["message" => $message, "mensaje_orden" => $mensaje_orden]);

        
        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }

    public function anular_numero_orden(Request $request)
    {
        try{
            $ip = request()->ip();
            $user = session::get('id_users');
            $objeto_Api = new ApiControllers();

            $message = "OK";
            $result_anular = "";

            $numero_orden = $request->input('numero_orden');
            $idInstitucion = $request->input('id_institucion');
            $motivo = $request->input('motivo');
            $comment = $request->input('comment');

            $json_anular_orden = $objeto_Api->anular_numero_orden($numero_orden, $idInstitucion, $motivo);

            $data_anular_orden = $json_anular_orden->getData(true);

            $body_anular_orden = $data_anular_orden["body"];

            if ($data_anular_orden["statusCode"] == 500)
            {
                $message = $body_anular_orden["message"];
            }

            $result_anular = $body_anular_orden["data"]["exito"];

            if($message == "OK"){
                $this->save_process_rtv(11, $numero_orden, $result_anular, $result_anular == "S", $comment, $ip, $user);
            }else{
                $this->save_process_rtv(11, $numero_orden, $message, false, $comment, $ip, $user);
            }

            return response()->json(["message" => $message, "result_anular" => $result_anular]);

        
        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }

    private function save_process_rtv($pr_process, $pr_placa, $pr_result, $pr_sucess, $pr_comment, $ip, $user)
    {
        try{

            $message = "OK";
            $result_anular = "";

            $json[] = [
                'pr_process' => $pr_process,
                'pr_placa' => $pr_placa,
                'pr_result' => $pr_result,
                'pr_sucess' => $pr_sucess,
                'pr_comment' => $pr_comment
            ];
            $jsoninsert = json_encode($json);


            $sql = DB::select('select public.procedimiento_registrar_tbl_procesos_rtv(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_tbl_procesos_rtv;
            }

            if ($sql != "[]") {
                return ['respuesta' => true, "data" => $id, "sql" => $sql];
            } else {
                return ["respuesta" => false];
            }

        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }

    public function ReportDiario($fecha_desde, $fecha_hasta, $estado)
    {
        $where = "";
        if($fecha_desde){
            $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " pr_fecha::date >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($fecha_hasta && $where != ""){
            $where .= " AND";
        }
        if($fecha_hasta){
            $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " pr_fecha::date <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }

        if($estado == 1){
            $where .= " AND pr_sucess = true";
        }

        if($estado == 2){
            $where .= " AND pr_sucess = false";
        }

        $lista_procesos_rtv = DB::Select("SELECT * FROM public.tbl_procesos_rtv WHERE pr_process = 7 AND {$where} ORDER BY pr_fecha DESC");
        return $lista_procesos_rtv;
    }

    public function ResultadosDiario()
    {
        $resultados_rtv = DB::Select("
        SELECT pr_comment as comentario, COUNT(*) as total
        FROM public.tbl_procesos_rtv 
        WHERE 
        pr_process = 7 AND
        pr_sucess = true AND
        pr_fecha::date = CURRENT_DATE
        GROUP BY pr_comment
        ");
        return $resultados_rtv;
    }

    public function ExcelReportDiario($fecha_desde, $fecha_hasta, $estado){

        $datos = $this->ReportDiario($fecha_desde, $fecha_hasta, $estado);
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
        $i = 8;
        foreach ($datos as &$dato) {

            $arrayValues[] = ['column'=>"A{$i}", 'value'=> $dato->pr_fecha, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"B{$i}", 'value'=> $dato->pr_placa, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"C{$i}", 'value'=> $dato->pr_result, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"D{$i}", 'value'=> $dato->pr_comment, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $i++;
        }

        $spreadsheet = ExcelHelper::ContructSpreadsheet(
            [
                ['columns'=>'A1:D1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A2:D2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A3:D3', 'value'=> "REPORTE DE PLACAS RTV", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A4:D4', 'value'=> "FECHA DESDE: {$fecha_desde} || FECHA HASTA: {$fecha_hasta}", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A5:D5', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
            ],
            [
                ['column' => 'A7', 'value' => 'FECHA / HORA'],
                ['column' => 'B7', 'value' => 'PLACA'],
                ['column' => 'C7', 'value' => 'ORDEN'],
                ['column' => 'D7', 'value' => 'COMENTARIO'],
            ],
            $arrayValues,
            [
                ['columns'=> 'A7:D7', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
            ]
        );

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DIARIO RTV.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function ReportApi($fecha_desde, $fecha_hasta)
    {
        $where = "p_id = 7";

        if ($fecha_desde) {
            $fecha_desde = DateTime::createFromFormat('Ymd', $fecha_desde);
            $where .= " AND t_fecha::date >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }

        if ($fecha_hasta) {
            $fecha_hasta = DateTime::createFromFormat('Ymd', $fecha_hasta);
            $where .= " AND t_fecha::date <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }

        // Una sola consulta: todas las transacciones relevantes
        $transacciones = collect(DB::select("
            SELECT t_uuid, t_code, t_fecha, t_body_api
            FROM orquestador.tbl_transacciones
            WHERE $where
            ORDER BY t_id DESC
        "));

        // Agrupar por UUID
        $agrupadas = $transacciones->groupBy('t_uuid');

        $resultados = $agrupadas->map(function ($grupo) {
            $peticion = $grupo->firstWhere('t_code', 2);
            $respuesta = $grupo->firstWhere('t_code', '!=', 2);

            if (!$peticion || !$respuesta) {
                return null;
            }

            $data_peticion = json_decode($peticion->t_body_api)->data ?? null;
            $respuesta_decoded = json_decode($respuesta->t_body_api)->original ?? null;

            if (
                !isset($respuesta_decoded->data->resultado->mensaje) ||
                !str_contains($respuesta_decoded->data->resultado->mensaje, 'Ingreso de Solicitud OK')
            ) {
                return null;
            }

            return [
                'placa' => $data_peticion->placa ?? null,
                'orden' => $respuesta_decoded->data->numeroOrden ?? null,
                'fecha' => $peticion->t_fecha,
            ];
        })
        ->filter()
        ->values()
        ->toArray();

        return $resultados;
    }

    public function ExcelReportApi($fecha_desde, $fecha_hasta){

        $datos = $this->ReportApi($fecha_desde, $fecha_hasta);
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
        $i = 8;
        foreach ($datos as &$dato) {

            $arrayValues[] = ['column'=>"A{$i}", 'value'=> $dato['fecha'], 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"B{$i}", 'value'=> $dato['placa'], 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"C{$i}", 'value'=> $dato['orden'], 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $i++;
        }

        $spreadsheet = ExcelHelper::ContructSpreadsheet(
            [
                ['columns'=>'A1:D1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A2:D2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A3:D3', 'value'=> "REPORTE DE PLACAS RTV", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A4:D4', 'value'=> "FECHA DESDE: {$fecha_desde} || FECHA HASTA: {$fecha_hasta}", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A5:D5', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
            ],
            [
                ['column' => 'A7', 'value' => 'FECHA / HORA'],
                ['column' => 'B7', 'value' => 'PLACA'],
                ['column' => 'C7', 'value' => 'ORDEN'],
            ],
            $arrayValues,
            [
                ['columns'=> 'A7:C7', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
            ]
        );

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE API RTV.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    private function solicitar_orden($placa, $claseServicio, $numeroRevision, $solicitud, $tipoServicio, $claseTransporte, $vin){
        $objeto_Api = new ApiControllers();
        return $objeto_Api->solicitar_orden($placa, $claseServicio, $numeroRevision, $solicitud, $tipoServicio, $claseTransporte, $vin);
    }

    public function get_last_secuencial_valor() {
        $secuencial = DB::select("SELECT cf_valor FROM orquestador.tbl_variables_configuraciones WHERE cf_codigo = 'SECUENCIAL_ORDEN_RTV' LIMIT 1");
        return $secuencial[0]->cf_valor;
    }
    
    public function get_last_secuencial() {
        return response($this->get_last_secuencial_valor(), 200)
            ->header('Content-Type', 'text/plain');
    }

    private function verificar_usuario($user_id){
        $codigos = DB::select("SELECT cf_valor FROM orquestador.tbl_variables_configuraciones WHERE cf_codigo = 'COD_USER_RTV' AND cf_valor = '{$user_id}' LIMIT 1");

        return $codigos;
    }

    private function update_last_secuencial(){
        $secuencial = DB::select("UPDATE orquestador.tbl_variables_configuraciones SET cf_valor = cf_valor::integer + 1  WHERE cf_codigo = 'SECUENCIAL_ORDEN_RTV' ");
    }
}
