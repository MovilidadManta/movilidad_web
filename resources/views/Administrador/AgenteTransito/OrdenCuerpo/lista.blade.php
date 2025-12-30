@extends('Administrador.Layout.app')

@section('css')
<style>
    .icon_email{
        font-size: 18px !important;
    }
    .icon_elevated{
        font-size: 16px !important;
    }
    .icon_process{
        animation: spin 1s linear infinite;
        color : #198754;
    }
    .icon_success{
        font-size: 24px;
        color: #198754;
    }

    @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
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
            <div class="row">
                <div class="col-xs-12 mb-3">
                    <h2 class="content-title mb-0 my-auto color-titulo">Lista de Orden de cuerpo</h2>
                </div>
                <div class="col-xs-12">
                    <a class="btn background-btn-nuevo pad-nu" id="btn_anadir_orden_cuerpo">
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
                        <div class="card-body">
                            <div class="table-responsive">
                                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                                <div id="div_table_orden_cuerpo"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
<!-- End Row -->
</div>
<!-- Container closed -->

<!-- INICIO MODAL VISOR PDF  -->
<x-generico.modal_iframe_view idModal="modal_view_pdf_orden_cuerpo" idVisor="iframe_visor_orden_cuerpo" titulo="Visor Orden de cuerpo">
</x-generico.modal_iframe_view>
<!-- FIN MODAL VISOR PDF  -->

<!-- Modal confirmacion borrar configuracion unidades almacenamiento -->
<x-generico.confirm_delete idModal="modal_confirm_delete_orden_cuerpo" idFormModal="form_confirm_delete_orden_cuerpo" idDelete="txt_id_delete_orden_cuerpo" messageDelete="Esta seguro de eliminar esta orden de cuerpo?" idBtnDelete="btn_delete_orden_cuerpo">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar configuracion unidades almacenamiento -->

<!-- Modal confirmacion enviar email orden de cuerpo -->
<x-generico.confirmation_emergent idModal="modal_confirm_send_email_orden_cuerpo" idBtnConfirm="btn_confirm_send_email" idBtnCancel="btn_cancel_send_email" message="Esta seguro de procesar esta orden de cuerpo?">
</x-generico.confirmation_emergent>
<!-- Fin Modal confirmacion enviar email orden de cuerpo -->

<!-- Modal confirmacion enviar email orden de cuerpo -->
<x-generico.confirm_autorizacion_qr modalConfirm="modal_confirm_autorizacion_qr">
</x-generico.confirm_autorizacion_qr>
<!-- Fin Modal confirmacion enviar email orden de cuerpo -->
@endsection

@section('js')
<script type='text/javascript' src='/js/agentes_transito/orden_cuerpo/lista.js'></script>
@endsection