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
                    <h1 class="content-title mb-0 my-auto color-titulo">Gestión de Bodegas</h1>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-bodega">
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
                                <div id="div-table-bodega"></div>
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
<x-administrador.archivo.bodega.modal_agregar_modificar_bodega titulo="Agregar Bodega" idModalBodega="modal_agregar_bodega" idFormModalBodega="form_agregar_bodega">
</x-administrador.archivo.bodega.modal_agregar_modificar_bodega>
<!-- Fin Modal agregar bodega -->

<!-- Modal modificar bodega -->
<x-administrador.archivo.bodega.modal_agregar_modificar_bodega titulo="Modificar Bodega" idModalBodega="modal_modificar_bodega" idFormModalBodega="form_modificar_bodega">
</x-administrador.archivo.bodega.modal_agregar_modificar_bodega>
<!-- Fin Modal modificar bodega -->

<!-- Modal confirmacion borrar bodega -->
<x-generico.confirm_delete idModal="modal_confirm_delete_bodega" idFormModal="form_confirm_delete_bodega" idDelete="txt-id-delete-bodega" messageDelete="Esta seguro de eliminar esta Bodega?" idBtnDelete="btn-delete-bodega">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar bodega -->
@endsection

@section('js')
<script type='text/javascript' src='/js/Bodega/bodega.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif