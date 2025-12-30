@extends('Administrador.Layout.app_pagina_web')
@section('css')



<style>
.breadcrumb-area {
    background-image: url(./Imagenes/banner.jpg);
    background-attachment: scroll;
}

.post-cont ent-2 {
    width: 100% !important;
    padding: 0px 0px 0px !important;
}

.heig-q {
    height: 100% !important;
}

.hei-po {
    height: 19em !important;
}

.hei-po-m {
    height: 15em !important;
}

.av {
    padding: 0px 220px !important;
}

.pdf {
    color: #f44336 !important;
    font-size: 35px !important;
}


.midle {
    vertical-align: middle !important;
}

.padding-ta {
    padding: 1rem 1rem !important;
}

.has-text-align-left {
    text-align: justify !important;
}

.jcontent_end {
    justify-content: center !important;
}

.midle {
    vertical-align: middle !important;
}

.accordion-button:not(.collapsed) {
    color: #fff !important;
    background-color: #004587 !important;
    box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .125) !important;
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
                        <h2>NUESTRA HISTORIA</h2>
                    </div>

                    <ol class="breadcrumb-list">
                        <li></li>
                        <li class="active">Inicio/Reseña Histórica</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> <!-- container -->
</section>

<section id="post-section" class="post-section av-py-default-100 blog-page">
    <div class="av-container">
        <div class=" av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp"
                style="visibility: visible; animation-name: fadeInUp;">
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)"
                    id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3"
                    data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                    <div class="container">
                        <div class="row" align="center">
                            <h2><strong>La Terminal Terrestre Luis Valdivieso Morán da impulso a Manta.</strong>
                            </h2>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-6 col-lg-6">
                                <div class="my-3">
                                    <img class="medida" src="/TTM/luis.jpg" class="card-image-top" alt="thumbnail">
                                    <p align="center"><strong>Luis Valdivieso Morán</strong></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="my-3">

                                    <p class="has-text-align-left">La Terminal Terrestre de Manta Luis Valdivieso Morán
                                        ha conseguido consolidarse como uno de los ejes de desarrollo turístico y
                                        económicos de la ciudad.
                                    </p>

                                    <p class="has-text-align-left">A diario un aproximado de 2.600 usuarios llegan hasta
                                        la terminal, mientras que en los días de feriados locales y nacionales la cifra
                                        llega a los 30.000, haciendo uso no solo del transporte, sino del patio de
                                        comidas y el centro comercial que alberga este espacio.</p>

                                    <p class="has-text-align-left">Está ubicada entre las vías El Palmar y la Puerto -
                                        Aeropuerto desde el 4 de noviembre del 2017, tras años de haberse ubicado en el
                                        corazón de Manta, a pocas cuadras del municipio..</p>

                                    <p class="has-text-align-left">Además de este aporte, la terminal terrestre está
                                        vinculada a la historia de la ciudad, llevando el nombre de Luis Valdivieso
                                        Morán, mantense nacido el 9 de octubre de 1937 y que desde siempre impulsó, a
                                        través del sindicalismo y la gestión el desarrollo de la ciudad, siendo gestor
                                        de la construcción del puerto de Manta.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-12 col-lg-12">
                                <div class="my-3">
                                    <p class="has-text-align-left">Valdivieso también promovió la creación del barrio
                                        Cuba Libre, convertido hoy en la parroquia Eloy Alfaro, formó la Unión Sindical
                                        de Manta, fue gestor del Sindicato de Obreros, defendió el espacio marítimo de
                                        200 millas náuticas, llegó a ser consejero provincial y concejal de Manta, como
                                        su hija, nuestra actual alcaldesa Marciana Valdivieso de Poveda.</p>
                                    <p class="has-text-align-left">Sin duda, méritos suficientes para que nuestra
                                        terminal terrestre lleve su nombre y lo resalte acogiendo 31 cooperativas de
                                        buses ínter e intraprovinciales.</p>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-12 col-lg-12">
                                <div class="my-3">
                                    <img class="medida" src="/TTM/ttm2.jpg" class="card-image-top" alt="thumbnail">
                                </div>
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