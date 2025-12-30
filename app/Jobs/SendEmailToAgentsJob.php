<?php

namespace App\Jobs;

use DB;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\ReducePdfHelper;
use Illuminate\Support\Facades\Http;
use Storage;
use Illuminate\Support\Str;
use Mail;
use Mpdf\Mpdf;
use File;

class SendEmailToAgentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orden_cuerpo;
    protected $ruta_archivo;
    protected $ip;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orden_cuerpo, $ruta_archivo, $ip, $user)
    {
        $this->orden_cuerpo = $orden_cuerpo;
        $this->ruta_archivo = $ruta_archivo;
        $this->ip = $ip;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->get_send_email($this->orden_cuerpo);

        if(count($email) == 0){

            $correo_emp = "joaquin.flores@movilidadmanta.gob.ec";

            Mail::send(
                'Administrador.AgenteTransito.OrdenCuerpo.Correo.view_correo_orden_cuerpo',
                array(
                    'orden_cuerpo' => $this->orden_cuerpo,
                    'intranet' => env('API_REST_INTRANET')
                ),
                function ($msj) use ($correo_emp) {
                    $msj->subject('ASIGNACION DE ORDEN DE CUERPO');
                    $msj->from('movilidadmanta@gmail.com');
                    $msj->to($correo_emp);
                }
            );
            
            return;
        }

        $email = $email[0];

        $datos_agente = $this->get_agente_id($email->id_related);
        $nombrearchivo = "orden_cuerpo_" . $this->orden_cuerpo . '_' . $datos_agente->at_id . '.PDF';
        $ruta = public_path($this->ruta_archivo . $nombrearchivo);
        $boolUpdate = FALSE;
        $messageUpdate = "";

        $response = Http::get("http://sgi-web/orden_cuerpo/show_pdf_orden_cuerpo/{$this->orden_cuerpo}/{$datos_agente->at_id}");

        try {

            if ($response->successful()) {
                $pdfContent = $response->body();
                Storage::put($nombrearchivo, $pdfContent);

                Storage::disk('ftp_movilidad')->put("/ftpagentes/" . $nombrearchivo, Storage::get($nombrearchivo));
                
                Storage::delete($nombrearchivo);

                $boolUpdate = TRUE;
            }
            else {
                $messageUpdate = "Error al descargar el PDF";
            }
        } catch (RequestException $e) {
            $messageUpdate = $e->getMessage();
        } catch (Exception $e) {
            $messageUpdate = $e->getMessage();
        }

        $this->update_state_email($email->e_id, $boolUpdate, $messageUpdate, $this->ip, $this->user);
        dispatch(new self($this->orden_cuerpo, $this->ruta_archivo, $this->ip, $this->user));
    }

    private function get_send_email($id_primary)
    {
        $sql = DB::Select("SELECT * FROM public.tbl_send_emails WHERE id_primary = {$id_primary} AND e_attempts < 3 AND e_sent = FALSE LIMIT 1");

        return $sql;
    }

    private function update_state_email($e_id, $sent, $message, $ip, $user){
        $json[] = [
            'e_id' => $e_id,
            'sent' => $sent,
            'message' => $message
        ];
        $jsoninsert = json_encode($json);
        $sql = DB::Select('select public.procedimiento_update_tbl_send_emails_oc(?,?,?)', [$jsoninsert, $ip, $user]);
        foreach ($sql as $s) {
            $id = $s->procedimiento_update_tbl_send_emails_oc;
        }
        return $id;
    }

    private function get_agente_id($id)
    {
        $sql = DB::Select("SELECT * FROM public.view_tbl_cod_agentes_transito WHERE at_id = {$id}");

        return $sql[0];
    }
}