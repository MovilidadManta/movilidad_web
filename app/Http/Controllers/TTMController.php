<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use DB;
use DateTime;
use File;
use Storage;

use Carbon\Carbon;
use Mpdf\Mpdf;
use App\Helpers\GuidHelper;
use App\Helpers\ExcelHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PHPExcel_Cell_DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class TTMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_empleado = session::get('id_empleado');
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.TTM.convocatoria_arrendamiento.index', compact('menus_'));
    }

    public function get_lista_convocatorias()
    {
        $arrendamientos = DB::Select("SELECT * FROM view_tbl_convocatoria_arrendamiento ORDER BY ca_id");
        return $arrendamientos;
    }

    public function store_convocatoria(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $guid = GuidHelper::GUIDv4();
        $archivo = $request->file('file');
        $nombrearchivo = $guid . date("Ymdsm") . '.' . $archivo->getClientOriginalExtension();

        $upload = Storage::disk('ftp_movilidad')->put("/ftppublic/convocatoria_arrendamiento/" . $nombrearchivo, File::get($archivo));

        if($upload){
            $json[] = [
                'descripcion' => $request->input('descripcion'),
                'estado' => boolval($request->input('estado')),
                'nombre_archivo' => $nombrearchivo,
                'nombre_archivo_original' => $archivo->getClientOriginalName(),
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::Select('select public.procedimiento_registrar_tbl_convocatoria_arrendamiento(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_registrar_tbl_convocatoria_arrendamiento;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }else{
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function update_convocatoria(Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');
        $guid = GuidHelper::GUIDv4();
        $archivo = $request->file('file');
        $nombrearchivo = $guid . date("Ymdsm") . '.' . $archivo->getClientOriginalExtension();
        $archivo_old = "/ftppublic/convocatoria_arrendamiento/" . $request->input('archivo_old');

        if (Storage::disk('ftp_movilidad')->exists($archivo_old)) {
            Storage::disk('ftp_movilidad')->delete($archivo_old);
        }

        $upload = Storage::disk('ftp_movilidad')->put("/ftppublic/convocatoria_arrendamiento/" . $nombrearchivo, File::get($archivo));

        if($upload){
            $json[] = [
                'id' => $request->input('id'),
                'descripcion' => $request->input('descripcion'),
                'estado' => boolval($request->input('estado')),
                'nombre_archivo' => $nombrearchivo,
                'nombre_archivo_original' => $archivo->getClientOriginalName(),
            ];
            $jsoninsert = json_encode($json);
            $sql = DB::Select('select public.procedimiento_modificar_tbl_convocatoria_arrendamiento(?,?,?)', [$jsoninsert, $ip, $user]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_modificar_tbl_convocatoria_arrendamiento;
            }
            if ($sql != "[]") {
                return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }else{
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function delete_convocatoria($id, Request $request)
    {
        $ip = request()->ip();
        $user = session::get('id_users');

        $archivo_old = "/ftppublic/convocatoria_arrendamiento/" . $request->input('archivo');

        if (Storage::disk('ftp_movilidad')->exists($archivo_old)) {
            Storage::disk('ftp_movilidad')->delete($archivo_old);
        }

        $json[] = [
            'id' => $id,
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_eliminar_tbl_convocatoria_arrendamiento(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_convocatoria_arrendamiento;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function descargar_archivo_convocatoria($archivo)
    {
        $ruta = base64_decode($archivo);
        $ruta = trim($archivo, '"');
        $contenidoPDF = Storage::disk('ftp_movilidad')->get("/ftppublic/convocatoria_arrendamiento/" . $archivo);
        return response($contenidoPDF, 200)->header('Content-Type', 'application/pdf');
    }
}