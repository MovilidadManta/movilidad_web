@extends('Administrador.Layout.app')

@section('css')
<style>
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

    .mt_4 {
        margin-top: 4em
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

    .size1_8 {
        font-size: 1.8rem;
    }

    .centar {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .ar_contenedores {
        display: flex;
        flex-direction: column;
    }

    .ar_contenedores span {
        margin-left: 0 !important;
    }

    .ar_contenedores span {
        color: #8d8d8d;
    }


    .ar_folders {
        width: 50px !important;
        height: 50px !important;
    }

    .flex {
        display: flex;
    }

    .jc-center {
        justify-content: center;
    }

    .ptop-10 {
        padding-top: 10px;
    }

    .ar-header {
        display: flex;
        justify-content: space-between;
    }

    #ar_com_vacio {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #ar_com_vacio span {
        color: #adadad;
    }

    .load_view_folder {
        position: absolute;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f0f8ff52;
        z-index: 100000;
    }

    .load_view_contenedor {
        position: absolute;
        height: 100%;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f0f8ff52;
        z-index: 100000;
    }

    .b1 {
        border-top: 1px solid #ddd;
    }

    .jc-end {
        display: flex;
        justify-content: end;
    }

    .tcenter {
        text-align: center;
    }
</style>
@endsection

@section('content')
<!-- main-content -->

<!-- container -->
<div class="main-container">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto col-md-12">
            <div class="d-flex">
                <div class="col-md-6">
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestión de Documentos </h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">

                    <!--<a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-bodega">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
                    </a>-->
                </div>

            </div>
        </div>


    </div>
    <!-- breadcrumb -->

    <!-- row -->
    <div class="row" id="c_bodegas">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm">

                        @foreach($bodegas as $b)
                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="card text-center">
                                <img class="card-img-top w-100" src="{{asset('Imagenes/archivo/bodega.jpg')}}" alt="">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">{{$b->archivo}}</h4>
                                    <p class="card-text">{{$b->ubicacion}}.</p>
                                    <a class="btn btn-primary" href="javascript:void(0);" onclick="select_bodega({{$b->id}}, '{{$b->archivo}}','{{$b->ubicacion}}')">Seleccionar bodega</a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->
    <!-- row -->
    <div class="card" id="cc_contenedores" style="display: none;">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-xl-3">
                    <div class="card">
                        <div class="main-content-left main-content-left-mail card-body">
                            <a class="btn btn-primary btn-compose" id="btnCompose" href="javascript:void(0);" onclick="crear_contendor();"><i class="fa fa-plus mx-2"></i> Crear Contenedor</a>
                            <div class="main-mail-menu">
                                <div id="load_contenedor" class="example load_view_contenedor">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <nav class="nav main-nav-column" id="nav_contenedores">

                                    <span class="nav-link thumb">
                                        Bodega sin contenedor <img src="./Imagenes/archivo/vacio.png"></span>

                                </nav>
                            </div><!-- main-mail-menu -->
                            <div class="card custom-card mt-3 pb-0 mb-0">
                                <div class="card-header font-weight-bold" id="txt_archivo">Bodega 1</div>
                                <div class="card-body pt-0">
                                    <div class="progress fileprogress mg-b-10">
                                        <div class="progress-bar progress-bar-xs wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="text-muted font-weight-semibold tx-13 mb-1" id="txt_ubicacion">ubicacion</div>
                                    <!--<div class="tx-13 text-primary font-weight-semibold">Upgrade Storage</div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-xl">
                    <div class="row">
                        <div class="col-6">
                            <div class="tx-20 mb-4">
                                Administrador de Archivos
                            </div>
                        </div>
                        <div class="col-6 col-auto file-1">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control rounded-3 br-te-0 br-be-0" placeholder="Buscar archivo.....">
                                <span class="input-group-text bg-transparent p-0 rounded-3 br-ts-0 br-bs-0 overflow-hidden">
                                    <button class="btn ripple btn-primary" type="button">Buscar</button>
                                </span>
                            </div>
                        </div>
                        <div class="ar-header">
                            <div class="text-muted mb-2 tx-16">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb breadcrumb-style1 mg-b-0" id="item_bread">
                                        <!--<li class="breadcrumb-item">
                                            <a href="javascript:void(0);">Home</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="javascript:void(0);">Library</a>
                                        </li>
                                        <li class="breadcrumb-item active">Data</li>-->
                                    </ol>
                                </nav>
                            </div>
                            <div>
                                <div class="btn-group mb-2 mt-2">
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fe fe-settings"></i>
                                    </button>
                                    <ul class="dropdown-menu" style="" id="menu_se">


                                    </ul>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="id_contenedor_f">
                        <input type="hidden" id="name_contenedor_f">
                        <input type="hidden" id="current_dir" />
                        <input type="hidden" id="id_carpeta_open" />
                        <div id="load_folder" class="example load_view_folder">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="row update_file" id="ar_content_update">

                            <div id="ar_com_vacio">
                                <img src="Imagenes/archivo/caja-vacia.png" alt="">
                                <span>Contenedor se encuentra vacio</span>
                            </div>
                            <!--<div class="file-image-1 ptop-10">
                                <div class="product-image flex jc-center">
                                    <a href="javascript:void(0)">
                                        <img src="../Imagenes/archivo/001-archivo.png" class="rounded-5 ar_folders" alt="">
                                    </a>
                                    <ul class="icons">
                                        <li><a href="javascript:void(0);" class="bg-danger"><i class="fe fe-trash"></i></a></li>
                                        <li><a href="javascript:void(0);" class="bg-pink"><i class="fe fe-download"></i></a></li>
                                        <li><a href="javascript:void(0);" class="bg-primary"><i class="fe fe-eye"></i></a></li>
                                    </ul>
                                </div>
                                <span class="file-name-1">Folder 1</span>
                            </div>-->
                        </div>
                        <div class="mt_4 b1">
                            <div class="ar_contenedores mt-2">
                                <h5>Contenedor del Departamento: <strong id="c_departamento"> </strong></h5>
                                <span id="c_contenido"></span>
                                <span>Desde: <span id="c_desde"></span></span>
                                <span>Hasta: <span id="c_hasta"></span></span>
                                <span>Año: <span id="c_ano"></span></span>
                                <span>Tipo: <span id="c_tipo"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3" id="inf_file" style="display: none;">
                    <div class="card">
                        <div class="">
                            <div class="ms-auto jc-end">
                                <div class="">
                                    <a href="javascript:void(0);" onclick="c_info()" data-bs-placement="top" data-bs-toggle="tooltip" title="" class="p-2 text-muted" data-bs-original-title="Cerrar información" aria-label="Cerrar información"><i class="fas fa-times-circle"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="tcenter">Información del archivo</h4>
                            <div class="ar_contenedores">
                                <span><Strong>Tipo:</Strong></span>
                                <span id="fi_tipo"></span>
                                <span><Strong>Asunto Documento:</Strong></span>
                                <span id="fi_asunto"></span>
                                <span><Strong>Usuario subio el proceso:</Strong></span>
                                <span id="fi_usuario"></span>
                                <span><Strong>Número identificación:</Strong></span>
                                <span id="fi_numero_iden"></span>
                                <span><Strong>Número orden:</Strong></span>
                                <span id="fi_numero_orden"></span>
                                <span><Strong>Fecha emisión:</Strong></span>
                                <span id="fi_fecha_emi"></span>
                                <span><Strong>Fecha de subida del proceso:</Strong></span>
                                <span id="fi_fecha_created"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
</div>
<!-- Container closed -->

<!-- INICIO MODAL AÑADIR proceso -->
<div class="modal" id="modal-create">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar bodega</h1><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form" id="form-bodega" method="POST" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-9 mg-t-10">
                            <strong>Tipo de Contenedor: <span>(*)</span> </strong>
                            <select name="" id="sel_tipo" class="form-control" onchange="cargar_img()">
                                <option value="0">Seleccione un Tipo de Contenedor</option>
                                @foreach($tipos as $t)
                                <option value="{{$t->id}}">{{$t->tipo}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <div class="centar">
                                <strong>Numeración:</strong>
                                <span class="size1_8" id="span_numeracion">C-001</span>
                                <input type="hidden" id="ip_numeracion">
                            </div>
                        </div>
                        <div class="col-md-8 mg-t-10">
                            <div class="row">
                                <div class="col-md-6 mg-t-10">
                                    <strong>Desde: <span>(*)</span></strong>
                                    <input type="text" id="ip_desde" class="form-control">
                                </div>
                                <div class="col-md-6 mg-t-10">
                                    <strong>Hasta: <span>(*)</span></strong>
                                    <input type="text" id="ip_hasta" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mg-t-10">
                                <strong>Contenido: <span>(*)</span></strong>
                                <textarea class="form-control" id="ip_contenido" cols="30" rows="3"></textarea>
                            </div>
                            <div class="col-md-12 mg-t-10">
                                <strong>Departamento: <span>(*)</span></strong>
                                <select class="form-control" id="sel_departamento">
                                    <option value="0">Seleccione un Departamento</option>
                                    @foreach($departamento as $d)
                                    <option value="{{$d->per_id}}">{{$d->per_perfil}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4 mg-t-10">
                            <img id="img_tipo" class="card-img-top w-100" src="./Imagenes/archivo/contenedor.jpg" alt="">
                            <div class="col-md-12 mg-t-10">
                                <strong>Año: <span>(*)</span></strong>
                                <input type="text" id="ip_anio" class="form-control">
                            </div>
                        </div>



                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" onclick="save_contendor();" id="btn_guardar" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR proceso -->

<!-- INICIO MODAL AÑADIR FOLDERS -->
<div class="modal" id="modal-create-folder">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar Folders a contenedor</h1><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form" id="form-folder" method="POST" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-8 mg-t-10">
                            <div class="row">
                                <div class="col-md-6 mg-t-10">
                                    <strong>Desde: <span>(*)</span></strong>
                                    <input type="text" id="ip_desde_f" class="form-control">
                                </div>
                                <div class="col-md-6 mg-t-10">
                                    <strong>Hasta: <span>(*)</span></strong>
                                    <input type="text" id="ip_hasta_f" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mg-t-10">
                                <strong>Contenido: <span>(*)</span></strong>
                                <textarea class="form-control" id="ip_contenido_f" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" onclick="save_folder();" id="btn_guardar" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>

<!--CARPETA FIN-->

<!-- Modal SUBIR ARCHIVO-->
<div id="modal_subir_archivo" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="center_t">
                    <h4>SUBIR PROCESO</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fe fe-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <strong><label for="asunto">Asunto:</label></strong>
                                        <input type="text" class="form-control" id="ip_asunto" placeholder="Ingrese el asunto">
                                    </div>
                                    <div class="form-group">
                                        <strong>Departamento: <span>(*)</span></strong>
                                        <select class="form-control" id="sel_departamento_pro">
                                            <option value="0">Seleccione un Departamento</option>
                                            @foreach($departamento as $d)
                                            <option value="{{$d->per_id}}">{{$d->per_perfil}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <strong>Tipo de proceso: <span>(*)</span></strong>
                                        <select class="form-control" id="sel_tipo_pro">
                                            <option value="0">Seleccione un Tipo de proceso</option>
                                            @foreach($tipos_procesos as $d)
                                            <option value="{{$d->id}}">{{$d->tipo}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg">
                                    <div class="form-group">
                                        <label for="asunto">Número identificación:</label>
                                        <input type="text" class="form-control" id="ip_numero_identificacion" placeholder="Ingrese el número de identificación">
                                    </div>
                                    <div class="form-group">
                                        <label for="asunto">Número de orden:</label>
                                        <input type="text" class="form-control" id="ip_numero_orden" placeholder="Ingrese el número de orden">
                                    </div>
                                    <div class="form-group">
                                        <label for="asunto">Fecha de emision del documento:</label>
                                        <input type="date" class="form-control" id="ip_fecha_emision" placeholder="Ingrese la fecha de emisión">
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <h5 class="card-title mb-4">Subir Archivos - (Max 1 GB)</h5>
                                    <input type="file" class="dropify" name="archivo" id="archivo">
                                    <br>
                                    <progress id="barra_de_progreso" value="0" max="100" style=" width:  100%; height:  21px;"></progress>
                                    <p id="porce">0%</p>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_subir" class="btn btn-primary btn-compose">SUBIR PROCESO</button>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>



@endsection

@section('js')
<script src="{{asset('dropify/dist/js/dropify.min.js')}}"></script>
<script src="{{asset('js/upload.js')}}"></script>
<script>
    let select_ = [];
    let bodega_item = [];
    let ruta = null;
    let cont_select;
    let conf_del_folder = 'f';

    const select_bodega = (id, archivo, ubicacion) => {
        bodega_item = [];

        let obj = {
            b_id: id,
            b_archivo: archivo,
            b_ubicacion: ubicacion
        };
        bodega_item.push(obj);
        console.log(bodega_item);
        $("#c_bodegas").hide();
        $("#cc_contenedores").show();
        $("#txt_ubicacion").html(ubicacion);
        $("#txt_archivo").html(archivo);
        ruta = "archivo/" + archivo;
        get_contenedors_b(id).then(result => {
            $("#load_contenedor").show();
            let items_contenedores = "";
            if (result.length > 0) {
                result.forEach(function(i, v) {
                    let r = "'" + ruta + "/" + i.numeracion + "'"
                    let c = "'" + i.numeracion + "'";
                    if (v == 0) {
                        items_contenedores += '<a class="nav-link thumb active" id="' + i.numeracion + '" data-bs-toggle="tooltip" data-bs-placement="right" title="Tooltip on right" href="javascript:void(0);" onclick="open_contenedor(' + r + ',' + i.id + ',' + c + ')">'
                        if (i.id_tipo_almacenamiento == 1) { // caja
                            items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>'
                        } else if (i.id_tipo_almacenamiento == 2) { //Mobiliarios
                            items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122" /></svg>'
                        } else {
                            items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" /></svg>'

                        }
                        items_contenedores += '<div class="ar_contenedores"><span>' + i.numeracion + '</span>'
                        items_contenedores += '<span>' + i.contenido + '</span></div></a>'
                        cont_select = i.numeracion;
                        open_contenedor(ruta + "/" + i.numeracion, i.id, i.numeracion);
                        // ruta += "/" + i.numeracion
                    } else {
                        items_contenedores += '  <a class="nav-link thumb" id="' + i.numeracion + '" data-bs-toggle="tooltip" data-bs-placement="right" title="Tooltip on right" href="javascript:void(0);" onclick="open_contenedor(' + r + ',' + i.id + ',' + c + ')">'
                        if (i.id_tipo_almacenamiento == 1) { // caja
                            items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>'
                        } else if (i.id_tipo_almacenamiento == 2) { //Mobiliarios
                            items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122" /></svg>'
                        } else {
                            items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" /></svg>'
                        }
                        items_contenedores += '<div class="ar_contenedores"><span>' + i.numeracion + '</span>'
                        items_contenedores += '<span>' + i.contenido + '</span></div></a>'
                    }
                });
                console.log("ruta de la carpeta: " + ruta);
            } else {
                items_contenedores += '<span class="nav-link thumb"><img src="./Imagenes/archivo/vacio.png">Bodega sin contenedor </span>';
            }
            $("#nav_contenedores").html(items_contenedores);
            $("#load_contenedor").hide();

            console.log("ruta de la carpeta: " + ruta);

        })
    }

    const crear_contendor = () => {
        $("#img_tipo").attr('src', './Imagenes/archivo/contenedor.jpg');
        $("#modal-create").modal('show');
    }

    const cargar_img = () => {
        var x = document.getElementById("sel_tipo").value;
        if (x != 0) {
            $("#img_tipo").attr('src', './Imagenes/archivo/' + x + '.jpg');
            GET_numeracion(x).then(result => {
                if (result.length > 0) {
                    result.forEach(function(i, v) {
                        let numero;
                        if (i.numeracion < 10) {
                            numero = "00" + i.numeracion;
                        } else if (i.numeracion < 100) {
                            numero = "0" + i.numeracion;
                        }
                        let numeracion = i.letra + "-" + numero
                        $("#span_numeracion").html(numeracion);
                        $("#ip_numeracion").val(i.numeracion);
                    })
                }
            });
        } else {
            $("#img_tipo").attr('src', './Imagenes/archivo/contenedor.jpg');
        }

    }

    const open_form_new_folder = () => {
        $("#modal-create-folder").modal("show");
    }
    const open_form_new_file = () => {
        $("#modal_subir_archivo").modal("show");

    }
    const save_folder = () => {
        let desde = $("#ip_desde_f").val();
        let hasta = $("#ip_hasta_f").val();
        let contenido = $("#ip_contenido_f").val();
        let id_contenedor = $("#id_contenedor_f").val();
        let contenedor = $("#name_contenedor_f").val();
        if (desde == "" && hasta == "" && contenido == "") {
            alert("Por favor llene todos los campos");
        } else if (desde == "") {
            alert("Por favor ingrese el desde, de su contenedor por ejemplo('01-2023') 0 en Letras 'A'");
            $("#ip_desde_f").focus();
        } else if (hasta == "") {
            alert("Por favor ingrese el hasta, de su contenedor por ejemplo('01-2023') 0 en Letras 'B'");
            $("#ip_hasta_f").focus();
        } else if (contenido == "") {
            alert("Por favor ingrese una descripcion de su contenedor!")
            $("#ip_contenido_f").focus();
        } else {
            let token = $("#csrf-token").val();
            let rr = ruta + "/" + contenedor
            let datos = {
                desde,
                hasta,
                contenido,
                rr,
                id_contenedor
            };

            _AJAX_("/store_folder", "POST", token, datos, 1);
        }
    }

    const save_contendor = () => {
        let id_tipo_contenedor = $("#sel_tipo").val();
        let desde = $("#ip_desde").val();
        let hasta = $("#ip_hasta").val();
        let numeracion = $("#span_numeracion").html();
        let contenido = $("#ip_contenido").val();
        let departamento = $("#sel_departamento").val();
        let id_bodega = bodega_item[0].b_id;
        let anio = $("#ip_anio").val();
        let num = $("#ip_numeracion").val();

        if (id_tipo_contenedor == 0 && desde == "" && hasta == "" && contenido == "" && departamento == 0 && anio == "") {
            alert("Por favor llene todos los campos");
        } else if (id_tipo_contenedor == 0) {
            alert("Por favor seleccione un tipo de contenedor que desea crear!");
            $("#sel_tipo").focus();
        } else if (desde == "") {
            alert("Por favor ingrese el desde, de su contenedor por ejemplo('01-2023') 0 en Letras 'A'");
            $("#ip_desde").focus();
        } else if (hasta == "") {
            alert("Por favor ingrese el hasta, de su contenedor por ejemplo('01-2023') 0 en Letras 'B'");
            $("#ip_hasta").focus();
        } else if (contenido == "") {
            alert("Por favor ingrese una descripcion de su contenedor!")
            $("#ip_contenido").focus();
        } else if (departamento == 0) {
            alert("Por favor seleccione el departamento al cual pertenece el contenedor");
            $("#sel_departamento").focus();
        } else if (anio == "") {
            alert("Por favor ingrese el año del contenedor");
            $("#ip_anio").focus();
        } else {
            //ejecutar guardado de contenedor;
            let token = $("#csrf-token").val();
            let datos = {
                id_tipo_contenedor,
                desde,
                hasta,
                numeracion,
                contenido,
                departamento,
                id_bodega,
                anio,
                num,
                ruta
            };

            _AJAX_("/store_contenedor", "POST", token, datos, 0);

        }
    }

    const get_contenedors_b = (id_bodega) => {
        return $.ajax({
            url: "/get_contenedor/" + id_bodega,
            type: "GET",
            dataType: "json",
        });
    }
    const GET_numeracion = (id) => {
        return $.ajax({
            url: "/get_numeracion/" + id + "/" + bodega_item[0].b_id,
            type: "GET",
            dataType: "json",
        });
    }

    const open_contenedor = (numeracion, id, c) => {
        //NUMERACION ES LA RUTA  DE LA CARPETA 
        // ID ES EL ID DEL CONTENEDOR
        // C nombre de la carpeta
        $("#" + cont_select).removeClass('active');
        $("#load_folder").show();
        console.log(numeracion, id);
        let token = $("#csrf-token").val();
        datos = {
            numeracion,
            id
        }
        $.ajax({
            url: "/open_contenedor",
            type: "POST",
            dataType: "json",
            data: datos,
            headers: {
                "X-CSRF-TOKEN": token
            },
            success: function(res) {
                $("#current_dir").val(numeracion);

                if (res == '[]') {
                    let html = '<div id="ar_com_vacio"><img src="Imagenes/archivo/caja-vacia.png" alt=""><span>Contenedor se encuentra vacio</span></div>'
                    $("#ar_content_update").html(html);
                } else {
                    let html = '';
                    res.carpetas.forEach(function(i, v) {
                        let current_ruta = "'" + numeracion + "/" + i.carpeta + "'";
                        /*const myArrayfolder = i.split("/");

                        let name_folder = myArrayfolder[myArrayfolder.length - 1];*/

                        html += '<div class="file-image-1 ptop-10"><div class="product-image flex jc-center"><a href="javascript:void(0)" onclick="abrir_carpeta(' + current_ruta + ', ' + i.id + ')"><img src="../Imagenes/archivo/001-archivo.png" class="rounded-5 ar_folders" alt=""></a><ul class="icons"><li><a href="javascript:void(0);" onclick="del_folder(' + i.id + ')" class="bg-danger"><i class="fe fe-trash"></i></a></li><li><a href="javascript:void(0);" class="bg-pink"><i class="fe fe-edit"></i></a></li></ul></div>'
                        html += '<span class="file-name-1">' + i.carpeta + '</span></div>'
                    });

                    res.contenedor.forEach(function(i, v) {
                        $("#c_departamento").html(i.per_perfil);
                        $("#c_tipo").html(i.tipo);
                        $("#c_contenido").html(i.contenido);
                        $("#c_ano").html(i.año);
                        $("#c_desde").html(i.desde);
                        $("#c_hasta").html(i.hasta);
                    });
                    console.log(res.contenedor);
                    $("#ar_content_update").html(html);
                }
                $("#id_contenedor_f").val(id);
                $("#name_contenedor_f").val(c)

                $("#item_bread").html('<li class="breadcrumb-item"><a href="javascript:void(0);">' + c + '</a></li>')
                cont_select = c;
                $("#" + c).addClass('active')
                $("#menu_se").html('<li><a class="dropdown-item" href="javascript:void(0);" onclick="open_form_new_folder()">Nueva carpeta</a></li>')
                $("#load_folder").hide();

            }
        })
    }

    const del_folder = (id_folder) => {

        _AJAX_('del_folder/' + id_folder + '/' + conf_del_folder, 'GET', '', '', 0);
    }

    const del_file_d = (id_file) => {
        let id_folder = $("#id_carpeta_open").val();
        _AJAX_('del_file/' + id_file + '/' + id_folder, 'GET', '', '', 2);

    }
    const abrir_carpeta = (carpeta, id_carpeta) => {

        let htmls = "";
        var token = $("#csrf-token").val();
        $.ajax({
            url: '/open_carpeta_arc',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            dataType: 'json',
            data: {
                carpeta,
                id_carpeta
            },
            success: function(res) {
                console.log("abirendo carpeta:" + carpeta);
                $("#current_dir").val(carpeta);
                $("#id_carpeta_open").val(id_carpeta);
                if (res.length == 0) {
                    let htmm = '<div id="ar_com_vacio"><img src="Imagenes/archivo/carpeta.png" alt=""><span>Carpeta vacio!</span><span>Puede agregar un nuevo archivo dando clic en <i class="fe fe-settings"></i></span><span>Luego da clic en Subir archivo</span>    </div>'
                    $("#ar_content_update").html(htmm);

                } else {
                    $.each(res, function(index, u) {
                        let myArrayfolder = u.archivo.split("/");
                        let carpeta_ = myArrayfolder[myArrayfolder.length - 1];
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
                        let c_ruta = "'" + u.archivo + "'"; //"'" + nombre + "/" + carpeta_ + "'";
                        if (arry_ext.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-pdf-o rojo mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file_d(' + u.id + ')"><i class="fe fe-trash me-2"></i> Eliminar</a><a class="dropdown-item" href="javascript:void(0);" onclick="get_info_file(' + u.id + ')"><i class="fe fe-trash me-2"></i> Informacion</a></div>'
                            htmls += '</div>'

                        } else if (ext_doc.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-word-o azul mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'

                        } else if (ext_docx.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-word-o azul mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'

                        } else if (ext_xls.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-excel-o verde mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'
                        } else if (ext_png.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-image-o mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'
                        } else if (ext_jpg.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-image-o mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'

                        } else if (ext_jpeg.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-image-o mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'
                        } else if (ext_zip.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-archive-o mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'
                        } else if (ext_rar.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-archive-o mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'
                        } else if (ext_7zip.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-archive-o mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'
                        } else if (ext_csv.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="descargar_archivo(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-csv-o mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'
                        } else if (ext_mp4.length > 1) {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="ver_video(' + c_ruta + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link">'
                            htmls += '<div class="card-body d-flex"><i class="fa fa-file-video-o mt_02"></i><span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + c_ruta + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'
                        } else {
                            htmls += '<div class="col-md-6 col-lg-3">'
                            htmls += '<a href="javascript:void(0)" onclick="abrir_carpeta(' + c_ruta + ',' + folder + ',' + home_ + ');" data-toggle="tooltip" data-placement="bottom" title="' + carpeta_ + '" class="card card-link"><div class="card-body d-flex"><i class="fa fa-folder-o gris mt_02"></i>'
                            htmls += '<span class="cortar ml_1">' + carpeta_ + '</span></div></a>'
                            // htmls += '<a href="javascript:void(0);" class="option-dots dotss" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>'
                            //htmls += '<div class="dropdown-menu rounded-7" style=""><a class="dropdown-item" href="javascript:void(0);" onclick="del_file(' + carpeta_ + ')"><i class="fe fe-trash me-2"></i> Eliminar</a></div>'
                            htmls += '</div>'
                        }

                    })
                    //carpeta_actual = temp_carpeta_actual + '/' + nombre;
                    $("#ar_content_update").html(htmls);
                }


                let con = $("#name_contenedor_f").val(); //nombre del contenedor
                let Afolder = carpeta.split("/");

                var index = -1;
                var n = Afolder.length;
                for (var i = 0; i < n; i++) {
                    if (Afolder[i] === con) {
                        index = i;
                        break;
                    }
                }
                let htm = '<li class="breadcrumb-item"><a href="javascript:void(0);">' + con + '</a></li>'
                for (let x = index + 1; x < n; x++) {
                    htm += '<li class="breadcrumb-item active">' + Afolder[x] + '</li>'
                }
                $("#item_bread").html(htm);

                $("#menu_se").html('<li><a class="dropdown-item" href="javascript:void(0);" onclick="open_form_new_folder()">Nueva carpeta</a></li><li><a class="dropdown-item" href="javascript:void(0);" onclick="open_form_new_file()">Subir archivo</a></li>')
                //let carpeta_ = Afolder[myArrayfolder.length - 1];
                /* $("#mi_unidad").html(htmls);
                 $("#carpeta_actual").html(carpeta);


                 let nav_ = "";
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
                 $("#breadcrumb").html(nav_);

                 console.log(carpeta_actual);*/
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

    $("#btn_subir").click(function() {
        $("#btn_subir").html("<i class='fa fa-spinner fa-spin fa-fw margin-bottom'></i><span>Subiendo proceso espere...</span>");
        $("#btn_subir").prop('disabled', true);
        subirArchivos();
    });

    function subirArchivos(carpeta_actual) {
        var token = $("#csrf-token").val();
        let f_current = $("#current_dir").val();
        var ruta = btoa(unescape(encodeURIComponent(f_current)));
        let asunto = $("#ip_asunto").val();
        let departamento = $("#sel_departamento_pro").val();
        let tipo_proceso = $("#sel_tipo_pro").val();
        let num_identificacion = $("#ip_numero_identificacion").val();
        let num_orden = $("#ip_numero_orden").val();
        let fecha_emision = $("#ip_fecha_emision").val();
        let id_folder = $("#id_carpeta_open").val();
        $("#archivo").upload('/subir_proceso', {
                ruta,
                asunto,
                departamento,
                tipo_proceso,
                num_identificacion,
                num_orden,
                fecha_emision,
                id_folder
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
                    $("#modal_subir_archivo").modal("hide");
                    //console.log(carpeta_actual);
                    let folder_ac = $("#current_dir").val();
                    let id_folder = $("#id_carpeta_open").val();
                    abrir_carpeta(folder_ac, id_folder);
                    $("#btn_subir").html("SUBIR PROCESO");
                    $("#btn_subir").removeAttr('disabled');
                } else {
                    //  mostrarRespuesta('El archivo NO se ha podido subir.', false);
                    alert("El archivo NO se ha podido subir. si el archivo pesa mas de 1 GB recarge su navegador ");
                    $("#btn_subir").html("SUBIR PROCESO");
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


    $('.dropify').dropify({
        messages: {
            'default': 'Arrastra aqui sus archivos',
            'replace': 'Arrastra y suelta o haz clic para reemplazar',
            'remove': 'Eliminar',
            'error': 'Ooops, algo malo paso.'
        }
    });
    const _AJAX_ = (ruta_AJX, tipo, token, datos, p) => {
        if (tipo == "POST") {
            $.ajax({
                url: ruta_AJX,
                type: tipo,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": token
                },
                data: datos,
                success: function(res) {
                    if (p == 0) {
                        if (res.respuesta) {
                            get_contenedors_b(datos.id_bodega).then(result => {
                                let items_contenedores = "";
                                if (result.length > 0) {
                                    result.forEach(function(i, v) {
                                        let r = "'" + ruta + "/" + i.numeracion + "'"
                                        let c = "'" + i.numeracion + "'";
                                        if (v == 0) {
                                            items_contenedores += '<a class="nav-link thumb active" data-bs-toggle="tooltip" data-bs-placement="right" title="Tooltip on right" href="javascript:void(0);" onclick="open_contenedor(' + r + ',' + i.id + ',' + c + ')">'
                                            if (i.id_tipo_almacenamiento == 1) { // caja
                                                items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>'
                                            } else if (i.id_tipo_almacenamiento == 2) { //Mobiliarios
                                                items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122" /></svg>'
                                            } else {
                                                items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" /></svg>'
                                            }
                                            items_contenedores += '<div class="ar_contenedores"><span>' + i.numeracion + '</span>'
                                            items_contenedores += '<span>' + i.contenido + '</span></div></a>'

                                            open_contenedor(r, i.id, i.numeracion);
                                        } else {
                                            items_contenedores += '  <a class="nav-link thumb" data-bs-toggle="tooltip" data-bs-placement="right" title="Tooltip on right" href="javascript:void(0);" onclick="open_contenedor(' + r + ',' + i.id + ',' + c + ')">'
                                            if (i.id_tipo_almacenamiento == 1) { // caja
                                                items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>'
                                            } else if (i.id_tipo_almacenamiento == 2) { //Mobiliarios
                                                items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h7.5A2.25 2.25 0 0118 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 004.5 9v.878m13.5-3A2.25 2.25 0 0119.5 9v.878m0 0a2.246 2.246 0 00-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0121 12v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6c0-.98.626-1.813 1.5-2.122" /></svg>'
                                            } else {
                                                items_contenedores += '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" /></svg>'
                                            }
                                            items_contenedores += '<div class="ar_contenedores"><span>' + i.numeracion + '</span>'
                                            items_contenedores += '<span>' + i.contenido + '</span></div></a>'
                                        }
                                    });
                                } else {
                                    items_contenedores += '<span class="nav-link thumb"><img src="./Imagenes/archivo/vacio.png">Bodega sin contenedor </span>';
                                }
                                $("#nav_contenedores").html(items_contenedores);

                            })

                            console.log("ruta de folder new:" +
                                res.ruta);
                            /*  Swal.fire(
                                  "Tramites!",
                                  "los tramites han sido reagsinado.",
                                  "success"
                              );
                              _AJAX_("/get_project", "GET", "", "", 0);
                              $("#btn_save_project").html(
                                  '<i class="fa fa-save"></i> Guardar'
                              );*/
                            $("#modal-create").modal("hide");
                        }
                    } else if (p == 1) {
                        if (res.respuesta) {
                            $("#modal-create-folder").modal('hide')

                            open_contenedor(ruta + "/" + $("#name_contenedor_f").val(), $("#id_contenedor_f").val(), $("#name_contenedor_f").val());
                        } else {
                            alert(res.res);
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
        } else if (tipo == "GET") {
            $.ajax({
                url: ruta_AJX,
                type: tipo,
                dataType: "json",
                success: function(res) {
                    let html_ = "";
                    if (p == 0) {
                        if (res.WS_RES == false) {
                            if (res.WS_CODE == '500') {
                                Swal.fire({
                                    title: 'Esta tratando de eliminar una carpeta con archivos?',
                                    text: "Esta seguro de continuar!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Si, Eliminar!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        conf_del_folder = 't';
                                        _AJAX_('del_folder/' + res.WS_data + '/' + conf_del_folder, 'GET', '', '', 0);

                                        /*Swal.fire(
                                            'Deleted!',
                                            'Your file has been deleted.',
                                            'success'
                                        )*/
                                    }
                                })
                            }
                        } else {
                            conf_del_folder = 'f';
                            let folder_ac = $("#current_dir").val();
                            let id_folder = $("#id_carpeta_open").val();
                            abrir_carpeta(folder_ac, id_folder);
                        }

                    } else if (p == 1) {
                        $("#inf_file").show();
                        $.each(res, function(index, u) {
                            $("#fi_tipo").html(u.tipo)
                            $("#fi_asunto").html(u.detalle_asunto)
                            $("#fi_usuario").html(u.usuario)
                            $("#fi_numero_iden").html(u.numero_identificacion)
                            $("#fi_numero_orden").html(u.numero_orden)
                            $("#fi_fecha_emi").html(u.fecha_emision_doc)
                            $("#fi_fecha_created").html(u.created_at)
                        });

                    } else if (p == 2) {
                        if (res.WS_CODE == '200') {
                            let folder_ac = $("#current_dir").val();
                            let id_folder = $("#id_carpeta_open").val();
                            abrir_carpeta(folder_ac, id_folder);
                        } else {
                            alert(res.WS_MSM);
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
    }

    const descargar_archivo = (ruta) => {
        let r = btoa(unescape(encodeURIComponent(ruta)));

        var url = "/descargar_archivo/" + r;
        console.log(url);
        var a = document.createElement("a");
        a.target = "_blank";
        a.href = url;
        a.click();
    }

    const get_info_file = (id) => {
        _AJAX_('get_info_f/' + id, 'GET', '', '', 1);
    }

    const c_info = () => {
        $("#inf_file").hide();

    }

    /*function dodrop(event) {
        event.preventDefault();
        var dt = event.dataTransfer.items;
        console.log(dt);
        dt.forEach((item, i) => {
            // If dropped items aren't files, reject them
            if (item.kind === "file") {
                const file = item.getAsFile();
                console.log(`… file[${i}].name = ${file.name}`);
            }
        });
        return false;
        var files = dt.files;
        console.log(files);
        var count = files.length;
        output("File Count: " + count + "\n");

        for (var i = 0; i < files.length; i++) {
            output(" File " + i + ":\n(" + (typeof files[i]) + ") : <" + files[i] + " > " +
                files[i].name + " " + files[i].size + "\n");
        }
    }


    function output(text) {
        //document.getElementById("output").textContent += text;
        //dump(text);
        console.log(text)
        event.target.style.border = "";
    }


    document.addEventListener("dragend", function(event) {
        //        document.getElementById("demo").innerHTML = "Finished dragging the p element.";
        //      event.target.style.opacity = "1";
    });

    document.addEventListener("dragenter", function(event) {
        //console.log(event);
      
    if (event.target.className == "row update_file") {
        event.target.style.border = "3px dotted red";
    }
    });

    document.addEventListener("dragover", function(event) {
        event.preventDefault();
    });

    // When the draggable p element leaves the droptarget, reset the DIVS's border style
    document.addEventListener("dragleave", function(event) {
        if (event.target.className == "row update_file") {
            event.target.style.border = "";
        }
    });*/
</script>
@endsection