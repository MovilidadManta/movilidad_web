@extends('Administrador.Layout.app')

@section('css')
<style>
    .menu-list{
        list-style: none;
        padding-left: 5px;
        cursor: pointer;
        max-height: 9000px;
        transition: max-height 0.5s ease;
    }

    .menu-list.contract{
        max-height: 0;
        overflow: hidden;
    }

    .menu-list__li{
        border-radius: 10px;
        padding: 5px;
    }

    .menu-list__li.active{
        color: #009ee2;
    }

    .menu-list__li.active > .expandButtonMedio > .fa-angle-right{
        color: #009ee2;
        animation: rotate90 1s forwards;
    }

    .menu-list__li:hover{
        color: #009ee2;
        background-color: #f5f5f5;
    }

    .expandButtonMedio:hover > .fa-angle-right{
        animation: jump 1s infinite;
    }

    .container-cards{
        display: flex;
        flex-wrap: wrap;
        justify-content: start;
    }

    .card_unidad_productora{
        flex-basis: 200px;
        margin-right: 10px;
        align-self: stretch;
    }

    .card_unidad_productora__img{
        height: 150px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card-text{
        font-size: 13px;
        font-weight: normal;
        margin-bottom: 1px;
    }
    .card-text__bold{
        font-weight: bold;
    }

    .border_dashed{
        border-bottom: 1px dashed #009ee2;
    }

    .control-card{
        flex-basis: 95px;
        height: 115px;
        border-radius: 10px;
        border: 1px solid #737f9e;
        text-align: center;
        margin-right: 5px;
        margin-bottom: 5px;
        position: relative;
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

    .icon-agregar{
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .img_preview{
        border: 1px dashed #737f9e;
        min-height: 200px;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        cursor: pointer;
        position: relative;
    }

    .img_preview:hover{
        border: 1px dashed #009ee2;
        color: #009ee2;
    }

    .img_preview--icon{
        font-size: 60px;
    }

    .img_preview--text{
        font-size: 18px;
    }

    .pdf_preview_archive{
        width: 100%;
        min-height: 600px;
        height: 100%;
    }

    .pdf_preview{
        border: 1px dashed #737f9e;
        min-height: 600px;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        cursor: pointer;
    }

    .pdf_preview:hover{
        border: 1px dashed #009ee2;
        color: #009ee2;
    }

    .pdf_preview--icon{
        font-size: 60px;
    }

    .pdf_preview--text{
        font-size: 18px;
    }

    .btn_delete_img{
        background-color: #ccc;
        width: 48px;
        height: 48px;
        position: absolute;
        top: 5px;
        right: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn_delete_image--icon{
        font-size: 32px;
    }

    .breadcrumb-item{
        cursor: pointer;
    }

    .breadcrumb-item.active{
        color: #009ee2;
    }

    #container_actions_unidad_almacenamiento_charge{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 115px;
    }

    #container_unidad_almacenamiento_charge{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 50vh;
    }

    #footer_charge_medio_almacenamiento-modal_agregar_medio_almacenamiento{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 50px;
    }

    #body_charge_medio_almacenamiento-modal_agregar_medio_almacenamiento{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 600px;
    }

    #body_charge_documento-modal_agregar_documento{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 600px;
    }

    #lista_archivos_lateral_charge{
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 60vh;
    }

    .icon_charge {
        font-size: 3em; /* Tamaño del icono */
        color: #007bff; /* Color del icono */
        animation: rotate 2s linear infinite; /* Inicia la animación de rotación */
    } 
    
    #bodega_badge{
        cursor: pointer;
    }

    .card_medio_almacenamiento{
        position: relative;
    }

    .card_medio_almacenamiento--container_btn_config{
        background-color: #ccc;
        opacity: .4;
        width: 48px;
        height: 48px;
        position: absolute;
        top: 0px;
        right: 0px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 2;
    }

    .card_medio_almacenamiento--container_btn_config.active{
        opacity: 1;
    }

    .card_medio_almacenamiento--container_btn_config:hover{
        opacity: 1;
    }

    .card_medio_almacenamiento--container_btn_config:hover > .card_medio_almacenamiento--icon_btn_config{
        animation: rotate 5s linear infinite;
    }

    .card_medio_almacenamiento--icon_btn_config{
        font-size: 32px;
    }

    .card_medio_almacenamiento--container_btn_icons{
        background-color: #ccc;
        opacity: 0;
        width: 36px;
        height: 36px;
        top: 0px;
        right: 0px;
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 1;
        border-radius: 50%;
        border: 1px solid black;
        transition: top 0.5s, right 0.5s, opacity 0.3s;
    }

    .card_medio_almacenamiento--container_btn_icons.active{
        opacity: 0.7;
    }

    .card_medio_almacenamiento--container_btn_icons--info.active{
        top: -45px;
        right: 10px;
    }

    .card_medio_almacenamiento--container_btn_icons--edit.active{
        top: -40px;
        right: -35px;
    }

    .card_medio_almacenamiento--container_btn_icons--delete.active{
        top: 5px;
        right: -50px;
    }

    .card_medio_almacenamiento--container_btn_icons:hover{
        opacity: 1;
    }

    .card_medio_almacenamiento--icon_btn_icons{
        font-size: 24px;
    }

    .card_medio_almacenamiento--container_btn_icons:hover > .card_medio_almacenamiento--icon_btn_icons{
        font-size: 24px;
        animation: jump 1s infinite;
    }
    .empty_medio_almacenamiento{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 100%;
        height: 50vh;
        color: #007bff; 
    }

    .icon_empty {
        font-size: 3em; /* Tamaño del icono */
        color: #007bff; /* Color del icono */
        animation: jump 2s linear infinite; /* Inicia la animación de rotación */
    } 

    #div_table_documentos_stored{
        overflow: auto;
    }

    @keyframes jump {
        0% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
        100% {
            transform: translateY(0);
        }
    }

    @keyframes rotate90 {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(90deg);
        }
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg); /* Empieza la rotación desde 0 grados */
        }
        to {
            transform: rotate(360deg); /* Termina la rotación en 360 grados */
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
            <div class="d-flex">
                <div class="col-xs-12">
                    <h2 class="content-title mb-0 my-auto color-titulo">Bodega</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="card" style="min-height: 80vh;">
            <div class="card-body">
                <div class="row row-sm">
                    <div class="col-xs-4 col-lg-2">
                        <div class="alert alert-primary text-center" id="bodega_badge" role="alert">
                            <i class="fa fa-home"></i> {{$bodega->archivo}}
                        </div>
                        <div id="lista_archivos_lateral" style="display: none;">
                            <ul class="menu-list" data-id_padre="0">
                            </ul>
                        </div>
                        <div id="lista_archivos_lateral_charge">
                            <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="col-xs-8 col-lg-10">
                        <input type="hidden" id="acronimo_institucion" value="{{$variable->cf_valor}}">
                        <input type="hidden" id="acronimo_departamento" value="{{$variable_dep->cf_valor}}">
                        <input type="hidden" id="ma_id_charge" value="{{$ma_id}}">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb" id="breadcum_menu_archivo">
                                <li class="breadcrumb-item active" id="principal_item_breadcum" data-padre="0" data-id="1" aria-current="page"><i class="fa fa-home"></i> {{$bodega->archivo}}</li>
                            </ol>
                        </nav>
                        <div id="container_actions_unidad_almacenamiento" style="display: none;" class="container-cards border_dashed mb-3">
                        </div>
                        <div id="container_actions_unidad_almacenamiento_charge" class="border_dashed mb-3">
                            <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
                        </div>
                        <div id="container_unidad_almacenamiento" style="display: none;" class="container-cards">
                        </div>
                        <div id="div_table_documentos_stored" style="display: none;">
                        </div>
                        <div id="container_unidad_almacenamiento_charge" class="">
                            <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
<!-- End Row -->
</div>
<!-- Container closed -->

<!-- Modal agregar medio almacenamiento -->
<x-administrador.archivo.listabodegas.modal_agregar_modificar_medio_almacenamiento titulo="Agregar Medio Almacenamiento" idModalUnidadAlmacenamiento="modal_agregar_medio_almacenamiento" idFormModalUnidadAlmacenamiento="form_agregar_medio_almacenamiento" idBodega="{{$bodega->id}}">
</x-administrador.archivo.listabodegas.modal_agregar_modificar_medio_almacenamiento>
<!-- Fin Modal agregar medio almacenamiento -->

<!-- Modal agregar medio almacenamiento -->
<x-administrador.archivo.listabodegas.modal_agregar_modificar_documento titulo="Agregar Documento" idModalDocumento="modal_agregar_documento" idFormModalDocumento="form_agregar_documento">
</x-administrador.archivo.listabodegas.modal_agregar_modificar_documento>
<!-- Fin Modal agregar medio almacenamiento -->

<!-- Modal confirmacion borrar configuracion unidades almacenamiento -->
<x-generico.confirm_delete idModal="modal_confirm_delete_medio_almacenamiento" idFormModal="form_confirm_delete_medio_almacenamiento" idDelete="txt_id_delete_medio_almacenamiento" messageDelete="Esta seguro de eliminar este medio de almacenamiento?" idBtnDelete="btn_delete_medio_almacenamiento">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar configuracion unidades almacenamiento -->

<!-- Modal confirmacion borrar configuracion unidades almacenamiento -->
<x-generico.confirm_delete idModal="modal_confirm_delete_documento" idFormModal="form_confirm_delete_documento" idDelete="txt_id_delete_documento" messageDelete="Esta seguro de eliminar este documento?" idBtnDelete="btn_delete_documento">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar configuracion unidades almacenamiento -->

<!-- INICIO MODAL VISOR PDF  -->
<x-generico.modal_iframe_view idModal="modal_view_pdf_certificado" idVisor="iframe_documento_pdf" titulo="Visor Certificado PDF">
</x-generico.modal_iframe_view>
<!-- FIN MODAL VISOR PDF  -->
@endsection

@section('js')
<script type='text/javascript' src='/js/archivo/bodega.js'></script>
@endsection