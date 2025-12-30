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
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UsuarioController;

class AcuerdosControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function get_empleados_acuerdos_id($id_empleado)
    {
        $sql = DB::Select('select public.cursor_listar_empleados_id_acuerdos(?)', [$id_empleado]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id_acuerdos;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function ArchivoAcuerdoResponsabilidadConfidencialidad(Request $request)
    {
        $sql = DB::Select('select public.cursor_listar_empleados_id_acuerdos(?)', [$request->input('txt-id-empleado')]);
        return $sql;
        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_id_acuerdos;
        }
        $json_data = json_decode($data);

        $cedula = $json_data[0]->emp_cedula;
        $nombres = $json_data[0]->emp_nombre;
        $apellidos = $json_data[0]->emp_apellido;
        $jefatura = $json_data[0]->emp_id_perfil;

        $nombre = explode(" ", $nombres);
        $apeliido = explode(" ", $apellidos);

        $correo = strtolower($nombre[0] . '.' . $apeliido[0] . '@movilidadmanta.gob.ec');
        //$estado_AR = $json_data[0]->ac_estado_r;
        //$estado_AC = $json_data[0]->ac_estado_c;

        $ip = request()->ip();
        $user = session::get('id_users');
        $archivo = $request->file('txt-archivo-acuerdo-responsabilidad');
        $nombrearchivo = $cedula . ' - ' . $request->input('txt-tipo-acuerdo') . '.' . $archivo->getClientOriginalExtension();
        $nuevaruta = public_path('/archivos_acuerdos/' . $nombrearchivo);
        if (copy($archivo->getRealPath(), $nuevaruta)) {
            $tipo_ = 'AC';
            if ($request->input('txt-tipo-acuerdo') == 'AR') {
                $tipo_ = 'AR';
            }
            $json[] = [
                'id_empleado' => $request->input('txt-id-empleado'),
                'ruta_archivo' => $nombrearchivo,
                'estado_acuerdo' => "F",
                'tipo_acuerdo' => $request->input('txt-tipo-acuerdo'),
                'codigo_archivo' => "MAN-EPMMM-2022-" . $tipo_ . '-' . $request->input('txt-id-empleado'),
                'correo' => $correo,
                'clave' => Hash::make('movilidad2022'),
                'tipo' => $jefatura,
                'estado' => 'A'
            ];
            $jsoninsert = json_encode($json);

            $sql = DB::Select('select public.procedimiento_registrar_acuerdo(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_acuerdo;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
    }

    public function descargar_archivo_ac($file)
    {
        $pathtoFile = public_path() . '/archivos_acuerdos/' . $file;
        return response()->download($pathtoFile);
    }

    public function delete_acuerdoResponsabilidadConfidencialidad(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $id = $request->input('txt-id-empleado-e');
        $tipo = $request->input('txt-tipo-acuerdo-e');

        $ruta_archivo_acuerdo = DB::select(
            "SELECT a.ac_ruta_archivo 
                                            FROM public.tbl_acuerdos a 
                                            WHERE a.ac_id_empleado =  $id
                                            AND a.ac_tipo_acuerdo = '$tipo'"
        );

        //return $ruta_archivo_acuerdo;

        foreach ($ruta_archivo_acuerdo as $a) {
            $ruta_archivo = $a->ac_ruta_archivo;
        }

        $nuevaruta = public_path('/archivos_acuerdos/' . $ruta_archivo);
        if (File::exists($nuevaruta)) {
            unlink($nuevaruta);
        }

        $json[] = [
            'id' => $id,
            'tipo_acuerdo' => $tipo,
            'ruta_acuerdo' => $ruta_archivo_acuerdo
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::Select('select public.procedimiento_eliminar_datos_acuerdos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_acuerdos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
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