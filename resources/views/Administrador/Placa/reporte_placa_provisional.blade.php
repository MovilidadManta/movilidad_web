@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
<style>
    .btn-buscar-certificado {
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
                    <h2 class="content-title mb-0 my-auto color-titulo" id="title_formulario">Reporte General de Placas
                        Provisionales</h2>
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
                    <form class="form" novalidate id="form-certificados-medicos" method="POST"
                        enctype="multipart/form-data">
                        <div class="row" style="margin-bottom: 1em;">
                            <div class="col-xs-4 col-md-1 mg-t-10">
                                <strong>Fecha Inicio</strong>
                            </div>
                            <div class="col-xs-8 col-md-2">
                                <input class="form-control" name="select-fecha-inicio" id="select-fecha-inicio"
                                    type="date">
                            </div>
                            <div class="col-xs-4 col-md-1 mg-t-10">
                                <strong>Fecha Fin</strong>
                            </div>
                            <div class="col-xs-8 col-md-2 mg-b-10">
                                <input class="form-control" name="select-fecha-fin" id="select-fecha-fin" type="date">
                            </div>
                            <!--<div class="col-xs-4 col-md-2 mg-t-10 text-end">
                                <strong>Tipo de certificado</strong>
                            </div>
                            <div class="col-xs-8 col-md-2 mg-b-10">
                                <select name="select-certificado-ficha" id="select-certificado-ficha"
                                    class="form-control">
                                    <option value="0">TODOS</option>
                                    <option value="1">CERTIFICADO POR DÍAS</option>
                                    <option value="2">CERTIFICADO POR HORAS</option>
                                    <option value="3">REVISIÓN MÉDICA</option>
                                </select>
                            </div>-->
                            <div class="col-xs-12 col-md-2 text-end">
                                <a class="btn background-btn-nuevo pad-nu btn-buscar-certificado"
                                    id="btn-reporte-placa-provisional">
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
            <div id="div-table-placa-provisional">

            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script type='text/javascript' src='/js/Placa/reporte_placa_provisional.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif