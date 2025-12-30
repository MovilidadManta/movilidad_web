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
                                    <strong>Placa</strong>
                                    <input class="form-control mayuscula" name="txt-placa" id="txt-placa"
                                        placeholder="Ingresar placa" type="text">
                                    <input class="form-control mayuscula" name="user" id="user" value="MOVWS"
                                        placeholder="Ingresar placa" type="hidden">
                                    <input class="form-control mayuscula" name="pwd" id="pwd" value="M0vilid@d!"
                                        placeholder="Ingresar placa" type="hidden">
                                    <input class="form-control mayuscula" name="token_api" id="token_api"
                                        placeholder="Ingresar placa" type="hidden">
                                </div>
                                <div class="col-md-4 mg-t-10 mg-lg-t-0 marg-a">
                                    <a class="btn background-btn-nuevo pad-nu" id="btn-consultar-p"
                                        onclick="get_vehiculo_placa()">
                                        <i class="fa fa-search color-btn-nuevo"></i>
                                        <strong class="color-btn-nuevo">Consultar</strong>
                                    </a>
                                </div>

                                <div class="col-md-12 mg-t-20">
                                    <div class="row">
                                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"
                                            id="div-table-placa-provisional">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mg-t-10 mg-lg-t-0 marg-a">
                                    <a class="btn background-btn-nuevo pad-nu" id="btn-consultar-p"
                                        onclick="imprimir_placa_provisional()">
                                        <i class="fa fa-search color-btn-nuevo"></i>
                                        <strong class="color-btn-nuevo">Generar</strong>
                                    </a>
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
<script type="text/javascript" src="/js/Placa/placa.js"></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif