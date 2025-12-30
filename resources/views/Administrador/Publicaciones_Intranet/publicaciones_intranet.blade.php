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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestion Slider</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-slider">
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
                                <div id="div-table-slider"></div>
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

<!-- INICIO MODAL AÑADIR SLIDER INDEX -->
<div class="modal" id="modal-slider">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Agregar Slider</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-slider" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="row-sm card-body">
                                <div class="col-lg">
                                    <strong>Foto</strong>
                                    <strong> (La foto debera tener una dimension de 1535 X 512 PX) </strong>
                                    <input type="file" class="dropify" name="txt-file-foto" id="txt-file-foto"
                                        data-max-file-size="3M" />
                                </div>
                            </div>

                            <div class="row row-sm">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <strong>Tipo</strong>
                                        <select name="select-tipo" id="select-tipo" class="form-control">
                                            <option value="0">Seleccione tipo</option>
                                            <option value="MOV">DMT</option>
                                            <option value="TER">TTM</option>
                                            <option value="INT">INTRANET</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group">
                                        <strong>Estado</strong>
                                        <select name="select-estado" id="select-estado" class="form-control">
                                            <option value="0">Seleccione Estado</option>
                                            <option value="A">Activo</option>
                                            <option value="I">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row-sm">
                                <div class="col-lg mg-t-10 mg-lg-t-0">
                                    <strong>Titulo</strong>
                                    <textarea class="form-control" id="txt-titulo" name="txt-titulo" rows="2"
                                        placeholder="Ingresar Titulo"></textarea>
                                </div>
                            </div>

                            <div class="row-sm ">
                                <div class="col-lg mg-t-10">
                                    <strong>Descripción</strong>
                                    <textarea class="form-control" id="txt-descripcion" name="txt-descripcion" rows="6"
                                        placeholder="Ingresar Descripción"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-slider" type="button"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR SLIDER INDEX -->

<!-- INICIO MODAL MODIFICAR SLIDER DE INDEX -->
<div class="modal" id="modal-modificar-slider">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Modificar Slider</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-slider-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-modificar-slider" id="txt-id-modificar-slider">
                    <input type="hidden" name="txt-ruta-anterior-m" id="txt-ruta-anterior-m">
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="row-sm card-body">
                                <div class="col-lg">
                                    <strong>Foto</strong>
                                    <strong> (La foto debera tener una dimension de 1535 X 512 PX) </strong>
                                    <input type="file" class="dropify" name="txt-file-foto-m" id="txt-file-foto-m"
                                        data-max-file-size="3M" />
                                </div>
                            </div>

                            <div class="row row-sm">
                                <div class="col-lg">
                                    <div class="form-group">
                                        <strong>Tipo</strong>
                                        <select name="select-tipo-m" id="select-tipo-m" class="form-control">
                                            <option value="0">Seleccione tipo</option>
                                            <option value="MOV">DMT</option>
                                            <option value="TER">TTM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group">
                                        <strong>Estado</strong>
                                        <select name="select-estado-m" id="select-estado-m" class="form-control">
                                            <option value="0">Seleccione Estado</option>
                                            <option value="A">Activo</option>
                                            <option value="I">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row-sm">
                                <div class="col-lg mg-t-10 mg-lg-t-0">
                                    <strong>Titulo</strong>
                                    <textarea class="form-control" id="txt-titulo-m" name="txt-titulo-m" rows="2"
                                        placeholder="Ingresar Titulo"></textarea>
                                </div>
                            </div>

                            <div class="row-sm card-body">
                                <div class="col-lg">
                                    <strong>Descripción</strong>
                                    <textarea class="form-control" id="txt-descripcion-m" name="txt-descripcion-m"
                                        rows="6" placeholder="Ingresar Descripción"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-slider" type="button"><i
                        class="fa fa-edit"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR SLIDER DE INDEX -->

<!--INICIO MODAL ELIMINAR SLIDER DE INDEX -->
<div class="modal show" id="modal-slider-e" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-slider-e" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-slider-e" name="txt-id-slider-e">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i
                        class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar Slider</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal"
                        type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-slider" type="button"><i
                            class="fa fa-save"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR SLIDER DE INDEX -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Publicaciones_intranet/publicaciones_intranet.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif