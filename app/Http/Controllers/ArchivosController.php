<?php

namespace App\Http\Controllers;

use Session;
use DB;
use File;
use DateTime;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Storage;
use Carbon\Carbon;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use App\Helpers\GuidHelper;
use App\Helpers\ExcelHelper;
use App\Jobs\UploadDocumentoJob;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel_Cell_DataType;


class ArchivosController extends Controller
{
    public function bodegaIndex()
    {
        if (Session::get('id_users')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            return view('Administrador.Archivo.Bodega.index', compact('menus_'));
        } else {
            return Redirect::to('/login');
        }
    }

    public function bodegaData()
    {
        $sql = DB::Select('SELECT * FROM archivo.view_tbl_archivos');
        $json_data = $sql;
        return response()->json($json_data);
    }

    public function get_empresas_active_all()
    {
        $sql = DB::Select("SELECT * FROM archivo.view_tbl_empresas WHERE estado = TRUE ORDER BY empresa");
        $json_data = $sql;
        return response()->json($json_data);
    }

    public function bodegaStore(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'archivo' => strtoupper($request->archivo),
            'ubicacion' => strtoupper($request->ubicacion),
            'id_empresa' => $request->id_empresa,
            'estado' => $request->estado
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_registrar_tbl_archivos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_archivos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function bodegaUpdate(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->id,
            'archivo' => strtoupper($request->archivo),
            'ubicacion' => strtoupper($request->ubicacion),
            'id_empresa' => $request->id_empresa,
            'estado' => $request->estado
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_modificar_tbl_archivos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_archivos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function bodegaDelete($id)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $id
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_eliminar_tbl_archivos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_archivos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function TipoCIndex()
    {
        if (Session::get('id_users')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            return view('Administrador.Archivo.TiposContenedores.index', compact('menus_'));
        } else {
            return Redirect::to('/login');
        }
    }

    public function TipoCData()
    {
        $sql = DB::Select('SELECT * FROM archivo.view_tbl_tipo_almacenamientos');
        $json_data = $sql;
        return response()->json($json_data);
    }

    public function TipoCGetNumeracion()
    {
        $sql = DB::Select('SELECT COALESCE(MAX(numeracion) + 1,1) as numeracion from archivo.view_tbl_tipo_almacenamientos');
        $json_data = $sql[0];
        return response()->json($json_data);
    }

    public function TipoCStore(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'tipo' => strtoupper($request->tipo),
            'letra' => strtoupper($request->letra),
            'numeracion' => $request->numeracion,
            'estado' => $request->estado
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_registrar_tbl_tipo_almacenamientos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_tipo_almacenamientos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function TipoCUpdate(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->id,
            'tipo' => strtoupper($request->tipo),
            'letra' => strtoupper($request->letra),
            'numeracion' => $request->numeracion,
            'estado' => $request->estado
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_modificar_tbl_tipo_almacenamientos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_tipo_almacenamientos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function TipoCDelete($id)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $id
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_eliminar_tbl_tipo_almacenamientos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_tipo_almacenamientos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }


    public function ContenedorIndex()
    {
        if (Session::get('id_users')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            $bodegas = DB::Select('select * from archivo.tbl_archivos where estado=?', ['1']);
            $tipos = DB::Select('select * from archivo.tbl_tipo_almacenamientos');
            $departamento = DB::select('select * from public.tbl_jefaturas_subdirecciones');
            $tipos_procesos = DB::select('Select * from archivo.tbl_tipo_procesos');
            return view('Administrador.Archivo.Contenedores.index', compact('menus_', 'bodegas', 'tipos', 'departamento', 'tipos_procesos'));
        } else {
            return Redirect::to('/login');
        }
    }

    public function get_numeracion($id, $id_bodega)
    {
        $tipos = DB::Select('select an.numeracion, ta.letra from archivo.tbl_archivos_numeraciones an
        INNER JOIN archivo.tbl_tipo_almacenamientos ta ON ta.id=an.id_tipo_alm
        where an.id_archivo=? and an.id_tipo_alm=?', [$id_bodega, $id]);
        //$tipos = DB::Select('select * from archivo.tbl_tipo_almacenamientos where id=?', [$id]);
        return $tipos;
    }

    public function get_contenedor($id)
    {
        $contenedor = DB::Select('select * from archivo.tbl_contenedores where id_archivo=?', [$id]);
        return $contenedor;
    }

    public function store_contenedor(Request $r)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $carpeta = Storage::disk('ftp')->makeDirectory($r->ruta . '/' . $r->numeracion);
        //return $carpeta;
        if ($carpeta) {
            $json[] = [
                'ip_bodega' => $r->id_bodega,
                'id_tipo_contenedor' => $r->id_tipo_contenedor,
                'desde' => $r->desde,
                'hasta' => $r->hasta,
                'numeracion' => $r->numeracion,
                'contenido' => $r->contenido,
                'departamento' => $r->departamento,
                'anio' => $r->anio
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::Select('select archivo.procedimiento_registrar_datos_contenedores(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_datos_contenedores;
            }
            if ($sql != "[]") {

                $json_[] = [
                    'id_contenedor' => $r->id_tipo_contenedor,
                    'id_bodega' => $r->id_bodega,
                    'numeracion' => $r->num + 1
                ];
                $jsoninsert = json_encode($json_);
                $sql = DB::Select('select archivo.procedimiento_modificar_numeracion_contendor(?,?,?)', [$jsoninsert, $ip, $user]);
                /*foreach ($sql as $s) {
                    $id = $s->procedimiento_modificar_numeracion_contendor;
                }*/
                if ($sql != "[]") {
                    //  return response()->json(['respuesta' => true, "data" => $id, "sql" => $sql]);
                    return response()->json(['respuesta' => true, "data" => $id, "ruta" => $r->ruta . '/' . $r->numeracion]);
                } else {
                    return response()->json(["respuesta" => false]);
                }
            } else {
                return response()->json(["respuesta" => false]);
            }
        }
    }

    public function store_folder(Request $r)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id_contenedor' => $r->id_contenedor,
            'desde' => $r->desde,
            'hasta' => $r->hasta,
            'descripcion' => $r->contenido,
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_registrar_datos_folders(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_datos_folders;
        }
        if ($sql != "[]") {
            $carpeta = Storage::disk('ftp')->makeDirectory($r->rr . '/' . $id . '_' . $r->contenido);
            //return $carpeta;
            if ($carpeta) {
                return response()->json(['respuesta' => true, "data" => $id]);
            } else {
                return response()->json(["respuesta" => false, "res" => "error al crear la carpeta"]);
            }
        } else {
            $dele = Storage::disk('ftp')->delete($r->ruta . '/' . $r->contenido);
            return response()->json(["respuesta" => false, "res" => "error al guardar la carpeta " . $dele]);
        }
    }

    public function open_contenedor(Request $r)
    {

        $direc = Storage::disk('ftp')->Directories($r->numeracion);
        $files = Storage::disk('ftp')->files($r->numeracion);
        $folder_ = array_merge($direc, $files);

        $folder = DB::select('select * from archivo.tbl_folders where id_contenedor = ? and estado=1', [$r->id]);
        //$contenedor = DB::select("select * from archivo.tbl_contenedores where id = ? ", [$r->id]);
        $contenedor = DB::select('select c.id,t.tipo, c.id_archivo, c.numeracion, c.desde, c.hasta, c.contenido, c.año, d.per_perfil from archivo.tbl_contenedores c 
        INNER JOIN public.tbl_jefaturas_subdirecciones d ON d.per_id=CAST(c.departamento AS INTEGER)
        INNER JOIN archivo.tbl_tipo_almacenamientos t ON t.id=c.id_tipo_almacenamiento
        where c.id = ?', [$r->id]);
        //return $folder;
        $carpetas = [];
        foreach ($folder as $f) {
            foreach ($folder_ as $ff) {
                //return $ff;
                if ($r->numeracion . '/' . $f->descripcion == $ff) {
                    $carpetas[] = [
                        "id"    => $f->id,
                        "carpeta"   => $f->descripcion
                    ];
                }
            }
        }
        return json_encode(["carpetas" => $carpetas, "contenedor" => $contenedor]);
    }

    public function open_carpeta(Request $r)
    {
        $direc = Storage::disk('ftp')->Directories($r->carpeta);
        $files = Storage::disk('ftp')->files($r->carpeta);
        $folder_ = array_merge($direc, $files);
        // return $folder_;
        $archivos = DB::select(
        "SELECT p.id, p.id_departamento, p.detalle_asunto, p.url_ftp_file, concat(e.emp_apellido,' ',e.emp_nombre) as usuario, p.user_created, p.id_tipo_proceso, tp.tipo, p.numero_identificacion, p.numero_orden,p.fecha_emision_doc, fp.estado
        FROM archivo.tbl_folders_procesos fp 
        INNER JOIN archivo.tbl_procesos p ON p.id = fp.id_proceso
        INNER JOIN public.tbl_usuarios u ON  u.usu_id =CAST (p.user_created AS INTEGER )
        INNER JOIN public.tbl_empleados e ON e.emp_id = u.usu_id_empleado
        INNER JOIN archivo.tbl_tipo_procesos tp ON tp.id = p.id_tipo_proceso
        WHERE fp.id_folder = ? and fp.estado=1", [$r->id_carpeta]);
        //return $archivos;
        $carpetas = [];
        foreach ($archivos as $f) {
            foreach ($folder_ as $ff) {
                if ($f->url_ftp_file == "/" . $ff) {

                    $carpetas[] = [
                        "id"    => $f->id,
                        "archivo"   => $f->url_ftp_file,
                        "asunto" => $f->detalle_asunto,
                        "usuario" => $f->usuario,
                        "tipo" => $f->tipo,
                        "numero_identificacion" => $f->numero_identificacion,
                        "numero_oreden" => $f->numero_orden,
                        "fecha_emision" => $f->fecha_emision_doc
                    ];
                }
            }
        }
        return $carpetas;
    }

    public function subir_proceso(Request $r)
    {
        //return $r->ruta;
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');
        if (Session::get('usuario')) {
            $ruta = base64_decode($r->ruta);
            //return $ruta;
            $archivo = $r->file('archivo');
            $nombre_original = $date . '_' . $archivo->getClientOriginalName();
            //return $nombre_original;
            $fileRemote = "";
            $fileRemote = "/" . $ruta . "/";
            //return $fileRemote.$nombre_original;
            $ftp = Storage::disk('ftp')->put($fileRemote . $nombre_original, File::get($archivo));
            if ($ftp) {
                $json[] = [
                    'asunto' => $r->asunto,
                    'departamento' => $r->departamento,
                    'tipo_proceso' => $r->tipo_proceso,
                    'id_folder' => $r->id_folder,
                    'num_identificacion' => $r->num_identificacion,
                    'num_orden' => $r->num_orden,
                    'fecha_emision' => $r->fecha_emision,
                    'url_ftp' => $fileRemote . $nombre_original,
                    'id_folder' => $r->id_folder
                ];
                $jsoninsert = json_encode($json);
                $sql = DB::Select('select archivo.procedimiento_registrar_datos_proceso(?,?,?)', [$jsoninsert, $ip, $user]);
                foreach ($sql as $s) {
                    $id = $s->procedimiento_registrar_datos_proceso;
                }
                if ($sql != "[]") {
                }
                return response()->json(array('registro' => true, 'res' => $id));
            } else {
                return response()->json(array('registro' => false));
            }
        } else {
            return 0;
        }
    }

    public function del_folder($id_folder, $v)
    {
        if ($v == 'f') { // SIN PERMISO PARA ELIMINAR

            $folder_con_files = DB::select('SELECT * FROM archivo.tbl_folders_procesos where id_folder =? and estado=1', [$id_folder]);
            if ($folder_con_files == []) {
                //NO EXISTE ARCHIVOS EN LA CARPETA ENTONCES SE PROCEDE A ELIMINAR(CAMBIO DE ESTADO EN LA TABLA tbl_folders);
                return $folder_con_files;
            } else {
                return response()->json(array('WS_RES' => false, "WS_MSM" => 'La carpeta que trata de eliminar continen informacion', 'WS_CODE' => '500', 'WS_data' => $id_folder));;
            }
        } else { // CON PERMISO PARA ELIMINAR CARPETAS
            return response()->json(array('WS_RES' => true, "WS_MSM" => 'La carpeta se eliminio para recuperarla acerquese a TICS de moviliad', 'WS_CODE' => '200', 'WS_data' => $id_folder));;
            return $v;
        }
    }

    public function del_file($id_file, $id_folder)
    {
        $del_f =  DB::update("update archivo.tbl_folders_procesos set estado = 0 where id_folder = ? and id_proceso = ?", [$id_folder, $id_file]);
        //return $del_f;
        if ($del_f != 1) {
            return response()->json(array('WS_RES' => false, "WS_MSM" => 'No se elimino el archivo', 'WS_CODE' => '500', 'WS_data' => $id_file));;
        } else {
            return response()->json(array('WS_RES' => true, "WS_MSM" => 'Se elimino el archivo de su carpeta', 'WS_CODE' => '200', 'WS_data' => $id_file));;
            //  return $del_f;
        }
    }

    public function descargar_archivo($ruta)
    {
        $ruta = base64_decode($ruta);
        $ruta = trim($ruta, '"');
        return Storage::disk('ftp')->download($ruta);
    }

    public function get_info_f($id)
    {
        $proceso = DB::select("SELECT p.id, p.id_departamento, p.detalle_asunto, p.url_ftp_file, concat(e.emp_apellido,' ',e.emp_nombre) as usuario, p.user_created, p.id_tipo_proceso, tp.tipo, p.numero_identificacion, p.numero_orden,p.fecha_emision_doc, fp.estado,p.created_at
        FROM archivo.tbl_folders_procesos fp 
        INNER JOIN archivo.tbl_procesos p ON p.id = fp.id_proceso
        INNER JOIN public.tbl_usuarios u ON  u.usu_id =CAST (p.user_created AS INTEGER )
        INNER JOIN public.tbl_empleados e ON e.emp_id = u.usu_id_empleado
        INNER JOIN archivo.tbl_tipo_procesos tp ON tp.id = p.id_tipo_proceso
        WHERE p.id= ?", [$id]);
        return $proceso;
    }

    public function procesos()
    {
        if (Session::get('id_users')) {
            $cl = new HomeController();
            $menus_ = $cl->GET_menus_asign();
            return view('Administrador.Archivo.Search.index', compact('menus_'));
        } else {
            return Redirect::to('/login');
        }
    }

    public function search_proceso($data)
    {
        if (Session::get('id_users')) {

            /*$procesos = DB::select("select * from archivo.tbl_procesos where detalle_asunto ilike '%$data%' OR url_ftp_file ilike '%$data%' or numero_identificacion ilike '%$data%' or numero_orden ilike '%$data%'
            union
            select * from archivo.tbl_procesos where id_departamento =(select MAX (per_id) from public.tbl_jefaturas_subdirecciones where per_perfil Ilike '%$data%')
            union 
            SELECT * from archivo.tbl_procesos where id_tipo_proceso = (SELECT max(id) from archivo.tbl_tipo_procesos where tipo ilike '%$data%')");*/

            $procesos = DB::select("
            select 
            p.id,
            js.per_perfil,
            p.id_departamento,
            p.detalle_asunto,
            p.url_ftp_file,
            concat(e.emp_apellido,' ',e.emp_nombre) as usuario,
             p.user_created, 
             tp.tipo ,
             p.id_tipo_proceso, 
             p.numero_identificacion,
            p.numero_orden,
            p.fecha_emision_doc,
            p.created_at,
            f.id_contenedor,
            f.desde,
            f.hasta,
            f.descripcion,
            ta.tipo as tipo_almacen,
            c.numeracion,
            c.desde as desde_contenedor,
            c.hasta as hasta_contenedor,
            c.contenido,
            c.año,
            a.archivo,
            a.ubicacion
            from archivo.tbl_procesos p
            INNER JOIN archivo.tbl_folders_procesos fp ON fp.id_proceso = p.id
            INNER JOIN public.tbl_jefaturas_subdirecciones js ON p.id_departamento = js.per_id
            INNER JOIN public.tbl_usuarios u ON  u.usu_id =CAST (p.user_created AS INTEGER )
            INNER JOIN public.tbl_empleados e ON e.emp_id = u.usu_id_empleado
            INNER JOIN archivo.tbl_tipo_procesos tp ON tp.id = p.id_tipo_proceso
            INNER JOIN archivo.tbl_folders f ON fp.id_folder = f.id
            INNER JOIN archivo.tbl_contenedores c ON f.id_contenedor = c.id
            INNER JOIN archivo.tbl_tipo_almacenamientos ta ON ta.id = c.id_tipo_almacenamiento
            INNER JOIN archivo.tbl_archivos a ON c.id_archivo = a.id
            where fp.estado=1
            and detalle_asunto ilike '%$data%' 
            OR url_ftp_file ilike '%$data%' 
            or numero_identificacion ilike '%$data%' 
            or numero_orden ilike '%$data%' 
            or per_perfil ilike '%$data%' 
            or tp.tipo ilike '%$data%' 
            or descripcion ilike '%$data%' 
            OR contenido ilike '%$data%'
            ");

            //return $procesos;
            /* $procesos = DB::select("select archivo.cursor_listar_procesos(?)", [$data]);

            foreach ($procesos as $s) {
                $pro = $s->cursor_listar_procesos;
            }*/
            //return $pro;
            if ($procesos != '[]') {
                return response()->json(array('WS_RES' => true, "WS_MSM" => 'OK', 'WS_CODE' => '200', 'WS_data' => $procesos));;
            } else {
                return response()->json(array('WS_RES' => true, "WS_MSM" => 'Sin resultados', 'WS_CODE' => '500'));;
            }
        } else {
            return response()->json(array('WS_RES' => false, "WS_MSM" => 'sesion caducada', 'WS_CODE' => '403'));;
        }
    }

    public function indexConfiguracionUnidadAlmacenamiento()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Archivo.ConfiguracionUnidadAlmacenamiento.index', compact('menus_'));
    }

    public function get_configuracion_unidad_almacenamiento()
    {
        $configuracion_medios_almacenamiento = DB::Select('SELECT * FROM archivo.view_tbl_configuracion_medios_almacenamiento');
        return $configuracion_medios_almacenamiento;
    }

    public function storeConfiguracionUnidadAlmacenamiento(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'tipo' => strtoupper($request->input('txt_tipo')),
            'codigo' => strtoupper($request->input('txt_codigo')),
            'capacidad' => strtoupper($request->input('txt_capacidad')),
            'caracteristicas' => strtoupper($request->input('txt_caracteristicas')),
            'estado' => $request->input('estado'),
            'upload_archive' => $request->input('upload_archive'),
            'list_unidades' => $request->input('list_unidades'),
            'icono' => $request->input('icono')
        ];


        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_registrar_tbl_configuracion_medios_almacenamiento(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_configuracion_medios_almacenamiento;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function updateConfiguracionUnidadAlmacenamiento(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('id'),
            'tipo' => strtoupper($request->input('txt_tipo')),
            'codigo' => strtoupper($request->input('txt_codigo')),
            'capacidad' => strtoupper($request->input('txt_capacidad')),
            'caracteristicas' => strtoupper($request->input('txt_caracteristicas')),
            'estado' => $request->input('estado'),
            'upload_archive' => $request->input('upload_archive'),
            'list_unidades' => $request->input('list_unidades'),
            'icono' => $request->input('icono')
        ];


        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_modificar_tbl_configuracion_medios_almacenamiento(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_configuracion_medios_almacenamiento;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function destroyConfiguracionUnidadAlmacenamiento($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $id
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_eliminar_tbl_configuracion_medios_almacenamiento(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_configuracion_medios_almacenamiento;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function indexConfiguracionDocumentos()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Archivo.ConfiguracionDocumentos.index', compact('menus_'));
    }

    public function get_configuracion_documentos()
    {
        $configuracion_documentos = DB::Select('SELECT * FROM archivo.view_tbl_configuracion_documentos');
        return $configuracion_documentos;
    }

    public function get_search_documentos_active($coincidenciaTotal,$limit, $text = '')
    {
        $text = str_replace("'", "\'", $text);
        if($coincidenciaTotal == 1){
            $coincidenciaTotal = '%';
        }else{
            $coincidenciaTotal = '';
        }

        $sql = DB::Select("select * from archivo.view_tbl_configuracion_documentos WHERE cd_estado = true AND (upper(cd_nombre) like E'" . trim($coincidenciaTotal) . strtoupper($text) ."%' OR upper(cd_codigo) like E'%" . strtoupper($text) ."%')  ORDER BY cd_nombre " . ($limit == -1 ? "" : "LIMIT $limit"));   

        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function storeConfiguracionDocumento(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'nombre' => strtoupper($request->input('txt_nombre')),
            'codigo' => strtoupper($request->input('txt_codigo')),
            'descripcion' => strtoupper($request->input('txt_descripcion')),
            'estado' => $request->input('estado'),
            'campos' => $request->input('campos')
        ];


        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_registrar_tbl_configuracion_documentos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_configuracion_documentos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function updateConfiguracionDocumento(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('id'),
            'nombre' => strtoupper($request->input('txt_nombre')),
            'codigo' => strtoupper($request->input('txt_codigo')),
            'descripcion' => strtoupper($request->input('txt_descripcion')),
            'estado' => $request->input('estado'),
            'campos' => $request->input('campos')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_modificar_tbl_configuracion_documentos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_configuracion_documentos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function destroyConfiguracionDocumento($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $id
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_eliminar_tbl_configuracion_documentos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_configuracion_documentos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function indexConfiguracionUnidadProductora()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Archivo.ConfiguracionUnidadProductora.index', compact('menus_'));
    }

    public function get_configuracion_unidad_productora()
    {
        return $this->get_configuracion_unidad_productora_sql();
    }

    public function get_configuracion_unidad_productora_sql($where = "")
    {
        $configuracion_unidad_productora = DB::Select("SELECT * FROM archivo.view_tbl_configuracion_unidad_productora {$where}");
        return $configuracion_unidad_productora;
    }

    public function get_configuracion_series_documentos($id)
    {
        return $this->get_configuracion_series_documentos_sql($id);
    }

    public function get_configuracion_series_documentos_sql($id, $column = "cup_id")
    {
        $configuracion_series_documentos_serie = DB::Select("SELECT * FROM archivo.view_tbl_configuracion_unidad_productora_serie_documento WHERE {$column} = {$id} ORDER BY cupsd_id ASC");
        return $configuracion_series_documentos_serie;
    }

    public function storeConfiguracionUnidadProductora(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'nombre' => strtoupper($request->input('txt_nombre')),
            'codigo' => strtoupper($request->input('txt_codigo')),
            'descripcion' => strtoupper($request->input('txt_descripcion')),
            'estado' => $request->input('estado'),
            'series' => $request->input('series')
        ];


        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_registrar_tbl_configuracion_unidad_productora(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_configuracion_unidad_productora;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function updateConfiguracionUnidadProductora(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $request->input('id'),
            'nombre' => strtoupper($request->input('txt_nombre')),
            'codigo' => strtoupper($request->input('txt_codigo')),
            'descripcion' => strtoupper($request->input('txt_descripcion')),
            'estado' => $request->input('estado'),
            'series' => $request->input('series')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_modificar_tbl_configuracion_unidad_productora(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_configuracion_unidad_productora;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function destroyConfiguracionUnidadProductra($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $id
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_eliminar_tbl_configuracion_unidad_productora(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_configuracion_unidad_productora;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function storeConfiguracionUnidadProductoraSerieDocumento(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'cups_id' => $request->input('cups_id'),
            'cup_id' => $request->input('cup_id'),
            'cd_id' => $request->input('cd_id')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.proc_reg_tbl_conf_u_prod_serie_doc(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->proc_reg_tbl_conf_u_prod_serie_doc;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function destroyConfiguracionUnidadProductraSerieDocumento($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $json[] = [
            'id' => $id
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.proc_eli_tbl_conf_u_prod_serie_doc(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->proc_eli_tbl_conf_u_prod_serie_doc;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function indexListaBodegas($prefix = "/lista-bodegas/")
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        $bodegas = DB::Select('SELECT * FROM archivo.view_tbl_archivos WHERE estado=?', ['1']);
        return view('Administrador.Archivo.ListaBodegas.index', compact('menus_', 'bodegas', 'prefix'));
    }

    public function indexBodegasId($id, $ma_id = 0)
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        $bodega = DB::Select('SELECT * FROM archivo.view_tbl_archivos where id=?', [$id]);
        $variable = DB::Select("SELECT cf_valor FROM archivo.tbl_variables_configuraciones WHERE cf_codigo = 'ACRONIMO_INSTITUCION' LIMIT 1");
        $variable_dep = DB::Select("SELECT cf_valor FROM archivo.tbl_variables_configuraciones WHERE cf_codigo = 'ACRONIMO_DEPARTAMENTO' LIMIT 1");
        $bodega = $bodega[0];
        $variable = $variable[0];
        $variable_dep = $variable_dep[0];
        return view('Administrador.Archivo.ListaBodegas.bodega', compact('menus_', 'bodega', 'variable', 'variable_dep', 'ma_id'));
    }

    public function get_configuracion_medios_almacenamiento_all()
    {
        $configuracion_medios_almacenamiento = DB::Select("SELECT * FROM archivo.view_tbl_configuracion_medios_almacenamiento_products WHERE cma_estado = TRUE ORDER BY cma_id_hijo, cma_id");
        return $configuracion_medios_almacenamiento;
    }

    public function get_configuracion_unidad_productora_active($id)
    {
        $where = "WHERE cup_estado = TRUE";
        if($id != 0)
            $where .= " AND cup_id = {$id}";
        return $this->get_configuracion_unidad_productora_sql($where);
    }

    public function get_configuracion_unidad_productora_serie_active($id)
    {
        $configuracion_medios_almacenamiento = DB::Select("select * from archivo.view_tbl_configuracion_medios_almacenamiento_products where cma_estado = TRUE ORDER BY cma_id_hijo, cma_id");
        return $configuracion_medios_almacenamiento;
    }

    public function get_configuracion_series_documentos_cupsd($id)
    {
        return $this->get_configuracion_series_documentos_sql($id, "cups_id");
    }

    public function get_secuencial_unidad_productora(Request $request)
    {
        $secuencialMaximo = DB::Select("SELECT COALESCE(MAX(ma_secuencial), 0) AS secuencial FROM archivo.tbl_medios_almacenamiento WHERE cma_id = {$request->input('cma_id')} AND ma_estado = TRUE");
        return $secuencialMaximo[0];
    }

    public function storeUnidadAlmacenamiento(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');
        $fecha_desde = $request->input('ma_estado_fecha') ? DateTime::createFromFormat('Y-m-d', $request->input('ma_fecha_desde')) : new DateTime();
        $fecha_hasta = $request->input('ma_estado_fecha') ? DateTime::createFromFormat('Y-m-d', $request->input('ma_fecha_hasta')) : new DateTime();
        $nombreimagen = "";

        if ($request->hasFile('file_imagen')) {
            $imagen = $request->file('file_imagen');
            $guid = GuidHelper::GUIDv4();
            $nombreimagen = $guid . '-' . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $ruta_imagen = public_path('/imagenes_archivo/' . $nombreimagen);
            copy($imagen->getRealPath(), $ruta_imagen);
            $nombreimagen = "/imagenes_archivo/{$nombreimagen}";
        }

        $json[] = [
            'cma_id' => $request->input('cma_id'),
            'ma_id_padre' => $request->input('ma_id_padre'),
            'cup_id' => $request->input('cup_id'),
            'cups_id' => $request->input('cups_id'),
            'cd_id' => $request->input('cd_id'),
            'id_bodega' => $request->input('id_bodega'),
            'codigo' => strtoupper($request->input('ma_codigo')),
            'descripcion' => strtoupper($request->input('ma_descripcion')),
            'ruta_imagen' => $nombreimagen,
            'estado_fecha' => $request->input('ma_estado_fecha'),
            'fecha_desde' => $fecha_desde->format("Y/m/d"),
            'fecha_hasta' => $fecha_hasta->format("Y/m/d"),
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_registrar_tbl_medios_almacenamiento(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_medios_almacenamiento;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function updateUnidadAlmacenamiento(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');
        $fecha_desde = $request->input('ma_estado_fecha') ? DateTime::createFromFormat('Y-m-d', $request->input('ma_fecha_desde')) : new DateTime();
        $fecha_hasta = $request->input('ma_estado_fecha') ? DateTime::createFromFormat('Y-m-d', $request->input('ma_fecha_hasta')) : new DateTime();
        $nombreimagen = "";

        if ($request->hasFile('file_imagen')) {
            $imagen = $request->file('file_imagen');
            $guid = GuidHelper::GUIDv4();
            $nombreimagen = $guid . '-' . date("Ymdsm") . '.' . $imagen->getClientOriginalExtension();
            $ruta_imagen = public_path('/imagenes_archivo/' . $nombreimagen);
            copy($imagen->getRealPath(), $ruta_imagen);
            $nombreimagen = "/imagenes_archivo/{$nombreimagen}";
        }

        $json[] = [
            'id' => $request->input('id'),
            'cma_id' => $request->input('cma_id'),
            'ma_id_padre' => $request->input('ma_id_padre'),
            'cup_id' => $request->input('cup_id'),
            'cups_id' => $request->input('cups_id'),
            'cd_id' => $request->input('cd_id'),
            'id_bodega' => $request->input('id_bodega'),
            'codigo' => strtoupper($request->input('ma_codigo')),
            'descripcion' => strtoupper($request->input('ma_descripcion')),
            'ruta_imagen' => $nombreimagen,
            'estado_fecha' => $request->input('ma_estado_fecha'),
            'fecha_desde' => $fecha_desde->format("Y/m/d"),
            'fecha_hasta' => $fecha_hasta->format("Y/m/d"),
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_modificar_tbl_medios_almacenamiento(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_medios_almacenamiento;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function deleteUnidadAlmacenamiento($id)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $id,
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_eliminar_tbl_medios_almacenamiento(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_medios_almacenamiento;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_medios_almacenamiento($idPadre, $idBodega)
    {
        $medios_almacenamiento_data = DB::Select("SELECT * FROM archivo.view_tbl_medios_almacenamiento WHERE ma_estado = TRUE AND id_bodega = {$idBodega} ORDER BY ma_estado_fecha desc, ma_fecha_desde, ma_id");
        $medios_almacenamiento = $this->get_medios_almacenamiento_asign($medios_almacenamiento_data, $idPadre);
        return $medios_almacenamiento;
    }

    public function get_medios_almacenamiento_asign($data, $idPadre)
    {
        $filtered_data = array_filter($data, function($d) use ($idPadre) {
            return $d->ma_id_padre == $idPadre;
        });

        $result = [];
        foreach ($filtered_data as $m) {
            $m->medios_almacenamiento = $this->get_medios_almacenamiento_asign($data, $m->ma_id);
            $result[] = $m;
        }

        return $result;
    }

    public function get_configuracion_documentos_active($id)
    {
        $campos_configuracion_documentos = DB::Select("SELECT * FROM archivo.view_tbl_configuracion_documentos WHERE cd_id = {$id}");
        return $campos_configuracion_documentos[0];
    }

    public function storeDocumento(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');
        $ruta_archivo = "";
        $nombre_archivo = "";
        $nombre_archivo_original = "";

        if ($request->hasFile('file_pdf')) {
            $request->validate([
                'file_pdf' => 'required|file|mimes:pdf',
            ]);

            $pdf = $request->file('file_pdf');

            $guid = GuidHelper::GUIDv4();
            $nombrearchivo_origen = $guid . '.' . $pdf->getClientOriginalExtension();
            $nombrearchivo_origen_temp = $guid . '_temp' . '.' . $pdf->getClientOriginalExtension();
            $ruta_temp_pdf = public_path('/imagenes_archivo/' . $nombrearchivo_origen);
            $pdfFilePath = public_path('/imagenes_archivo/' . $nombrearchivo_origen_temp);
            $nameFolderTemp = public_path('/imagenes_archivo/' . $guid);
            copy($pdf->getRealPath(), $pdfFilePath);
            $nombre_archivo = $guid . '-' . date("Ymdsm") . '.' . $pdf->getClientOriginalExtension();
            $nameFolderFileCompress = public_path('/imagenes_archivo/' . $nombre_archivo);
            $nombre_archivo_original = $pdf->getClientOriginalName();
            $ruta_archivo = "/archivo/{$nombre_archivo}";

            // Crear el directorio si no existe
            if (!file_exists($nameFolderTemp)) {
                mkdir($nameFolderTemp, 0777, true);
            }
            // Dividir el archivo original en partes más pequeñas (por ejemplo, páginas individuales)
            $paginas_por_parte = 5;
            $numero_paginas_total = $this->countPages($pdfFilePath);
            $num_parts = ceil($numero_paginas_total / $paginas_por_parte);
            $longitud_numero = strlen((string)$num_parts);
            $parte_actual = 1;
            $cont = 1;

            while ($parte_actual <= $numero_paginas_total) {
                // Obtener el rango de páginas para esta parte
                $inicio = $parte_actual;
                $fin = min($parte_actual + $paginas_por_parte - 1, $numero_paginas_total);
            
                // Nombre del archivo de la parte
                $nombre_archivo_parte = $nameFolderTemp . '/' . 'parte_' . str_pad($cont,$longitud_numero,'0', STR_PAD_LEFT)  . '.pdf';
    
                UploadDocumentoJob::dispatch($nameFolderTemp, $pdfFilePath, $ruta_archivo, $nameFolderFileCompress, $nombre_archivo_parte, $inicio, $fin, $num_parts);
            
                // Incrementar el número de página para la próxima parte
                $parte_actual += $paginas_por_parte;
                $cont++;
            }

        }

        $json[] = [
            'ma_id' => $request->input('ma_id'),
            'cup_id' => $request->input('cup_id'),
            'cups_id' => $request->input('cups_id'),
            'cd_id' => $request->input('cd_id'),
            'codigo' =>strtoupper($request->input('codigo')),
            'nro_folio' =>$request->input('txt_nro_folio'),
            'comentario' =>strtoupper($request->input('comentario')),
            'nombre_archivo' => $nombre_archivo,
            'nombre_archivo_original' => $nombre_archivo_original,
            'ruta_archivo' => $ruta_archivo,
            'campos' => $request->input('campos')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_registrar_tbl_documentos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_documentos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    private function countPages($file) {
        $mpdf = new Mpdf();
        $pageCount = $mpdf->setSourceFile($file);
        return $pageCount;
    }

    public function updateDocumento(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');
        $ruta_archivo = "";
        $nombre_archivo = "";
        $nombre_archivo_original = "";

        $documento = DB::Select("SELECT d_nombre_archivo AS archivo FROM archivo.view_tbl_documentos WHERE d_id = {$request->input('id')}");
        $documento = $documento[0];

        if ($request->hasFile('file_pdf')) {
            $request->validate([
                'file_pdf' => 'required|file|mimes:pdf',
            ]);

            $pdf = $request->file('file_pdf');

            $guid = GuidHelper::GUIDv4();
            $nombrearchivo_origen = $guid . '.' . $pdf->getClientOriginalExtension();
            $nombrearchivo_origen_temp = $guid . '_temp' . '.' . $pdf->getClientOriginalExtension();
            $ruta_temp_pdf = public_path('/imagenes_archivo/' . $nombrearchivo_origen);
            $pdfFilePath = public_path('/imagenes_archivo/' . $nombrearchivo_origen_temp);
            $nameFolderTemp = public_path('/imagenes_archivo/' . $guid);
            copy($pdf->getRealPath(), $pdfFilePath);
            $nombre_archivo = $guid . '-' . date("Ymdsm") . '.' . $pdf->getClientOriginalExtension();
            $nameFolderFileCompress = public_path('/imagenes_archivo/' . $nombre_archivo);
            $nombre_archivo_original = $pdf->getClientOriginalName();
            $ruta_archivo = "/archivo/{$nombre_archivo}";

            // Crear el directorio si no existe
            if (!file_exists($nameFolderTemp)) {
                mkdir($nameFolderTemp, 0777, true);
            }
            // Dividir el archivo original en partes más pequeñas (por ejemplo, páginas individuales)
            $paginas_por_parte = 5;
            $numero_paginas_total = $this->countPages($pdfFilePath);
            $num_parts = ceil($numero_paginas_total / $paginas_por_parte);
            $longitud_numero = strlen((string)$num_parts);
            $parte_actual = 1;
            $cont = 1;

            while ($parte_actual <= $numero_paginas_total) {
                // Obtener el rango de páginas para esta parte
                $inicio = $parte_actual;
                $fin = min($parte_actual + $paginas_por_parte - 1, $numero_paginas_total);
            
                // Nombre del archivo de la parte
                $nombre_archivo_parte = $nameFolderTemp . '/' . 'parte_' . str_pad($cont,$longitud_numero,'0', STR_PAD_LEFT)  . '.pdf';
    
                UploadDocumentoJob::dispatch($nameFolderTemp, $pdfFilePath, $ruta_archivo, $nameFolderFileCompress, $nombre_archivo_parte, $inicio, $fin, $num_parts);
            
                // Incrementar el número de página para la próxima parte
                $parte_actual += $paginas_por_parte;
                $cont++;
            }
        }

        if($documento->archivo != ""){
            Storage::disk('ftp_movilidad')->delete("/ftparchivo/archivo/{$documento->archivo}");
        }

        $json[] = [
            'id' => $request->input('id'),
            'ma_id' => $request->input('ma_id'),
            'cup_id' => $request->input('cup_id'),
            'cups_id' => $request->input('cups_id'),
            'cd_id' => $request->input('cd_id'),
            'codigo' =>strtoupper($request->input('codigo')),
            'nro_folio' =>$request->input('txt_nro_folio'),
            'comentario' =>strtoupper($request->input('comentario')),
            'nombre_archivo' => $nombre_archivo,
            'nombre_archivo_original' => $nombre_archivo_original,
            'ruta_archivo' => $ruta_archivo,
            'campos' => $request->input('campos')
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_modificar_tbl_documentos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_modificar_tbl_documentos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function deleteDocumento($id)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $id,
        ];

        $jsoninsert = json_encode($json);
        $sql = DB::Select('select archivo.procedimiento_eliminar_tbl_documentos(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_documentos;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_documentos_active($id)
    {
        $documentos = DB::Select("SELECT * FROM archivo.view_tbl_documentos WHERE ma_id = {$id} AND d_estado = TRUE");
        return $documentos;
    }

    public function get_secuencial_anio_documento($id)
    {
        $secuencialDocumento = DB::Select("SELECT EXTRACT(YEAR FROM CURRENT_DATE) AS anio_actual, COALESCE(MAX(d_secuencial), 0) + 1 AS siguiente_secuencial FROM archivo.tbl_documentos WHERE cd_id = {$id} AND d_estado = TRUE;");
        return $secuencialDocumento[0];
    }

    public function descargar_archivo_documento($archivo)
    {
        $ruta = base64_decode($archivo);
        $ruta = trim($archivo, '"');
        $contenidoPDF = Storage::disk('ftp_movilidad')->get('/ftparchivo/archivo/' . $archivo);
        return response($contenidoPDF, 200)->header('Content-Type', 'application/pdf');
    }

    public function indexBuscarBodegas()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        $bodegas = DB::Select('SELECT * FROM archivo.view_tbl_archivos WHERE estado=?', ['1']);
        return view('Administrador.Archivo.Buscar.index', compact('menus_', 'bodegas'));
    }

    public function get_documentos_buscar_active(Request $request)
    {
        $idBodega = $request->input('bodega');
        $cup_id = $request->input('cup_id');
        $cups_id = $request->input('cups_id');
        $cd_id = $request->input('cd_id');
        $txt_busqueda = strtoupper($request->input('txt_busqueda'));

        $andWhere = "";

        if($idBodega != 0){
            $andWhere .= " AND id_bodega = {$idBodega}";
        }

        if($cup_id != 0){
            $andWhere .= " AND cup_id = {$cup_id}";
        }

        if($cups_id != 0){
            $andWhere .= " AND cups_id = {$cups_id}";
        }

        if($cd_id != 0){
            $andWhere .= " AND cd_id = {$cd_id}";
        }

        if($txt_busqueda != ""){
            $andWhere .= " AND (d_codigo LIKE '%{$txt_busqueda}%' OR campos_unidades::text LIKE '%{$txt_busqueda}%')";
        }

        $documentos = DB::Select("SELECT * FROM archivo.view_tbl_documentos WHERE d_estado = TRUE {$andWhere}");

        return $documentos;
    }

    public function indexImprimirCaratula()
    {
        return $this->indexListaBodegas('/imprimir_caratula_archivo/');
    }

    public function indexImprimirCaratulaId($id)
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        $bodega = DB::Select('SELECT * FROM archivo.view_tbl_archivos where id=?', [$id]);
        $bodega = $bodega[0];
        return view('Administrador.Archivo.ImprimirArchivoCaratula.index', compact('menus_', 'bodega'));
    }

    public function getDetailsDocument($id){
        $documento = DB::Select("SELECT * FROM archivo.view_tbl_documentos WHERE d_id = {$id}");
        $documento = $documento[0];

        $ma_id_padre = $documento->ma_id;
        $list_padres = [];
        while($ma_id_padre != 0){
            $padre_medio = DB::Select("SELECT * FROM archivo.view_tbl_medios_almacenamiento WHERE ma_id = {$ma_id_padre}");
            $list_padres[] = ["tipo" => $padre_medio[0]->cma_tipo, "codigo" => $padre_medio[0]->ma_codigo, "descripcion" => $padre_medio[0]->ma_descripcion];
            $ma_id_padre = $padre_medio[0]->ma_id_padre;
        }
        $documento->padre_medios = array_reverse($list_padres);
        return $documento;
    }

    public function show_imprimir_caratula(Request $request)
    {
        $medios_almacenamiento_data = DB::Select("SELECT * FROM archivo.view_tbl_medios_almacenamiento WHERE ma_id IN ({$request->medios_almacenamiento}) ORDER BY ma_id");
        $PortraitOrientationList = [2];
        $LandscapeOrientationList = [0,1];

        foreach($medios_almacenamiento_data as $medio){
            $ma_id_padre = $medio->ma_id_padre;
            $list_padres = [];
            while($ma_id_padre != 0){
                $padre_medio = DB::Select("SELECT * FROM archivo.view_tbl_medios_almacenamiento WHERE ma_id = {$ma_id_padre}");
                $list_padres[] = ["nombre" => $padre_medio[0]->cma_tipo, "codigo" => $padre_medio[0]->ma_codigo];
                $ma_id_padre = $padre_medio[0]->ma_id_padre;
            }
            $medio->padre_medios = array_reverse($list_padres);
        }

        foreach($medios_almacenamiento_data as $medio){
            $list_hijos = [];
            $hijo_medio = DB::Select("SELECT cma_tipo, count(*) AS conteo FROM archivo.view_tbl_medios_almacenamiento WHERE ma_id_padre = {$medio->ma_id} AND ma_estado = TRUE GROUP BY cma_tipo");
            foreach($hijo_medio as $h){
                $list_hijos[] = ["nombre" => $h->cma_tipo, "conteo" => $h->conteo];
            }
            $medio->hijos_medios = $list_hijos;
        }

        // Renderizar la vista Blade y obtener el HTML
        $html = view("Administrador.Archivo.ImprimirArchivoCaratula.Reportes.impresion_caratula_{$request->tipoCaratula}", [
            'medios_almacenamiento' => $medios_almacenamiento_data
        ])->render();

        // Configuración de mPDF
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [public_path() . '/fonts']),
            'fontdata' => $fontData + [
                'arial' => [
                    'R' => 'arial.ttf',
                    'B' => 'arialbd.ttf',
                ],
            ],
            'default_font' => 'arial',
            'orientation' => in_array($request->tipoCaratula, $LandscapeOrientationList) ? 'L' : 'P'
        ]);

        // Agregar HTML al PDF
        $mpdf->WriteHTML($html);

        // Devolver PDF como respuesta
        $mpdf->Output("Caratula.pdf", "I");
    }

    public function indexReporteArchivo()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        $bodegas = DB::Select('SELECT * FROM archivo.view_tbl_archivos WHERE estado=?', ['1']);
        return view('Administrador.Archivo.Reportes.index', compact('menus_', 'bodegas'));
    }

    public function get_excel_reporte_archivos($bodega, $cup_id, $cups_id, $cd_id, $text = ""){
        $andWhere = "";

        if($bodega != 0){
            $andWhere .= " AND id_bodega = {$bodega}";
        }

        if($cup_id != 0){
            $andWhere .= " AND cup_id = {$cup_id}";
        }

        if($cups_id != 0){
            $andWhere .= " AND cups_id = {$cups_id}";
        }

        if($cd_id != 0){
            $andWhere .= " AND cd_id = {$cd_id}";
        }

        if($text != ""){
            $andWhere .= " AND (d_codigo LIKE '%{$text}%' OR campos_unidades::text LIKE '%{$text}%')";
        }

        $documentos = DB::Select("SELECT * FROM archivo.view_tbl_documentos WHERE d_estado = TRUE {$andWhere}");

        date_default_timezone_set('America/Guayaquil');
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();
        
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

        $fecharepo = $a . '-' . $mes . '-' . $d;

        foreach($documentos as $documento){
            $valorcampos = "";
            $campos = json_decode($documento->campos_unidades, true);

            foreach ($campos as $campo) {
                $valorcampos .= "[{$campo['dc_nombre']}, {$campo['dc_valor']}] \n";
            }

            $documento->campos_valor = $valorcampos;
        }

        $arrayValues = [];
        $i = 7;
        foreach ($documentos as &$documento) {
            $arrayValues[] = ['column'=>"A{$i}", 'value'=> $documento->d_id, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"B{$i}", 'value'=> $documento->bodega, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"C{$i}", 'value'=> $documento->cup_nombre, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"D{$i}", 'value'=> $documento->cups_nombre, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"E{$i}", 'value'=> $documento->cd_nombre, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"F{$i}", 'value'=> $documento->d_codigo, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"G{$i}", 'value'=> $documento->d_nro_folio, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"H{$i}", 'value'=> $documento->d_comentario, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"I{$i}", 'value'=> $documento->campos_valor, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $i++;
        }

        $spreadsheet = ExcelHelper::ContructSpreadsheet(
            [
                ['columns'=>'A1:I1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A2:I2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A3:I3', 'value'=> "REPORTE DE DOCUMENTOS DE ARCHIVO", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A4:I4', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
            ],
            [
                ['column' => 'A6', 'value' => '#'],
                ['column' => 'B6', 'value' => 'BODEGA'],
                ['column' => 'C6', 'value' => 'UNIDAD PRODUCTORA'],
                ['column' => 'D6', 'value' => 'SERIE'],
                ['column' => 'E6', 'value' => 'DOCUMENTO'],
                ['column' => 'F6', 'value' => 'CÓDIGO'],
                ['column' => 'G6', 'value' => 'NRO FOLIOS'],
                ['column' => 'H6', 'value' => 'COMENTARIOS'],
                ['column' => 'I6', 'value' => 'CAMPOS']
            ],
            $arrayValues,
            [
                ['columns'=> 'A6:I6', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
            ]
        );

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE DOCUMENTOS.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function get_pdf_reporte_archivos($bodega, $cup_id, $cups_id, $cd_id, $text = ""){
        $andWhere = "";

        if($bodega != 0){
            $andWhere .= " AND id_bodega = {$bodega}";
        }

        if($cup_id != 0){
            $andWhere .= " AND cup_id = {$cup_id}";
        }

        if($cups_id != 0){
            $andWhere .= " AND cups_id = {$cups_id}";
        }

        if($cd_id != 0){
            $andWhere .= " AND cd_id = {$cd_id}";
        }

        if($text != ""){
            $andWhere .= " AND (d_codigo LIKE '%{$text}%' OR campos_unidades::text LIKE '%{$text}%')";
        }

        $documentos = DB::Select("SELECT * FROM archivo.view_tbl_documentos WHERE d_estado = TRUE {$andWhere}");
        //return $datos[0];
        date_default_timezone_set('America/Guayaquil');
        $user = session::get('usuario');
        $date = Carbon::now();
        $fecha = $date->toDateString();
        $hora = $date->toTimeString();
        
        $a = date("Y");
        $m = date("m");
        $d = date("d");
        $h = date("H");
        $ii = date("i");
        $s = date("s");
        $mes = '';

        foreach($documentos as $documento){
            $valorcampos = "";
            $campos = json_decode($documento->campos_unidades, true);

            foreach ($campos as $campo) {
                $valorcampos .= "[{$campo['dc_nombre']}, {$campo['dc_valor']}] \n";
            }

            $documento->campos_valor = $valorcampos;
        }

        $html = view('Generico.Reports.report_table_movilidad_manta', [
            'titleReport' => 'Reporte de Certificados Médicos',
            'titlesHeader' => ["<span class='titulo3'>Usuario: {$user} || Fecha: {$fecha} || Hora: {$hora}</span>"],
            'titlesHeaderTable' => ["#","BODEGA", "UNIDAD PRODUCTORA", "SERIE", "DOCUMENTO", "CÓDIGO","NRO FOLIOS", "COMENTARIOS", "CAMPOS"],
            "columnsTable"=> ["d_id","bodega","cup_nombre","cups_nombre","cd_nombre", "d_codigo", "d_nro_folio", "d_comentario","campos_valor"],
            'items'=>$documentos
        ])->render();
        $namefile = 'ReporteDocumentosArchivos_' . time() . '.pdf';
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
        $mpdf->Output($namefile, "D");
    }

}
