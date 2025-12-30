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
                    <h2 class="content-title mb-0 my-auto color-titulo">Reporte de Equipos de Computacion</h2>
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
                                <strong>Categoria</strong>
                            </div>
                            <div align='left' class="col-4">
                            <select name="select-categoria" id="select-categoria" class="form-control">
                                <option value="0">TODOS</option>
                                <option value="1">LAPTOP</option>
                                <option value="2">IMPRESORA</option>
                                <option value="3">MOUSE</option>
                                <option value="4">ROUTER</option>
                                <option value="5">TECLADO</option>
                                <option value="6">MONITOR</option>
                                <option value="7">CONVERTIDOR</option>
                                <option value="8">UPS</option>
                                <option value="9">REGULADOR</option>
                                <option value="10">TV</option>
                                <option value="11">SWICH O CONMUTADOR</option>
                                <option value="12">SERVIDOR</option>
                                <option value="13">ACCES POINTS</option>
                                <option value="14">DISCO DURO</option>
                                <option value="15">MEMORIA RAM</option>
                                <option value="16">FUENTE</option>
                                <option value="17">CPU</option>
                                <option value="18">PARLANTES</option>
                                <option value="19">SCANNER</option>
                                <option value="20">SERVIDOR</option>
                                <option value="21">LECTOR DE HUELLA</option>
                                <option value="22">BIOMETRICO</option>
                                <option value="23">TELEFONO IP</option>
                                <option value="24">TODO EN UNO</option>
                            </select>
                            </div>
                        </div>

                        <div class="row justify-content-center mg-t-10">
                            <div align='center' class="col-1">
                                <strong>Area</strong>
                            </div>
                            <div align='left' class="col-4">
                            <select name="select-area" id="select-area" class="form-control">
                                <option value="0">TODOS</option>
                                <option value="1">TRANSITO</option>
                                <option value="2">TTM</option>
                                <option value="3">CENTRO DE MONITOREO</option>
                            </select>
                            </div>
                        </div>

                        <div class="row justify-content-center mg-t-10">
                            <div align='center' class="col-1">
                                <strong>Estado</strong>
                            </div>
                            <div align='left' class="col-4">
                            <select name="select-estado" id="select-estado" class="form-control">
                                <option value="0">TODOS</option>
                                <option value="1">MALO</option>
                                <option value="2">REGULAR</option>
                                <option value="3">BUENO</option>
                                <option value="4">DAR DE BAJA</option>
                            </select>
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
                        <div class="" id="div-table-reporte-catalogo"></div>
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
<script type='text/javascript' src='/js/Catalogo/reporte_catalogo.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif