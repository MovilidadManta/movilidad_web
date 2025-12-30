@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
<style>
    .frame-recibido-lotaip{
        width: 400px;
        height: 500px;
    }
    .swal2-container {
        z-index: 99999 !important;
    }
    .tam-btn{
        height: 40px !important;
    }
    .tam-icono{
        font-size: 18px !important;
    }
</style>
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Solicitud LOTAIP</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <!--<div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-lotaip">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
                    </a>
                </div>-->

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
                            <div class="">
                                <div id="div-table-solicitud-lotaip"></div>
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

<!-- INICIO MODAL CONTESTAR SOLICITUD DE LOTAIP -->
<x-administrador.lotaip.modal_contestar_solicitud_lotaip_email></x-administrador.lotaip.modal_contestar_solicitud_lotaip_email>
<x-administrador.lotaip.modal_contestar_solicitud_lotaip_fisico></x-administrador.lotaip.modal_contestar_solicitud_lotaip_fisico>
<!--FIN MODAL CONTESTAR SOLICITUD DE LOTAIP -->

<!-- INICIO MODAL MODIFICAR LOTAIP AÑO -->
<div class="modal" id="modal-lotaip-m">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Modificar Lotaip</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">

                <form class="form" novalidate id="form-lotaip-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-lotaip-m" id="txt-id-lotaip-m">
                    <div class="row row-sm card-body">
                        <div class="col-lg">
                            <strong>Año</strong>
                            <input class="form-control" name="txt-year-m" id="txt-year-m" placeholder="Ingresar Año"
                                type="text">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-lotaip" type="button"><i
                        class="fa fa-save"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR LOTAIP AÑO -->

<!--INICIO MODAL ELIMINAR LOTAIP AÑO -->
<div class="modal show" id="modal-eliminar-lotaip" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-eliminar-lotaip" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-lotaip" name="txt-id-lotaip">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i
                        class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el lotaip</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal"
                        type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-lotaip" type="button"><i
                            class="fa fa-times-circle"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR LOTAIP AÑO -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Lotaip/solicitud_lotaip.js'></script>
<script src="/valex/assets/plugins/summernote-editor/summernote1.js"></script>
<script src="/valex/assets/js/summernote.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif