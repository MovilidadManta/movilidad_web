<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Session;

use Carbon\Carbon;


class NotificacionController extends Controller
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
            //return $usuario;
            return view('Administrador.Notificacion.index', compact('menus_', 'usuario'));
        } else {
            return view("Administrador.Login.login");
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
    public function store(Request $r)
    {
        $date = Carbon::now();
        $date = $date->format('Y-m-d');
        $ip = request()->ip();
        $uced = session::get('id_cedula');
        //return $r->users_to;
        $aux = 0;

        if ($r->users_to[0] == 'todos') {
            $json = [];
            $json[] = [
                'user_to' => $r->users_to[0],
                'user_send' => $uced,
                'contenido' => $r->mensaje,
                'estado' => 0,
                'tipo' => $r->tipo,
                'asunto' => $r->asunto
            ];
            $jsoninsert = json_encode($json);
            //print_r($jsoninsert);
            $sql = DB::select('select public.procedimiento_enviar_notificacion_todos(?,?,?)', [$jsoninsert, $ip, $uced]);
            foreach ($sql as $s) {
                $id = $s->procedimiento_enviar_notificacion_todos;
            }
            if ($id == "OK") {
                return response()->json(['respuesta' => "true"]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        } else {
            for ($i = 0; $i < sizeof($r->users_to); $i++) {
                $json = [];
                $json[] = [
                    'user_to' => $r->users_to[$i],
                    'user_send' => $uced,
                    'contenido' => $r->mensaje,
                    'estado' => 0,
                    'tipo' => $r->tipo,
                    'asunto' => $r->asunto

                ];
                $jsoninsert = json_encode($json);
                //print_r($jsoninsert);
                $sql = DB::select('select public.procedimiento_registrar_datos_mensajes(?,?,?)', [$jsoninsert, $ip, $uced]);
                foreach ($sql as $s) {
                    $id = $s->procedimiento_registrar_datos_mensajes;
                }
                if ($id > 0) {
                    $aux++;
                }
            }
            //return $aux;
            if ($aux == sizeof($r->users_to)) {
                return response()->json(['respuesta' => "true"]);
            } else {
                return response()->json(["respuesta" => "false"]);
            }
        }
       
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
