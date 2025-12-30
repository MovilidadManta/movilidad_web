<!DOCTYPE html>
<html lang="en">
<head>
    <title>IMPRESIÓN CARATULA</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            margin: 4mm;
        }
        body{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .content{
            width:  100%;
            border: 1px solid #ccc;
            margin-top: 2px;
        }
        .body_caratula{
            margin: 0;
            padding: 0;
            width: 70%;
            float: left;
        }
        .img_empresa{
            text-align: center;
            width: 150px;
            float: left;
            margin: 0;
            padding: 0;
        }
        .center{
            text-align: center;
        }
        .content_div{
            width: 115px;
            margin: 0;
            padding: 0;
            float: left;
        }
        .content_div--serie{
            width: 100px;
        }
        .content_div--codigo{
            width: 90px;
        }
        .content_div--estanteria{
            width: 90px;
        }
        .content_div--fechas{
            width: 120px;
        }
        .footer_div{
            float: right;
            margin: 0;
            padding: 0;
        }
        .bodega_tittle{
            font-weight: bold;
            font-size: 10px;
            text-align: center;
            width: 65px;
            float: left;
            margin-top: 10px;
        }
        .unidad_tittle{
            padding: 2px;
            margin: 0;
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            margin: 0
        }
        .unidad_descripcion{
            padding: 0;
            margin: 0;
            text-align: center;
            font-size: 8px;
        }
        .info_footer{
            padding: 2px;
            margin: 0;
            font-weight: bold;
            font-size: 8px;
            margin-top: 10px;
            text-align: center;
        }
        .info_footer_description{
            padding: 0;
            margin: 0;
            text-align: center;
            font-weight: normal;
            font-size: 8px;
        }
        .info_footer_fechas{
            font-size: 8px;
        }
        .info_footer_center{
            text-align: center;
            margin: 0;
            padding: 0;
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
                    <div class="content_div content_div--codigo">
                        <p class="unidad_tittle">CÓDIGO:</p>
                        <p class="unidad_descripcion">{{$m->ma_codigo}}</p>
                    </div>
                    <div class="content_div">
                        <p class="unidad_tittle">UNIDAD PRODUCTORA:</p>
                        <p class="unidad_descripcion">{{$m->cup_id == 0 ? 'NO ASIGNADO' : $m->cup_nombre}}</p>
                    </div>
                    <div class="content_div content_div--serie">
                        <p class="unidad_tittle">SERIE:</p>
                        <p class="unidad_descripcion">{{$m->cups_id == 0 ? 'NO ASIGNADO' : $m->cups_nombre}}</p>
                    </div>
                </div>
                <div class="footer_div">
                    <div class="content_div content_div--fechas">
                        <p class="info_footer">FECHAS EXTREMAS:</p>
                        <p class="info_footer_center"><span class="info_footer_description info_footer_fechas">{{$m->ma_estado_fecha ? "{$m->ma_fecha_desde} - {$m->ma_fecha_hasta}" : '-'}}</span></p>
                    </div>
                    
                    @foreach($m->padre_medios as $pm)
                        <div class="content_div content_div--estanteria">
                            <p class="info_footer">{{$pm["nombre"]}}:</p>
                            <p class="info_footer_center"><span class="info_footer_description info_footer_fechas">{{$pm["codigo"]}}</span></p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </main>
</body>
</html>