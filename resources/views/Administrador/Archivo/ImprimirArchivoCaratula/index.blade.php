@extends('Administrador.Layout.app')

@section('css')
<style>
    .menu-list{
        list-style: none;
        padding-left: 5px;
        cursor: pointer;
        max-height: 9000px;
        transition: max-height 0.5s ease;
    }

    .menu-list.contract{
        max-height: 0;
        overflow: hidden;
    }

    .menu-list__li{
        border-radius: 10px;
        padding: 5px;
    }

    .menu-list__li.active{
        color: #009ee2;
    }

    .menu-list__li.active > .expandButtonMedio > .fa-angle-right{
        color: #009ee2;
        animation: rotate90 1s forwards;
    }

    .menu-list__li:hover{
        color: #009ee2;
        background-color: #f5f5f5;
    }

    .expandButtonMedio:hover > .fa-angle-right{
        animation: jump 1s infinite;
    }

    #lista_archivos_lateral_charge{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 60vh;
    }

    .icon_charge {
        font-size: 3em; /* Tamaño del icono */
        color: #007bff; /* Color del icono */
        animation: rotate 2s linear infinite; /* Inicia la animación de rotación */
    }

    .btn_generar{
        display: flex;
        justify-content: end;
        align-items: center;
    }

    .iframe_caratula{
        width: 100%;
        height: 60vh;
    }

    .iframe_caratula_chargue{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 60vh;
    }

    @keyframes jump {
        0% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
        100% {
            transform: translateY(0);
        }
    }

    @keyframes rotate90 {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(90deg);
        }
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg); /* Empieza la rotación desde 0 grados */
        }
        to {
            transform: rotate(360deg); /* Termina la rotación en 360 grados */
        }
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Imprimir Caratulas de Archivo</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="card" style="min-height: 80vh;">
            <div class="card-body">
                <div class="row row-sm">
                    <div class="col-xs-4 col-lg-3">
                        <input type="hidden" id="id_bodega" value="{{$bodega->id}}">
                        <input type="hidden" name="csrf_token" value="{{csrf_token()}}" id="csrf_token">
                        <div class="alert alert-primary text-center" id="bodega_badge" role="alert">
                            <i class="fa fa-home"></i> {{$bodega->archivo}}
                        </div>
                        <div id="lista_archivos_lateral" style="display: none;">
                            <ul class="menu-list" data-id_padre="0">
                            </ul>
                        </div>
                        <div id="lista_archivos_lateral_charge">
                            <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-xs-8 col-lg-9">
                        <div class="row">
                            <div class="col-xs-12 col-md-9">
                                <div class="form-group">
                                    <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                        Tipo de Carátula
                                    </label>
                                    <select name="caratula" id="tipo_caratura" class="form-control">
                                        <option value="2">Bandejas</option>
                                        <option value="0">Cajas(Media Página)</option>
                                        <option value="1">Carpetas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-3 btn_generar">
                                <div>
                                    <button class="btn btn-success-gradient btn-movi" id="btn_generar_caratula" type="button"><i class="fa fa-save"></i> Generar</button>
                                </div>
                            </div>
                        </div>
                        <div id="iframe_generate_caratula_charge" class="iframe_caratula_chargue" style="display: none;">
                            <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
                        </div>
                        <iframe id="iframe_generate_caratula" class="iframe_caratula" src="" frameborder="0" style="display: none;"></iframe>
                    </div>
                </div>
            </div>
        </div> 
    </div>
<!-- End Row -->
</div>
<!-- Container closed -->
@endsection

@section('js')
<script type='text/javascript' src='/js/archivo/imprimirCaratula.js'></script>
@endsection