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
                    <h1 class="content-title mb-0 my-auto color-titulo">Gestión de Eventos</h1>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-eventos">
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
                                <div id="div-table-eventos"></div>
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
<x-administrador.eventos.modal_agregar_modificar_evento titulo="Agregar Eventos" idModalEvento="modal_agregar_evento" idFormModalEvento="form_agregar_evento">
</x-administrador.eventos.modal_agregar_modificar_evento>
<!-- Fin Modal agregar bodega -->

<!-- Modal modificar bodega -->
<x-administrador.eventos.modal_agregar_modificar_evento titulo="Modificar Eventos" idModalEvento="modal_modificar_evento" idFormModalEvento="form_modificar_evento">
</x-administrador.eventos.modal_agregar_modificar_evento>
<!-- Fin Modal modificar bodega -->

<!-- Modal confirmacion borrar bodega -->
<x-generico.confirm_delete idModal="modal_confirm_delete_evento" idFormModal="form_confirm_delete_evento" idDelete="txt-id-delete-evento" messageDelete="Esta seguro de eliminar este Evento?" idBtnDelete="btn-delete-evento">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar bodega -->
@endsection

@section('js')
<script type='text/javascript' src='/js/Eventos/eventos.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif