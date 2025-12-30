<!DOCTYPE html>
<html lang="en">
<head>
    <title>CERTIFICADO MÉDICO</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .logo_movilidad_manta{
            width: 140px;
        }
        .logo_alcaldia_manta{
            width: 210px;
            float: right;
        }
        .escudo_manta{
            position: absolute;
            top: 980px;
            right: 17px;
        }
        .firma_medico{
            position: absolute;
            top: 940px;
            left: 100px;
        }
        .firma_medico_imagen{
            width: 150px;
        }
        .footer{
            position: absolute;
            bottom: 30px;
            left: 60px;
            color: #ccc;
        }
        .logo_escudo_manta{
            width: 55px; 
        }
        .titulo_principal{
            text-align: center;
            font-size: 16px;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .row_footer{
            padding: 8px 20px 8px 0px;
            width: 25%;
            font-size: 8px;
            color: #ccc;
            font-weight: bold;
        }
        .row_footer_phone{
            width: 13%;
        }
        .row_footer_web{
            width: 22%;
        }
        .row_footer_email{
            width: 30%;
        }
        .row_footer_location{
            width: 25%;
        }
        .div_tabla_firma{
            position: absolute;
            bottom: 100px;
            left: 60px;
            width: 30%
        }
        .tabla_firma{
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .row_firma{
            width: 100%;
        }
        .row_firma_line{
            border-bottom: 1px solid #000;
        }
        .row_firma_description{
            text-align: center;
            font-size: 10px;
        }

        .content{
            margin-left: 10px;
            width: 100%;
        }

        .tabla_datos_fecha{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 5px 7px;
            margin-top: 20px;
        }
        .cell_fecha_titulo{
            text-align: center;
        }
        .cell_fecha_emision{
            text-align: center;
            width: 33.3%;
            font-weight: bold;
            font-size: 12px;
            padding: 12px;
            border-bottom: 1px solid #000;
        }
        .cell_fecha_emision_info{
            text-align: center;
            width: 33.3%;
            font-weight: bold;
            font-size: 12px;
            padding: 5px;
            border-bottom: 1px solid #000;
        }
        .div_table_fecha{
            width: 30%;
            float: right;
        }

        .tabla_diagnostico_medico{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 5px 7px;
            margin-top: 20px;
        }
        .cell_diagnostico_medico_diagnostico_title{
            text-align: center;
            width: 70%;
            font-weight: bold;
            font-size: 12px;
            padding: 12px;
            border: 1px solid #000;
        }
        .cell_diagnostico_medico_cie10_title{
            text-align: center;
            width: 30%;
            font-weight: bold;
            font-size: 12px;
            padding: 12px;
            border: 1px solid #000;
        }
        .cell_diagnostico_medico_description{
            text-align: center;
            width: 30%;
            font-size: 12px;
            padding: 12px;
            border: 1px solid #000;
        }

        .tabla_reposo_medico{
            width: 70%;
            border-collapse: collapse;
            border-spacing: 5px 7px;
            margin-bottom: 20px;
        }
        .cell_reposo_medico_title{
            text-align: center;
            width: 70%;
            font-weight: bold;
            font-size: 12px;
            padding: 12px;
            border: 1px solid #000;
            border-top: 0px;
        }
        .cell_reposo_medico_descripcion{
            text-align: center;
            width: 30%;
            font-size: 12px;
            padding: 12px;
            border: 1px solid #000;
            border-top: 0px;
        }
        .text_certifico{
            font-size: 13px;
        }
        .titulo_secundario{
            font-size: 14px;
        }
        .tabla_fecha_reposo_medico{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 5px 7px;
            margin-bottom: 20px;
        }
        .cell_fecha_reposo_medico_title{
            text-align: center;
            width: 50%;
            font-weight: bold;
            font-size: 12px;
            padding: 12px;
            border: 1px solid #000;
        }
        .cell_fecha_reposo_medico_descripcion{
            text-align: center;
            width: 50%;
            font-size: 12px;
            padding: 12px;
            border: 1px solid #000;
        }
        .cell_fecha_reposo_medico_title_titulo{
            width: 100%;
        }
    </style>
</head>

<body>
    <main>
        <header class="header">
            <img src="Imagenes/lotaip/movilidad_manta.png" class="logo_movilidad_manta" alt="Movilidad Manta" />
            <img src="Imagenes/lotaip/manta_alcaldia.png" class="logo_alcaldia_manta" alt="Alcaldia Manta" />
        </header>
        <div class="div_table_fecha">
            <table class="tabla_datos_fecha" border="1">
                <tr>
                    <td colspan="3" class="cell_fecha_titulo">FECHA DE EMISIÓN</td>
                </tr>
                <tr>
                    <td class="cell_fecha_emision">{{$dia_emision}}</td>
                    <td class="cell_fecha_emision">{{$mes_emision}}</td>
                    <td class="cell_fecha_emision">{{$anio_emision}}</td>
                </tr>
                <tr>
                    <td class="cell_fecha_emision_info">DÍA</td>
                    <td class="cell_fecha_emision_info">MES</td>
                    <td class="cell_fecha_emision_info">AÑO</td>
                </tr>
            </table>
        </div>
        <div class="content">
            <h1 class="titulo_principal">CERTIFICADO MÉDICO</h1>
            <p class="text_certifico">Certifico haber atendido a: {{$apellidos}} {{$nombres}} con número de cédula: {{$cedula}}, el cual presenta el siguiente diagnostico:</p>
            <table class="tabla_diagnostico_medico">
                <tr>
                    <td class="cell_diagnostico_medico_diagnostico_title">DIAGNÓSTICO</td>
                    <td class="cell_diagnostico_medico_cie10_title">CIE10</td>
                </tr>
                <tr>
                    <td class="cell_diagnostico_medico_description">{{$diagnostico_medico}}</td>
                    <td class="cell_diagnostico_medico_description">{{$diagnostico_cie10}}</td>
                </tr>
            </table>
            <table class="tabla_reposo_medico">
                <tr>
                    <td class="cell_reposo_medico_title">REPOSO MEDICO:</td>
                    <td class="cell_reposo_medico_descripcion">{{$tipo_certificado == 3 ?'NO':'SI'}}</td>
                </tr>
            </table>
            @if($tipo_certificado != 3)
            <table class="tabla_fecha_reposo_medico">
                <tr>
                    <td colspan="2" class="cell_fecha_reposo_medico_title cell_fecha_reposo_medico_title_titulo">
                        PERÍODO DE REPOSO
                    </td>
                </tr>
                <tr>
                    <td class="cell_fecha_reposo_medico_title">Desde</td>
                    <td class="cell_fecha_reposo_medico_title">Hasta</td>
                </tr>
                <tr>
                    <td class="cell_fecha_reposo_medico_descripcion">{{$fecha_inicio_certificado}} {{$tipo_certificado == 2 ? $hora_inicio_certificado : ''}}</td>
                    <td class="cell_fecha_reposo_medico_descripcion">{{$fecha_fin_certificado}} {{$tipo_certificado == 2 ? $hora_fin_certificado : ''}}</td>
                </tr>
            </table>
            @endif
            <h2 class="titulo_secundario">Observación:</h2>
            <p class="text_certifico">{{$observacion}}</p>
        </div>
    </main>
    <div class="div_tabla_firma">
        <table class="tabla_firma">
            <tr>
                <td class="row_firma row_firma_line"></td>
            </tr>
            <tr>
                <td class="row_firma row_firma_description">
                    {{$apellidos_firma}} {{$nombres_firma}}
                </td>
            </tr>
        </table>
    </div>
    @if($approve == 1)
    <div class="firma_medico">
        <img src="Imagenes/utilitarios/FirmaDoc.PNG" class="firma_medico_imagen" alt="Firma Medico">
    </div>
    @endif
    <div class="escudo_manta">
        <img src="Imagenes/lotaip/escudo_manta.png" class="logo_escudo_manta" alt="Escudo Manta">
    </div>
    <div class="footer">
        <table class="tabla_footer">
            <tr>
                <td class="row_footer row_footer_phone">
                    <img src="Imagenes/lotaip/phone.png" alt="phone"> 05303-7681
                </td>
                <td class="row_footer row_footer_web">
                    <img src="Imagenes/lotaip/web.png" alt="web"> http://movilidadmanta.gob.ec
                </td>
                <td class="row_footer row_footer_email">
                    <img src="Imagenes/lotaip/email.png" alt="email"> requerimiento.informacion@movilidadmanta.gob.ec
                </td>
                <td class="row_footer row_footer_location">
                    <img src="Imagenes/lotaip/ubicacion.png" alt="ubicacion"> Vía Puerto-Aeropuerto Sector El Palmar
                </td>
            </tr>
        </table>
    </div>
</body>
</html>