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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestion de Archivo</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-proceso">
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
                                <div id="div-table-proceso"></div>
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

<!-- INICIO MODAL AÑADIR proceso -->
<div class="modal" id="modal-proceso">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar proceso</h1><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <input type="hidden"  value="{{Session::get('id_jefatura')}}" id="session_id_jefatura">
                <input type="hidden"  value="{{Session::get('id_departamento')}}" id="session_id_departamento">
                <input type="hidden"  value="{{Session::get('id_empleado')}}" id="session_id_empleado">
                <form class="form" novalidate id="form-proceso" method="POST" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-md-4 mg-t-10">
                            <strong>Numero de Orden</strong>
                            <input class="form-control" name="txt-numero-orden" id="txt-numero-orden" placeholder="Ingresar numero de orden" type="text" onkeypress="mayus(this);">
                        </div>

                        <div class="col-md-4 mg-t-10">
                            <strong>Identificador</strong>
                            <input class="form-control" name="txt-identificacion" id="txt-identificacion" placeholder="Ingresar identificacion" type="text" onkeypress="mayus(this);">
                        </div>


                        <div class="col-md-4 mg-t-10">
                            <strong>Tipo de Proceso</strong>
                            <select name="select-tipo-proceso" id="select-tipo-proceso" class="form-control">
                                <option value="0">SELECCIONE PROCESO</option>
                                @if(Session::get('id_jefatura')==3)
                                <option value="1">REVISIÓN</option>
                                <option value="2">TRASPASO</option>
                                <option value="3">CAMBIO SERVICIO</option>
                                <option value="4">DUPLICADO</option>
                                <option value="5">EMISION DE MATRICULA</option>
                                <option value="6">PRIMERA VEZ</option>

                                <option value="7">ROLES</option>
                                <option value="8">LIQUIDACIÓN</option>
                                <option value="9">INFORMES</option>
                                <option value="10">MEMOS INTERNOS</option>

                                <option value="11">COMPROBANTES INGRESOS</option>
                                <option value="12">COMPROBANTES EGRESOS</option>
                                <option value="13">CRUZE DE CUENTAS</option>
                                <option value="14">DIARIO GARANTIA</option>
                                <option value="15">DIARIO ACTIVO FIJO</option>
                                <option value="16">DIARIO INVENTARIO</option>
                                <option value="17">CONCILIACIONES BANCARIAS</option>
                                <option value="18">FINANZAS</option>

                                <option value="19">ORDENES DE PAGO</option>
                                <option value="20">ORDENES DE CONTABILIZACIÓN</option>
                                <option value="21">ORDENES DE TRABAJO</option>
                                <option value="22">RESOLUCIONES DIRECTORIO</option>
                                <option value="23">OFICIOS INTERNOS</option>
                                
                                @elseif(Session::get('id_jefatura')==6)
                                <option value="1">REVISIÓN</option>
                                <option value="2">TRASPASO</option>
                                <option value="3">CAMBIO SERVICIO</option>
                                <option value="4">DUPLICADO</option>
                                <option value="5">EMISION DE MATRICULA</option>
                                <option value="6">PRIMERA VEZ</option>
                                @elseif(Session::get('id_jefatura')==13)
                                <option value="7">ROLES</option>
                                <option value="8">LIQUIDACIÓN</option>
                                <option value="9">INFORMES</option>
                                <option value="10">MEMOS INTERNOS</option>
                                @elseif(Session::get('id_jefatura')==17)
                                <option value="11">COMPROBANTES INGRESOS</option>
                                <option value="12">COMPROBANTES EGRESOS</option>
                                <option value="13">CRUZE DE CUENTAS</option>
                                <option value="14">DIARIO GARANTIA</option>
                                <option value="15">DIARIO ACTIVO FIJO</option>
                                <option value="16">DIARIO INVENTARIO</option>
                                <option value="17">CONCILIACIONES BANCARIAS</option>
                                <option value="18">FINANZAS</option>
                                @elseif(Session::get('id_jefatura')==23)
                                <option value="19">ORDENES DE PAGO</option>
                                <option value="20">ORDENES DE CONTABILIZACIÓN</option>
                                <option value="21">ORDENES DE TRABAJO</option>
                                <option value="22">RESOLUCIONES DIRECTORIO</option>
                                <option value="23">OFICIOS INTERNOS</option>
                                @endif
                            </select>
                        </div>

                        <div class="col-md-6 mg-t-10">
                            <strong>Dirección</strong>
                            <select name="select-direccion" id="select-direccion" class="form-control">
                                <option value="0">SELECCIONE DIRECCIÓN</option>
                            </select>
                        </div>

                        <div class="col-md-6 mg-t-10">
                            <strong>Jefatura</strong>
                            <select name="select-jefatura-subdireccion" id="select-jefatura-subdireccion" class="form-control">
                                <option value="0">SELECCIONE JEFATURA</option>
                            </select>
                        </div>

                        <div class="col-md-8 mg-t-10">
                            <strong>Digitador</strong>
                            <select name="select-digitador" id="select-digitador" class="form-control">
                                <option value="0">SELECCIONE DIGITADOR</option>
                            </select>
                        </div>

                        <div class="col-md-4 mg-t-10">
                            <strong>Fecha</strong>
                            <input class="form-control" name="txt-fecha" id="txt-fecha" placeholder="Ingresar fecha" type="date">
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Descripción</strong>
                            <textarea rows="3" class="form-control" name="txt-descripcion" id="txt-descripcion" placeholder="Ingresar descripción del titulo" type="text" onkeypress="mayus(this);"></textarea>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Archivo</strong>
                            <input type="file" class="dropify" name="txt-file-proceso" id="txt-file-proceso" data-max-file-size="3M" />
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-proceso" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR proceso -->

<!--INICIO MODAL ELIMINAR proceso -->
<div class="modal show" id="modal-proceso-e" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-proceso-e" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-proceso" name="txt-id-proceso">
                    <input type="hidden" name="txt-archivo-anterior-e" id="txt-archivo-anterior-e">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el proceso?</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-proceso" type="button"><i class="fa fa-delete"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR proceso -->

<!-- INICIO MODAL MODIFICAR proceso -->
<div class="modal" id="modal-proceso-m">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Modificar proceso</h1><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-proceso-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-proceso-m" id="txt-id-proceso-m">
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
                                <option value="T">proceso</option>
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
                            <input class="form-control" name="txt-titulo-m" id="txt-titulo-m" placeholder="Ingresar titulo de la proceso" type="text">
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Descripción</strong>
                            <textarea rows="3" class="form-control" name="txt-descripcion-m" id="txt-descripcion-m" placeholder="Ingresar nombre de abreviatura" type="text"></textarea>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-proceso" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR proceso -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Proceso/proceso.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif