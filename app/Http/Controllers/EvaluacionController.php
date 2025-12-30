<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EvaluacionController extends Controller
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
        return view('Administrador.Evaluacion.evaluacion', compact('menus_'));
    }

    public function index_reporte_evaluacion()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.Evaluacion.reporte_evaluacion', compact('menus_'));
    }

    public function get_reporte_evaluacion($id_direccion, $id_jefatura, $id_regimen_contractual)
    {
        if ($id_direccion == 0) {
            $ruta_direccion = '';
        } else {
            $ruta_direccion = "AND emp_id_departamento = '" . $id_direccion . "'";
        }

        if ($id_jefatura == 0) {
            $ruta_jefatura = '';
        } else {
            $ruta_jefatura = "AND emp_id_perfil = '" . $id_jefatura . "'";
        }

        if ($id_regimen_contractual == 0) {
            $ruta_regimen_contractual = '';
        } else {
            $ruta_regimen_contractual = "AND emp_id_regimen_contractual = '" . $id_regimen_contractual . "'";
        }

        //$sql = DB::Select('select public.cursor_listar_reporte_empleados(?,?,?,?)', [$id_direccion,$id_jefatura,$fecha_inicio, $fecha_fin]);

        $sql = DB::connection('pgsql')->select("select * from view_empleado_evaluaciones where emp_id !=1 $ruta_direccion $ruta_jefatura  $ruta_regimen_contractual");

        /*$sql = DB::select("SELECT 
        e.emp_id,
        e.emp_cedula,			
        e.emp_nombre,				
        e.emp_apellido,			
        e.emp_cargo,			
        e.emp_id_perfil,		
        p.per_perfil,		
        e.emp_id_departamento,
        d.dep_departamento,
        e.emp_tipo_contrato,
        e.emp_telefono,	
        e.emp_remuneracion,	
        e.emp_direccion,
        e.emp_ruta_foto,	
        e.emp_observacion,		
        e.emp_fecha_ingreso	  
           FROM public.tbl_empleados e, public.tbl_jefaturas_subdirecciones p, public.tbl_direcciones d
           WHERE e.emp_id_perfil = p.per_id
           AND e.emp_id_departamento = d.dep_id
           AND e.emp_id !=1
           AND e.emp_estado ='A'
           $ruta_direccion
           $ruta_jefatura
           $ruta_regimen_contractual
           ORDER by e.emp_id asc");*/
        $total_empleados = count($sql);
        if ($sql != "[]") {
            return response()->json(['data' => $sql, 'total_empleado' => $total_empleados, 'respuesta' => 'true']);
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