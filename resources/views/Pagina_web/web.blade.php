@extends('Administrador.Layout.app_pagina_web2')
@section('css')
@endsection

@section('content')
<section id="slider-section" class="slider-wrapper">
    <div class="main-slider owl-carousel owl-theme">
        <div class="item" style="background-image:url('/valex/assets/img/terminal-manta.jpg') !important;">
            <div class="theme-slider">
                <div class="theme-table">
                    <div class="theme-table-cell">
                        <div class="av-container">
                            <div class="theme-content text-left">
                                <h3 data-animation="fadeInUp" data-delay="150ms">COOPERATIVAS DE TAXI</h3>
                                <p data-animation="fadeInLeft" data-delay="500ms">Nuestra moderna Terminal Terrestre presta el mejor servicio a las cooperativas de transporte de taxi a los usuarios.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" style="background-image:url('/valex/assets/img/terminal.jpg') !important;">
            <div class="theme-slider">
                <div class="theme-table">
                    <div class="theme-table-cell">
                        <div class="av-container">
                            <div class="theme-content text-center">
                                <h3 data-animation="fadeInUp" data-delay="150ms">COOPERATIVAS DE BUSES</h3>
                                <p data-animation="fadeInLeft" data-delay="500ms">Nuestra moderna Terminal Terrestre presta el mejor servicio a las cooperativas de transporte de buses a los usuarios.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="item" style="background-image:url('https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/04/CENTRO-COMERCIAL.jpg')">
            <div class="theme-slider">
                <div class="theme-table">
                    <div class="theme-table-cell">
                        <div class="av-container">
                            <div class="theme-content text-right">
                                <h3 data-animation="fadeInUp" data-delay="150ms">SERVICIOS COMERCIALES </h3>
                                <p data-animation="fadeInLeft" data-delay="500ms">Nuestra Terminal Terrestre ofrece una variedad de locales comerciales para realizar tus compras, y una completa opción gastronómica en su patio de comidas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                    <span class="text">COMO LLEGAR</span>
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
                                    <span class="text">COMO LLEGAR</span>
                                    <span class="title">AGENCIA DE TRANSITO</span>
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
                    <span class="ttl">SEGUIMOS FIRMES CON EL CAMBIO </span>

                    <h3>Trabajamos para ti <span class="av-heading animate-7"><span class="av-text-wrapper"><b class="is-hide">ALCALDÍA DE MANTA </b> <b class="is-show">ALCALDÍA DE MANTA</b><b class="is-hide">ALCALDÍA DE MANTA</b></span></span></h3>


                    <p>Desde la Empresa Pública Movilidad de Manta se trabaja para dar seguridad en las vías, promover el cumplimiento de la Ley de Tránsito; y administrar la Terminal Terrestre y su centro comercial de forma eficaz.</p>

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
                        <h5 class="service-title"><a href="/rendicion-cuenta">COOPERATIVAS</a></h5>
                        <p>Comprometidos con la gestión la de nuestra administración la EMPRESA PÚBLICA MOVILIDAD DE MANTA-EP presenta nuestros documentos para constatar la transparencia de nuestra administración </p>
                        <a href="/rendicion-de-cuentas"><i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="av-column-4 av-md-column-6 mb-1 p-0">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fa fa-list txt-pink"></i>
                    </div>
                    <div class="service-content">
                        <h5 class="service-title"><a href="/nosotro">ENCOMIENDAS</a></h5>
                        <p>La principal filosofía de la Empresa Pública Movilidad de Manta es el servicio a la comunidad. En este espacio se difunde la Misión y Visión que tenemos para dar cumplimiento a ese objetivo.</p>
                        <a href="https://web.movilidadmanta.gob.ec/nosotros"><i class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="av-column-4 av-md-column-6 mb-1 p-0">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fa fa-play txt-pink"></i>
                    </div>
                    <div class="service-content">
                        <h5 class="service-title"><a href="/noticia">BOLETERIAS</a></h5>
                        <p>La EMPRESA PÚBLICA MOVILIDAD DE MANTA-EP, quiere que usted sea participe de nuestras actividades cotidianas, y de nuestro compromiso para ayudar y solventar los problemas de nuestra ciudadanía</p>
                        <a href="https://sgi.movilidadmanta.gob.ec/noticias"><i class="fa fa-long-arrow-right"></i></a>
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
                    <h1><strong>LOCALES COMERCIALES</strong></h1>
                </span>
            </div>
        </div>

        <!--*-*-*-*-*-*-*-*-*-*- END BOOTSTRAP CAROUSEL *-*-*-*-*-*-*-*-*-*-->

        <div id="carouselExampleControls" class="carousel slide " data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active marg-bo">
                    <div class="cards-wrapper" style="display: flex;">
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item marg-bo">
                    <div class="cards-wrapper" style="display: flex;">
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item marg-bo">
                    <div class="cards-wrapper" style="display: flex;">
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                        <div class="card img-border-ra sha-no-index">
                            <div class="rt-img-holder">
                                <a class="" href="#" target="_blank">
                                    <img src="/imagenes_noticias/noticia202206215006.jpeg" class="img-border-ra  tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-ali-titu">Título de la tarjeta</h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>02-07-2022</strong></span></div>
                                <p class="card-text text-ali-des">Un texto de ejemplo rápido para colocal cerca del título de la tarjeta y componer la mayor parte del contenido de la tarjeta.</p>
                                <a class="btn-noticia btn-ri" href="#" target="_blank">Leer mas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev back-marg" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next back-marg" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
        <!--<div class="av-columns-area wow fadeInUp" style="visibility: hidden; animation-name: none;">
            <div class="av-column-4 av-md-column-6 mb-4 mb-av-0">
                <article class="post-items">
                    <figure class="post-image">
                        <a href="https://web.movilidadmanta.gob.ec/2022/05/10/transporte-terrestre-transito-y-seguridad-vial-2/" class="post-hover">
                            <img width="1126" height="1407" src="./Empresa Publica Movilidad Manta Ep sitio oficial de contacto directo_files/280321855_306793001621489_8608781696313307552_n-1.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image jetpack-lazy-image" alt="" loading="lazy" data-lazy-src="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/05/280321855_306793001621489_8608781696313307552_n-1.jpg?is-pending-load=1" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"> </a>
                        <span class="posted-on post-date">
                            <a href="https://web.movilidadmanta.gob.ec/2022/05/"><span>10</span>May, 2022</a>
                        </span>
                        <div class="post-meta imu">
                            <span class="post-list">
                                <ul class="post-categories">
                                    <li><a href="https://web.movilidadmanta.gob.ec/2022/05/10/transporte-terrestre-transito-y-seguridad-vial-2/"></a><a href="https://web.movilidadmanta.gob.ec/category/noticas-movilidad-de-manta/" rel="category tag">Noticas</a></li>
                                </ul>
                            </span>
                        </div>
                    </figure>
                    <div class="post-content">
                        <div class="post-meta up">
                            <span class="posted-on">
                                <a href="https://web.movilidadmanta.gob.ec/2022/05/">May 10 2022</a>
                            </span>
                        </div>
                        <h5 class="post-title"><a href="https://web.movilidadmanta.gob.ec/2022/05/10/transporte-terrestre-transito-y-seguridad-vial-2/" rel="bookmark">Transporte Terrestre, Tránsito y Seguridad Vial</a></h5>
                        <p class="has-text-align-justify">La madrugada de este lunes 9 de mayo, día de regreso a clases presenciales, delincuentes robaron los controladores de dos semáforos en zonas escolares de la ciudad.</p>



                        <p class="has-text-align-justify">Los dispositivos fueron sacados de las cajas de control ubicadas en la parte alta de los postes de los semáforos. Los robos se reportaron en la calle 304 y avenida 215 (Interbarrial), y en la calle 8 y avenida 24 (colegio Manta).</p>



                        <p class="has-text-align-justify">Ambos atentados están siendo investigados. Aparentemente los ladrones conocen con exactitud el funcionamiento del controlador semafórico ya que se llevaron las piezas exactas para impedir que las luces enciendan.</p>



                        <p class="has-text-align-justify">Mientras se reponen los equipos, los agentes civiles de tránsito dirigen el tránsito para evitar accidentes y brindar seguridad a conductores y peatones.</p>

                        <div class="post-meta down">
                            <span class="author-name">
                                <i class="fa fa-user-secret"></i> <a href="https://web.movilidadmanta.gob.ec/author/MovilidadEp/">MovilidadEp</a>
                            </span>
                            <span class="comments-link">
                                <i class="fa fa-comment"></i> <a href="https://web.movilidadmanta.gob.ec/2022/05/10/transporte-terrestre-transito-y-seguridad-vial-2/#respond">0 Comentarios</a>
                            </span>
                        </div>
                    </div>
                </article>
            </div>
            <div class="av-column-4 av-md-column-6 mb-4 mb-av-0">
                <article class="post-items">
                    <figure class="post-image">
                        <a href="https://web.movilidadmanta.gob.ec/2022/04/28/%f0%9d%97%9f%f0%9d%97%ae-%f0%9d%97%a7%f0%9d%97%b2%f0%9d%97%bf%f0%9d%97%ba%f0%9d%97%b6%f0%9d%97%bb%f0%9d%97%ae%f0%9d%97%b9-%f0%9d%97%a7%f0%9d%97%b2%f0%9d%97%bf%f0%9d%97%bf%f0%9d%97%b2%f0%9d%98%80/" class="post-hover">
                            <img width="1024" height="611" src="./Empresa Publica Movilidad Manta Ep sitio oficial de contacto directo_files/capacitacion.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image jetpack-lazy-image" alt="" loading="lazy" data-lazy-src="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/04/capacitacion.jpg?is-pending-load=1" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"> </a>
                        <span class="posted-on post-date">
                            <a href="https://web.movilidadmanta.gob.ec/2022/04/"><span>28</span>Abr, 2022</a>
                        </span>
                        <div class="post-meta imu">
                            <span class="post-list">
                                <ul class="post-categories">
                                    <li><a href="https://web.movilidadmanta.gob.ec/2022/04/28/%f0%9d%97%9f%f0%9d%97%ae-%f0%9d%97%a7%f0%9d%97%b2%f0%9d%97%bf%f0%9d%97%ba%f0%9d%97%b6%f0%9d%97%bb%f0%9d%97%ae%f0%9d%97%b9-%f0%9d%97%a7%f0%9d%97%b2%f0%9d%97%bf%f0%9d%97%bf%f0%9d%97%b2%f0%9d%98%80/"></a><a href="https://web.movilidadmanta.gob.ec/category/noticas-movilidad-de-manta/" rel="category tag">Noticas</a></li>
                                </ul>
                            </span>
                        </div>
                    </figure>
                    <div class="post-content">
                        <div class="post-meta up">
                            <span class="posted-on">
                                <a href="https://web.movilidadmanta.gob.ec/2022/04/">Abr 28 2022</a>
                            </span>
                        </div>
                        <h5 class="post-title"><a href="https://web.movilidadmanta.gob.ec/2022/04/28/%f0%9d%97%9f%f0%9d%97%ae-%f0%9d%97%a7%f0%9d%97%b2%f0%9d%97%bf%f0%9d%97%ba%f0%9d%97%b6%f0%9d%97%bb%f0%9d%97%ae%f0%9d%97%b9-%f0%9d%97%a7%f0%9d%97%b2%f0%9d%97%bf%f0%9d%97%bf%f0%9d%97%b2%f0%9d%98%80/" rel="bookmark">𝗟𝗮 𝗧𝗲𝗿𝗺𝗶𝗻𝗮𝗹 𝗧𝗲𝗿𝗿𝗲𝘀𝘁𝗿𝗲 𝗱𝗲 𝗠𝗮𝗻𝘁𝗮 𝗰𝗮𝗽𝗮𝗰𝗶𝘁𝗮 𝗮 𝘀𝘂 𝗽𝗲𝗿𝘀𝗼𝗻𝗮𝗹 𝗽𝗮𝗿𝗮 𝗳𝗼𝗿𝘁𝗮𝗹𝗲𝗰𝗲𝗿 𝗹𝗮 𝘀𝗲𝗴𝘂𝗿𝗶𝗱𝗮𝗱</a></h5>
                        <p class="has-text-align-justify">El personal del centro de monitoreo de cámaras de seguridad de la Terminal Terrestre de Manta recibió una capacitación para mejorar el servicio que se brinda a los usuarrios.</p>
                        <p class="has-text-align-justify">Durante la jornada, llevada a cabo en la Terminal Terrestre este 27 de abril y dictada por personal del ECU 911, los funcionarios fortalecieron sus conocimientos en identificación de perfiles sospechosos y aprendieron técnicas de paneo y acercamiento con las cámaras.</p>
                        <p class="has-text-align-justify">Al finalizar la capacitación, integrantes del ECU 911 recorrieron el área de monitoreo y recibieron una explicación del trabajo que se realiza desde el centro.</p>
                        <p><a href="https://web.facebook.com/hashtag/firmesconelcambio?__eep__=6&amp;source=feed_text&amp;epa=HASHTAG&amp;__xts__%5B0%5D=68.ARDGAmTGjyZeEvfrJpywfP3MsbDbEMzJsryVzqxqY2BIEymesJ-OGtD2AyKwymqvRrO8dFvYOToxVRIDZ3FqzEH6kOBZw-ybFVSQc83U-R-sBILHG1VO982KMi-RqBS2v7NJApiQnrEMohBmYvApvE_onwB50lCs-E8t3yOBl4Z_PlBa6jjughDrHnXFs4HmLxxqunOE_VayoAMvzilO6YHsw_TQSe7omgwhaXetmj4pdhLW4b7doO4Dg4MTaklZIxmNIyR0ZuR6SLWI5LGIuTMwWcALN5iC4DLXdBSY6opCIDr2LXY&amp;__tn__=%2ANK-R">#FirmesConElCambio</a><br><a href="https://web.facebook.com/hashtag/mantainfinita?__eep__=6&amp;source=feed_text&amp;epa=HASHTAG&amp;__xts__%5B0%5D=68.ARDGAmTGjyZeEvfrJpywfP3MsbDbEMzJsryVzqxqY2BIEymesJ-OGtD2AyKwymqvRrO8dFvYOToxVRIDZ3FqzEH6kOBZw-ybFVSQc83U-R-sBILHG1VO982KMi-RqBS2v7NJApiQnrEMohBmYvApvE_onwB50lCs-E8t3yOBl4Z_PlBa6jjughDrHnXFs4HmLxxqunOE_VayoAMvzilO6YHsw_TQSe7omgwhaXetmj4pdhLW4b7doO4Dg4MTaklZIxmNIyR0ZuR6SLWI5LGIuTMwWcALN5iC4DLXdBSY6opCIDr2LXY&amp;__tn__=%2ANK-R">#MantaInfinita</a><br><a href="https://web.facebook.com/hashtag/ciudadcentenaria?__eep__=6&amp;source=feed_text&amp;epa=HASHTAG&amp;__xts__%5B0%5D=68.ARDGAmTGjyZeEvfrJpywfP3MsbDbEMzJsryVzqxqY2BIEymesJ-OGtD2AyKwymqvRrO8dFvYOToxVRIDZ3FqzEH6kOBZw-ybFVSQc83U-R-sBILHG1VO982KMi-RqBS2v7NJApiQnrEMohBmYvApvE_onwB50lCs-E8t3yOBl4Z_PlBa6jjughDrHnXFs4HmLxxqunOE_VayoAMvzilO6YHsw_TQSe7omgwhaXetmj4pdhLW4b7doO4Dg4MTaklZIxmNIyR0ZuR6SLWI5LGIuTMwWcALN5iC4DLXdBSY6opCIDr2LXY&amp;__tn__=%2ANK-R">#CiudadCentenaria</a></p>
                        <div class="post-meta down">
                            <span class="author-name">
                                <i class="fa fa-user-secret"></i> <a href="https://web.movilidadmanta.gob.ec/author/MovilidadEp/">MovilidadEp</a>
                            </span>
                            <span class="comments-link">
                                <i class="fa fa-comment"></i> <a href="https://web.movilidadmanta.gob.ec/2022/04/28/%f0%9d%97%9f%f0%9d%97%ae-%f0%9d%97%a7%f0%9d%97%b2%f0%9d%97%bf%f0%9d%97%ba%f0%9d%97%b6%f0%9d%97%bb%f0%9d%97%ae%f0%9d%97%b9-%f0%9d%97%a7%f0%9d%97%b2%f0%9d%97%bf%f0%9d%97%bf%f0%9d%97%b2%f0%9d%98%80/#respond">0 Comentarios</a>
                            </span>
                        </div>
                    </div>
                </article>
            </div>
            <div class="av-column-4 av-md-column-6 mb-4 mb-av-0">
                <article class="post-items">
                    <figure class="post-image">
                        <a href="https://web.movilidadmanta.gob.ec/2022/04/28/transporte-terrestre-transito-y-seguridad-vial/" class="post-hover">
                            <img width="960" height="960" src="./Empresa Publica Movilidad Manta Ep sitio oficial de contacto directo_files/279370375_298663989101057_176861042441778888_n.jpg" class="attachment-post-thumbnail size-post-thumbnail wp-post-image jetpack-lazy-image" alt="" loading="lazy" data-lazy-src="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/04/279370375_298663989101057_176861042441778888_n.jpg?is-pending-load=1" srcset="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"> </a>
                        <span class="posted-on post-date">
                            <a href="https://web.movilidadmanta.gob.ec/2022/04/"><span>28</span>Abr, 2022</a>
                        </span>
                        <div class="post-meta imu">
                            <span class="post-list">
                                <ul class="post-categories">
                                    <li><a href="https://web.movilidadmanta.gob.ec/2022/04/28/transporte-terrestre-transito-y-seguridad-vial/"></a><a href="https://web.movilidadmanta.gob.ec/category/noticas-movilidad-de-manta/" rel="category tag">Noticas</a></li>
                                </ul>
                            </span>
                        </div>
                    </figure>
                    <div class="post-content">
                        <div class="post-meta up">
                            <span class="posted-on">
                                <a href="https://web.movilidadmanta.gob.ec/2022/04/">Abr 28 2022</a>
                            </span>
                        </div>
                        <h5 class="post-title"><a href="https://web.movilidadmanta.gob.ec/2022/04/28/transporte-terrestre-transito-y-seguridad-vial/" rel="bookmark">Transporte Terrestre, Tránsito y Seguridad Vial</a></h5>
                        <p class="has-text-align-justify">Tras una reforma de la Ley de Tránsito, cada vez que el conductor de un vehículo sea sancionado con una multa puede beneficiarse con un descuento del 50%.</p>
                        <p class="has-text-align-justify">Este beneficio está disponible para quienes hagan el pago de la sanción durante los primeros 20 días tras haber recibido la notificación.</p>
                        <p class="has-text-align-justify">El descuento se sustenta en la Disposición General Trigésima cuarta de la Ley Orgánica de Transporte Terrestre, que señala que las personas que paguen las multas de tránsito al término de 20 días, serán beneficiarias del 50% de reducción del monto de la multa respectiva.</p>
                        <p class="has-text-align-justify">Esto quiere decir que, por ejemplo, si el conductor fue amonestado con 42 dólares por mal estacionamiento y decide pagar su multa en los 20 días posteriores a la sanción, solo deberá cancelar 21 dólares.</p>
                        <p>Al consultar la multa en el sistema, el descuento se verá reflejado automáticamente durante los 20 días de vigencia.</p>
                        <p><a href="https://web.facebook.com/hashtag/firmesconelcambio?__eep__=6&amp;source=feed_text&amp;epa=HASHTAG&amp;__xts__%5B0%5D=68.ARCK5fsH1tCvhV-ca3hBEpzPyJ7q-ZPt5tk8Jxd97U7psOEACpthInX8CQmJQk_FoTXbxM5qdaNtioAyKdtCENPfJC-3yIaWhV3m-Chgy8VDZRrNq5wrgxrO5dLu1AhSer5ZZgsjgp12nJ03_p8ZkY8LLagwmyYEMkrDD0CNmlOqlRYK6Y8YbdIdqYGJ3Wto7Sb4PBAWaBz2X2zog5lhBvexOekvCtE-no1dWhdKQxWzdKhDegIdNaAd22HrOKGURtrfJlf8djCpKTYrka0n8wNHXKPkhi-QhR4CBr74BQv0DtQZ1-s&amp;__tn__=%2ANK-R">#FirmesConElCambio</a><br><a href="https://web.facebook.com/hashtag/mantainfinita?__eep__=6&amp;source=feed_text&amp;epa=HASHTAG&amp;__xts__%5B0%5D=68.ARCK5fsH1tCvhV-ca3hBEpzPyJ7q-ZPt5tk8Jxd97U7psOEACpthInX8CQmJQk_FoTXbxM5qdaNtioAyKdtCENPfJC-3yIaWhV3m-Chgy8VDZRrNq5wrgxrO5dLu1AhSer5ZZgsjgp12nJ03_p8ZkY8LLagwmyYEMkrDD0CNmlOqlRYK6Y8YbdIdqYGJ3Wto7Sb4PBAWaBz2X2zog5lhBvexOekvCtE-no1dWhdKQxWzdKhDegIdNaAd22HrOKGURtrfJlf8djCpKTYrka0n8wNHXKPkhi-QhR4CBr74BQv0DtQZ1-s&amp;__tn__=%2ANK-R">#MantaInfinita</a><br><a href="https://web.facebook.com/hashtag/ciudadcentenaria?__eep__=6&amp;source=feed_text&amp;epa=HASHTAG&amp;__xts__%5B0%5D=68.ARCK5fsH1tCvhV-ca3hBEpzPyJ7q-ZPt5tk8Jxd97U7psOEACpthInX8CQmJQk_FoTXbxM5qdaNtioAyKdtCENPfJC-3yIaWhV3m-Chgy8VDZRrNq5wrgxrO5dLu1AhSer5ZZgsjgp12nJ03_p8ZkY8LLagwmyYEMkrDD0CNmlOqlRYK6Y8YbdIdqYGJ3Wto7Sb4PBAWaBz2X2zog5lhBvexOekvCtE-no1dWhdKQxWzdKhDegIdNaAd22HrOKGURtrfJlf8djCpKTYrka0n8wNHXKPkhi-QhR4CBr74BQv0DtQZ1-s&amp;__tn__=%2ANK-R">#CiudadCentenaria</a><br><a href="https://web.facebook.com/hashtag/movilidadsegura?__eep__=6&amp;source=feed_text&amp;epa=HASHTAG&amp;__xts__%5B0%5D=68.ARCK5fsH1tCvhV-ca3hBEpzPyJ7q-ZPt5tk8Jxd97U7psOEACpthInX8CQmJQk_FoTXbxM5qdaNtioAyKdtCENPfJC-3yIaWhV3m-Chgy8VDZRrNq5wrgxrO5dLu1AhSer5ZZgsjgp12nJ03_p8ZkY8LLagwmyYEMkrDD0CNmlOqlRYK6Y8YbdIdqYGJ3Wto7Sb4PBAWaBz2X2zog5lhBvexOekvCtE-no1dWhdKQxWzdKhDegIdNaAd22HrOKGURtrfJlf8djCpKTYrka0n8wNHXKPkhi-QhR4CBr74BQv0DtQZ1-s&amp;__tn__=%2ANK-R">#MovilidadSegura</a></p>

                        <div class="post-meta down">
                            <span class="author-name">
                                <i class="fa fa-user-secret"></i> <a href="https://web.movilidadmanta.gob.ec/author/MovilidadEp/">MovilidadEp</a>
                            </span>
                            <span class="comments-link">
                                <i class="fa fa-comment"></i> <a href="https://web.movilidadmanta.gob.ec/2022/04/28/transporte-terrestre-transito-y-seguridad-vial/#respond">0 Comentarios</a>
                            </span>
                        </div>
                    </div>
                </article>
            </div>
        </div>-->
    </div>
</section>

@endsection

@section('js')

@endsection