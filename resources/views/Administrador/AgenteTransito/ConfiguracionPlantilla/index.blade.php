@extends('Administrador.Layout.app')

@section('css')
<style>
    :root{
        --repeat-color:#198754;
        --header-green: #E2EFDA;
        --border-color:#007bff;
        --hover-color: #007bff;
        --header-yellow: #0F4C88;
        --header-blue: #00AFEF;
        --hover-blue: #00AFEF;
        --hover-color-secondary: #B0AAD280 ;
    }
    body{
        position: relative;
    }
    .creator_container{
        display: grid;
        height: 60vh;
        grid-template-columns: 1fr 4fr;
    }
    .creator_sidebar{
        border-right: 1px dashed var(--border-color);
        padding-right: 5px;
    }
    .creator_content_option{
        padding: 10px;
        text-align: center;
        font-size: 16px;
        border: 1px solid #222;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 5px;
    }
    .creator_content_option:hover{
        border-color: var(--hover-color);
        color: var(--hover-color);
        -webkit-user-select: none; /* Safari */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Standard */
    }
    .creator_content{
        position: relative;
        overflow-y: auto;
    }
    .creator_content.preview {
        background-color: rgba(0, 128, 0, 0.2);
    }

    .dragging {
        position: absolute;
        pointer-events: none;
        opacity: 0.7;
        z-index: 1000;
    }
    .dropzone{
        min-height: 200px;
    }
    .preview {
        height: 100px;
        background-color: rgba(0, 128, 0, 0.2);
        border: 2px dashed green;
        margin: 10px 0;
    }

    .box-content{
        position: relative;
        padding: 25px 15px;
        border: 1px dashed var(--border-color); 
    }
    .box-options{
        position: absolute;
        top: 1px;
        right: 35px;
        padding: 10px;
        background-color: #B0AAD2 ;
        border-radius: 5px;
    }
    .box-options-icon{
        padding: 3px;
        opacity: .7;
    }
    .box-options-icon:hover{
        opacity: 1;
        cursor: pointer;
    }
    .box_move{
        position: absolute;
        top: 0;
        opacity: .7;
    }
    .box_move--left{
        left: 0;
    }
    .box_move--right{
        right: 0;
    }
    .box_move:hover{
        opacity: 1;
        cursor: pointer;
    }
    .paragraph{
        font-size: 16px;
    }

    .list_container{
        position: relative;
        width: 80%;
        margin: 10px auto;
    }
    .row_list{
        display: flex;
        flex-wrap: wrap;
    }
    .row_list_col{
        flex-basis: 50%;
        margin-bottom: 5px;
    }
    .configure,
    .added{
        position: relative;
    }
    .configure > .row_list_col,
    .added > .row_list_col{
        border: 1px dashed var(--border-color);
        padding: 5px;
        text-align: center;
    }
    .configure > .row_list_col.empty:hover{
        background-color: var(--hover-color);
        cursor: pointer;
        color: white;
    }

    .configure_options{
        position: absolute;
        top: 0;
        right: -55px;
        background-color: var(--hover-color-secondary);
        border-radius: 5px;
        opacity: .5;
        font-size: 18px;
        padding: 3px;
    }
    .configure_options:hover{
        opacity: 1;
    }

    .configure_options i{
        margin-right: 5px;
    }

    .configure_options i:hover{
        color: var(--hover-color);
        cursor: pointer;
    }
    .icons_actions{
        display: flex;
        flex-wrap: wrap;
    }
    .icons_actions_icon{
        display: grid;
        flex-direction: column;
        justify-content: center;
        align-content: space-around;
        flex-basis: 80px;
        height: 80px;
        border: 1px solid #222;
        text-align: center;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 5px;
    }
    .icons_actions_icon.active,
    .icons_actions_icon:hover{
        color: var(--hover-color);
        border-color: var(--hover-color);
    }

    .no_margin{
        margin: 0;
    }

    .search_choose{
        margin-bottom: 5px;
    }

    .option_choose:hover{
        cursor: pointer;
    }

    .option_choose:hover,
    .option_choose.active{
        background-color: var(--hover-color) !important;
    }
    .repeat_color{
        color: var(--repeat-color);
    }

    .container_elements{
        border: 1px solid var(--border-color);
        min-height: 150px;
    }
    .container_elements_header{
        border: 1px solid var(--border-color);
        padding: 10px;
        position: relative;
    }
    .container_elements_header_text{
        font-size: 18px;
    }
    .table_options_container{
        margin-bottom: 20px;
    }
    .table_options_container_button{
        cursor: pointer;
        margin-right: 5px;
    }
    .table_options_container_button.active,
    .table_options_container_button:hover{
        background-color: var(--hover-blue) !important;
    }
    .table_options_container_option{
        font-size: 11px;
    }
    .table_container{
        display: block;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
        overflow-x: auto;
    }
    .table_container > table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed; /* Distribuye las columnas proporcionalmente */
    }
    .table_container > table th, 
    .table_container > table td {
        padding: 8px;
        border: 1px solid #000;
        white-space: nowrap; /* Para que el contenido no se quiebre en varias líneas */
        overflow: hidden; /* Para evitar que el contenido se desborde */
        text-overflow: ellipsis; /* Añade "..." al final del contenido si es demasiado largo */
    }
    .table_container > table th[data-col]{
        position: relative;
    }
    .table_container > table td[data-row]{
        position: relative;
    }
    .table_container > table th.fixed100, 
    .table_container > table td.fixed100 {
            width: 100px; /* Ancho fijo para las columnas que no deben expandirse */
    }    
    .table_container > table th.expand, 
    .table_container > table td.expand {
        width: auto; /* Ocupa el espacio disponible */
    }
    .configure_row{
        position: relative;
    }
    .configure_row > td[data-col]:hover{
        background-color: var(--hover-color);
        color: white;
        cursor: pointer;
    }
    .configure_row > td[data-col]:hover{
        background-color: var(--hover-color);
        color: white;
        cursor: pointer;
    }
    .configure_row > td.row_actions{

    }
    .col_actions,
    .row_actions,
    .row_action{
        text-align: center;
    }
    .row_actions > i,
    .row_action > i{
        cursor: pointer;
    }

    .image_content{
        border: 1px dashed #737f9e;
        min-height: 200px;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        position: relative;
    }
    .image_content:not(.loaded):hover{
        cursor: pointer;
    }
    .image_content:hover{
        border: 1px dashed var(--border-color);
        color: var(--border-color);
    }
    .image_content_img{
        font-size: 24px;
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

    .btn_delete_img:hover{
        cursor: pointer;
    }

    .btn_delete_image--icon{
        font-size: 32px;
    }
    .form_actions{
        margin-bottom: 10px;
        display: flex;
        justify-content: end;
    }
    .form_actions > *{
        flex-grow: 0;
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
                <div class="col-md-12">
                    <h1 class="content-title mb-0 my-auto color-titulo">Configuración de plantilla</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="form_actions">
                <button type="button" id="save_plantilla" class="btn btn-primary">
                   <i class="fa fa-save"></i> Guardar
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                    <div class="creator_container">
                        <div class="creator_sidebar">
                            <div class="creator_content_option drag_item draggable" data-content="title">
                                <i class="fa fa-header"></i> TÍTULO
                            </div>
                            <div class="creator_content_option drag_item draggable" data-content="paragraph">
                                <i class="fa fa-paragraph"></i> PÁRRAFO
                            </div>
                            <div class="creator_content_option drag_item draggable" data-content="container">
                                <i class="fa fa-columns"></i> CONTENEDOR
                            </div>
                            <div class="creator_content_option drag_item draggable" data-content="list">
                                <i class="fa fa-list"></i> LISTA
                            </div>
                            <div class="creator_content_option drag_item draggable" data-content="table">
                                <i class="fa fa-table"></i> TABLA
                            </div>
                            <div class="creator_content_option drag_item draggable" data-content="table_total">
                                <i class="fa fa-table"></i> TOTAL
                            </div>
                            <div class="creator_content_option drag_item draggable" data-content="table_franco">
                                <i class="fa fa-table"></i> P. FRANCO
                            </div>
                            <div class="creator_content_option drag_item draggable" data-content="image">
                                <i class="fa fa-picture-o"></i> IMAGEN
                            </div>
                        </div>
                        <div id="content_plantilla" class="creator_content dropzone">
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

<!-- Modal Configuracion de campo -->
<x-administrador.agentetransito.configuracionplantilla.modal_add_values_campos titulo="Configuración de campo" idModalConfiguracionCampos="modal_configurar_campo">
</x-administrador.agentetransito.configuracionplantilla.modal_add_values_campos>
<!-- Fin Modal Configuracion de campo -->

<!-- Modal Configuracion de nombre de elemento -->
<x-administrador.agentetransito.configuracionplantilla.asign_name_element idModalAsignNameElement="modal_asign_name_element">
</x-administrador.agentetransito.configuracionplantilla.asign_name_element>
<!-- Fin Modal Configuracion de nombre de elemento -->
@endsection

@section('js')
<script type='text/javascript' src='/js/agentes_transito/plantilla/container_plantilla.js'></script>
<script type='text/javascript' src='/js/agentes_transito/plantilla/elements_from_plantilla.js'></script>
<script type='text/javascript' src='/js/agentes_transito/configuracion_plantilla.js'></script>
@endsection