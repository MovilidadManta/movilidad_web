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
                    <h2 class="content-title mb-0 my-auto color-titulo">Literales LOTAIP</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-nuevo-literal-lotaip">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo"> Nuevo</strong>
                    </a>
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
                        <!--<div class="card-header">
									<h3 class="card-title"></h3>
								</div>-->
                        <div class="card-body">
                            <div class="">
                                <div id="div-table-lotaip">
                                    <form class="form" novalidate id="form-literal-lotaip" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                                        <input type="hidden" name="txt-id-lotaip" id="txt-id-lotaip" value="{{$id}}">
                                        <input type="hidden" name="txt-id-literal-rendicion-cuenta-e" id="txt-id-literal-rendicion-cuenta-e">
                                        <input type="hidden" name="ip_id_lotaip_datelle" id="ip_id_lotaip_datelle">
                                        <div class="row row-sm card-body">
                                            <div class="col-lg">
                                                <strong>Literal</strong>
                                                <select name="select-literal-lotaip" id="select-literal-lotaip" class="form-control form-select select2">
                                                    <option value="0">SELECCIONE LITERAL</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row row-sm card-body">
                                            <div class="col-lg">
                                                <strong>Mes</strong>
                                                <select name="select-mes" id="select-mes" class="form-control">
                                                    <option value="0">SELECCIONE MES</option>
                                                    <option value="1">ENERO</option>
                                                    <option value="2">FEBRERO</option>
                                                    <option value="3">MARZO</option>
                                                    <option value="4">ABRIL</option>
                                                    <option value="5">MAYO</option>
                                                    <option value="6">JUNIO</option>
                                                    <option value="7">JULIO</option>
                                                    <option value="8">AGOSTO</option>
                                                    <option value="9">SEPTIEMBRE</option>
                                                    <option value="10">OCTUBRE</option>
                                                    <option value="11">NOVIEMBRE</option>
                                                    <option value="12">DICIEMBRE</option>
                                                </select>
                                            </div>
                                            <div class="col-lg mg-t-10 mg-lg-t-0">
                                                <strong>Archivo</strong>
                                                <input class="dropify" type="file" name="txt-ruta-archivo" id="txt-ruta-archivo" data-max-file-size="3M">
                                            </div>
                                            <div class="col-lg mg-t-10 mg-lg-t-0 marg-a">
                                                <a class="btn background-btn-nuevo pad-nu " id="btn-añadir-literal-lotaip">
                                                    <i class="fa fa-plus-square color-btn-nuevo"></i>
                                                    <strong class="color-btn-nuevo"> Añadir</strong>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="div-table-detalle-lotaip">
                                            <!--<table id="table-empleado" border="2" class="table">
                                                <thead class="background-thead">
                                                    <tr align="center">
                                                        <th align="center" class="border-bottom-0 color-th pad">Mes</th>
                                                        <th align="center" class="border-bottom-0 color-th pad">archivo</th>
                                                        <th align="center" class="border-bottom-0 color-th pad">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-table-detalle-lotaip">

                                                </tbody>
                                            </table>-->
                                        </div>
                                        <!--<div class="row row-sm">
                        <div class="col-lg">
                            <strong>Año</strong>
                            <select class="form-control" id="select-ano" name="select-ano" placeholder="" >
                                <option value="0">Seleccione año</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>-->
                                    </form>
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
<!--INICIO MODAL ELIMINAR LITERAL DE LOTAIP -->
<div class="modal show" id="modal-eliminar-literal-lotaip" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-eliminar-literal-lotaip" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-literal-lotaip-e" name="txt-id-literal-lotaip-e">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                    <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el literal de LOTAIP</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-literal-lotaip" type="button">
                        <i class="fa fa-times-circle"></i>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR ELIMINAR LITERAL DE LOTAIP -->
@endsection

@section('js')
<script type="text/javascript" src="/js/Lotaip/registrar_lotaip.js"></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif