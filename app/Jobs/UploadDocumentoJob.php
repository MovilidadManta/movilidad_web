<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\ReducePdfHelper;
use Storage;

class UploadDocumentoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $carpetaTemp;
    protected $rutaArchivo;
    protected $rutaFinalSftp;
    protected $nameFolderFileCompress;
    protected $nombreArchivoParte;
    protected $inicio;
    protected $fin;
    protected $numeros_archivos;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($carpetaTemp, $rutaArchivo, $rutaFinalSftp, $nameFolderFileCompress, $nombreArchivoParte, $inicio, $fin, $numeros_archivos)
    {
        $this->carpetaTemp = $carpetaTemp;
        $this->rutaArchivo = $rutaArchivo;
        $this->rutaFinalSftp = $rutaFinalSftp;
        $this->nameFolderFileCompress = $nameFolderFileCompress;
        $this->nombreArchivoParte = $nombreArchivoParte;
        $this->inicio = $inicio;
        $this->fin = $fin;
        $this->numeros_archivos = $numeros_archivos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $return_var = ReducePdfHelper::reduce($this->nombreArchivoParte, $this->rutaArchivo, $this->inicio, $this->fin);

        if($this->scanPDFFiles($this->carpetaTemp) >= $this->numeros_archivos){
            ReducePdfHelper::combine($this->nameFolderFileCompress, $this->carpetaTemp . '/');
            $compressedContent = file_get_contents($this->nameFolderFileCompress);
            Storage::disk('ftp_movilidad')->put('/ftparchivo' . $this->rutaFinalSftp , $compressedContent);
            // Eliminar el archivo temporal
            $this->eliminarDirectorio($this->carpetaTemp . '/');
            unlink($this->rutaArchivo);
            unlink($this->nameFolderFileCompress);
        } 
    }

    private function eliminarDirectorio($carpeta) {
        if (!file_exists($carpeta)) {
            return false;
        }
        
        // Eliminar archivos dentro de la carpeta
        $archivos = glob($carpeta . '/*');
        foreach ($archivos as $archivo) {
            if (is_file($archivo)) {
                unlink($archivo);
            } elseif (is_dir($archivo)) {
                eliminarDirectorio($archivo);
            }
        }
        
        // Eliminar la carpeta
        return rmdir($carpeta);
    }

    private function scanPDFFiles($ruta){
        $archivos = scandir($ruta);
        $total_archivos_pdf = 0;

        foreach ($archivos as $archivo) {
            // Verificar si el archivo es un archivo regular y tiene la extensión .pdf
            if (is_file($ruta . '/' . $archivo) && pathinfo($archivo, PATHINFO_EXTENSION) == 'pdf') {
                $total_archivos_pdf++;
            }
        }

        return $total_archivos_pdf;
    }
}
