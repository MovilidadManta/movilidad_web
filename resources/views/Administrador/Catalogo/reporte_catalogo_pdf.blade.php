<!DOCTYPE html>
<html lang="en">

<head>
    <title>REPORTE DE EQUIPOS DE COMPUTACIÓN</title>
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
            font-weight: bold;
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

        .titulo1-tam {
            font-size: 16px;

        }

        .titulo2-tam {
            font-size: 14px;

        }

        .titulo3-tam {
            font-size: 10px;
            color: #031b4e;
        }

        .color-thead {
            font-size: 10px;
            background: #009ee2;
            color: #fff;
        }

        .img-logo {
            width: 120px !important;
            height: 70px !important;
            margin-top: 0px !important;
        }

        .img-logo-transito {
            width: 80px !important;
            height: 70px !important;
            margin-top: 0px !important;
        }

        .tam-fo {
            width: 60px !important;
            height: 75px !important;
        }
    </style>
</head>

<body> 

    <table width="100%" border="1" class="table table-bordered">
        <tr align="center">
            <td width="15%" align="center"><img src="https://i0.wp.com/web.movilidadmanta.gob.ec/wp-content/uploads/2022/04/cropped-LOGO-PAGINA-WEB.png?fit=600%2C300&ssl=1" class="img-logo main-logo" alt="logo"></img></td>
            <td width="80%" align="center">
                <strong class="titulo1">EMPRESA PUBLICA MOVILIDAD DE MANTA EP<strong><br>
                        <span class="titulo2">REPORTE DE EQUIPOS DE COMPUTACIÓN</span><br>
                        <span class="titulo2">CATEGORIA: {{$categoria}} || AREA: {{$area}} || ESTADO: {{$estado}}</span><br>
                        <span class="titulo3">Usuario: {{$usuario}} || Fecha: {{$fecha_actual}} || Hora: {{$hora_actual}}</span><br>
            </td>
            <td width="15%" align="center"><img src="https://manta.gob.ec/wp-content/uploads/2020/05/manta-alcaldia-logo.png" class=" img-logo-transito main-logo" alt="logo"></img></td>
        </tr>
    </table>
    <table width="100%" border="1" class="table tb table-tarea-m table-bordered">
        <thead>
            <tr class="color-thead">
                <th class="color-thead">CODIGO</th>
                <th class="color-thead">CATEGORIA</th>
                <th class="color-thead">MARCA</th>
                <th class="color-thead">MODELO</th>
                <th class="color-thead">DESCRIPCION</th>
                <th class="color-thead">OBSERVACION</th>
            </tr>
        </thead>
        @foreach ($catalogos as $datos)
        <tr>
            <!--<td class="titulo3-tam">aaa</td> -->
            <td class="titulo3-tam" align="center">{{$datos->cat_codigo}}</td>
            <td class="titulo3-tam" align="center">{{$datos->cat_categoria}}</td>
            <td class="titulo3-tam" align="center">{{$datos->cat_marca}}</td>
            <td class="titulo3-tam" align="center">{{$datos->cat_modelo}}</td>
            <td class="titulo3-tam" align="center">{{$datos->cat_descripcion}}</td>
            <td class="titulo3-tam" align="center">{{$datos->cat_observacion}}</td>
        </tr>
        @endforeach

        <tbody>

        </tbody>
    </table>

</body>
<script>
    var h = $("#txt-hora").val().split('.')
    var hora = h[0]
    $("#hora").val(hora)
</script>

</html>