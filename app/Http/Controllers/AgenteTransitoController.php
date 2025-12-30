<?php

namespace App\Http\Controllers;

use DB;
use Session;
use DateTime;
use PHPExcel_Cell_DataType;

use Carbon\Carbon;
use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Jobs\SendEmailToAgentsJob;
use App\Helpers\GenerateQRHelper;
use App\Helpers\ExcelHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Mail;

class AgenteTransitoController extends Controller
{
    public function ConfAgentesTransitoIndex()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.AgenteTransito.ConfiguracionAgentesTransito.index', compact('menus_'));
    }

    public function GetAgentesTransito()
    {
        $sql = DB::Select("SELECT * FROM public.view_tbl_cod_agentes_transito ORDER BY CASE WHEN TRIM(at_codigo) = '' THEN 1 ELSE 0 END, at_codigo, emp_apellido");
        $json_data = $sql;
        return response()->json($json_data);
    }

    public function storeCodAgenteTransito(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'at_id' => strtoupper($request->at_id),
            'at_codigo' => strtoupper($request->at_codigo),
            'emp_id' => $request->emp_id,
            'at_cedula' => $request->at_cedula
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_modificar_tbl_cod_agentes_transito(?,?,?)', [$jsoninsert, $ip, $user]);

        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_modificar_tbl_cod_agentes_transito;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function ConfPlantillaIndex()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.AgenteTransito.ConfiguracionPlantilla.index', compact('menus_'));
    }

    public function StorePlantilla(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');
        $cont = 1;

        if ($request->hasFile("file_imagen_{$cont}")) {
            $imagen = $request->file("file_imagen_{$cont}");
            $ruta_imagen = public_path('/imagenes_orden_cuerpo/' . $imagen->getClientOriginalName());
            copy($imagen->getRealPath(), $ruta_imagen);
            $nombreimagen = "/imagenes_orden_cuerpo/{$imagen->getClientOriginalName()}";
            $cont++;
        }

        $json[] = [
            'cf_plantilla' => json_decode($request->cf_plantilla)
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_modificar_tbl_conf_plan_orden_cuerpo(?,?,?)', [$jsoninsert, $ip, $user]);

        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_modificar_tbl_conf_plan_orden_cuerpo;
        }

        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function GetActivePlantilla()
    {
        $plantilla = DB::Select("SELECT * FROM public.tbl_conf_plan_orden_cuerpo WHERE cf_estado = TRUE ORDER BY cf_fecha desc LIMIT 1");
        return $plantilla;
    }

    public function ListaOrdenCuerpoIndex()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.AgenteTransito.OrdenCuerpo.lista', compact('menus_'));
    }

    public function RegisterOrdenCuerpo($oc_id = 0, $duplicate = false)
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.AgenteTransito.OrdenCuerpo.registrar', compact('menus_', 'oc_id', 'duplicate'));
    }

    private function get_agente_id($id)
    {
        $sql = DB::Select("SELECT * FROM public.view_tbl_cod_agentes_transito WHERE at_id = {$id}");

        return $sql[0];
    }

    public function get_all_agente()
    {
        $agents = DB::Select("SELECT * FROM public.view_tbl_cod_agentes_transito WHERE at_id > 0");

        return $agents;
    }

    public function get_agente_search($limit, $text)
    {
        $text = str_replace("'", "\'", $text);
        $sql = DB::Select("SELECT * FROM public.view_tbl_cod_agentes_transito WHERE at_id > 0 AND (at_codigo LIKE E'%" . strtoupper($text) . "%' OR emp_cedula LIKE E'%" . strtoupper($text) . "%' OR UPPER(CONCAT(emp_apellido, ' ', emp_nombre)) LIKE E'%" . strtoupper($text) . "%') ORDER BY CASE WHEN TRIM(at_codigo) = '' THEN 1 ELSE 0 END, at_codigo, emp_apellido");

        $json_data = $sql;

        if ($json_data != "[]") {
            return response()->json(['data' => $json_data, 'respuesta' => true]);
        } else {
            return response()->json(['respuesta' => false]);
        }
    }

    public function get_lista_orden_cuerpo($id = 0)
    {
        $where = "";
        if($id != 0){
            $where = "WHERE oc_id = {$id}";
        }
        if($id == 0){
            $where = "ORDER BY oc_id DESC LIMIT 30";
        }
        $lista_orden_cuerpo = DB::Select("SELECT * FROM public.view_tbl_plan_orden_cuerpo {$where}");
        return $lista_orden_cuerpo;
    }

    public function get_secuencial_orden_cuerpo()
    {
        $secuencial = DB::Select("SELECT * FROM tbl_variables_configuraciones WHERE cf_codigo = 'SECUENCIAL_ORDEN_CUERPO'");
        return $secuencial;
    }

    public function StoreOrdenCuerpo(Request $request)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'oc_id' => json_decode($request->oc_id),
            'oc_plantilla' => json_decode($request->oc_plantilla),
            'oc_datos' => json_decode($request->oc_datos)
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_modificar_tbl_plan_orden_cuerpo(?,?,?)', [$jsoninsert, $ip, $user]);

        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_modificar_tbl_plan_orden_cuerpo;
        }

        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function OrdenCuerpoDelete($id)
    {
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $json[] = [
            'id' => $id
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_eliminar_tbl_plan_orden_cuerpo(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_eliminar_tbl_plan_orden_cuerpo;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    public function get_pdf_orden_cuerpo($id, $at_id = 0)
    {
        
        $data = $this->get_lista_orden_cuerpo($id);
        $mpdf = $this->generatePdfToOrdenCuerpo(json_decode($data[0]->oc_datos), $at_id, $data[0]->oc_firma);
        $namefile = "Orden_cuerpo_{$id}.pdf";
        $mpdf->Output($namefile, "I");
    }

    public function processOC(Request $request){

        $data = $this->get_lista_orden_cuerpo($request->oc_id);
        $datosOc = json_decode($data[0]->oc_datos);
        $agentesToSendEmail = $this->recorrerDatos($datosOc);
        $ip = request()->ip();
        $user = session::get('id_users');

        // 1) Eliminar valores no válidos (undefined, null, vacío)
        $agentsLimpios = array_filter(
            $agentesToSendEmail['agents'],
            fn ($v) => $v !== null && $v !== '' && $v !== 'undefined'
        );

        // 2) Dejar solo únicos
        $agentesToSendEmailList = array_values(array_unique($agentsLimpios));

        $nombrearchivo = Str::slug("orden_cuerpo_") . date("Ymdsm") . '.PDF';
        $ruta = '/archivos_solicitudes_lotaip/';

        $json[] = [
            'id_oc' => $request->oc_id,
            'list_id_related' => array_values($agentesToSendEmailList),
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_tbl_send_emails_oc(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_tbl_send_emails_oc;
        }

        //$this->sendEmailAgentesList($agentesToSendEmail['cod']);

        if ($sql != "[]") {
            return response()->json(['respuesta' => "true", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => "false"]);
        }
    }

    private function sendEmailAgentesList($orden_cuerpo){
        $correo_emp = "joaquin.flores@movilidadmanta.gob.ec";

        Mail::send(
            'Administrador.AgenteTransito.OrdenCuerpo.Correo.view_correo_orden_cuerpo',
            array(
                'orden_cuerpo' => $orden_cuerpo,
                'intranet' => env('API_REST_INTRANET')
            ),
            function ($msj) use ($correo_emp) {
                $msj->subject('ASIGNACION DE ORDEN DE CUERPO');
                $msj->from('movilidadmanta@gmail.com');
                $msj->to($correo_emp);
            }
        );
    }

    private function recorrerDatos($datos, $agents = ['agents' => [], 'cod' => '']){

        foreach ($datos as $dato) {
            switch ($dato->type) {
                case 'container':
                    $agents = $this->recorrerDatos($dato->items, $agents);
                    break;
                case 'paragraph':
                    if($dato->name == "title_document"){
                        preg_match('/\d{7}/', $dato->text, $matches);
                        if (isset($matches[0])) {
                            $agents['cod'] = $matches[0];
                        }
                    }
                    break;
                case 'list':
                    foreach($dato->items as $il){
                        if(isset($il->der->origin) && $il->der->origin == "agente" && $il->der->at_id != ""){
                            $agents['agents'][] = $il->der->at_id;
                        }
                        if(isset($il->izq->origin) && $il->izq->origin == "agente" && $il->izq->at_id != ""){
                            $agents['agents'][] = $il->izq->at_id;
                        }
                    }
                    break;
                case 'table':
                    foreach($dato->filas as $fila){
                        foreach($fila->columns as $column){
                            if($column->type == "search" && $column->at_id != ""){
                                $agents['agents'][] = $column->at_id;
                            }
                        }
                    }
                    break;
                case 'table_franco':
                    foreach($dato->items as $item){
                        $agents['agents'][] = $item->id;
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }

        return $agents;
    }

    private function getIdsToRender($data, $at_id){
        $listToRender = ['all' => false, 'ids' => [], 'distrito' => [], 'turno' => ''];
        $listIds = [];

        $listIds[] = $at_id;
        switch ($at_id) {
            case 0:
            case 125:
            case 1:
                $listToRender['all'] = true;
                break;
            case 152:
                $listIds = array_merge($listIds, $this->resolveUnidadesLogisticas($data, $at_id, $listToRender, $listIds));
                break;
            default:
                $listResult = $this->resolveSomethingCaseIds($data, $at_id, $listToRender, $listIds);
                $listToRender['distrito'] = $listResult['listToRender']['distrito'];
                $listToRender['turno'] = $listResult['listToRender']['turno'];
                $listIds = array_merge($listIds, $listResult['ids']);
                break;
        }

        $listToRender['ids'] = array_values(array_unique($listIds));

        return $listToRender;
    }

    private function resolveSomethingCaseIds($data, $at_id, $listToRender, $listIds){
        $list_supervisor = $this->getAsignationFromListSupervisor($data, $at_id);

        if($list_supervisor['all']) $listToRender['all'] = true;
        if($list_supervisor['found']){
            $listIds[] = $list_supervisor['id_supervisor'];
        }

        $list_distribucion_agente = $this->getListDistribucionSupervisores($data);
        $filterDistribucionAgente = array_filter($list_distribucion_agente, function($item) use ($at_id) {
            return $item['at_id'] == $at_id;
        });

        $filterDistribucionAgente = array_values($filterDistribucionAgente);

        $list_patrulleros = $this->getIdsUnidadesPatrulleros($data, $at_id);

        $listIds = array_merge($listIds, $list_patrulleros);

        //Puntos Fijos mañana oeste
        $turno_manana_oeste = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'MAÑANA' && $item['distrito'] == 'OESTE';
        });
        
        $idsPuntosFijosMananaOeste = [];
        $namePuntoFijo = 'puntos_fijos_manana_oeste';
        if(count($turno_manana_oeste) > 0){
            $idsPuntosFijosMananaOeste = $this->getIdsPuntosFijos($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsPuntosFijosMananaOeste = $this->getIdsPuntosFijos($data, $namePuntoFijo, false, $at_id);
            if($idsPuntosFijosMananaOeste['found']){
                $listToRender['distrito'] = ["OESTE"];
                $listToRender['turno'] = "MAÑANA";
            }
        }

        $listIds = array_merge($listIds, $idsPuntosFijosMananaOeste['ids']);
        //Fin Puntos Fijos mañana oeste

        //Puntos Fijos mañana este
        $turno_manana_este = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'MAÑANA' && $item['distrito'] == 'ESTE';
        });

        $idsPuntosFijosMananaEste = [];
        $namePuntoFijo = 'puntos_fijos_manana_este';
        if(count($turno_manana_este) > 0){
            $idsPuntosFijosMananaEste = $this->getIdsPuntosFijos($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsPuntosFijosMananaEste = $this->getIdsPuntosFijos($data, $namePuntoFijo, false, $at_id);
            if($idsPuntosFijosMananaEste['found']){
                $listToRender['distrito'] = ["ESTE"];
                $listToRender['turno'] = "MAÑANA";
            }
        }

        $listIds = array_merge($listIds, $idsPuntosFijosMananaEste['ids']);
        //Fin Puntos Fijos mañana este

        //Puntos Fijos tarde oeste
        $turno_tarde_oeste = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'TARDE' && $item['distrito'] == 'OESTE';
        });
        
        $idsPuntosFijosTardeOeste = [];
        $namePuntoFijo = 'puntos_fijos_tarde_oeste';
        if(count($turno_tarde_oeste) > 0){
            $idsPuntosFijosTardeOeste = $this->getIdsPuntosFijos($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsPuntosFijosTardeOeste = $this->getIdsPuntosFijos($data, $namePuntoFijo, false, $at_id);
            if($idsPuntosFijosTardeOeste['found']){
                $listToRender['distrito'] = ["OESTE"];
                $listToRender['turno'] = "TARDE";
            }
        }
        
        $listIds = array_merge($listIds, $idsPuntosFijosTardeOeste['ids']);
        //Fin Puntos Fijos tarde oeste

        //Puntos Fijos tarde este
        $turno_tarde_este = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'TARDE' && $item['distrito'] == 'ESTE';
        });

        $idsPuntosFijosTardeEste = [];
        $namePuntoFijo = 'puntos_fijos_tarde_este';
        if(count($turno_tarde_este) > 0){
            $idsPuntosFijosTardeEste = $this->getIdsPuntosFijos($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsPuntosFijosTardeEste = $this->getIdsPuntosFijos($data, $namePuntoFijo, false, $at_id);
            if($idsPuntosFijosTardeEste['found']){
                $listToRender['distrito'] = ["ESTE"];
                $listToRender['turno'] = "TARDE";
            }
        }

        $listIds = array_merge($listIds, $idsPuntosFijosTardeEste['ids']);
        //Fin Puntos Fijos tarde este

        //Motorizados mañana oeste
        $turno_manana_oeste = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'MAÑANA' && $item['distrito'] == 'OESTE';
        });
        
        $idsMotorizadosMananaOeste = [];
        $namePuntoFijo = 'motorizados_manana_oeste';
        if(count($turno_manana_oeste) > 0){
            $idsMotorizadosMananaOeste = $this->getIdsMotorizados($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsMotorizadosMananaOeste = $this->getIdsMotorizados($data, $namePuntoFijo, false, $at_id);
            if($idsMotorizadosMananaOeste['found']){
                $listToRender['distrito'] = ["OESTE"]; 
                $listToRender['turno'] = "MAÑANA";
            }
        }

        $listIds = array_merge($listIds, $idsMotorizadosMananaOeste['ids']);
        //Fin Motorizados mañana oeste

        //Motorizados mañana este
        $turno_manana_este = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'MAÑANA' && $item['distrito'] == 'ESTE';
        });

        $idsMotorizadosMananaEste = [];
        $namePuntoFijo = 'motorizados_manana_este';
        if(count($turno_manana_este) > 0){
            $idsMotorizadosMananaEste = $this->getIdsMotorizados($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsMotorizadosMananaEste = $this->getIdsMotorizados($data, $namePuntoFijo, false, $at_id);
            if($idsMotorizadosMananaEste['found']){
                $listToRender['distrito'] = ["ESTE"]; 
                $listToRender['turno'] = "MAÑANA";
            }
        }

        $listIds = array_merge($listIds, $idsMotorizadosMananaEste['ids']);
        //Fin Motorizados mañana este

        //Motorizados tarde oeste
        $turno_tarde_oeste = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'TARDE' && $item['distrito'] == 'OESTE';
        });
        
        $idsMotorizadosTardeOeste = [];
        $namePuntoFijo = 'motorizados_tarde_oeste';
        if(count($turno_tarde_oeste) > 0){
            $idsMotorizadosTardeOeste = $this->getIdsMotorizados($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsMotorizadosTardeOeste = $this->getIdsMotorizados($data, $namePuntoFijo, false, $at_id);
            if($idsMotorizadosTardeOeste['found']){
                $listToRender['distrito'] = ["OESTE"]; 
                $listToRender['turno'] = "TARDE";
            }
        }

        $listIds = array_merge($listIds, $idsMotorizadosTardeOeste['ids']);
        //Fin Motorizados tarde oeste

        //Motorizados tarde este
        $turno_tarde_este = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'TARDE' && $item['distrito'] == 'ESTE';
        });

        $idsMotorizadosTardeEste = [];
        $namePuntoFijo = 'motorizados_tarde_este';
        if(count($turno_tarde_este) > 0){
            $idsMotorizadosTardeEste = $this->getIdsMotorizados($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsMotorizadosTardeEste = $this->getIdsMotorizados($data, $namePuntoFijo, false, $at_id);
            if($idsMotorizadosTardeEste['found']){
                $listToRender['distrito'] = ["ESTE"]; 
                $listToRender['turno'] = "TARDE";
            }
        }

        $listIds = array_merge($listIds, $idsMotorizadosTardeEste['ids']);
        //Fin Motorizados tarde este

        //Ciclistas manana este oeste
        $turno_manana_este_oeste = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'MAÑANA' && ($item['distrito'] == 'ESTE' || $item['distrito'] == 'OESTE');
        });

        $idsCiclistasMananaEsteOeste = [];
        $namePuntoFijo = 'ciclista_manana_este_oeste';
        if(count($turno_manana_este_oeste) > 0){
            $idsCiclistasMananaEsteOeste = $this->getIdsCiclistas($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsCiclistasMananaEsteOeste = $this->getIdsCiclistas($data, $namePuntoFijo, false, $at_id);
            if($idsCiclistasMananaEsteOeste['found']){
                $listToRender['distrito'] = ["ESTE", "OESTE"]; 
                $listToRender['turno'] = "MAÑANA";
            }
        }

        $listIds = array_merge($listIds, $idsCiclistasMananaEsteOeste['ids']);
        //Fin Ciclistas manana este oeste

        //Ciclistas tarde este oeste
        $turno_tarde_este_oeste = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'TARDE' && ($item['distrito'] == 'ESTE' || $item['distrito'] == 'OESTE');
        });

        $idsCiclistasTardeEsteOeste = [];
        $namePuntoFijo = 'ciclista_tarde_este_oeste';
        if(count($turno_tarde_este_oeste) > 0){
            $idsCiclistasTardeEsteOeste = $this->getIdsCiclistas($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsCiclistasTardeEsteOeste = $this->getIdsCiclistas($data, $namePuntoFijo, false, $at_id);
            if($idsCiclistasTardeEsteOeste['found']){
                $listToRender['distrito'] = ["ESTE", "OESTE"]; 
                $listToRender['turno'] = "TARDE";
            }
        }

        $listIds = array_merge($listIds, $idsCiclistasTardeEsteOeste['ids']);
        //Fin Ciclistas tarde este oeste

        //Operativo
        $turno_operativo_este_oeste = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'OPERATIVO' && ($item['distrito'] == 'ESTE' || $item['distrito'] == 'OESTE');
        });

        $idsOperativoEsteOeste = [];
        $nameOperativo = 'tabla_grupo_operativo';
        if(count($turno_operativo_este_oeste) > 0){
            $idsOperativoEsteOeste = $this->getIdsOperativo($data, $nameOperativo, true, $at_id);
        }else{
            $idsOperativoEsteOeste = $this->getIdsOperativo($data, $nameOperativo, false, $at_id);
            if($idsOperativoEsteOeste['found']){
                $listToRender['distrito'] = ["ESTE", "OESTE"];
                $listToRender['turno'] = "OPERATIVO";
            }
        }

        $listIds = array_merge($listIds, $idsOperativoEsteOeste['ids']);
        //Fin Operativo

         //Nocturno
         $turno_nocturno_este_oeste = array_filter($filterDistribucionAgente, function($item) {
            return $item['turno'] == 'NOCTURNA' && ($item['distrito'] == 'ESTE' || $item['distrito'] == 'OESTE');
        });

        $idsNocturnoEsteOeste = [];
        $namePuntoFijo = 'tabla_personal_nocturna';
        if(count($turno_nocturno_este_oeste) > 0){
            $idsNocturnoEsteOeste = $this->getIdsNocturna($data, $namePuntoFijo, true, $at_id);
        }else{
            $idsNocturnoEsteOeste = $this->getIdsNocturna($data, $namePuntoFijo, false, $at_id);
            if($idsNocturnoEsteOeste['found']){
                $listToRender['distrito'] = ["ESTE", "OESTE"];
                $listToRender['turno'] = "NOCTURNA";
            }
        }

        $listIds = array_merge($listIds, $idsNocturnoEsteOeste['ids']);

        return ['ids' => $listIds, 'listToRender' => $listToRender];
    }

    private function resolveUnidadesLogisticas($data, $at_id, $listToRender, $listIds){

        $list_patrulleros = $this->getIdsUnidadesPatrulleros($data, $at_id, [], true);

        $listIds = array_merge($listIds, $list_patrulleros);

        //Motorizados mañana oeste
        
        
        $namePuntoFijo = 'motorizados_manana_oeste';
        $idsMotorizadosMananaOeste = $this->getIdsMotorizados($data, $namePuntoFijo, true, $at_id);

        $listIds = array_merge($listIds, $idsMotorizadosMananaOeste['ids']);
        //Fin Motorizados mañana oeste

        //Motorizados mañana este

        $namePuntoFijo = 'motorizados_manana_este';
        $idsMotorizadosMananaEste = $this->getIdsMotorizados($data, $namePuntoFijo, true, $at_id);

        $listIds = array_merge($listIds, $idsMotorizadosMananaEste['ids']);
        //Fin Motorizados mañana este

        //Motorizados tarde oeste
        
        $namePuntoFijo = 'motorizados_tarde_oeste';
        $idsMotorizadosTardeOeste = $this->getIdsMotorizados($data, $namePuntoFijo, true, $at_id);

        $listIds = array_merge($listIds, $idsMotorizadosTardeOeste['ids']);
        //Fin Motorizados tarde oeste

        //Motorizados tarde este

        $namePuntoFijo = 'motorizados_tarde_este';
        $idsMotorizadosTardeEste = $this->getIdsMotorizados($data, $namePuntoFijo, true, $at_id);

        $listIds = array_merge($listIds, $idsMotorizadosTardeEste['ids']);
        //Fin Motorizados tarde este

         //Nocturno

        $namePuntoFijo = 'tabla_personal_nocturna';
        $idsNocturnoEsteOeste = $this->getIdsNocturna($data, $namePuntoFijo, true, $at_id);

        //Fin Noctura

        $listIds = array_merge($listIds, $idsNocturnoEsteOeste['ids']);

        return $listIds;
    }

    private function getAsignationFromListSupervisor($data, $at_id){
        $resultList = ['all' => false, 'found' => false, 'id_supervisor' => 0];
        foreach($data as $item){
            if($item->type == 'container'){
                $resultList = $this->getAsignationFromListSupervisor($item->items, $at_id);
            }
            if($item->type == 'list' && $item->name == 'list_supervisor'){
                foreach ($item->items as $index => $row) {
                    if (isset($row->der->at_id) && $row->der->at_id == $at_id) {
                        if($index == 0){
                            $resultList['all'] = true;
                        }
                        $resultList['id_supervisor'] = $item->items[0]->der->at_id;
                        $resultList['found'] = true;
                        break;
                    }
                }
                break;
            }
        }
        return $resultList;
    }

    private function getListDistribucionSupervisores($data){
        $list = [];
        foreach($data as $item){
            if($item->type == 'container'){
                $result = $this->getListDistribucionSupervisores($item->items);
                $list = count($result) > 0 ? $result : $list;
            }
            if($item->type == 'table' && $item->name == 'distribucion_supervisor'){
                foreach ($item->filas as $fila) {
                    if($fila->columns[1]->at_id != ""){
                        $list[] = ['turno' => $fila->columns[0]->data_text, 'distrito' => 'OESTE', 'at_id' => $fila->columns[1]->at_id];
                    }
                    if($fila->columns[2]->at_id != ""){
                        $list[] = ['turno' => $fila->columns[0]->data_text, 'distrito' => 'ESTE', 'at_id' => $fila->columns[2]->at_id];
                    }
                }
                break;
            }
        }
        return $list;
    }

    private function getIdsUnidadesPatrulleros($data, $at_id, $list = [], $renderAll = false){
        foreach($data as $item){
            if($item->type == 'container'){
                $result = $this->getIdsUnidadesPatrulleros($item->items, $at_id, $list, $renderAll);
                $list = count($result) > 0 ? $result : $list;
            }
            if($item->type == 'table' && ($item->name == 'unidades_patrullero_manana' || $item->name == 'unidades_patrullero_tarde')){
                if($item->filas[0]->columns[2]->at_id == $at_id || $renderAll){
                    $list[] = $item->filas[1]->columns[2]->at_id;
                }
                if($item->filas[1]->columns[2]->at_id == $at_id || $renderAll){
                    $list[] = $item->filas[0]->columns[2]->at_id;
                }
                $list[] = $at_id;
            }
        }
        return $list;
    }

    private function getIdsPuntosFijos($data, $nameTable, $renderAll, $at_id, $list = ['found' => false, 'ids' => []]){
        foreach($data as $item){
            if($item->type == 'container'){
                $result = $this->getIdsPuntosFijos($item->items, $nameTable, $renderAll, $at_id, $list);
                $list = count($result['ids']) > 0 ? $result : $list;
            }
            if($item->type == 'table' && $item->name == $nameTable){
                foreach ($item->filas as $index => $fila) {
                    if($index == 0) continue;
                    if($fila->columns[3]->at_id != "" && $renderAll){
                        $list['ids'][] = $fila->columns[3]->at_id;
                    }
                    if($fila->columns[3]->at_id == $at_id){
                        $list['ids'][] = $at_id;
                        $list['found'] = true;
                    }
                }
            }
        }
        return $list;
    }

    private function getIdsMotorizados($data, $nameTable, $renderAll, $at_id, $list = ['found' => false, 'ids' => []]){
        foreach($data as $item){
            if($item->type == 'container'){
                $result = $this->getIdsMotorizados($item->items, $nameTable, $renderAll, $at_id, $list);
                $list = count($result['ids']) > 0 ? $result : $list;
            }
            if($item->type == 'table' && $item->name == $nameTable){
                foreach ($item->filas as $index => $fila) {
                    if($index == 0) continue;
                    if($fila->columns[3]->at_id != "" && $renderAll){
                        $list['ids'][] = $fila->columns[3]->at_id;
                    }
                    if($fila->columns[3]->at_id == $at_id){
                        $list['ids'][] = $at_id;
                        $list['found'] = true;
                    }
                }
            }
        }
        return $list;
    }

    private function getIdsCiclistas($data, $nameTable, $renderAll, $at_id, $list = ['found' => false, 'ids' => []]){
        foreach($data as $item){
            if($item->type == 'container'){
                $result = $this->getIdsCiclistas($item->items, $nameTable, $renderAll, $at_id, $list);
                $list = count($result['ids']) > 0 ? $result : $list;
            }
            if($item->type == 'table' && $item->name == $nameTable){
                foreach ($item->filas as $index => $fila) {
                    if($index == 0) continue;
                    if($fila->columns[3]->at_id != "" && $renderAll){
                        $list['ids'][] = $fila->columns[3]->at_id;
                    }
                    if($fila->columns[3]->at_id == $at_id){
                        $list['ids'][] = $at_id;
                        $list['found'] = true;
                    }
                }
            }
        }
        return $list;
    }

    private function getIdsNocturna($data, $nameTable, $renderAll, $at_id, $list = ['found' => false, 'ids' => []]){
        foreach($data as $item){
            if($item->type == 'container'){
                $result = $this->getIdsNocturna($item->items, $nameTable, $renderAll, $at_id, $list);
                $list = count($result['ids']) > 0 ? $result : $list;
            }
            if($item->type == 'table' && $item->name == $nameTable){
                foreach ($item->filas as $index => $fila) {
                    if($fila->columns[3]->at_id != "" && $renderAll){
                        $list['ids'][] = $fila->columns[3]->at_id;
                    }
                    if($fila->columns[3]->at_id == $at_id){
                        $list['ids'][] = $at_id;
                        $list['found'] = true;
                    }
                }
            }
        }
        return $list;
    }

    private function getIdsOperativo($data, $nameTable, $renderAll, $at_id, $list = ['found' => false, 'ids' => []]){
        foreach($data as $item){
            if($item->type == 'container'){
                $result = $this->getIdsOperativo($item->items, $nameTable, $renderAll, $at_id, $list);
                $list = count($result['ids']) > 0 ? $result : $list;
            }
            if($item->type == 'table' && $item->name == $nameTable){
                foreach ($item->filas as $index => $fila) {
                    if($fila->columns[2]->at_id != "" && $renderAll){
                        $list['ids'][] = $fila->columns[2]->at_id;
                    }
                    if($fila->columns[2]->at_id == $at_id){
                        $list['ids'][] = $at_id;
                        $list['found'] = true;
                    }
                }
            }
        }
        return $list;
    }

    private function generatePdfToOrdenCuerpo($data, $at_id, $oc_firma){

        $ids = $this->getIdsToRender($data, $at_id);
        $all_agents = $this->get_all_agente();

        $html = view('Administrador.AgenteTransito.Reportes.orden_cuerpo', 
        [
            'data' => $data,
            'ids' =>$ids['all'] ? [0] : $ids['ids'],
            'distrito' => $ids['distrito'],
            'turno' => $ids['turno'],
            'todo' => $ids,
            'all_agents' => $all_agents,
            'oc_firma' => $oc_firma
        ])->render();
        
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new Mpdf([
            'margin_top' => 30,
            'margin_bottom' => 30,
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
            'orientation' => 'P'
        ]);
        $mpdf->SetHTMLHeader("
            <div style='header'>
                <img src='Imagenes/manta_alcaldia.png' class='logo_alcaldia'>
                <img src='Imagenes/agentes_civiles_transito.png' class='logo_agentes'>
            </div>
        ");
        $mpdf->SetHTMLFooter("
            <div class='info_oc'>
                <img src='Imagenes/gadm_manta.png' class='img_info_oc' alt='Escudo Manta'>
            </div>
        ");
        $mpdf->SetDisplayMode('fullwidth');
        $mpdf->WriteHTML($html);
        $mpdf->debug = true;
        $mpdf->showImageErrors = true;

        return $mpdf;
    }

    public function enviar_code_qr(Request $r)
    {
        $cedula = Session::get('id_cedula');
        $code = Str::upper(Str::random(6));
        GenerateQRHelper::enviar_code_qr($cedula, $code);
        return response()->json(["res" => true, "sms" => "9999", "code" => $code]);
    }

    public function storeFirmaDocumentOC(Request $r)
    {
        $cedula = Session::get('id_cedula');
        $date = Carbon::now();
        $ip = request()->ip();
        $user = session::get('id_users');

        $codigo = DB::select('SELECT * FROM tbl_codigos_permisos WHERE co_cedula_usuario=? AND co_codigo=? AND estado = 0 ORDER BY created_at DESC LIMIT 1', [$cedula, $r->codigo]);

        if(count($codigo) == 0){
            return response()->json(["respuesta" => false, "message" => "El codigo proporcinado no es correcto"]);
        }

        $codigo = $codigo[0];

        $json[] = [
            'oc_id' => $r->oc_id,
            'oc_firma' => Session::get('apellidos') . " " . Session::get('nombres'),
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_registrar_firma_tbl_plan_orden_cuerpo(?,?,?)', [$jsoninsert, $ip, $user]);

        $this->processOC($r);

        foreach ($sql as $s) {
            $id = $s->procedimiento_registrar_firma_tbl_plan_orden_cuerpo;
        }
        if ($sql != "[]") {
            return response()->json(['respuesta' => true, "message" => "OK", "data" => $id, "sql" => $sql]);
        } else {
            return response()->json(["respuesta" => false, "message" => "Ocurrio un error en la base de datos"]);
        }
    }

    public function IndexReport()
    {
        $cl = new HomeController();
        $menus_ = $cl->GET_menus_asign();
        return view('Administrador.AgenteTransito.OrdenCuerpo.Reportes.reporte_fechas_orden_cuerpo', compact('menus_'));
    }

    public function get_lista_orden_cuerpo_filters($fecha_desde, $fecha_hasta, $estado)
    {
        $where = "";
        if($fecha_desde){
            $fecha_desde = DateTime::createFromFormat('Ymd',  $fecha_desde);
            $where .= " oc_fecha >= TO_DATE('{$fecha_desde->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($fecha_hasta && $where != ""){
            $where .= " AND";
        }
        if($fecha_hasta){
            $fecha_hasta = DateTime::createFromFormat('Ymd',  $fecha_hasta);
            $where .= " oc_fecha <= TO_DATE('{$fecha_hasta->format("d/m/Y")}', 'DD/MM/YYYY')";
        }
        if($estado != 0 && $where != ""){
            $where .= " AND";
        }
        if($estado == 1){
            $where .= " oc_firma IS NULL OR oc_firma = ''";
        }
        if($estado == 2){
            $where .= " oc_firma IS NOT NULL AND oc_firma <> ''";
        }
        $lista_orden_cuerpo = DB::Select("SELECT * FROM public.view_tbl_plan_orden_cuerpo WHERE {$where}");
        return $lista_orden_cuerpo;
    }

    public function ReportDatesOC($fecha_desde, $fecha_hasta, $estado)
    {
        return $this->get_lista_orden_cuerpo_filters($fecha_desde, $fecha_hasta, $estado);
    }

    public function ExcelReportDatesOC($fecha_desde, $fecha_hasta, $estado){

        $datos = $this->get_lista_orden_cuerpo_filters($fecha_desde, $fecha_hasta, $estado);
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

        $arrayValues = [];
        $i = 8;
        foreach ($datos as &$dato) {

            $valuesItems = json_decode($dato->oc_datos, true);
            $titleText = '';
            foreach ($valuesItems as $value) {
                if (isset($value['name']) && $value['name'] === 'title_document') {
                    $titleText = $value['text'];
                    break; // Una vez encontrado, no necesitamos seguir buscando
                }
            }

            $arrayValues[] = ['column'=>"A{$i}", 'value'=> $dato->oc_id, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"B{$i}", 'value'=> $dato->oc_fecha, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"C{$i}", 'value'=> $titleText, 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $arrayValues[] = ['column'=>"D{$i}", 'value'=> $dato->oc_firma ? 'APROBADO' : 'NO APROBADO', 'type' =>PHPExcel_Cell_DataType::TYPE_STRING];
            $i++;
        }

        $spreadsheet = ExcelHelper::ContructSpreadsheet(
            [
                ['columns'=>'A1:D1', 'value'=> '', 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A2:D2', 'value'=> "EMPRESA PUBLICA MOVILIDAD DE MANTA EP", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A3:D3', 'value'=> "REPORTE DE ORDEN DE CUERPO", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A4:D4', 'value'=> "FECHA DESDE: {$fecha_desde} || FECHA HASTA: {$fecha_hasta}", 'formato' =>ExcelHelper::GetStyleEstiloTituloReporte()],
                ['columns'=>'A5:D5', 'value'=> "Usuario: {$user} || Generado: {$fecharepo} || Hora: {$h}h{$ii}:{$s}", 'formato' =>ExcelHelper::GetStyleStyleArray()]
            ],
            [
                ['column' => 'A7', 'value' => '#'],
                ['column' => 'B7', 'value' => 'FECHA DE CREACIÓN'],
                ['column' => 'C7', 'value' => 'TITULO'],
                ['column' => 'D7', 'value' => 'ESTADO'],
            ],
            $arrayValues,
            [
                ['columns'=> 'A7:D7', 'format'=> ExcelHelper::GetStyleStyleNegrita()]
            ]
        );

        $sheet = $spreadsheet->getActiveSheet();

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
         }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORTE DE ORDEN DE CUERPO.xls"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
    }

    public function PdfReportDatesOC($fecha_desde, $fecha_hasta, $estado){
        
        $datos = $this->get_lista_orden_cuerpo_filters($fecha_desde, $fecha_hasta, $estado);
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

        foreach($datos as $dato){

            $valuesItems = json_decode($dato->oc_datos, true);
            $titleText = '';
            foreach ($valuesItems as $i) {
                if (isset($i['name']) && $i['name'] === 'title_document') {
                    $titleText = $i['text'];
                    break; // Una vez encontrado, no necesitamos seguir buscando
                }
            }
            $dato->estado = $dato->oc_firma ? 'APROBADO' : 'NO APROBADO';
            $dato->title = $titleText;
        }

        $html = view('Generico.Reports.report_table_movilidad_manta', [
            'titleReport' => 'Reporte de Certificados de Orden de cuerpo',
            'titlesHeader' => ["<span class='titulo3'>Usuario: {$user} || Fecha: {$fecha} || Hora: {$hora}</span>"],
            'titlesHeaderTable' => ["#", "FECHA DE CREACIÓN","TITULO","ESTADO"],
            "columnsTable"=> ["oc_id","oc_fecha","title","estado"],
            'items'=>$datos
        ])->render();
        $namefile = 'ReporteOrdenCuerpo_' . time() . '.pdf';
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
