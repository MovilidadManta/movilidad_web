<?php

namespace App\Http\Controllers;

use  Session;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Codedge\Fpdf\Fpdf\Fpdf;
use Mpdf\Mpdf;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class ReporteEmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Administrador.Empleado.reporte_empleado');
    }
    public function indexp()
    {
        return view('Administrador.Empleado.reporte_empleado_pdf');
    }


    public function get_reporte_empleados($fecha_inicio, $fecha_fin)
    {
        $sql = DB::Select('select public.cursor_listar_reporte_empleados(?,?)', [$fecha_inicio, $fecha_fin]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_reporte_empleados;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function reportePdfEmpleados($fecha_inicio, $fecha_fin)
    {
        date_default_timezone_set('America/Guayaquil');
        $accion = 'ver';
        $tipo = 'fisico';
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();

        $sql = DB::Select('select public.cursor_listar_reporte_empleados(?,?)', [$fecha_inicio, $fecha_fin]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_reporte_empleados;
        }
        $json_data = json_decode($data);

        $json_data['empleados'] = $json_data;
        $json_data['fecha_inicio'] = $fecha_inicio;
        $json_data['fecha_fin'] = $fecha_fin;
        $json_data['usuario'] = $user;
        $json_data['fecha_actual'] = $fecha;
        $json_data['hora_actual'] = $hora;

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
                'default_font' => 'calibri(cuerpo)',
                // "format" => "A4",
                "format" => [264.8, 188.9],
                'orientation' => 'L',
                'default_font_size' => 8,
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

    public function imagen()
    {
        // $rutaImagen = "/1311718181.png";
        //$file = 'http://192.168.0.106:8000/imagenes_empleados/1311718183.jpeg';
        $contents = Storage::get('http://192.168.0.106:8000/imagenes_empleados/1311718183.jpeg');
        $imagenComoBase64 = base64_encode($contents);
        echo $imagenComoBase64;
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
        $año = date('Y');
        $hora = $date->toTimeString();

        if ($mes == 01) {
            $mes = 'enero';
        } else if ($mes == 2) {
            $mes = 'febrero';
        } else if ($mes == 3) {
            $mes = 'marzo';
        } else if ($mes == 4) {
            $mes = 'abril';
        } else if ($mes == 05) {
            $mes = 'mayo';
        } else if ($mes == 6) {
            $mes = 'junio';
        } else if ($mes == 7) {
            $mes = 'julio';
        } else if ($mes == 8) {
            $mes = 'agosto';
        } else if ($mes == 9) {
            $mes = 'septiembre';
        } else if ($mes == 10) {
            $mes = 'octubre';
        } else if ($mes == 11) {
            $mes = 'noviembre';
        } else if ($mes == 12) {
            $mes = 'diciembre';
        }

        $sql = DB::Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id;
        }
        $json_data = json_decode($data);
        $cedula = $json_data[0]->emp_cedula;

        $json_data['empleados'] = $json_data;
        $nombres = $json_data[0]->emp_nombre;
        $nombre = explode(" ", $nombres);
        $apeliidos = $json_data[0]->emp_apellido;
        $apeliido = explode(" ", $apeliidos);

        $correo=strtolower($nombre[0].'.'.$apeliido[0].'@movilidadmanta.gob.ec');

        $json_data['fecha_actual'] = $fecha;
        $json_data['dia'] = $dia;
        $json_data['mes'] = $mes;
        $json_data['año'] = $año;
        $json_data['correo'] = $correo;

        if ($json_data != "[]") {
            $html = view('Administrador.Empleado.reporte_acuerdo_responsabilidad_pdf', $json_data)->render();
            $header = view('Administrador.Empleado.header_responsabilidad', $json_data)->render();
            $namefile = $nombres.' '.$apeliidos.' - '.$cedula.' - AR.pdf';

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
            // $mpdf->SetTopMargin(5);
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHeader($header);
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
        $año = date('Y');
        $hora = $date->toTimeString();

        if ($mes == 01) {
            $mes = 'enero';
        } else if ($mes == 2) {
            $mes = 'febrero';
        } else if ($mes == 3) {
            $mes = 'marzo';
        } else if ($mes == 4) {
            $mes = 'abril';
        } else if ($mes == 05) {
            $mes = 'mayo';
        } else if ($mes == 6) {
            $mes = 'junio';
        } else if ($mes == 7) {
            $mes = 'julio';
        } else if ($mes == 8) {
            $mes = 'agosto';
        } else if ($mes == 9) {
            $mes = 'septiembre';
        } else if ($mes == 10) {
            $mes = 'octubre';
        } else if ($mes == 11) {
            $mes = 'noviembre';
        } else if ($mes == 12) {
            $mes = 'diciembre';
        }

        $sql = DB::Select('select public.cursor_listar_empleados_id(?)', [$id_empleado]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id;
        }
        $json_data = json_decode($data);
        $cedula = $json_data[0]->emp_cedula;
        $nombres = $json_data[0]->emp_nombre;
        $apellidos = $json_data[0]->emp_apellido;


        $json_data['empleados'] = $json_data;
        $json_data['fecha_actual'] = $fecha;
        $json_data['dia'] = $dia;
        $json_data['mes'] = $mes;
        $json_data['año'] = $año;

        if ($json_data != "[]") {
            $html = view('Administrador.Empleado.reporte_acuerdo_confidencialidad_pdf', $json_data)->render();
            $header = view('Administrador.Empleado.header_confidencialidad', $json_data)->render();
            $namefile = $nombres.' '.$apellidos.' - '.$cedula.' - AC.pdf';

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
            // $mpdf->SetTopMargin(5);
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHeader($header);
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
