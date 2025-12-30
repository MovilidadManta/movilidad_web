@extends('Administrador.Layout.app_pagina_web')
@section('metatags')
    @foreach($json_data as $data)
        @if ($loop->first)
        <meta property="og:title" content="Información de {{$data->co_nombre}}" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{url()->current()}}" />
        <meta property="og:image" content="{{url('')}}/imagenes_cooperativa/{{$data->co_ruta_foto}}" />
        <meta property="og:description" content="Conoce los destinos y horarios de encomienda para la {{$data->co_nombre}}" />
        <meta property="og:site_name" content="Movilidad de Manta EP" />
        <meta property="og:image:width" content="1200" /> 
        <meta property="og:image:height" content="630" />
        <meta name="twitter:title" content="Movilidad de Manta EP">
        <meta name="twitter:card" content="Información de {{$data->co_nombre}}">
        <meta property="twitter:description" content="Conoce los destinos y horarios de encomienda para la {{$data->co_nombre}}" />
        <meta name="twitter:image" content="{{url('')}}/imagenes_cooperativa/{{$data->co_ruta_foto}}">
        @endif
    @endforeach
@endsection
@section('css')
<style type="text/css" media="all">
    #rt-tpg-container-985975327 .rt-holder .rt-woo-info .price {
        color: #0367bf;
    }

    body .rt-tpg-container .rt-tpg-isotope-buttons .selected,
    #rt-tpg-container-985975327 .layout12 .rt-holder:hover .rt-detail,
    #rt-tpg-container-985975327 .isotope8 .rt-holder:hover .rt-detail,
    #rt-tpg-container-985975327 .carousel8 .rt-holder:hover .rt-detail,
    #rt-tpg-container-985975327 .layout13 .rt-holder .overlay .post-info,
    #rt-tpg-container-985975327 .isotope9 .rt-holder .overlay .post-info,
    #rt-tpg-container-985975327.rt-tpg-container .layout4 .rt-holder .rt-detail,
    .rt-modal-985975327 .md-content,
    .rt-modal-985975327 .md-content>.rt-md-content-holder .rt-md-content,
    .rt-popup-wrap-985975327.rt-popup-wrap .rt-popup-navigation-wrap,
    #rt-tpg-container-985975327 .carousel9 .rt-holder .overlay .post-info {
        background-color: #0367bf;
    }

    #rt-tpg-container-985975327 .layout5 .rt-holder .overlay,
    #rt-tpg-container-985975327 .isotope2 .rt-holder .overlay,
    #rt-tpg-container-985975327 .carousel2 .rt-holder .overlay,
    #rt-tpg-container-985975327 .layout15 .rt-holder h3,
    #rt-tpg-container-985975327 .isotope11 .rt-holder h3,
    #rt-tpg-container-985975327 .carousel11 .rt-holder h3,
    #rt-tpg-container-985975327 .layout16 .rt-holder h3,
    #rt-tpg-container-985975327 .isotope12 .rt-holder h3,
    #rt-tpg-container-985975327 .carousel12 .rt-holder h3 {
        background-color: rgba(3, 103, 191, 0.1);
    }

    #rt-tpg-container-985975327 .read-more a {
        border-radius: px;
    }

    #rt-tpg-container-985975327 .rt-img-holder img.rt-img-responsive,
    #rt-tpg-container-985975327 .rt-img-holder,
    #rt-tpg-container-985975327 .rt-post-overlay .post-img,
    #rt-tpg-container-985975327 .post-sm .post-img,
    #rt-tpg-container-985975327 .rt-post-grid .post-img,
    #rt-tpg-container-985975327 .post-img img {
        border-radius: px;
    }

    .pad-25 {
        padding: 0 25px;
    }

    .btn-social{
        padding: 8px 5px;
        font-size: 20px;
        color: #fff;
        display: inline-block;
    }
    .btn-social-whatsapp{
        color: #25D366;
    }
    .btn-social-facebook{
        color: #3b5998;
    }
    .btn-social-twitter{
        color: #00acee;
    }
    .btn-social > a{
        color: inherit !important;
    }
    .btn-le{
        float: left;
        margin-top: 15px;
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
                        <h2>COOPERATIVA</h2>

                    </div>

                    <ol class="breadcrumb-list">
                        <li><a href="/terminal">Inicio > Terminal</a> &nbsp;&gt;&nbsp;</li>
                        <li class="active">Cooperativas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> <!-- container -->
</section>
<?php 
    $ubicacion_encomienda = "";
?>
<section id="post-section" class="post-section av-py-default-100 blog-page">
    <div class="av-container width-t-100-n">
        <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <!--<p class="has-text-align-justify has-text-color margin-b-no" style="color:#009fe3;font-size:15px">La EMPRESA PÚBLICA MOVILIDAD DE MANTA-EP, en ayuda a nuestra comunidad damos a conocer nuestras principales noticias, con la finalidad de formar parte del desarrollo de nuestra hermosa ciudad, ACALDÍA DE MANTA siempre firmes con el cambio.</p>-->
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)" id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                    <!--<div class="tpg-widget-heading-wrapper heading-style1 "><span class="tpg-widget-heading-line line-left"></span>
                        <h2 class="tpg-widget-heading">NOTICIAS MOVILIDAD MANTA</h2><span class="tpg-widget-heading-line"></span>-->
                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">

                    <div class="rt-col-md-12 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                        @foreach($json_data as $data)
                        @if ($loop->first)
                        <h2 class="color-titu-pag" align="center">{{$data->co_nombre}}</h2>
                        @endif
                        @endforeach
                        <!--<div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong class="color-fe"> hhhhhhhhhh</strong></span></div>-->
                        <div class="rt-holder sha-no">
                            @foreach($json_data as $data)
                            @if ($loop->first)
                            <div class="rt-img-holder">
                                <a>
                                    <img src="/imagenes_cooperativa/{{$data->co_ruta_foto}}" class="img-border-ra tam-img-no-100 rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>
                            @endif
                            @endforeach
                            <div class="rt-detail ">
                                @foreach($json_data as $data)
                                @if ($loop->first)
                                <div class="tpg-excerpt">
                                    <h5 class="color-titu-pag" align="center"><strong>Datos de la Cooperativa</strong></h5>
                                    <table class="table">
                                        <tr>
                                            <td width='20%' class="color-titu-pag"><strong> Telefono:</strong></td>
                                            <td width='30%'>
                                                @if (strlen(trim($data->co_celular)) > 2)
                                                    <span class="btn-social btn-social-whatsapp">
                                                        <a href="https://api.whatsapp.com/send?text=Buenas tardes, estimados señores {{$data->co_nombre}}, tengo una consulta&phone=+593{{substr($data->co_celular, 1)}}" target="_blank" class="whatsapp">
                                                            <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                                        </a>
                                                    </span>
                                                @endif
                                                 {{$data->co_celular}} - {{$data->co_convencional}}
                                            </td>
                                            <td width='20%' class="color-titu-pag"><strong>Email:</strong></td>
                                            <td width='30%'>{{$data->co_correo}}</td>
                                        </tr>
                                    </table>
                                    <table class="table">
                                        <tr>
                                            <td class="color-titu-pag" width="20%"><strong> Ubicacion:</strong></td>
                                            <td width="80%">{{$data->co_ubicacion}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <?php 
                                    $ubicacion_encomienda = $data->co_ubicacion_encomienda;
                                ?>
                                @endif
                                @endforeach


                                <div class="tpg-excerpt pad-25">
                                    <h5 class="color-titu-pag" align="center"><strong>Destinos</strong> </h5>
                                    <table id="table-empleado" border="1" class="table table-bor">
                                        <thead class="background-thead pad">
                                            <tr align="center">
                                                <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-road"></i> Ruta: </strong></th>
                                                <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-clock-o"></i> Horas de Salida:</strong></th>
                                                <th align="center" class="border-bottom-0 color-th pad"><i class="fa fa-dollar"></i> Precio: </strong></th>
                                            </tr>
                                        </thead>
                                        <tbody style="border-top: 2px solid #fff;">
                                            @foreach($json_data as $data)
                                            <tr>
                                                <td class="color-td" align="center">Manta - {{$data->de_destino}}</td>
                                                <td class="color-td" align="center">
                                                    @foreach($data->data_hora_salida as $hora)
                                                        <div class="col-md-5  color-hora" align="center">{{$hora->hs_hora_salida}}</div>
                                                    @endforeach
                                                </td>
                                                <td class="color-td" align="center">${{$data->dc_precio}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                @if (count($horarios_encomienda) > 0)
                                <div class="tpg-excerpt pad-25">
                                    <h5 class="color-titu-pag" align="center"><strong>Horarios de Encomienda</strong> </h5>
                                    <table id="table-empleado" border="1" class="table table-bor">
                                        <thead class="background-thead pad">
                                            <tr align="center">
                                                <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-sun-o"></i> Días:</strong></th>
                                                <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-clock-o"></i> Horario</strong></th>
                                                <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-map-marker"></i> Ubicación</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody style="border-top: 2px solid #fff;">
                                            @foreach($horarios_encomienda as $horario)
                                            <tr>
                                                <td class="color-td" align="center">{{$horario->ho_dias}}</td>
                                                <td class="color-td" align="center">{{$horario->ho_desde}} - {{$horario->ho_hasta}}</td>
                                                <td class="color-td" align="center">{{$ubicacion_encomienda}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('js')

@endsection