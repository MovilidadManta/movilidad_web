<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use File;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;


class HomeController extends Controller
{

    public function GET_menus_asign()
    {
        $id_proyecto = Session::get('id_proyecto');
        $id_user = Session::get('id_users');
        $menus = DB::select("select * from tbl_submenus s  
        INNER JOIN tbl_menus m  ON s.sme_id_menu = m.me_id
        INNER JOIN tbl_usuarios_menus um ON um.um_id_submenu = s.sme_id 
        where m.me_id_proyecto =? 
        and um.um_id_usuario = ?", [$id_proyecto, $id_user]);
        $menus_ = [];

        foreach ($menus as $m) {
            if (sizeof($menus_) == 0) {
                $menus_[] = [
                    "menu"    => $m->me_menu,
                    "icono"   => $m->me_icons,
                    "submenu" => null
                ];
            } else {
                $aux = 0;
                foreach ($menus_ as $mm) {
                    if ($m->me_menu == $mm['menu']) {
                        $aux++;
                        $submenu[] = [
                            "sme_submenu" => $m->sme_submenu,
                            "sme_tipo_link" => $m->sme_tipo_link,
                            "sme_link" => $m->sme_link
                        ];
                    }
                }
                if ($aux == 0) {
                    $menus_[] = [
                        "menu"  => $m->me_menu,
                        "icono"   => $m->me_icons,
                        "submenu" => null
                    ];
                }
            }
            $index = 0;
            foreach ($menus_ as $m) {
                $submenu = [];
                foreach ($menus as $mm) {
                    if ($m['menu'] == $mm->me_menu) {
                        $submenu[] = [
                            "sme_submenu" => $mm->sme_submenu,
                            "sme_tipo_link" => $mm->sme_tipo_link,
                            "sme_link" => $mm->sme_link
                        ];
                    }
                }
                $menus_[$index]["submenu"] = $submenu;
                $index++;
            }
        }
        //$menus_ = response()->json($menus_);
        return json_encode($menus_);
    }

    public function GET_PERMISOS_SOLICITUDES($fech_ini, $fech_fin)
    {
        $identificacion = Session::get('cedula');
        if ($fech_ini == 0) {
            $ruta_fecha_inicio = '';
            $ruta_fecha_fin = '';
        } else {
            $ruta_fecha_inicio = "AND p.fecha_inicio >= TO_DATE('$fech_ini', 'YYYY-MM-DD')";
            $ruta_fecha_fin = "AND  p.fecha_final <= TO_DATE('$fech_fin', 'YYYY-MM-DD')";
        }
        $permisosporAprobar = DB::select("select 
        p.id_empleado,
        p.estado, 
        p.id,
        p.id_tipo_permiso, 
        concat(e.emp_nombre,' ',e.emp_apellido)as empleado, 
        tp.tipo_permiso, 
        p.fecha_inicio, 
        p.fecha_final,
        p.hora_inicio, 
        p.hora_final, 
        p.total_horas, 
        p.documento, 
        p.fecha_solicitud,
        p.observacion_rechazo, 
        p.total_dias,
        p.observacion,
        p.formulario
        from tbl_permisos p
        inner join tbl_empleados e ON CAST(e.emp_cedula AS integer) = p.id_empleado 
        inner join tbl_tipos_permisos tp ON p.id_tipo_permiso = tp.id
        WHERE p.jefe_imediato = $identificacion 
        $ruta_fecha_inicio
        $ruta_fecha_fin
        ORDER BY p.id DESC");
        return $permisosporAprobar;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$sql = DB::connection('pgsql')->Select('select public.cursor_listar_home()');

        foreach ($sql as $r) {
            $data = $r->cursor_listar_home;
        }
        $json_data = json_decode($data);

        foreach ($json_data as $v) {
            $t_empleado = $v->t_empleado;
            $t_usuario = $v->t_usuario;
            $t_noticia = $v->t_noticia;
            $t_cooperativa = $v->t_cooperativa;
            $t_lugar_turistico = $v->t_lugar_turistico;
            $t_centro_comercial = $v->t_centro_comercial;
            $t_servicio = $v->t_servicio;
            $t_slider = $v->t_slider;
        }
    return view('Administrador.Layout.home',compact('t_empleado','t_usuario','t_noticia','t_cooperativa','t_lugar_turistico','t_centro_comercial','t_servicio','t_slider'));*/
        $menus_ = $this->GET_menus_asign();
        // return $menus_;
        $t_empleados = DB::connection('pgsql')->select("select * from view_total_empleados");
        $t_usuarios = DB::connection('pgsql')->select("select * from view_total_usuarios");
        $t_menu = DB::connection('pgsql')->table("public.view_menu")->get();
        $t_menu_empleado = DB::connection('pgsql')->select("select * from public.view_menu_empleado where emp_id = " . session::get('id_empleado') . "");
        $t_sub_menu_empleado = DB::connection('pgsql')->table("public.view_sub_menu_empleado")->where("emp_id", "=", session::get('id_empleado'))->get();

        //DB::connection('pgsql')->table("public.view_usuarios")->where("correo", "=", $user)->get();
        return view('Administrador.Layout.home', compact('menus_', 't_empleados', 't_usuarios', 't_menu', 't_menu_empleado', 't_sub_menu_empleado'));
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


    public function multas()
    {
        return view('Administrador.Multas.index');
    }
}
