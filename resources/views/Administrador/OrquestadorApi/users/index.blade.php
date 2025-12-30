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
                    <h2 class="content-title mb-0 my-auto color-titulo">USUARIOS - EMPRESAS</h2>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn_add_empresa">
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
                                <div id="div_table_empresas"></div>
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
<x-administrador.orquestadorapi.modal_view_users idModalView="modal_view_usuarios">
</x-administrador.orquestadorapi.modal_view_users>
<!-- FIN MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->
<x-administrador.orquestadorapi.modal_modificar_agregar_empresa idModalDocumento="modal_add_mod_empresa">
</x-administrador.orquestadorapi.modal_modificar_agregar_empresa>
<!-- FIN MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->
<x-administrador.orquestadorapi.modal_modificar_agregar_users idModalDocumento="modal_add_mod_user">
</x-administrador.orquestadorapi.modal_modificar_agregar_users>
<!-- FIN MODAL AGREGAR MODIFICAR CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_delete_empresa" message="Esta seguro de borrar esta empresa?" idBtnConfirm="btn_confirm_delete_empresa" idBtnCancel="btn_cancelar_delete_empresa">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_delete_user" message="Esta seguro de borrar este usuario?" idBtnConfirm="btn_confirm_delete_user" idBtnCancel="btn_cancelar_delete_user">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR DELETE CONVOCATORIA ARRENDAMIENTO  -->

<!-- INICIO MODAL AGREGAR MODIFICAR CONTROL PETICIONES  -->
<x-administrador.orquestadorapi.modal_modificar_agregar_control_peticiones idModalDocumento="modal_add_mod_control_peticiones">
</x-administrador.orquestadorapi.modal_modificar_agregar_control_peticiones>
<!-- FIN MODAL AGREGAR MODIFICAR CONTROL PETICIONES  -->

<!-- INICIO MODAL AGREGAR MODIFICAR CONTROL PETICIONES  -->
<x-administrador.orquestadorapi.modal_modificar_agregar_control_ips idModalDocumento="modal_add_mod_control_ips">
</x-administrador.orquestadorapi.modal_modificar_agregar_control_ips>
<!-- FIN MODAL AGREGAR MODIFICAR CONTROL PETICIONES  -->
@endsection

@section('js')
<script type='text/javascript' src='/js/OrquestadorApi/usersList.js'></script>
@endsection