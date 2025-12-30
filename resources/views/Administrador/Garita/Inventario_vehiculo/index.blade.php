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
                    <h1 class="content-title mb-0 my-auto color-titulo">Configuración de Inventario de vehículos</h1>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn_add_inventario_vehiculos">
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
                                <div id="div_table_inventario_vehiculos"></div>
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
<x-administrador.garita.inventario_vehiculo.modal_agregar_modificar_configuracion_inventario_vehiculo titulo="Agregar Configuración de Inventario Vehículo" idModalConfiguracionInventarioVehiculo="modal_agregar_inventario_vehiculo" idFormModalConfiguracionInventarioVehiculo="form_configuracion_inventario_vehiculo">
</x-administrador.garita.inventario_vehiculo.modal_agregar_modificar_configuracion_inventario_vehiculo>
<!-- Fin Modal agregar configuracion unidades almacenamiento -->

<!-- Modal confirmacion borrar configuracion unidades almacenamiento -->
<x-generico.confirm_delete idModal="modal_confirm_delete_inventario_vehiculo" idFormModal="form_confirm_delete_inventario_vehiculo" idDelete="txt_id_delete_inventario_vehiculo" messageDelete="Esta seguro de eliminar este inventario de vehiculo?" idBtnDelete="btn_delete_iventario_vehiculo">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar configuracion unidades almacenamiento -->
@endsection

@section('js')
<script type='text/javascript' src='/js/Garita/inventario_vehiculo.js'></script>
@endsection