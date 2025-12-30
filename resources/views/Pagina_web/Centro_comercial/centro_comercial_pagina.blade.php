@extends('Administrador.Layout.app_pagina_web')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<style>
    .btn-check:active+.btn-outline-danger,
    .btn-check:checked+.btn-outline-danger,
    .btn-outline-danger.active,
    .btn-outline-danger.dropdown-toggle.show,
    .btn-outline-danger:active {
        color: #fff !important;
        background-color: #34abde !important;
        border-color: #34abde !important;
    }

    .btn-outline-danger:hover {
        color: #fff !important;
        background-color: #34abde !important;
        border-color: #34abde !important;
    }

    .w {
        width: 100% !important;
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
                        <h2>CENTRO COMERCIAL</h2>
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

<section id="post-section" class="post-section av-py-default blog-page">
    <div class="av-container width-t">
        <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <p class="has-text-align-justify has-text-color margin-b-no" style="color:#009fe3;font-size:15px">El
                    centro comercial de la Terminal Terrestre, administrado por la Empresa Pública Municipal MOVILIDAD
                    DE MANTA, ofrece una amplia variedad de locales e islas con diversos productos y servicios para
                    nuestros usuarios. Además de un patio de comidas con variedad gastronómica.</p>
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)" id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                    <!--<div class="tpg-widget-heading-wrapper heading-style1 "><span class="tpg-widget-heading-line line-left"></span>
                        <h2 class="tpg-widget-heading">NOTICIAS MOVILIDAD MANTA</h2><span class="tpg-widget-heading-line"></span>-->

                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-3" align="center">
                                <h2 class="color-titu-pag"><strong> Categoria</strong> </h2>
                                <ul class="list-group">
                                    <div id="div-categoria">

                                    </div>
                                </ul>
                            </div>

                            <div class="col-sm-9">
                                <div class="container">
                                    <div class="row" id="div-table-turismo" align="center">

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
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
<script type="text/javascript" src="/js/CentroComercial/centro_comercial_pagina.js"></script>
@endsection