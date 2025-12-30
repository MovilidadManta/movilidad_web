<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Carbon\Carbon;


class FrecuenciasController extends Controller
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
        $tipo_coope = DB::connection('sqlsrv')->select('select * from fc_tipo_coop');
        $cooperativas =  DB::connection('sqlsrv')->select('SELECT count(*) as u FROM FC_COOPERATIVA  where cp_id not in(31)');
        $unidades =  DB::connection('sqlsrv')->select('SELECT COUNT(*) as u FROM [dbo].[FC_UNIDAD] WHERE ND_ID != 200 ');

        //return $tipo_coope;
        //return view('Administrador.Proyectos.index', compact('t_menu', 't_menu_empleado', 't_sub_menu_empleado'));


        return view('Administrador.Frecuencias.index', compact('menus_', 'tipo_coope', 'cooperativas', 'unidades'));
    }


    public function get_frecuencias_semanal()
    {
        $today = Carbon::today();
        $today = $today->format('Y-m-d');

        $semana = Carbon::now();
        $semana = $semana->subDay(8);
        $semana = $semana->format('Y-m-d');

        /*$frecuencias = DB::connection('sqlsrv')->select("SELECT  CONVERT(DATE, m.MR_FECHA, 101) AS dia, count(m.MR_ID) as total FROM [dbo].[FC_MARCACION] m 
        INNER JOIN FC_UNIDAD u ON U.ND_ID = M.ND_ID
        INNER JOIN FC_COOPERATIVA c ON C.CP_ID = u.CP_ID
        INNER JOIN FC_TIPO_COOP tc ON tc.tc_id = c.CP_TIPO_COOPERATIVA
        where m.MR_RESULTADO = 'OK' and CONVERT(DATE,m.MR_FECHA,101)  BETWEEN '" . $semana . "' and '" . $today . "'
        GROUP BY CONVERT(DATE,m.MR_FECHA,101) ORDER BY CONVERT(DATE,m.MR_FECHA,101) ASC");*/

        $automaticas = DB::connection('sqlsrv')->select("select CONVERT(DATE, tn_fecha, 101) AS dia, 
        count(TN_ORIGEN)  as total
        from FC_TRANSACCIONCONSOLIDADA  where  CONVERT(DATE,tn_fecha,101)  BETWEEN '" . $semana . "' and '" . $today .
        "'
        and TN_ORIGEN = 1
        GROUP BY CONVERT(DATE,tn_fecha,101), TN_ORIGEN ORDER BY dia ASC");

        $manuales = DB::connection('sqlsrv')->select("select CONVERT(DATE, tn_fecha, 101) AS dia, 
        count(TN_ORIGEN)  as total
        from FC_TRANSACCIONCONSOLIDADA  where  CONVERT(DATE,tn_fecha,101)  BETWEEN '" . $semana . "' and '" . $today .
        "'
        and TN_ORIGEN = 2
        GROUP BY CONVERT(DATE,tn_fecha,101), TN_ORIGEN ORDER BY dia ASC");
        return response()->json(["automaticas" => $automaticas, "manuales" => $manuales]);
        //return $frecuencias;
    }

    public function get_resporte($today, $f)
    {

        /*$today = Carbon::today();
        $today = $today->format('Y-m-d');*/

        /*  $semana = Carbon::now();
        $semana = $semana->subDay(8);
        $semana = $semana->format('Y-m-d');*/


        /* $sql = "select c.CP_NOMBRE,u.ND_DISCO,u.ND_PLACA ,count(*) as salidas , SUM(t.TR_VTOTAL) as valor,
        STUFF((SELECT ','+cast(cast(MR_FECHA as datetime) as varchar(30))
         FROM FC_MARCACION T1
        WHERE T1.nd_id=u.ND_ID and CONVERT(DATE,T1.MR_FECHA,101)  BETWEEN '" . $today . "' and '" . $today . "'  FOR xml path ('')),1,1,'') AS fecha_salida
        from FC_UNIDAD u 
        INNER JOIN FC_MARCACION m ON u.ND_ID = m.ND_ID
        INNER JOIN FC_COOPERATIVA c ON C.CP_ID = u.CP_ID
        INNER JOIN FC_TIPO_COOP tc ON tc.tc_id = c.CP_TIPO_COOPERATIVA
        INNER JOIN FC_TARIFA t ON t.TR_ID = c.CP_TARIFA
        where m.MR_RESULTADO = 'OK'
        and CONVERT(DATE,m.MR_FECHA,101)  BETWEEN '" . $today . "' and '" . $today . "'";

        $sqlwhere = "and tc.TC_ID in(1,2,3)";*/

        $sql2 = "SELECT 
        PLACA, 
        DISCO, 
        COOPERATIVA, 
        COUNT(*) AS SALIDAS,
        SUM(TOTAL) AS TOTAL,
        STUFF((SELECT ','+CONVERT(VARCHAR,FECHA,8) FROM FCV_RECARGA_USOS_COOPERATIVA T1 WHERE T1.ID=u.ID and CONVERT(DATETIME,T1.FECHA,120)  BETWEEN CONVERT(DATETIME,'" . $today . " 00:00:00',120) and CONVERT(DATETIME,'" . $f . " 23:59:59',120)  FOR xml path ('')),1,1,'') AS fecha_salida,
        STUFF((SELECT ','+TIPO FROM FCV_RECARGA_USOS_COOPERATIVA T2 WHERE T2.ID=u.ID and CONVERT(DATETIME,T2.FECHA,120)  BETWEEN CONVERT(DATETIME,'" . $today . " 00:00:00',120) and CONVERT(DATETIME,'" . $f . " 23:59:59',120)  FOR xml path ('')),1,1,'') AS TIPO 
        from FCV_RECARGA_USOS_COOPERATIVA u 
        where CONVERT (DATETIME,u.fecha,120) BETWEEN CONVERT(DATETIME,'" . $today . " 00:00:00',120) AND CONVERT(DATETIME,'" . $f . " 23:59:59',120)
        and u.tipo !='RECARGA' and ORIGEN !='S/PAGO'
        GROUP BY PLACA,DISCO, COOPERATIVA, CODIGOCOOP, ID ORDER BY COOPERATIVA DESC";

        $sql = "Select PLACA, DISCO, COOPERATIVA, TOTAL, CONVERT(VARCHAR,FECHA,8) as fecha_salida, TIPO from FCV_RECARGA_USOS_COOPERATIVA u
        where u.fecha BETWEEN CONVERT(DATETIME,'" . $today . " 00:00:00',120) AND CONVERT(DATETIME,'" . $f . " 23:59:59',120)
        and u.tipo !='RECARGA'
          and ORIGEN !='S/PAGO'";

        $frecuencias = DB::connection('sqlsrv')->select($sql);
        return $frecuencias;
    }

    public function detalle_f()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        $tipo_coope = DB::connection('sqlsrv')->select('select * from fc_tipo_coop');
        $cooperativas =  DB::connection('sqlsrv')->select('SELECT * FROM FC_COOPERATIVA  where cp_id not in(31,18)');
        //$unidades =  DB::connection('sqlsrv')->select('SELECT * FROM [dbo].[FC_UNIDAD] WHERE ND_ID != 200 ');

        return view('Administrador.Frecuencias.buscar_detalle', compact('menus_', 'cooperativas'));
    }

    public function get_disco($id_coop)
    {
        $Disco = DB::connection('sqlsrv')->select("select CAST(ND_DISCO as INT) as disco from FC_UNIDAD where cp_id=$id_coop ORDER BY CAST (nd_disco as INT) asc");
        return $Disco;
    }

    public function detalle(Request $r)
    {
        $frecuenca = DB::connection('sqlsrv')->select("SELECT TOP 500 PLACA, DISCO, COOPERATIVA, TOTAL, SALDO_INICIAL, SALDO_FINAL, CONVERT(VARCHAR(30),FECHA,120) as FECHA, ORIGEN,ID,TIPO FROM [dbo].[FCV_RECARGA_USOS_COOPERATIVA] where COOPERATIVA = ? AND DISCO=? ORDER BY FECHA DESC", [$r->coop, $r->disco]);

        $saldo = DB::connection('sqlsrv')->select("SELECT ND_SALDO FROM FC_UNIDAD  u
        INNER JOIN FC_COOPERATIVA c ON c.cp_id=u.cp_id
        where u.ND_DISCO=? AND c.CP_NOMBRE = ?", [$r->disco, $r->coop]);
        return response()->json(["frecuencias" => $frecuenca, "saldos" => $saldo]);
    }

    public function gettasas($today, $f)
    {
        $tasas = DB::connection('sqlsrv')->select("select t.TS_FECHAUSO, t.TS_VALOR, p.PRI_DES from [dbo].[PC_TASAHIST] as t INNER JOIN PUERTA p on t.TS_IP_MARCA = p.PRI_IP WHERE t.TS_FECHAUSO BETWEEN CONVERT(DATETIME,'" . $today . " 00:00:00',120) and CONVERT(DATETIME,'" . $f . " 23:59:59',120) ORDER BY TS_VALOR DESC");
        return $tasas;
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
