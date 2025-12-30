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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestion de Mensaje de Contacto</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-contactano">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
                    </a>
                </div>

            </div>
        </div>
        <!--<div class="d-flex my-xl-auto right-content">
                <div class="pe-1 mb-xl-0">
                    <button type="button" class="btn btn-info btn-icon me-2 btn-b"><i class="mdi mdi-filter-variant"></i></button>
                </div>
                <div class="pe-1 mb-xl-0">
                    <button type="button" class="btn btn-danger btn-icon me-2"><i class="mdi mdi-star"></i></button>
                </div>
                <div class="pe-1 mb-xl-0">
                    <button type="button" class="btn btn-warning  btn-icon me-2"><i class="mdi mdi-refresh"></i></button>
                </div>
                <div class="mb-xl-0">
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-primary">14 Aug 2019</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuDate" x-placement="bottom-end">
                            <a class="dropdown-item" href="javascript:void(0);">2015</a>
                            <a class="dropdown-item" href="javascript:void(0);">2016</a>
                            <a class="dropdown-item" href="javascript:void(0);">2017</a>
                            <a class="dropdown-item" href="javascript:void(0);">2018</a>
                        </div>
                    </div>
                </div>
            </div>-->

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
                            <div class="table-responsive">
                                <div id="div-table-contactano"></div>
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

<!-- INICIO MODAL AÑADIR CONTACTANOS -->
<div class="modal" id="modal-contactano">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Agregar Mensaje de Contacto</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-contactano" method="POST" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg">
                            <strong>Nombres <span id="va-ced"></span></strong>
                            <input class="form-control" name="txt-nombre" id="txt-nombre" placeholder="Ingresar Nombres" type="text">
                        </div>
                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <strong>Apellidos</strong>
                            <input class="form-control" name="txt-apellido" id="txt-apellido" placeholder="Ingresar Apellidos" type="text" onkeypress="mayus(this);">
                        </div>
                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <strong>Correo</strong>
                            <input class="form-control" name="txt-correo" id="txt-correo" placeholder="Ingresar Correo" type="text" onkeypress="mayus(this);">
                        </div>
                    </div>
                    <div class="row row-sm mg-t-10">
                        <div class="col-lg">
                            <strong>Mensaje <span id="va-ced"></span></strong>
                            <textarea class="form-control" name="txt-mensaje" id="txt-mensaje" placeholder="Ingresar Mensaje" type="text"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-contactano" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR CONTACTANOS -->

<!--INICIO MODAL ELIMINAR CONTACTANOS -->
<div class="modal show" id="modal-eliminar-contactano" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-eliminar-contactano" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-contactano" name="txt-id-contactano">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el Mensaje</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-contactano" type="button"><i class="fa fa-times"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR CONTACTANOS -->

<!-- INICIO MODAL MODIFICAR CONTACTANOS -->
<div class="modal" id="modal-modificar-contactano">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Modificar Mensaje de Contacto</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">


                <form class="form" novalidate id="form-contactano-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-modificar-contactano" id="txt-id-modificar-contactano">
                    <div class="row row-sm">
                        <div class="col-lg">
                            <strong>Nombres <span id="va-ced"></span></strong>
                            <input class="form-control" name="txt-nombre-m" id="txt-nombre-m" placeholder="Ingresar Nombres" type="text">
                        </div>
                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <strong>Apellidos</strong>
                            <input class="form-control" name="txt-apellido-m" id="txt-apellido-m" placeholder="Ingresar Apellidos" type="text" onkeypress="mayus(this);">
                        </div>
                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <strong>Correo</strong>
                            <input class="form-control" name="txt-correo-m" id="txt-correo-m" placeholder="Ingresar Correo" type="text" onkeypress="mayus(this);">
                        </div>
                    </div>
                    <div class="row row-sm mg-t-10">
                        <div class="col-lg">
                            <strong>Mensaje <span id="va-ced"></span></strong>
                            <textarea class="form-control" name="txt-mensaje-m" id="txt-mensaje-m" placeholder="Ingresar Mensaje" type="text"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-contactano" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR CONTACTANOS -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Contactano/admin_contactanos.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif