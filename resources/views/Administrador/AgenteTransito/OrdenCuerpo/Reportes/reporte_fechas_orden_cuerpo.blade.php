@extends('Administrador.Layout.app')

@section('css')
<style>
    .btn_buscar_oc{
        margin-top: -3px !important;
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Reporte de Orden de Cuerpo</h2>
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
                    <form class="form" novalidate id="form_orden_cuerpo" method="POST" enctype="multipart/form-data">
                        <div class="row" style="margin-bottom: 1em;">
                            <div class="col-xs-4 col-md-1 mg-t-10">
                                <strong>Fecha Inicio</strong>
                            </div>
                            <div class="col-xs-8 col-md-2">
                                <input class="form-control" name="select_fecha_inicio" id="select_fecha_inicio"
                                    type="date">
                            </div>
                            <div class="col-xs-4 col-md-1 mg-t-10">
                                <strong>Fecha Fin</strong>
                            </div>
                            <div class="col-xs-8 col-md-2 mg-b-10">
                                <input class="form-control" name="select_fecha_fin" id="select_fecha_fin"
                                    type="date">
                            </div>
                            <div class="col-xs-4 col-md-2 mg-t-10 text-end">
                                <strong>ESTADO</strong>
                            </div>
                            <div class="col-xs-8 col-md-2 mg-b-10">
                                <select name="select_estado_orden_cuerpo" id="select_estado_orden_cuerpo" class="form-control">
                                    <option value="0">TODOS</option>
                                    <option value="1">NO APROBADOS</option>
                                    <option value="2">APROBADOS</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-2 text-end">
                                <a class="btn background-btn-nuevo pad-nu btn_buscar_oc" id="btn_reporte_orden_cuerpo">
                                    <i class="fa fa-search color-btn-nuevo"></i>
                                    <strong class="color-btn-nuevo">Buscar</strong>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm">
                        <div class="card-body">
                            <div class="col-md-12 marg" id="optionsDownload" style="display: none">
                                <a id="downloadPDF" target="_blank" href="">
                                    <i class="far fa-file-pdf tam-pdf"></i>
                                </a>
                                <a id="downloadExcel" target="_blank" href="">
                                    <i class="far fa-file-excel tam-excell"></i>
                                </a>
                            </div>
                            <div class="table-responsive">
                                <div id="div_table_reporte_orden_cuerpo"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- INICIO MODAL VISOR PDF  -->
<x-generico.modal_iframe_view idModal="modal_view_pdf_orden_cuerpo" idVisor="iframe_visor_orden_cuerpo" titulo="Visor Orden de cuerpo">
</x-generico.modal_iframe_view>
<!-- FIN MODAL VISOR PDF  -->

@endsection

@section('js')
<script type='text/javascript' src='/js/agentes_transito/orden_cuerpo/reporte_fechas_orden_cuerpo.js'></script>
@endsection