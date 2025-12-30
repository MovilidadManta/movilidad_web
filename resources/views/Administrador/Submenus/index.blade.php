@if(Session::get('usuario'))
@extends('Administrador.Layout.app')
@section('css')
<link rel="stylesheet" href="{{asset('lib/Switch/dist/checkbox.css')}}">
<link rel="stylesheet" href="{{asset('lib/Switch/css/SimpleSwitch.css')}}">

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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestion de Submenus</h2>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn_add">
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
                                <div id="div-table"></div>
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

<!-- INICIO MODAL AÑADIR SUB MENU -->
<div class="modal" id="modal_created">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Agregar Submenu</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="load_moda" id="load_m">
                    <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                    <img src="/valex/assets/img/logo-movilidad.png" class="loader_2 loader-img tam" alt="loader_2">
                </div>
                <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                    <div class="form-group">
                        <strong>Proyecto</strong>
                        <select name="select-proyecto" id="select-proyecto" onchange="get_menus()" class="form-control">
                            <option value='0'>Seleccione un proyecto</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>Menu</strong>
                        <select id="sel_menu" class="form-control">
                            <option value='0'>Seleccione un menu....</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            Submenu
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="ip_submenu" name="ip_submenu" placeholder="Ej. recaudacion">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            Tipo de Link
                        </label>
                        <div class="pos-relative">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rd_tipo" id="rd_tipo_in" value="interno">
                                <label class="form-check-label" for="rd_tipo_in">
                                    Interno
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rd_tipo" id="rd_tipo_ex" value="externo">
                                <label class="form-check-label" for="rd_tipo_ex">
                                    Externo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            Link
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="ip_link" name="ip_submenu" placeholder="Ej. /recaudacion">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_save" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR USUARIOS -->

<!--INICIO MODAL ELIMINAR USUARIOS -->
<div class="modal show" id="modal_delete_proyecto" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" id="ip_id_proyecto_delete" name="ip_id_proyecto_delete">
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">×</span>
                </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="tx-danger mg-b-20">Seguro de eliminar el submenu?</h4>
                <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                <button class="btn btn-success-gradient" id="btn-eliminar-proyecto" type="button"><i class="fa fa-save"></i> Eliminar</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR USUARIOS -->

<!-- INICIO MODAL MODIFICAR USUARIOS -->
<div class="modal" id="modal_editar_submenu">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal-m" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Modificar Submenu</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="load_moda" id="load_m-m">
                    <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                    <img src="/valex/assets/img/logo-movilidad.png" class="loader_2 loader-img tam" alt="loader_2">
                </div>
                <input type="hidden" id="id_mod_submenu" value="" />
                <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                    <div class="form-group">
                        <strong>Proyecto</strong>
                        <select name="select-proyecto" id="select-proyecto-m" onchange="get_menus_m()" class="form-control">
                            <option value='0'>Seleccione un proyecto</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <strong>Menu</strong>
                        <select id="sel_menu-m" class="form-control">
                            <option value='0'>Seleccione un menu....</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            Submenu
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="ip_submenu-m" name="ip_submenu" placeholder="Ej. recaudacion">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            Tipo de Link
                        </label>
                        <div class="pos-relative">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rd_tipo-m" id="rd_tipo_in-m" value="interno">
                                <label class="form-check-label" for="rd_tipo_in-m">
                                    Interno
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rd_tipo-m" id="rd_tipo_ex-m" value="externo">
                                <label class="form-check-label" for="rd_tipo_ex-m">
                                    Externo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            Link
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="ip_link-m" name="ip_submenu" placeholder="Ej. /recaudacion">
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <div style="margin-left: 35px;">
                            <input class="form-check-input" type="checkbox" id="chk_estado-m">
                            <label for="">Estado: <span id="l_estado_h">Inactivo</span></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_save-m" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--
<div class="modal" id="modal_editar_proyecto">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            !-- Loader --
            <div id="global-loader-modal" class="none">
                !--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">--
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            !-- /Loader --
            <div class="modal-header">
                <h6 class="modal-title">Modificar SubMenu</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="ip_id_proyecto_edit" id="ip_id_proyecto_edit">
                <div class="row">
                    <input type="text" class="form-control" id="ip_proyecto_edit">

                    <span class="margin-r">Estado</span>
                    <input type="checkbox" data-type="simple-switch" id="chk_estado_2" data-material="true">
                    <label for="" id="l_estado_h">activo</label>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-proyecto" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div> -->
<!--FIN MODAL MODIFICAR USUARIOS -->



@endsection

@section('js')
<script type='text/javascript' src="{{asset('lib/Switch/js/SimpleSwitch.min.js')}}"></script>


<script type='text/javascript' src='/js/Submenus/submenus.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif