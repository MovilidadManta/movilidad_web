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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestion de Inventario</h2>
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
                <div class="card-body">
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
                    <div class="col-md-12">
                        <div class="card-body pd-10">
                            <div class="form-group">
                                <div id="div-table-empleado">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card-body pd-10">
                            <div class="form-group">
                                <div id="div-table-empleado-catalogo">

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


<div class="modal show" id="modal-catalogo" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg width-mo" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Lista del Catalogo</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form class="form" novalidate id="form-catalogo-inventario" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-empleado" id="txt-id-empleado">
                    <input type="hidden" name="txt-id-catalogo" id="txt-id-catalogo">
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
                                                <div id="div-table-catalogo"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--/div-->
                    </div>
                    <!-- row closed -->
                </form>
            </div>
            <!--<div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-acuerdo-responsabilidad-confidencialidad" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>-->
        </div>
    </div>
</div>


<!--INICIO MODAL ELIMINAR CATALOGO  INVENTARIO-->
<div class="modal show" id="modal-catalogo-inventario-e" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-catalogo-inventario-e" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-catalogo-inventario-e" name="txt-id-catalogo-inventario-e">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i
                        class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el catalogo inventario</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal"
                        type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-catalogo-inventario" type="button"><i
                            class="fa fa-times-circle"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR CATALOGO INVENTARIO -->

<!--INICIO MODAL ELIMINAR CATALOGO INVENTARIO -->
<div class="modal" id="modal-mensaje-asignacion" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h2>Equipo ya tiene custodio asignado</h2>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
        <button type="button" id="btn-cerrar" class="btn btn-secondary" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
<!--FIN MODAL ELIMINAR CATALOGO INVENTARIO -->

<!--INICIO MODAL ELIMINAR CATALOGO INVENTARIO -->
<div class="modal" id="modal-mensaje-custodio" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h2>Equipo agregado correctamente a un custodio</h2>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
        <button type="button" id="btn-cerrar-g" class="btn btn-secondary" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
<!--FIN MODAL ELIMINAR CATALOGO INVENTARIO -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Inventario/inventario.js'></script>
@endsection

@else
<script>
location.href = "/login";
</script>
@endif