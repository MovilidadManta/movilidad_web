@extends('Administrador.Layout.app_pagina_web')
@section('css')
<style>
    .rojo {
        color: red;
    }
    .color-ti{
        font-size: 16px !important;
    }
    #txt-peticion{
        resize: none;
    }
    #select-formato-digital{
        margin-top: 10px;
    }
    #frame-pdf-lotaip{
        width: 100%;
        min-height: 600px;
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="has-text-align-justify has-text-color margin-b-no"
                    style="color:#009fe3;font-size:15px;text-align: justify;">
                    La Ley Orgánica de Transparencia y Acceso a la Información Pública (LOTAIP) garantiza y norma el
                    ejercicio
                    del derecho fundamental de las personas a la información, por eso, en este espacio transparentamos
                    los actos
                    de quienes conformamos Movilidad EP y cumplimos con parte del proceso de rendición de cuentas hacia
                    la
                    ciudadanía.
                    Art. 7.- Difusión de la Información Pública.- Por la transparencia en la
                    gestión administrativa que están obligadas a observar todas las instituciones
                    del Estado que conforman el sector público en los términos del artículo 118 de la
                    Constitución Política de la República y demás entes señalados en el artículo 1 de la presente Ley,
                    difundirán a través de un portal de información o página web, así como de los medios necesarios a
                    disposición del público,
                    implementados en la misma institución,
                    la siguiente información mínima actualizada, que para efectos de esta Ley, se la considera de
                    naturaleza
                    obligatoria:
                </p>
            </div>
            <div class="col-md-8">
                <div data-title="Loading ..." class="rt-row rt-content-loader layout1 tpg-even ">
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
                                aria-controls="v-pills-profile" aria-selected="false">{{$data_year->lo_year}}</button>
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
            </div>
            <div class="col-md-4">
                <!--
                <div class="row marg-bot-for">
                    <a class="btn btn-secondary btn-noticia" target="_blank" href="
                        /Archivos/formato_lotaip/solicitud_lotaip.pdf">
                        <span>
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            Formato del formulario de acceso a la información pública
                        </span>
                    </a>
                </div>
                <div class="row">
                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                    <form class="form" novalidate id="form-solicitud-lotaip" method="POST"
                        enctype="multipart/form-data">
                        <div class="col-12 marg-bot-for">
                            <label class="color-ti" for="">
                                <strong>Nombres y Apellidos:</strong>
                            </label>
                            <input type="text" class="form-control " id="txt-nombre" name="txt-nombre"
                                placeholder="Ingrese nombres y apellidos">
                        </div>
                        <div class="col-12 marg-bot-for">
                            <label class="form-label color-ti">
                                <strong>Número de cédula:</strong>
                                <span class="rojo">*</span>
                            </label>
                            <input type="text" class="form-control" id="txt-cedula" name="txt-cedula"
                                placeholder="Ingrese número de cédula">
                        </div>
                        <div class="col-12 marg-bot-for">
                            <label class="form-label color-ti">
                                <strong>Email:</strong>
                                <span class="rojo">*</span>
                            </label>
                            <input type="email" class="form-control" id="txt-email" name="txt-email"
                                placeholder="Ingresar Email">
                        </div>
                        <div class="col-12 marg-bot-for">
                            <label class="form-label color-ti">
                                <strong> Mensaje:</strong>
                                <span class="rojo">*</span>
                            </label>
                            <textarea class="form-control" id="txt-mensaje" name="txt-mensaje" rows="3"></textarea>
                        </div>
                        <div class="col-12 marg-bot-for">
                            <label class="form-label color-ti">
                                <strong>Número de télefono:</strong>
                                <span class="rojo">*</span>
                            </label>
                            <input type="email" class="form-label color-ti" id="txt-telefono" name="txt-telefono"
                                placeholder="Ingresar número de télefono">
                        </div>
                        <div class="col-12 marg-bot-for">
                            <label class="form-label color-ti">
                                <strong>Adjuntar solicitud en formato pdf</strong>
                            </label>
                            <input class="form-control" type="file" id="txt-file" name="txt-file">
                        </div>
                    </form>
                </div>
                <div class="row" style="margin-top: 0.5em;">
                    <div class="col-12">
                        <button type="button" id="btn-guardar-solicitud-lotaip"
                            class="btn btn-primary form-control btn-noticia" onclick="guardar_solicitud_lotaip()">
                            <i class="fa fa-save"></i>
                            Enviar solicitud
                        </button>
                    </div>
                </div>
                -->
                <div class="row marg-bot-for">
                    <div class="alert alert-primary text-center" role="alert">
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                        Solicitud de acceso a la información publica
                    </div>
                </div>
                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                    <form class="form form-solicitud-lotaip" novalidate id="form-solicitud-acceso-lotaip" method="POST"
                        enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <label class="color-ti" for="">
                                    <strong>Nombres:</strong>
                                    <span class="rojo">*</span>
                                </label>
                                <input type="text" class="form-control " id="txt-nombre" name="txt-nombre"
                                    placeholder="Ingrese nombres">
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <label class="color-ti" for="">
                                    <strong>Apellidos:</strong>
                                    <span class="rojo">*</span>
                                </label>
                                <input type="text" class="form-control " id="txt-apellido" name="txt-apellido"
                                    placeholder="Ingrese apellidos">
                            </div>
                            <div class="col-xs-12 marg-bot-for">
                                <label class="color-ti" for="">
                                    <strong>Cédula #:</strong>
                                    <span class="rojo">*</span>
                                </label>
                                <input type="text" class="form-control input-number" id="txt-cedula" name="txt-cedula"
                                    placeholder="Ingrese número de cédula">
                            </div>
                            <div class="col-xs-12 marg-bot-for">
                                <label class="form-label color-ti">
                                    <strong>Télefono(fijo o celular):</strong>
                                    <span class="rojo">*</span>
                                </label>
                                <input type="text" class="form-label color-ti input-number" id="txt-telefono" name="txt-telefono"
                                    placeholder="Ingresar número de télefono">
                            </div>
                            <div class="col-xs-12 marg-bot-for">
                                <label class="form-label color-ti">
                                    <strong>Dirección domiciliaria:</strong>
                                    <span class="rojo">*</span>
                                </label>
                                <input type="text" class="form-label color-ti" id="txt-direccion" name="txt-direccion"
                                    placeholder="Ingresar su dirección">
                            </div>
                            <div class="col-xs-12 marg-bot-for">
                                <label class="form-label color-ti">
                                    <strong>Petición concreta:</strong>
                                    <span class="rojo">*</span>
                                </label>
                                <textarea id="txt-peticion" name="txt-peticion" class="form-control" rows="6"></textarea>
                            </div>
                            <div class="col-xs-12 marg-bot-for">
                                <label class="form-label color-ti">
                                    <strong>Forma de recepción de la información solicitada:</strong>
                                    <span class="rojo">*</span>
                                </label>
                                <select name="select-forma-recepcion" id="select-forma-recepcion" class="form-control">
                                    <option value="0">Seleccione forma de recepción</option>
                                    <option value="1">Retiro de la información en la institución</option>
                                    <option value="2">Email</option>
                                </select>
                            </div>
                            <div id="div-email" class="col-xs-12 marg-bot-for" style="display: none;">
                                <label class="form-label color-ti">
                                    <strong>Email:</strong>
                                    <span class="rojo">*</span>
                                </label>
                                <input type="email" class="form-label color-ti" id="txt-email" name="txt-email"
                                    placeholder="Ingresar su dirección">
                            </div>
                            <div class="col-xs-12 marg-bot-for">
                                <label class="form-label color-ti">
                                    <strong>Formato de entrega:</strong>
                                    <span class="rojo">*</span>
                                </label>
                                <select name="select-formato-entrega" id="select-formato-entrega" class="form-control">
                                    <option value="0">Seleccione formato de entrega</option>
                                    <option value="1">Copia en papel</option>
                                    <option value="2">CD</option>
                                    <option value="3">Formato electrónico digital</option>
                                </select>
                                <select name="select-formato-digital" id="select-formato-digital" style="display: none;" class="form-control">
                                    <option value="0">Seleccione formato electrónico</option>
                                    <option value="1">PDF</option>
                                    <option value="2">WORD</option>
                                    <option value="3">EXCEL</option>
                                    <option value="4">OTROS</option>
                                </select>
                            </div>
                            <div id="div-otros" class="col-xs-12 marg-bot-for" style="display: none;">
                                <label class="form-label color-ti">
                                    <strong>Especifique:</strong>
                                    <span class="rojo">*</span>
                                </label>
                                <input type="text" class="form-label color-ti" id="txt-otros-especifico" name="txt-otros-especifico"
                                    placeholder="Ingresar otro formato electronico">
                            </div>
                        </div>
                    </form>
                    <div class="row form-solicitud-lotaip" style="margin-top: 0.5em;">
                        <div class="col-12">
                            <button type="button" id="btn-enviar-solicitud-lotaip"
                                class="btn btn-primary form-control btn-noticia">
                                <i class="fa fa-save"></i>
                                Enviar solicitud
                            </button>
                        </div>
                    </div>
                    <iframe id="frame-pdf-lotaip" class="frame-lotaip" src="" title="PDF creado en la solicitud" style="display: none"></iframe>
                    <div class="row frame-lotaip" style="margin-top: 0.5em; display: none">
                        <div class="col-12">
                            <button type="button" id="btn-nueva-solicitud-lotaip"
                                class="btn btn-primary form-control btn-noticia">
                                <i class="fa fa-plus"></i>
                                Nueva solicitud
                            </button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript" src="/js/Lotaip/pagina_lotaip.js"></script>
@endsection