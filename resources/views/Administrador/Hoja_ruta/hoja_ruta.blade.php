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
                    <h2 class="content-title mb-0 my-auto color-titulo">Hoja de Ruta previa a liquidacion de haberes
                    </h2>
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
                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                    <div class="col-md-10 col-lg-8 col-xl-6 mx-auto d-block">
                        <div class="card-body pd-20">
                            <!--<div class="form-group">
                                    <strong>Tipo de busqueda</strong>
                                    <select name="select-tipo-buscar" id="select-tipo-buscar" class="form-control">
                                        <option value="0">Seleccione tipo de busqueda</option>
                                        <option value="1">Cedula</option>
                                        <option value="2">Nombres</option>
                                    </select>
                                </div>-->
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">Cedula/Nombres</label>
                                <div class="pos-relative">
                                    <input class="form-control pd-r-80" required="" type="text" id="txt-buscar"
                                        name="txt-buscar">
                                    <div id="div-busqueda-empleado"></div>
                                </div>
                            </div>
                            <!--<a class="btn background-btn-nuevo pad-nu margin-top-bu btn-movi" id="btn-reporte-empleado">
                                    <i class="fas fa-neuter color-btn-nuevo"></i>
                                    <strong class="color-btn-nuevo">Buscar</strong>
                                </a>-->
                        </div>
                    </div>
                    <div id="div-table-empleado">
                        <div class="card-body">
                            <div id="div-empleado"></div>
                            <!--<div class="main-content-label mg-b-5">
                                                    Basic Style2 Tabs
                                                </div>
                                                
                                                <p class="mg-b-20">It is Very Easy to Customize and it uses in your website apllication.
                                                </p>-->
                            <!--<div class="text-wrap">
                                    <div class="example">
                                        <div class="panel panel-primary tabs-style-2">
                                            <h5 class="card-title mb-3">Información Personal</h5>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td width="15%"><strong>Nombres y Apellidos:</strong></td>
                                                    <td width="35%">YANDRY MOISES NAVARRETE MENDOZA</td>
                                                    <td width="15%"><strong> Cédula:</strong></td>
                                                    <td width="35%">1311718181</td>
                                                </tr>

                                                <tr>
                                                    <td width="15%"><strong> Dirección:</strong></td>
                                                    <td width="35%">FINANCIERA</td>
                                                    <td width="15%"><strong>Jefatura:</strong></td>
                                                    <td width="35%">TECNOLOGÍA</td>

                                                </tr>

                                                <tr>
                                                    <td width="15%"><strong> Cargo:</strong></td>
                                                    <td width="35%">ANALISTA DE TECNOLOGIA 1</td>
                                                    <td width="15%"><strong>Telefono:</strong></td>
                                                    <td width="35%">0986895656</td>
                                                </tr>
                                                <tr>
                                                    <td width="10%"><strong> Fecha de Ingreso:</strong></td>
                                                    <td width="20%">07/07/0185</td>
                                                    <td width="10%" class="align-midle" rowspan="2"><strong>Firma del
                                                            servidor:</strong></td>
                                                    <td width="10%" rowspan="2"><strong></strong></td>
                                                </tr>
                                                <tr>
                                                    <td width="10%"><strong> Fecha de salida:</strong></td>
                                                    <td width="20%">07/07/0185</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>-->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<!-- row -->

<div class="" id="div-table-reporte-empleado">

</div>
<!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->


<div class="modal show" id="modal-subir-acuerdo-responsabilidad-condifencialidad" aria-modal="true" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Subir Acuerdo</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                        <form class="form" novalidate id="form-acuerdo-responsabilidad-confidencialidad" method="POST"
                            enctype="multipart/form-data">
                            <input type="hidden" name="txt-id-empleado" id="txt-id-empleado">
                            <input type="hidden" name="txt-tipo-acuerdo" id="txt-tipo-acuerdo">
                            <input type="file" class="dropify" id="txt-archivo-acuerdo-responsabilidad"
                                name="txt-archivo-acuerdo-responsabilidad" data-max-file-size="3M" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi"
                    id="btn-guardar-acuerdo-responsabilidad-confidencialidad" type="button"><i class="fa fa-save"></i>
                    Guardar</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<!--INICIO MODAL ELIMINAR ACUERDOS-->
<div class="modal show" id="modal-acuerdo-e" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-acuerdo-e" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-empleado-e" id="txt-id-empleado-e">
                    <input type="hidden" name="txt-tipo-acuerdo-e" id="txt-tipo-acuerdo-e">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i
                        class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el acuerdo?</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal"
                        type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-acuerdo" type="button"><i
                            class="fa fa-times-circle"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR ELIMINAR ACUERDOS-->
@endsection

@section('js')
<script type='text/javascript' src='/js/Paz_Salvo/paz_salvo.js'></script>
@endsection

@else
<script>
location.href = "/login";
</script>
@endif