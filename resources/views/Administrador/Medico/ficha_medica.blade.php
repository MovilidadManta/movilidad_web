@extends('Administrador.Layout.app')

@section('css')
<style>
    .swal2-container {
        z-index: 99999 !important;
    }
    .border_dashed{
        border-bottom: 1px dashed #009ee2;
    }
    #table-responsive_charge{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 400px;
    }
    .icon_charge {
        font-size: 3em; /* Tamaño del icono */
        color: #007bff; /* Color del icono */
        animation: rotate 2s linear infinite; /* Inicia la animación de rotación */
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Certificados Médicos</h2>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-ficha">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>

     <!-- row -->
     <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="card box-sha">
                <div class="card-body">
                    <div class="row row-sm">
                        <div class="card-body">
                            <div id="table-responsive" class="table-responsive">
                                <div id="div-table-ficha"></div>
                            </div>
                            <div id="table-responsive_charge" class="border_dashed mb-3" style="display: none;">
                                <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--/div-->
    </div>
</div>
<!-- Container closed -->

<!-- INICIO MODAL APROBAR CERTIFICADO  -->
<x-administrador.medico.modal_aprobar_certificado_medico>
</x-administrador.medico.modal_aprobar_certificado_medico>
<!-- FIN MODAL APROBAR CERTIFICADO  -->

<!-- INICIO MODAL VISOR PDF  -->
<x-generico.modal_iframe_view idModal="modal_view_pdf_certificado" idVisor="iframe_visor_certificado" titulo="Visor Certificado Médico">
</x-generico.modal_iframe_view>
<!-- FIN MODAL VISOR PDF  -->

<!-- INICIO MODAL CONFIRMAR APROBACION CERTIFICADO  -->
<x-generico.confirmation_emergent idModal="modal_confirmacion_aprobar_certificado" message="Esta seguro de aprobar este certificado?" idBtnConfirm="btn_confirm_generate_certificate" idBtnCancel="btn_cancelar_generate_certificate">
</x-generico.confirmation_emergent>
<!-- FIN MODAL CONFIRMAR APROBACION CERTIFICADO  -->
@endsection

@section('js')
<script type='text/javascript' src='/js/Medico/ficha_medica.js'></script>
@endsection