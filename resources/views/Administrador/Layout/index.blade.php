@extends('Administrador.Layout.app_pagina_web')
@section('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
    .btn_aporte_ciudadano {
        font-size: 1.5rem !important;
    }

    .btn_aporte_ciudadano:hover {
        background-color: #0d6efd !important;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .close {
        float: right;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        border: 0;
    }

    .close:hover {
        border: 0;
    }

    button:hover {
        outline: 0;
    }

    .badge::before {
        border: transparent;
    }
</style>
@endsection

@section('content')

<section id="slider-section">
    <div class="contenedor">
        <video loop="loop" autoplay="" muted="" playsinline="" class="video_1">
            <!--<source src="{{ env('APP_URL_INTRA') }}/valex/assets/videos/movilidad.mp4" type="video/mp4">-->
            <source src="/videos/movilidad.mp4" type="video/mp4">
        </video>
        <div class="centrado">
            <h1 class="sombra empresa" data-animation="fadeInUp" data-delay="150ms">EMPRESA PÚBLICA
                MUNICIPAL MOVILIDAD DE MANTA-EP</h1>
            <!--<h3 class="sombra-1 f25" data-animation="fadeInLeft" data-delay="500ms">Se trabaja para dar
                seguridad en las
                vías, promover el cumplimiento de la Ley de Tránsito; administrar la Terminal
                Terrestre y su centro comercial de forma eficaz.</h3>
            <div style="    position: relative;    display: flex;    justify-content: center;">
                <a href="#sec_legado">
                    <img src="{{asset('Imagenes/dist/legado.png')}}"
                        style="    width: 13vw;    margin-left: 1em;    margin-top: 0.5em;"
                        class="animate__animated animate__bounce animate__infinite" alt="">
                </a>
            </div>-->
        </div>
    </div>
</section>
<!--<section id="slider-sections" class="slider-wrapper">
    <div class="main-slider owl-carousel owl-theme">

<div class="item">
    <div class="theme-slider">
        <video src="{{asset('valex/assets/videos/mov.mp4')}}" class="v" autoplay="true" muted="true" loop="true" poster="https://carontestudio.com/img/contacto.jpg"></video>
        <div class="theme-table">
            <div class="theme-table-cell">
                <div class="av-container">
                    <div class="theme-content text-center total">
                        <h1 class="sombra" data-animation="fadeInUp" data-delay="150ms">EMPRESA PÚBLICA
                            MUNICIPAL MOVILIDAD DE MANTA-EP</h1>
                        <h3 class="sombra-1" data-animation="fadeInLeft" data-delay="500ms">Se trabaja para dar
                            seguridad en las
                            vías, promover el cumplimiento de la Ley de Tránsito; administrar la Terminal
                            Terrestre y su centro comercial de forma eficaz.</h3>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="    position: relative;    display: flex;    justify-content: center;">
        <a href="#sec_legado">
            <img src="{{asset('Imagenes/dist/legado.png')}}" style="    width: 13em;    margin-left: 1em;    margin-top: 0.5em;" class="animate__animated animate__bounce animate__infinite" alt="">
        </a>
    </div>
</div>

</section>-->

<section id="service-section" class="service-section service-section-hover av-py-default service-home">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12">
                <div class="heading-default wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="av-columns-area">
                                <div class="av-column-12 heading-default wow fadeInUp">
                                    <span class="ttl ">
                                        <h1>
                                            <strong>REALIZA LOS TRÁMITES DESDE TU COMODIDAD </strong>
                                        </h1>
                                    </span>
                                </div>
                            </div>
                            <ul class="info-wrapper wow fadeInUp"
                                style="visibility: visible; animation-name: fadeInUp;">
                                <li class="info-second">
                                    <aside class=" widget-contact">
                                        <a href="/agencia-transito" class="contact-info">
                                            <img src="{{asset('valex/assets/img/dtm.png')}}" alt="">
                                        </a>
                                    </aside>
                                </li>
                                <li class="info-second">
                                    <aside class=" widget-contact">
                                        <a href="/terminal" class="contact-info">
                                            <img src="{{asset('valex/assets/img/ttm.png')}}" alt="">
                                        </a>
                                    </aside>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button type="button" id="btn-enviar-solicitud-lotaip"
                class="btn btn-primary form-control btn-noticia btn_aporte_ciudadano">
                <i class="fa fa-save"></i>
                INGRESAR APORTE CIUDADANO
            </button>
        </div>
    </div>
</section>
<section id="sec_legado" class="seccion_legado">
    <div class="av-container">
        <span class="ttl ">

            <h1>
                <strong>¡Legado Manta, empezó! </strong>
            </h1>
            <hr>
        </span>
        <div class="row">
            <div class="col-md-4">
                <video width="100%" height="auto" controls id="videoPlayer">
                    <source src="/videos/1.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="col-md-4">
                <video width="100%" height="auto" controls id="videoPlayer">
                    <source src="/videos/2.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="col-md-4">
                <video width="100%" height="auto" controls id="videoPlayer">
                    <source src="/videos/3.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="col-md-4">
                <video width="100%" height="auto" controls id="videoPlayer">
                    <source src="/videos/4.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="col-md-4">
                <video width="100%" height="auto" controls id="videoPlayer">
                    <source src="/videos/5.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</section>

<!-- INICIO MODAL VISOR PDF  -->
<x-paginaweb.modal_aporte_ciudadano>
</x-paginaweb.modal_aporte_ciudadano>
<!-- FIN MODAL VISOR PDF  -->

@endsection
@section('js')
<script type='text/javascript' src='/js/index.js'></script>
@endsection