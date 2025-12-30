@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.41.0/mapbox-gl.css' rel='stylesheet' />
<link href="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.css" rel="stylesheet">
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
                    <h1 class="content-title mb-0 my-auto color-titulo">Organigrama</h1>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-organigrama">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
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
                            <div class="table-responsive">
                                <div id="div-table-organigrama"></div>
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

<!-- INICIO MODAL AÑADIR organigramaS -->
<div class="modal" id="modal-organigrama">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar Estructura Organica</h1><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-organigrama" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 mg-t-10">
                            <strong>Dirección</strong>
                            <select name="select-direccion" id="select-direccion" class="form-control form-select select2">
                                <option value="0">SELECCIONE DIRECCIÓN</option>
                            </select>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Jefatura/SubDirección</strong>
                            <select name="select-jefatura-subdireccion" id="select-jefatura-subdireccion" class="form-control">
                                <option value="0">SELECCIONE JEFATURA</option>
                            </select>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Cargo</strong>
                            <select name="select-cargo" id="select-cargo" class="form-control">
                                <option value="0">SELECCIONE CARGO</option>
                            </select>
                        </div>


                        <div class="col-md-9 mg-t-10">
                            <strong>Nivel</strong>
                            <select name="select-nivel" id="select-nivel" class="form-control">
                                <option value="0">SELECCIONE NIVEL</option>
                                <option value="1">Nivel 1</option>
                                <option value="2">Nivel 2</option>
                                <option value="3">Nivel 3</option>
                                <option value="4">Nivel 4</option>
                            </select>
                        </div>

                        <div class="col-md-3 mg-t-10">
                            <strong>Estado</strong>
                            <select name="select-estado" id="select-estado" class="form-control">
                                <option value="0">Seleccione Estado</option>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Descripción</strong>
                            <input class="form-control" name="txt-descripcion" id="txt-descripcion" placeholder="Ingresar Descripción" type="text" style="text-transform: uppercase;">
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-organigrama" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR organigramaS -->

<!--INICIO MODAL ELIMINAR organigramaS -->
<div class="modal show" id="modal-organigrama-e" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-organigrama-e" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-organigrama" name="txt-id-organigrama">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar la Cargo</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-organigrama" onclick="eliminar_organigramas_id()" type="button"><i class="fa fa-delete"></i>
                        Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR organigramaS -->

<!-- INICIO MODAL MODIFICAR organigramaS -->
<div class="modal" id="modal-organigrama-m">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Modificar organigramas</h1><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-organigrama-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-organigrama-m" name="txt-id-organigrama-m">
                    <div class="row">
                        <div class="col-md-12 mg-t-10">
                            <strong>Dirección</strong>
                            <select name="select-direccion-m" id="select-direccion-m" class="form-control form-select select2">
                                <option value="0">Seleccione Dirección</option>
                            </select>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Jefatura/SubDirección</strong>
                            <select name="select-jefatura-subdireccion-m" id="select-jefatura-subdireccion-m" class="form-control">
                                <option value="0">Seleccione Jefaturas</option>
                            </select>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Cargo</strong>
                            <select name="select-cargo-m" id="select-cargo-m" class="form-control">
                                <option value="0">Seleccione cargo</option>
                            </select>
                        </div>


                        <div class="col-md-9 mg-t-10">
                            <strong>Nivel</strong>
                            <select name="select-nivel-m" id="select-nivel-m" class="form-control">
                                <option value="0">Seleccione nivel</option>
                                <option value="1">Nivel 1</option>
                                <option value="2">Nivel 2</option>
                                <option value="3">Nivel 3</option>
                                <option value="4">Nivel 4</option>
                            </select>
                        </div>

                        <div class="col-md-3 mg-t-10">
                            <strong>Estado</strong>
                            <select name="select-estado-m" id="select-estado-m" class="form-control">
                                <option value="0">Seleccione Estado</option>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Descripción</strong>
                            <input class="form-control" name="txt-descripcion-m" id="txt-descripcion-m" placeholder="Ingresar Descripción" type="text" style="text-transform: uppercase;">
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-organigrama" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR organigramaS -->

@endsection

@section('js')
<!-- Mapa box-->
<script src="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.js"></script>
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.41.0/mapbox-gl.js'></script>
<script type='text/javascript' src='/js/Organigrama/organigrama.js'></script>

@endsection

@else
<script>
    location.href = "/login";
</script>
@endif