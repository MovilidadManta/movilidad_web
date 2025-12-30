@extends('Administrador.Layout.app')

@section('css')
<style>
    .container-cards{
        display: flex;
        flex-wrap: wrap;
        justify-content: start;
    }
    .control-card{
        flex-basis: 75px;
        height: 95px;
        border-radius: 10px;
        border: 1px solid #737f9e;
        text-align: center;
        margin-right: 5px;
        margin-bottom: 5px;
    }
    .control-card_active{
        border: 1px solid #009ee2;
        color: #009ee2;
    }
    .control-card:hover{
        cursor: pointer;
        border: 1px solid #009ee2;
        color: #009ee2;
    }
    .control-card__icon{
        padding: 10px;
        font-size: 24px;
    }
    .control-card__text{
        display: block;
        text-align: center;
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
                    <h1 class="content-title mb-0 my-auto color-titulo">Configuración de Unidades de Almacenamiento</h1>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-configuracion-unidades-almacenamiento">
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
                                <div id="div-table-configuracion-unidades-almacenamiento"></div>
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

<!-- Modal agregar configuracion unidades almacenamiento -->
<x-administrador.archivo.configuracionunidadesalmacenamiento.modal_agregar_modificar_configuracion_unidades_almacenamiento titulo="Agregar Configuracion Unidades Almacenamiento" idModalConfiguracionUnidadesAlmacenamiento="modal_agregar_configuracion_unidades_almacenamiento" idFormModalConfiguracionUnidadesAlmacenamiento="form_agregar_configuracion_unidades_almacenamiento">
</x-administrador.archivo.configuracionunidadesalmacenamiento.modal_agregar_modificar_configuracion_unidades_almacenamiento>
<!-- Fin Modal agregar configuracion unidades almacenamiento -->

<!-- Modal modificar configuracion unidades almacenamiento -->
<x-administrador.archivo.configuracionunidadesalmacenamiento.modal_agregar_modificar_configuracion_unidades_almacenamiento titulo="Modificar Configuracion Unidades Almacenamiento" idModalConfiguracionUnidadesAlmacenamiento="modal_modificar_configuracion_unidades_almacenamiento" idFormModalConfiguracionUnidadesAlmacenamiento="form_modificar_configuracion_unidades_almacenamiento">
</x-administrador.archivo.configuracionunidadesalmacenamiento.modal_agregar_modificar_configuracion_unidades_almacenamiento>
<!-- Fin Modal modificar configuracion unidades almacenamiento -->

<!-- Modal confirmacion borrar configuracion unidades almacenamiento -->
<x-generico.confirm_delete idModal="modal_confirm_delete_configuracion_unidades_almacenamiento" idFormModal="form_confirm_delete_configuracion_unidades_almacenamiento" idDelete="txt-id-delete-configuracion-unidades-almacenamiento" messageDelete="Esta seguro de eliminar esta configuración de unidades de almacenamiento?" idBtnDelete="btn-delete-configuracion-unidades-almacenamiento">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar configuracion unidades almacenamiento -->
@endsection

@section('js')
<script type='text/javascript' src='/js/ConfiguracionUnidadesAlmacenamiento/configuracion_unidades_almacenamiento.js'></script>
@endsection