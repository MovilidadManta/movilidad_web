<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
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

class ReporteEmpleadoController extends Controller
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
        return view('Administrador.Empleado.reporte_empleado', compact('menus_'));
    }
    public function indexp()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Empleado.reporte_empleado_pdf', compact('menus_'));
    }


    public function get_reporte_empleados($id_direccion, $id_jefatura, $fecha_inicio, $fecha_fin, $id_regimen_contractual)
    {
        if ($id_direccion == 0) {
            $ruta_direccion = '';
        } else {
            $ruta_direccion = "AND e.emp_id_departamento = $id_direccion";
        }

        if ($id_jefatura == 0) {
            $ruta_jefatura = '';
        } else {
            $ruta_jefatura = "AND e.emp_id_perfil = $id_jefatura";
        }

        if ($id_regimen_contractual == 0) {
            $ruta_regimen_contractual = '';
        } else {
            $ruta_regimen_contractual = 'AND e.emp_id_regimen_contractual = ' . $id_regimen_contractual;
        }


        if ($fecha_inicio == 0) {
            $ruta_fecha_inicio = '';
        } else {
            $ruta_fecha_inicio = "AND e.emp_fecha >= '$fecha_inicio'";
        }

        if ($fecha_fin == 0) {
            $ruta_fecha_fin = '';
        } else {
            $ruta_fecha_fin = "AND e.emp_fecha <= '$fecha_fin'";
        }

        //$sql = DB::Select('select public.cursor_listar_reporte_empleados(?,?,?,?)', [$id_direccion,$id_jefatura,$fecha_inicio, $fecha_fin]);
        $sql = DB::select("SELECT e.emp_id,
    e.emp_cedula,
    e.emp_nombre,
    e.emp_apellido,
    e.emp_id_perfil,
    e.emp_id_departamento,
    e.emp_tipo_contrato,
    e.emp_telefono,
    e.emp_direccion,
    e.emp_ruta_foto,
    e.emp_observacion,
    e.emp_remuneracion,
    e.emp_fecha_ingreso,
    e.emp_fecha,
    e.emp_fecha_update,
    e.emp_sexo,
    e.emp_id_regimen_contractual,
    e.emp_fecha_salida,
    e.emp_cargo,
    e.emp_edad,
    e.emp_fecha_nacimiento,
    e.emp_titulo,
    e.emp_id_empleado_biometrico,
    e.emp_tipo_sangre,
    e.emp_estado,
    e.emp_id_cargo,
    p.per_id,
    p.per_perfil,
    p.per_fecha,
    p.per_fecha_update,
    p.per_id_direccion,
    p.per_estado_direccion,
    d.dep_id,
    d.dep_departamento,
    d.dep_fecha,
    d.dep_fecha_update,
    c.ca_id,
    c.ca_cargo,
    c.ca_id_direccion,
    c.ca_id_jefatura,
    c.ca_estado,
    c.ca_fecha,
    c.ca_fecha_update,
    c.ca_id_cargo_superior
   FROM tbl_empleados e
	   LEFT JOIN tbl_jefaturas_subdirecciones p ON e.emp_id_perfil = p.per_id
     LEFT JOIN tbl_direcciones d ON e.emp_id_departamento = d.dep_id
     LEFT JOIN tbl_cargos c ON c.ca_id = e.emp_id_cargo
		 WHERE e.emp_estado ='A'
		 AND e.emp_id !=1
           $ruta_direccion
           $ruta_jefatura
           $ruta_regimen_contractual
           $ruta_fecha_inicio
           $ruta_fecha_fin
           ORDER by e.emp_id asc");

        $total_empleados = count($sql);
        if ($sql != "[]") {
            return response()->json(['data' => $sql, 'total_empleado' => $total_empleados, 'respuesta' => 'true']);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_reporte_empleados_niveles($niveles)
    {
        $sql = DB::select("SELECT e.emp_id,e.emp_cedula,			
        e.emp_nombre,				
        e.emp_apellido,			
        u.usu_correo,
        e.emp_cargo,			
        e.emp_id_perfil,
        p.per_perfil,		
        e.emp_id_departamento,
        d.dep_departamento,
        e.emp_tipo_contrato,
        e.emp_telefono,	
        e.emp_remuneracion,	
        e.emp_direccion,
        e.emp_ruta_foto,	
        e.emp_observacion,		
        e.emp_fecha_ingreso	,c.ca_cargo,d.dep_departamento, eo.eo_nivel 
        FROM tbl_estructuras_organicas eo 
        INNER JOIN tbl_direcciones d ON d.dep_id = eo.eo_id_direccion
        INNER JOIN tbl_cargos c ON c.ca_id = eo.eo_id_cargo
        FULL JOIN tbl_empleados e ON e.emp_id_cargo = c.ca_id
        INNER JOIN tbl_usuarios u ON e.emp_id = u.usu_id_empleado 
        INNER JOIN tbl_jefaturas_subdirecciones p ON e.emp_id_perfil = p.per_id
        where eo_nivel in(?) ORDER BY eo.eo_nivel ASC", [$niveles]);

        $total_empleados = count($sql);

        if ($sql != []) {
            return response()->json(['data' => $sql, 'total_empleado' => $total_empleados, 'respuesta' => 'true']);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }
    public function reportePdfEmpleados($id_direccion, $id_jefatura, $fecha_inicio, $fecha_fin, $id_regimen_contractual)
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

        if ($id_direccion == 0) {
            $ruta_direccion = '';
            $direccion = 'TODAS';
        } else {
            $ruta_direccion = "AND e.emp_id_departamento = $id_direccion";
            $direccion = DB::select('select dep_departamento from public.tbl_direcciones where dep_id=' . $id_direccion);
            foreach ($direccion as $d) {
                $direccion = $d->dep_departamento;
            }
        }

        if ($id_jefatura == 0) {
            $ruta_jefatura = '';
            $jefatura = 'TODAS';
        } else {
            $ruta_jefatura = "AND e.emp_id_perfil = $id_jefatura";
            $jefatura = DB::select('select per_perfil from public.tbl_jefaturas_subdirecciones where per_id =' . $id_jefatura);
            foreach ($jefatura as $j) {
                $jefatura = $j->per_perfil;
            }
        }

        if ($id_regimen_contractual == 0) {
            $ruta_regimen_contractual = '';
            $regimen_contractual = 'TODAS';
        } else {
            $ruta_regimen_contractual = 'AND e.emp_id_regimen_contractual = ' . $id_regimen_contractual;
            if ($id_regimen_contractual == 1) {
                $regimen_contractual = 'CODIGO DE TRABAJO';
            } elseif ($id_regimen_contractual == 2) {
                $regimen_contractual = 'LOEP';
            } elseif ($id_regimen_contractual == 3) {
                $regimen_contractual = 'LOSEP';
            } elseif ($id_regimen_contractual == 4) {
                $regimen_contractual = 'PROFESIONAL';
            }
        }

        if ($fecha_inicio == 0) {
            $ruta_fecha_inicio = '';
            $fecha_ini = 'TODAS';
        } else {
            $ruta_fecha_inicio = "AND e.emp_fecha >= TO_DATE('$fecha_inicio', 'YYYY-MM-DD')";
            $fecha_ini = $fecha_inicio;
        }

        if ($fecha_fin == 0) {
            $ruta_fecha_fin = '';
            $fecha_fi = 'TODAS';
        } else {
            $ruta_fecha_fin = "AND e.emp_fecha <= TO_DATE('$fecha_fin', 'YYYY-MM-DD')";
            $fecha_fi = $fecha_fin;
        }

        //$sql = DB::Select('select public.cursor_listar_reporte_empleados(?,?,?,?)', [$id_direccion,$id_jefatura,$fecha_inicio, $fecha_fin]);

        $json_data = DB::select("SELECT e.emp_id,
    e.emp_cedula,
    e.emp_nombre,
    e.emp_apellido,
    e.emp_id_perfil,
    e.emp_id_departamento,
    e.emp_tipo_contrato,
    e.emp_telefono,
    e.emp_direccion,
    e.emp_ruta_foto,
    e.emp_observacion,
    e.emp_remuneracion,
    e.emp_fecha_ingreso,
    e.emp_fecha,
    e.emp_fecha_update,
    e.emp_sexo,
    e.emp_id_regimen_contractual,
    e.emp_fecha_salida,
    e.emp_cargo,
    e.emp_edad,
    e.emp_fecha_nacimiento,
    e.emp_titulo,
    e.emp_id_empleado_biometrico,
    e.emp_tipo_sangre,
    e.emp_estado,
    e.emp_id_cargo,
    p.per_id,
    p.per_perfil,
    p.per_fecha,
    p.per_fecha_update,
    p.per_id_direccion,
    p.per_estado_direccion,
    d.dep_id,
    d.dep_departamento,
    d.dep_fecha,
    d.dep_fecha_update,
    c.ca_id,
    c.ca_cargo,
    c.ca_id_direccion,
    c.ca_id_jefatura,
    c.ca_estado,
    c.ca_fecha,
    c.ca_fecha_update,
    c.ca_id_cargo_superior
   FROM tbl_empleados e
	   LEFT JOIN tbl_jefaturas_subdirecciones p ON e.emp_id_perfil = p.per_id
     LEFT JOIN tbl_direcciones d ON e.emp_id_departamento = d.dep_id
     LEFT JOIN tbl_cargos c ON c.ca_id = e.emp_id_cargo
		 WHERE e.emp_estado ='A'
		 AND e.emp_id !=1
           $ruta_direccion
           $ruta_jefatura
           $ruta_regimen_contractual
           $ruta_fecha_inicio
           $ruta_fecha_fin
           ORDER by e.emp_id asc");

        /*$sql = DB::Select('select public.cursor_listar_reporte_empleados(?,?,?,?)', [$ruta_direccion,$ruta_jefatura,$ruta_fecha_inicio, $fecha_fin]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_reporte_empleados;
        }
        $json_data = json_decode($data);

        return $json_data;

        $json_data['empleados'] = $json_data;
        $json_data['fecha_inicio'] = $fecha_inicio;
        $json_data['fecha_fin'] = $fecha_fin;
        $json_data['usuario'] = $user;
        $json_data['fecha_actual'] = $fecha;
        $json_data['hora_actual'] = $hora;*/

        //return $json_data;

        /*if($usuario =='0'){
            $marcaciones_reporte=DB::Select('select public.cursor_lista_marcaciones_empleado_todos_reporte(?,?)',[$fechaIni,$fechaFin]);
            foreach ($marcaciones_reporte as $r){
                $lista_marcaciones_reporte = $r->cursor_lista_marcaciones_empleado_todos_reporte;
            }
        }else{
            $marcaciones_reporte=DB::Select('select public.cursor_lista_marcaciones_empleado_reporte(?,?,?)',[$fechaIni,$fechaFin,$usuario]);
            foreach ($marcaciones_reporte as $r){
                $lista_marcaciones_reporte = $r->cursor_lista_marcaciones_empleado_reporte;
            }
        }
        $data = json_decode($lista_marcaciones_reporte);

        foreach ($data as $i => $d) {
            $hora_m=$d->ma_hora;
        }

        $data['marcaciones'] = $data;
        $data['fecha_inicio'] = $fechaIni;
        $data['fecha_fin'] = $fechaFin;
        $data['usuario']=$user;
        $data['fecha_actual']=$fecha;
        $data['hora_actual']=$hora;

        $hora_mar = explode(".",$hora_m);
        $hora_marcacion = $hora_mar[0];
        $data['hora_marcacion']=$hora_marcacion;
        if($usuario=='0'){
        $data['usuario_todos'] = 0;
        }else{
        $data['usuario_todos'] = 1;
        }*/

        //$data['usuario_todos'] = 1;



        $json_data['empleados'] = $json_data;
        $json_data['fecha_inicio'] = $fecha_ini;
        $json_data['fecha_fin'] = $fecha_fi;
        $json_data['usuario'] = $user;
        $json_data['fecha_actual'] = $fecha;
        $json_data['hora_actual'] = $hora;
        $json_data['direccion'] = $direccion;
        $json_data['jefatura'] = $jefatura;
        $json_data['regimen_contractual'] = $regimen_contractual;

        if ($json_data != "[]") {
            $html = view('Administrador.Empleado.reporte_empleado_pdf', $json_data)->render();
            $namefile = 'ReporteEmpleado_' . time() . '.pdf';

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
        } else {
        }
    }

    public function reportePdfEmpleados_nivel($niveles)
    {
        date_default_timezone_set('America/Guayaquil');
        $accion = 'ver';
        $tipo = 'fisico';
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();

        $json_data = DB::select("SELECT e.emp_id,e.emp_cedula,			
        e.emp_nombre,				
        e.emp_apellido,			
        u.usu_correo,
        e.emp_cargo,			
        e.emp_id_perfil,
        p.per_perfil,		
        e.emp_id_departamento,
        d.dep_departamento,
        e.emp_tipo_contrato,
        e.emp_telefono,	
        e.emp_remuneracion,	
        e.emp_direccion,
        e.emp_ruta_foto,	
        e.emp_observacion,		
        e.emp_fecha_ingreso	,c.ca_cargo,d.dep_departamento, eo.eo_nivel 
        FROM tbl_estructuras_organicas eo 
        INNER JOIN tbl_direcciones d ON d.dep_id = eo.eo_id_direccion
        INNER JOIN tbl_cargos c ON c.ca_id = eo.eo_id_cargo
        FULL JOIN tbl_empleados e ON e.emp_id_cargo = c.ca_id
        INNER JOIN tbl_usuarios u ON e.emp_id = u.usu_id_empleado 
        INNER JOIN tbl_jefaturas_subdirecciones p ON e.emp_id_perfil = p.per_id
        where eo_nivel in(?) ORDER BY eo.eo_nivel ASC", [$niveles]);




        $json_data['empleados'] = $json_data;
        $json_data['fecha_inicio'] = 0;
        $json_data['fecha_fin'] = 0;
        $json_data['usuario'] = $user;
        $json_data['fecha_actual'] = $fecha;
        $json_data['hora_actual'] = $hora;
        $json_data['direccion'] = 0;
        $json_data['jefatura'] = 0;
        $json_data['regimen_contractual'] = 0;
        $json_data['niveles'] = $niveles;

        if ($json_data != "[]") {
            $html = view('Administrador.Empleado.reporte_empleado_pdf', $json_data)->render();
            $namefile = 'ReporteEmpleado_' . time() . '.pdf';

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
        } else {
        }
    }

    public function reporteExcelEmpleados($id_direccion, $id_jefatura, $fecha_inicio, $fecha_fin, $id_regimen_contractual)
    {
        /*$objPHPExcel = new PHPExcel();
         // Se asignan las propiedades del libro
        $objPHPExcel->getProperties()->setCreator("URBAN") //Autor
        ->setLastModifiedBy("URBAN") //Ultimo usuario que lo modificó
        ->setTitle("Reporte Excel de fichas")
        ->setSubject("Reporte Excel de fichas")
        ->setDescription("Reporte de fichas")
        ->setKeywords("Reporte")
        ->setCategory("Reporte excel");

        $tituloReporte = "GOBIERNO MUNICIPAL DEL CANTÓN JUNÍN ";

        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A6',  "AÑO")
        ->setCellValue('B6',  "CLAVE")
        ->setCellValue('C6',  "N. TÍTULO")
        ->setCellValue('D6',  "CONTRIBUYENTE")
        ->setCellValue('E6',  "CEDULA")
        ->setCellValue('F6',  "AREA TERRENO")
        ->setCellValue('G6',  "VALOR M2 TERRENO")
        ->setCellValue('H6',  "AVALUO TERRENO")
        ->setCellValue('I6',  "AREA CONSTRUCCION")
        ->setCellValue('J6',  "AVALUO CONSTRUCCION")
        ->setCellValue('K6',  "AVALUO TOTAL")
        ->setCellValue('L6',  "DESCUENTO LEY ANCIANO")
        ->setCellValue('M6',  "DESCUENTO LEY DISCAPACIDAD")
        ->setCellValue('N6',  "DESCUENTO LEY HIPOTECARIA")
        ->setCellValue('O6',  "BASE IMPONIBLE")
        ->setCellValue('P6',  "IMP PREDIAL")
        ->setCellValue('Q6',  "TASA ADMINISTRATIVA")
        ->setCellValue('R6',  "SOLAR NO EDIFICADO")
        ->setCellValue('S6',  "BOMBEROS")
        ->setCellValue('T6',  "CEM")
        ->setCellValue('U6',  "TOTAL")
        ->setCellValue('V6',  "TASA");


        header('Content-Type: application/vnd.ms-excel');
        $ann = '2013';
        header('Content-Disposition: attachment;filename="ReporteEmitidosIMPU-'.$ann.'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');*/
        date_default_timezone_set('America/Guayaquil');
        $accion = 'ver';
        $tipo = 'fisico';
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();

        if ($id_direccion == 0) {
            $ruta_direccion = '';
            $direccion = 'TODAS';
        } else {
            $ruta_direccion = "AND e.emp_id_departamento = $id_direccion";
            $direccion = DB::select('select dep_departamento from public.tbl_direcciones where dep_id=' . $id_direccion);
            foreach ($direccion as $d) {
                $direccion = $d->dep_departamento;
            }
        }

        if ($id_jefatura == 0) {
            $ruta_jefatura = '';
            $jefatura = 'TODAS';
        } else {
            $ruta_jefatura = "AND e.emp_id_perfil = $id_jefatura";
            $jefatura = DB::select('select per_perfil from public.tbl_jefaturas_subdirecciones where per_id =' . $id_jefatura);
            foreach ($jefatura as $j) {
                $jefatura = $j->per_perfil;
            }
        }

        if ($id_regimen_contractual == 0) {
            $ruta_regimen_contractual = '';
            $regimen_contractual = 'TODAS';
        } else {
            $ruta_regimen_contractual = 'AND e.emp_id_regimen_contractual = ' . $id_regimen_contractual;
            if ($id_regimen_contractual == 1) {
                $regimen_contractual = 'CODIGO DE TRABAJO';
            } elseif ($id_regimen_contractual == 2) {
                $regimen_contractual = 'LOEP';
            } elseif ($id_regimen_contractual == 3) {
                $regimen_contractual = 'LOSEP';
            } elseif ($id_regimen_contractual == 4) {
                $regimen_contractual = 'PROFESIONAL';
            }
        }

        if ($fecha_inicio == 0) {
            $ruta_fecha_inicio = '';
            $fecha_ini = 'TODAS';
        } else {
            $ruta_fecha_inicio = "AND e.emp_fecha >= TO_DATE('$fecha_inicio', 'YYYY-MM-DD')";
            $fecha_ini = $fecha_inicio;
        }

        if ($fecha_fin == 0) {
            $ruta_fecha_fin = '';
            $fecha_fi = 'TODAS';
        } else {
            $ruta_fecha_fin = "AND e.emp_fecha <= TO_DATE('$fecha_fin', 'YYYY-MM-DD')";
            $fecha_fi = $fecha_fin;
        }

        $json_data = DB::select("SELECT e.emp_id,
    e.emp_cedula,
    e.emp_nombre,
    e.emp_apellido,
    e.emp_id_perfil,
    e.emp_id_departamento,
    e.emp_tipo_contrato,
    e.emp_telefono,
    e.emp_direccion,
    e.emp_ruta_foto,
    e.emp_observacion,
    e.emp_remuneracion,
    e.emp_fecha_ingreso,
    e.emp_fecha,
    e.emp_fecha_update,
    e.emp_sexo,
    e.emp_id_regimen_contractual,
    e.emp_fecha_salida,
    e.emp_cargo,
    e.emp_edad,
    e.emp_fecha_nacimiento,
    e.emp_titulo,
    e.emp_id_empleado_biometrico,
    e.emp_tipo_sangre,
    e.emp_estado,
    e.emp_id_cargo,
    p.per_id,
    p.per_perfil,
    p.per_fecha,
    p.per_fecha_update,
    p.per_id_direccion,
    p.per_estado_direccion,
    d.dep_id,
    d.dep_departamento,
    d.dep_fecha,
    d.dep_fecha_update,
    c.ca_id,
    c.ca_cargo,
    c.ca_id_direccion,
    c.ca_id_jefatura,
    c.ca_estado,
    c.ca_fecha,
    c.ca_fecha_update,
    c.ca_id_cargo_superior
   FROM tbl_empleados e
	   LEFT JOIN tbl_jefaturas_subdirecciones p ON e.emp_id_perfil = p.per_id
     LEFT JOIN tbl_direcciones d ON e.emp_id_departamento = d.dep_id
     LEFT JOIN tbl_cargos c ON c.ca_id = e.emp_id_cargo
		 WHERE e.emp_estado ='A'
		 AND e.emp_id !=1
           $ruta_direccion
           $ruta_jefatura
           $ruta_regimen_contractual
           $ruta_fecha_inicio
           $ruta_fecha_fin
           ORDER by e.emp_id asc");

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
        $titulo_direccion_jefa = 'DIRECCION: ' . $direccion . ' || JEFATURA: ' . $jefatura . '  || REGIMEN CONTRACTUAL: ' . $regimen_contractual;
        $titulo_desde_hasta = 'DESDE: ' . $fecha_ini . ' || HASTA: ' . $fecha_fi;

        $Generado = 'Usuario: ' . $user . ' || Generado: ' . $fecharepo . ' || Hora: ' . $h . 'h' . $ii . ':' . $s;


        $sheet = $spreadsheet->getActiveSheet()
            ->setCellValue('A8', "CEDULA")
            ->setCellValue('B8', "FUNCIONARIO")
            ->setCellValue('C8', "DIRECCION")
            ->setCellValue('D8', "JEFATURA")
            ->setCellValue('E8', "CARGO")
            ->setCellValue('F8', "SALARIO")
            ->setCellValue('G8', "TELEFONO")
            ->setCellValue('H8', "FECHA INGRESO")
            ->setCellValue('I8', "DOMICILIO");

        $spreadsheet->setActiveSheetIndex(0)
            ->mergeCells('A1:J1');
        $spreadsheet->setActiveSheetIndex(0)
            ->mergeCells('A2:J2');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $tituloReporte);
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A3:I3');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', $tituloReporte1);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A4:I4');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', $titulo_direccion_jefa);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A5:I5');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', $titulo_desde_hasta);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A6:I6');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A6', $Generado);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A1:I1');

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

        $spreadsheet->setActiveSheetIndex(0)->getStyle('A2:I2')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A2:I2')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A8:I8')->applyFromArray($negrillaa);
        // $spreadsheet->getActiveSheet()->getStyle('A4:V4')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A3:I3')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A4:I4')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A5:I5')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A6:I6')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A7:I7')->applyFromArray($styleArray);
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
            $cedula = $value->emp_cedula;
            $nombres = $value->emp_apellido . ' ' . $value->emp_nombre;
            $departamento = $value->dep_departamento;
            $perfil = $value->per_perfil;
            $cargo = $value->ca_cargo;
            $remuneracion = $value->emp_remuneracion;
            $telefono = $value->emp_telefono;
            $fecha_ingreso = $value->emp_fecha_ingreso;
            $domicilio = $value->emp_direccion;

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValueExplicit('A' . $i, $cedula, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B' . $i, $nombres, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('C' . $i, $departamento, PHPExcel_Cell_DataType::TYPE_STRING)

                ->setCellValueExplicit('D' . $i, $perfil, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E' . $i, $cargo, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('F' . $i, '$' . $remuneracion, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('G' . $i, $telefono, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('H' . $i, $fecha_ingreso, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('I' . $i, $domicilio, PHPExcel_Cell_DataType::TYPE_STRING);
            $i++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE NOMINA DE EMPLEADOS.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');

        /*$writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');*/
    }

    public function reporteExcelEmpleados_nivel($niveles)
    {

        date_default_timezone_set('America/Guayaquil');
        $accion = 'ver';
        $tipo = 'fisico';
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();



        $json_data = DB::select("SELECT e.emp_id,e.emp_cedula,			
        e.emp_nombre,				
        e.emp_apellido,			
        u.usu_correo,
        e.emp_cargo,			
        e.emp_id_perfil,
        p.per_perfil,		
        e.emp_id_departamento,
        d.dep_departamento,
        e.emp_tipo_contrato,
        e.emp_telefono,	
        e.emp_remuneracion,	
        e.emp_direccion,
        e.emp_ruta_foto,	
        e.emp_observacion,		
        e.emp_fecha_ingreso	,c.ca_cargo,d.dep_departamento, eo.eo_nivel 
        FROM tbl_estructuras_organicas eo 
        INNER JOIN tbl_direcciones d ON d.dep_id = eo.eo_id_direccion
        INNER JOIN tbl_cargos c ON c.ca_id = eo.eo_id_cargo
        FULL JOIN tbl_empleados e ON e.emp_id_cargo = c.ca_id
        INNER JOIN tbl_usuarios u ON e.emp_id = u.usu_id_empleado 
        INNER JOIN tbl_jefaturas_subdirecciones p ON e.emp_id_perfil = p.per_id
        where eo_nivel in(?) ORDER BY eo.eo_nivel ASC", [$niveles]);

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

        $spreadsheet = new Spreadsheet();


        $fecharepo = $a . '-' . $mes . '-' . $d;
        $tituloReporte1 = "REPORTE DE NOMINA DE EMPLEADOS";
        $tituloReporte = "EMPRESA PUBLICA MOVILIDAD DE MANTA EP";
        $titulo_direccion_jefa = ''; //'DIRECCION: ' . $direccion . ' || JEFATURA: ' . $jefatura . '  || REGIMEN CONTRACTUAL: ' . $regimen_contractual;
        $titulo_desde_hasta = ''; //'DESDE: ' . $fecha_ini . ' || HASTA: ' . $fecha_fi;

        $Generado = 'Usuario: ' . $user . ' || Generado: ' . $fecharepo . ' || Hora: ' . $h . 'h' . $ii . ':' . $s;


        $sheet = $spreadsheet->getActiveSheet()
            ->setCellValue('A8', "CEDULA")
            ->setCellValue('B8', "FUNCIONARIO")
            ->setCellValue('C8', "DIRECCION")
            ->setCellValue('D8', "JEFATURA")
            ->setCellValue('E8', "CARGO")
            ->setCellValue('F8', "SALARIO")
            ->setCellValue('G8', "TELEFONO")
            ->setCellValue('H8', "FECHA INGRESO")
            ->setCellValue('I8', "DOMICILIO")
            ->setCellValue('J8', "CORREO");

        $spreadsheet->setActiveSheetIndex(0)
            ->mergeCells('A1:J1');
        $spreadsheet->setActiveSheetIndex(0)
            ->mergeCells('A2:J2');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', $tituloReporte);
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A3:I3');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', $tituloReporte1);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A4:I4');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', $titulo_direccion_jefa);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A5:I5');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A5', $titulo_desde_hasta);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A6:I6');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A6', $Generado);

        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A1:I1');

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

        $spreadsheet->setActiveSheetIndex(0)->getStyle('A2:I2')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A2:I2')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A8:J8')->applyFromArray($negrillaa);
        // $spreadsheet->getActiveSheet()->getStyle('A4:V4')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A3:I3')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A4:I4')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A5:I5')->applyFromArray($estiloTituloReporte);
        $spreadsheet->getActiveSheet()->getStyle('A6:I6')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A7:I7')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getProtection()->setInsertRows(true);
        $spreadsheet->getActiveSheet()->getProtection()->setFormatCells(true);
        $spreadsheet->getActiveSheet()->getProtection()->setSort(true);
        $spreadsheet->getActiveSheet()->getProtection()->setSheet(true);

        $con = 0;
        $i = 9;

        foreach ($json_data as $value) {
            //AGREGAR FOTO
            // Add a drawing to the worksheet
            $cedula = $value->emp_cedula;
            $nombres = $value->emp_apellido . ' ' . $value->emp_nombre;
            $departamento = $value->dep_departamento;
            $perfil = $value->per_perfil;
            $cargo = $value->emp_cargo;
            $remuneracion = $value->emp_remuneracion;
            $telefono = $value->emp_telefono;
            $fecha_ingreso = $value->emp_fecha_ingreso;
            $domicilio = $value->emp_direccion;
            $correo = $value->usu_correo;

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValueExplicit('A' . $i, $cedula, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B' . $i, $nombres, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('C' . $i, $departamento, PHPExcel_Cell_DataType::TYPE_STRING)

                ->setCellValueExplicit('D' . $i, $perfil, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E' . $i, $cargo, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('F' . $i, '$' . $remuneracion, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('G' . $i, $telefono, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('H' . $i, $fecha_ingreso, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('I' . $i, $domicilio, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('J' . $i, $correo, PHPExcel_Cell_DataType::TYPE_STRING);
            $i++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE NOMINA DE EMPLEADOS.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function reportePdfAcuerdoResponsabilidad($id_empleado)
    {
        date_default_timezone_set('America/Guayaquil');
        $accion = 'ver';
        $tipo = 'fisico';
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $dia = date('d');
        $mes = date('m');
        $mes_n = date('m');
        $año = date('Y');
        $hora = $date->toTimeString();

        if ($mes == 01) {
            $mes = 'enero';
        } elseif ($mes == 2) {
            $mes = 'febrero';
        } elseif ($mes == 3) {
            $mes = 'marzo';
        } elseif ($mes == 4) {
            $mes = 'abril';
        } elseif ($mes == 05) {
            $mes = 'mayo';
        } elseif ($mes == 6) {
            $mes = 'junio';
        } elseif ($mes == 7) {
            $mes = 'julio';
        } elseif ($mes == 8) {
            $mes = 'agosto';
        } elseif ($mes == 9) {
            $mes = 'septiembre';
        } elseif ($mes == 10) {
            $mes = 'octubre';
        } elseif ($mes == 11) {
            $mes = 'noviembre';
        } elseif ($mes == 12) {
            $mes = 'diciembre';
        }
        //$sql = DB::Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);
        $json_data = DB::connection('pgsql')->select("select * from view_empleados_t where emp_id = $id_empleado");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id;
        }*/

        $cedula = $json_data[0]->emp_cedula;

        $json_data['empleados'] = $json_data;
        $nombres = $json_data[0]->emp_nombre;
        $nombre = explode(" ", $nombres);
        $apeliidos = $json_data[0]->emp_apellido;
        $apeliido = explode(" ", $apeliidos);

        $correo = strtolower($nombre[0] . '.' . $apeliido[0] . '@movilidadmanta.gob.ec');

        $json_data['fecha_actual'] = $fecha;
        $json_data['dia'] = $dia;
        $json_data['mes'] = $mes;
        $json_data['año'] = $año;
        $json_data['correo'] = $correo;

        $html = view('Administrador.Empleado.reporte_acuerdo_responsabilidad_pdf', $json_data)->render();
        $header = view('Administrador.Empleado.header_responsabilidad', $json_data)->render();
        $namefile = $nombres . ' ' . $apeliidos . ' - ' . $cedula . ' - AR.pdf';

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
            'default_font' => 'calibri(cuerpo)',
            // "format" => "A4",
            "format" => [264.8, 188.9],
            'orientation' => 'L',
            'default_font_size' => 9,
        ]);

        // Example content

        // Add content to PDF
        $mpdf->SetHeader($header);
        $mpdf->WriteHTML($html);

        // Output PDF
        $mpdf->Output($namefile, 'D');

        exit;
    }

    public function reportePdfAcuerdoConfidencialidad($id_empleado)
    {
        date_default_timezone_set('America/Guayaquil');
        $accion = 'ver';
        $tipo = 'fisico';
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $dia = date('d');
        $mes = date('m');
        $mes_n = date('m');
        $año = date('Y');
        $hora = $date->toTimeString();

        if ($mes == 01) {
            $mes = 'enero';
        } elseif ($mes == 2) {
            $mes = 'febrero';
        } elseif ($mes == 3) {
            $mes = 'marzo';
        } elseif ($mes == 4) {
            $mes = 'abril';
        } elseif ($mes == 05) {
            $mes = 'mayo';
        } elseif ($mes == 6) {
            $mes = 'junio';
        } elseif ($mes == 7) {
            $mes = 'julio';
        } elseif ($mes == 8) {
            $mes = 'agosto';
        } elseif ($mes == 9) {
            $mes = 'septiembre';
        } elseif ($mes == 10) {
            $mes = 'octubre';
        } elseif ($mes == 11) {
            $mes = 'noviembre';
        } elseif ($mes == 12) {
            $mes = 'diciembre';
        }
        //$sql = DB::Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);
        $json_data = DB::connection('pgsql')->select("select * from view_empleados_t where emp_id = $id_empleado");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id;
        }*/

        //$json_data = json_decode($data);
        $cedula = $json_data[0]->emp_cedula;
        $nombres = $json_data[0]->emp_nombre;
        $apellidos = $json_data[0]->emp_apellido;

        $json_data['empleados'] = $json_data;
        $json_data['fecha_actual'] = $fecha;
        $json_data['dia'] = $dia;
        $json_data['mes'] = $mes;
        $json_data['mes_n'] = $mes_n;
        $json_data['año'] = $año;
        $json_data['id_empleado'] = $id_empleado;
        $html = view('Administrador.Empleado.reporte_acuerdo_confidencialidad_pdf', $json_data)->render();
        $header = view('Administrador.Empleado.header_confidencialidad', $json_data)->render();
        $namefile = $nombres . ' ' . $apellidos . ' - ' . $cedula . ' - AC.pdf';

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
            'default_font' => 'calibri(cuerpo)',
            // "format" => "A4",
            "format" => [264.8, 188.9],
            'orientation' => 'L',
            'default_font_size' => 9,
        ]);

        // Example content

        // Add content to PDF
        $mpdf->SetHeader($header);
        $mpdf->WriteHTML($html);

        // Output PDF
        $mpdf->Output($namefile, 'D');

        exit;
    }

    public function generatePdf($id_empleado)
    {
        date_default_timezone_set('America/Guayaquil');
        $accion = 'ver';
        $tipo = 'fisico';
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $dia = date('d');
        $mes = date('m');
        $mes_n = date('m');
        $año = date('Y');
        $hora = $date->toTimeString();

        if ($mes == 01) {
            $mes = 'enero';
        } elseif ($mes == 2) {
            $mes = 'febrero';
        } elseif ($mes == 3) {
            $mes = 'marzo';
        } elseif ($mes == 4) {
            $mes = 'abril';
        } elseif ($mes == 05) {
            $mes = 'mayo';
        } elseif ($mes == 6) {
            $mes = 'junio';
        } elseif ($mes == 7) {
            $mes = 'julio';
        } elseif ($mes == 8) {
            $mes = 'agosto';
        } elseif ($mes == 9) {
            $mes = 'septiembre';
        } elseif ($mes == 10) {
            $mes = 'octubre';
        } elseif ($mes == 11) {
            $mes = 'noviembre';
        } elseif ($mes == 12) {
            $mes = 'diciembre';
        }
        //$sql = DB::Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);
        $json_data = DB::connection('pgsql')->select("select * from view_empleados_t where emp_id = $id_empleado");

        /*foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id;
        }*/

        $cedula = $json_data[0]->emp_cedula;

        $json_data['empleados'] = $json_data;
        $nombres = $json_data[0]->emp_nombre;
        $nombre = explode(" ", $nombres);
        $apeliidos = $json_data[0]->emp_apellido;
        $apeliido = explode(" ", $apeliidos);

        $correo = strtolower($nombre[0] . '.' . $apeliido[0] . '@movilidadmanta.gob.ec');

        $json_data['fecha_actual'] = $fecha;
        $json_data['dia'] = $dia;
        $json_data['mes'] = $mes;
        $json_data['año'] = $año;
        $json_data['correo'] = $correo;

        $html = view('Administrador.Empleado.reporte_acuerdo_responsabilidad_pdf', $json_data)->render();
        $header = view('Administrador.Empleado.header_responsabilidad', $json_data)->render();
        $namefile = $nombres . ' ' . $apeliidos . ' - ' . $cedula . ' - AR.pdf';

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
            'default_font' => 'calibri(cuerpo)',
            // "format" => "A4",
            "format" => [264.8, 188.9],
            'orientation' => 'L',
            'default_font_size' => 9,
        ]);

        // Example content

        // Add content to PDF
        $mpdf->SetHeader($header);
        $mpdf->WriteHTML($html);

        // Output PDF
        $mpdf->Output($namefile, 'D');

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
