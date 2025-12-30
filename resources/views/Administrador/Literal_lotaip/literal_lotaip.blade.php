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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestión de literal de LOTAIP</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-literal-lotaip">
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
                                <div id="div-table-lotaip"></div>
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

<!-- INICIO MODAL AÑADIR LITERAL LOTAIP -->
<div class="modal" id="modal-literal-lotaip">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Agregar Literal Lotaip</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-literal-lotaip" method="POST" enctype="multipart/form-data">
                    <div class="row row-sm card-body">
                        <div class="col-lg">
                            <strong>Literal</strong>
                            <input class="form-control" name="txt-literal" id="txt-literal" placeholder="Ingresar Literal" type="text"></input>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-literal-lotaip" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR LITERAL LOTAIP-->

<!--INICIO MODAL ELIMINAR INDICADOR -->
<div class="modal show" id="modal-eliminar-indicador" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-eliminar-indicador" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-indicador" name="txt-id-indicador">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el indicador</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-indicador" type="button"><i class="fa fa-times-circle"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR INDICADOR -->

<!-- INICIO MODAL MODIFICAR CONSOLIDADO LITERAL LOTAIP  -->
<div class="modal" id="modal-literal-lotaip-m">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Modificar Literal LOTAIP</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-literal-lotaip-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-literal-lotaip-m" id="txt-id-literal-lotaip-m">
                    <div class="row row-sm card-body">
                        <div class="col-lg">
                            <strong>Literal</strong>
                            <input class="form-control" name="txt-literal-m" id="txt-literal-m" placeholder="Ingresar Literal" type="text"></input>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-literal-lotaip" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR CONSOLIDADO LITERAL LOTAIP -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Literal_Lotaip/literal_lotaip.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif