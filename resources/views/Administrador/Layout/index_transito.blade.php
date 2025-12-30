@extends('Administrador.Layout.app_pagina_web')
@section('css')
<style>
    .carousel-indicators [data-bs-target] {
        background-color: #000 !important;
    }

    .card-text {
        display: -webkit-box !important;
        -webkit-line-clamp: 4 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
        text-align: justify !important;
    }

    .card-img,
    .card-img-top {
        height: 250px !important;
    }

    .al_btn {
        display: flex;
        justify-content: end;
        margin-top: 1.5em;
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
<section id="slider-section" class="slider-wrapper">
    <div class="main-slider owl-carousel owl-theme">
        <!--<div class="item" style="background-image:url('https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/04/FOTO-CON-MEDIDAS-2.jpg')">-->
        @foreach($json_data_slider_slider as $data)
        <div class="item" style="background-image:url('/imagenes_slider/{{$data->sl_ruta_foto}}') !important;">
            <div class="theme-slider">
                <div class="theme-table">
                    <div class="theme-table-cell">
                        <div class="av-container">
                            <div class="theme-content text-left">
                                <h3 data-animation="fadeInUp" data-delay="150ms">{{$data->sl_titulo}}</h3>
                                <p data-animation="fadeInLeft" data-delay="500ms">{{$data->sl_descripcion}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
</section>
<div id="info-section" class="info-section">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12">
                <ul class="info-wrapper wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                    <li class="info-first">
                        <aside class="widget widget-contact">
                            <div class="contact-area">
                                <div class="contact-icon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <a href="#" class="contact-info">
                                    <span class="text">ABIERTO LUNES A DOMINGO</span>
                                    <span class="title">PATIO DE COMIDAS</span>
                                </a>
                            </div>
                        </aside>
                    </li>
                    <li class="info-second">
                        <aside class="widget widget-contact">
                            <div class="contact-area">
                                <div class="contact-icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <a target="_blank" href="https://www.google.com/maps/place/Terminal+Terrestre+De+Manta/@-0.9606578,-80.6926596,17z/data=!3m1!4b1!4m5!3m4!1s0x902be69a8c47e8ab:0xd2d4d38082b8b234!8m2!3d-0.9606632!4d-80.6904709" class="contact-info">
                                    <span class="text">CÓMO LLEGAR</span>
                                    <span class="title">TERMINAL TERRESTRE</span>
                                </a>
                            </div>
                        </aside>
                    </li>
                    <li class="info-third">
                        <aside class="widget widget-contact">
                            <div class="contact-area">
                                <div class="contact-icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <a target="_blank" href="https://www.google.com/maps/place/Agencia+Municipal+De+Transirootto+Manta/@-0.9559469,-80.6985823,17z/data=!3m1!4b1!4m5!3m4!1s0x902be76e3f079e51:0xb15638f73f7e0210!8m2!3d-0.9559109!4d-80.6943569" class="contact-info">
                                    <span class="text">CÓMO LLEGAR</span>
                                    <span class="title">AGENCIA DE TRÁNSITO</span>
                                </a>
                            </div>
                        </aside>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<section id="service-section" class="service-section service-section-hover av-py-default service-home">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12">
                <div class="heading-default wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                    <span class="ttl">SEGUIMOS FIRMES CON EL CAMBIO</span>
                    <h3>
                        Trabajamos para ti
                        <span class="av-heading animate-7">
                            <span class="av-text-wrapper">
                                <b class="is-hide">ALCALDÍA DE MANTA</b>
                                <b class="is-show">ALCALDÍA DE MANTA</b>
                                <b class="is-hide">ALCALDÍA DE MANTA</b>

                            </span>
                        </span>
                    </h3>
                    <p>
                        Desde la Empresa Pública Movilidad de Manta se trabaja para dar seguridad en las vías, promover
                        el cumplimiento de la Ley de Tránsito; y administrar la Terminal Terrestre y su centro comercial
                        de forma eficaz.
                    </p>
                </div>
            </div>
        </div>

        <div class="av-columns-area wow fadeInUp service-row" style="visibility: visible; animation-name: fadeInUp;">
            <div class="av-column-4 av-md-column-6 mb-1 p-0">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fa fa-folder-open-o txt-pink"></i>
                    </div>
                    <div class="service-content">
                        <h5 class="service-title">
                            <a href="/rendicion-cuenta">TRANSPARENCIA</a>
                        </h5>
                        <p>
                            Comprometidos con la gestión la de nuestra administración la EMPRESA PÚBLICA MUNICIPAL
                            MOVILIDAD DE
                            MANTA-EP presenta nuestros documentos para constatar la transparencia de nuestra
                            administración
                        </p>
                        <a href="/rendicion-cuenta">
                            <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="av-column-4 av-md-column-6 mb-1 p-0">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fa fa-list txt-pink"></i>
                    </div>
                    <div class="service-content">
                        <h5 class="service-title">
                            <a href="/nosotros">QUIÉNES SOMOS</a>
                        </h5>
                        <p>
                            La principal filosofía de la EMPRESA PÚBLICA MUNICIPAL MOVILIDAD DE
                            MANTA-EP es el servicio a la
                            comunidad. En este espacio se difunde la Misión y Visión que tenemos para dar cumplimiento a
                            ese objetivo.
                        </p>
                        <a href="/nosotros">
                            <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="av-column-4 av-md-column-6 mb-1 p-0">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fa fa-play txt-pink"></i>
                    </div>
                    <div class="service-content">
                        <h5 class="service-title">
                            <a href="/noticia-dtm">NOTICIAS</a>
                        </h5>
                        <p>
                            La EMPRESA PÚBLICA MUNICIPAL MOVILIDAD DE
                            MANTA-EP, quiere que usted sea participe de nuestras
                            actividades cotidianas, y de nuestro compromiso para ayudar y solventar los problemas de
                            nuestra ciudadanía
                        </p>
                        <a href="/noticia-dtm">
                            <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="indicator"></div>
        </div>
    </div>
</section>
<section id="post-section" class="post-section post-shadow av-py-default home-blog">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12 heading-default wow fadeInUp">
                <span class="ttl ">
                    <h1>
                        <strong>NOTICIAS</strong>
                    </h1>
                </span>
            </div>
        </div>
        <div>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @if(sizeof($result_array_1)>0)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    @endif
                    @if(sizeof($result_array_2)>0)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    @endif
                    @if(sizeof($result_array_3)>0)
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    @endif
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="flex">
                            @foreach($result_array_1 as $data1)
                            <div class="card" style="width: 18rem;">
                                <div class="rt-holder-no sha-no">
                                    <div class="rt-img-holder">
                                        <a class="" href="/noticia/{{$data1->id_noticia_hash}}/1" target="_blank"></a>
                                        <img src="/imagenes_noticias/{{$data1->no_ruta_foto}}" class="img-border-ra tam-img-no rt-img-responsive jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                                    </div>
                                    <div class="rt-detail pad-no">
                                        <h5 class="entry-title text-ali-titu">
                                            <a class="color-ti" target="_blank" href="/noticia/{{$data1->id_noticia_hash}}/1">{{$data1->no_titulo}}</a>
                                        </h5>

                                        <div class="post-meta-user  "><span class="date"><i class="fa fa-clock-o"></i><strong> {{$data1->no_fecha}}
                                                </strong></span></div>
                                        <div class="tpg-excerpt">
                                            <p class="text-ali-des">@php echo ($data1->no_descripcion)@endphp</p>
                                        </div>
                                        <div class="btn-le">
                                            <span class="btn-social btn-social-facebook">
                                                <a href="http://www.facebook.com/sharer.php?u={{url('')}}/noticia/{{$data1->id_noticia_hash}}/1&t=Noticia DTM: {{$data1->no_titulo}}" target="_blank" class="facebook">
                                                    <i class="fa fa-facebook-official" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="btn-le">
                                            <span class="btn-social btn-social-twitter">
                                                <a href="https://twitter.com/intent/tweet?text=Noticia DTM: {{$data1->no_titulo}}&url={{url('')}}/noticia/{{$data1->id_noticia_hash}}/1&via=MantaAMT&hashtags=#ElCambioSigue" target="_blank" class="twitter">
                                                    <i class="fa fa-twitter-square" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="post-meta btn-ri">
                                            <span class="read-more margin-bo">
                                                <a class="btn-noticia" href="/noticia/{{$data1->id_noticia_hash}}/1" target="_blank">Leer mas</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="card" style="width: 18rem;">
                                <img src="/imagenes_noticias/{{$data1->no_ruta_foto}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{$data1->no_titulo}}</h5>
                                    <div class="card-text">@php echo ($data1->no_descripcion)@endphp</div>
                                    <div class="al_btn">
                                        <a href="/noticia/{{$data1->id_noticia_hash}}" class="btn-noticia btn-ri">Leer
                                            mas...</a>
                                    </div>
                                </div>
                            </div>-->
                            @endforeach
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="flex">
                            @foreach($result_array_2 as $data1)

                            <div class="card" style="width: 18rem;">
                                <div class="rt-holder-no sha-no">
                                    <div class="rt-img-holder">
                                        <a class="" href="/noticia/{{$data1->id_noticia_hash}}/1" target="_blank"></a>
                                        <img src="/imagenes_noticias/{{$data1->no_ruta_foto}}" class="img-border-ra tam-img-no rt-img-responsive jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                                    </div>
                                    <div class="rt-detail pad-no">
                                        <h5 class="entry-title text-ali-titu">
                                            <a class="color-ti" target="_blank" href="/noticia/{{$data1->id_noticia_hash}}/1">{{$data1->no_titulo}}</a>
                                        </h5>

                                        <div class="post-meta-user  "><span class="date"><i class="fa fa-clock-o"></i><strong> {{$data1->no_fecha}}
                                                </strong></span></div>
                                        <div class="tpg-excerpt">
                                            <p class="text-ali-des">@php echo ($data1->no_descripcion)@endphp</p>
                                        </div>
                                        <div class="btn-le">
                                            <span class="btn-social btn-social-facebook">
                                                <a href="http://www.facebook.com/sharer.php?u={{url('')}}/noticia/{{$data1->id_noticia_hash}}/1&t=Noticia DTM: {{$data1->no_titulo}}" target="_blank" class="facebook">
                                                    <i class="fa fa-facebook-official" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="btn-le">
                                            <span class="btn-social btn-social-twitter">
                                                <a href="https://twitter.com/intent/tweet?text=Noticia DTM: {{$data1->no_titulo}}&url={{url('')}}/noticia/{{$data1->id_noticia_hash}}/1&via=MantaAMT&hashtags=#ElCambioSigue" target="_blank" class="twitter">
                                                    <i class="fa fa-twitter-square" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="post-meta btn-ri">
                                            <span class="read-more margin-bo">
                                                <a class="btn-noticia" href="/noticia/{{$data1->id_noticia_hash}}/1" target="_blank">Leer mas</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach

                        </div>
                    </div>

                    @if(sizeof($result_array_3)>0)
                    <div class="carousel-item">
                        <div class="flex">
                            @foreach($result_array_3 as $data1)

                            <div class="card" style="width: 18rem;">
                                <div class="rt-holder-no sha-no">
                                    <div class="rt-img-holder">
                                        <a class="" href="/noticia/{{$data1->id_noticia_hash}}/1" target="_blank"></a>
                                        <img src="/imagenes_noticias/{{$data1->no_ruta_foto}}" class="img-border-ra tam-img-no rt-img-responsive jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                                    </div>
                                    <div class="rt-detail pad-no">
                                        <h5 class="entry-title text-ali-titu">
                                            <a class="color-ti" target="_blank" href="/noticia/{{$data1->id_noticia_hash}}/1">{{$data1->no_titulo}}</a>
                                        </h5>

                                        <div class="post-meta-user  "><span class="date"><i class="fa fa-clock-o"></i><strong> {{$data1->no_fecha}}
                                                </strong></span></div>
                                        <div class="tpg-excerpt">
                                            <p class="text-ali-des">@php echo ($data1->no_descripcion)@endphp</p>
                                        </div>
                                        <div class="btn-le">
                                            <span class="btn-social btn-social-facebook">
                                                <a href="http://www.facebook.com/sharer.php?u={{url('')}}/noticia/{{$data1->id_noticia_hash}}/1&t=Noticia DTM: {{$data1->no_titulo}}" target="_blank" class="facebook">
                                                    <i class="fa fa-facebook-official" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="btn-le">
                                            <span class="btn-social btn-social-twitter">
                                                <a href="https://twitter.com/intent/tweet?text=Noticia DTM: {{$data1->no_titulo}}&url={{url('')}}/noticia/{{$data1->id_noticia_hash}}/1&via=MantaAMT&hashtags=#ElCambioSigue" target="_blank" class="twitter">
                                                    <i class="fa fa-twitter-square" aria-hidden="true"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="post-meta btn-ri">
                                            <span class="read-more margin-bo">
                                                <a class="btn-noticia" href="/noticia/{{$data1->id_noticia_hash}}/1" target="_blank">Leer mas</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach

                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>
@endsection

@section('js')

@endsection