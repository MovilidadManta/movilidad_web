<?php

namespace App\Helpers;

use DateTime;

class DatesHelper{


    public static function FechaATexto($formato, $fecha)
    {
        $date = DateTime::createFromFormat($formato, $fecha);
        $splitFecha = explode("-",$date->format("d-m-Y"));
        $dia = $splitFecha[0];
        $mes = $splitFecha[1];
        $anio = $splitFecha[2];
        $mesLetra = "";

        switch (intval($mes)) {
            case 1:
                $mesLetra = "Enero";
                break;
            case 2:
                $mesLetra = "Febrero";
                break;
            case 3:
                $mesLetra = "Marzo";
                break;
            case 4:
                $mesLetra = "Abril";
                break;
            case 5:
                $mesLetra = "Mayo";
                break;
            case 6:
                $mesLetra = "Junio";
                break;
            case 7:
                $mesLetra = "Julio";
                break;
            case 8:
                $mesLetra = "Agosto";
                break;
            case 9:
                $mesLetra = "Septiembre";
                break;
            case 10:
                $mesLetra = "Octubre";
                break;
            case 11:
                $mesLetra = "Noviembre";
                break;
            case 12:
                $mesLetra = "Diciembre";
                break;
        }

        return "{$dia} de {$mesLetra} del {$anio}";
    }
}