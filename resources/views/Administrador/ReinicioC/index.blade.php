@extends('Administrador.Layout.app')

@section('css')
@endsection
@section('content')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hola, bienvenido al Sistema de Gestión Interno de la Empresa Pública Municipal Movilidad de Manta-EP.</h2>
        </div>
    </div>

</div>
<div class="row row-sm">
    <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
        <div class="card  box-shadow-0">
            <div class="card-header">
                <h4 class="card-title mb-1">Reinicio de contraseña</h4>
                <p class="mb-2">El cambio de contraseña es bajo su responsabilidad.</p>
            </div>
            <div class="card-body pt-0">
                <form class="form-horizontal">
                    <div class="form-group">
                        <input type="password" class="form-control" id="ip_pass" placeholder="Contraseña actual">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="ip_newpass" placeholder="Nueva Contraseña">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="ip_conpass" placeholder="Confirmar Contraseña">
                    </div>

                    <div class="form-group mb-0 mt-3 justify-content-end">
                        <div>
                            <button type="button" id="btn_cambiar" class="btn btn-primary">Cambiar</button>
                            <a href="/home" class="btn btn-secondary ms-4">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('/js/Login/reset.js')}}"></script>
@endsection