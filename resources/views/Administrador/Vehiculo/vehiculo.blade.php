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
                    <h2 class="content-title mb-0 my-auto color-titulo">Vehiculo</h2>
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
                                        onclick="get_vehiculo()">
                                        <i class="fa fa-search color-btn-nuevo"></i>
                                        <strong class="color-btn-nuevo">Consultar</strong>
                                    </a>
                                </div>

                                <div class="col-md-12 mg-t-20">
                                    <div class="row">
                                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12"
                                            id="div-table-placa-provisional">
                                            <!-- <div class="card">
                                                <div class="card-body">
                                                    <form class="form" novalidate="" id="form-m-empleado" method="POST"
                                                        enctype="multipart/form-data"></form>
                                                    <table id="table-placa-provisional" border="1"
                                                        class="table table-bor">
                                                        <thead class="background-thead pad">
                                                            <tr align="center">
                                                                <th align="center" class="border-bottom-0 color-th pad">
                                                                    Cedula P.</th>
                                                                <th align="center" class="border-bottom-0 color-th pad">
                                                                    propietario</th>
                                                                <th align="center" class="border-bottom-0 color-th pad">
                                                                    Placa</th>
                                                                <th align="center" class="border-bottom-0 color-th pad">
                                                                    Marca</th>
                                                                <th align="center" class="border-bottom-0 color-th pad">
                                                                    Modelo</th>
                                                                <th align="center" class="border-bottom-0 color-th pad">
                                                                    Año de matricula</th>
                                                                <th align="center" class="border-bottom-0 color-th pad">
                                                                    fecha ultima revision</th>
                                                                <th align="center" class="border-bottom-0 color-th pad">
                                                                    Imprimir Placa </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>VIN O
                                                                        Chasis:</strong>
                                                                </td>
                                                                <td width="30%" class="color-td" align="left">Vin</td>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Clase de
                                                                        Transporte
                                                                        Terrestre:</strong>
                                                                </td>
                                                                <td width="30%" class="color-td" align="left">PART
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Marca:</strong>
                                                                </td>
                                                                <td class="color-td" align="left">kia</td>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>SubClase de
                                                                        Transporte Terrestre:</strong>
                                                                </td>
                                                                <td class="color-td" align="left">PART</td>
                                                            </tr>

                                                            <tr>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Modelo:</strong>
                                                                </td>
                                                                <td class="color-td" align="left">Rio</td>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Ambito de
                                                                        Operación:</strong>
                                                                </td>
                                                                <td class="color-td" align="left">NOSE</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Año
                                                                        Fab:</strong>
                                                                </td>
                                                                <td class="color-td" align="left">2020</td>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Tipo de
                                                                        Transporte:</strong>
                                                                </td>
                                                                <td class="color-td" align="left">PART</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="20%" class="color-td" align="left"><strong>
                                                                        Fecha de Matrícula:</strong></td>
                                                                <td class="color-td" align="left">2020-05-05</td>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Clase de
                                                                        Servicio:</strong>
                                                                </td>
                                                                </td>
                                                                <td class="color-td" align="left">PART</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="20%" class="color-td" align="left"><strong>
                                                                        Fecha de Caducidad:</strong></td>
                                                                <td class="color-td" align="left">2020-05-05</td>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Color
                                                                        1:</strong>
                                                                </td>
                                                                </td>
                                                                <td class="color-td" align="left">PART</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="20%" class="color-td" align="left"><strong>
                                                                        Nro de Motor:</strong></td>
                                                                <td class="color-td" align="left">2020-05-05</td>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Indicador de
                                                                        Ortopedico:</strong>
                                                                </td>
                                                                </td>
                                                                <td class="color-td" align="left">PART</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="20%" class="color-td" align="left"><strong>
                                                                        Combustible:</strong></td>
                                                                <td class="color-td" align="left">2020-05-05</td>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Carroceria:</strong>
                                                                </td>
                                                                </td>
                                                                <td class="color-td" align="left">PART</td>
                                                            </tr>

                                                            <tr>
                                                                <td width="20%" class="color-td" align="left"><strong>
                                                                        Tipo de Vehiculo:</strong></td>
                                                                <td class="color-td" align="left">2020-05-05</td>
                                                                <td width="20%" class="color-td" align="left">
                                                                    <strong>Tipo de Peso:</strong>
                                                                </td>
                                                                </td>
                                                                <td class="color-td" align="left">PART</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                    </form>
                                                </div>
                                            </div>-->

                                        </div>
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
<script type="text/javascript" src="/js/Vehiculo/vehiculo.js"></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif