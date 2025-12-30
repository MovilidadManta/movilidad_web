<!DOCTYPE html>
<html lang="en">

<head>
    <title>Placa Proviosnal</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @font-face {
            font-family: Rounded;
            src: url('../fonts/Rounded_Elegance.ttf');
        }


        body {
            font-family: Rounded;
        }

        .titulo1 {
            font-size: 16px;
            font-sight: bold;
            color: #031b4e;
        }

        .titulo2 {
            font-size: 14px;
            font-weight: bold;
            color: #031b4e;
        }

        .titulo3 {
            font-size: 12px;
            font-weight: bold;
        }

        .titulo1-tam-ecua {
            font-size: 32px;

        }

        .titulo1-tam-placa {
            font-size: 160px;
        }

        .titulo2-tam {
            font-size: 14px;

        }

        .titulo3-tam {
            font-size: 12px;
            color: rgb(0, 0, 0);
        }

        .color-thead {
            background: #009ee2;
            color: #fff;
        }

        .img-logo {
            width: 120px !important;
            height: 70px !important;
            margin-top: 0px !important;
        }

        .img-logo-transito {
            width: 100px !important;
            height: 90px !important;
            margin-top: 0px !important;
        }

        .justificar {
            text-align: justify !important;
        }

        .border-div-pl {
            border: 0.5px solid #000;
        }


        .titulo2-tam-d {
            font-size: 72px;
            font-weight: normal;
        }

        .img-logo-transito-pla {
            width: 150px !important;
        }
    </style>
</head>

<body>
    <div class="table-responsive border-div-pl">
        <table width="100%" align="center" border="0" class="table tb table-tarea-m table-bordered ">
            <tr>
                <td width="35%" align="center"><strong><img
                            src="https://radiocresatelital.com/wp-content/uploads/2023/08/ANT-ecuador-logo.png"
                            class=" img-logo-transito-pla main-logo" alt="logo"></img></strong><br><img
                        src="https://manta.gob.ec/wp-content/uploads/2024/12/logotipo-manta-ecuador.jpg"
                        class=" img-logo-transito-pla main-logo" alt="logo"></img></td>
                <td width="30%" align="center" rowspan=1><strong class="titulo1-tam-ecua">ECUADOR</strong></td>
                <td width="35%" align="center"><strong class="titulo2-tam-d">D</strong><br><img
                        src="http://movilidadmanta.gob.ec/Imagenes/dist/movilidad.png"
                        class="img-logo-transito-pla main-logo" alt="logo"></img></td>
            </tr>
            <tr>
                <td width="35%" align="center" colspan=3 class="titulo1-tam-placa">
                    <strong>{{$data['data']['placaActual'][0]}}{{$data['data']['placaActual'][1]}}</strong><br><strong>{{$data['data']['placaActual'][2]}}{{$data['data']['placaActual'][3]}}{{$data['data']['placaActual'][4]}}{{$data['data']['placaActual'][5]}}</strong>
                </td>
            </tr>
        </table>
    </div>

    <div class="table-responsive border-div-pl">
        <table width="100%" align="center" border="3" class="table tb table-tarea-m table-bordered titulo3-tam interno">
            <tr>
                <td width="20%" align="left" class="table-responsive border-div-pl"><strong>PROVINCIA:</strong> </td>
                <td width="20%" align="left" class="table-responsive border-div-pl">MANABI </td>
                <td width="20%" align="left" class="table-responsive border-div-pl"><strong>FECHA TRÁMITE:</strong>
                </td>
                <td width="20%" align="left" class="table-responsive border-div-pl">{{$fecha_tramite}} </td>
                <td width="20%" align="center" class="table-responsive border-div-pl" rowspan="5">
                    <strong><img src="data:image/png;base64,{{ $qr_placa }}" alt=""></strong>
                </td>
            </tr>
            <tr>
                <td width="20%" align="left" class="table-responsive border-div-pl"><strong>OFICINA DE
                        MATRICULACIÓN:</strong> </td>
                <td width="20%" align="left" class="table-responsive border-div-pl">MANTA </td>
                <td width="20%" align="left" class="table-responsive border-div-pl"><strong>VÁLIDO HASTA:</strong> </td>
                <td width="20%" align="left" class="table-responsive border-div-pl">{{$fecha_valida}} </td>
            </tr>
            <tr>
                <td width="20%" align="left" class="table-responsive border-div-pl"><strong>PROPIETARIO:</strong> </td>
                <td width="60%" align="left" class="table-responsive border-div-pl" colspan=3>
                    {{$data['data']['propietario']}}
                </td>
            </tr>
            <tr>
                <td width="20%" align="left" class="table-responsive border-div-pl"><strong>SERVICIO:</strong> </td>
                @IF($data['data']['tipoServicio'] == "PAR")
                <td width="65%" align="left" class="table-responsive border-div-pl" colspan=3>
                    PARTICULAR
                </td>
                @ENDIF
            </tr>
            <tr>
                <td width="20%" align="left" class="table-responsive border-div-pl"><strong>DIGITADOR:</strong> </td>
                <td width="60%" align="left" class="table-responsive border-div-pl" colspan=3>{{$usuario}} </td>
            </tr>
        </table>
    </div>

    <p class="justificar">La resolución N° 093-DIR-2021-ANT en "REFORMA AL REGLAMENTO DE PROCEDIMIENTOS Y REQUISITOS
        PARA LA MATRICULACIÓN
        VEHICULAR" en
        su Art. 29.- tipifica, en los casos de que no sea posible la entrega de una placa metálica por la entidad
        competente, se otorgará por excepcionalidad una placa
        provisional que contendrá la misma serie alfa númerica de la definitiva y tendrá la vigencia de hasta 120 días
        renovables en casos excepcionales.</p>

    <p class="justificar">Esta placa provisional conteniene información que puede ser validada por un agente de control
        a través de su
        código QR.</p>

    <script>
        var h = $("#txt-hora").val().split('.')
        var hora = h[0]
        $("#hora").val(hora)
    </script>
</body>

</html>