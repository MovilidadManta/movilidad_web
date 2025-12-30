<!DOCTYPE html>
<html lang="en">

<head>
    <title>REPORTE DE NOMINA DE EMPLEADOS</title>
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
                        <span class="titulo2">REPORTE DE NOMINA DE EMPLEADO</span><br>
                        @if($direccion==0)
                        @if($niveles==1)
                        <span class="titulo2">GERENCIA </span><br>
                        @elseif($niveles==2)
                        <span class="titulo2">DIRECTORES </span><br>
                        @elseif($niveles==3)
                        <span class="titulo2">JEFATURAS</span><br>
                        @elseif($niveles==4)
                        <span class="titulo2">ANALISTAS</span><br>
                        @endif
                        @else
                        <span class="titulo2">DIRECCION: {{$direccion}} || JEFATURA: {{$jefatura}} || REGIMEN
                            CONTRACTUAL: {{$regimen_contractual}}</span><br>
                        <span class="titulo2">DESDE: {{$fecha_inicio}} HASTA: {{$fecha_fin}}</span><br>
                        @endif
                        <span class="titulo3">Usuario: {{$usuario}} || Fecha: {{$fecha_actual}} || Hora:
                            {{$hora_actual}}</span><br>

            </td>
            <td width="15%" align="center"><img src="https://manta.gob.ec/wp-content/uploads/2020/05/manta-alcaldia-logo.png" class=" img-logo-transito main-logo" alt="logo"></img></td>
        </tr>
    </table>
    <table width="100%" border="1" class="table tb table-tarea-m table-bordered">
        <thead>
            <tr class="color-thead">
                <th class="color-thead">FOTO</th>
                <th class="color-thead">CEDULA</th>
                <th class="color-thead">FUNCIONARIO</th>
                <th class="color-thead">CORREO</th>
                <th class="color-thead">DIRECCIÓN</th>
                <th class="color-thead">JEFATURA</th>
                <th class="color-thead">CARGO</th>
                <th class="color-thead">SALARIO</th>
                <th class="color-thead">TELEFONO</th>
                <th class="color-thead">OBSERVACION</th>
            </tr>
        </thead>
        @foreach ($empleados as $datos)
        <tr>
            <td class="titulo3-tam"><img class="tam-fo" src="#" alt=""></td>
            <!--<td class="titulo3-tam">aaa</td> -->
            <td class="titulo3-tam" align="center">{{$datos->emp_cedula}}</td>
            <td class="titulo3-tam" align="center">{{$datos->emp_nombre}} {{$datos->emp_apellido}}</td>
            <td class="titulo3-tam" align="center">{{$datos->usu_correo}}</td>
            <td class="titulo3-tam" align="center">{{$datos->dep_departamento}}</td>
            <td class="titulo3-tam" align="center">{{$datos->per_perfil}}</td>
            <td class="titulo3-tam" align="center">{{$datos->ca_cargo}}</td>
            <td class="titulo3-tam" align="center">$ {{$datos->emp_remuneracion}}</td>
            <td class="titulo3-tam" align="center">{{$datos->emp_telefono}}</td>
            <td class="titulo3-tam" align="center">{{$datos->emp_observacion}}</td>
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