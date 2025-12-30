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
                    <h1 class="content-title mb-0 my-auto color-titulo">Configuración de Documentos</h1>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-configuracion-documentos">
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
                                <div id="div-table-configuracion-documentos"></div>
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

<!-- Modal agregar configuracion unidades almacenamiento -->
<x-administrador.archivo.configuraciondocumentos.modal_agregar_modificar_configuracion_documentos titulo="Agregar Configuración de Documento" idModalConfiguracionDocumentos="modal_agregar_configuracion_documento" idFormModalConfiguracionDocumento="form_agregar_configuracion_documento">
</x-administrador.archivo.configuraciondocumentos.modal_agregar_modificar_configuracion_documentos>
<!-- Fin Modal agregar configuracion unidades almacenamiento -->

<!-- Modal modificar configuracion unidades almacenamiento -->
<x-administrador.archivo.configuraciondocumentos.modal_agregar_modificar_configuracion_documentos titulo="Modificar Configuración de Documento" idModalConfiguracionDocumentos="modal_modificar_configuracion_documento" idFormModalConfiguracionDocumento="form_modificar_configuracion_documento">
</x-administrador.archivo.configuraciondocumentos.modal_agregar_modificar_configuracion_documentos>
<!-- Fin Modal modificar configuracion unidades almacenamiento -->

<!-- Modal confirmacion borrar configuracion unidades almacenamiento -->
<x-generico.confirm_delete idModal="modal_confirm_delete_configuracion_documento" idFormModal="form_confirm_delete_configuracion_documento" idDelete="txt-id-delete-configuracion-documento" messageDelete="Esta seguro de eliminar esta configuración de documento?" idBtnDelete="btn-delete-configuracion-documento">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar configuracion unidades almacenamiento -->
@endsection

@section('js')
<script type='text/javascript' src='/js/ConfiguracionDocumentos/configuracion_documentos.js'></script>
@endsection