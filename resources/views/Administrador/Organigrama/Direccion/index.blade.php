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
                    <h1 class="content-title mb-0 my-auto color-titulo">Direcciones</h1>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-direccion">
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
                                <div id="div-table-direccion"></div>
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

<!-- Modal agregar direccion organizacional -->
<x-administrador.organigrama.direccion.modal_agregar_modificar_direccion titulo="Agregar Dirección Organizacional" idModalDireccion="modal_agregar_direccion" idFormModalDireccion="form_agregar_direccion">
</x-administrador.organigrama.direccion.modal_agregar_modificar_direccion>
<!-- Fin Modal agregar direccion organizacional -->

<!-- Modal modificar direccion organizacional -->
<x-administrador.organigrama.direccion.modal_agregar_modificar_direccion titulo="Modificar Dirección Organizacional" idModalDireccion="modal_modificar_direccion" idFormModalDireccion="form_modificar_direccion">
</x-administrador.organigrama.direccion.modal_agregar_modificar_direccion>
<!-- Fin Modal modificar direccion organizacional -->

<!-- Modal confirmacion borrar bodega -->
<x-generico.confirm_delete idModal="modal_confirm_delete_direccion" idFormModal="form_confirm_delete_direccion" idDelete="txt-id-delete-direccion" messageDelete="Esta seguro de eliminar esta Dirección?" idBtnDelete="btn-delete-direccion">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar bodega -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Organigrama/direccion_organigrama.js'></script>
@endsection