@extends('Administrador.Layout.app_pagina_web')
@section('css')
<style>
    .rojo {
        color: red;
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
                        <h2>LOTAIP</h2>
                    </div>
                    <ol class="breadcrumb-list">
                        <li></li>
                        <li class="active">TRANSPARENCIA/LOTAIP</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->
</section>
<section id="post-section" class="post-section av-py-default-100 blog-page">

    <div class="av-container width-t-100-n">
        <p class="has-text-align-justify has-text-color margin-b-no"
            style="color:#009fe3;font-size:15px;text-align: justify;">
            La Ley Orgánica de Transparencia y Acceso a la Información Pública (LOTAIP) garantiza y norma el ejercicio
            del derecho fundamental de las personas a la información, por eso, en este espacio transparentamos los actos
            de quienes conformamos Movilidad EP y cumplimos con parte del proceso de rendición de cuentas hacia la
            ciudadanía.
            Art. 7.- Difusión de la Información Pública.- Por la transparencia en la
            gestión administrativa que están obligadas a observar todas las instituciones
            del Estado que conforman el sector público en los términos del artículo 118 de la
            Constitución Política de la República y demás entes señalados en el artículo 1 de la presente Ley,
            difundirán a través de un portal de información o página web, así como de los medios necesarios a
            disposición del público,
            implementados en la misma institución,
            la siguiente información mínima actualizada, que para efectos de esta Ley, se la considera de naturaleza
            obligatoria:
        </p>
    </div>
    <div class="container">
        <div class="row">
            <div class="av-columns-area wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                <div id="av-primary-content" class="av-column-11 wow fadeInUp"
                    style="visibility: visible; animation-name: fadeInUp;">
                    <div class="rt-container-fluid rt-tpg-container tpg-shortcode-main-wrapper rt-img-holder(height: 230px;)"
                        id="rt-tpg-container-985975327" data-layout="layout1" data-grid-style="even"
                        data-desktop-col="3" data-tab-col="2" data-mobile-col="1" data-sc-id="874">
                        <!--<div class="tpg-widget-heading-wrapper heading-style1 "><span class="tpg-widget-heading-line line-left"></span>
                        <h2 class="tpg-widget-heading">NOTICIAS MOVILIDAD MANTA</h2><span class="tpg-widget-heading-line"></span>-->
                    </div>
                    <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col 9">
                                    hola
                                </div>
                                <div class="col 3">
                                    hola2
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start" style="width: 95%;">
                            <div class="nav flex-column nav-pills padi bor-ho" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                @if($json_data_year =='')

                                @else

                                @foreach($json_data_year as $data_year)
                                @if ($loop->first)
                                <input type="hidden" id="id-lotaip" value="{{$data_year->lo_id}}">
                                <input type="hidden" id="year-lotaip" value="{{$data_year->lo_year}}">
                                <button class="nav-link active btn-pagina-año me-4"
                                    id="{{$data_year->lo_id}}-{{$data_year->lo_year}}" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-{{$data_year->lo_year}}" type="button" role="tab"
                                    aria-controls="v-pills-home" aria-selected="true">{{$data_year->lo_year}}</button>
                                @else
                                <button class="nav-link btn-pagina-año me-4"
                                    id="{{$data_year->lo_id}}-{{$data_year->lo_year}}" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-{{$data_year->lo_year}}" type="button" role="tab"
                                    aria-controls="v-pills-profile"
                                    aria-selected="false">{{$data_year->lo_year}}</button>
                                @endif
                                <!--<button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-2020" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">2020</button>
                                <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-2019" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">2019</button>-->
                                @endforeach
                                @endif
                            </div>
                            <div class="tab-content bor bor-ho" id="v-pills-tabContent" style="width: 100%;">
                                <div class="cargando"></div>
                                @if($json_data_year =='')

                                @else
                                @foreach($json_data_year as $data_year)
                                <div class="tab-pane fade show active bd-example" id="v-pills-{{$data_year->lo_year}}"
                                    role="tabpanel" aria-labelledby="v-pills-home-tab"></div>
                                @endforeach
                                @endif
                                <!--<div class="tab-pane fade" id="v-pills-2021" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                2
                            </div>
                            <div class="tab-pane fade" id="v-pills-2020" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                3
                            </div>
                            <div class="tab-pane fade" id="v-pills-2019" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                4
                            </div>-->
                            </div>
                        </div>
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
                <!-- <div class="av-column-3 wow">
                    <div class="row">
                        <a class="btn btn-secondary" href="#"><span><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Formato del formulario de acceso a la información pública </span></a>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="exampleFormControlInput1" class="form-label">Nombres y Apellidos:<span class="rojo">*</span></label>
                            <input type="text" class="form-control" id="ip_nombre" placeholder="Nombre y apellido">
                        </div>
                        <div class="col-12">
                            <label for="exampleFormControlInput1" class="form-label">Número de cédula:<span class="rojo">*</span></label>
                            <input type="text" class="form-control" id="ip_cedula" placeholder="número de cedula">
                        </div>
                        <div class="col-12">
                            <label for="exampleFormControlInput1" class="form-label">Email:<span class="rojo">*</span></label>
                            <input type="email" class="form-control" id="ip_email" placeholder="Email">
                        </div>
                        <div class="col-12">
                            <label for="exampleFormControlTextarea1" class="form-label">Mensaje:<span class="rojo">*</span></label>
                            <textarea class="form-control" id="ip_mensaje" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="exampleFormControlInput1" class="form-label">Número de télefono:<span class="rojo">*</span></label>
                            <input type="email" class="form-control" id="ip_numero" placeholder="Email">
                        </div>
                        <div class="col-12">
                            <label for="formFile" class="form-label">Adjuntar solicitud en formato pdf</label>
                            <input class="form-control" type="file" id="formFile">
                        </div>

                    </div>
                    <div class="row" style="margin-top: 0.5em;">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary form-control"> Enviar solicitud</button>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript" src="/js/Lotaip/pagina_lotaip.js"></script>
@endsection