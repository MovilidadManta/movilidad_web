@extends('Administrador.Layout.app_pagina_web')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<style>
    .entry-title a {
        text-decoration: none;
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
                        <h2>COOPERATIVAS</h2>
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

<section id="post-section" class="post-section av-py-default blog-page">
    <div class="av-container width-t">
        <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <p class="has-text-align-justify has-text-color margin-b-no" style="color:#009fe3;font-size:15px">
                    Conozca todos los destinos a los que puede viajar desde la Terminal Terrestre de Manta, con
                    horarios, precios de pasajes y más detalles de los servicios de cada cooperativa de transporte.</p>
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)" id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                    <!--<div class="tpg-widget-heading-wrapper heading-style1 "><span class="tpg-widget-heading-line line-left"></span>
                        <h2 class="tpg-widget-heading">NOTICIAS MOVILIDAD MANTA</h2><span class="tpg-widget-heading-line"></span>-->

                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                    <div class="cargando-not-pag" id="div-noticia-paginacion"></div>
                    @foreach ($json_data as $data)
                    <div class="rt-col-md-3 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                        <div class="rt-holder sha-no">
                            <div class="rt-img-holder">
                                <a class="" href="/cooperativa-id/{{$data->co_id}}">
                                    <img src="/imagenes_cooperativa/{{$data->co_ruta_foto}}" class="img-border-ra tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager">
                                </a>
                            </div>
                            <div class="rt-detail pad25">
                                <h3 class="entry-title text-ali-titu-coo">
                                    <a class="color-ti-coo color-titu-pag" align="center" href="/cooperativa-id/{{$data->co_id}}">{{$data->co_nombre}}</a>
                                </h3>
                                <!--<div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong> nnnnnnn</strong></span></div>
                                <div class="tpg-excerpt">
                                    <p class="text-ali-des">nnnnn</p>
                                </div>-->
                                @if (strlen(trim($data->co_celular)) > 2)
                                <div class="btn-le">
                                    <span class="btn-social btn-social-whatsapp">
                                        <a href="https://api.whatsapp.com/send?text=Buenas tardes, estimados señores {{$data->co_nombre}}, tengo una consulta&phone=+593{{substr($data->co_celular, 1)}}" target="_blank" class="whatsapp">
                                            <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>
                                @endif
                                <div class="post-meta btn-ri">
                                    <span class="read-more">
                                        <a class="btn-noticia" href="/cooperativa-id/{{$data->co_id}}">Leer mas</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


                <div class="rt-pagination-wrap" data-total-pages="3" data-posts-per-page="6" data-type="pagination">
                    <div class="rt-pagination">
                        <ul class="pagination-list">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<!--<script type="text/javascript" src="/js/Noticia/noticia_pagina.js"></script>-->
@endsection