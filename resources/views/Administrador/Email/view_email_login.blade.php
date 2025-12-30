<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Correo</title>
</head>

<body>
    <div>
        <table border="1" cellpadding="2" cellspacing="2" style="100%">
            <tr>
                <td style="background: white;" width="100%" colspan="2"><h2 align="center"><img align="center" width="150px"; src="https://aprendoki.com/img/logo-full.png"></td>
            </tr>
            <tr>
                <td align="left" width="100%"> 
                    <strong><h2 align="center">NOTIFICACION DE INGRESO A Aprendoki</h2></strong></h2>
                     Generado: <strong>{{$fecha}}</strong>
                    <br><br><strong>Estimado/a</strong>
                    <br><br>Usted ingresó un curso a Aprendoki. Desde la IP: <strong> {{$ip_publica}} </strong>
                    <br><br>Ubicación: <strong>{{$country}} / {{$city}}</strong>
                    <br><br>Proveedor de Servicio de Internet: <strong>{{$host}}</strong>
                    <br><strong>{{$host2}}</strong>
                    <br><br>En caso de no haber realizado esta operación comuníquese inmediatamente a <strong>0981113122</strong>
                    <br><br><h5>Nota: No responda a este correo electrónico. Si tiene alguna duda, póngase en contacto con nosotros mediante <br>nuestro sitio web <a href="https://www.aprendoki.com">www.aprendoki.com</a></h5>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

