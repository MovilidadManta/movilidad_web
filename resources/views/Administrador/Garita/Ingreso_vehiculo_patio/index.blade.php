@extends('Administrador.Layout.app')

@section('css')
<style>
  :root{
    --color_hover: #009ee2;
  }

  .panel-heading{
    background: #25476a;
    border-color: #25476a;
    color: #fff;
    margin-bottom: 20px;
  }
.modal-full{
    max-width: 90%;
}
.container_inventario_vehiculo{
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    grid-template-rows: repeat(6, 1fr);
    grid-column-gap: 0px;
    grid-row-gap: 0px;
}
.item_full_width {
  grid-column: 1 / -1;
}
.margin-10{
    margin-top: 10px;
}

/* CheckBox */
.checkbox-wrapper-1 *,
  .checkbox-wrapper-1 ::after,
  .checkbox-wrapper-1 ::before {
    box-sizing: border-box !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted {
    margin: 0 !important;
    width: 0 !important;
    height: 0 !important;
    display: inline !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted + label:before {
    content: "" !important;
    display: inline-block !important;
    vertical-align: top !important;
    height: 1.15em !important;
    width: 1.15em !important;
    margin-right: 0.6em !important;
    color: rgba(0, 0, 0, 0.275) !important;
    border: solid 0.06em !important;
    box-shadow: 0 0 0.04em, 0 0.06em 0.16em -0.03em inset, 0 0 0 0.07em transparent inset !important;
    border-radius: 0.2em !important;
    background: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xml:space="preserve" fill="white" viewBox="0 0 9 9"><rect x="0" y="4.3" transform="matrix(-0.707 -0.7072 0.7072 -0.707 0.5891 10.4702)" width="4.3" height="1.6" /><rect x="2.2" y="2.9" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 12.1877 2.9833)" width="6.1" height="1.7" /></svg>') no-repeat center, white !important;
    background-size: 0 !important;
    will-change: color, border, background, background-size, box-shadow !important;
    transform: translate3d(0, 0, 0) !important;
    transition: color 0.1s, border 0.1s, background 0.15s, box-shadow 0.1s !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted:enabled:active + label:before,
  .checkbox-wrapper-1 [type=checkbox].substituted:enabled + label:active:before {
    box-shadow: 0 0 0.04em, 0 0.06em 0.16em -0.03em transparent inset, 0 0 0 0.07em rgba(0, 0, 0, 0.1) inset !important;
    background-color: #f0f0f0 !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted:checked + label:before {
    background-color: #3B99FC !important;
    background-size: 0.75em !important;
    color: rgba(0, 0, 0, 0.075) !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted:checked:enabled:active + label:before,
  .checkbox-wrapper-1 [type=checkbox].substituted:checked:enabled + label:active:before {
    background-color: #0a7ffb !important;
    color: rgba(0, 0, 0, 0.275) !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted:focus + label:before {
    box-shadow: 0 0 0.04em, 0 0.06em 0.16em -0.03em transparent inset, 0 0 0 0.07em rgba(0, 0, 0, 0.1) inset, 0 0 0 3.3px rgba(65, 159, 255, 0.55), 0 0 0 5px rgba(65, 159, 255, 0.3) !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted:focus:active + label:before,
  .checkbox-wrapper-1 [type=checkbox].substituted:focus + label:active:before {
    box-shadow: 0 0 0.04em, 0 0.06em 0.16em -0.03em transparent inset, 0 0 0 0.07em rgba(0, 0, 0, 0.1) inset, 0 0 0 3.3px rgba(65, 159, 255, 0.55), 0 0 0 5px rgba(65, 159, 255, 0.3) !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted:disabled + label:before {
    opacity: 0.5 !important;
  }

  .checkbox-wrapper-1 [type=checkbox].substituted.dark + label:before {
    color: rgba(255, 255, 255, 0.275) !important;
    background-color: #222 !important;
    background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xml:space="preserve" fill="rgba(34, 34, 34, 0.999)" viewBox="0 0 9 9"><rect x="0" y="4.3" transform="matrix(-0.707 -0.7072 0.7072 -0.707 0.5891 10.4702)" width="4.3" height="1.6" /><rect x="2.2" y="2.9" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 12.1877 2.9833)" width="6.1" height="1.7" /></svg>') !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted.dark:enabled:active + label:before,
  .checkbox-wrapper-1 [type=checkbox].substituted.dark:enabled + label:active:before {
    background-color: #444 !important;
    box-shadow: 0 0 0.04em, 0 0.06em 0.16em -0.03em transparent inset, 0 0 0 0.07em rgba(255, 255, 255, 0.1) inset !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted.dark:checked + label:before {
    background-color: #a97035 !important;
    color: rgba(255, 255, 255, 0.075) !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted.dark:checked:enabled:active + label:before,
  .checkbox-wrapper-1 [type=checkbox].substituted.dark:checked:enabled + label:active:before {
    background-color: #c68035 !important;
    color: rgba(0, 0, 0, 0.275) !important;
  }
  .checkbox-wrapper-1 [type=checkbox].substituted + label {
    -webkit-user-select: none !important;
    user-select: none !important;
  }
/* Fin CheckBox */

/* Container Documentos */
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

    .pdf_preview{
        border: 1px dashed #737f9e;
        min-height: 150px;
        max-height: 300px;
        flex-basis: 200px;
        margin-right: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        align-self: stretch;
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
        text-align: center;
    }

    .btn-grow{
      flex-grow: 1;
      font-size: 24px;
    }

    .card_ingreso{
      width: 70%;
      margin-left: auto;
      margin-right: auto;
      text-align: center;
    }

    .card_ingreso:hover{
      cursor: pointer;
      border-color: var(--color_hover);
    }

    .card_ingreso--check{
      border: 1px solid #ccc;
      position: absolute;
      width: 40px;
      height: 40px;
      top: 5px;
      right: 5px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    .card_ingreso:hover .card_ingreso--check,
    .card_ingreso.clickeado .card_ingreso--check{
      border-color: var(--color_hover);
    }

    .card_ingreso--check--icon{
      position: absolute;
      right: 12px;
      transition: right 1s;
      color: var(--color_hover);
    }

    .card_ingreso--check--oculto{
      right: -15px;
    }

    .card_ingreso.clickeado{
      border-color: var(--color_hover);
    }

    .card-img-top{
      max-width: 300px;
    }

    .modal-footer-iv{
      display: flex
    }

    .modal-footer-iv > div{
      flex-basis: 50%;
    }

    #img_tipo_ingreso_elegido{
      width: 50px;
      height: 50px;
    }
    .btn_back_elegir_ingreso{
      padding-left: 1rem;
    }
    .btn_tipo_ingreso_elegido{
      padding: 20px;
      border-radius: 10px;
    }
    .btn_tipo_ingreso_elegido:hover{
      cursor: pointer;
      background-color: #0a7ffb;
      color: #f0f0f0;
    }
/* Fin Container Documentos */
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
                    <h1 class="content-title mb-0 my-auto color-titulo">Ingreso al patio Vehicular</h1>
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn_add_ingreso_vehiculo_patio">
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
                                <div id="div_table_ingreso_vehiculo_patio">

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

<x-administrador.garita.ingreso_vehiculo_patio.modal_elegir_ingreso_vehiculo idModalTipoIngreso="modal_tipo_ingreso" :tipoIngreso="$tipo_ingreso" >
</x-administrador.garita.ingreso_vehiculo_patio.modal_elegir_ingreso_vehiculo>

<!-- Modal agregar configuracion unidades almacenamiento -->
<x-administrador.garita.ingreso_vehiculo_patio.modal_modificar_agregar_ingreso_vehiculo_patio idModalIngresoVehiculoPatio="modal_agregar_ingreso_vehiculo_patio">
</x-administrador.garita.ingreso_vehiculo_patio.modal_modificar_agregar_ingreso_vehiculo_patio>
<!-- Fin Modal agregar configuracion unidades almacenamiento -->

<!-- Modal confirmacion borrar configuracion unidades almacenamiento -->
<x-generico.confirm_delete idModal="modal_confirm_delete_ingreso_vehiculo_patio" idFormModal="form_confirm_delete_ingreso_vehiculo_patio" idDelete="txt_id_delete_ingreso_vehiculo_patio" messageDelete="Esta seguro de eliminar este ingreso al patio vehicular?" idBtnDelete="btn_delete_ingreso_vehiculo_patio">
</x-generico.confirm_delete>
<!-- Fin Modal confirmacion borrar configuracion unidades almacenamiento -->

<!-- INICIO MODAL VISOR PDF  -->
<x-generico.modal_iframe_view idModal="modal_view_pdf" idVisor="iframe_visor_pdf" titulo="Visor Certificado">
</x-generico.modal_iframe_view>
<!-- FIN MODAL VISOR PDF  -->
@endsection

@section('js')
<script type='text/javascript' src='/js/Garita/editar_vehiculo_patio.js'></script>
<script type='text/javascript' src='/js/Garita/ingreso_vehiculo_patio.js'></script>
@endsection