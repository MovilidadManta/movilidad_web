<!DOCTYPE html>
<html lang="en">

<head>
    <title>Placa Provisional</title>
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
        
        @font-face {
            font-family: Rounded;
            src: url('../fonts/Rounded_Elegance.ttf');
        }

        .clearfix::after {
          content: "";
          display: table;
          clear: both;
        }


        body {
            font-family: Rounded;
        }

        .container_moto{
          width: 225mm;
          height: 155mm;
          margin: 0 auto;
          box-sizing:border-box;
          padding: 0;
          overflow: hidden;
        }

        .container_moto::after { 
          content:""; 
          display:block; 
          clear:both; 
        }

        .border-div-pl {
            border: 1px solid #000;
        }

        .header_logos{
          height: 40mm;
          padding: 0;
        }

        .logo_ecuador{
          width: 45mm;
          float: left;
          text-align:center;
        }

        .texto_placa{
          width: 134mm; /* 135 */
          text-align:center;
          float: left;
        }

        .titulo1-tam-ecua {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 28pt;
            font-weight: bold;
            line-height: 1;
        }

        .logo_gad{
          width: 45mm;
          float: left;
          text-align:center;
        }

        .img-escudo{
          max-height: 26mm;
          width: auto;
          margin-top: 10px;
        } 
        
        .img-logo {
          max-height: 36mm;
          width: auto;
          margin-top: 2px;
        }
        .section_placas{
          width: 225mm;                /* riel exacto */
          margin: 0 auto;
          padding: 0 6.4286mm;         /* bordes iguales */
          box-sizing: border-box;
          overflow: hidden;
        }

        .section_placas::after{content:"";display:block;clear:both;}
        .div_letter{
        float:left;
        width:30mm;
        height:64mm;
        box-sizing:border-box;        /* el borde no suma */
        border:1px solid #000;
        text-align: center;
        font-size: 15.5mm;
        line-height: 64mm;
      }

      .div_letter:last-child{ margin-right:0; }
      .div_letter_space{
        float:left;
        width:5.7mm;
        height:0.01mm;
      }
      .div_letter_space:last-child{
        float:left;
        width:0;
        height:0;
      }
      .section_datos{
        width: 225mm;                /* riel exacto */
        margin: 0 auto;
        padding: 0 6.4286mm;         /* bordes iguales */
        box-sizing: border-box;
        padding: 0;
      }
      .div_qr{
        width: 25mm;
        float: left;
        overflow: hidden;
        padding-top:15mm;
        padding-left: 10mm;
      }
      .div_qr__img{
        height: 30mm;
      }
      .div_servicio{
        width: 75mm;
        float: left;
        overflow: hidden;
        padding-top:25mm;
        padding-left: 15mm;
      }
      .div_fechas{
        padding-top:15mm;
        width: 98mm;
        float: left;
        overflow: hidden;
      }
      .subrayar_text{
        border-bottom: 1px solid #000;
      }
    </style>
</head>

<body>
    <div class="container_moto clearfix border-div-pl">
      <div class="header_logos">
        <div class="logo_ecuador">
          <img
            src="{{ public_path('Imagenes/dist/escudo_ecuador.png') }}"
            class="img-escudo" alt="logo">
          </img>
        </div>
        <div class="texto_placa">
            <p class="titulo1-tam-ecua">PLACA PROVISIONAL</p>
        </div>
        <div class="logo_gad">
          <img
            src="{{ public_path('Imagenes/dist/logo/movilidad_intervencion.PNG') }}"
            class="img-logo" alt="logo">
          </img>
        </div>
      </div>
      <div class="section_placas">
        @foreach (str_split($placa_moto) as $letra_placa)
          <div class="div_letter">
           <img
              src="{{ public_path("Imagenes/dist/letras/moto/{$letra_placa}.png") }}"
              alt="{{$letra_placa}}">
            </img>
          </div>
          <div class="div_letter_space">
          </div>
        @endforeach
      </div>
       <div class="section_datos">
          <div class="div_qr">
            <strong><img class="div_qr__img" src="data:image/png;base64,{{ $qr_placa }}" alt=""></strong>
          </div>
          <div class="div_servicio">
            <strong>SERVICIO:</strong>
            <span>
              @if($data->tipoServicio == "PAR")
                PARTICULAR
                @elseif($data->tipoServicio == "PUB")
                TRANSPORTE PÚBLICO
                @elseif($data->tipoServicio == "COM")
                COMERCIAL
                @elseif($data->tipoServicio == "CPR")
                CUENTA PROPIA
                @endif
            </span>
          </div>
          <div class="div_fechas">
            <p>Lugar y fecha de emisión: <span class="subrayar_text">{{$fecha_tramite}}</span></p>
            <p>Fecha de caducidad: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="subrayar_text">{{$fecha_valida}}</span></p>
          </div>
       </div>
    </div>

    <script>
        var h = $("#txt-hora").val().split('.')
        var hora = h[0]
        $("#hora").val(hora)
    </script>
</body>

</html>