@extends('Administrador.Layout.app')

@section('css')
<style>
    .btn-buscar-certificado{
        margin-top: -3px !important;
    }
    .pointer{
        cursor: pointer;
    }
    .chart_div{
        height: 300px;
    }
    .btn_details{
        background: transparent;
        border: none;
        color: #009ee2;
        font-size: 16px;
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Reporte de Certificados Médicos</h2>
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
                            <div class="col-xs-12 mb-3">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    Tipo de Reporte
                                </label>
                                <select name="tipo_reporte" id="tipo_reporte" class="form-control">
                                    <option value="0">TOP TIPO DE DIAGNÓSTICOS</option>
                                    <option value="1">TOP EMPLEADOS CON MAS ATENCIONES MEDICAS</option>
                                    <option value="2">TOP PERMISOS POR ATENCIÓN MEDICA</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-6 mg-t-10">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    FECHA INICIO
                                </label>
                                <input class="form-control" name="select-fecha-inicio" id="select-fecha-inicio"
                                    type="date">
                            </div>
                            <div class="col-xs-12 col-md-6 mg-t-10">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    FECHA FIN
                                </label>
                                <input class="form-control" name="select-fecha-fin" id="select-fecha-fin"
                                    type="date">
                            </div>
                            <div class="col-xs-12 col-md-6 mg-t-10">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    TIPO DE CERTIFICADO
                                </label>
                                <select name="select-certificado-ficha" id="select-certificado-ficha" class="form-control">
                                    <option value="0">TODOS</option>
                                    <option value="1">CERTIFICADO POR DÍAS</option>
                                    <option value="2">CERTIFICADO POR HORAS</option>
                                    <option value="3">REVISIÓN MÉDICA</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-6 mg-t-10">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    CANTIDAD DE REGISTROS
                                </label>
                                <select name="select-nro-top" id="select-nro-top" class="form-control">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="col-xs-12 mg-t-20 d-flex justify-content-center align-items-end">
                                <div>
                                    <a href="#" class="btn background-btn-nuevo pad-nu btn-buscar-certificado" id="btn-reporte-certificados">
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
                                <div class="main-content-label mg-b-5">
                                    Gráfico
                                </div>
                                <div class="chart_div">
                                    <canvas id="chartReport"></canvas>
                                </div>
                                <div class="table-responsive mt-3">
                                    <div class="col-md-12 marg" id="optionsDownload" style="display: none;">
                                        <a id="downloadExcel" target="_blank" href="">
                                            <i class="far fa-file-excel tam-excell"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-12 marg" id="optionsDownload_details" style="display: none;">
                                        <a id="backpageDetail" target="_blank" href="">
                                            <i class="fa fa-arrow-circle-left tam-excell"></i>
                                        </a>
                                        <a id="downloadExcelDetail" target="_blank" href="">
                                            <i class="far fa-file-excel tam-excell"></i>
                                        </a>
                                    </div>
                                    <div id="div_table_reporte_medicos"></div>
                                    <div id="div_table_reporte_medicos_detail" style="display: none;"></div>
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
<script src="/valex/assets/js/custom/construct_graphics.js"></script>
<script type='text/javascript' src='/js/Medico/reportes_graficos.js'></script>
@endsection