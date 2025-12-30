<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Codedge\Fpdf\Fpdf\Fpdf;
use Mpdf\Mpdf;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;
use PHPExcel_Style_Fill;
use PHPExcel_Cell_DataType;
use PHPExcel_Worksheet_Drawing;
use PHPExcel_Worksheet;
use Drawing;
use Worksheet;

class ReporteCatalogoController extends Controller
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
        return view('Administrador.Catalogo.reporte_catalogo', compact('menus_'));
    }

    public function get_reporte_catalogo($id_categoria, $id_area, $id_estado)
    {
        if ($id_categoria == 0) {
            $ruta_categoria = '';
        } else {
            $ruta_categoria = "AND c.cat_categoria = $id_categoria";
        }

        if ($id_area == 0) {
            $ruta_area = '';
        } else {
            $ruta_area = "AND c.cat_id_area = $id_area";
        }

        if ($id_estado == 0) {
            $ruta_estado = '';
        } else {
            $ruta_estado = 'AND c.cat_id_estado = ' . $id_estado;
        }

        //$sql = DB::Select('select public.cursor_listar_reporte_empleados(?,?,?,?)', [$id_direccion,$id_jefatura,$fecha_inicio, $fecha_fin]);
        $sql = DB::select("SELECT  
        c.cat_id,			    	
        c.cat_codigo,				
        c.cat_ram,			    	
        c.cat_tipo_so,			
        c.cat_so,    				
        c.cat_mac_ethernet,  		
        c.cat_mac_wifi, 
        c.cat_categoria,     		
        c.cat_numero_serie,    	
        c.cat_modelo,     	  
        c.cat_marca,     	    	
        c.cat_descripcion ,
        c.cat_ubicacion  ,
        c.cat_id_area,
        c.cat_fecha_compra,
        c.cat_ip,
        c.cat_periodo_garantia,
        c.cat_proveedor,
        c.cat_id_estado,
        c.cat_observacion,
        c.cat_usuario_sistema,
        c.cat_disco_duro,
        c.cat_id_anydesk,
        c.cat_estado_custodio
           FROM public.tbl_catalogos c
           WHERE c.cat_estado = 'A'
           $ruta_categoria
           $ruta_area
           $ruta_estado
           ORDER by c.cat_id asc");

        $total_equipos = count($sql);

        if ($sql != "[]") {
            return response()->json(['data' => $sql, 'total_equipo' => $total_equipos, 'respuesta' => 'true']);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_reporte_catalogo_pdf($id_categoria, $id_area, $id_estado)
    {
        date_default_timezone_set('America/Guayaquil');
        $accion = 'ver';
        $tipo = 'fisico';
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();

        /*$sql_encabezado = DB::Select('select public.cursor_listar_datos_encabezado_reporte_empleado(?,?)', [$id_direccion, $id_jefatura]);
        foreach ($sql_encabezado as $r) {
            $data = $r->cursor_listar_datos_encabezado_reporte_empleado;
        }
        $json_data_encabezado = json_decode($data);

        foreach ($json_data_encabezado as $r) {
            $direccion = $r->direccion;
            $jefatura = $r->jefatura;
        }*/

        if ($id_categoria == 0) {
            $ruta_categoria = '';
            $categoria = 'TODAS';
        } else {
            $ruta_categoria = "AND c.cat_categoria = $id_categoria";
            if ($id_categoria == '1') {
                $categoria = 'LAPTO';
            } else if ($id_categoria == '2') {
                $categoria = 'IMPRESORA';
            } else if ($id_categoria == '3') {
                $categoria = 'MOUSE';
            } else if ($id_categoria == '4') {
                $categoria = 'ROUTER';
            } else if ($id_categoria == '5') {
                $categoria = 'TECLADO';
            } else if ($id_categoria == '6') {
                $categoria = 'MONITOR';
            } else if ($id_categoria == '7') {
                $categoria = 'CONVERTIDOR';
            } else if ($id_categoria == '8') {
                $categoria = 'UPS';
            } else if ($id_categoria == '9') {
                $categoria = 'REGULADOR';
            } else if ($id_categoria == '10') {
                $categoria = 'TV';
            } else if ($id_categoria == '11') {
                $categoria = 'SWICH O COMMUTADOR';
            } else if ($id_categoria == '12') {
                $categoria = 'SERVIDOR';
            } else if ($id_categoria == '13') {
                $categoria = 'ACCES POINTS';
            } else if ($id_categoria == '14') {
                $categoria = 'DISCO DURO';
            } else if ($id_categoria == '15') {
                $categoria = 'MEMORIA RAM';
            } else if ($id_categoria == '16') {
                $categoria = 'FUENTE';
            } else if ($id_categoria == '17') {
                $categoria = 'CPU';
            } else if ($id_categoria == '18') {
                $categoria = 'PARLANTES';
            } else if ($id_categoria == '19') {
                $categoria = 'SCANNER';
            } else if ($id_categoria == '20') {
                $categoria = 'SERVIDOR';
            } else if ($id_categoria == '21') {
                $categoria = 'LECTOR DE HUELLA';
            } else if ($id_categoria == '22') {
                $categoria = 'BIOMETRICO';
            } else if ($id_categoria == '23') {
                $categoria = 'TELEFONO IP';
            } else if ($id_categoria == '24') {
                $categoria = 'TODO EN UNO';
            }
            //$direcci1on = DB::select('select dep_departamento from public.tbl_direcciones where dep_id='.$id_categoria);
            /*foreach ($direccion as $d) {
                $direccion = $d->dep_departamento;
            }*/
        }

        if ($id_area == 0) {
            $ruta_area = '';
            $area = 'TODAS';
        } else {
            $ruta_area = "AND c.cat_id_area = $id_area";
            if ($id_area == '1') {
                $area = 'TRANSITO';
            } else if ($id_area == '2') {
                $area = 'TTM';
            } else if ($id_area == '3') {
                $area = 'CENTRO DE MONITOREO';
            }
        }

        if ($id_estado == 0) {
            $ruta_estado = '';
            $estado = 'TODAS';
        } else {
            $ruta_estado = 'AND c.cat_id_estado = ' . $id_estado;
            if ($id_estado == 1) {
                $estado = 'MALO';
            } elseif ($id_estado == 2) {
                $estado = 'REGULAR';
            } elseif ($id_estado == 3) {
                $estado = 'BUENO';
            } elseif ($id_estado == 4) {
                $estado = 'DAR DE BAJA';
            }
        }

        $json_data = DB::select("SELECT  
        c.cat_id,			    	
        c.cat_codigo,				
        c.cat_ram,			    	
        c.cat_tipo_so,			
        c.cat_so,    				
        c.cat_mac_ethernet,  		
        c.cat_mac_wifi, 
        c.cat_categoria,     		
        c.cat_numero_serie,    	
        c.cat_modelo,     	  
        c.cat_marca,     	    	
        c.cat_descripcion ,
        c.cat_ubicacion  ,
        c.cat_id_area,
        c.cat_fecha_compra,
        c.cat_ip,
        c.cat_periodo_garantia,
        c.cat_proveedor,
        c.cat_id_estado,
        c.cat_observacion,
        c.cat_usuario_sistema,
        c.cat_disco_duro,
        c.cat_id_anydesk,
        c.cat_estado_custodio
           FROM public.tbl_catalogos c
           WHERE c.cat_estado = 'A'
           $ruta_categoria
           $ruta_area
           $ruta_estado
           ORDER by c.cat_id asc");

        $json_data['catalogos'] = $json_data;
        $json_data['usuario'] = $user;
        $json_data['fecha_actual'] = $fecha;
        $json_data['hora_actual'] = $hora;
        $json_data['categoria'] = $categoria;
        $json_data['area'] = $area;
        $json_data['estado'] = $estado;

        $html = view('Administrador.Catalogo.reporte_catalogo_pdf', $json_data)->render();
        $namefile = 'ReporteCatalogo_' . time() . '.pdf';

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
        // dd($mpdf);
        if ($accion == 'ver') {
            $mpdf->Output($namefile, "I");
        } elseif ($accion == 'descargar') {
            $mpdf->Output($namefile, "D");
        }

    }

    public function get_reporte_catalogo_excell($id_categoria, $id_area, $id_estado)
    {
        date_default_timezone_set('America/Guayaquil');
        $accion = 'ver';
        $tipo = 'fisico';
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();

        if ($id_categoria == 0) {
            $ruta_categoria = '';
            $categoria = 'TODAS';
        } else {
            $ruta_categoria = "AND c.cat_categoria = $id_categoria";
            if ($id_categoria == '1') {
                $categoria = 'LAPTO';
            } else if ($id_categoria == '2') {
                $categoria = 'IMPRESORA';
            } else if ($id_categoria == '3') {
                $categoria = 'MOUSE';
            } else if ($id_categoria == '4') {
                $categoria = 'ROUTER';
            } else if ($id_categoria == '5') {
                $categoria = 'TECLADO';
            } else if ($id_categoria == '6') {
                $categoria = 'MONITOR';
            } else if ($id_categoria == '7') {
                $categoria = 'CONVERTIDOR';
            } else if ($id_categoria == '8') {
                $categoria = 'UPS';
            } else if ($id_categoria == '9') {
                $categoria = 'REGULADOR';
            } else if ($id_categoria == '10') {
                $categoria = 'TV';
            } else if ($id_categoria == '11') {
                $categoria = 'SWICH O COMMUTADOR';
            } else if ($id_categoria == '12') {
                $categoria = 'SERVIDOR';
            } else if ($id_categoria == '13') {
                $categoria = 'ACCES POINTS';
            } else if ($id_categoria == '14') {
                $categoria = 'DISCO DURO';
            } else if ($id_categoria == '15') {
                $categoria = 'MEMORIA RAM';
            } else if ($id_categoria == '16') {
                $categoria = 'FUENTE';
            } else if ($id_categoria == '17') {
                $categoria = 'CPU';
            } else if ($id_categoria == '18') {
                $categoria = 'PARLANTES';
            } else if ($id_categoria == '19') {
                $categoria = 'SCANNER';
            } else if ($id_categoria == '20') {
                $categoria = 'SERVIDOR';
            } else if ($id_categoria == '21') {
                $categoria = 'LECTOR DE HUELLA';
            } else if ($id_categoria == '22') {
                $categoria = 'BIOMETRICO';
            } else if ($id_categoria == '23') {
                $categoria = 'TELEFONO IP';
            } else if ($id_categoria == '24') {
                $categoria = 'TODO EN UNO';
            }
            //$direcci1on = DB::select('select dep_departamento from public.tbl_direcciones where dep_id='.$id_categoria);
            /*foreach ($direccion as $d) {
                $direccion = $d->dep_departamento;
            }*/
        }

        if ($id_area == 0) {
            $ruta_area = '';
            $area = 'TODAS';
        } else {
            $ruta_area = "AND c.cat_id_area = $id_area";
            if ($id_area == '1') {
                $area = 'TRANSITO';
            } else if ($id_area == '2') {
                $area = 'TTM';
            } else if ($id_area == '3') {
                $area = 'CENTRO DE MONITOREO';
            }
        }

        if ($id_estado == 0) {
            $ruta_estado = '';
            $estado = 'TODAS';
        } else {
            $ruta_estado = 'AND c.cat_id_estado = ' . $id_estado;
            if ($id_estado == 1) {
                $estado = 'MALO';
            } elseif ($id_estado == 2) {
                $estado = 'REGULAR';
            } elseif ($id_estado == 3) {
                $estado = 'BUENO';
            } elseif ($id_estado == 4) {
                $estado = 'DAR DE BAJA';
            }
        }

        $json_data = DB::select("SELECT  
        c.cat_id,			    	
        c.cat_codigo,				
        c.cat_ram,			    	
        c.cat_tipo_so,			
        c.cat_so,    				
        c.cat_mac_ethernet,  		
        c.cat_mac_wifi, 
        c.cat_categoria,     		
        c.cat_numero_serie,    	
        c.cat_modelo,     	  
        c.cat_marca,     	    	
        c.cat_descripcion ,
        c.cat_ubicacion  ,
        c.cat_id_area,
        c.cat_fecha_compra,
        c.cat_ip,
        c.cat_periodo_garantia,
        c.cat_proveedor,
        c.cat_id_estado,
        c.cat_observacion,
        c.cat_usuario_sistema,
        c.cat_disco_duro,
        c.cat_id_anydesk,
        c.cat_estado_custodio
           FROM public.tbl_catalogos c
           WHERE c.cat_estado = 'A'
           $ruta_categoria
           $ruta_area
           $ruta_estado
           ORDER by c.cat_id asc");

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
        }

        $spreadsheet = new Spreadsheet();
        /*$spreadsheet
        ->getProperties()
        ->setCreator("Aquí va el creador, como cadena")
        ->setLastModifiedBy('Parzibyte') // última vez modificado por
        ->setTitle('Mi primer documento creado con PhpSpreadSheet')
        ->setSubject('El asunto')
        ->setDescription('Este documento fue generado para parzibyte.me')
        ->setKeywords('etiquetas o palabras clave separadas por espacios')
        ->setCategory('La categoría');*/

        $fecharepo = $a . '-' . $mes . '-' . $d;
        $tituloReporte1 = "REPORTE DE NOMINA DE EMPLEADOS";
        $tituloReporte = "EMPRESA PUBLICA MOVILIDAD DE MANTA EP";
        $titulo_direccion_jefa = 'CATEGORIA: ' . $categoria . ' || AREA: ' . $area . '  || ESTADO: ' . $estado;
        //$titulo_desde_hasta = 'DESDE: '.$fecha_ini.' || HASTA: '.$fecha_fi;

        $Generado = 'Usuario: ' . $user . ' || Generado: ' . $fecharepo . ' || Hora: ' . $h . 'h' . $ii . ':' . $s;


        $sheet = $spreadsheet->getActiveSheet()
            ->setCellValue('A8', "CODIGO")
            ->setCellValue('B8', "CATEGORIA")
            ->setCellValue('C8', "MARCA")
            ->setCellValue('D8', "MODELO")
            ->setCellValue('E8', "DESCRIPCION")
            ->setCellValue('F8', "OBSERVACION");

        $spreadsheet->setActiveSheetIndex(0)
            ->mergeCells('A1:F1');
        $spreadsheet->setActiveSheetIndex(0)
            ->mergeCells('A2:F2');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $tituloReporte);
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A3:F3');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', $tituloReporte1);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A4:F4');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', $titulo_direccion_jefa);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A5:F5');
        //$spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', $titulo_desde_hasta);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A6:F6');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A6', $Generado);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A1:F1');
        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
        //$spreadsheet->getActiveSheet()->getColumnDimensionByColumn(1)->setAutoSize(true);
        //$spreadsheet->getActiveSheet()->getColumnDimensionByColumn(2)->setAutoSize(true);
        //$spreadsheet->getDefaultStyle()->getAlignment()->setWrapText(true);

        $negrillaa = array(
            'font' => array(
                'name' => 'Verdana',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 10,
                'color' => array(
                    'rgb' => '090909'
                )
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                    'bold' => true,
                )
            ),

        );

        $estiloTituloReporte = array(
            'font' => array(
                'name' => 'Verdana',
                'bold' => true,
                'italic' => false,
                'strike' => false,
                'size' => 14,
                'color' => array(
                    'rgb' => '090909'
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => true
            )
        );


        $estiloTituloReporte123 = array(
            'font' => array(
                'name' => 'Verdana',
                'bold' => false,
                'italic' => false,
                'strike' => false,
                'size' => 12,
                'color' => array(
                    'rgb' => '090909'
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_NONE
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => true
            )
        );
        $styleArray = array(
            'font' => array(
                'size' => 12,
                'bold' => true,
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'rotation' => 0,
                'wrap' => true
            )
        );

        $borders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                    'bold' => true,
                )
            ),
        );

        $spreadsheet->setActiveSheetIndex(0)->getStyle('A2:F2')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A2:F2')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A8:F8')->applyFromArray($negrillaa);
        // $spreadsheet->getActiveSheet()->getStyle('A4:V4')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A3:F3')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A4:F4')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A5:F5')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A6:F6')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A7:F7')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getProtection()->setInsertRows(true);
        $spreadsheet->getActiveSheet()->getProtection()->setFormatCells(true);
        $spreadsheet->getActiveSheet()->getProtection()->setSort(true);
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);

        $con = 0;
        $i = 9;

        /*$objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo=public_path('/imagenes_empleados/ALVARO ROBERTO MATUTE ACEBO - 1315258424.png');
        $objDrawing->setPath($logo);
        $objDrawing->setOffsetX(28);
        $objDrawing->setOffsetY(50);
        $objDrawing->setWidth(50);
        $objDrawing->setWorksheet($spreadsheet->Sheet);*/



        foreach ($json_data as $value) {

            //AGREGAR FOTO
            // Add a drawing to the worksheet
            $codigo = $value->cat_codigo;
            $categoria = $value->cat_categoria;
            $marca = $value->cat_marca;
            $modelo = $value->cat_modelo;
            $descripcion = $value->cat_descripcion;
            $observacion = $value->cat_observacion;

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValueExplicit('A' . $i, $codigo, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B' . $i, $categoria, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('C' . $i, $marca, PHPExcel_Cell_DataType::TYPE_STRING)

                ->setCellValueExplicit('D' . $i, $modelo, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E' . $i, $descripcion, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('F' . $i, $observacion, PHPExcel_Cell_DataType::TYPE_STRING);
            $i++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE EQUIPOS DE COMPUTACION.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');

        /*$writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');*/
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