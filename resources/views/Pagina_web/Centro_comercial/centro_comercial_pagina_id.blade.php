@extends('Administrador.Layout.app_pagina_web')
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
</style>
@endsection


@section('content')
<section id="breadcrumb-section" class="breadcrumb-area breadcrumb-center">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12">
                <div class="breadcrumb-content">
                    <div class="breadcrumb-heading">
                        <h2>Centro Comercial</h2>
                    </div>

                    <ol class="breadcrumb-list">
                        <li><a href="/terminal">Inicio > Terminal</a> &nbsp;&gt;&nbsp;</li>
                        <li class="active">Centro Comercial</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> <!-- container -->
</section>

<section id="post-section" class="post-section av-py-default-100 blog-page">
    <div class="av-container width-t-100-n">
        <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <!--<p class="has-text-align-justify has-text-color margin-b-no" style="color:#009fe3;font-size:15px">La EMPRESA PÚBLICA MOVILIDAD DE MANTA-EP, en ayuda a nuestra comunidad damos a conocer nuestras principales noticias, con la finalidad de formar parte del desarrollo de nuestra hermosa ciudad, ACALDÍA DE MANTA siempre firmes con el cambio.</p>-->
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)" id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                    <!--<div class="tpg-widget-heading-wrapper heading-style1 "><span class="tpg-widget-heading-line line-left"></span>
                        <h2 class="tpg-widget-heading">NOTICIAS MOVILIDAD MANTA</h2><span class="tpg-widget-heading-line"></span>-->
                </div>
                @foreach($json_data as $data)
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                    <div class="rt-col-md-12 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                        <h2 class="color-titu-pag" align="center">{{$data->tu_titulo}}</h2>
                        <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong class="color-fe">Manta</strong></span></div>
                        <div class="rt-holder sha-no">
                            <div class="rt-img-holder">
                                <a>
                                    <img src="/imagenes_turismo/{{$data->tu_ruta_foto}}" class="img-border-ra tam-img-no-100 rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>
                            <div class="rt-detail pad-no">
                                <div class="tpg-excerpt">
                                    <p class="justify">{{$data->tu_descripcion}}</p>
                                </div>
                                <!--<div class="tpg-excerpt">
                                    <h5 class="color-titu-pag" align="center"><strong>Ubicación</strong> </h5>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('js')

@endsection