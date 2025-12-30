@extends('Administrador.Layout.app_pagina_web')
@section('css')
<style>
.breadcrumb-area {
    background-image: url(./Imagenes/banner.jpg);
    background-attachment: scroll;
}

.post-content-2 {
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

.card-img-top {
    max-height: 250px;
    overflow: hidden;
}

.card-title a:link {
    font-size: 30px;
    background-color: transparent;
    color: #000000;
    text-decoration: none;
}

.card-title a:hover {
    color: red;
    background-color: transparent;
    text-decoration: underline;
}

.medida {
    width: 530px !important;
    height: auto !important;
}

.car-bo {
    flex: 1 1 auto;
    padding: 1rem 0rem;
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
                        <h2>DIRECTORIO</h2>
                    </div>
                    <ol class="breadcrumb-list">
                        <li></li>
                        <li class="active">Directorio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> <!-- container -->
</section>

<section class=" py-4 my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3 col-lg-3">
                <div class="my-3">
                    <img class="medida" src="/directorio/marciana_.png" class="card-image-top" alt="thumbnail">
                    <div class="card-body car-bo" align="center">
                        <p>Ing. Marciana Auxiliadora Valdiviezo Zamora, Mg.</p>
                        <h5 class="post-title"><strong>ALCALDESA</strong></h5>
                        <h5 class="post-title"><strong>GOBIERNO AUTÓNOMO DESCENTRALIZADO MUNICIPAL DEL CANTÓN
                                MANTA</strong></h5>
                        <!--<p>Ing. Marciana Auxiliadora Valdiviezo Zamora Mg.</p>
                        <h5 class="post-title"><strong>ALCALDESA DEL CANTÓN MANTA</strong></h5>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class=" col-md-4 col-lg-3">
                <div class="my-3">
                    <img class=" medida" src="/directorio/fernando.png" class="card-image-top" alt="thumbnail">
                    <div class="card-body car-bo" align="center">
                        <p>Arq. Fernando Javier Zambrano Loor.</p>
                        <h5 class="post-title"><strong>DIRECTOR DE PLANIFICACIÓN TERRITORIAL DEL
                                GOBIERNO AUTÓNOMO DESCENTRALIZADO MUNICIPAL DEL CANTÓN MANTA</strong></h5>
                        <!--<p>Ing. Marciana Auxiliadora Valdiviezo Zamora Mg.</p>
                        <h5 class="post-title"><strong>ALCALDESA DEL CANTÓN MANTA</strong></h5>-->
                    </div>
                </div>
            </div>

            <div class=" col-md-4 col-lg-3">
                <div class=" my-3">
                    <img class="medida" src="/directorio/victor.png" class="card-image-top" alt="thumbnail">
                    <div class="card-body car-bo" align="center">
                        <p>Dr. Víctor Hugo Párraga Velásquez.</p>
                        <h5 class="post-title"><strong>CONCEJAL DE MANTA-PRESIDENTE DE LA
                                COMISIÓN-PLANIFICACIÓN TERRITORIAL, INFRAESTRUCTURAS Y SERVICIOS
                                PÚBLICOS</strong></h5>
                        <!--<p>Ing. Marciana Auxiliadora Valdiviezo Zamora Mg.</p>
                        <h5 class="post-title"><strong>ALCALDESA DEL CANTÓN MANTA</strong></h5>-->
                    </div>
                </div>
            </div>

            <div class=" col-md-4 col-lg-3">
                <div class=" my-3">
                    <img class="medida" src="/directorio/gerente.png" class="card-image-top" alt="thumbnail">
                    <div class="card-body car-bo" align="center">
                        <p>Ab. Sandy Maiker Garcia Cano.</p>
                        <h5 class="post-title"><strong>GERENTE GENERAL DE LA EMPRESA PÚBLICA MUNICIPAL MOVILIDAD DE
                                MANTA-EP, SECRETARIO DEL DIRECTORIO</strong></h5>
                        <!--<p>Ing. Marciana Auxiliadora Valdiviezo Zamora Mg.</p>
                        <h5 class="post-title"><strong>ALCALDESA DEL CANTÓN MANTA</strong></h5>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')

@endsection