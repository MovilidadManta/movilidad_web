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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestión de Consolidado</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-consolidado">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
                    </a>
                </div>

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
                                <div id="div-table-indicador"></div>
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

<!-- INICIO MODAL AÑADIR CONSOLIDADO -->
<div class="modal" id="modal-indicador">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Agregar Indicador</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-indicador" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-json-indicador" id="txt-json-indicador">
                    <div class="row row-sm card-body">
                        <div class="col-lg">
                            <strong>Dirección</strong>
                            <select name="select-direccion" id="select-direccion" class="form-control form-select select2">
                                <option value="0">SELECCIONE DIRECCIÓN</option>
                            </select>
                        </div>
                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <strong>Jefatura/SubDirección</strong>
                            <select name="select-jefatura-subdireccion" id="select-jefatura-subdireccion" class="form-control">
                                <option value="0">SELECCIONE JEFATURA</option>
                            </select>
                        </div>

                    </div>
                    <div class="row row-sm card-body">
                        <div class="col-lg">
                            <strong>Indicador</strong>
                            <select name="select-indicador" id="select-indicador" class="form-control form-select select2">
                                <option value="0">SELECCIONE INDICADOR</option>
                            </select>
                        </div>
                    </div>

                    <div class="row row-sm card-body">
                        <div class="col-lg">
                            <strong>Tipo Indicador</strong>
                            <select name="select-tipo-indicador" id="select-tipo-indicador" class="form-control">
                                <option value="0">SELECCIONE TIPO</option>
                            </select>
                        </div>
                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <strong>Valor</strong>
                            <input class="form-control" name="txt-valor" id="txt-valor" placeholder="Ingresar Valor" type="text">
                        </div>
                        <div class="col-lg mg-t-10 mg-lg-t-0 marg-a">
                            <a class="btn background-btn-nuevo pad-nu " id="btn-añadir-indicador">
                                <i class="fa fa-plus-square color-btn-nuevo"></i>
                                <strong class="color-btn-nuevo">Añadir</strong>
                            </a>
                        </div>

                    </div>

                    <div class="row row-sm card-body none" id="div-table-detalle-indicador">
                        <table id="table-empleado" border="2" class="table">
                            <thead class="background-thead">
                                <tr align="center">
                                    <th align="center" class="border-bottom-0 color-th pad">Tipo Indicador</th>
                                    <th align="center" class="border-bottom-0 color-th pad">Valor</th>
                                    <th align="center" class="border-bottom-0 color-th pad">Opciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-table-detalle-indicador">

                            </tbody>
                        </table>
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
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-indicador" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR CONSOLIDADO -->

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

<!-- INICIO MODAL MODIFICAR CONSOLIDADO -->
<div class="modal" id="modal-modificar-indicador">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Modificar Indicador</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-modificar-indicador" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-json-indicador-m" id="txt-json-indicador-m">
                    <input type="hidden" name="txt-id-indicador-m" id="txt-id-indicador-m">
                    <div class="row row-sm card-body">
                        <div class="col-lg">
                            <strong>Dirección</strong>
                            <select name="select-direccion-m" id="select-direccion-m" class="form-control form-select select2">
                                <option value="0">SELECCIONE DIRECCIÓN</option>
                            </select>
                        </div>
                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <strong>Jefatura/SubDirección</strong>
                            <select name="select-jefatura-subdireccion-m" id="select-jefatura-subdireccion-m" class="form-control">
                                <option value="0">SELECCIONE JEFATURA</option>
                            </select>
                        </div>

                    </div>
                    <div class="row row-sm card-body">
                        <div class="col-lg">
                            <strong>Indicador</strong>
                            <select name="select-indicador-m" id="select-indicador-m" class="form-control form-select select2">
                                <option value="0">SELECCIONE INDICADOR</option>
                            </select>
                        </div>
                    </div>

                    <div class="row row-sm card-body">
                        <div class="col-lg">
                            <strong>Tipo Indicador</strong>
                            <select name="select-tipo-indicador-m" id="select-tipo-indicador-m" class="form-control">
                                <option value="0">SELECCIONE TIPO</option>
                            </select>
                        </div>
                        <div class="col-lg mg-t-10 mg-lg-t-0">
                            <strong>Valor</strong>
                            <input class="form-control" name="txt-valor-m" id="txt-valor-m" placeholder="Ingresar Valor" type="text">
                        </div>
                        <div class="col-lg mg-t-10 mg-lg-t-0 marg-a">
                            <a class="btn background-btn-nuevo pad-nu " id="btn-añadir-indicador-m">
                                <i class="fa fa-plus-square color-btn-nuevo"></i>
                                <strong class="color-btn-nuevo">Añadir</strong>
                            </a>
                        </div>

                    </div>

                    <div class="row row-sm card-body none" id="div-table-detalle-indicador-m">
                        <table id="table-empleado" border="2" class="table">
                            <thead class="background-thead">
                                <tr align="center">
                                    <th align="center" class="border-bottom-0 color-th pad">Tipo Indicador</th>
                                    <th align="center" class="border-bottom-0 color-th pad">Valor</th>
                                    <th align="center" class="border-bottom-0 color-th pad">Opciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-table-detalle-indicador-m">

                            </tbody>
                        </table>
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
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-indicador" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR CONSOLIDADO -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Consolidado/consolidado.js'></script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif