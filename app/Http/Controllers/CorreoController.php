<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Session;
use  Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Codedge\Fpdf\Fpdf\Fpdf;
use Mpdf\Mpdf;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Mail;
use Pdf;

class CorreoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Administrador.Correo.enviar_correo');
    }

    public function enviar_correo($id_direccion, $id_jefatura, $id_regimen_contractual, $mensaje)
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
            $ruta_regimen_contractual = 'AND e.emp_id_regimen_contractual = '.$id_regimen_contractual;
        }

        $json_data = DB::select("SELECT 
        e.emp_nombre,				
        e.emp_apellido		
           FROM public.tbl_empleados e, public.tbl_jefaturas_subdirecciones p, public.tbl_direcciones d
           WHERE e.emp_id_perfil = p.per_id
           AND e.emp_id_departamento = d.dep_id
           AND e.emp_id !=1
           AND e.emp_estado ='A'
           $ruta_direccion
           $ruta_jefatura
           $ruta_regimen_contractual
           ORDER by e.emp_id asc");

        $data = json_decode(json_encode($json_data),true);
        for ($i=0; $i < count($data); $i++) { 
            $nombre = explode(" ", $data[$i]['emp_nombre']);
            $apeliido = explode(" ", $data[$i]['emp_apellido']);
            $correo=strtolower($nombre[0].'.'.$apeliido[0].'@movilidadmanta.gob.ec');
            $correo = str_replace("Ñ", "n", $correo);
            $em = Mail::send(
                'Administrador.Correo.view_correo_empleado',
                array(
                    'mensaje' => $mensaje
                    //'country' => $country,
                    //'ip_publica' => $ip_publica,
                    //'host' => $host,
                    //'city' => $city,
                    //'data_cumple' => $data_cumple,
                    //'nombre' => $nombre,
                    //'apellido' => $apellido,
                    //'ruta_foto' => $ruta_foto
                ),
                function ($msj) use ($correo) {
                    $msj->subject('Aviso');
                    $msj->from('yandry.navarrete@movilidadmanta.gob.ec');
                    $msj->to($correo);
                    //$msj->attach("2022Retencion_IR_sueldo.xlsx");
                    //$msj->attach("FormularioSRI_GP_2022.xls");
                    //$msj->to($correos_users_1);
                }
            );
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