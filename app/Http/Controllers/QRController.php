<?php

namespace App\Http\Controllers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Http;
use Session;
use DB;
use Carbon;


class QRController extends Controller
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
        return view('Administrador.Credencial.credencial', compact('menus_'));
    }

    public function get_empleado_qr($id_empleado)
    {
        $hashids = new \Hashids\Hashids('app-100', 8);
        $id_ = substr(implode(" ", $hashids->decode($id_empleado)), 4);

        $sql = DB::Select('select public.cursor_listar_empleados_qr_id(?)', [$id_empleado]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_qr_id;
        }
        $json_data = json_decode($data);

        foreach ($json_data as $value) {
            $id = $value->emp_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_empleado_hash = $id_;
        }
        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_qr_empleado()
    {
        $response = Http::get('http://movilidadmanta.gob.ec/api/get-verficar-empleado-id-p/43');
        $data = $response->json();
        foreach ($data as $value) {
            $codigo_encriptado = $value['id_empleado_hash'];
            $emp_cedula = $value['emp_cedula'];
        }
        //return $codigo_encriptado;
        QrCode::format('png')->generate('http://movilidadmanta.gob.ec/api/get-verficar-empleado-id/' . $codigo_encriptado, 'C:/xampp/htdocs/movilidad-web/app-web/public/Imagenes/QR/' . $emp_cedula . '.png');
    }

    public function get_descargar_qr_empleado($file)
    {
        $pathtoFile = public_path() . '/Imagenes/QR/' . $file;
        return response()->download($pathtoFile);
    }


    public function save_qr_empleado(Request $request)
    {
        $hashids = new \Hashids\Hashids('app-100', 8);
        $id_ = substr(implode(" ", $hashids->decode($request->id)), 4);

        $sql = DB::Select('select public.cursor_listar_empleados_qr_id(?)', [$request->id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados_qr_id;
        }
        $json_data = json_decode($data);
        foreach ($json_data as $value) {
            $nombres = $value->emp_nombre . ' ' . $value->emp_apellido;
            $jefatura = $value->dep_departamento;
        }

        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id_encriptado' => $request->id_encrip,
            'id' => $request->id,
            'cedula' => $request->cedula . '.png'
        ];
        $jsoninsert = json_encode($json);

        $sql = DB::Select('select public.procedimiento_registrar_datos_credencial_qr_empleado(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_credencial_qr_empleado;
        }
        if ($sql != "[]") {
            QrCode::format('png')->generate('http://movilidadmanta.gob.ec/api/get-verficar-empleado-id/' . $request->id_encrip, public_path() . '/Imagenes/QR/' . $request->cedula . '.png');
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function descargar_foto_empleado($ruta)
    {
        $pathtoFile = public_path() . '/imagenes_empleados/' . $ruta;
        return response()->download($pathtoFile);
    }

    public function descargar_QR_empleado($ruta)
    {
        $pathtoFile = public_path() . '/Imagenes/QR/' . $ruta;
        return response()->download($pathtoFile);
    }

    public function save_qr_empleado_masivo(Request $request)
    {
        $sql = DB::Select('select public.cursor_listar_empleados()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_empleados;
        }
        $json_data = json_decode($data);

        foreach ($json_data as $value) {
            $id = $value->emp_id;
            $hashids = new \Hashids\Hashids('app-100', 8);
            $id_ = $hashids->encode('1110' . $id);
            $value->id_empleado_hash = $id_;
            $insert_ = DB::connection('pgsql')->table('tbl_credenciales')->insert(
                [
                    'cre_id_empleado' => $id,
                    'cre_estado' => 'I',
                    'cre_fecha_update' => now(),
                    'cre_fecha' => now(),
                    'cre_nombre_qr' => $value->emp_cedula . '.png'
                ]
            );
            //QrCode::format('png')->generate(view('Administrador.Empleado.empleado_credencial',compact('json_data')),'C:/xampp/htdocs/movilidad-web/app-web/public/Imagenes/QR/'.$value->emp_cedula.'.png');
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