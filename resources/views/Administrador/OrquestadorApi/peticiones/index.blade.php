@extends('Administrador.Layout.app')

@section('css')
<style>
    .swal2-container {
        z-index: 99999 !important;
    }
    .border_dashed{
        border-bottom: 1px dashed #009ee2;
    }
    .icon_charge {
        font-size: 3em; /* Tamaño del icono */
        color: #007bff; /* Color del icono */
        animation: rotate 2s linear infinite; /* Inicia la animación de rotación */
    }
    #btn_guardar_respuesta{
        margin-left: 5px;
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
                    <h2 class="content-title mb-0 my-auto color-titulo">PETICIONES</h2>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn_add_proveedor_api">
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
                                <div id="div_table_proveedor_api"></div>
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

<!-- INICIO MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->
<x-administrador.orquestadorapi.modal_modificar_agregar_proveedor_api idModalFormulario="modal_add_mod_proveedor">
</x-administrador.orquestadorapi.modal_modificar_agregar_proveedor_api>
<!-- FIN MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->
<x-administrador.orquestadorapi.modal_modificar_agregar_servicio idModalDocumento="modal_add_mod_proveedor_servicio">
</x-administrador.orquestadorapi.modal_modificar_agregar_servicio>
<!-- FIN MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->
<x-administrador.orquestadorapi.modal_modificar_agregar_view_peticiones idModalFormulario="modal_view_peticiones">
</x-administrador.orquestadorapi.modal_modificar_agregar_view_peticiones>
<!-- FIN MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->
<x-administrador.orquestadorapi.modal_modificar_agregar_peticiones idModalDocumento="modal_add_mod_peticion">
</x-administrador.orquestadorapi.modal_modificar_agregar_peticiones>
<!-- FIN MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->
<x-administrador.orquestadorapi.modal_modificar_agregar_respuestas_peticiones>
</x-administrador.orquestadorapi.modal_modificar_agregar_respuestas_peticiones>
<!-- FIN MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_delete_proveedor_api" message="Esta seguro de borrar este proveedor api?" idBtnConfirm="btn_confirm_delete_proveedor_api" idBtnCancel="btn_cancelar_delete_proveedor_api">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_delete_peticion" message="Esta seguro de borrar esta peticion?" idBtnConfirm="btn_confirm_delete_peticion" idBtnCancel="btn_cancelar_delete_peticion">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_delete_peticion_respuesta" message="Esta seguro de borrar esta respuesta de la peticion?" idBtnConfirm="btn_confirm_delete_peticion_respuesta" idBtnCancel="btn_cancelar_delete_peticion_respuesta">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->
@endsection

@section('js')
<script type='text/javascript' src='/js/OrquestadorApi/peticionesList.js'></script>
@endsection