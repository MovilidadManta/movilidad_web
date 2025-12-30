@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
<link rel="stylesheet" href="{{asset('dropify/dist/css/dropify.css')}}" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .ql-toolbar.ql-snow {
        border: 1px solid #cecdcf !important;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #00BCD4 !important;
        border: 1px solid #03A9F4 !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        border-right: 1px solid #fff !important;
        color: #fff !important;
    }
</style>
<style>
    .fc .fc-scrollgrid-liquid {
        height: 80vh !important;
    }

    .is-today {
        background: #9ac7ed;
    }

    .ma_p {
        margin: 0 !important;
        margin-left: 0.5em !important;
    }

    .azul {
        color: #0077c0;
    }

    .verde {
        color: #18b173;
    }

    .rojo {
        color: #fb5885;
    }

    .gris {
        color: #bdbcbc;
    }

    .cortar {
        font-size: 12px;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        display: -webkit-box !important;
        -webkit-box-orient: vertical !important;
        -webkit-line-clamp: 1 !important;
    }

    .mt_02 {
        margin-top: 0.2em
    }

    .ml_1 {
        margin-left: 1em;
        ;
    }

    .dotss {
        position: absolute;
        top: 17px;
        right: 20px;
    }

    .dropdown-menu {
        background-color: #e7ebed !important;
    }
</style>
@endsection

@section('content')
<!-- main-content -->

<!-- container -->
<div class="main-container">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Gestión carpetas</h4>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pe-1 mb-xl-0">
                <!--<button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo</button>-->
                <button data-bs-toggle="dropdown" class="btn btn-primary btn-block show" aria-expanded="true"><i class="fa fa-plus"></i> Nuevo <i class="icon ion-ios-arrow-down tx-11 mg-l-3"></i></button>
                <div class="dropdown-menu show" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(5px, 42px);" data-popper-placement="bottom-start">
                    <!--<a href="javascript:void(0)" onclick="open_modal(1)" class="dropdown-item"><i class="fa fa-folder-o"></i> Nueva carpeta</a>-->
                    <a href="javascript:void(0)" onclick="open_modal(2)" class="dropdown-item"><i class="fa fa-upload"></i> Subir archivo</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h4>
                    <ol class="breadcrumb breadcrumb-arrows" id="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{strtoupper($folder)}}</a></li>
                    </ol>
                </h4>
            </div>

        </div>
    </div>
    <!-- breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm">
                        <!--<div class="card-header">
									<h3 class="card-title"></h3>
								</div>-->

                        <div class="card-body">
                            <input type="hidden" value="" id="id_open_folder">
                            <input type="hidden" value="" id="open_folder">
                            <div class="row" id="mi_unidad">
                                @php $caracteres = strlen($folder); @endphp

                                @foreach($folder_actual as $d)

                                @php
                                $carpeta_ = $d['carpeta']; //substr($d,$caracteres+1);
                                //var_dump($carpeta_);
                                $carpeta_a = '"'.$carpeta_.'"';
                                $separador_pdf = ".pdf";
                                $separador_doc = ".doc";
                                $separador_docx = ".docx";
                                $separador_xls = ".xls";
                                $separador_png = ".png";
                                $separador_jpg = ".jpg";
                                $separador_jpeg = ".jpeg";
                                $separador_zip = ".zip";
                                $separador_rar = ".rar";
                                $separador_7zip = ".7zip";
                                $separador_csv = ".csv";
                                $separador_mp4 = ".mp4";
                                $arry_ext = explode($separador_pdf,$carpeta_);
                                $ext_doc = explode($separador_doc,$carpeta_);
                                $ext_docx = explode($separador_docx,$carpeta_);
                                $ext_xls = explode($separador_xls,$carpeta_);
                                $ext_png = explode($separador_png,$carpeta_);
                                $ext_jpg = explode($separador_jpg,$carpeta_);
                                $ext_jpeg = explode($separador_jpeg,$carpeta_);
                                $ext_zip = explode($separador_zip,$carpeta_);
                                $ext_rar = explode($separador_rar,$carpeta_);
                                $ext_7zip = explode($separador_7zip,$carpeta_);
                                $ext_csv = explode($separador_csv,$carpeta_);
                                $ext_mp4 = explode($separador_mp4,$carpeta_);
                                @endphp
                                @if(sizeof($arry_ext)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-pdf-o rojo mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>

                                            <div class="float-end ms-auto">
                                                <a href="javascript:void(0);" class="option-dots show" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fe fe-more-vertical"></i></a>
                                                <div class="dropdown-menu rounded-7 show" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(153px, 41px);" data-popper-placement="bottom-start">
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-edit me-2"></i> Edit</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-share me-2"></i> Share</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-download me-2"></i> Download</a>
                                                    <a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-trash me-2"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_doc)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-word-o azul mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_docx)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-word-o azul mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_xls)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-excel-o verde mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_png)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-image-o mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_jpg)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-image-o mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_jpeg)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-image-o mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_zip)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-archive-o mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_rar)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-archive-o mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_7zip)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-archive-o mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_csv)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="descargar_archivo('{{$d['id']}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-text-o mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @elseif(sizeof($ext_mp4)>1)
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="ver_video('{{$folder}}','{{$carpeta_}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-file-video-o mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>
                                        </div>
                                    </a>
                                </div>
                                @else
                                <div class="col-md-6 col-lg-3">
                                    <a href="javascript:void(0)" onclick="abrir_carpeta('{{$d['id']}}','{{$carpeta_}}','{{$folder}}');" data-toggle="tooltip" data-placement="bottom" title="{{$carpeta_}}" class="card card-link">
                                        <div class="card-body d-flex">
                                            <i class="fa fa-folder gris mt_02"></i>
                                            <span class="cortar ml_1">{{$carpeta_}}</span>

                                        </div>
                                    </a>
                                    <a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                                    <div class="dropdown-menu rounded-7" style="">
                                        <!--<a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-edit me-2"></i> Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-share me-2"></i> Share</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="fe fe-download me-2"></i> Download</a>-->
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delte_folder({{$d['id']}})"><i class="fe fe-trash me-2"></i> Eliminar</a>
                                    </div>
                                </div>
                                @endif

                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->
</div>
<!-- Container closed -->

<!-- INICIO MODAL AÑADIR USUARIOS -->
<div class="modal" id="modal-carpeta">

    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Nueva carpeta</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block">
                    <div class="form-group">
                        <input class="form-control pd-r-80" type="text" id="ip_folder">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" onclick="fn_save_folder();" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR USUARIOS -->

<!--INICIO MODAL ELIMINAR USUARIOS -->
<div class="modal show" id="modal-eliminar-usuario" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-eliminar-usuario" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-usuario" name="txt-id-usuario">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el usuario</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-usuario" type="button"><i class="fa fa-save"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR USUARIOS -->

<!-- INICIO MODAL MODIFICAR USUARIOS -->
<div class="modal" id="modal-usuario-m">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Modificar Usuario</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-usuario-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-modificar-usuario" id="txt-id-modificar-usuario">
                    <div id="div-table-empleado-m">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-usuario" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR USUARIOS -->

<!-- INICIO MODAL CAMBIAR CONTRASEÑA USUARIOS -->
<div class="modal" id="modal-usuario-cambiar-clave">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Modificar Clave</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-usuario-cambiar-clave" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-cambiar-clave-usuario" id="txt-id-cambiar-clave-usuario">
                    <div id="div-table-cambiar-clave">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-cambiar-clave-usuario" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL CAMBIAR CONTRASEÑA USUARIOS -->
<!-- Modal SUBIR ARCHIVO-->
<div id="modal_subir_archivo" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="center_t">
                    <h4>SUBIR ARCHIVO</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Subir Archivos - (Max 1 GB)</h5>
                                <form action="javascript:void(0);">
                                    <label for="">Nombre del documento</label>
                                    <input type="text" class="form-control" id="ip_name_doc" placeholder="Ingrese el nombre del documento">
                                    <br>
                                    <input type="file" class="dropify" name="archivo" id="archivo">
                                    <br>
                                    <button type="button" id="btn_subir" class="btn btn-primary form-control">SUBIR ARCHIVO</button>
                                    <progress id="barra_de_progreso" value="0" max="100" style=" width:  100%; height:  21px;"></progress>
                                    <p id="porce">0%</p>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type='text/javascript' src='/js/Notificacion/notificacion.js'></script>
<script src="/valex/assets/plugins/quill/quill.min.js"></script>
<!-- INTERNAL Summernote Editor js -->
<script src="/valex/assets/plugins/summernote-editor/summernote1.js"></script>
<script src="/valex/assets/js/summernote.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('dropify/dist/js/dropify.min.js')}}"></script>
<script src="{{asset('js/upload.js')}}"></script>


<script>
    let carpetas = []
    //let carpeta_actual = '';

    function open_modal(tipo) {
        if (tipo == 1) {
            /*let e_folder = $("#id_open_folder").val();
            if(e_folder ==""){}*/
            $("#modal-carpeta").modal("show")
        } else {
            modal_subir();
        }
    }

    function modal_subir() {
        $("#modal_subir_archivo").modal("show");
    }

    function delte_folder(id) {
        $.ajax({
            url: "/delete_folder/" + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                if (res.res) {
                    if (res.sms == '9999') {
                        abrir_carpeta_refres(carpeta_actual, 'documentos')
                    }
                }
            },
        }).fail(function(jqXHR, textStatus, errorthrown) {
            if (jqXHR.status === 0) {
                alert("Not connect: Verify Network.");
            } else if (jqXHR.status == 404) {
                alert("Requested page not found [404]");
            } else if (jqXHR.status == 500) {
                alert("Internal Server Error [500].");
            } else if (textStatus === "parsererror") {
                alert("Requested JSON parse failed.");
            } else if (textStatus === "timeout") {
                alert("Time out error.");
            } else if (textStatus === "abort") {
                alert("Ajax request aborted.");
            } else {
                alert("Uncaught Error: " + jqXHR.responseText);
            }
        });
    }

    function del_file(idfile) {
        let token = $("#csrf-token").val();
        let datos = {
            idfile
        };
        $.ajax({
            url: "/delete_file",
            type: "POST",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": token,
            },
            data: datos,
            success: function(res) {
                if (res.res) {
                    if (res.sms == '9999') {
                        let carpeta_actual = $("#open_folder").val();
                        abrir_carpeta_refres(carpeta_actual, 'documentos')
                    }
                }
            },
        }).fail(function(jqXHR, textStatus, errorthrown) {
            if (jqXHR.status === 0) {
                alert("Not connect: Verify Network.");
            } else if (jqXHR.status == 404) {
                alert("Requested page not found [404]");
            } else if (jqXHR.status == 500) {
                alert("Internal Server Error [500].");
            } else if (textStatus === "parsererror") {
                alert("Requested JSON parse failed.");
            } else if (textStatus === "timeout") {
                alert("Time out error.");
            } else if (textStatus === "abort") {
                alert("Ajax request aborted.");
            } else {
                alert("Uncaught Error: " + jqXHR.responseText);
            }
        });
    }

    function fn_save_folder() {

        let carpeta = $("#ip_folder").val();
        let carpeta_actual_ = $("#open_folder").val();

        if (carpeta == "") {
            alert("Ingrese el nombre de su nueva carpeta!")
        } else {
            if (carpeta_actual_ == "") {
                carpeta = carpeta;
            } else {
                carpeta = carpeta_actual_ + "/" + carpeta;
            }
            let token = $("#csrf-token").val();
            let datos = {
                carpeta
            };

            $.ajax({
                url: "/save_folder",
                type: "POST",
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": token,
                },
                data: datos,
                success: function(res) {
                    if (res.respuesta) {
                        $("#modal-carpeta").modal("hide");
                        window.location.reload()

                    }
                },
            }).fail(function(jqXHR, textStatus, errorthrown) {
                if (jqXHR.status === 0) {
                    alert("Not connect: Verify Network.");
                } else if (jqXHR.status == 404) {
                    alert("Requested page not found [404]");
                } else if (jqXHR.status == 500) {
                    alert("Internal Server Error [500].");
                } else if (textStatus === "parsererror") {
                    alert("Requested JSON parse failed.");
                } else if (textStatus === "timeout") {
                    alert("Time out error.");
                } else if (textStatus === "abort") {
                    alert("Ajax request aborted.");
                } else {
                    alert("Uncaught Error: " + jqXHR.responseText);
                }
            });
        }

    }

    function abrir_carpeta_refres(nombre, home) {
        //temp_carpeta_actual = carpeta_actual;

        let id_folder = $("#id_open_folder").val();

        let datos = {
            id_folder,
            nombre
        }
        $("#open_folder").val(nombre);
        if (carpetas.length == 0) {
            carpetas.push(home)
            carpetas.push(nombre)
        } else {
            carpetas.push(nombre)
        }
        let htmls = "";
        var token = $("#csrf-token").val();
        let home_ = "'" + home + "'";
        $.ajax({
            url: '/open_carpeta',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            dataType: 'json',
            data: datos,
            success: function(res) {
                $.each(res, function(index, u) {
                    let count_caracter = nombre.length;
                    let carpeta_ = u.ca_carpetas + "/" + u.ar_ruta; //u.substring(count_caracter);
                    ///let carpeta_a = "'" + nombre + "/" + u.ar_ruta + "'";
                    let folder = "'" + carpeta_ + "'";

                    let separador_pdf = ".pdf";
                    let separador_doc = ".doc";
                    let separador_docx = ".docx";
                    let separador_xls = ".xls";
                    let separador_png = ".png";
                    let separador_jpg = ".jpg";
                    let separador_jpeg = ".jpeg";
                    let separador_zip = ".zip";
                    let separador_rar = ".rar";
                    let separador_7zip = ".7zip";
                    let separador_csv = ".csv";
                    let separador_mp4 = ".mp4";
                    let arry_ext = carpeta_.split(separador_pdf);
                    let ext_doc = carpeta_.split(separador_doc);
                    let ext_docx = carpeta_.split(separador_docx);
                    let ext_xls = carpeta_.split(separador_xls);
                    let ext_png = carpeta_.split(separador_png);
                    let ext_jpg = carpeta_.split(separador_jpg);
                    let ext_jpeg = carpeta_.split(separador_jpeg);
                    let ext_zip = carpeta_.split(separador_zip);
                    let ext_rar = carpeta_.split(separador_rar);
                    let ext_7zip = carpeta_.split(separador_7zip);
                    let ext_csv = carpeta_.split(separador_csv);
                    let ext_mp4 = carpeta_.split(separador_mp4);
                    //let c_ruta = "'" + nombre + "/" + carpeta_ + "'";
                    let c_ruta = "'" + carpeta_ + "'";

                    //console.log(arry_ext);
                    if (arry_ext.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-pdf-o rojo mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'

                    } else if (ext_doc.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-word-o azul mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'

                    } else if (ext_docx.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-word-o azul mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'

                    } else if (ext_xls.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-excel-o verde mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_png.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-image-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_jpg.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-image-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'

                    } else if (ext_jpeg.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-image-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_zip.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-archive-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_rar.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-archive-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_7zip.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-archive-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_csv.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-csv-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_mp4.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="ver_video(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-video-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="abrir_carpeta(' + carpeta_a + ',' + folder + ',' + home_ + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link"><div class="card-body d-flex"><i class="fa fa-folder-o gris mt_02"></i>'
                        htmls += '<span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                        // htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        //htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + carpeta_ + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    }

                })
                // carpeta_actual = temp_carpeta_actual + '/' + nombre;

                $("#mi_unidad").html(htmls);
                //  $("#carpeta_actual").html(carpeta);


                /* let nav_ = "";
                 let count_caracter = carpeta.length;
                 let carpeta_anterior = '';
                 for (var i = 0; i < carpetas.length; i++) {
                     let carpeta_ = carpetas[i].substring(count_caracter + 1);
                     let carpeta_a = "'" + carpeta + "/" + carpeta_ + "'";
                     let folder = "'" + carpeta_ + "'";
                     if (carpetas.length - 1 == i) {
                         nav_ += "<li class='breadcrumb-item active' aria-current='page'>" + carpetas[i] + "</li>"
                     } else {

                         if (i == 0) {
                             carpeta_anterior += carpetas[i];
                             nav_ += "<li class='breadcrumb-item'><a href='/gestion-documentos'>" + carpetas[i] + "</a></li>"
                         } else {

                             carpeta_anterior += "/" + carpetas[i];
                             let carpeta__ = "'" + carpeta_anterior + "'";
                             let folder__ = "'" + carpetas[0] + "'";
                             let folder_current = "'" + carpetas[carpetas.length - 1] + "'";
                             nav_ += '<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="cerrar_carpeta(' + carpeta__ + ',' + folder_current + ',' + folder__ + ')">' + carpetas[i] + '</a></li>';
                         }
                     }
                 }
                 $("#breadcrumb").html(nav_);*/

                //console.log(carpeta_actual);
            }
        }).fail(function(jqXHR, textStatus, errorthrown) {
            if (jqXHR.status === 0) {

                alert('Not connect: Verify Network.');

            } else if (jqXHR.status == 404) {

                alert('Requested page not found [404]');

            } else if (jqXHR.status == 500) {

                alert('Internal Server Error [500].');

            } else if (textStatus === 'parsererror') {

                alert('Requested JSON parse failed.');

            } else if (textStatus === 'timeout') {

                alert('Time out error.');

            } else if (textStatus === 'abort') {

                alert('Ajax request aborted.');

            } else {

                alert('Uncaught Error: ' + jqXHR.responseText);

            }

        })
    }
    function abrir_carpeta(id_folder, folder_name, home) {
        $("#id_open_folder").val(id_folder)
        $("#open_folder").val(folder_name);

        //temp_carpeta_actual = carpeta_actual;
        if (carpetas.length == 0) {
            carpetas.push(home)
            carpetas.push(folder_name)
        } else {
            carpetas.push(folder_name)
        }
        let htmls = "";
        var token = $("#csrf-token").val();
        let home_ = "'" + home + "'";

        let datos = {
            id_folder,
            folder_name
        }

        $.ajax({
            url: '/open_carpeta',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            dataType: 'json',
            data: datos,
            success: function(res) {
                $.each(res, function(index, u) {
                    let count_caracter = u.ca_carpetas.length;
                    let carpeta_ = u.ca_carpetas + "/" + u.ar_ruta; //.substring(count_caracter + 1);
                    //let carpeta_a = "'" + u.ca_carpetas + "/" + carpeta_ + "'";
                    let folder = "'" + carpeta_ + "'";

                    let separador_pdf = ".pdf";
                    let separador_doc = ".doc";
                    let separador_docx = ".docx";
                    let separador_xls = ".xls";
                    let separador_png = ".png";
                    let separador_jpg = ".jpg";
                    let separador_jpeg = ".jpeg";
                    let separador_zip = ".zip";
                    let separador_rar = ".rar";
                    let separador_7zip = ".7zip";
                    let separador_csv = ".csv";
                    let separador_mp4 = ".mp4";
                    let arry_ext = carpeta_.split(separador_pdf);
                    let ext_doc = carpeta_.split(separador_doc);
                    let ext_docx = carpeta_.split(separador_docx);
                    let ext_xls = carpeta_.split(separador_xls);
                    let ext_png = carpeta_.split(separador_png);
                    let ext_jpg = carpeta_.split(separador_jpg);
                    let ext_jpeg = carpeta_.split(separador_jpeg);
                    let ext_zip = carpeta_.split(separador_zip);
                    let ext_rar = carpeta_.split(separador_rar);
                    let ext_7zip = carpeta_.split(separador_7zip);
                    let ext_csv = carpeta_.split(separador_csv);
                    let ext_mp4 = carpeta_.split(separador_mp4);

                    //console.log(arry_ext);
                    let c_ruta = "'" + carpeta_ + "'";
                    //let c_ruta = "'" + nombre + "/" + carpeta_ + "'";
                    if (arry_ext.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-pdf-o rojo mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'

                    } else if (ext_doc.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-word-o azul mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'

                    } else if (ext_docx.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-word-o azul mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'

                    } else if (ext_xls.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-excel-o verde mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_png.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-image-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_jpg.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-image-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'

                    } else if (ext_jpeg.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-image-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_zip.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-archive-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_rar.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-archive-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_7zip.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-archive-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_csv.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-csv-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else if (ext_mp4.length > 1) {
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="ver_video(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                        htmls += '<div class="card-body d-flex"><i class="fa fa-file-video-o mt_02"></i><span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + u.ar_id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    } else {
                        let c = "'" + u.ar_nombre_documento + "'";
                        htmls += '<div class="col-md-6 col-lg-3">'
                        htmls += '<a href="javascript:void(0)" onclick="abrir_carpeta(' + u.ar_id_carpeta + ',' + c + ',' + home_ + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link"><div class="card-body d-flex"><i class="fa fa-folder-o gris mt_02"></i>'
                        htmls += '<span class="cortar ml_1">' + u.ar_nombre_documento + '</span></div></a>'
                        // htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                        //htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + carpeta_ + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                        htmls += '</div>'
                    }
                    // temp_carpeta_actual = u.ca_carpetas
                })
                //carpeta_actual = temp_carpeta_actual;

                $("#mi_unidad").html(htmls);
                //  $("#carpeta_actual").html(carpeta_actual);

                let carpeta_actual = $("#open_folder").val();
                let nav_ = "";
                let count_caracter = carpeta_actual.length;
                let carpeta_anterior = '';
                debugger
                for (var i = 0; i < carpetas.length; i++) {
                    let carpeta_ = carpetas[i].substring(count_caracter + 1);
                    // let carpeta_a = "'" + carpeta_actual + "/" + carpeta_ + "'";
                    // let folder = "'" + carpeta_ + "'";
                    if (carpetas.length - 1 == i) {
                        nav_ += "<li class='breadcrumb-item active' aria-current='page'>" + carpetas[i] + "</li>"
                    } else {

                        if (i == 0) {
                            carpeta_anterior += carpetas[i];
                            nav_ += "<li class='breadcrumb-item'><a href='/gestion-documentos'>" + carpetas[i] + "</a></li>"
                        } else {

                            carpeta_anterior += "/" + carpetas[i];
                            let carpeta__ = "'" + carpeta_anterior + "'";
                            let folder__ = "'" + carpetas[0] + "'";
                            let folder_current = "'" + carpetas[carpetas.length - 1] + "'";
                            nav_ += '<li class="breadcrumb-item"><a href="javascript:void(0);" onclick="cerrar_carpeta(' + carpeta__ + ',' + folder_current + ',' + folder__ + ')">' + carpetas[i] + '</a></li>';
                        }
                    }
                }
                $("#breadcrumb").html(nav_);

                //console.log(carpeta_actual);
            }
        }).fail(function(jqXHR, textStatus, errorthrown) {
            if (jqXHR.status === 0) {

                alert('Not connect: Verify Network.');

            } else if (jqXHR.status == 404) {

                alert('Requested page not found [404]');

            } else if (jqXHR.status == 500) {

                alert('Internal Server Error [500].');

            } else if (textStatus === 'parsererror') {

                alert('Requested JSON parse failed.');

            } else if (textStatus === 'timeout') {

                alert('Time out error.');

            } else if (textStatus === 'abort') {

                alert('Ajax request aborted.');

            } else {

                alert('Uncaught Error: ' + jqXHR.responseText);

            }

        })
    }

    $('.dropify').dropify({
        messages: {
            'default': 'Arrastra aqui sus archivos',
            'replace': 'Arrastra y suelta o haz clic para reemplazar',
            'remove': 'Eliminar',
            'error': 'Ooops, algo malo paso.'
        }
    });

    $("#btn_subir").click(function() {
        $("#btn_subir").html("<i class='fa fa-spinner fa-spin fa-fw margin-bottom'></i><span>Subiendo archivo espere...</span>");
        $("#btn_subir").prop('disabled', true);
        let carpeta_actual = $("#open_folder").val();
        subirArchivos(carpeta_actual);
    });

    function subirArchivos(carpeta_actual) {
        var token = $("#csrf-token").val();
        let name = $("#ip_name_doc").val();
        let id_folder = $("#id_open_folder").val();
        var r = btoa(unescape(encodeURIComponent(carpeta_actual)));
        $("#archivo").upload('/upload', {
                ruta: r,
                name: name,
                id_folder: id_folder
            },
            token,

            function(respuesta) {
                //Subida finalizada.
                //
                $("#barra_de_progreso").val(0);
                if (respuesta.registro) {
                    //  mostrarRespuesta('El archivo ha sido subido correctamente.', true);
                    alert("El archivo ha sido subido correctamente.");
                    var drEvent = $('.dropify').dropify();
                    //location.reload();
                    $("#ip_name_doc").val();
                    $("#modal_subir_archivo").modal("hide");
                    console.log(carpeta_actual);
                    abrir_carpeta_refres(carpeta_actual, 'documentos');
                    $("#btn_subir").html("SUBIR ARCHIVO");
                    $("#btn_subir").removeAttr('disabled');
                } else {
                    //  mostrarRespuesta('El archivo NO se ha podido subir.', false);
                    alert("El archivo NO se ha podido subir. si el archivo pesa mas de 1 GB recarge su navegador ");
                    $("#btn_subir").html("SUBIR ARCHIVO");
                    $("#btn_subir").removeAttr('disabled');
                }
                //  mostrarArchivos();
            },
            function(progreso, valor) {
                //Barra de progreso.
                $("#porce").html(valor + "%");
                $("#barra_de_progreso").val(valor);

            });
    }

    $(function() {
        'use strict'
        var icons = Quill.import('ui/icons');
        icons['bold'] = '<i class="la la-bold" aria-hidden="true"><\/i>';
        icons['italic'] = '<i class="la la-italic" aria-hidden="true"><\/i>';
        icons['underline'] = '<i class="la la-underline" aria-hidden="true"><\/i>';
        icons['strike'] = '<i class="la la-strikethrough" aria-hidden="true"><\/i>';
        icons['list']['ordered'] = '<i class="la la-list-ol" aria-hidden="true"><\/i>';
        icons['list']['bullet'] = '<i class="la la-list-ul" aria-hidden="true"><\/i>';
        icons['link'] = '<i class="la la-link" aria-hidden="true"><\/i>';
        icons['image'] = '<i class="la la-image" aria-hidden="true"><\/i>';
        icons['video'] = '<i class="la la-film" aria-hidden="true"><\/i>';
        icons['code-block'] = '<i class="la la-code" aria-hidden="true"><\/i>';
        var toolbarOptions = [
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['bold', 'italic', 'underline', 'strike'],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            ['link', 'image', 'video']
        ];
        var quill = new Quill('#quillEditor', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });

        $('#summernote').summernote();

        $('.js-example-basic-multiple').select2();
    });

    function descargar_archivo(ruta) {
        let r = btoa(unescape(encodeURIComponent(ruta)));

        var url = "/descargar_archivo/" + r;
        console.log(url);
        var a = document.createElement("a");
        a.target = "_blank";
        a.href = url;
        a.click();
    }

    $("#btn_enviar").click(function() {
        let user = $("#user_").val();
        let users_to = [];
        $('#users_to :selected').each(function(i, sel) {
            users_to.push($(sel).val());
        });
        let asunto = $("#ip_asunto").val();
        let mensaje = $(".note-editable").html();
        let tipo = 2;

        let token = $("#csrf-token").val();
        let datos = {
            user: user,
            mensaje: mensaje,
            users_to: users_to,
            asunto: asunto,
            tipo: tipo
        };

        $.ajax({
            url: "/save_noti",
            type: "POST",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": token,
            },
            data: datos,
            success: function(res) {
                if (res.respuesta) {
                    window.location.reload()
                }
            },
        }).fail(function(jqXHR, textStatus, errorthrown) {
            if (jqXHR.status === 0) {
                alert("Not connect: Verify Network.");
            } else if (jqXHR.status == 404) {
                alert("Requested page not found [404]");
            } else if (jqXHR.status == 500) {
                alert("Internal Server Error [500].");
            } else if (textStatus === "parsererror") {
                alert("Requested JSON parse failed.");
            } else if (textStatus === "timeout") {
                alert("Time out error.");
            } else if (textStatus === "abort") {
                alert("Ajax request aborted.");
            } else {
                alert("Uncaught Error: " + jqXHR.responseText);
            }
        });
    })
</script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif