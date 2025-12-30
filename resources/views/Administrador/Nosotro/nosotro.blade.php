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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestion de Misión y Visión</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-nosotro">
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
                                <div id="div-table-nosotro"></div>
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

<!-- INICIO MODAL AÑADIR MISION Y VISION -->
<div class="modal" id="modal-nosotro">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Agregar Misión y Visión</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-nosotro" method="POST" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg">
                            <strong>Misión</strong>
                            <textarea class="form-control" id="txt-mision" name="txt-mision" rows="4" placeholder="Ingresar misión"></textarea>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg">
                            <strong>Visión</strong>
                            <textarea class="form-control" id="txt-vision" name="txt-vision" rows="4" placeholder="Ingresar visión"></textarea>
                        </div>
                    </div>
                    <!--<div class="row row-sm">
                        <div class="col-lg">
                            <strong>Año</strong>
                            <select class="form-control" id="select-ano" name="select-ano" placeholder="" >
                                <option value="0">Seleccione año</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>-->
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-nosotro" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR MISION Y VISION -->

<!--INICIO MODAL ELIMINAR MISION Y VISION -->
<div class="modal show" id="modal-eliminar-nosotro" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-eliminar-nosotro" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-nosotro" name="txt-id-nosotro">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar Misión y Visión</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-nosotro" type="button"><i class="fa fa-save"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR MISION Y VISION -->

<!-- INICIO MODAL AÑADIR MISION Y VISION -->
<div class="modal" id="modal-modificar-nosotro">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Modificar Misión y Visión</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-m-nosotro" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-modificar-nosotro" id="txt-id-modificar-nosotro">
                    <div class="row row-sm">
                        <div class="col-lg">
                            <strong>Misión</strong>
                            <textarea class="form-control" id="txt-m-mision" name="txt-m-mision" rows="4" placeholder="Ingresar misión"></textarea>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg">
                            <strong>Visión</strong>
                            <textarea class="form-control" id="txt-m-vision" name="txt-m-vision" rows="4" placeholder="Ingresar visión"></textarea>
                        </div>
                    </div>
                    <!--<div class="row row-sm">
                        <div class="col-lg">
                            <strong>Año</strong>
                            <select class="form-control" id="select-ano" name="select-ano" placeholder="" >
                                <option value="0">Seleccione año</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>-->
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-nosotro" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR MISION Y VISION -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Nosotro/nosotro.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif