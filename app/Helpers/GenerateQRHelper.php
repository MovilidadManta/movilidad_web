<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCodeQr;
use DB;

class GenerateQRHelper{

    public static function enviar_code_qr($cedula, $code)
    {
        $usuario = DB::select('select * from view_usuarios where emp_cedula = ? ', [$cedula]);
        $user = $usuario[0];

        $codigo = self::generate_code_qr($code, $cedula);

        return Mail::to($user->correo, $user->emp_nombre . " " . $user->emp_apellido)->send(new EnviarCodeQr($code));
    }


    private static function generate_code_qr($code, $cedula)
    {
        $date = Carbon::now();

        $codigo = DB::table('public.tbl_codigos_permisos')->insertGetId([
            'co_codigo' => $code,
            'co_cedula_usuario' => $cedula,
            'estado' => 0,
            'created_at' => $date
        ]);

        return $codigo;
    }
}