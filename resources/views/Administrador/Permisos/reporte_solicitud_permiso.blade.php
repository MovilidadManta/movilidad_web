@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
<style>
    .btn-buscar-permiso{
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Reporte de Solicitud/Permiso</h2>
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
                    <form class="form" novalidate id="form-m-empleado" method="POST" enctype="multipart/form-data">
                        <div class="row" style="margin-bottom: 1em;">
                            <div class="col-xs-4 col-md-1 mg-t-10">
                                <strong>Fecha Inicio</strong>
                            </div>
                            <div class="col-xs-8 col-md-3">
                                <input class="form-control" name="select-fecha-inicio" id="select-fecha-inicio"
                                    type="date">
                            </div>
                            <div class="col-xs-4 col-md-1 mg-t-10">
                                <strong>Fecha Fin</strong>
                            </div>
                            <div class="col-xs-8 col-md-3 mg-b-10">
                                <input class="form-control" name="select-fecha-fin" id="select-fecha-fin"
                                    type="date">
                            </div>
                            <div class="col-xs-12 col-md-4 text-end">
                                <a class="btn background-btn-nuevo pad-nu btn-buscar-permiso" id="btn-reporte-permisos">
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
                                <div id="div-table-reporte-empleado"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script type='text/javascript' src='/js/Permisos/reporte_solicitud_permiso.js'></script>
@endsection

@else
<script>
location.href = "/login";
</script>
@endif