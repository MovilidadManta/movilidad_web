@extends('Administrador.Layout.app')

@section('css')
<style>
    .swal2-container {
        z-index: 99999 !important;
    }
    .border_dashed{
        border-bottom: 1px dashed #009ee2;
    }
    #table-responsive_charge{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 400px;
    }
    .icon_charge {
        font-size: 3em; /* Tamaño del icono */
        color: #007bff; /* Color del icono */
        animation: rotate 2s linear infinite; /* Inicia la animación de rotación */
    }
    .status_document{
        font-size: 15px;
        padding: 10px !important;
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Documentos requeridos</h2>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn_add_documento_requerido">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>

     <!-- row -->
     <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="card box-sha">
                <div class="card-body">
                    <div class="row row-sm">
                        <div class="card-body">
                            <div id="table-responsive" class="table-responsive">
                                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                                <div id="div_table_documentos_requeridos"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
</div>
<!-- Container closed -->

<!-- INICIO MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_delete_documento_requerido" message="Esta seguro de borrar este documento?" idBtnConfirm="btn_confirm_delete_documento_requerido" idBtnCancel="btn_cancelar_delete_documento_requerido">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->


<!-- INICIO MODAL AGREGAR MODIFICAR TIPO DE VEHICULO  -->
<x-administrador.garita.documento_requerido.modal_modificar_agregar_documento_requerido idModalDocumento="modal_add_mod_documento_requerido">
</x-administrador.garita.documento_requerido.modal_modificar_agregar_documento_requerido>
<!-- FIN MODAL AGREGAR MODIFICAR TIPO DE VEHICULO  -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Garita/documento_requerido.js'></script>
@endsection