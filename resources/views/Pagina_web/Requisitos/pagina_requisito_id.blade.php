@extends('Administrador.Layout.app_pagina_web')
@section('css')
<style>
a {
    text-decoration: none;
}

.border-bo {
    border-bottom: 1px solid #e9e9ea !important;
}
</style>

@endsection


@section('content')
<section id="breadcrumb-section" class="breadcrumb-area breadcrumb-center">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12">
                <div class="breadcrumb-content">
                    <div class="breadcrumb-heading">
                        <h2>TRÁMITE DE {{$requisito}}</h2>
                    </div>
                    <ol class="breadcrumb-list">
                        <li><a href="/">Inicio</a> &nbsp;&gt;&nbsp;</li>
                        <li class="active">Requisitos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<section class=" py-4 my-5">
    <div class="container">
        <div class="row justify-content-center">
            @if($id == 1)
            <div class="col-md-10 col-lg-10">
                <div class="my-3">
                    <h4 align="center"><strong>{{$requisito}}</strong></h4>
                    <p>Para acceder al servicio de exoneración del pago de parqueo tarifado en la zona regulada de la
                        ciudad, el usuario debe presentar los siguientes requisitos.
                    </p>
                    <h5><strong>DOCUMENTOS: </strong></h5>
                    <table border="0" class="border-bo">
                        <tr>
                            <td width="80%" class="border-bo">1.- Solicitud mediante oficio simple dirigido al Gerente
                                general de la EMPRESA PÚBLICA MUNICIPAL MOVILIDAD DE MANTA
                                EP.</td>
                            <td width="20%" class="border-bo" align="center">
                                <!--<a target="_blank"
                                    href="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/09/LISTADO-DE-APELACIONES-PRUEBAS-MEDICAS.pdf">
                                    <i class="fa fa-file-pdf-o pdf"></i>
                                </a>-->
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">2.- Copia de la cédula de ciudadanía.</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%">3.- Copia de la matrícula del vehículo en el que se traslada la persona
                                beneficiada.</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%">4.- Carnet de persona con deficiencia o condición discapacitante.</td>
                            <td width="20%" align="center"></td>
                        </tr>

                    </table>

                    <h5><strong>PASOS: </strong></h5>
                    <p class="has-text-align-left ma-le"> 1.- Acercarse a la Agencia de Tránsito de Manta en horario de
                        lunes a viernes, de 08h00 a 17h00.</p>
                    <p class="has-text-align-left ma-le"> 2.- Presentar la documentación requerida para el trámite.</p>
                    <p class="has-text-align-left ma-le"> NOTA: Pueden acceder a este beneficio, las personas con
                        discapacidad, adultos mayores y las embarazadas.</p>
                </div>
            </div>
            @elseif($id == 2)
            <div class="col-md-10 col-lg-10">
                <div class="my-3">
                    <h4 align="center"><strong>{{$requisito}}</strong></h4>
                    <p>Para acceder al servicio de actualización de datos, el ciudadano debe cumplir con estos
                        requisitos.

                    </p>
                    <h5><strong>DOCUMENTOS: </strong></h5>
                    <table border="0" class="border-bo">
                        <tr>
                            <td width="80%" class="border-bo">1.- Solicitud mediante oficio simple dirigido al Gerente
                                general de la EMPRESA PÚBLICA MUNICIPAL MOVILIDAD DE MANTA
                                EP.</td>
                            <td width="20%" class="border-bo" align="center">
                                <a target="_blank" href="/requisitos/solicitud_actualizacion_datos.docx">
                                    <i class="fa fa-file-word-o word"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">2.- Copia de la cédula de ciudadanía.</td>
                            <td width="20%" align="center"></td>
                        </tr>
                    </table>

                    <h5><strong>PASOS: </strong></h5>
                    <p class="has-text-align-left ma-le"> 1.- Acercarse a la Agencia de Tránsito de Manta en horario de
                        lunes a viernes, de 08h00 a 17h00.</p>
                    <p class="has-text-align-left ma-le"> 2.- Presentar la la solicitud y la copia de la cédula.</p>
                </div>
            </div>
            @elseif($id == 3)
            <div class="col-md-10 col-lg-10">
                <div class="my-3">
                    <h4 align="center"><strong>{{$requisito}}</strong></h4>
                    <p>Para acceder al servicio de certificación del correo, el usuario debe cumplir con estos
                        requisitos. </p>
                    <h5><strong>DOCUMENTOS: </strong></h5>
                    <table border="0" class="border-bo">
                        <tr>
                            <td width="80%" class="border-bo">1.- Solicitud mediante oficio simple dirigido al Gerente
                                general de la EMPRESA PÚBLICA MUNICIPAL MOVILIDAD DE MANTA
                                EP.</td>
                            <td width="20%" class="border-bo" align="center">
                                <!--<a target="_blank"
                                    href="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/09/LISTADO-DE-APELACIONES-PRUEBAS-MEDICAS.pdf">
                                    <i class="fa fa-file-pdf-o pdf"></i>
                                </a>-->
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">2.- Copia de la cédula de ciudadanía.</td>
                            <td width="20%" align="center"></td>
                        </tr>
                    </table>

                    <h5><strong>PASOS: </strong></h5>
                    <p class="has-text-align-left ma-le"> 1.- Acercarse a la Agencia de Tránsito de Manta en horario de
                        lunes a viernes, de 08h00 a 17h00.</p>
                    <p class="has-text-align-left ma-le"> 2.- Presentar la la solicitud y la copia de la cédula.</p>
                </div>
            </div>
            @elseif($id == 4)
            <div class="col-md-10 col-lg-10">
                <div class="my-3">
                    <h4 align="center"><strong>{{$requisito}}</strong></h4>
                    <P>Para acceder a un convenio de pago, debe cumplir con estos requisitos.</P>
                    <h5><strong>DOCUMENTOS: </strong></h5>
                    <table border="0" class="border-bo">
                        <tr>
                            <td width="80%" class="border-bo">1.- Solicitud mediante oficio simple dirigido al Gerente
                                general de la EMPRESA PÚBLICA MUNICIPAL MOVILIDAD DE MANTA
                                EP.</td>
                            <td width="20%" class="border-bo" align="center">
                                <!--<a target="_blank"
                                    href="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/09/LISTADO-DE-APELACIONES-PRUEBAS-MEDICAS.pdf">
                                    <i class="fa fa-file-pdf-o pdf"></i>
                                </a>-->
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">2.- Copia de cédula</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%">3.- Copia de multas de manta</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%">4.- 20% del total de las multas</td>
                            <td width="20%" align="center"></td>
                        </tr>
                    </table>

                    <h5><strong>PASOS: </strong></h5>
                    <p class="has-text-align-left ma-le"> 1.- Acercarse a la Agencia de Tránsito de Manta, desde las
                        08h00 hasta las 17h00 de lunes a viernes.
                    <p>
                    <p class="has-text-align-left ma-le"> 2.- Presentar la documentación requerida para continuar con el
                        trámite.</p>
                </div>
            </div>
            @elseif($id == 5)
            <div class="col-md-10 col-lg-10">
                <div class="my-3">
                    <h4 align="center"><strong>{{$requisito}}</strong></h4>
                    <p>Para acceder al levantamiento de gravamen de carro, debe cumplir con estos requisitos.</p>
                    <h5><strong>DOCUMENTOS: </strong></h5>
                    <table border="0" class="border-bo">
                        <tr>
                            <td width="80%">1- Copia de Matrícula</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%" class="border-bo">2.- Contrato de compra-venta</td>
                            <td width="20%" class="border-bo" align="center">
                                <!--<a target="_blank"
                                    href="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/09/LISTADO-DE-APELACIONES-PRUEBAS-MEDICAS.pdf">
                                    <i class="fa fa-file-pdf-o pdf"></i>
                                </a>-->
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">3.- Certificado del Registro Mercantil</td>
                            <td width="20%" align="center"></td>
                        </tr>

                        <tr>
                            <td width="80%">4.- Pago del trámite en la Agencia de Tránsito</td>
                            <td width="20%" align="center"></td>
                        </tr>
                    </table>

                    <h5><strong>PASOS: </strong></h5>
                    <p class="has-text-align-left ma-le">1.- Acercarse a la Agencia de Tránsito de Manta, desde las
                        08h00 hasta las 17h00 de lunes a viernes.</p>
                    <p class="has-text-align-left ma-le">2.- Presentar la documentación requerida para continuar con el
                        trámite.</p>
                </div>
            </div>
            @elseif($id == 6)
            <div class="col-md-10 col-lg-10">
                <div class="my-3">
                    <h4 align="center"><strong>{{$requisito}}</strong></h4>
                    <p>Para acceder al levantamiento de gravamen de carro, debe cumplir con estos requisitos.</p>
                    <h5><strong>DOCUMENTOS: </strong></h5>
                    <table border="0" class="border-bo">
                        <tr>
                            <td width="80%">1- Copia de Matrícula</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%" class="border-bo">2.- Oficio de la casa comercial certificaciónn de pago
                                total</td>
                            <td width="20%" class="border-bo" align="center">
                                <!--<a target="_blank"
                                    href="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/09/LISTADO-DE-APELACIONES-PRUEBAS-MEDICAS.pdf">
                                    <i class="fa fa-file-pdf-o pdf"></i>
                                </a>-->
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">3.- Certificado del Registro Mercantil</td>
                            <td width="20%" align="center"></td>
                        </tr>

                        <tr>
                            <td width="80%">4.- Pago del trámite en la Agencia de Tránsito</td>
                            <td width="20%" align="center"></td>
                        </tr>
                    </table>

                    <h5><strong>PASOS: </strong></h5>
                    <p class="has-text-align-left ma-le">1.- Acercarse a la Agencia de Tránsito de Manta, desde las
                        08h00 hasta las 17h00 de lunes a viernes.</p>
                    <p class="has-text-align-left ma-le">2.- Presentar la documentación requerida para continuar con el
                        trámite.</p>
                </div>
            </div>
            @elseif($id == 7)
            <div class="col-md-10 col-lg-10">
                <div class="my-3">
                    <h4 align="center"><strong>{{$requisito}}</strong></h4>
                    <p>Para realizar el trámite de traspaso de multa, el usuario debe cumplir con estos requisitos. </p>
                    <h5><strong>DOCUMENTOS: </strong></h5>
                    <table border="0" class="border-bo">
                        <tr>
                            <td width="80%" class="border-bo">1.- Solicitud mediante oficio simple dirigido a la EMPRESA
                                PÚBLICA MUNICIPAL MOVILIDAD DE MANTA.</td>
                            <td width="20%" class="border-bo" align="center">
                                <!--<a target="_blank"
                                    href="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/09/LISTADO-DE-APELACIONES-PRUEBAS-MEDICAS.pdf">
                                    <i class="fa fa-file-pdf-o pdf"></i>
                                </a>-->
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">2.- Carta de venta completa (certificado único vehicular)
                            </td>
                            <td width="20%" align="center"></td>
                        </tr>
                    </table>

                    <h5><strong>PASOS: </strong></h5>
                    <p class="has-text-align-left ma-le"> 1.- Acercarse a la Agencia de Tránsito de Manta en horario de
                        lunes a viernes, desde las 08h00 hasta las 17h00.</p>
                    <p class="has-text-align-left ma-le"> 2.- Presentar la documentación requerida para este trámite.
                    </p>
                </div>
            </div>
            @elseif($id == 8)
            <div class="col-md-10 col-lg-10">
                <div class="my-3">
                    <h4 align="center"><strong>{{$requisito}}</strong></h4>
                    <p>Para realizar el trámite de desvinculación de multa, el usuario debe cumplir con estos
                        requisitos. </p>
                    <h5><strong>DOCUMENTOS: </strong></h5>
                    <table border="0" class="border-bo">
                        <tr>
                            <td width="80%" class="border-bo">1.- Solicitud mediante oficio simple dirigido a la
                                EMPRESA PÚBLICA MUNICIPAL MOVILIDAD DE MANTA.</td>
                            <td width="20%" class="border-bo" align="center">
                                <!--<a target="_blank"
                                    href="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/09/LISTADO-DE-APELACIONES-PRUEBAS-MEDICAS.pdf">
                                    <i class="fa fa-file-pdf-o pdf"></i>
                                </a>-->
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">2.- Copia de matrícula del vehículo</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%">3.- Copia de multas</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%">4.- Copia de la cédula de ciudadanía</td>
                            <td width="20%" align="center"></td>
                        </tr>
                    </table>

                    <h5><strong>PASOS: </strong></h5>
                    <p class="has-text-align-left ma-le"> 1.- Acercarse a la Agencia de Tránsito de Manta en horario de
                        lunes a viernes, desde las 08h00 hasta las 17h00.</p>
                    <p class="has-text-align-left ma-le"> 2.- Presentar la documentación requerida para este trámite.
                    </p>
                </div>
            </div>
            @elseif($id == 9)
            <div class="col-md-10 col-lg-10">
                <div class="my-3">
                    <h4 align="center"><strong>{{$requisito}}</strong></h4>
                    <h5><strong>DOCUMENTOS: </strong></h5>
                    <table border="0" class="border-bo">
                        <tr>
                            <td width="80%" class="border-bo">1.- Solicitud mediante oficio simple dirigido al general
                                de la EMPRESA
                                PUBLICA MUNICIPAL "MOVILIDAD DE MANTA EP"</td>
                            <td width="20%" class="border-bo" align="center">
                                <!--<a target="_blank"
                                    href="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/09/LISTADO-DE-APELACIONES-PRUEBAS-MEDICAS.pdf">
                                    <i class="fa fa-file-pdf-o pdf"></i>
                                </a>-->
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">2.- Copia de la matrícula del vehículo</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%">3.- Copia de multas</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%">3.- Copia de cédula</td>
                            <td width="20%" align="center"></td>
                        </tr>
                        <tr>
                            <td width="80%">4.- Foto del vehículo (placa)</td>
                            <td width="20%" align="center"></td>
                        </tr>
                    </table>

                    <h5><strong>PASOS: </strong></h5>
                    <p class="has-text-align-left ma-le"> 1.- Acercarse a la Agencia de Tránsito de Manta en horario de
                        lunes a viernes, desde las 08h00 hasta las 17h00.</p>
                    <p class="has-text-align-left ma-le"> 2.- Presentar la documentación requerida para este trámite.
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>


@endsection

@section('js')

@endsection