<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$titleReport}}</title>
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
            <td width="15%" align="center"><img src="Imagenes/cropped-LOGO-PAGINA-WEB.png" class="img-logo main-logo" alt="logo"></img></td>
            <td width="80%" align="center">
                <strong class="titulo1">EMPRESA PUBLICA MOVILIDAD DE MANTA EP<strong><br>
                        <span class="titulo2">{{$titleReport}}</span><br>
                        @foreach ($titlesHeader as $title)
                            {!! $title !!}
                        @endforeach
            </td>
            <td width="15%" align="center"><img src="Imagenes/manta-alcaldia-logo.png" class=" img-logo-transito main-logo" alt="logo"></img></td>
        </tr>
    </table>
    <table width="100%" border="1" class="table tb table-tarea-m table-bordered">
        <thead>
            <tr class="color-thead">
                @foreach ($titlesHeaderTable as $title)
                    <th class="color-thead">{{$title}}</th>
                @endforeach
            </tr>
        </thead>
        @foreach ($items as $item)
        <tr>
            @foreach ($columnsTable as $column)
                <td class="titulo3-tam" align="center">{{$item->$column}}</td>
            @endforeach
        </tr>
        @endforeach
    </table>

</body>
</html>