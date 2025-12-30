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
                    <h1 class="content-title mb-0 my-auto color-titulo">Configuración de Unidad Productora</h1>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn_añadir_configuracion_unidad_productora">
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
                                <div id="div_table_configuracion_unidad_productora"></div>
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

<!-- Modal agregar configuracion unidad productora -->
<x-administrador.archivo.configuracionunidadproductora.modal_agregar_modificar_configuracion_unidad_productora titulo="Agregar Configuración de Unidad Productora" idModalConfiguracionUnidadProductora="modal_agregar_configuracion_unidad_productora" idFormModalConfiguracionUnidadProductora="form_agregar_configuracion_unidad_productora">
</x-administrador.archivo.configuracionunidadproductora.modal_agregar_modificar_configuracion_unidad_productora>
<!-- Fin Modal agregar configuracion unidad productora -->

<!-- Modal modificar configuracion unidad productora -->
<x-administrador.archivo.configuracionunidadproductora.modal_agregar_modificar_configuracion_unidad_productora titulo="Modificar Configuración de Unidad Productora" idModalConfiguracionUnidadProductora="modal_modificar_configuracion_unidad_productora" idFormModalConfiguracionUnidadProductora="form_modificar_configuracion_unidad_productora">
</x-administrador.archivo.configuracionunidadproductora.modal_agregar_modificar_configuracion_unidad_productora>
<!-- Fin Modal modificar configuracion unidad productora -->

<!-- Modal modificar configuracion series y documentos -->
<x-administrador.archivo.configuracionunidadproductora.modal_configurar_series>
</x-administrador.archivo.configuracionunidadproductora.modal_configurar_series>
<!-- Fin Modal modificar configuracion series y documentos -->

<!-- Modal confirmacion borrar configuracion unidad productora -->
<x-generico.confirm_delete idModal="modal_confirm_delete_configuracion_unidad_productora" idFormModal="form_confirm_delete_configuracion_unidad_productora" idDelete="txt_id_delete_configuracion_unidad_productora" messageDelete="Esta seguro de eliminar esta configuración de unidad productora?" idBtnDelete="btn_delete_configuracion_unidad_productora">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar configuracion unidad productora -->

<!-- Modal confirmacion borrar documento serie -->
<x-generico.confirm_delete idModal="modal_confirm_delete_configuracion_unidad_productora_serie_documento" idFormModal="form_confirm_delete_configuracion_unidad_productora_serie_documento" idDelete="txt_id_delete_configuracion_unidad_productora_serie_documento" messageDelete="Esta seguro de eliminar este documento asignado?" idBtnDelete="btn_delete_configuracion_unidad_productora_serie_documento">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar documento serie -->
@endsection

@section('js')
<script type='text/javascript' src='/js/ConfiguracionUnidadProductora/configuracion_unidad_productora.js'></script>
@endsection