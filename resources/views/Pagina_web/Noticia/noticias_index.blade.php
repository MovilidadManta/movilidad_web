@extends('Administrador.Layout.app_pagina_web')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<style>
.tpg-excerpt {
    display: -webkit-box !important;
    -webkit-line-clamp: 4 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    text-align: justify !important;
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
<input type="hidden" id="no_tipo" value="{{$no_tipo}}" />
<input type="hidden" id="url_web" value="{{url('')}}" />
<section id="breadcrumb-section" class="breadcrumb-area breadcrumb-center">
    <div class="av-container">
        <div class="av-columns-area">
            <div class="av-column-12">
                <div class="breadcrumb-content">
                    <div class="breadcrumb-heading">
                        <h2>
                            NOTICIAS </h2>
                    </div>
                    <ol class="breadcrumb-list">
                        <li><a href="https://web.movilidadmanta.gob.ec">Inicio</a> &nbsp;&gt;&nbsp;</li>
                        <li class="active">NOTICIAS</li>
                    </ol>
                </div>
            </div>
        </div>
    </div> <!-- container -->
</section>

<section id="post-section" class="post-section av-py-default blog-page">
    <div class="av-container width-t">
        <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div id="av-primary-content" class="av-column-12 wow fadeInUp"
                style="visibility: visible; animation-name: fadeInUp;">
                <p class="has-text-align-justify has-text-color margin-b-no" style="color:#009fe3;font-size:15px">La
                    EMPRESA PÚBLICA MOVILIDAD DE MANTA-EP, en ayuda a nuestra comunidad damos a conocer nuestras
                    principales noticias, con la finalidad de formar parte del desarrollo de nuestra hermosa ciudad,
                    ACALDÍA DE MANTA siempre firmes con el cambio.</p>
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)"
                    id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3"
                    data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                    <!--<div class="tpg-widget-heading-wrapper heading-style1 "><span class="tpg-widget-heading-line line-left"></span>
                        <h2 class="tpg-widget-heading">NOTICIAS MOVILIDAD MANTA</h2><span class="tpg-widget-heading-line"></span>-->

                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                    <div class="cargando-not-pag" id="div-noticia-paginacion"></div>


                </div>


                <div class="rt-pagination-wrap" data-total-pages="3" data-posts-per-page="6" data-type="pagination">
                    <div class="rt-pagination">
                        <ul class="pagination-list">
                            @for ($i = 0; $i < $filas; $i++) <li
                                id="{{$i+1}}-{{$array_fila[$i]['desde']}}-{{$array_fila[$i]['hasta']}}"
                                class="btn-paginacion"><span>{{$i+1}}</span></li>
                                <!--<li><a data-paged="2" href="https://web.movilidadmanta.gob.ec/noticias-movilidad-de-manta/page/2/">2</a></li>
                                <li><a data-paged="3" href="https://web.movilidadmanta.gob.ec/noticias-movilidad-de-manta/page/3/">3</a></li>-->
                                @endfor
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript" src="/js/Noticia/noticia_pagina.js"></script>
@endsection