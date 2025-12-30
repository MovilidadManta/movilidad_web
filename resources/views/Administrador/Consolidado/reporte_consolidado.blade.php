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
                    <h2 class="content-title mb-0 my-auto color-titulo">Reporte Consolidado</h2>
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
                        <div class="row row-sm">
                            <div class="col-lg">
                                <strong>Fecha Inicio</strong>
                                <input class="form-control" name="select-fecha-inicio" id="select-fecha-inicio" placeholder="Ingresar cedula" type="date">
                            </div>
                            <div class="col-lg mg-t-10 mg-lg-t-0">
                                <strong>Fecha Fin</strong>
                                <input class="form-control" name="select-fecha-fin" id="select-fecha-fin" placeholder="Ingresar Nombre" type="date">
                            </div>
                            <div class="col-lg mg-t-10 mg-lg-t-0">
                                <a class="btn background-btn-nuevo pad-nu margin-top-bu" id="btn-reporte-empleado">
                                    <i class="fa fa-plus-square color-btn-nuevo"></i>
                                    <strong class="color-btn-nuevo">Buscar</strong>
                                </a>
                            </div>
                        </div>
                    </form>
                    <br><br>
                    <!--<table border="2" class="table table-bordered">
                        <tr>
                            <th>2022-JUNIO</th>
                        </tr>
                    </table>
                    
                    <table border="2" class="table table-bordered">
                        <tr>
                            <th rowspan="4" width="15%" class="midle">OPERATIVIDAD</th>
                        </tr>
                        <tr>
                            <td class="pad-td">
                                <table border="0" cellpadding="1" class="table table-bordered mar-bot">
                                    <tr>
                                        <th rowspan="4" width="50%" class="midle">PROMEDIO DE USUARIOS POR DIA QUE USAN TASA DE TORNIQUETE</th>
                                    </tr>
                                    <tr>
                                        <td width="30%">INTRAPROVINCIAL</td>
                                        <td width="10%">02 JUNIO</td>
                                        <td width="10%">14615</td>
                                    </tr>
                                    <tr>
                                        <td width="30%">INTERPROVINCIAL</td>
                                        <td width="10%">02-JUNIO</td>
                                        <td width="10%">20879</td>
                                    </tr>
                                    <tr>
                                        <td width="30%">ALTOS FLUJOS</td>
                                        <td width="10%">02-JUNIO</td>
                                        <td width="10%">6263</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="pad-td">
                                <table border="0" cellpadding="1" class="table table-bordered mar-bot">
                                    <tr>
                                        <th rowspan="4" class="midle" width="50%">USUARIOS QUE ACUDEN AL CENTRO COMERCIAL</th>
                                    </tr>
                                    <tr>
                                        <td width="30%">CENTRO COMERCIAL</td>
                                        <td width="10%">02-JUNIO</td>
                                        <td width="10%">70570</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="pad-td">
                                <table border="0" cellpadding="1" class="table table-bordered mar-bot">
                                    <tr>
                                        <th rowspan="4" class="midle" width="50%">FRECUENCIA DE BUSES</th>
                                    </tr>
                                    <tr>
                                        <td width="30%">NORMALES</td>
                                        <td width="10%">02-JUNIO</td>
                                        <td width="10%">4832</td>
                                    </tr>
                                    <tr>
                                        <td width="30%">EXTRAS PROGRAMADAS</td>
                                        <td width="10%">02-JUNIO</td>
                                        <td width="10%">0</td>
                                    </tr>
                                    <tr>
                                        <td width="30%">EXTRAS NO PROGRAMADAS</td>
                                        <td width="10%">02-JUNIO</td>
                                        <td width="10%">13</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>-->
                </div>
            </div>
        </div>

    </div>
    <!--/div-->
    <!-- row -->

    <div class="" id="div-table-reporte-consolidado">

    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Consolidado/reporte_consolidado.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif