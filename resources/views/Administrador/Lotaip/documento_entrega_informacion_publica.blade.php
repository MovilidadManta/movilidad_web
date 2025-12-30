<!DOCTYPE html>
<html lang="en">
<head>
    <title>ENTREGA DE INFORMACIÓN PÚBLICA</title>
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
        .tabla_datos_solicitante{
            width: 80%;
            border-collapse: separate;
            border-spacing: 0px 7px;
        }
        .text-descripcion{
            text-align: center;
            width: 100%;
        }
        .title-table{
            padding: 8px 20px 8px 0px;
            width: 45%;
            font-weight: bold;
            font-size: 12px;
        }
        .tabla_datos_solicitante{
            width: 80%;
            border-collapse: separate;
            border-spacing: 5px 7px;
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
        .tabla_questions{
            width: 60%;
            border-collapse: separate;
            border-spacing: 5px 7px;
        }
        .row_questions{
            padding: 8px 20px 8px 0px;
            width: 25%;
            font-size: 12px;
            font-weight: bold;
        }
        .row_questions_title{
            width: 60%;
        }
        .row_question_cell{
            width: 10%;
        }
        .row_question_option{
            width: 10%;
            padding-left: 20px; 
        }
        .tabla_observation{
            width: 100%;
            border-collapse: collapse;
        }
        .row_observacion{
            padding: 12px;
            border-bottom: 1px solid #000;
        }
        .formato_digital_p{
            font-size: 12px;
        }
        .tabla_medios_digitales{
            width: 100%;
            border-collapse: separate;
            border-spacing: 5px 7px;
        }
        .row_medios_digitales{
            padding: 8px 20px 8px 0px;
            width: 8%;
            font-size: 12px;
        }
        .row_medios_digitales_descripcion{
            width: 9%;
        }
        .row_medios_digitales_blanco{
            width: 8%;
        }
        .row_medios_digitales_opcion{
           padding-left: 12px; 
        }
        .tabla_firma{
            margin-top: 140px; 
            width: 35%;
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
            padding-left: 65px; 
        }
    </style>
</head>

<body>
    <main>
        <header class="header">
            <img src="Imagenes/lotaip/movilidad_manta.png" class="logo_movilidad_manta" alt="Movilidad Manta" />
            <img src="Imagenes/lotaip/manta_alcaldia.png" class="logo_alcaldia_manta" alt="Alcaldia Manta" />
        </header>
        <div class="content">
            <h1 class="titulo_principal">ENTREGA DE INFORMACIÓN PÚBLICA MEDIANTE ACCESO A LA INFORMACIÓN (LOTAIP)</h1>
            <div class="content">
                <table class="tabla_datos_solicitante">
                    <tr>
                        <td class="title-table">Número de Solicitud:</td>
                        <td class="td-info">
                            {{$numero_solicitud}}
                        </td>
                    </tr>
                    <tr>
                        <td class="title-table">Nombres y Apellidos:</td>
                        <td class="td-info">
                            {{$nombres}} {{$apellidos}}
                        </td>
                    </tr>
                    <tr>
                        <td class="title-table">Identificación del solicitante:</td>
                        <td class="td-info">
                            {{$cedula}}
                        </td>
                    </tr>
                    <tr>
                        <td class="title-table">Fecha de recepción:</td>
                        <td class="td-info">
                            {{$fecha_recepcion}}
                        </td>
                    </tr>
                    <tr>
                        <td class="title-table">Dirección Domiciliaria:</td>
                        <td class="td-info">
                            {{$direccion}}
                        </td>
                    </tr>
                </table>
                <h2 class="titulo_secundario">PETICIÓN CONCRETA:</h2>
                <div class="peticion_concreta">
                    {{$peticion}}
                </div>
                <table class="tabla_questions">
                    <tr>
                        <td class="row_questions row_questions_title">¿Se entregó la información?: </td>
                        <td class="row_questions row_question_option">
                            Si
                        </td>
                        <td class="row_questions row_question_cell td-info">
                            
                        </td>
                        <td class="row_questions row_question_option">
                            No
                        </td>
                        <td class="row_questions row_question_cell td-info">
                            
                        </td>
                    </tr>
                    <tr>
                        <td class="row_questions row_questions_title">¿Se utilizo prorroga?: </td>
                        <td class="row_questions row_question_option">
                            Si
                        </td>
                        <td class="row_questions row_question_cell td-info">
                            
                        </td>
                        <td class="row_questions row_question_option">
                            No
                        </td>
                        <td class="row_questions row_question_cell td-info">
                            
                        </td>
                    </tr>
                </table>
                <h2 class="titulo_secundario">Observaciones*</h2>
                <table class="tabla_observation">
                    <tr>
                        <td class="row_observacion"></td>
                    </tr>
                    <tr>
                        <td class="row_observacion"></td>
                    </tr>
                    <tr>
                        <td class="row_observacion"></td>
                    </tr>
                </table>
                <h2 class="titulo_secundario">FORMA DE ENTREGA DE LA INFORMACIÓN SOLICITADA:</h2>
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
                @if ($formato_entrega == 1 || $formato_entrega == 2)
                    <p class="formato_digital_p">Formato de entrega:</p>
                    <p class="formato_digital_p">{{$formato_entrega == 1 ? 'Copia en papel' : 'CD'}}</p>
                @endif
                @if ($formato_entrega == 3)
                    <p class="formato_digital_p">Formato electrónico digital:</p>
                    <table class="tabla_medios_digitales">
                        <tr>
                            <td class="row_medios_digitales row_medios_digitales_descripcion">PDF</td>
                            <td class="row_medios_digitales row_medios_digitales_opcion td-info">
                                {{$formato_digital == 1 ? 'X' : ''}}
                            </td>
                            <td class="row_medios_digitales row_medios_digitales_blaco">
                            </td>
                            <td class="row_medios_digitales row_medios_digitales_descripcion">Word</td>
                            <td class="row_medios_digitales row_medios_digitales_opcion td-info">
                                {{$formato_digital == 2 ? 'X' : ''}}
                            </td>
                            <td class="row_medios_digitales row_medios_digitales_blaco">
                            </td>
                            <td class="row_medios_digitales row_medios_digitales_descripcion">Excel</td>
                            <td class="row_medios_digitales row_medios_digitales_opcion td-info">
                                {{$formato_digital == 3 ? 'X' : ''}}
                            </td>
                            <td class="row_medios_digitales row_medios_digitales_blaco">
                            </td>
                            <td class="row_medios_digitales row_medios_digitales_descripcion">Otros</td>
                            <td class="row_medios_digitales row_medios_digitales_opcion td-info">
                                {{$formato_digital == 4 ? 'X' : ''}}
                            </td>
                            <td class="row_medios_digitales row_medios_digitales_blaco">
                            </td>
                        </tr>
                    </table>
                @endif
                <table class="tabla_firma">
                    <tr>
                        <td class="row_firma row_firma_line"></td>
                    </tr>
                    <tr>
                        <td class="row_firma row_firma_description">
                            Firma del solicitante
                        </td>
                    </tr>
                    <tr>
                        <td class="row_firma">
                            CI:
                        </td>
                    </tr>
                </table>
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