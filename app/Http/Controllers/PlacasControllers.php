<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Exception;
use Storage;
use Predis\Response\Status;
use Illuminate\Http\JsonResponse;
use Session;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;
use File;
use Carbon\Carbon;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use Mpdf\QrCode\Output;
use App\Helpers\DatesHelper;
use Mpdf\Tag\Br;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class PlacasControllers extends Controller
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

        return view('Administrador.Placa.placa', compact('menus_'));
    }

    public function  get_vehiculo($placa)
    {
        $objeto_Api = new ApiControllers();

        try {
            // Validación de la entrada (por ejemplo, si el valor de placa es válido)
            if (!preg_match('/^[A-Za-z0-9]+$/', $placa)) {
                return response()->json(['error' => 'Placa no válida'], 400);
            }

            $data = $objeto_Api->consultar_vehiculo($placa);
            $data_ = $data->getData(true);

            // Si la consulta a la API devuelve null o un error, manejamos ese caso
            if (!$data) {
                return response()->json(['error' => 'No se encontró información del vehículo'], 404);
            }

            // Guardar la placa provisional
            $guardar_placa = $this->save_placa_provisional($data, $placa);

            // Verificar si la acción fue exitosa
            if ($guardar_placa->isSuccessful()) {
                $dat_ = $guardar_placa->getData(true);
                //return $data;
                return response()->json(['data' => $data_['data'], 'id' => $dat_['data'], 'status' => 200], 200); // Respuesta exitosa
                //return $dat_['data']; // Respuesta exitosa
            } else {
                return response()->json(['error' => 'Error al guardar la placa provisional'], 500);
            }
        } catch (\Exception $e) {
            // Capturar cualquier excepción inesperada
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
        }
    }

    public function save_placa_provisional($data, $placa)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        //$vehiculoData = $request->input('vehiculo_data');
        $data_api = $data->getData(true);
        $cedula = $data_api['data']['identBenef'];
        $nombre_empleado = $data_api['data']['nombreBenef'];

        $json[] = [
            'placa' => strtoupper($placa),
            'data' => $data,
            'cedula' => $cedula,
            'nombre_propietario' => $nombre_empleado
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::connection('pgsql')->Select('select public.procedimiento_registrar_datos_placas_provisionales(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_placas_provisionales;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => true, "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function impirmir_placa_provisional_pdf($placa, $id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id'     => $id,
            'estado' => "A",
            'placa'  => $placa
        ];
        $jsoninsert = json_encode($json);

        try {
            // Ejecutar la consulta en PostgreSQL
            $sql = DB::connection('pgsql')->select('select public.procedimiento_modificar_datos_placa_provisional(?, ?, ?)', [$jsoninsert, $ip, $user]);

            if ($sql) {
                // Obtener datos para el PDF
                $sql = DB::connection('pgsql')->select("select * from view_placas_provisionales where pp_id = $id");
                foreach ($sql as $value) {
                    $data = json_decode($value->pp_respuesta_json);
                }
                $data_ = $data->original->data;

                // Configurar fechas y usuario
                date_default_timezone_set('America/Guayaquil');
                $usuarioSession = session::get('usuario');
                $now          = Carbon::now();
                $date_actual  = $now->format('Y-m-d H:i:s');
                $date_valida  = $now->copy()->addMonthsNoOverflow(6)->format('Y-m-d H:i:s');
                $usuario      = session::get('nombres') . ' ' . session::get('apellidos');
                $nombreArchivo = $placa . '_' . $id . '.pdf';

                // Generar el código QR
                $png = QrCode::format('png')->size(100)
                    ->generate('https://movilidadmanta.gob.ec/descargar-ftp/' . $nombreArchivo);
                $png = base64_encode($png);
                $png_logo_movilidad = base64_encode('https://movilidadmanta.gob.ec/logo/movilidad.png');

                // Datos para el PDF
                $json_data = [];
                $json_data['data']          = $data_;
                $json_data['usuario']       = $usuarioSession;
                $json_data['qr_placa']      = $png;
                $json_data['fecha_tramite'] = $date_actual;
                $json_data['fecha_valida']  = $date_valida;
                $json_data['usuario']       = $usuario;
                $json_data['placa_1']       = $placa[0] . '' . $placa[1];
                $json_data['placa_2']       = $placa[2] . '' . $placa[3] . '' . $placa[4] . '' . $placa[5];
                $json_data['png_logo_movilidad']       = $png_logo_movilidad;
                $clase_vehiculo             = $data_->clase_vehiculo;
                $isCar = $clase_vehiculo != "G";


                // Generar el HTML del reporte en base a la clase de vehículo
                if (!empty($json_data)) {
                    if ($isCar) {
                        $html = view('Administrador.Placa.reporte_placa_provisional_carro', $json_data)->render();
                    } else {
                        $html = view('Administrador.Placa.reporte_placa_provisional_moto', $json_data)->render();
                    }

                    // Generar nombre del archivo PDF
                    $namefile = $placa . '_' . $id . '.pdf';

                    // Configuración de Mpdf
                    $defaultConfig   = (new \Mpdf\Config\ConfigVariables())->getDefaults();
                    $fontDirs        = $defaultConfig['fontDir'];
                    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
                    $fontData        = $defaultFontConfig['fontdata'];
                    $mpdf = new \Mpdf\Mpdf([
                        'fontDir'     => array_merge($fontDirs, [public_path() . '/fonts']),
                        'fontdata'    => $fontData + [
                            'arial' => [
                                'R' => 'arial.ttf',
                                'B' => 'arialbd.ttf',
                            ],
                        ],
                        'default_font' => 'arial',
                        "format"      => [264.8, 188.9],
                    ]);

                    // Definir orientación según clase de vehículo
                    if ($isCar) {
                        $mpdf->AddPage('P');
                    } else {
                        $mpdf->AddPage('L');
                    }

                    $mpdf->SetDisplayMode('fullpage');
                    $mpdf->WriteHTML($html);

                    // Generar el contenido PDF en memoria (modo 'S' para retornar el contenido)
                    $pdfContent = $mpdf->Output('', 'S');

                    // Guardar el PDF en el FTP usando el disco "ftp_movilidad" y la carpeta "placa"
                    $ftp_disk = Storage::disk('ftp_movilidad');
                    $ftp_path = '/ftpplacasprovisionales/placas/' . $namefile;
                    if ($ftp_disk->put($ftp_path, $pdfContent)) {
                        // Verificar que el archivo se encuentre en el FTP
                        if ($ftp_disk->exists($ftp_path)) {
                            // Se retorna la URL del archivo; si no se tiene una URL pública configurada, se puede retornar la ruta relativa
                            return response()->json([
                                'respuesta' => true,
                                'pdf_url'   => $ftp_disk->url($ftp_path)
                            ]);
                        } else {
                            return response()->json([
                                'respuesta' => false,
                                'error'     => 500,
                                'mensaje'   => 'Archivo no encontrado en el servidor FTP tras subirlo'
                            ]);
                        }
                    } else {
                        return response()->json([
                            'respuesta' => false,
                            'error'     => 500,
                            'mensaje'   => 'Error al subir el archivo al FTP'
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'respuesta' => false,
                    'error'     => 404,
                    'mensaje'   => 'No se obtuvo resultado, consulta no exitosa'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'respuesta' => false,
                'error'     => 404,
                'mensaje'   => $e->getMessage()
            ]);
        }
    }

    public function descargar_placa_provisional($archivo)
    {
        $path = "/ftpplacasprovisionales/placas/$archivo";
        return Storage::disk('ftp_movilidad')->download($path);
    }

    public function descargar_placa_provisional_v2($archivo)
    {
        $path = "/ftpplacasprovisionales_v2/placas/$archivo";
        return Storage::disk('ftp_movilidad')->download($path);
    }

    public function index_placa_provisional_reporte()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();

        return view('Administrador.Placa.reporte_placa_provisional', compact('menus_'));
    }

    public function get_placa_provisional($fecha_inicio, $fecha_fin)
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

        // Combine the conditions into the query
        $sql = DB::connection('pgsql')->select("SELECT * FROM view_placas_provisionales $fecha");

        // Check if the result is empty or not
        if (count($sql) > 0) {
            return response()->json(['data' => $sql, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function impirmir_placa_provisional_pdf_v2($placa, $id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id'     => $id,
            'estado' => "A",
            'placa'  => $placa
        ];
        $jsoninsert = json_encode($json);

        try {
            // Ejecutar la consulta en PostgreSQL
            $sql = DB::connection('pgsql')->select('select public.procedimiento_modificar_datos_placa_provisional(?, ?, ?)', [$jsoninsert, $ip, $user]);

            if ($sql) {
                // Obtener datos para el PDF
                $sql = DB::connection('pgsql')->select("select * from view_placas_provisionales where pp_id = $id");
                foreach ($sql as $value) {
                    $data = json_decode($value->pp_respuesta_json);
                }
                $data_ = $data->original->data;

                // Configurar fechas y usuario
                date_default_timezone_set('America/Guayaquil');
                $usuarioSession = session::get('usuario');
                $now          = Carbon::now();
                $date_actual  = $now->format('Y-m-d H:i:s');
                $date_valida  = $now->copy()->addMonthsNoOverflow(6)->format('Y-m-d H:i:s');
                $usuario      = session::get('nombres') . ' ' . session::get('apellidos');
                $nombreArchivo = $placa . '_' . $id . '.pdf';

                // Generar el código QR
                $png = QrCode::format('png')->size(100)
                    ->generate('https://movilidadmanta.gob.ec/descargar-ftp-v2/' . $nombreArchivo);
                $png = base64_encode($png);
                $png_logo_movilidad = base64_encode('https://movilidadmanta.gob.ec/logo/movilidad.png');

                // Datos para el PDF
                $json_data = [];
                $json_data['data']          = $data_;
                $json_data['usuario']       = $usuarioSession;
                $json_data['qr_placa']      = $png;
                $json_data['fecha_tramite'] = $date_actual;
                $json_data['fecha_valida']  = $date_valida;
                $json_data['usuario']       = $usuario;
                $json_data['placa_moto']       = $placa;
                $json_data['png_logo_movilidad']       = $png_logo_movilidad;
                $clase_vehiculo             = $data_->clase_vehiculo;
                $isCar = $clase_vehiculo != "G";


                // Generar el HTML del reporte en base a la clase de vehículo
                if (!empty($json_data)) {
                    if ($isCar) {
                        $html = view('Administrador.Placa.reporte_placa_provisional_carro_v2', $json_data)->render();
                    } else {
                        $html = view('Administrador.Placa.reporte_placa_provisional_moto_v2', $json_data)->render();
                    }

                    // Generar nombre del archivo PDF
                    $namefile = $placa . '_' . $id . '.pdf';

                    // Configuración de Mpdf
                    $defaultConfig   = (new \Mpdf\Config\ConfigVariables())->getDefaults();
                    $fontDirs        = $defaultConfig['fontDir'];
                    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
                    $fontData        = $defaultFontConfig['fontdata'];
                    $mpdf = new \Mpdf\Mpdf([
                        'fontDir'     => array_merge($fontDirs, [public_path() . '/fonts']),
                        'fontdata'    => $fontData + [
                            'arial' => [
                                'R' => 'arial.ttf',
                                'B' => 'arialbd.ttf',
                            ],
                        ],
                        'default_font' => 'arial',
                        "format"      => $isCar ? 'A3' : 'A4',
                        'orientation'   => 'L',
                        'defaultheaderline' => 0,
                        'defaultfooterline' => 0,
                    ]);

                    $mpdf->SetDisplayMode('fullpage');
                    $mpdf->WriteHTML($html);
                    $mpdf->SetJS("this.print({bUI:true,bSilent:false,bShrinkToFit:false});");
                    $mpdf->debug = true;

                    // Generar el contenido PDF en memoria (modo 'S' para retornar el contenido)
                    $pdfContent = $mpdf->Output('', 'S');

                    // Guardar el PDF en el FTP usando el disco "ftp_movilidad" y la carpeta "placa"
                    $ftp_disk = Storage::disk('ftp_movilidad');
                    $ftp_path = '/ftpplacasprovisionales_v2/placas/' . $namefile;
                    if ($ftp_disk->put($ftp_path, $pdfContent)) {
                        // Verificar que el archivo se encuentre en el FTP
                        if ($ftp_disk->exists($ftp_path)) {
                            // Se retorna la URL del archivo; si no se tiene una URL pública configurada, se puede retornar la ruta relativa
                            return response()->json([
                                'respuesta' => true,
                                'pdf_url'   => $ftp_disk->url($ftp_path)
                            ]);
                        } else {
                            return response()->json([
                                'respuesta' => false,
                                'error'     => 500,
                                'mensaje'   => 'Archivo no encontrado en el servidor FTP tras subirlo'
                            ]);
                        }
                    } else {
                        return response()->json([
                            'respuesta' => false,
                            'error'     => 500,
                            'mensaje'   => 'Error al subir el archivo al FTP'
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'respuesta' => false,
                    'error'     => 404,
                    'mensaje'   => 'No se obtuvo resultado, consulta no exitosa'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'respuesta' => false,
                'error'     => 404,
                'mensaje'   => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *ññ
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
