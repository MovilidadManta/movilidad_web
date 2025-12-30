@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
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
                    <h1 class="content-title mb-0 my-auto color-titulo">Gestión de Tipos de Contenedores</h1>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-contenedor">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
                    </a>
                </div>
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
                            <div class="table-responsive">
                                <div id="div-table-contenedor"></div>
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

<!-- Modal agregar bodega -->
<x-administrador.archivo.tiposcontenedores.modal_agregar_modificar_tipos_contenedores titulo="Agregar Tipo de Contenedor" idModalContenedor="modal_agregar_contenedor" idFormModalContenedor="form_agregar_contenedor">
</x-administrador.archivo.tiposcontenedores.modal_agregar_modificar_tipos_contenedores>
<!-- Fin Modal agregar bodega -->

<!-- Modal modificar bodega -->
<x-administrador.archivo.tiposcontenedores.modal_agregar_modificar_tipos_contenedores titulo="Modificar Tipo de Contenedor" idModalContenedor="modal_modificar_contenedor" idFormModalContenedor="form_modificar_contenedor">
</x-administrador.archivo.tiposcontenedores.modal_agregar_modificar_tipos_contenedores>
<!-- Fin Modal modificar bodega -->

<!-- Modal confirmacion borrar bodega -->
<x-generico.confirm_delete idModal="modal_confirm_delete_contenedor" idFormModal="form_confirm_delete_contenedor" idDelete="txt-id-delete-contenedor" messageDelete="Esta seguro de eliminar este Tipo de Contenedor?" idBtnDelete="btn-delete-contenedor">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar bodega -->
@endsection

@section('js')
<script type='text/javascript' src='/js/TipoC/tipoc.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif