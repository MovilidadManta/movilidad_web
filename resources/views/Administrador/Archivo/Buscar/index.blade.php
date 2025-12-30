@extends('Administrador.Layout.app')

@section('css')
<style>
    #btn_buscar_documento{
        cursor: pointer;
    }
    .btn-modal-editar{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .border_dashed{
        border-bottom: 1px dashed #009ee2;
        padding-bottom: 20px;
    }
    .icon_charge {
        font-size: 3em; /* Tamaño del icono */
        color: #007bff; /* Color del icono */
        animation: rotate 2s linear infinite; /* Inicia la animación de rotación */
    }
    .caratula_chargue{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 60vh;
    }
    .icon_detail{
        font-size: 20px;
    }
    .bold{
        font-weight: bold;
    }
    .white_space{
        white-space: pre;
    }
    .center_ubicacion{
        display: flex;
        justify-content: center;
        align-content: center;
        padding-top: 10px;
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
                <div class="col-xs-12">
                    <h1 class="content-title mb-0 my-auto color-titulo">Buscar Documentos</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm">
                        <div class="card-body">
                            <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf_token">
                            <form class="form" novalidate id="form_buscar_documentos" method="POST" enctype="multipart/form-data">
                                <div class="row border_dashed">
                                    <div class="col-xs-12 mb-3">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                            Bodega
                                        </label>
                                        <select name="bodega" id="bodega" class="form-control">
                                            <option value="0">TODOS</option>
                                            @foreach ($bodegas as $b)
                                                <option value="{{$b->id}}">{{$b->archivo}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-6 col-lg-4">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                            Unidad Productora
                                        </label>
                                        <select name="cup_id" id="cup_id" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-6 col-lg-4">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                            Unidad Productora Serie
                                        </label>
                                        <select name="cups_id" id="cups_id" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-6 col-lg-4">
                                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                            Documento
                                        </label>
                                        <select name="cd_id" id="cd_id" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-xs-12 mt-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control"
                                            id="txt_busqueda"
                                            name="txt_busqueda" 
                                            placeholder="Buscar Documento..." 
                                            aria-label="Buscar Documento..."
                                            style="text-transform: uppercase;"
                                            aria-describedby="btn_buscar_documento">
                                            <div class="input-group-text" id="btn_buscar_documento"><i class="fa fa-search"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive mt-3">
                                <div id="div_table_buscar_documentos" style="display: none;"></div>
                                <div id="div_table_buscar_documentos_charge" class="caratula_chargue">
                                    <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
                                </div>
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

<x-administrador.archivo.buscar.modal_detail_archivo idModalDetalleArchivo="modal_detail_archivo">
</x-administrador.archivo.buscar.modal_detail_archivo>

<!-- INICIO MODAL VISOR PDF  -->
<x-generico.modal_iframe_view idModal="modal_view_pdf" idVisor="iframe_documento_pdf" titulo="Visor Certificado PDF">
</x-generico.modal_iframe_view>
<!-- FIN MODAL VISOR PDF  -->

@endsection



@section('js')
<script type='text/javascript' src='/js/archivo/buscar.js'></script>
@endsection