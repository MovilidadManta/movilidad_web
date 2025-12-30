@extends('Administrador.Layout.app_pagina_web')
@section('css')

<style>
    .pad-25 {
        padding: 25px !important;
    }
    .btn-social{
        padding: 8px 5px;
        font-size: 20px;
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
        margin-top: 15px;
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
                        <h2>BUSCAR DESTINO</h2>
                    </div>
                    <ol class="breadcrumb-list">
                        <li><a href="/terminal">Inicio</a> &nbsp;&gt;&nbsp;</li>
                        <li class="active">Buscar Destino</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> <!-- container -->
</section>

<section id="post-section" class="post-section av-py-default blog-page">
    <div class="av-container width-t-100-n">
        <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <p class="has-text-align-justify has-text-color margin-b-no justify" style="color:#009fe3;font-size:15px"></p>
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)" id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                    <!--<div class="tpg-widget-heading-wrapper heading-style1 "><span class="tpg-widget-heading-line line-left"></span>
                        <h2 class="tpg-widget-heading">NOTICIAS MOVILIDAD MANTA</h2><span class="tpg-widget-heading-line"></span>-->
                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                    <div class="rt-col-md-12 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no">
                        <div class="rt-holder sha-no">
                            <div class="rt-detail pad-no">
                                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                                <form class="form" novalidate id="form-contactano" method="POST" enctype="multipart/form-data">
                                    <div class="marg-bot row">
                                        <div class="col-md-4">
                                            <label class="color-ti"><strong>Destinos</strong> </label>
                                            <select type="text" id="select-destino" name="select-destino" class="form-control"></select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="color-ti"><strong>Cooperativas</strong> </label>
                                            <select type="text" id="select-cooperativa" name="select-cooperativa" class="form-control">
                                                <option value="0">TODOS</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 align-self">
                                            <a class="btn btn-buscar-des" id="btn-buscar-destino">
                                                <i class="fa fa-search color-btn-nuevo"></i>
                                                <strong class="color-btn-nuevo">Buscar</strong>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div id="div-destino"></div>

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
<script type='text/javascript' src='/js/Destino/pagina_buscar_destino.js'></script>
@endsection