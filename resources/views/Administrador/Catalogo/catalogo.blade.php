@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')

@endsection

@section('content')

<!-- container -->
<div class="main-container">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto col-md-12">
            <div class="d-flex">
                <div class="col-md-6">
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestión de Catalogo</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-catalogo">
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
</div>
<!-- Container closed -->

<!-- INICIO MODAL AÃ‘ADIR CATALOGO-->
<div class="modal" id="modal-catalogo">
    <div class="modal-dialog modal-lg width-mo" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Agregar Catalogo</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-catalogo" method="POST" enctype="multipart/form-data">
                    <div class="row ">
                        <div class="col-md-3 mg-t-10">
                            <strong>Codigo</strong>
                            <input class="form-control" name="txt-codigo" id="txt-codigo" placeholder="Ingresar codigo" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Categoria</strong>
                            <select name="select-categoria" id="select-categoria" class="form-control">
                                <option value="0">SELECCIONE CATEGORIA</option>
                                <option value="1">LAPTOP</option>
                                <option value="2">IMPRESORA</option>
                                <option value="3">MOUSE</option>
                                <option value="4">ROUTER</option>
                                <option value="5">TECLADO</option>
                                <option value="6">MONITOR</option>
                                <option value="7">CONVERTIDOR</option>
                                <option value="8">UPS</option>
                                <option value="9">REGULADOR</option>
                                <option value="10">TV</option>
                                <option value="11">SWICH O CONMUTADOR</option>
                                <option value="12">SERVIDOR</option>
                                <option value="13">ACCES POINTS</option>
                                <option value="14">DISCO DURO</option>
                                <option value="15">MEMORIA RAM</option>
                                <option value="16">FUENTE</option>
                                <option value="17">CPU</option>
                                <option value="18">PARLANTES</option>
                                <option value="19">SCANNER</option>
                                <option value="20">CAMARA</option>
                                <option value="21">LECTOR DE HUELLA</option>
                                <option value="22">BIOMETRICO</option>
                                <option value="23">TELEFONO IP</option>
                                <option value="24">TODO EN UNO</option>
                            </select>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Marca</strong>
                            <input class="form-control" name="txt-marca" id="txt-marca" placeholder="Ingresar marca" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Modelo</strong>
                            <input class="form-control" name="txt-modelo" id="txt-modelo" placeholder="Ingresar modelo" type="text" onkeypress="mayus(this);"></input>
                        </div>
                       
                        <div class="col-md-6 mg-t-10">
                            <strong>Descripcion del Equipo</strong>
                            <input class="form-control" name="txt-descripcion" id="txt-descripcion" placeholder="Ingresar descripcion" type="text" onkeypress="mayus(this);"></input>
                        </div>

                        <div class="col-md-3 mg-t-10">
                            <strong>Numero de Serie</strong>
                            <input class="form-control" name="txt-serie" id="txt-serie" placeholder="Ingresar serie" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>MAC Ethernet</strong>
                            <input class="form-control" name="txt-mac-ethernet" id="txt-mac-ethernet" placeholder="Ingresar mac-ethernet" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>MAC Wifi</strong>
                            <input class="form-control" name="txt-mac-wifi" id="txt-mac-wifi" placeholder="Ingresar mac-wifi" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>IP</strong>
                            <input class="form-control" name="txt-ip" id="txt-ip" placeholder="Ingresar ip" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Anydesk</strong>
                            <input class="form-control" name="txt-anydesk" id="txt-anydesk" placeholder="Ingresar anydesk" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Area</strong>
                            <select name="select-area" id="select-area" class="form-control">
                                <option value="0">SELECCIONE AREA</option>
                                <option value="1">TRANSITO</option>
                                <option value="2">TTM</option>
                                <option value="3">CENTRO DE MONITOREO</option>
                            </select>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Ubicacion</strong>
                            <input class="form-control" name="txt-ubicacion" id="txt-ubicacion" placeholder="Ingresar ubicacion" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Fecha de Compra</strong>
                            <input class="form-control" name="txt-fecha-compra" id="txt-fecha-compra" placeholder="Ingresar fecha de compra" type="date" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Periodo de Garantia</strong>
                            <input class="form-control" name="txt-periodo-garantia" id="txt-periodo-garantia" placeholder="Ingresar periodo de garantia" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Proveedor</strong>
                            <input class="form-control" name="txt-proveedor" id="txt-proveedor" placeholder="Ingresar proveedor" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Estado</strong>
                            <select name="select-estado" id="select-estado" class="form-control">
                                <option value="0">SELECCIONE ESTADO</option>
                                <option value="1">MALO</option>
                                <option value="2">REGULAR</option>
                                <option value="3">BUENO</option>
                                <option value="4">DAR DE BAJA</option>
                            </select>
                        </div>

                        <div class="col-md-3 mg-t-10">
                            <strong>Memoria Ram</strong>
                            <input class="form-control" name="txt-ram" id="txt-ram" placeholder="Ingresar ram" type="text" onkeypress="mayus(this);"></input>
                        </div>
                     
                        <div class="col-md-3 mg-t-10">
                            <strong>Sistema Operativo</strong>
                            <input class="form-control" name="txt-sistema-operativo" id="txt-sistema-operativo" placeholder="Ingresar so" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Tipo de Sistema Operativo</strong>
                            <select name="select-tipo-sistema-operativo" id="select-tipo-sistema-operativo" class="form-control">
                                <option value="0">SELECCIONE TIPO DE SO</option>
                                <option value="1">32 BITS</option>
                                <option value="2">64 BITS</option>
                            </select>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Usuario del Sistema</strong>
                            <input class="form-control" name="txt-usuario-sistema" id="txt-usuario-sistema" placeholder="Ingresar usuario del sistema" type="text" onkeypress="mayus(this);"></input>
                        </div>

                        <div class="col-md-9 mg-t-10">
                            <strong>Programas</strong>
                            <input class="form-control" name="txt-programa" id="txt-programa" placeholder="Ingresar programa" type="text" onkeypress="mayus(this);"></input>
                        </div>

                        <div class="col-md-4 mg-t-10">
                            <strong>Disco Duro</strong>
                            <input class="form-control" name="txt-disco-duro" id="txt-disco-duro" placeholder="Ingresar disco duro" type="text" onkeypress="mayus(this);"></input>
                        </div>

                        <div class="col-md-8 mg-t-10">
                            <strong>Observacion</strong>
                            <input class="form-control" name="txt-observacion" id="txt-observacion" placeholder="Ingresar observacion" type="text" onkeypress="mayus(this);"></input>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-catalogo" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÃ‘ADIR CATALOGO-->

<!--INICIO MODAL ELIMINAR CATALOGO -->
<div class="modal show" id="modal-catalogo-e" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-catalogo-e" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-catalogo" name="txt-id-catalogo">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">Ã—</span>
                    </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el catalogo</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-catalogo" type="button"><i class="fa fa-times-circle"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR CATALOGO -->

<!-- INICIO MODAL MODIFICAR CONSOLIDADO LITERAL LOTAIP  -->
<div class="modal" id="modal-catalogo-m">
    <div class="modal-dialog modal-lg width-mo" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Agregar Catalogo</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-catalogo-m" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="txt-id-catalogo-m" name="txt-id-catalogo-m">
                    <div class="row ">
                        <div class="col-md-3 mg-t-10">
                            <strong>Codigo</strong>
                            <input class="form-control" name="txt-codigo-m" id="txt-codigo-m" placeholder="Ingresar codigo" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Categoria</strong>
                            <select name="select-categoria-m" id="select-categoria-m" class="form-control">
                                <option value="0">SELECCIONE CATEGORIA</option>
                                <option value="1">LAPTOP</option>
                                <option value="2">IMPRESORA</option>
                                <option value="3">MOUSE</option>
                                <option value="4">ROUTER</option>
                                <option value="5">TECLADO</option>
                                <option value="6">MONITOR</option>
                                <option value="7">CONVERTIDOR</option>
                                <option value="8">UPS</option>
                                <option value="9">REGULADOR</option>
                                <option value="10">TV</option>
                                <option value="11">SWICH O CONMUTADOR</option>
                                <option value="12">SERVIDOR</option>
                                <option value="13">ACCES POINTS</option>
                                <option value="14">DISCO DURO</option>
                                <option value="15">MEMORIA RAM</option>
                                <option value="16">FUENTE</option>
                                <option value="17">CPU</option>
                                <option value="18">PARLANTES</option>
                                <option value="19">SCANNER</option>
                                <option value="20">SERVIDOR</option>
                                <option value="21">LECTOR DE HUELLA</option>
                                <option value="22">BIOMETRICO</option>
                                <option value="23">TELEFONO IP</option>
                                <option value="24">TODO EN UNO</option>
                            </select>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Marca</strong>
                            <input class="form-control" name="txt-marca-m" id="txt-marca-m" placeholder="Ingresar marca" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Modelo</strong>
                            <input class="form-control" name="txt-modelo-m" id="txt-modelo-m" placeholder="Ingresar modelo" type="text" onkeypress="mayus(this);"></input>
                        </div>
                       
                        <div class="col-md-6 mg-t-10">
                            <strong>Descripcion del Equipo</strong>
                            <input class="form-control" name="txt-descripcion-m" id="txt-descripcion-m" placeholder="Ingresar descripcion" type="text" onkeypress="mayus(this);"></input>
                        </div>

                        <div class="col-md-3 mg-t-10">
                            <strong>Numero de Serie</strong>
                            <input class="form-control" name="txt-serie-m" id="txt-serie-m" placeholder="Ingresar serie" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>MAC Ethernet</strong>
                            <input class="form-control" name="txt-mac-ethernet-m" id="txt-mac-ethernet-m" placeholder="Ingresar mac-ethernet" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>MAC Wifi</strong>
                            <input class="form-control" name="txt-mac-wifi-m" id="txt-mac-wifi-m" placeholder="Ingresar mac-wifi" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>IP</strong>
                            <input class="form-control" name="txt-ip-m" id="txt-ip-m" placeholder="Ingresar ip" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Anydesk</strong>
                            <input class="form-control" name="txt-anydesk-m" id="txt-anydesk-m" placeholder="Ingresar anydesk" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Area</strong>
                            <select name="select-area-m" id="select-area-m" class="form-control">
                                <option value="0">SELECCIONE AREA</option>
                                <option value="1">TRANSITO</option>
                                <option value="2">TTM</option>
                                <option value="3">CENTRO DE MONITOREO</option>
                            </select>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Ubicacion</strong>
                            <input class="form-control" name="txt-ubicacion-m" id="txt-ubicacion-m" placeholder="Ingresar ubicacion" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Fecha de Compra</strong>
                            <input class="form-control" name="txt-fecha-compra-m" id="txt-fecha-compra-m" placeholder="Ingresar fecha de compra" type="date" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Periodo de Garantia</strong>
                            <input class="form-control" name="txt-periodo-garantia-m" id="txt-periodo-garantia-m" placeholder="Ingresar periodo de garantia" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Proveedor</strong>
                            <input class="form-control" name="txt-proveedor-m" id="txt-proveedor-m" placeholder="Ingresar proveedor" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Estado</strong>
                            <select name="select-estado-m" id="select-estado-m" class="form-control">
                                <option value="0">SELECCIONE ESTADO</option>
                                <option value="1">MALO</option>
                                <option value="2">REGULAR</option>
                                <option value="3">BUENO</option>
                                <option value="4">DAR DE BAJA</option>
                            </select>
                        </div>

                        <div class="col-md-3 mg-t-10">
                            <strong>Memoria Ram</strong>
                            <input class="form-control" name="txt-ram-m" id="txt-ram-m" placeholder="Ingresar ram" type="text" onkeypress="mayus(this);"></input>
                        </div>
                     
                        <div class="col-md-3 mg-t-10">
                            <strong>Sistema Operativo</strong>
                            <input class="form-control" name="txt-sistema-operativo-m" id="txt-sistema-operativo-m" placeholder="Ingresar so" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Tipo de Sistema Operativo</strong>
                            <select name="select-tipo-sistema-operativo-m" id="select-tipo-sistema-operativo-m" class="form-control">
                                <option value="0">SELECCIONE TIPO DE SO</option>
                                <option value="1">32 BITS</option>
                                <option value="2">64 BITS</option>
                            </select>
                        </div>
                        <div class="col-md-3 mg-t-10">
                            <strong>Usuario del Sistema</strong>
                            <input class="form-control" name="txt-usuario-sistema-m" id="txt-usuario-sistema-m" placeholder="Ingresar usuario del sistema" type="text" onkeypress="mayus(this);"></input>
                        </div>

                        <div class="col-md-9 mg-t-10">
                            <strong>Programas</strong>
                            <input class="form-control" name="txt-programa-m" id="txt-programa-m" placeholder="Ingresar programa" type="text" onkeypress="mayus(this);"></input>
                        </div>

                        <div class="col-md-4 mg-t-10">
                            <strong>Disco Duro</strong>
                            <input class="form-control" name="txt-disco-duro-m" id="txt-disco-duro-m" placeholder="Ingresar disco-duro" type="text" onkeypress="mayus(this);"></input>
                        </div>

                        <div class="col-md-8 mg-t-10">
                            <strong>Observacion</strong>
                            <input class="form-control" name="txt-observacion-m" id="txt-observacion-m" placeholder="Ingresar observacion" type="text" onkeypress="mayus(this);"></input>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-catalogo" type="button"><i class="fa fa-save"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR CONSOLIDADO LITERAL LOTAIP -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Catalogo/catalogo.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif