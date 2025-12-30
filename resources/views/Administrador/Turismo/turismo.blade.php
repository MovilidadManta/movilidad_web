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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestion de Turismo</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-turismo">
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
                                <div id="div-table-turismo"></div>
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

<!-- INICIO MODAL AÑADIR TURISMO -->
<div class="modal" id="modal-turismo">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar Turismo</h1><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-turismo" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Foto</strong>
                            <strong> (La foto deberá tener una dimensión de 1535 X 512 px) </strong>
                            <input type="file" class="dropify" name="txt-file-foto" id="txt-file-foto" data-max-file-size="3M" />
                        </div>

                        <div class="col-md-4 mg-t-10">
                            <strong>Tipo</strong>
                            <select name="select-tipo" id="select-tipo" class="form-control">
                                <option value="0">Seleccione Tipo</option>
                                <option value="T">Turismo</option>
                                <option value="C">Centro Comercial</option>
                            </select>
                        </div>

                        <div class="col-md-4 mg-t-10">
                            <strong>Categoría</strong>
                            <select name="select-categoria" id="select-categoria" class="form-control">
                                <option value="0">Seleccione Categoría</option>
                            </select>
                        </div>

                        <div class="col-md-4 mg-t-10">
                            <strong>Estado</strong>
                            <select name="select-estado" id="select-estado" class="form-control">
                                <option value="0">Seleccione Estado</option>
                                <option value="A">Activo</option>
                                <option value="I">Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Nombre</strong>
                            <input class="form-control" name="txt-titulo" id="txt-titulo" placeholder="Ingresar titulo" type="text">
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Descripción</strong>
                            <textarea rows="3" class="form-control" name="txt-descripcion" id="txt-descripcion" placeholder="Ingresar descripción del titulo" type="text"></textarea>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-turismo" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR TURISMO -->

<!--INICIO MODAL ELIMINAR TURISMO -->
<div class="modal show" id="modal-turismo-e" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-turismo-e" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-turismo" name="txt-id-turismo">
                    <input type="hidden" name="txt-foto-anterior-e" id="txt-foto-anterior-e">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar turismo</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-turismo" type="button"><i class="fa fa-delete"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR TURISMO -->

<!-- INICIO MODAL MODIFICAR TURISMO -->
<div class="modal" id="modal-turismo-m">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Modificar Turismo</h1><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-turismo-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-turismo-m" id="txt-id-turismo-m">
                    <input type="hidden" name="txt-foto-anterior" id="txt-foto-anterior">
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Foto</strong>
                            <strong> (La foto debera tener una dimension de 1535 X 512 PX) </strong>
                            <input type="file" class="dropify" name="txt-file-foto-m" id="txt-file-foto-m" data-max-file-size="3M" />
                        </div>

                        <div class="col-md-4 mg-t-10">
                            <strong>Tipo</strong>
                            <select name="select-tipo-m" id="select-tipo-m" class="form-control">
                                <option value="0">Seleccione Tipo</option>
                                <option value="T">Turismo</option>
                                <option value="C">Centro Comercial</option>
                            </select>
                        </div>

                        <div class="col-md-4 mg-t-10">
                            <strong>Categoria</strong>
                            <select name="select-categoria-m" id="select-categoria-m" class="form-control">
                                <option value="0">Seleccione Categoria</option>
                            </select>
                        </div>

                        <div class="col-md-4 mg-t-10">
                            <strong>Estado</strong>
                            <select name="select-estado-m" id="select-estado-m" class="form-control">
                                <option value="0">Seleccione Estado</option>
                                <option value="A">Activo</option>
                                <option value="I">Inactivo</option>
                            </select>
                        </div>


                        <div class="col-md-12 mg-t-10">
                            <strong>Nombre</strong>
                            <input class="form-control" name="txt-titulo-m" id="txt-titulo-m" placeholder="Ingresar titulo de la turismo" type="text">
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Descripción</strong>
                            <textarea rows="3" class="form-control" name="txt-descripcion-m" id="txt-descripcion-m" placeholder="Ingresar nombre de abreviatura" type="text"></textarea>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-turismo" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR TURISMO -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Turismo/turismo.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif