@extends('Administrador.Layout.app')

@section('css')
<style>
    .jc-end {
        display: flex;
        justify-content: end;
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Busqueda de procesos </h2>
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
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body pb-0">

                    <div class="input-group mb-2">
                        <span class="input-group-text"> <i class="fas fa-search"></i></span>
                        <input type="text" class="form-control rounded-3 br-te-0 br-be-0" id="ip_search" placeholder="Buscar proceso.....">
                        <span class="input-group-text bg-transparent p-0 rounded-3 br-ts-0 br-bs-0 overflow-hidden">
                            <button class="btn ripple btn-primary" id="btn_buscar" type="button" onclick="buscar_procesos();">buscar</button>
                        </span>
                    </div>
                </div>
                <div class="card-body ps-0 pe-0 bd-t-0 pt-0">
                    <div class="main-content-body-profile mb-3">
                        <nav class="nav main-nav-line">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab1">Todo</a>
                            <!--<a class="nav-link" data-bs-toggle="tab" href="#tab2">Images</a>
                            <a class="nav-link" data-bs-toggle="tab" href="#tab3">Books</a>
                            <a class="nav-link" data-bs-toggle="tab" href="#tab4">News</a>
                            <a class="nav-link" data-bs-toggle="tab" href="#tab5">Videos</a>-->
                        </nav>
                    </div>
                    <p class="text-muted mb-0 ps-3" id="total_res"></p>
                </div>
            </div>
            <div id="c_resul_procesos">

            </div>
        </div>
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

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <strong>Tipo de proceso: <span>(*)</span></strong>
                                        <select class="form-control" id="sel_tipo_pro">
                                            <option value="0">Seleccione un Tipo de proceso</option>

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


<script>
    $("#ip_search").keypress(function(tecla) {
        if (tecla.which == 13) {
            $("#btn_buscar").attr('disabled', true);
            let palabras = $("#ip_search").val();
            if (palabras == "") {
                $("#btn_buscar").removeAttr('disabled');

            } else {
                _AJAX_('search_proceso/' + palabras, 'GET', '', palabras, 0);

            }
        }
    });
    const buscar_procesos = () => {
        let palabras = $("#ip_search").val();
        $("#btn_buscar").attr('disabled', true);

        if (palabras == "") {
            $("#btn_buscar").removeAttr('disabled');

        } else {
            _AJAX_('search_proceso/' + palabras, 'GET', '', '', 0);

        }
    }


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
                            open_contenedor(ruta + "/" + $("#name_contenedor_f").val(), 1, $("#name_contenedor_f").val());
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
            var ajaxTime = new Date().getTime();
            let c = 0;

            $.ajax({
                url: ruta_AJX,
                type: tipo,
                dataType: "json",
                success: function(res) {
                    let html_ = "";
                    if (p == 0) {
                        let html = ''
                        if (res.WS_RES) {
                            if (res.WS_CODE == '200') {
                                if (res.WS_data.length != 0) {
                                    res.WS_data.forEach(function(i, v) {
                                        let ruta = "'" + i.url_ftp_file + "'";
                                        html += '<div class="card custom-card"><div class="card-body"><div class=""><div class="ms-auto jc-end"><div class=""><a href="javascript:void(0);" onclick="c_info()" data-bs-placement="top" data-bs-toggle="tooltip" title="" class="p-2 text-muted" data-bs-original-title="Cerrar información" aria-label="Cerrar información"><i class="fas fa-share-square"></i></a></div></div></div><div class="mb-2">'
                                        html += '<a href="javascript:void(0);" class="h5 card-title">' + i.detalle_asunto + '</a></div>'
                                        html += '<a href="javascript:void(0);" onclick="descargar_archivo(' + ruta + ')"><h6 class="tx-13">' + i.url_ftp_file + '</h6></a>'
                                        html += '<p class="mb-0 text-muted">Número Identificación: ' + i.numero_identificacion + ' Fecha emision del documento: ' + i.fecha_emision_doc + ' el documento se encuentra en la <strong>' + i.tipo_almacen + '</strong> numero ' + i.numeracion
                                        html += ' ubicado en el archivo ' + i.archivo + ' -- ' + i.ubicacion + ' documento subido al archivo por el usuario: ' + i.usuario + ' </p>'
                                        html += '</div></div>'
                                        c++;
                                    });
                                } else {
                                    html += '<span>No se han encontrado resultados para tu búsqueda (<strong>' + datos + '</strong>).</span>'
                                    html += '<br>'
                                    html += '<span>Sugerencias:</span>'
                                    html += '<ul><li>Asegúrate de que todas las palabras estén escritas correctamente.</li>'
                                    html += '<li>Prueba diferentes palabras clave.</li>'
                                    html += '<li>Prueba palabras clave más generales.</li>'
                                    html += '<li>Prueba menos palabras clave.</li>'
                                    html += '</ul>'
                                }

                                $("#c_resul_procesos").html(html);
                            } else {

                                html += '<span>No se han encontrado resultados para tu búsqueda (<strong>' + datos + '</strong>).</span>'
                                html += '<br>'
                                html += '<span>Sugerencias:</span>'
                                html += '<ul><li>Asegúrate de que todas las palabras estén escritas correctamente.</li>'
                                html += '<li>Prueba diferentes palabras clave.</li>'
                                html += '<li>Prueba palabras clave más generales.</li>'
                                html += '<li>Prueba menos palabras clave.</li>'
                                html += '</ul>'
                                $("#c_resul_procesos").html(html);
                            }
                        } else {

                        }

                    }
                },
            }).done(function() {
                var totalTime = new Date().getTime() - ajaxTime;
                $("#total_res").html('Cerca de ' + c + ' resultados ( ' + totalTime / 1000 + ' Seconds )')
                $("#btn_buscar").removeAttr('disabled');

                // Here I want to get the how long it took to load some.php and use it further
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
</script>
@endsection