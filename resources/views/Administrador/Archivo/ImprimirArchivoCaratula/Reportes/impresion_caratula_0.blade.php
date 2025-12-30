<!DOCTYPE html>
<html lang="en">
<head>
    <title>IMPRESIÓN CARATULA</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            margin: 3mm;
        }
        body{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .content{
            width:  49.8%;
            border: 1px solid #ccc;
            height: 1000px;
            float: left;
        }
        .body_caratula{
            height: 600px;
        }
        .img_empresa{
            padding-top: 5px;
        }
        .center{
            text-align: center;
        }
        .bodega_tittle{
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
        }
        .unidad_tittle{
            padding: 2px;
            margin: 0;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }
        .unidad_descripcion{
            padding: 0;
            margin: 0;
            text-align: center;
            font-size: 18px;
        }
        .info_footer{
            padding: 2px;
            margin: 0;
            font-weight: bold;
            font-size: 16px;
        }
        .info_footer_description{
            padding: 0;
            margin: 0;
            text-align: center;
            font-weight: normal;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <main>
        @foreach($medios_almacenamiento as $m)
            <div class="content">
                <div class="body_caratula">
                    <div class="img_empresa center">
                        <img src="Imagenes/movilidad.png" class="logo_alcaldia_manta" alt="Alcaldia Manta" />         
                    </div>
                    <p class="bodega_tittle">{{$m->archivo}}</p>
                    <p class="unidad_tittle">UNIDAD PRODUCTORA:</p>
                    <p class="unidad_descripcion">{{$m->cup_id == 0 ? 'NO ASIGNADO' : $m->cup_nombre}}</p>
                    <p class="unidad_tittle">SERIE:</p>
                    <p class="unidad_descripcion">{{$m->cups_id == 0 ? 'NO ASIGNADO' : $m->cups_nombre}}</p>
                    <p class="unidad_tittle">CÓDIGO:</p>
                    <p class="unidad_descripcion">{{$m->ma_codigo}}</p>
                    <p class="unidad_tittle">DESCRIPCIÓN:</p>
                    <p class="unidad_descripcion">{{$m->ma_descripcion}}</p>
                </div>
                <p class="info_footer">FECHA INICIAL/FINAL: <span class="info_footer_description">{{$m->ma_estado_fecha ? "{$m->ma_fecha_desde} - {$m->ma_fecha_hasta}" : '-'}}</span></p>
                @foreach($m->hijos_medios as $hm)
                    <p class="info_footer">NRO {{$hm["nombre"]}}: <span class="info_footer_description">{{$hm["conteo"]}}</span></p>
                @endforeach
                @foreach($m->padre_medios as $pm)
                    <p class="info_footer">{{$pm["nombre"]}}: <span class="info_footer_description">{{$pm["codigo"]}}</span></p>
                @endforeach
            </div>
        @endforeach
    </main>
</body>
</html>