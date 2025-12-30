<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\DB;
use Log;

use Illuminate\Http\Request;

class TestControllers extends Controller
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
        return view('Administrador.Test.reporte_test', compact('menus_'));
    }


    public function get_obtener_Fichas($fecha_inicio, $fecha_fin)
    {
        $id_usuario = session::get('id_users');

        // Initialize the condition variables
        $fecha = '';
        $id_usuario_condition = ''; // Initialize this variable separately to avoid overwriting $id_usuario

        // Check if the dates are provided
        if ($fecha_inicio == '' && $fecha_fin == '') {
            // No dates, so do not apply any filter
            $fecha = '';
        } else {
            // If dates are provided, add the WHERE condition to the query
            // Ensure the dates are properly formatted for SQL
            $fecha_inicio = \Carbon\Carbon::parse($fecha_inicio)->format('Y-m-d');
            $fecha_fin = \Carbon\Carbon::parse($fecha_fin)->format('Y-m-d');

            $fecha = "WHERE pp_fecha_created BETWEEN '$fecha_inicio' AND '$fecha_fin'";
        }

        // Check if $id_usuario exists, and apply it to the query
        if (!empty($id_usuario)) {
            // Append the user condition to the query
            $id_usuario_condition = "AND pp_id_usuario = $id_usuario";
        }

        // Consulta segura con bindings
        $sql = DB::connection('pgsql')->select("
        SELECT * FROM test.view_fichas
        WHERE date_end_test BETWEEN ? AND ?
    ", [$fecha_inicio, $fecha_fin]);


        // Check if the result is empty or not
        if (count($sql) > 0) {
            return response()->json(['data' => $sql, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function impirmir_pdf_fichas($fecha_inicio, $fecha_fin)
    {
        try {
            $userId = Session::get('id_users');
            $usuarioSession = Session::get('usuario');
            $nombres = Session::get('nombres');
            $apellidos = Session::get('apellidos');
            $usuario = $nombres . ' ' . $apellidos;

            // Validar fechas
            $fecha_inicio = Carbon::parse($fecha_inicio)->startOfDay()->format('Y-m-d H:i:s');
            $fecha_fin = Carbon::parse($fecha_fin)->endOfDay()->format('Y-m-d H:i:s');

            // Consulta segura con bindings
            $sql = DB::connection('pgsql')->select("
            SELECT * FROM test.view_fichas
            WHERE date_end_test BETWEEN ? AND ?
        ", [$fecha_inicio, $fecha_fin]);

            // Fechas y hora
            date_default_timezone_set('America/Guayaquil');
            $now = Carbon::now();
            $fecha = $now->toDateString();
            $hora = $now->toTimeString();
            $date_actual = $fecha . ' ' . $hora;
            $fecha_valida = $now->addMonths(4)->format('Y-m-d') . ' ' . $hora;

            $nombreArchivo = 'Reporte_ficha_' . $fecha . '.pdf';

            // Preparar datos para la vista
            $json_data = [
                'data'          => $sql,
                'usuario'       => $usuario,
                'usuarioSession' => $usuarioSession,
                'fecha_actual'  => $date_actual,
                'fecha_valida'  => $fecha_valida,
                'hora_actual'   => $hora,
                'fecha_inicio'   => $fecha_inicio,
                'fecha_fin'   => $fecha_fin,
            ];

            // Renderizar vista
            $html = view('Administrador.Test.reporte_pdf_ficha', $json_data)->render();

            // Configuración de Mpdf
            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new Mpdf([
                'fontDir' => array_merge($fontDirs, [public_path('fonts')]),
                'fontdata' => $fontData + [
                    'arial' => [
                        'R' => 'arial.ttf',
                        'B' => 'arialbd.ttf',
                    ],
                ],
                'default_font' => 'arial',
                'format' => [264.8, 188.9],
                'orientation' => 'P' // Paisaje
            ]);

            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($html);

            // Descargar el PDF directamente
            return response($mpdf->Output($nombreArchivo, 'I'), 200)
                ->header('Content-Type', 'application/pdf');
        } catch (\Exception $e) {
            log::error("Error al generar PDF: " . $e->getMessage());

            return response()->json([
                'respuesta' => false,
                'mensaje' => 'Error al generar el PDF.',
                'error' => $e->getMessage()
            ], 500);
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
