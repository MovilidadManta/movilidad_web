<!DOCTYPE html>
<html lang="en">

<head>
    <title>ACCION DE PERSONAL</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            margin: 8mm;
        }

        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .logo_movilidad_manta {
            width: 140px;
        }

        .border_body {
            border: 1px solid #000;
        }

        main {
            margin-top: 30px;
        }

        .titulo_situacion {
            font-size: 10px;
            font-weight: bold;
            text-align: center;
        }

        .table_header {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 5px 7px;
        }

        .header_table_title_logo {
            text-align: center;
            width: 20%;
        }

        .header_table_title_header {
            font-weight: bold;
            font-size: 16px;
            width: 50%;
            text-align: center;
        }

        .header_table_title_data {
            width: 30%;
            text-align: right;
            font-size: 11px;
            border-left: 1px solid black;
        }

        .text_bold {
            font-weight: bold;
        }

        .table_tipo_accion_personal_div {
            margin-bottom: 20px;
        }

        .table_tipo_accion_personal {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 5px 7px;
        }

        .table_tipo_accion_personal_opcion {
            width: 25%;
            font-size: 11px;
        }

        .cuadrado_seleccion {
            font-size: 20px;
        }

        .cuadrado_con_x {
            width: 10px;
        }

        .table_datos_empleado {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 5px 7px;
            font-size: 10px;
        }

        .table_datos_empleado td {
            border: 1px solid #000;
        }

        .table_datos_empleado--nombre {
            text-align: center;
            width: 50%;
        }

        .table_datos_empleado--otros_datos {
            text-align: center;
            width: 33%;
        }

        .table_datos_empleado--otros_datos_header {
            font-size: 10px;
        }

        .table_datos_accion_personal_div {
            margin-bottom: 20px;
        }

        .table_datos_accion_personal {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 5px 7px;
            font-size: 10px;
        }

        .table_datos_accion_personal--no {
            width: 3%;
        }

        .table_datos_accion_personal--no_line {
            width: 30%;
            border-bottom: 1px solid #000;
        }

        .table_datos_accion_personal--space_blank {
            width: 33%;
        }

        .table_datos_accion_personal--date {
            width: 3%;
        }

        .table_datos_accion_personal--date_line {
            width: 30%;
            border-bottom: 1px solid #000;
        }

        .table_datos_empleado_div {
            margin-bottom: 20px;
        }

        .text-accion-div {
            margin-bottom: 10px;
            font-size: 10px;
            border-bottom: 1px solid #000;
        }

        .table_datos_tipo_accion_div {
            border-bottom: 1px solid #000;
        }

        .table_opciones_accion {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 3px 5px;
            font-size: 10px;
        }

        .table_opciones_accion--opcion {
            width: 20%;
        }

        .table_opciones_accion--check {
            width: 5%;
            text-align: center;
        }

        .datos_situacion_actual {
            width: 50%;
            float: left;
        }

        .datos_situacion_propuesta {
            width: 49%;
            float: right;
            border-left: 1px solid black;
        }

        .table_situacion_actual {
            width: 100%;
            border-collapse: separate;
            font-size: 10px;
        }

        .table_situacion_actual--title {
            width: 40%;
            padding: 5px 0;
        }

        .table_situacion_actual--borde {
            width: 60%;
            border-bottom: 1px solid #000;
            text-align: center;
        }

        .table_situacion_propuesta {
            width: 100%;
            border-collapse: separate;
            font-size: 10px;
            margin-bottom: 5px;
        }

        .table_situacion_propuesta--title {
            width: 42%;
            padding: 5px 0;
        }

        .table_situacion_propuesta--borde {
            width: 58%;
            border-bottom: 1px solid #000;
            text-align: center;
        }

        .datos_acta_final_concurso {
            width: 50%;
            float: left;
        }

        .datos_proceso_talento_humano {
            width: 49%;
            float: right;
            border-left: 1px solid black;
        }

        .table_acta_final_concurso {
            width: 100%;
            font-size: 10px;
        }

        .table_proceso_talento_humano {
            width: 100%;
            border-collapse: separate;
            font-size: 10px;
        }

        .table_acta_final_concurso--nro {
            width: 10%;
        }

        .table_acta_final_concurso--nro_borde {
            width: 40%;
            border-bottom: 1px solid #000;
        }

        .table_acta_final_concurso--fecha {
            width: 10%;
        }

        .table_acta_final_concurso--fecha_borde {
            width: 40%;
            border-bottom: 1px solid #000;
        }

        .table_proceso_talento_humano--firma {
            width: 10%;
            text-align: right;
        }

        .table_proceso_talento_humano--borde_firma {
            width: 80%;
            border-bottom: 1px solid #000;
        }

        .table_proceso_talento_humano--blank {
            width: 10%;
        }

        .table_proceso_talento_humano--text_firma {
            text-align: center;
        }

        .titulo_dios_patria_libertad {
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            width: 100%;
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
        }

        .datos_fima_autoridad_delegada {
            margin-bottom: 10px;
        }

        .table_firma_autoridad_delegada {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 3px 5px;
            font-size: 10px;
        }

        .table_firma_autoridad_delegada--blanco {
            width: 30%;
        }

        .table_firma_autoridad_delegada--datos {
            width: 40%;
            text-align: center;
        }

        .firma_talento_humano {
            width: 50%;
            float: left;
        }

        .firma_recibido {
            width: 50%;
            float: right;
        }

        .table_firma_talento_humano {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 3px 5px;
            font-size: 10px;
        }

        .table_firma_recibido {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 3px 5px;
            font-size: 10px;
        }

        .table_firma_talento_humano--nro {
            width: 10%;
        }

        .table_firma_talento_humano--borde {
            width: 40%;
            border-bottom: 1px solid #000;
            text-align: center;
        }

        .table_firma_talento_humano--fecha {
            width: 10%;
        }

        .table_firma_recibido--blanco {
            width: 20%;
        }

        .table_firma_recibido--firma {
            width: 60%;
        }

        .table_firma_talento_humano {
            margin-top: 30px;
        }

        .table_firma_recibido {
            margin-top: 30px;
        }

        .table_firma_talento_humano--firma_sufijo {
            text-align: center;
        }

        .table_firma_recibido--firma_sufijo {
            text-align: center;
        }

        .div_space_blank {
            padding: 6px;
        }

        .table_header_div {
            border: 1px solid black;
        }

        .contenedor_situacion {
            border-bottom: 1px solid #000;
        }

        .container_firmas_acta {
            border-bottom: 1px solid #000;
        }

        .container_firma_talento_humano {
            border-top: 1px solid #000;
        }
    </style>
</head>

<body>
    <div class="border_body">
        <header class="header">
            <div class="table_header_div">
                <table class="table_header">
                    <tr>
                        <td class="header_table_title_logo">
                            <img src="Imagenes/lotaip/movilidad_manta.png" class="logo_movilidad_manta"
                                alt="Movilidad Manta" />
                        </td>
                        <td class="header_table_title_header">EMPRESA PÚBLICA MUNICIPAL MOVILIDAD DE MANTA-EP</td>
                        <td class="header_table_title_data">
                            <p><span class="text_bold">ACCION DE PERSONAL</span></p>
                            <p><span class="text_bold">No.</span> {{$secuencial}}</p>
                            <p><span class="text_bold">Fecha:</span> {{$fecha_accion}}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </header>
        <main>
            <div class="table_tipo_accion_personal_div">
                <table class="table_tipo_accion_personal">
                    <tr>
                        <td class="table_tipo_accion_personal_opcion">
                            DECRETO <span class="cuadrado_seleccion">&#9633;</span>
                        </td>
                        <td class="table_tipo_accion_personal_opcion">
                            ACUERDO <span class="cuadrado_seleccion">&#9633;</span>
                        </td>
                        <td class="table_tipo_accion_personal_opcion">
                            RESOLUCION <img src="Imagenes/cuadradoconx.png" class="cuadrado_con_x"
                                alt="Cuadrado con x" />
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table_datos_accion_personal_div">
                <table class="table_datos_accion_personal">
                    <tr>
                        <td class="table_datos_accion_personal--no">
                            NO.
                        </td>
                        <td class="table_datos_accion_personal--no_line">

                        </td>
                        <td class="table_datos_accion_personal--space_blank">

                        </td>
                        <td class="table_datos_accion_personal--date">
                            FECHA:
                        </td>
                        <td class="table_datos_accion_personal--date_line">

                        </td>
                    </tr>
                </table>
            </div>
            <div class="table_datos_empleado_div">
                <table class="table_datos_empleado">
                    <tr>
                        <td class="table_datos_empleado--nombre" colspan="3">
                            <p><span class="text_bold">{{strtoupper($apellidos_empleado)}}</span></p>
                            <p>APELLIDOS</p>
                        </td>
                        <td class="table_datos_empleado--nombre" colspan="3">
                            <p><span class="text_bold">{{strtoupper($nombres_empleado)}}</span></p>
                            <p>NOMBRES</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="table_datos_empleado--otros_datos table_datos_empleado--otros_datos_header"
                            colspan="2">
                            No. de Cédula de Ciudadania
                        </td>
                        <td class="table_datos_empleado--otros_datos table_datos_empleado--otros_datos_header"
                            colspan="2">
                            No. De Afiliación IESS
                        </td>
                        <td class="table_datos_empleado--otros_datos table_datos_empleado--otros_datos_header"
                            colspan="2">
                            Rige a partir de:
                        </td>
                    </tr>
                    <tr>
                        <td class="table_datos_empleado--otros_datos" colspan="2">
                            {{$cedula_empleado}}
                        </td>
                        <td class="table_datos_empleado--otros_datos" colspan="2">

                        </td>
                        <td class="table_datos_empleado--otros_datos" colspan="2">
                            {{$fecha_accion_personal}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="text-accion-div">
                <p>Explicación: (Opcioncal: Adjuntar Anexo)</p>
                <p>
                    Con Memorando MMEP-GGE-MEM-150120241512, el Gerente General Lcdo Gabriel German Alarcon Zambrano,
                    dispone aprobar dos días de vacaciones al Ing. Jimmy Piloso Rodríguez, Director de Talento Humano,
                    atendiendo solicito mediante memorando MEMORANDO MMEP-DTH-MEM-110120241701, de fecha 15 de enero de
                    2024. En relación a lo expuesto y de acuero a lo establecido en la Ley Orgánica de Empresas Públicas
                    (en adelante LOEP), publicada en la Ley 0, del Registro Oficial Suplemento No. 48, de 16 de octubre
                    de 2009, establece en el artículo 21: SUBROGACIÓN O ENCARGO.- Cuando por disposición de la ley o por
                    orden escrita de autoridad competente, un servidor deba subrogar a superiores jerárquicos o ejercer
                    un encargo en los que perciban mayor remuneración mensual unificada, éste recibirá la diferencia de
                    la remuneración mensual unificada, obtenida entre el valor que percibe al subrogante y el valor que
                    perciba el subrogado, durante el tiempo que dure el reemplazo y a partir de la fecha en que se
                    inicia tal encargo o subrogación, sin perjuicio del derecho del titular a recibir la remuneración
                    que le corresponda . Por lo ante expuesto se emite la presente acción de personal para regularizar
                    el encargo como DIRECTORA DE TALENTO HUMANO ENCARGADA.
                </p>
            </div>
            <div class="table_datos_tipo_accion_div">
                <table class="table_opciones_accion">
                    <tr>
                        <td class="table_opciones_accion--opcion">
                            INGRESO
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "INGRESO" ? '<img src="Imagenes/cuadradoconx.png" class="cuadrado_con_x"
                                alt="Cuadrado con x" />' : '<span class="cuadrado_seleccion">&#9633;</span>' !!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            TRASLADO
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "TRASLADO" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            REVALORIZACION
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "REVALORIZACION" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            SUPRESION
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "SUPRESION" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                    </tr>
                    <tr>
                        <td class="table_opciones_accion--opcion">
                            NOMBRAMIENTO
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "NOMBRAMIENTO" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            TRASPASO
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "TRASPASO" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            RECLASIFICACION
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "RECLASIFICACION" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            DESTITUCION
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "DESTITUCION" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                    </tr>
                    <tr>
                        <td class="table_opciones_accion--opcion">
                            ASCENSO
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "ASCENSO" ? '<img src="Imagenes/cuadradoconx.png" class="cuadrado_con_x"
                                alt="Cuadrado con x" />' : '<span class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            CAMBIO ADMINISTRATIVO
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "CAMBIO ADMINISTRATIVO" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            UBICACION
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "UBICACION" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            REMOCION
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "REMOCION" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                    </tr>
                    <tr>
                        <td class="table_opciones_accion--opcion">
                            SUBROGACION
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "SUBROGACION" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            INTERCAMBIO
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "INTERCAMBIO" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            REINTEGRO
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "REINTEGRO" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            JUBILACION
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "JUBILACION" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                    </tr>
                    <tr>
                        <td class="table_opciones_accion--opcion">
                            ENCARGO
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "ENCARGO" ? '<img src="Imagenes/cuadradoconx.png" class="cuadrado_con_x"
                                alt="Cuadrado con x" />' : '<span class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            COMISION DE SERVICIOS
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "COMISION DE SERVICIOS" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            RESTITUCION
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "RESTITUCION" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion" colspan="2">
                            OTRO _________________________
                        </td>
                    </tr>
                    <tr>
                        <td class="table_opciones_accion--opcion">
                            VACACIONES
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "VACACIONES" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            LICENCIA
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "LICENCIA" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                        <td class="table_opciones_accion--opcion">
                            RENUNCIA
                        </td>
                        <td class="table_opciones_accion--check">
                            {!! $tipo_accion == "RENUNCIA" ? '<img src="Imagenes/cuadradoconx.png"
                                class="cuadrado_con_x" alt="Cuadrado con x" />' : '<span
                                class="cuadrado_seleccion">&#9633;</span>'!!}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="contenedor_situacion">
                <div class="datos_situacion_actual">
                    <h2 class="titulo_situacion">SITUACIÓN ACTUAL</h2>
                    <table class="table_situacion_actual">
                        <tr>
                            <td class="table_situacion_actual--title">EMPRESA:</td>
                            <td class="table_situacion_actual--borde">{{$empresa}}</td>
                        </tr>
                        <tr>
                            <td class="table_situacion_actual--title">DEPARTAMENTO:</td>
                            <td class="table_situacion_actual--borde">{{$departamento_empleado}}</td>
                        </tr>
                        <tr>
                            <td class="table_situacion_actual--title">PUESTO:</td>
                            <td class="table_situacion_actual--borde">{{$cargo_empleado}}</td>
                        </tr>
                        <tr>
                            <td class="table_situacion_actual--title">LUGAR DE TRABAJO:</td>
                            <td class="table_situacion_actual--borde">{{$lugar_trabajo}}</td>
                        </tr>
                        <tr>
                            <td class="table_situacion_actual--title">REMUNERACIÓN MENSUAL:</td>
                            <td class="table_situacion_actual--borde">${{$remuneracion_empleado}}</td>
                        </tr>
                        <tr>
                            <td class="table_situacion_actual--title">PARTIDA PRESUPUESTARIA:</td>
                            <td class="table_situacion_actual--borde"></td>
                        </tr>
                    </table>
                </div>
                <div class="datos_situacion_propuesta">
                    <h2 class="titulo_situacion">SITUACIÓN PROPUESTA</h2>
                    <table class="table_situacion_propuesta">
                        <tr>
                            <td class="table_situacion_propuesta--title">EMPRESA:</td>
                            <td class="table_situacion_propuesta--borde"></td>
                        </tr>
                        <tr>
                            <td class="table_situacion_propuesta--title">DEPARTAMENTO:</td>
                            <td class="table_situacion_propuesta--borde"></td>
                        </tr>
                        <tr>
                            <td class="table_situacion_propuesta--title">PUESTO:</td>
                            <td class="table_situacion_propuesta--borde"></td>
                        </tr>
                        <tr>
                            <td class="table_situacion_propuesta--title">LUGAR DE TRABAJO:</td>
                            <td class="table_situacion_propuesta--borde"></td>
                        </tr>
                        <tr>
                            <td class="table_situacion_propuesta--title">REMUNERACIÓN MENSUAL:</td>
                            <td class="table_situacion_propuesta--borde"></td>
                        </tr>
                        <tr>
                            <td class="table_situacion_propuesta--title">PARTIDA PRESUPUESTARIA:</td>
                            <td class="table_situacion_propuesta--borde"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="container_firmas_acta">
                <div class="datos_acta_final_concurso">
                    <h2 class="titulo_situacion">ACTA FINAL DEL CONCURSO</h2>
                    <div class="div_space_blank"></div>
                    <table class="table_acta_final_concurso">
                        <tr>
                            <td class="table_acta_final_concurso--nro"><span class="text_bold">No.</span></td>
                            <td class="table_acta_final_concurso--nro_borde"></td>
                            <td class="table_acta_final_concurso--fecha"><span class="text_bold">Fecha:</span></td>
                            <td class="table_acta_final_concurso--fecha_borde"></td>
                        </tr>
                    </table>
                </div>
                <div class="datos_proceso_talento_humano">
                    <h2 class="titulo_situacion">PROCESO DE TALENTO HUMANO</h2>
                    <div class="div_space_blank"></div>
                    <table class="table_proceso_talento_humano">
                        <tr>
                            <td class="table_proceso_talento_humano--firma"><span class="text_bold">f.</span></td>
                            <td class="table_proceso_talento_humano--borde_firma"></td>
                            <td class="table_proceso_talento_humano--blank"></td>
                        </tr>
                        <tr>
                            <td class="table_proceso_talento_humano--text_firma" colspan="3">
                                <span class="text_bold">Nombre: {{substr($titulo_director,0,3)}}.
                                    {{strtoupper($nombres_director)}} {{strtoupper($apellidos_director)}}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="table_proceso_talento_humano--text_firma" colspan="3">
                                <span class="text_bold">Director de Talento Humano</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="titulo_dios_patria_libertad">
                <p class="text-center">DIOS, PATRIA Y LIBERTAD</p>
            </div>
            <div class="datos_fima_autoridad_delegada">
                <table class="table_firma_autoridad_delegada">
                    <tr>
                        <td class="table_firma_autoridad_delegada--blanco"></td>
                        <td class="table_firma_autoridad_delegada--datos"><span
                                class="text_bold">f.</span>______________________________________________</td>
                        <td class="table_firma_autoridad_delegada--blanco"></td>
                    </tr>
                    <tr>
                        <td class="table_firma_autoridad_delegada--blanco"></td>
                        <td class="table_firma_autoridad_delegada--datos"><span class="text_bold">Nombre:
                                {{substr($titulo_director,0,3)}}. {{$nombres_director}} {{$apellidos_director}}</span>
                        </td>
                        <td class="table_firma_autoridad_delegada--blanco"></td>
                    </tr>
                    <tr>
                        <td class="table_firma_autoridad_delegada--blanco"></td>
                        <td class="table_firma_autoridad_delegada--datos"><span class="text_bold">DELEGADO DE AUTORIDAD
                                NOMINADORA</span></td>
                        <td class="table_firma_autoridad_delegada--blanco"></td>
                    </tr>
                    <tr>
                        <td class="table_firma_autoridad_delegada--blanco"></td>
                        <td class="table_firma_autoridad_delegada--datos"><span class="text_bold">Resolución No.
                                004-GG-EPMMM-2022</span></td>
                        <td class="table_firma_autoridad_delegada--blanco"></td>
                    </tr>
                </table>
            </div>
            <div class="container_firma_talento_humano">
                <div class="firma_talento_humano">
                    <h2 class="titulo_situacion">TALENTO HUMANO</h2>
                    <table class="table_firma_talento_humano">
                        <tr>
                            <td class="table_firma_talento_humano--nro"><span class="text_bold">No.</span></td>
                            <td class="table_firma_talento_humano--borde">{{$secuencial}}</td>
                            <td class="table_firma_talento_humano--fecha"><span class="text_bold">Fecha</span></td>
                            <td class="table_firma_talento_humano--borde">{{$fecha_accion}}</td>
                        </tr>
                        <tr>
                            <td class="table_firma_talento_humano--firma_sufijo" colspan="4"><span
                                    class="text_bold">Responsable del Registro</span></td>
                        </tr>
                    </table>
                </div>
                <div class="firma_recibido">
                    <h2 class="titulo_situacion">RECIBIDO</h2>
                    <table class="table_firma_recibido">
                        <tr>
                            <td class="table_firma_recibido--blanco"></td>
                            <td class="table_firma_recibido--firma"><span
                                    class="text_bold">f.</span>________________________________________</td>
                            <td class="table_firma_recibido--blanco"></td>
                        </tr>
                        <tr>
                            <td class="table_firma_recibido--firma_sufijo" colspan="3"><span
                                    class="text_bold">{{strtoupper($nombres_empleado)}}
                                    {{strtoupper($apellidos_empleado)}}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>