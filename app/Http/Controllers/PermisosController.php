<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Mpdf\Mpdf;

use DB;

use Storage;
use  Session;
use DateTime;


use File;
use App\Helpers\ExcelHelper;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel_Cell_DataType;

class PermisosController extends Controller
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
        return view('Administrador.Permisos.index', compact('menus_'));
    }

    public function get_permisos($fecha_desde = null, $fecha_hasta = null)
    {


        $where = "WHERE";
        if ($fecha_desde) {
            $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " TO_DATE(fecha_solicitud, 'DD/MM/YYYY') >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if ($where != "WHERE") {
            $where .= " AND";
        }
        if ($fecha_hasta) {
            $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " TO_DATE(fecha_solicitud, 'DD/MM/YYYY') <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if ($where == "WHERE") {
            $where = "";
        }
        $permisos = DB::select("select * from view_permisos_solicitudes {$where} order by id DESC");
        return $permisos;
    }

    public function descargar_archivo($ruta)
    {
        $ruta = base64_decode($ruta);
        $ruta = trim($ruta, '"');
        return Storage::disk('ftp_movilidad')->download("/ftptalentohumano/permisos/" . $ruta);
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

    public function create_reporte_solicitudes()
    {
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            $permisos = DB::select('select * from view_permisos_solicitudes order by id DESC');
            return view('Administrador.Permisos.reporte_solicitud_permiso', compact('menus_', 'permisos'));
        } else {
            return Redirect("/");
        }
    }

    public function get_reporte_permisos($fecha_inicio, $fecha_fin)
    {
        $cl = new HomeController();
        $permisos = $cl->GET_PERMISOS_SOLICITUDES($fecha_inicio, $fecha_fin);

        if ($permisos != []) {
            return response()->json(["res" => true, "data" => $permisos]);
        } else {
            return response()->json(["res" => false,]);
        }
    }

    public function reporte_excel_permisos_empleados($fechaDesde, $fechaHasta)
    {
        $datos = $this->get_permisos($fechaDesde, $fechaHasta);
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
            $arrayValues[] = ['column' => "A{$i}", 'value' => $dato->id, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "B{$i}", 'value' => $dato->jefe, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "C{$i}", 'value' => $dato->empleado, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "D{$i}", 'value' => $dato->tipo_permiso, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "E{$i}", 'value' => $dato->estado, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "F{$i}", 'value' => $dato->fecha_solicitud, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "G{$i}", 'value' => $dato->fecha_inicio, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "H{$i}", 'value' => $dato->fecha_final, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "I{$i}", 'value' => $dato->hora_inicio, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "J{$i}", 'value' => $dato->hora_final, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "K{$i}", 'value' => $dato->total_horas, 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column' => "L{$i}", 'value' => $dato->observacion_rechazo ?: 'Sin Información', 'type' => PHPExcel_Cell_DataType::TYPE_STRING];
            $i++;
        }

        $spreadsheet = ExcelHelper::ContructSpreadsheet(
            [
                ['columns' => 'A1:K1', 'value' => '', 'formato' => ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns' => 'A2:K2', 'value' => "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' => ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns' => 'A3:K3', 'value' => "REPORTE DE SOLICITUD/PERMISOS DE EMPLEADOS", 'formato' => ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns' => 'A4:K4', 'value' => "FECHA DESDE: {$fechaDesde} || FECHA HASTA: {$fechaHasta}", 'formato' => ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns' => 'A5:K5', 'value' => "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' => ExcelHelper::GetStyleStyleArray()]
            ],
            [
                ['column' => 'A7', 'value' => 'ID'],
                ['column' => 'B7', 'value' => 'JEFE'],
                ['column' => 'C7', 'value' => 'EMPLEADO'],
                ['column' => 'D7', 'value' => 'TIPO PERMISO'],
                ['column' => 'E7', 'value' => 'ESTADO'],
                ['column' => 'F7', 'value' => 'FECHA SOLICITUD'],
                ['column' => 'G7', 'value' => 'FECHA INICIO'],
                ['column' => 'H7', 'value' => 'FECHA FIN'],
                ['column' => 'I7', 'value' => 'HORA INICIO'],
                ['column' => 'J7', 'value' => 'HORA FIN'],
                ['column' => 'K7', 'value' => 'TOTAL HORAS'],
                ['column' => 'L7', 'value' => 'OBSERVACIÓN RECHAZO'],
            ],
            $arrayValues,
            [
                ['columns' => 'A7:L7', 'format' => ExcelHelper::GetStyleStyleNegrita()]
            ]
        );

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE NOMINA DE EMPLEADOS.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function reporte_pdf_permisos_empleados($fechaDesde, $fechaHasta)
    {
        $datos = $this->get_permisos($fechaDesde, $fechaHasta);
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

        foreach ($datos as $dato) {
            if ($dato->observacion_rechazo == null) {
                $dato->observacion_rechazo = 'Sin Información';
            }
        }

        $html = view('Generico.Reports.report_table_movilidad_manta', [
            'titleReport' => 'Reporte de Permisos de Empleados',
            'titlesHeader' => ["<span class='titulo3'>Usuario: {$user} || Fecha: {$fecha} || Hora: {$hora}</span>"],
            'titlesHeaderTable' => ["ID", "JEFE", "EMPLEADO", "TIPO PERMISO", "ESTADO", "FECHA SOLICITUD", "FECHA INICIO", "FECHA FIN", "HORA INICIO", "HORA FIN", "TOTAL HORAS", "OBSERVACIÓN RECHAZO"],
            "columnsTable" => ["id", "jefe", "empleado", "tipo_permiso", "estado", "fecha_solicitud", "fecha_inicio", "fecha_final", "hora_inicio", "hora_final", "total_horas", "observacion_rechazo"],
            'items' => $datos
        ])->render();
        $namefile = 'ReportePermisos_' . time() . '.pdf';
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
