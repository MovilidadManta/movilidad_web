<?php

namespace App\Helpers;

use Mpdf\Mpdf;
use Illuminate\Support\Facades\Log;

class ReducePdfHelper{


    public static function reduce($nombre_archivo_parte, $ruta_archivo, $inicio, $fin)
    {

        // Comando de Ghostscript para comprimir el PDF
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $gsCommand = sprintf(
                'gswin64c -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dDownsampleColorImages=true -dColorImageResolution=115 -dDownsampleGrayImages=true -dGrayImageResolution=150 -dDownsampleMonoImages=true -dMonoImageResolution=300 -dNOPAUSE -dBATCH -dQUIET -dFirstPage=%d -dLastPage=%d -sOutputFile=%s %s',
                $inicio,
                $fin,
                escapeshellarg($nombre_archivo_parte),
                escapeshellarg($ruta_archivo)
            );
        } else {
            $gsCommand = sprintf(
                'gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/screen -dDownsampleColorImages=true -dColorImageResolution=115 -dDownsampleGrayImages=true -dGrayImageResolution=150 -dDownsampleMonoImages=true -dMonoImageResolution=300 -dNOPAUSE -dBATCH -dQUIET -dFirstPage=%d -dLastPage=%d -sOutputFile=%s %s',
                $inicio,
                $fin,
                escapeshellarg($nombre_archivo_parte),
                escapeshellarg($ruta_archivo)
            );
        }
        
        // Ejecutar el comando Ghostscript
        exec($gsCommand, $output, $return_var);
        // Después de ejecutar el comando
        $logMessage = sprintf("Comando ejecutado: %s\n", $gsCommand);
        $logMessage .= sprintf("Salida: %s\n", implode("\n", $output));
        $logMessage .= sprintf("Código de retorno: %d\n", $return_var);

        // Registrar en el archivo de log de Laravel con nivel debug
        Log::debug($logMessage);

        return $return_var;
    }

    public static function combine($ruta_salida, $nameFolderTemp)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $gsCombineCommand = sprintf(
                'gswin64c -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=%s %s',
                $ruta_salida,
                $nameFolderTemp . '*.pdf'
            );
        } else {
            $gsCombineCommand = sprintf(
                'gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=%s %s',
                $ruta_salida,
                $nameFolderTemp . '*.pdf'
            );
        }
        
        // Ejecutar el comando Ghostscript para combinar las partes
        exec($gsCombineCommand, $output, $return_var);
        $logMessage = sprintf("Comando ejecutado: %s\n", $gsCombineCommand);
        $logMessage .= sprintf("Salida: %s\n", implode("\n", $output));
        $logMessage .= sprintf("Código de retorno: %d\n", $return_var);

        // Registrar en el archivo de log de Laravel con nivel debug
        Log::debug($logMessage);

        return $return_var;
    }
}