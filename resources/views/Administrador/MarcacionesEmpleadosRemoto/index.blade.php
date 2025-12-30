@extends('Administrador.Layout.app')

@section('css')
<style>
    .container_modal_foto_empleado{
        width: 70%;
        margin-left: auto;
        margin-right: auto;
    }
    .foto_empleado{
        min-height: 100%;
    }
    .form-control[readonly] {
        background-color: transparent;
        opacity: 1;
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
                <div class="col-xs-12 col-md-6">
                    <h1 class="content-title mb-0 my-auto color-titulo">Configuración de Empleados Remoto</h1>
                </div>
                <div class="col-xs-12 col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn_add_empleado_remoto">
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
                    <div id="div_table_empleados_remotos">

                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->
</div>

<!-- INICIO MODAL APROBAR CERTIFICADO  -->
<x-administrador.marcacionesempleadosremoto.modal_agregar_modificar_empleado_remoto idModalEmpleadoRemoto="modal_agregar_modificar_empleado_remoto">
</x-administrador.marcacionesempleadosremoto.modal_agregar_modificar_empleado_remoto>
<!-- FIN MODAL APROBAR CERTIFICADO  -->

<x-generico.confirm_delete idModal="modal_confirm_delete_empleado_remoto" idFormModal="form_modal_confirm_delete_empleado_remoto" idDelete="cer_id_delete" messageDelete="Confirma que desea eliminar la configuración para empleado remoto" idBtnDelete="btn_delete_empleado_remoto">
</x-generico.confirm_delete>

@endsection

@section('js')
<script type='text/javascript' src='/js/marcaciones_empleados_remoto/empleados_remoto.js?v=20250919'></script>
@endsection