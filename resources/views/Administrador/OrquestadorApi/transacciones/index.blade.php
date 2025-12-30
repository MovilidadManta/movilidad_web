@extends('Administrador.Layout.app')

@section('css')
<style>
    .swal2-container {
        z-index: 99999 !important;
    }
    .border_dashed{
        border-bottom: 1px dashed #009ee2;
    }
    .icon_charge {
        font-size: 3em; /* Tamaño del icono */
        color: #007bff; /* Color del icono */
        animation: rotate 2s linear infinite; /* Inicia la animación de rotación */
    }
    #btn_guardar_respuesta{
        margin-left: 5px;
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
                    <h2 class="content-title mb-0 my-auto color-titulo">TRANSACCIONES</h2>
                </div>
            </div>
        </div>
    </div>

     <!-- row -->
     <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="card box-sha">
                <div class="card-body">
                    <div class="row row-sm">
                        <div class="card-body">
                            <form class="form" novalidate id="form-certificados-medicos" method="POST" enctype="multipart/form-data">
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
                                        <input class="form-control" name="select-fecha-fin" id="select-fecha-fin"
                                            type="date">
                                    </div>
                                    <div class="col-xs-4 col-md-2 mg-t-10 text-end">
                                        <strong>Usuario correo:</strong>
                                    </div>
                                    <div class="col-xs-8 col-md-2 mg-b-10">
                                        <input
                                            class="form-control"
                                            name="txt_usuario"
                                            id="txt_usuario"
                                            placeholder="Ingresar Usuario"
                                            type="text"
                                        >
                                    </div>
                                    <div class="col-xs-12 col-md-2 text-end">
                                        <a class="btn background-btn-nuevo pad-nu btn-buscar-certificado" id="btn-reporte-transacciones">
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
        </div>
        <!--/div-->
    </div>


    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm">
                        <div class="card-body">
                            <div id="table-responsive" class="table-responsive">
                                <div id="div_table_transacciones"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container closed -->
@endsection

@section('js')
<script type='text/javascript' src='/js/OrquestadorApi/transaccionesList.js'></script>
@endsection