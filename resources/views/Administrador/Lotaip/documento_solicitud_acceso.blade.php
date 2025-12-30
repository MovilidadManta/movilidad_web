<!DOCTYPE html>
<html lang="en">

<?php
    $url = "http://192.168.0.105:8000/";
?>

<head>
    <title>SOLICITUD ACCESO A LA INFORMACION PUBLICA</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .header{
        }
        .logo_movilidad_manta{
            width: 140px;
        }
        .logo_alcaldia_manta{
            width: 210px;
            float: right;
        }
        .barra{
            width: 6px;
            height: 960px;
            background-color: #4cacc4 ;
            position: absolute;
            right: 40px;
            top: 0;
        }
        .escudo_manta{
            position: absolute;
            top: 980px;
            right: 17px;
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
        .titulo_secundario{
            font-size: 12px;
        }
        .content{
            margin-left: 10px;
        }
        .tabla_datos_empresa{
            width: 75%;
            border-collapse: separate;
            border-spacing: 0px 7px;
        }
        .text-descripcion{
            text-align: center;
            width: 100%;
        }
        .title-table{
            padding: 8px 20px 8px 0px;
            width: 40%;
            font-weight: bold;
            font-size: 12px;
        }
        .tabla_datos_solicitante{
            width: 80%;
            border-collapse: separate;
            border-spacing: 5px 7px;
        }
        .row_solicitante{
            padding: 8px 20px 8px 0px;
            width: 31%;
            font-size: 12px;
        }
        .row_solicitante_title{
            width: 19%;
        }
        .label_apellido{
            text-align: center;
        }
        .row_solicitante_2{
            width: 65%;
        }
        .row_solicitante_title_2{
            width: 35%;
        }
        .tabla_formas_recepcion{
            width: 60%;
            border-collapse: separate;
            border-spacing: 5px 7px;
        }
        .row_recepcion{
            padding: 8px 20px 8px 0px;
            width: 30%;
            font-size: 12px;
        }
        .row_recepcion_title{
            width: 70%;
        }
        .tabla_formas_recepcion_2{
            width: 60%;
            border-collapse: separate;
            border-spacing: 5px 7px;
        }
        .row_recepcion_2{
            padding: 8px 20px 8px 0px;
            width: 70%;
            font-size: 12px;
        }
        .row_recepcion_2_title{
            width: 30%;
        }
        .tabla_formato_entrega{
            width: 60%;
            border-collapse: separate;
            border-spacing: 5px 7px;
        }
        .row_entrega{
            padding: 8px 20px 8px 0px;
            width: 30%;
            font-size: 12px;
        }
        .row_entrega_title{
            width: 70%;
        }
        .tabla_tipo_entrega{
            width: 80%;
            border-collapse: separate;
            border-spacing: 5px 7px;
        }
        .row_tipo_entrega{
            padding: 8px 20px 8px 0px;
            width: 10%;
            font-size: 12px;
        }
        .row_tipo_entrega_title{
            width: 10%;
        }
        .row_tipo_entrega_observacion{
            width: 80%;
        }
        .tabla_tipo_entrega{
            width: 80%;
            border-collapse: separate;
            border-spacing: 5px 7px;
            margin-left: auto;
            margin-right: auto;
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
        .td-info{
            border: 1px solid #000; 
            text-align: center;
            font-size: 12px;
        }
        .peticion_concreta{
            border: 1px solid #000;
            font-size: 12px;
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <div class="barra">
    </div>
    <main>
        <header class="header">
            <img src="Imagenes/lotaip/movilidad_manta.png" class="logo_movilidad_manta" alt="Movilidad Manta" />
            <img src="Imagenes/lotaip/manta_alcaldia.png" class="logo_alcaldia_manta" alt="Alcaldia Manta" />
        </header>
        <div class="content">
            <h1 class="titulo_principal">SOLICITUD DE ACCESO A LA INFORMACIÓN PÚBLICA</h1>
            <div class="content">
                <table class="tabla_datos_empresa">
                    <tr>
                        <td class="title-table">Fecha:</td>
                        <td class="td-info">
                            {{date("Y-m-d")}}
                        </td>
                    </tr>
                    <tr>
                        <td class="title-table">Ciudad:</td>
                        <td class="td-info">
                            {{$city}}
                        </td>
                    </tr>
                    <tr>
                        <td class="title-table">Institución:</td>
                        <td class="td-info">
                            {{$institution}}
                        </td>
                    </tr>
                    <tr>
                        <td class="title-table">Autoridad:</td>
                        <td class="td-info">
                            {{$authority}}
                        </td>
                    </tr>
                </table>
                <h2 class="titulo_secundario">IDENTIFICACIÓN DEL SOLICITANTE</h2>
                <table class="tabla_datos_solicitante">
                    <tr>
                        <td class="row_solicitante row_solicitante_title">Nombre:</td>
                        <td class="row_solicitante td-info">
                            {{$nombre}}
                        </td>
                        <td class="row_solicitante row_solicitante_title label_apellido">Apellido:</td>
                        <td class="row_solicitante td-info">
                            {{$apellido}}
                        </td>
                    </tr>
                    <tr>
                        <td class="row_solicitante row_solicitante_title">Cédula No.</td>
                        <td class="row_solicitante td-info">
                            {{$cedula}}
                        </td>
                    </tr>
                </table>
                <table class="tabla_datos_solicitante">
                    <tr>
                        <td class="row_solicitante row_solicitante_2 row_solicitante_title row_solicitante_title_2">Dirección domiciliaria: </td>
                        <td class="row_solicitante row_solicitante_2 td-info">
                            {{$direccion}}
                        </td>
                    </tr>
                    <tr>
                        <td class="row_solicitante row_solicitante_2 row_solicitante_title row_solicitante_title_2">Teléfono (fijo o celular)</td>
                        <td class="row_solicitante row_solicitante_2 td-info">
                            {{$telefono}}
                        </td>
                    </tr>
                </table>
                <h2 class="titulo_secundario">PETICIÓN CONCRETA:</h2>
                <div class="peticion_concreta">
                    {{$peticion}}
                </div>
                <h2 class="titulo_secundario">FORMA DE RECEPCIÓN DE LA INFORMACIÓN SOLICITADA:</h2>
                <table class="tabla_formas_recepcion">
                    <tr>
                        <td class="row_recepcion row_recepcion_title">Retiro de la información en la institución: </td>
                        <td class="row_recepcion td-info">
                            {{$forma_recepcion == 1? 'X' : ''}}
                        </td>
                    </tr>
                </table>
                <table class="tabla_formas_recepcion_2">
                    <tr>
                        <td class="row_recepcion_2 row_recepcion_2_title">Email: </td>
                        <td class="row_recepcion_2 td-info">
                            {{$email}}
                        </td>
                    </tr>
                </table>
                <h2 class="titulo_secundario">FORMATO DE ENTREGA</h2>
                <table class="tabla_formato_entrega">
                    <tr>
                        <td class="row_entrega row_entrega_title">Copia en papel: </td>
                        <td class="row_entrega td-info">
                            {{$formato_entrega == 1? 'X' : ''}}
                        </td>
                    </tr>
                    <tr>
                        <td class="row_entrega row_entrega_title">CD: </td>
                        <td class="row_entrega td-info">
                            {{$formato_entrega == 2? 'X' : ''}}
                        </td>
                    </tr>
                    <tr>
                        <td class="row_entrega row_entrega_title">Formato electrónico digital: </td>
                        <td class="row_entrega td-info">
                            {{$formato_entrega == 3? 'X' : ''}}
                        </td>
                    </tr>
                </table>
                @if ($formato_entrega == 3)
                    <table class="tabla_tipo_entrega">
                        @if ($formato_digital == 1)
                        <tr>
                            <td class="row_tipo_entrega row_tipo_entrega_title">PDF </td>
                            <td class="row_tipo_entrega td-info">
                                X
                            </td>
                            <td class="row_tipo_entrega row_tipo_entrega_observacion"></td>
                        </tr>
                        @endif
                        @if ($formato_digital == 2)
                        <tr>
                            <td class="row_tipo_entrega row_tipo_entrega_title">Word </td>
                            <td class="row_tipo_entrega td-info">
                                X
                            </td>
                            <td class="row_tipo_entrega row_tipo_entrega_observacion"></td>
                        </tr>
                        @endif
                        @if ($formato_digital == 3)
                        <tr>
                            <td class="row_tipo_entrega row_tipo_entrega_title">Excel </td>
                            <td class="row_tipo_entrega td-info">
                                X
                            </td>
                            <td class="row_tipo_entrega row_tipo_entrega_observacion"></td>
                        </tr>
                        @endif
                        @if ($formato_digital == 4)
                        <tr>
                            <td class="row_tipo_entrega row_tipo_entrega_title">Otros </td>
                            <td class="row_tipo_entrega td-info">
                                X
                            </td>
                            <td class="row_tipo_entrega row_tipo_entrega_observacion td-info">
                                {{$especificacion_otros}}
                            </td>
                        </tr>
                        @endif
                    </table>
                @endif
            </div>
        </div>
    </main>
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