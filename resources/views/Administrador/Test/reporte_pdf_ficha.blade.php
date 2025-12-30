<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reporte de fichas</title>
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
            <td width="10%" align="center"><img width="15%" src="{{ public_path('Imagenes/dist/logo/movilidad.png') }}"
                    class="img-logo-transito-pla main-logo" alt="logo"></img></td>
            <td width="80%" align="center">
                <strong class="titulo1">Empresa Pública Municipal Movilidad de Manta EP<strong><br>
                        <span class="titulo1">Reporte de Fichas</span><br>
                        <span class="titulo2">Desde: {{$fecha_inicio}} Hasta: {{$fecha_fin}}</span><br>
                        <span class="titulo3">Usuario: {{$usuario}} || Fecha y Hora: {{$fecha_actual}} </span><br>
            </td>
            <td width="10%" align="center">
                <!--<img src="https://manta.gob.ec/wp-content/uploads/2020/05/manta-alcaldia-logo.png"
                    class=" img-logo-transito main-logo" alt="logo"></img>-->
            </td>
        </tr>
    </table>
    <table width="100%" border="1" class="table tb table-tarea-m table-bordered">
        <thead>
            <tr class="color-thead">
                <th width="10%" class="color-thead">ID</th>
                <th width="25%" class="color-thead">PROYECTO</th>
                <th width="10%" class="color-thead">CEDULA</th>
                <th width="25%" class="color-thead">NOMBRES</th>
                <th width="20%" class="color-thead">FECHA DE TEST</th>
                <th width="10%" class="color-thead">CALIFICACIÓN</th>
            </tr>
        </thead>
        @foreach ($data as $datos)
        <tr>
            <td class="titulo3-tam" align="center">{{$datos->id}}</td>
            <td class="titulo3-tam" align="center">{{$datos->proyecto}}</td>
            <td class="titulo3-tam" align="center">{{$datos->emp_cedula}}</td>
            <td class="titulo3-tam" align="center">{{$datos->nombre_completo}}</td>
            <td class="titulo3-tam" align="center">{{$datos->date_end_test}}</td>
            <td class="titulo3-tam" align="center">{{ number_format($datos->total_calificacion, 2, '.', '') }}</td>
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