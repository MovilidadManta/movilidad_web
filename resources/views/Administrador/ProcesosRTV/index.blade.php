@extends('Administrador.Layout.app')

@section('css')
<style>
    .detalle_placa{
        margin-top: 20px;
    }
    .btn_aprobar{
        margin-top: 20px;
    }
    .form-control[readonly]{
        background-color: rgb(255, 255, 255);
    }
    input:-internal-autofill-selected{
        background-color: rgb(255, 255, 255);
    }
    .form-control{
        color: black;
    }
    .form-control:focus{
        color: black;
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
                <div class="col-xs-12">
                    <h1 class="content-title mb-0 my-auto color-titulo">Aprobacion de Placas RTV</h1>
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
                            <div class="example2">
                                <div class="panel panel-primary tabs-style-3">
                                    <div class="tab-menu-heading">
                                        <div class="tabs-menu ">
                                            <!-- Tabs -->
                                            <ul class="nav panel-tabs">
                                                <li class=""><a href="#tab_aprobacion_one_to_one" class="active"
                                                        data-bs-toggle="tab"><i class="fa fa-car"></i> Aprobación manual</a></li>
                                                <li><a href="#tab_aprobacion_many" data-bs-toggle="tab"><i
                                                            class="fa fa-database"></i> Aprobación Lote</a></li>
                                                <li><a href="#tab_aprobacion_numero_orden" data-bs-toggle="tab"><i
                                                    class="fa fa-check-square"></i> Aprobar número de Orden</a></li>
                                                <li><a href="#tab_anular_numero_orden" data-bs-toggle="tab"><i
                                                    class="fa fa-minus-square"></i> Anular número de Orden</a></li>
                                                <li><a href="#tab_reporte_diario" data-bs-toggle="tab"><i
                                                    class="fa fa-file-excel-o"></i> Reporte Diario</a></li>
                                                <li><a href="#tab_reporte_api" data-bs-toggle="tab"><i
                                                    class="fa fa-bars"></i> Reporte API</a></li>
                                                <li><a href="#tab_conteo_diario" data-bs-toggle="tab"><i
                                                    class="fa fa-sort-numeric-asc"></i> Conteo Diario</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body tabs-menu-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_aprobacion_one_to_one">
                                                <x-administrador.procesosrtv.aprobacion_one_to_one>
                                                </x-administrador.procesosrtv.aprobacion_one_to_one>
                                            </div>
                                            <div class="tab-pane" id="tab_aprobacion_many">
                                                <x-administrador.procesosrtv.aprobacion_many>
                                                </x-administrador.procesosrtv.aprobacion_many>
                                            </div>
                                            <div class="tab-pane" id="tab_aprobacion_numero_orden">
                                                <x-administrador.procesosrtv.aprobar_numero_orden>
                                                </x-administrador.procesosrtv.aprobar_numero_orden>
                                            </div>
                                            <div class="tab-pane" id="tab_anular_numero_orden">
                                                <x-administrador.procesosrtv.anular_numero_orden>
                                                </x-administrador.procesosrtv.anular_numero_orden>
                                            </div>
                                            <div class="tab-pane" id="tab_reporte_diario">
                                                <x-administrador.procesosrtv.reporte_diario>
                                                </x-administrador.procesosrtv.reporte_diario>
                                            </div>
                                            <div class="tab-pane" id="tab_reporte_api">
                                                <x-administrador.procesosrtv.reporte_api>
                                                </x-administrador.procesosrtv.reporte_api>
                                            </div>
                                            <div class="tab-pane" id="tab_conteo_diario">
                                                <x-administrador.procesosrtv.conteo_diario>
                                                </x-administrador.procesosrtv.conteo_diario>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
<x-administrador.procesosrtv.modal_aprobar_rtv idModalFormulario="modal_aprobar_rtv">
</x-administrador.procesosrtv.modal_aprobar_rtv>
<!-- Fin Modal agregar configuracion unidades almacenamiento -->

<!-- Modal mensaje emergente -->
<x-generico.message_emergent idModal="modal_message_emergente" idMessage="txt_message_emergente">
</x-generico.message_emergent>
<!-- Fin Modal mensaje emergente -->

@endsection

@section('js')
<script type='text/javascript' src='/js/procesos_rtv/procesos_rtv.js?v=20250813'></script>
@endsection