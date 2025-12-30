@extends('Administrador.Layout.app_pagina_web')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
@endsection

@section('content')
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
            <div id="av-primary-content" class="av-column-12 wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <p class="has-text-align-justify has-text-color margin-b-no" style="color:#009fe3;font-size:15px">La EMPRESA PÚBLICA MOVILIDAD DE MANTA-EP, en ayuda a nuestra comunidad damos a conocer nuestras principales noticias, con la finalidad de formar parte del desarrollo de nuestra hermosa ciudad, ACALDÍA DE MANTA siempre firmes con el cambio.</p>
                <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)" id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even" data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                    <!--<div class="tpg-widget-heading-wrapper heading-style1 "><span class="tpg-widget-heading-line line-left"></span>
                        <h2 class="tpg-widget-heading">NOTICIAS MOVILIDAD MANTA</h2><span class="tpg-widget-heading-line"></span>-->
                </div>
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                    
                    <table border="0" class="table" id="table_id">
                        <thead>
                            <tr>
                                <th class="border-th-td"></th>
                                <th class="border-th-td"></th>
                                <th class="border-th-td"></th>
                                <th class="border-th-td"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < $filas; $i++) <tr>
                                @for ($x = $array_fila[$i]['desde']; $x < $array_fila[$i]['hasta']; $x++) <td class="border-th-td">
                                    <div class="rt-col-md-12 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                                        <div class="rt-holder sha-no">
                                            <div class="rt-img-holder">
                                                <a class="" href="#" target="_blank">
                                                    <img src="/imagenes_noticias/{{$json_data[$x]['no_ruta_foto']}}" class="img-border-ra tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                                            </div>
                                            <div class="rt-detail pad-no">
                                                <h5 class="entry-title text-ali-titu">
                                                    <a class="color-ti" target="_blank" href="#">{{$json_data[$x]['no_titulo']}}</a>
                                                </h5>
                                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong>{{$json_data[$x]['no_fecha']}}</strong></span></div>
                                                <div class="tpg-excerpt">
                                                    <p class="text-ali-des">{{$json_data[$x]['no_descripcion']}}</p>
                                                </div>
                                                <div class="post-meta btn-ri">
                                                    <span class="read-more">
                                                        <a class="btn-noticia" href="#" target="_blank">Leer mas</a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </td>
                                    @endfor
                                    </tr>
                                    @endfor
                        </tbody>
                    </table>

                    <!--@foreach($json_data2 as $data)
                    <div class="rt-col-md-3 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                        <div class="rt-holder sha-no">
                            <div class="rt-img-holder">
                                <a class="" href="/noticia/{{$data->no_id}}" target="_blank">
                                    <img src="/imagenes_noticias/{{$data->no_ruta_foto}}" class="img-border-ra tam-img-no rt-img-responsive jetpack-lazy-image jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager"></a>
                            </div>
                            <div class="rt-detail pad-no">
                                <h5 class="entry-title text-ali-titu">
                                    <a class="color-ti" target="_blank" href="/noticia/{{$data->no_id}}">{{$data->no_titulo}}</a>
                                </h5>
                                <div class="post-meta-user  "><span class="date"><i class="far fa-calendar-alt"></i><strong> {{$data->no_fecha}}</strong></span></div>
                                <div class="tpg-excerpt">
                                    <p class="text-ali-des">{{$data->no_descripcion}}</p>
                                </div>
                                <div class="post-meta btn-ri">
                                    <span class="read-more">
                                        <a class="btn-noticia" href="/noticia/{{$data->no_id}}" target="_blank">Leer mas</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach-->
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
</section>
@endsection

@section('js')



@endsection