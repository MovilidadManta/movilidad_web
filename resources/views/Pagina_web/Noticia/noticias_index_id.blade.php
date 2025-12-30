@extends('Administrador.Layout.app_pagina_web')
@section('metatags')
    @foreach($json_data as $data)
        @if ($loop->first)
        <meta property="og:title" content="Noticia: {{$data->no_titulo}}" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{url()->current()}}" />
        <meta property="og:image" content="{{url('')}}/imagenes_noticias/{{$data->no_ruta_foto}}" />
        <meta property="og:description" content="{{$data->no_descripcion}}" />
        <meta property="og:site_name" content="Movilidad de Manta EP" />
        <meta property="og:image:width" content="1200" /> 
        <meta property="og:image:height" content="630" />
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Movilidad de Manta - Noticia: {{$data->no_titulo}}">
        <meta property="twitter:url" content="{{url()->current()}}">
        <meta property="twitter:description" content="{{$data->no_descripcion}}" />
        <meta name="twitter:image" content="{{url('')}}/imagenes_noticias/{{$data->no_ruta_foto}}">
        <meta name="twitter:creator" content="{{$tipo == 1 ? '@MantaAMT' : '@TerminaldeManta'}}">
        @endif
    @endforeach
@endsection
@section('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
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

    .f_roboto {
        font-family: 'Roboto Slab', serif;
    }

    .f_parrafo {
        margin: 0 0 30px;
        color: inherit;
        line-height: 1.875;
        font-size: 18px;
        font-family: 'Cairo', sans-serif;
    }

    .btn-social{
        padding: 8px 5px;
        font-size: 35px;
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
        margin-top: 7px;
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

                        <h2>NOTICIA</h2>

                    </div>
                    @foreach($json_data as $data)
                    <ol class="breadcrumb-list">
                        <li></li>
                        <li class="active">{{$data->no_titulo}}</li>
                    </ol>
                    @endforeach
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
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                    @foreach($json_data as $data)
                    <div class="rt-col-md-12 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                        <h2 class="f_roboto">{{$data->no_titulo}}</h2>
                        <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong class="color-fe"> <i class="fa fa-clock-o"></i> {{$data->no_fecha}}</strong></span></div>
                        <div class="rt-holder sha-no">
                            <div class="rt-img-holder">
                                <a class="" href="https://web.movilidadmanta.gob.ec/2022/05/10/transporte-terrestre-transito-y-seguridad-vial-2/">
                                    <img src="/imagenes_noticias/{{$data->no_ruta_foto}}" class="img-border-ra tam-img-no-100 rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>
                            <div class="rt-detail pad-no pad-h">
                                <!---<h5 class="entry-title text-ali-titu">
                                    <a class="color-ti" href="https://web.movilidadmanta.gob.ec/2022/05/10/transporte-terrestre-transito-y-seguridad-vial-2/">{{$data->no_titulo}}</a>
                                </h5>-->

                                <div class="tpg-excerpt">
                                    <p class="justify f_parrafo">@php echo($data->no_descripcion) @endphp</p>
                                </div>
                                <br />
                                <div class="post-meta ">
                                    <span class="read-more">
                                        <a class="btn-noticia-100" href="https://www.facebook.com/hashtag/ElCambioSigue" target="_blank">#ElCambioSigue</a>
                                    </span>
                                </div>
                                <div class="btn-ri">
                                    <span class="btn-social btn-social-facebook">
                                        <a href="http://www.facebook.com/sharer.php?u={{url()->current()}}&t=Noticia {{$tipo == 1 ? 'DTM' : 'TTM'}}: {{$data->no_titulo}}" target="_blank" class="facebook">
                                            <i class="fa fa-facebook-official" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>
                                <div class="btn-ri">
                                    <span class="btn-social btn-social-twitter">
                                        <a href="https://twitter.com/intent/tweet?text=Noticia {{$tipo == 1 ? 'DTM' : 'TTM'}}: {{$data->no_titulo}}&url={{url()->current()}}&via={{$tipo == 1 ? 'MantaAMT' : 'TerminaldeManta'}}&hashtags=#ElCambioSigue" target="_blank" class="twitter">
                                            <i class="fa fa-twitter-square" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!--<div class="rt-pagination-wrap" data-total-pages="3" data-posts-per-page="6" data-type="pagination">
                        <div class="rt-pagination">
                            <ul class="pagination-list">
                                <li class="active"><span>1</span>

                                </li>
                                <li><a data-paged="2" href="https://web.movilidadmanta.gob.ec/noticias-movilidad-de-manta/page/2/">2</a></li>
                                <li><a data-paged="3" href="https://web.movilidadmanta.gob.ec/noticias-movilidad-de-manta/page/3/">3</a></li>
                            </ul>
                        </div>
                    </div>-->
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('js')

@endsection