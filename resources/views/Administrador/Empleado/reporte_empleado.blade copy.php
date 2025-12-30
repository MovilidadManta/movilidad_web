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
                    <h2 class="content-title mb-0 my-auto color-titulo">Reporte de Nomina de Empleado</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <!--<div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-empleado">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
                    </a>
                </div>-->

            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="card">
                <!--<div class="card-header">
									<h3 class="card-title"></h3>
								</div>-->
                <div class="card-body">
                    <form class="form" novalidate id="form-m-empleado" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div align='center' class="col-1 mg-t-10">
                                <strong>Dirección</strong>
                            </div>
                            <div align='left' class="col-4">
                                <select name="select-direccion" id="select-direccion" class="form-control form-select select2">
                                    <option value="0">TODOS</option>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center mg-t-10">
                            <div align='center' class="col-1">
                                <strong>Jefatura/SubDirección</strong>
                            </div>
                            <div align='left' class="col-4">
                                <select name="select-jefatura-subdireccion" id="select-jefatura-subdireccion" class="form-control">
                                    <option value="0">TODOS</option>
                                </select>
                            </div>
                        </div>

                        <div class="row justify-content-center ">
                            <div align='center' class="col-1 mg-t-10">
                                <strong>Fecha Inicio</strong>
                            </div>
                            <div align='left' class="col-4">
                                <input class="form-control" name="select-fecha-inicio" id="select-fecha-inicio" placeholder="Ingresar cedula" type="date">
                            </div>
                        </div>

                        <div class="row justify-content-center mg-t-10">
                            <div align='center' class="col-1 mg-t-10">
                                <strong>Fecha Fin</strong>
                            </div>
                            <div align='left' class="col-4">
                                <input class="form-control" name="select-fecha-fin" id="select-fecha-fin" placeholder="Ingresar Nombre" type="date">
                            </div>
                        </div>

                        <div class="row justify-content-center mg-t-10">
                            <div align='center' class="col-1 mg-t-10">
                                <strong></strong>
                            </div>
                            <div align='right' class="col-4">
                                <a class="btn background-btn-nuevo pad-nu margin-top-bu" id="btn-reporte-empleado">
                                    <i class="fa fa-plus-square color-btn-nuevo"></i>
                                    <strong class="color-btn-nuevo">Buscar</strong>
                                </a>
                            </div>
                        </div>


                        <!--<div class="col-md-10 col-lg-8 col-xl-6 mx-auto d-block">
                            <div class="card-body pd-20">
                                <div class="form-group">
                                    <strong>Dirección</strong>
                                    <select name="select-direccion" id="select-direccion" class="form-control form-select select2">
                                        <option value="0">TODOS</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <strong>Jefatura/SubDirección</strong>
                                    <select name="select-jefatura-subdireccion" id="select-jefatura-subdireccion" class="form-control">
                                        <option value="0">TODOS</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <strong>Fecha Inicio</strong>
                                    <input class="form-control" name="select-fecha-inicio" id="select-fecha-inicio" placeholder="Ingresar cedula" type="date">
                                </div>
                                <div class="form-group">
                                    <strong>Fecha Fin</strong>
                                    <input class="form-control" name="select-fecha-fin" id="select-fecha-fin" placeholder="Ingresar Nombre" type="date">
                                    <a class="btn background-btn-nuevo pad-nu margin-top-bu" id="btn-reporte-empleado">
                                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                                        <strong class="color-btn-nuevo">Buscar</strong>
                                    </a>
                                </div>-->

                                <!--<a class="btn background-btn-nuevo pad-nu margin-top-bu btn-movi" id="btn-reporte-empleado">
                                    <i class="fas fa-neuter color-btn-nuevo"></i>
                                    <strong class="color-btn-nuevo">Buscar</strong>
                                </a>-->
                            </div>
                        </div>
                        <div class="" id="div-table-reporte-empleado"></div>
                    </form>
                </div>
            </div>
            <!--div-->
        </div>
    </div>
    <!--/div-->
    <!-- row -->

    
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Empleado/reporte_empleado.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif