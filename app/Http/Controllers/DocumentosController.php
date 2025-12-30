<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use Session;

use Carbon\Carbon;

use Storage;

use File;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Session::get('usuario')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            $sql = DB::Select('select public.cursor_listar_usuarios()');
            foreach ($sql as $r) {
                $data = $r->cursor_listar_usuarios;
            }
            $usuario = json_decode($data);
            $folder_sql = DB::table('ftp.tbl_ftp_carpetas')->where('ca_estado', 1)->get();
            //return $folder_sql;
            $direc = Storage::disk('ftp_movilidad')->Directories("/ftpintranet");
            $files = Storage::disk('ftp_movilidad')->files("/ftpintranet");
            //return $direc;
            $folder_ = array_merge($direc, $files);
            //return $folder_;
            $folder_actual = [];
            foreach ($folder_ as $c) {
                foreach ($folder_sql  as $car) {
                    if ($c == $car->ca_carpetas) {
                        $folder_actual[] = [
                            "id"     => $car->id,
                            "carpeta" => $c,
                        ];
                    }
                }
            }

            //return var_dump($folder_actual);
            $folder = 'documentos';
            //return $usuario;
            return view('Administrador.Documentaciones.index', compact('usuario', 'folder_actual', 'folder', 'menus_'));
        } else {
            return view("Administrador.Login.login");
        }
    }

    public function delete_folder($id)
    {
        $dele = DB::update('update ftp.tbl_ftp_carpetas set ca_estado=0 where id=?', [$id]);
        if ($dele > 0) {
            return response()->json(["res" => true, "sms" => "9999"]);
        } else {
            return response()->json(["res" => false, "sms" => "9998"]);
        }
    }

    public function delete_file(Request $r)
    {
        $dele = DB::update('update ftp.tbl_ftp_archivos set ar_estado=0 where ar_id=?', [$r->idfile]);
     
     //   $dele = Storage::disk('ftp')->delete($r->file);
        if ($dele > 0) {
            return response()->json(["res" => true, "sms" => "9999"]);
        } else {
            return response()->json(["res" => false, "sms" => "9998"]);
        }
    }
    public function save_folder(Request $r)
    {
        $date = Carbon::now();
        $carpeta = Storage::disk('ftp_movilidad')->makeDirectory("/ftpintranet/" . $r->carpeta);
        if ($carpeta) {
            $carpeta = DB::table('ftp.tbl_ftp_carpetas')->insertGetId([
                'ca_carpetas' => $r->carpeta,
                'ca_id_proyectos' => 1,
                'ca_estado' => '1',
                'ca_created_at' => $date
            ]);
            if ($carpeta > 0) {
                $carpeta_archivo = DB::table('ftp.tbl_ftp_archivos')->insertGetId([
                    'ar_id_carpeta' => $carpeta,
                    'ar_ruta' => $r->carpeta,
                    'ar_estado' => '1',
                    'ar_created_at' => $date,
                    'ar_nombre_documento' => $r->carpeta,
                    'ar_tipo' => 0
                ]);
                if ($carpeta_archivo > 0) {
                    return response()->json(["respuesta" => true, "sms" => "Carpeta creada correctamente"]);
                } else {
                    Storage::disk('ftp_movilidad')->delete("/ftpintranet/" . $r->carpeta);
                    return response()->json(["respuesta" => false, "sms" => "Error al crear una carpeta"]);
                }
            } else {
                Storage::disk('ftp_movilidad')->delete("/ftpintranet/" . $r->carpeta);
                return response()->json(["respuesta" => false, "sms" => "Error al crear una carpeta"]);
            }
        } else {
            return response()->json(["respuesta" => false, "sms" => "Error al crear una carpeta"]);

        }
    }

    public function open_folder(Request $r)
    {
        $folder_sql = DB::select("SELECT a.*, c.ca_carpetas FROM ftp.tbl_ftp_archivos a
        INNER JOIN ftp.tbl_ftp_carpetas c ON c.id = a.ar_id_carpeta
        where a.ar_id_carpeta = ? and a.ar_estado=1", [$r->id_folder]);
        return $folder_sql;

        $direc = Storage::disk('ftp_movilidad')->Directories("/ftpintranet/" . $r->folder_name);
        $files = Storage::disk('ftp_movilidad')->files("/ftpintranet/" . $r->folder_name);
        //return $direc;
        $folder_ = array_merge($direc, $files);
        //return $folder_;
        $folder_actual = [];
        foreach ($folder_ as $c) {
            foreach ($folder_sql  as $car) {
                if ($c == $car->ca_carpetas) {
                    $folder_actual[] = [
                        "id"     => $car->id,
                        "carpeta" => $c,
                    ];
                }
            }
        }
        return $folder_actual;
    }

    public function subir_archivo(Request $r)
    {
        $date = Carbon::now();
        //return $r->ruta;
        if (Session::get('usuario')) {
            $ruta = base64_decode($r->ruta);
            //return $ruta;
            $archivo = $r->file('archivo');
            $nombre_original = $archivo->getClientOriginalName();
            //return $nombre_original;
            $fileRemote = "";
            $fileRemote = "/" . $ruta . "/";
            //return $fileRemote.$nombre_original;
            $ftp = Storage::disk('ftp_movilidad')->put("/ftpintranet/" . $fileRemote . $nombre_original, File::get($archivo));
            if ($ftp) {
                $archivo = DB::table('ftp.tbl_ftp_archivos')->insert([
                    'ar_id_carpeta' => $r->id_folder,
                    'ar_ruta' => $nombre_original,
                    'ar_estado' => '1',
                    'ar_created_at' => $date,
                    'ar_nombre_documento' => $r->name,
                    'ar_tipo' => 1
                ]);
                return response()->json(array('registro' => true));
            } else {
                return response()->json(array('registro' => false));
            }
        } else {
            return 0;
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
