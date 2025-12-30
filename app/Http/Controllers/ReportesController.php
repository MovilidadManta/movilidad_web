<?php

namespace App\Http\Controllers;

use DateTime;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\ExcelHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use PHPExcel_Cell_DataType;

class ReportesController extends Controller
{
    public function index_aporte_ciudadano()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Reportes.aporte_ciudadano', compact('menus_'));
    }

    public function get_aporte_ciudadano($fecha_desde, $fecha_hasta)
    {
        $where = "";
        if($fecha_desde){
            $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " ac_fecha >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($fecha_hasta && $where != ""){
            $where .= " AND";
        }
        if($fecha_hasta){
            $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " ac_fecha <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }

        $aportes = DB::connection('pgsql_pag_web')->Select("select * from public.tbl_aporte_ciudadano WHERE {$where}");
        return $aportes;
    }

    public function get_excel_aporte_ciudadano($fecha_desde, $fecha_hasta){

        $where = "";
        if($fecha_desde){
            $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " ac_fecha >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($fecha_hasta && $where != ""){
            $where .= " AND";
        }
        if($fecha_hasta){
            $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " ac_fecha <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }

        $aportes = DB::connection('pgsql_pag_web')->Select("select * from public.tbl_aporte_ciudadano WHERE {$where}");

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
        $i = 7;

        foreach ($aportes as &$aporte) {
            $arrayValues[] = ['column'=>"A{$i}", 'value'=> $aporte->ac_cedula, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"B{$i}", 'value'=> $aporte->ac_apellidos_nombres, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"C{$i}", 'value'=> $aporte->ac_organizacion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"D{$i}", 'value'=> $aporte->ac_direccion, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"E{$i}", 'value'=> $aporte->ac_telefono, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"F{$i}", 'value'=> $aporte->ac_email, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"G{$i}", 'value'=> $aporte->ac_fecha, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $i++;
        }

        $spreadsheet = ExcelHelper::ContructSpreadsheet(
            [
                ['columns'=>'A1:G1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A2:G2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A3:G3', 'value'=> "REPORTE DE APORTES CIUDADANOS", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A4:G4', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
            ],
            [
                ['column' => 'A6', 'value' => 'CÉDULA'],
                ['column' => 'B6', 'value' => 'APELLIDOS Y NOMBRES'],
                ['column' => 'C6', 'value' => 'ORGANIZACIÓN'],
                ['column' => 'D6', 'value' => 'DIRECCIÓN'],
                ['column' => 'E6', 'value' => 'TELÉFONO'],
                ['column' => 'F6', 'value' => 'CORREO'],
                ['column' => 'G6', 'value' => 'FECHA']
            ],
            $arrayValues,
            [
                ['columns'=> 'A6:G6', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
            ]
        );

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE APORTES CIUDADANOS.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function get_pdf_aporte_ciudadano($fecha_desde, $fecha_hasta){
        $where = "";
        if($fecha_desde){
            $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " ac_fecha >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($fecha_hasta && $where != ""){
            $where .= " AND";
        }
        if($fecha_hasta){
            $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " ac_fecha <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }

        $aportes = DB::connection('pgsql_pag_web')->Select("select * from public.tbl_aporte_ciudadano WHERE {$where}");

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

        $html = view('Generico.Reports.report_table_movilidad_manta', [
            'titleReport' => 'Reporte de Aportes Ciudadanos',
            'titlesHeader' => ["<span class='titulo3'>Usuario: {$user} || Fecha: {$fecha} || Hora: {$hora}</span>"],
            'titlesHeaderTable' => ['CÉDULA', 'APELLIDOS Y NOMBRES', 'ORGANIZACIÓN', 'DIRECCIÓN', 'TELÉFONO', 'CORREO', 'FECHA'],
            "columnsTable"=> ['ac_cedula', 'ac_apellidos_nombres', 'ac_organizacion', 'ac_direccion', 'ac_telefono', 'ac_email', 'ac_fecha'],
            'items'=>$aportes
        ])->render();
        $namefile = 'ReporteAportesCiudadanos_' . time() . '.pdf';
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
}
