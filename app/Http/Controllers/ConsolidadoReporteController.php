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

class ConsolidadoReporteController extends Controller
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
        return view('Administrador.Consolidado.reporte_consolidado', 'menus_');
    }

    public function get_reporte_consolidados($fecha_inicio, $fecha_fin)
    {
        //$sql = DB::Select('select public.cursor_listar_indicadores_reporte_consolidado(?,?)', [$fecha_inicio, $fecha_fin]);
        $sql = DB::select("SELECT 
        i.in_id_direccion,			
        d.dep_departamento,			
        i.in_id_jefatura_subdireccion, 	
        j.per_id, 					
        j.per_perfil, 					
        c.con_id, 					
        id.id_id_consolidado, 			
        c.con_id_indicador,			
        i.in_id,						
        i.in_indicador, 			
        i.in_fecha_ingreso, 			
        id.id_id_tipo_detalle, 	
        t.ti_tipo_indicador,		
        c.con_year,					
        c.con_mes,					
        c.con_dia, 				
        c.con_fecha, 				
        id.id_id, 							
        id.id_valor,
        c.con_total,
        c.con_id_indicador			
   FROM public.tbl_indicadores_detalles id,
       public.tbl_consolidados c,
       public.tbl_indicadores i,
       public.tbl_direcciones d,
       public.tbl_jefaturas_subdirecciones j,
       public.tbl_tipos_indicadores t
       WHERE c.con_id = id.id_id_consolidado
       AND i.in_id=c.con_id_indicador
       AND d.dep_id=i.in_id_direccion
       AND j.per_id=i.in_id_jefatura_subdireccion
       AND t.ti_id = id.id_id_tipo_detalle
       /*AND j.per_id = 26*/
       ORDER by c.con_id_indicador ASC");

        $json_data = json_decode(json_encode($sql), true);
        $array_a = [];
        $array_m = [];
        $array_j = [];
        $array_i = [];

        for ($i = 0; $i < count($json_data); $i++) {
            array_push($array_a, $json_data[$i]['con_year']);
            array_push($array_m, $json_data[$i]['con_mes']);
            array_push($array_j, $json_data[$i]['per_id']);
            array_push($array_i, $json_data[$i]['in_id']);
        }

        //AÑOS UNICOS
        $array_año = array_keys(array_count_values($array_a));
        $data_year = [];
        for ($i = 0; $i < count($array_año); $i++) {
            array_push($data_year, array('year' => $array_año[$i]));
        }

        //MESES UNICOS
        $array_meses = array_keys(array_count_values($array_m));
        $data_mes = [];
        for ($i = 0; $i < count($array_año); $i++) {
            array_push($data_mes, array('mes' => $array_meses[$i]));
        }

        $data=[];
        for ($i=0; $i < count($data_year) ; $i++) { 
            for ($x=0; $x < count($data_mes) ; $x++) { 
                for ($j=0; $j < count($json_data) ; $j++) {
                    if($data_year[$i]['year']==$json_data[$j]['con_year']){
                        array_push($data,$json_data[$j]);
                    }
                }
            }
        }
        return $data;

        //JEFATURAS UNICAS
        $array_jefaturas = array_keys(array_count_values($array_j));
        $data_jefatura = [];
        for ($i = 0; $i < count($array_jefaturas); $i++) {
            array_push($data_jefatura, array('jefatura' => $array_jefaturas[$i]));
        }

        //INDICADORES UNICAS
        $array_indicadores = array_keys(array_count_values($array_i));
        $data_indicador = [];
        for ($i = 0; $i < count($array_indicadores); $i++) {
            array_push($data_indicador, array('id_indicador' => $array_indicadores[$i]));
        }

        return response()->json([
            'respuesta' => $data_year,
        ]);


        if ($json_data != "[]") {
            return response()->json([
                'respuesta' => true,
                'data_year' => $data_year,
                'data_mes' => $data_mes,
                'data_jefatura' => $data_jefatura,
                'data_indicador' => $data_indicador,
                'json_data' => $json_data
            ]);
        } else {
            return response()->json(['respuesta' => false]);
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
