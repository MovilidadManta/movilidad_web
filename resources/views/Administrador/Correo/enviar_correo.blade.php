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
                    <h2 class="content-title mb-0 my-auto color-titulo">Correo Masivo</h2>
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
                    <form class="form" novalidate id="form-m-empleado" method="POST" enctype="multipart/form-data">
                        <div class="row row-sm card-body">
                            <div class="col-md-4">
                                <strong>Dirección</strong>
                                <select name="select-direccion" id="select-direccion"
                                    class="form-control form-select select2">
                                    <option value="0">SELECCIONE DIRECCIÓN</option>
                                </select>
                            </div>

                            <div class="col-md-4 mg-t-10 mg-lg-t-0">
                                <strong>Jefatura/SubDirección</strong>
                                <select name="select-jefatura-subdireccion" id="select-jefatura-subdireccion"
                                    class="form-control">
                                    <option value="0">SELECCIONE JEFATURA</option>
                                </select>
                            </div>

                            <div class="col-md-4 mg-t-10 mg-lg-t-0">
                                <strong>Regimen Contractual</strong>
                                <select name="select-regimen-contrato" id="select-regimen-contrato"
                                    class="form-control">
                                    <option value="0">TODOS</option>
                                    <option value="1">CODIGO DE TRABAJO</option>
                                    <option value="2">LOEP</option>
                                    <option value="3">LOSEP</option>
                                    <option value="4">PROFESIONAL</option>
                                </select>
                            </div>

                            <div class="col-md-12 mg-t-20">
                                <strong>Mensaje</strong>
                                <textarea class="form-control" name="txt-mensaje" id="txt-mensaje"
                                    placeholder="Ingresar observación" rows="10" ></textarea>
                            </div>
                        </div>

                        <div class="col-md-12 cen ubica" align="right">
                            <button class="btn btn-primary btn btn-success-gradient btn-movi" id="btn-enviar-correo"
                                type="button"><i class="fa fa-paper-plane"></i> Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--div-->
    </div>
</div>
@endsection

@section('js')
<script type='text/javascript' src='/js/Correo/correo.js'></script>
@endsection

@else
<script>
location.href = "/login";
</script>
@endif