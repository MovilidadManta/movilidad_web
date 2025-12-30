@extends('Administrador.Layout.app')

@section('css')
<style>

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
                    <h2 class="content-title mb-0 my-auto color-titulo">Reporte de Aportes Ciudadanos</h2>
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
                    <form class="form" novalidate id="form-certificados-medicos" method="POST" enctype="multipart/form-data">
                        <div class="row" style="margin-bottom: 1em;">
                            <div class="col-xs-12 col-md-6 mg-t-10">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    FECHA INICIO
                                </label>
                                <input class="form-control" name="select_fecha_inicio" id="select_fecha_inicio"
                                    type="date">
                            </div>
                            <div class="col-xs-12 col-md-6 mg-t-10">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    FECHA FIN
                                </label>
                                <input class="form-control" name="select_fecha_fin" id="select_fecha_fin"
                                    type="date">
                            </div>
                            <div class="col-xs-12 mg-t-20 d-flex justify-content-center align-items-end">
                                <div>
                                    <a href="#" class="btn background-btn-nuevo pad-nu btn-buscar-certificado" id="btn_reporte_aportes">
                                        <i class="fa fa-table color-btn-nuevo"></i>
                                        <strong class="color-btn-nuevo">Generar Reporte</strong>
                                    </a>
                                </div>
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
                            <div class="col-md-12 marg">
                                <div class="table-responsive mt-3">
                                    <div class="col-md-12 marg" id="optionsDownload" style="display: none;">
                                        <a id="downloadPDF" target="_blank" href="">
                                            <i class="far fa-file-pdf tam-pdf"></i>
                                        </a>
                                        <a id="downloadExcel" target="_blank" href="">
                                            <i class="far fa-file-excel tam-excell"></i>
                                        </a>
                                    </div>
                                    <div id="div_table_aportes_ciudadanos"></div>
                                </div>
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
<script type='text/javascript' src='/js/Reporte/aporte_ciudadano.js'></script>
@endsection