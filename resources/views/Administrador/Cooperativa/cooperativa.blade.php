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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestion de Cooperativas</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-cooperativa">
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
                                <div id="div-table-cooperativa"></div>
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
<!-- INICIO MODAL AÑADIR COOPERATIVAS -->
<x-administrador.cooperativa.modal_agregar_cooperativa :update="false"></x-administrador.cooperativa.modal_agregar_cooperativa>
<!--FIN MODAL AÑADIR COOPERATIVAS -->
<!--INICIO MODAL ELIMINAR COOPERATIVAS -->
<x-generico.confirm_delete idModal='modal-eliminar-cooperativa' idFormModal='form-eliminar-cooperativa' idDelete='txt-id-cooperativa' messageDelete='Seguro de eliminar la cooperativa' idBtnDelete='btn-eliminar-cooperativa'></x-generico.confirm_delete>
<!--FIN MODAL ELIMINAR COOPERATIVAS -->
<!-- INICIO MODAL MODIFICAR COOPERATIVAS -->
<x-administrador.cooperativa.modal_agregar_cooperativa :update="true"></x-administrador.cooperativa.modal_agregar_cooperativa>
<!--FIN MODAL MODIFICAR COOPERATIVAS -->
<!-- INICIO MODAL AÑADIR DESTINOS DE COOPERATIVA -->
<x-administrador.cooperativa.modal_destinos_cooperativa></x-administrador.cooperativa.modal_destinos_cooperativa>
<!--FIN MODAL AÑADIR DESTINOS DE COOPERATIVA -->
<!--INICIO MODAL ELIMINAR DESTINOS COOPERATIVAS -->
<x-generico.confirm_delete idModal='modal-destino-cooperativa-e' idFormModal='form-destino-cooperativa-e' idDelete='txt-id-destino-cooperativa' messageDelete='Seguro de eliminar el destino de la cooperativa' idBtnDelete='btn-eliminar-destino-cooperativa'></x-generico.confirm_delete>
<!--FIN MODAL ELIMINAR DESTINOS COOPERATIVAS -->
<!-- INICIO MODAL AÑADIR HORARIOS DESTINOS DE COOPERATIVA -->
<x-administrador.cooperativa.modal_frecuencia_cooperativa></x-administrador.cooperativa.modal_frecuencia_cooperativa>
<!--FIN MODAL AÑADIR HORARIOS DESTINOS DE COOPERATIVA -->
<!--INICIO MODAL ELIMINAR HORARIOS DESTINOS COOPERATIVAS -->
<x-generico.confirm_delete idModal='modal-horario-destino-cooperativa-e' idFormModal='form-horario-destino-cooperativa-e' idDelete='txt-id-horario-destino-cooperativa' messageDelete='Seguro de eliminar el horario del destino de la cooperativa' idBtnDelete='btn-eliminar-horario-destino-cooperativa'></x-generico.confirm_delete>
<!--FIN MODAL ELIMINAR HORARIOS DESTINOS COOPERATIVAS -->
@endsection

@section('js')
    <script type="text/javascript" src="/js/Cooperativa/cooperativa.js"></script>
@endsection

@else
    <script>
        location.href = "/login";
    </script>
@endif
