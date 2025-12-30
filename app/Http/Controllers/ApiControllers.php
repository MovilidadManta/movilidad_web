<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Session;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\consultarVehiculo;

class ApiControllers extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        $client = new Client(
            [
                'base_uri' => 'https://api.movilidadmanta.gob.ec:8015/api/v1/',
                'verify' => false, // Desactivar la verificación SSL si es necesario
                'http_errors' => false, // Prevenir que Guzzle lance excepciones en errores HTTP
                'curl' => [
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2, // Forzar el uso de TLS 1.2
                ]
            ]
        );

        $url = 'login';

        // Intentar obtener el token previamente almacenado
        $token = $this->getTokenFromStorage();

        // Verificar si el token es válido o ha expirado (1 minuto)
        if ($token && $this->isTokenValid()) {
            return [
                'status' => 'success',
                'message' => 'Usando el token activo.',
                'token' => $token
            ];
        }

        // Si no tenemos un token válido, obtenemos uno nuevo
        $data = [
            'username' => env('API_USERNAME_MOV'),
            'password' => env('API_PASSWORD_MOV'),
        ];

        try {
            // Realizamos la solicitud POST para obtener el token
            $response = $client->post($url, [
                'form_params' => $data // Los datos a enviar en el cuerpo de la solicitud POST
            ]);

            // Obtener el cuerpo de la respuesta
            $body = $response->getBody();
            $responseData = json_decode($body, true); // Decodificar la respuesta JSON

            // Verificamos si la respuesta contiene un token válido
            if (isset($responseData['data']['token'])) {
                $newToken = $responseData['data']['token'];
                $this->storeToken($newToken); // Almacenamos el nuevo token (ej. en sesión o base de datos)
                return [
                    'status' => 'success',
                    'message' => 'Nuevo token obtenido.',
                    'token' => $newToken
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'No se pudo obtener un token.'
                ];
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // En caso de error, puedes manejarlo de la forma que prefieras
            return [
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    // Esta función es para obtener el token almacenado (puedes implementarlo en base a tus necesidades)
    private function getTokenFromStorage()
    {
        // Aquí deberías agregar la lógica para obtener el token almacenado
        // Por ejemplo, puede ser de la sesión o base de datos
        return Session::has('token') ? Session::get('token') : null;
    }

    // Esta función es para almacenar el token (puedes implementarlo según sea necesario)
    private function storeToken($token)
    {
        // Aquí deberías agregar la lógica para almacenar el token
        // Por ejemplo, en la sesión o en una base de datos
        // $_SESSION['token'] = $token;
        Session::put('token', $token);
        Session::put('token_timestamp', time()); // Almacena el tiempo actual
    }

    // Esta función verifica si el token aún es válido (si no ha pasado más de 1 minuto)
    public function isTokenValid()
    {
        // Verifica si el token tiene una marca de tiempo y si han pasado más de 60 segundos
        if (Session::has('token_timestamp')) {
            $timestamp = Session::get('token_timestamp');
            // Si han pasado más de 60 segundos (1 minuto), el token ha expirado
            if (time() - $timestamp > 60) {
                return false; // El token ha expirado
            }
            return true; // El token es válido
        }
        return false; // No hay timestamp, por lo que el token no es válido
    }

    public function  consultar_vehiculo($placa)
    {
        $token = '';
        $objeto_Api = new ApiControllers();
        $data_token = $objeto_Api->login();

        $client = new Client(
            [
                'base_uri' => 'https://api.movilidadmanta.gob.ec:8015/api/v1/',
                'verify' => false,  // Desactivar verificación SSL si es necesario
                'http_errors' => false,  // Evitar que Guzzle lance excepciones en errores HTTP
                'curl' => [
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,  // Forzar uso de TLS 1.2
                ]
            ]
        );

        $url = 'process';  // La parte final de la URL (base_uri ya está configurado)
        $data = [
            'modulo' => 'ANT',
            'peticion' => 'CONSULTAR-VEHICULOO',
            'data' => [
                'placa' => $placa,  // Asegúrate de tener la variable $placa definida
            ],
        ];

        // Token de autenticación
        $token = $data_token['token'];  // Asegúrate de tener el token disponible

        try {
            // Realizamos la solicitud POST con el Bearer Token en las cabeceras
            $response = $client->post($url, [
                'json' => $data,  // El cuerpo de la solicitud como JSON
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,  // Agregar el Bearer Token
                ],
                'timeout' => 40,  // Establece un tiempo de espera de 10 segundos
            ]);

            // Obtener el cuerpo de la respuesta
            $body = $response->getBody();
            $responseData = json_decode($body, true);  // Decodificar la respuesta JSON

            // Verificamos si la respuesta es exitosa
            if ($response->getStatusCode() == 200) {
                // Guardamos el JSON en una variable de sesión si es necesario
                session()->push('data_vehiculo', $responseData);
                return response()->json($responseData);  // Devolver la respuesta en formato JSON
            }

            // Si la respuesta no es exitosa, obtener detalles adicionales
            return response()->json([
                'error' => 'Hubo un problema con la solicitud',
                'status' => $response->getStatusCode(),  // Código de estado HTTP
                'body' => $response->getBody(),  // Cuerpo de la respuesta (por si el API envía detalles adicionales)
            ], 500);
        } catch (RequestException $e) {
            // Manejo de errores de conexión o fallos en la solicitud
            return response()->json(['error' => 'Error al conectar con el servicio: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Manejo de otros errores generales
            return response()->json(['error' => 'Ocurrió un error inesperado: ' . $e->getMessage()], 500);
        }
    }

    public function  consultar_vehiculo_rtv($placa)
    {
        $token = '';
        $objeto_Api = new ApiControllers();
        $data_token = $objeto_Api->login(); //Descomentar linea
        //$data_token = ["token" => "123"]; //Comentar linea o borrar

        $client = new Client(
            [
                'base_uri' => 'https://api.movilidadmanta.gob.ec:8015/api/v1/',
                'verify' => false,  // Desactivar verificación SSL si es necesario
                'http_errors' => false,  // Evitar que Guzzle lance excepciones en errores HTTP
                'curl' => [
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,  // Forzar uso de TLS 1.2
                ]
            ]
        );

        $url = 'process';  // La parte final de la URL (base_uri ya está configurado)
        $data = [
            'modulo' => 'ANT',
            'peticion' => 'CONSULTAR-VEHICULO',
            'data' => [
                'placa' => $placa,  // Asegúrate de tener la variable $placa definida
            ],
        ];

        // Token de autenticación
        $token = $data_token['token'];  // Asegúrate de tener el token disponible

        try {

            // --- MODO PRUEBA (Descomenta si deseas probar sin invocar el API) ---
            /*
            $body = [
                'data' => [
                    "placaActual" => "IP757H",
                    "chasis" => "LXSPCKLY8J1500978",
                    "tipoServicio" => "PAR",
                    "clase_servicio" => "PAR",
                    "clase_transporte" => "PAR",
                    "anio" => 2018,
                    "activoVig" => "S",
                    "anio_matriculado" => 2023,
                    "primer_apellido" => "FLORES",
                    "segundo_apellido" => "MOREIRA",
                    "avaluo_comercial" => "94,5",
                    "cambio_propietario" => "N",
                    "celular" => "0989866167",
                    "canvcp" => "M00049205",
                    "capacidad" => "2",
                    "carroceria" => "MET",
                    "cilindraje" => "150",
                    "clase_vehiculo" => "G",
                    "color_1" => "NEG",
                    "color_2" => "NEG",
                    "combustible" => "GAS",
                    "contrato" => "102542483",
                    "correo" => "paul_1705@outlook.com",
                    "desdePcir" => "30-07-2024 09:40:42",
                    "direccion" => "BARRIO SAN AGUSTIN",
                    "docPropietario" => "1309901443",
                    "estado" => "A",
                    "estadoCon" => "A",
                    "estadoInf" => "ACT",
                    "estadoPcir" => "I",
                    "estadoSer" => "A",
                    "fechaCaducidad" => "31-08-2028 00:00:00",
                    "fechaIniCon" => "06-02-2018 00:00:00",
                    "fechaMatricula" => "22-05-2023 15:56:53",
                    "hastaPcir" => "11-03-2025 11:22:19",
                    "idAlterno" => "0",
                    "idAlternoMov" => 121356850,
                    "identBenef" => "1309901443",
                    "infraestructura" => 142259666,
                    "inicioVig" => "06-02-2018 10:56:42",
                    "inicioPcir" => "22-05-2023 15:56:53",
                    "institucionRenova" => "01:::AGENCIA NACIONAL DE TRANSITO:::76MAN:::GAD MANTA",
                    "marca" => "674",
                    "marcaDesc" => "RANGER",
                    "modelo" => "64287",
                    "modeloDesc" => "150 USM",
                    "motor" => "FC162FMJ2J5002754",
                    "nombreBenef" => "FLORES MOREIRA JOAQUIN PAUL",
                    "numEjes" => 2,
                    "numRuedas" => 4,
                    "pais" => "25997",
                    "prendaComercial" => "N",
                    "prendaIndustrial" => "N",
                    "prohibidoEnajenar" => "N",
                    "propietario" => "FLORES MOREIRA JOAQUIN PAUL",
                    "registroPcir" => "30-07-2024 09:40:42",
                    "remarcadoChasis" => "N",
                    "remarcadoMotor" => "N",
                    "reservaDominio" => "N",
                    "residencia" => "MAN",
                    "robado" => "N",
                    "rucCooperativa" => "***",
                    "telefono" => "052923097",
                    "tipoIdent" => "CED",
                    "tipoIdentBenef" => "CED",
                    "tipoPeso" => "LIV",
                    "tipoVehiculo" => "292",
                    "tonelaje" => ",25"
                ],
                'status' => 200,
                'message' => 'OK',
                'errors' => [],
            ];

            return response()->json([
                'statusCode' => 200,
                'body' => $body,
            ], 200);
            */
            $body = [
                'data' => [
                    'codigo_error' => 'I00002',
                    'mensaje' => 'Usuario no registrado. Solicite soporte al administrador del sistema',
                ],
                'status'  => 404,
                'message' => 'OK',
                'errors'  => [],
            ];

            return response()->json([
                'statusCode' => 404,
                'body' => $body,
            ], 404);

            // --- LLAMADA REAL ---
            
            // Realizamos la solicitud POST con el Bearer Token en las cabeceras
            /*$response = $client->post($url, [
                'json' => $data,  // El cuerpo de la solicitud como JSON
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,  // Agregar el Bearer Token
                ],
                'timeout' => 40,  // Establece un tiempo de espera de 10 segundos
            ]);

            // Obtener el cuerpo de la respuesta
            $body = json_decode($response->getBody(), true);

            return response()->json([
                'statusCode' => $response->getStatusCode(),
                'body' => $body,
            ], $response->getStatusCode());/*
            

        } catch (RequestException $e) {
            // Manejo de errores de conexión o fallos en la solicitud
            return response()->json(['error' => 'Error al conectar con el servicio: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Manejo de otros errores generales
            return response()->json(['error' => 'Ocurrió un error inesperado: ' . $e->getMessage()], 500);
        }
    }

    public function solicitar_orden($placa, $claseServicio, $numeroRevision, $solicitud, $tipoServicio, $tipoTransporte, $vin)
    {
        $objeto_Api = new ApiControllers();
        $data_token = $objeto_Api->login(); //Descomentar linea
        //$data_token = ["token" => "123"]; //Comentar linea o borrar

        $client = new Client([
            'base_uri' => 'https://api.movilidadmanta.gob.ec:8015/api/v1/',
            'verify' => false,
            'http_errors' => false,
            'curl' => [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            ]
        ]);

        $url = 'process';
        $data = [
            'modulo' => 'ANT',
            'peticion' => 'SOLICITAR-ORDEN',
            'data' => [
                'ambito' => '',
                'claseServicio' => $claseServicio,
                'fechaOrden' => '',
                'institucion' => '76MAN',
                'numeroRevision' => $numeroRevision,
                'placa' => $placa,
                'proceso' => 'TRAMATRTV',
                'solicitud' => $solicitud,
                'tipoOrden' => 'RT1',
                'tipoServicio' => $tipoServicio,
                'tipoTransporte' => $tipoTransporte,
                'vin' => $vin,
            ],
        ];

        $token = $data_token['token'];

        try {
            // --- MODO PRUEBA (Descomenta si deseas probar sin invocar el API) ---
            
            $body = [
                'data' => [
                    'codigo_error' => 'I00002',
                    'mensaje' => 'Usuario no registrado. Solicite soporte al administrador del sistema',
                ],
                'status'  => 404,
                'message' => 'OK',
                'errors'  => [],
            ];

            return response()->json([
                'statusCode' => 404,
                'body' => $body,
            ], 404);
            

            // --- LLAMADA REAL ---
            /*
            $response = $client->post($url, [
                'json' => $data,
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'timeout' => 40,
            ]);

            $body = json_decode($response->getBody(), true);

            return response()->json([
                'statusCode' => $response->getStatusCode(),
                'body' => $body,
            ], $response->getStatusCode());*/
            

        } catch (RequestException $e) {
            return response()->json(['error' => 'Error al conectar con el servicio: ' . $e->getMessage()], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ocurrió un error inesperado: ' . $e->getMessage()], 500);
        }
    }

    public function finalizar_orden($numeroOrden)
    {
        $objeto_Api = new ApiControllers();
        $data_token = $objeto_Api->login(); //Descomentar linea
        //$data_token = ["token" => "123"]; //Comentar linea o borrar

        $client = new Client([
            'base_uri' => 'https://api.movilidadmanta.gob.ec:8015/api/v1/',
            'verify' => false,
            'http_errors' => false,
            'curl' => [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            ]
        ]);

        $url = 'process';
        $data = [
            'modulo' => 'ANT',
            'peticion' => 'FINALIZAR-ORDEN',
            'data' => [
                'aprobado' => 'S',
                'aprobado1' => 'S',
                'aprobado2' => 'S',
                'aprobado3' => 'S',
                'aprobado4' => 'S',
                'fechaFinOt' => '',
                'numeroOrden' => $numeroOrden,
            ],
        ];

        $token = $data_token['token'];

        try {
            // --- MODO PRUEBA (Descomenta para pruebas sin invocar API) ---
            
            $body = [
                'data' => [
                    'codigo_error' => 'I00002',
                    'mensaje' => 'Usuario no registrado. Solicite soporte al administrador del sistema',
                ],
                'status'  => 404,
                'message' => 'OK',
                'errors'  => [],
            ];

            return response()->json([
                'statusCode' => 404,
                'body' => $body,
            ], 404);
            

            // --- LLAMADA REAL ---
            /*
            $response = $client->post($url, [
                'json' => $data,
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'timeout' => 40,
            ]);

            $body = json_decode($response->getBody(), true);

            return response()->json([
                'statusCode' => $response->getStatusCode(),
                'body' => $body,
            ], $response->getStatusCode());*/
            

        } catch (RequestException $e) {
            return response()->json(['error' => 'Error al conectar con el servicio: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error inesperado: ' . $e->getMessage()], 500);
        }
    }

    public function anular_numero_orden($numeroOrden, $idInstitucion, $motivo)
    {
        $objeto_Api = new ApiControllers();
        $data_token = $objeto_Api->login(); //Descomentar linea
        //$data_token = ["token" => "123"]; //Comentar linea o borrar

        $client = new Client([
            'base_uri' => 'https://api.movilidadmanta.gob.ec:8015/api/v1/',
            'verify' => false,
            'http_errors' => false,
            'curl' => [
                CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            ]
        ]);

        $url = 'process';
        $data = [
            'modulo' => 'ANT',
            'peticion' => 'ANULAR-ORDEN',
            'data' => [
                'idOrden' => $numeroOrden,
                'idInstitucion' => $idInstitucion,
                'motivoAnulacion' => $motivo,
                'exito' => 'S'
            ],
        ];

        $token = $data_token['token'];

        try {
            // --- MODO PRUEBA (Descomenta para pruebas sin invocar API) ---
            
            $body = [
                'data' => [
                    'codigo_error' => 'I00002',
                    'mensaje' => 'Usuario no registrado. Solicite soporte al administrador del sistema',
                ],
                'status'  => 404,
                'message' => 'OK',
                'errors'  => [],
            ];

            return response()->json([
                'statusCode' => 404,
                'body' => $body,
            ], 404);
            

            // --- LLAMADA REAL ---
            /*
            $response = $client->post($url, [
                'json' => $data,
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
                'timeout' => 40,
            ]);

            $body = json_decode($response->getBody(), true);

            return response()->json([
                'statusCode' => $response->getStatusCode(),
                'body' => $body,
            ], $response->getStatusCode());*/
            

        } catch (RequestException $e) {
            return response()->json(['error' => 'Error al conectar con el servicio: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error inesperado: ' . $e->getMessage()], 500);
        }
    }


    public function index()
    {
        //
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
