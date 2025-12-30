<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use File;
use Illuminate\Http\Request;

class CatalogoController extends Controller
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
        return view('Administrador.Catalogo.catalogo', compact('menus_'));
    }

    public function get_catalogo()
    {
        //$sql = DB::Select('select public.cursor_listar_catalogos()');
        $sql = DB::Select('select public.cursor_listar_catalogos()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_catalogos;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function save_catalogo(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $year = date('Y');

        $mac_ethernet = $request->input('txt-mac-ethernet');

        if ($mac_ethernet == "") {
            $mac_ethernet = 'SIN INFORMACION';
        }

        $mac_wifi = $request->input('txt-mac-wifi');
        if ($mac_wifi == '') {
            $mac_wifi = 'SIN INFORMACION';
        }

        $ip = $request->input('txt-ip');
        if ($ip == '') {
            $ip = 'SIN INFORMACION';
        }

        $anydesk = $request->input('txt-anydesk');
        if ($anydesk == '') {
            $anydesk = 'SIN INFORMACION';
        }

        $ubicacion = $request->input('txt-ubicacion');
        if ($ubicacion == '') {
            $ubicacion = 'SIN INFORMACION';
        }

        $fecha_compra = $request->input('txt-fecha-compra');
        if ($fecha_compra == '') {
            $fecha_compra = '1100-01-01';
        }

        $periodo_garantia = $request->input('txt-periodo-garantia');
        if ($periodo_garantia == '') {
            $periodo_garantia = 'SIN INFORMACION';
        }

        $proveedor = $request->input('txt-proveedor');
        if ($proveedor == '') {
            $proveedor = 'SIN INFORMACION';
        }

        $ram = $request->input('txt-ram');
        if ($ram == '') {
            $ram = 'SIN INFORMACION';
        }

        $so = $request->input('txt-sistema-operativo');
        if ($so == '') {
            $so = 'SIN INFORMACION';
        }

        $tso = $request->input('select-tipo-sistema-operativo');
        if ($tso == '') {
            $tso = 'SIN INFORMACION';
        }

        $usuario_sistema = $request->input('txt-usuario-sistema');
        if ($usuario_sistema == '') {
            $usuario_sistema = 'SIN INFORMACION';
        }

        $observacion = $request->input('txt-observacion');
        if ($observacion == '') {
            $observacion = 'SIN INFORMACION';
        }

        $disco_duro = $request->input('txt-disco-duro');
        if ($disco_duro == '') {
            $disco_duro = 'SIN INFORMACION';
        }

        $programa = $request->input('txt-programa');
        if ($programa == '') {
            $programa = 'SIN INFORMACION';
        }

        $json[] = [
            'codigo' => $request->input('txt-codigo'),
            'categoria' => $request->input('select-categoria'),
            'marca' => $request->input('txt-marca'),
            'modelo' => $request->input('txt-modelo'),
            'descripcion' => $request->input('txt-descripcion'),
            'serie' => $request->input('txt-serie'),
            'mac_ethernet' => $mac_ethernet,
            'mac_wifi' => $mac_wifi,
            'ip' => $ip,
            'anydesk' => $anydesk,
            'id_area' => $request->input('select-area'),
            'ubicacion' => $ubicacion,
            'fecha_compra' => $fecha_compra,
            'periodo_garantia' => $periodo_garantia,
            'proveedor' => $proveedor,
            'estado' => $request->input('select-estado'),
            'ram' => $ram,
            'sistema_operativo' => $so,
            'tipo_sistema_operativo' => $tso,
            'usuario_sistema' => $usuario_sistema,
            'observacion' => $observacion,
            'disco_duro' => $disco_duro,
            'programa' => $programa
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_datos_catalogo(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_catalogo;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }


    public function delete_catalogo_id(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $request->input('txt-id-catalogo')
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_eliminar_datos_catalogos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $data = $s->procedimiento_eliminar_datos_catalogos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $data, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_catalogo_id($id)
    {
        //$sql = DB::Select('select public.cursor_listar_catalogos()');
        $sql = DB::Select('select public.cursor_listar_catalogo_id(?)', [$id]);

        foreach ($sql as $r) {
            $data = $r->cursor_listar_catalogo_id;
        }
        $json_data = json_decode($data);

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function update_catalogo(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $year = date('Y');

        $mac_ethernet = $request->input('txt-mac-ethernet-m');

        if ($mac_ethernet == "") {
            $mac_ethernet = 'SIN INFORMACION';
        }

        $mac_wifi = $request->input('txt-mac-wifi-m');
        if ($mac_wifi == '') {
            $mac_wifi = 'SIN INFORMACION';
        }

        $ip = $request->input('txt-ip-m');
        if ($ip == '') {
            $ip = 'SIN INFORMACION';
        }

        $anydesk = $request->input('txt-anydesk-m');
        if ($anydesk == '') {
            $anydesk = 'SIN INFORMACION';
        }

        $ubicacion = $request->input('txt-ubicacion-m');
        if ($ubicacion == '') {
            $ubicacion = 'SIN INFORMACION';
        }

        $fecha_compra = $request->input('txt-fecha-compra-m');
        if ($fecha_compra == '') {
            $fecha_compra = '1100-01-01';
        }

        $periodo_garantia = $request->input('txt-periodo-garantia-m');
        if ($periodo_garantia == '') {
            $periodo_garantia = 'SIN INFORMACION';
        }

        $proveedor = $request->input('txt-proveedor-m');
        if ($proveedor == '') {
            $proveedor = 'SIN INFORMACION';
        }

        $ram = $request->input('txt-ram-m');
        if ($ram == '') {
            $ram = 'SIN INFORMACION';
        }

        $so = $request->input('txt-sistema-operativo-m');
        if ($so == '') {
            $so = 'SIN INFORMACION';
        }

        $tso = $request->input('select-tipo-sistema-operativo-m');
        if ($tso == '') {
            $tso = 'SIN INFORMACION';
        }

        $usuario_sistema = $request->input('txt-usuario-sistema-m');
        if ($usuario_sistema == '') {
            $usuario_sistema = 'SIN INFORMACION';
        }

        $observacion = $request->input('txt-observacion-m');
        if ($observacion == '') {
            $observacion = 'SIN INFORMACION';
        }

        $disco_duro = $request->input('txt-disco-duro-m');
        if ($disco_duro == '') {
            $disco_duro = 'SIN INFORMACION';
        }

        $programa = $request->input('txt-programa-m');
        if ($programa == '') {
            $programa = 'SIN INFORMACION';
        }

        $json[] = [
            'id' => $request->input('txt-id-catalogo-m'),
            'codigo' => $request->input('txt-codigo-m'),
            'categoria' => $request->input('select-categoria-m'),
            'marca' => $request->input('txt-marca-m'),
            'modelo' => $request->input('txt-modelo-m'),
            'descripcion' => $request->input('txt-descripcion-m'),
            'serie' => $request->input('txt-serie-m'),
            'mac_ethernet' => $mac_ethernet,
            'mac_wifi' => $mac_wifi,
            'ip' => $ip,
            'anydesk' => $anydesk,
            'id_area' => $request->input('select-area-m'),
            'ubicacion' => $ubicacion,
            'fecha_compra' => $fecha_compra,
            'periodo_garantia' => $periodo_garantia,
            'proveedor' => $proveedor,
            'estado' => $request->input('select-estado-m'),
            'ram' => $ram,
            'sistema_operativo' => $so,
            'tipo_sistema_operativo' => $tso,
            'usuario_sistema' => $usuario_sistema,
            'observacion' => $observacion,
            'disco_duro' => $disco_duro,
            'programa' => $programa
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_modificar_datos_catalogo(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_datos_catalogo;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
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