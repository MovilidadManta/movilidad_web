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
                    <h2 class="content-title mb-0 my-auto color-titulo">Placas Provisionales</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mg-t-10">
                                    <input class="form-control mayuscula" name="data_api" id="data_api"
                                        placeholder="Ingresar placa" type="hidden">
                                    <strong>Placa</strong>
                                    <input class="form-control mayuscula" name="txt-placa" id="txt-placa"
                                        placeholder="Ingresar placa" type="text">
                                </div>
                                <div class="col-md-4 mg-t-10 mg-lg-t-0 marg-a">
                                    <a class="btn background-btn-nuevo pad-nu" id="btn-consultar-p"
                                        onclick="get_vehiculo()">
                                        <i class="fa fa-save color-btn-nuevo"></i>
                                        <strong class="color-btn-nuevo">Generar</strong>
                                    </a>
                                </div>

                                <div class="col-md-12 mg-t-20">
                                    <div class="row">
                                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"
                                            id="div-table-placa-provisional">

                                        </div>
                                        <!--<div class="col-md-12 mg-t-10 mg-lg-t-0 marg-a" align="right">
                                            <a class="btn background-btn-nuevo pad-nu" id="btn-consultar-p"
                                                onclick="imprimir_placa_provisional()">
                                                <i class="fa fa-search color-btn-nuevo"></i>
                                                <strong class="color-btn-nuevo">Generar</strong>
                                            </a>
                                        </div>-->
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

@endsection

@section("js")
<script type="text/javascript" src="/js/Placa/placa.js?v=20251027"></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif