@extends('Administrador.Layout.app_pagina_web')
@section('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
    .sect {
        width: 100%;
        min-height: 100px;
    }

    #sect1,
    #sect3 {
        /*background-color: #3333337d;*/
        color: #fff;
    }

    /*
#sect2 {
  background-color: #dddddd7d;
  color: #333;
}*/

    .v {
        position: fixed;
        right: 0;
        bottom: 0;
        min-width: 100%;
        min-height: 100%;
        z-index: 0;
    }

    h1 {
        margin: 0;
        padding-top: 3rem;
        padding-left: 2rem;
    }

    h2 {
        margin: 0;
        padding-top: 3rem;
        padding-left: 2rem;
    }

    .mov {
        margin-top: 450px !important;
        opacity: 70%;
    }

    .main-slider .owl-item .item_2 {
        position: relative;
        background-color: var(--sp-secondary);
        background-repeat: no-repeat;
        background-position: center center;
        width: 100%;
        z-index: 0;
        padding: 90px 0;
        background-size: cover;
        min-height: 660px;
    }

    .info-section-2 {
        margin: -409px 266px -300px 300px !important;
        display: flex;
        /* width: 100vw; */
        height: 100vh;
        justify-content: center;
        align-items: center;
    }

    .owl-stage {
        transition: all 0s ease 0s !important;
        /*width: 7577px !important;*/
    }

    .total {
        max-width: 100% !important;
    }

    .sombra {
        text-shadow: #75a9f5 3px 4px, rgba(0, 0, 0, 0.1) 0 -1px, rgba(255, 255, 255, 0.1) 1px 0, rgba(255, 255, 255, 0.1) 0 1px, rgba(0, 0, 0, 0.1) -1px -1px, rgba(255, 255, 255, 0.1) 1px 1px !important;
        color: #ffffff !important;
    }

    .sombra-1 {
        text-shadow: #75a9f5 1px -1px, rgba(0, 0, 0, 0.1) 0 -1px, rgba(255, 255, 255, 0.1) 1px 0, rgba(255, 255, 255, 0.1) 0 1px, rgba(0, 0, 0, 0.1) -1px -1px, rgba(255, 255, 255, 0.1) 1px 1px !important;
        color: #ffffff !important;
    }

    .seccion_legado {
        /* height: 100vh;*/
    }

    .f_titulos {
        font-family: 'Cairo', sans-serif;
    }

    .video_1 {
        max-width: 100%;
        height: auto;
    }

    .contenedor {
        width: 100%;
        position: relative;
        display: inline-block;
        text-align: center;
        border-bottom: 10px solid #25cff2;
    }

    .centrado {
        position: absolute;
        top: 55%;
        left: 25%;
        transform: translate(-20%, 0%);
    }

    .empresa {
        font-size: 3.2vw;
        text-shadow: 1px 1px 5px #1d1c1cfa;
    }

    .f25 {
        font-size: 2.5vw;
    }

    .mtop15 {
        margin-top: -15%;
    }
</style>
@endsection

@section('content')

<section id="slider-section" style="    margin-top: 16%;">
    <div class="contenedor" style="height: 500px;">
        <iframe src="https://servicios.axiscloud.ec/AutoServicio/inicio.jsp?ps_empresa=04" referrerpolicy="strict-origin-when-cross-origin" sandbox="allow-forms allow-modals allow-popups allow-presentation allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" allow="encrypted-media; picture-in-picture; sync-xhr; geolocation;" allowpaymentrequest="true" allowpopups allowfullscreen height="500px" width="100%" style="height: 100% !important; ">

        </iframe>
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


@endsection
@section('js')
@endsection