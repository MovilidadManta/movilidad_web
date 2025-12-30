<!DOCTYPE html>
<html lang="en">

<head>
    <title>ACUERDO DE CONFIDENCIALIDAD</title>
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

        .titulo1-tam {
            font-size: 16px;

        }

        .titulo2-tam {
            font-size: 14px;

        }

        .titulo3-tam {
            font-size: 12px;
            color: #031b4e;
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
            width: 80px !important;
            height: 70px !important;
            margin-top: 0px !important;
        }

        .justificar {
            text-align: justify !important;
        }
    </style>
</head>

<body>
    @foreach ($empleados as $data)
    <br><br><br><br><br><br>
    <p class="justificar">
        El (la) Señor (a) <strong>{{$data->emp_nombre}} {{$data->emp_apellido}}</strong> con cargo
        <strong>{{$data->ca_cargo}}</strong> que en adelante se denominará el SERVIDOR MUNICIPAL
        de la Empresa Pública Municipal Movilidad de Manta-EP, de manera libre y voluntaria, y en el uso de sus
        capacidades, suscribe
        el presente Acuerdo de Confidencialidad al tenor de las siguientes cláusulas:
    </p>

    <p>
        <strong>Cláusula Primera. - ANTECEDENTES:</strong>
    </p>
    <p class="justificar">
        El artículo 18 numeral 2 de la Constitución de la República del Ecuador, determina que:
    </p>
    <p class="justificar">
        "Todas las personas, en forma individual o colectiva, tienen derecho 2.a:
        Acceder libremente a la información generada en entidades públicas, o en las
        privadas que manejen fondos del Estado o realicen funciones públicas.
        No existirá reserva de información excepto en los casos expresamente
        establecidos en la ley. En caso de violación a los derechos humanos, ninguna entidad pública negará la
        información"
    </p>
    <p class="justificar">
        El artículo 6 de la Ley Orgánica de Transparencia y Acceso a la Información Pública, establece:
    </p>
    <p class="justificar">
        "Se considera información confidencial aquella información pública personal, que no está sujeta al principio de
        publicidad
        y comprende aquella derivada de sus derechos personalísimos y fundamentales, especialmente aquellos señalados en
        los artículos
        23 y 24 de la Constitución Política de la República.

        El uso ilegal que se haga de la información personal a su divulgación dará lugar a las acciones legales
        pertinentes (..)."

    </p>
    <p class="justificar">
        El artículo 179 del Código Integral Penal tipifica que:
    </p>
    <p class="justificar">
        "La persona que, teniendo conocimiento por razón de su estado u oficio, empleo, profesión o arte,
        de un secreto cuya divulgación pueda causar daño a otra persona y lo revele, será sancionada con
        pena privativa de libertad de seis meses a un año"

    </p>
    <p class="justicar">
        <strong>Cláusula Segunda. - OBJETO:</strong>
    </p>
    <p class="justicar">
        En virtud de las disposiciones legales invocadas en la cláusula anterior,
        el SERVIDOR PÚBLICO se compromete a guardar sigilo y reserva sobre la información
        y documentación que se maneja en la Empresa Pública Municipal Movilidad de Manta-EP
        y que pueda poner en riesgos la seguridad de la información.
    </p>


    <p class="justificar">
        <strong>Cláusula Tercera. - OBLIGACIONES:</strong>
    </p>
    <p class="justificar">
        EI SERVIDOR PÚBLICO ha sido informado y acepta que en atención a la naturaleza de la información
        y a los riesgos que el mal uso y/o divulgación de la misma implican para el Gobierno Autónomo
        Descentralizado Municipal de Cantón Manta, por tanto, se obliga a mantener el sigilo de toda la
        información que por razones de sus actividades tendrá acceso. Se obliga a abstenerse de usar, disponer,
        divulgar y/o publicar por cualquier medio, verbal o escrito, y en general, aprovecharse de ella en cualquier
        otra forma,
        o utilizarla para efectos ajenos a lo requerido por el SERVIDOR PÚBLICO.
    </p>

    <p class="justificar"><strong>Cláusula Cuarta. - SANCIONES:</strong></p>
    <p class="justificar">
        Como interesado en la información, he sido informado y quedo sometido a las Leyes y
        Reglamentos pertinentes sobre la materia, principalmente, quedo advertido de las
        sanciones penales que para estos casos establece la legislación ecuatoriana.
        En especial conozco que el incumplimiento de lo previsto en este "Acuerdo de
        Confidencialidad (..)"acarreará la siguiente sanción:
    </p>
    <br><br><br><br><br><br><br>
    <p class="jusificar"><br><br><br><br><br><br><br>
        EI SERVIDOR PÚBLICO podrá ser sancionado de conformidad con lo determinado en la Ley Orgánica del Servicio
        Público
        y su Reglamento General.

    </p>

    <p class="justificar">
        <strong>Cláusula Quinta. - DECLARACIÓN:</strong>
    </p>
    <p class="justificar">
        El SERVIDOR PÚBLICO declara conocer la información que se maneja en la Empresa Pública Municipal Movilidad de
        Manta-EP
        y utilizará en virtud de sus competencias la mencionada información únicamente para los fines para los cuales se
        le ha
        permitido acceso a la misma, debiendo mantener dichos datos de manera reservada, en virtud de la protección de
        que gozan
        de conformidad con la legislación vigente.
    </p>
    <p class="justificar">
        El interesado declara, además, conocer la normativa que regula la confidencialidad de la documentación,
        en especial las previsiones de la Constitución de la República, Ley Orgánica de Transparencia y
        Acceso a la Información Pública, Ley Orgánica del Servicio Público y el Código Orgánico Integral Penal.
    </p>

    <p class="justificar">
        <strong>Cláusula Sexta. - VIGENCIA:</strong>
    </p>
    <p class="justificar">
        Los compromisos establecidos en el presente Acuerdo de Confidencialidad se mantendrán vigentes desde la
        suscripción de
        este documento, sin límite, debido a la sensibilidad de la información.

    </p>
    <p class="justifiacr">
        <strong>Cláusula Séptima. - ACEPTACIÓN:</strong>
    </p>
    <p class="justificar">
        El SERVIDOR PÚBLICO {{$data->emp_nombre}} {{$data->emp_apellido}} acepta el contenido de todas y cada una de las
        cláusulas del
        presente acuerdo y en consecuencia se compromete a cumplirlas en toda su extensión, en fe de lo cual y para
        los fines legales correspondientes, lo firma en dos ejemplares del mismo tenor y efecto, en la ciudad de Manta,
        el {{$dia}} de {{$mes}} de {{$año}}.


    </p>
    <br><br>
    <table width="100%" align="center" border="0" class="table tb table-tarea-m table-bordered">
        <tr>
            <td align="center"><strong>f. ______________________________________</strong></td>
        </tr>
        <tr>
            <td align="center"><strong>Servidor Público</strong></td>
        </tr>
    </table>
    <br>
    <table width="100%" align="center" border="0" class="table tb table-tarea-m table-bordered">
        <tr>
            <td><strong>Nombre del Servidor Público:</strong> {{$data->emp_nombre}} {{$data->emp_apellido}}</td>
        </tr>
        <tr>
            <td><strong>Documento de identidad:</strong> {{$data->emp_cedula}}</td>
        </tr>
    </table>
    @endforeach

    <script>
        var h = $("#txt-hora").val().split('.')
        var hora = h[0]
        $("#hora").val(hora)
    </script>
</body>

</html>