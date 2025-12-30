@extends('Administrador.Layout.app_pagina_web')
@section('css')
<style>
    .breadcrumb-area {
        background-image: url(./Imagenes/banner.jpg);
        background-attachment: scroll;
    }
</style>
<!-- imgaen 1920x300 px-->
@endsection


@section('content')
<section id="breadcrumb-section" class="breadcrumb-area breadcrumb-center">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12">
                <div class="breadcrumb-content">
                    <div class="breadcrumb-heading">
                        <h2>NOSOTROS</h2>
                    </div>
                    <ol class="breadcrumb-list">
                        <li></li>
                        <li class="active">Misión y Visión</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</section>
<section id="post-section" class="post-section av-py-default-100 blog-page">
    <div class="av-container">
        <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <!--<p class="has-text-align-justify has-text-color margin-b-no" style="color:#009fe3;font-size:15px">La EMPRESA PÚBLICA MOVILIDAD DE MANTA-EP, en ayuda a nuestra comunidad damos a conocer nuestras principales noticias, con la finalidad de formar parte del desarrollo de nuestra hermosa ciudad, ACALDÍA DE MANTA siempre firmes con el cambio.</p>-->
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)" id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                    <!--<div class="tpg-widget-heading-wrapper heading-style1 "><span class="tpg-widget-heading-line line-left"></span>
                        <h2 class="tpg-widget-heading">NOTICIAS MOVILIDAD MANTA</h2><span class="tpg-widget-heading-line"></span>-->
                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even mt-4 ">
                    <p class="justify" align="center">
                        <strong>Empresa Pública Municipal Movilidad de Manta EP</strong>
                    </p>
                    <p class="justify">
                        El 31 de agosto de 2021 el Concejo Cantonal, aprueba la ordenanza reformatoria que crea la
                        Empresa Pública Municipal Movilidad de Manta EP, asumiendo las competencias de movilidad,
                        tránsito, seguridad vial y transporte.

                        Esta acertada decisión de unificar a la Terminal Terrestre con la Dirección de Transito, volvió
                        más eficiente las gestiones administrativas y económicas de ambas entidades, que ahora proyecta
                        buenos resultados.
                    </p>
                    @foreach($json_data as $data)
                    <div class="rt-col-md-12 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                        <div class="rt-holder sha-no">
                            <div class="rt-img-holder">
                                <a class="" href="https://web.movilidadmanta.gob.ec/2022/05/10/transporte-terrestre-transito-y-seguridad-vial-2/"></a>
                            </div>
                            <div class="rt-detail pad-no pad-h">
                                <!---<h5 class="entry-title text-ali-titu">
                                    <a class="color-ti" href="https://web.movilidadmanta.gob.ec/2022/05/10/transporte-terrestre-transito-y-seguridad-vial-2/"></a>
                                </h5>-->
                                <div class="post-meta-user">
                                    <span class="date">
                                        <i class="far fa-calendar-alt"></i>
                                        <strong>Misión</strong>
                                    </span>
                                </div>
                                <div class="">
                                    <p class="justify">{{$data->nos_mision}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rt-col-md-12 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                        <div class="rt-holder sha-no">
                            <div class="rt-img-holder">
                                <a href="https://web.movilidadmanta.gob.ec/2022/05/10/transporte-terrestre-transito-y-seguridad-vial-2/"></a>
                            </div>
                            <div class="rt-detail pad-no pad-h">
                                <!---<h5 class="entry-title text-ali-titu">
                                    <a class="color-ti" href="https://web.movilidadmanta.gob.ec/2022/05/10/transporte-terrestre-transito-y-seguridad-vial-2/"></a>
                                </h5>-->
                                <div class="post-meta-user  ">
                                    <span class="date">
                                        <i class="far fa-calendar-alt"></i>
                                        <strong>Visión</strong>
                                    </span>
                                </div>
                                <div>
                                    <p class="justify">{{$data->nos_vision}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('js')

@endsection