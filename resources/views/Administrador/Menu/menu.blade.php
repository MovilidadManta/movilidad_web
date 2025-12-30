@if (Session::get('usuario'))
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestion de Menu</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-menu">
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
                                <div id="div-table-menu"></div>
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
<!-- INICIO MODAL AÑADIR MENU -->
<div class="modal" id="modal-menu">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Agregar Menu</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" novalidate id="form-menu" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Proyecto</strong>
                            <select name="select-proyecto" id="select-proyecto" class="form-control"></select>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Menu</strong>
                            <input class="form-control" name="txt-menu" id="txt-menu" placeholder="Ingresar Menu" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Estado</strong>
                            <select name="select-estado" id="select-estado" class="form-control">
                                <option value="S">Seleccione Estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Icono</strong>
                            <select name="select-icono" id="select-icono" class="form-control fa">
                                <option value="S">Seleccione un icono</option>
                                @foreach($iconos as $i)
                                <option class="fa" value="{{$i->icono_img}}">&#x{{$i->icono_hex}}; {{$i->icono}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-menu" type="button">
                    <i class="fa fa-save"></i>
                    Guardar
                </button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i>
                    Salir
                </button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR MENU -->
<!--INICIO MODAL ELIMINAR MENU -->
<div class="modal show" id="modal-eliminar-menu" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <form class="form" novalidate id="form-eliminar-menu" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-menu-e" name="txt-id-menu-e">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                    <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar Menu</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
         the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-menu" type="button">
                        <i class="fa fa-times"></i>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR MENU -->
<!-- INICIO MODAL MODIFICAR MENU -->
<div class="modal" id="modal-menu-m">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Modificar Menu</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" novalidate id="form-menu-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-menu-m" name="txt-id-menu-m">
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Proyecto</strong>
                            <select name="select-proyecto-m" id="select-proyecto-m" class="form-control"></select>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Menu</strong>
                            <input class="form-control" name="txt-menu-m" id="txt-menu-m" placeholder="Ingresar Menu" type="text" onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Estado</strong>
                            <select name="select-estado-m" id="select-estado-m" class="form-control">
                                <option value="S">Seleccione Estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-menu" type="button">
                    <i class="fa fa-edit"></i>
                    Modificar
                </button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i>
                    Salir
                </button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR MENU -->
@endsection

@section('js')
<script type="text/javascript" src="/js/Menu/menu.js"></script>
@endsection
@else
<script>
    location.href = "/login";
</script>
@endif