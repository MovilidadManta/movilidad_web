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
    .no_margin{
        margin: 0;
    }
    .card{
        margin-bottom: 5px;
    }
    .container_doc{
        height: 70vh;
        overflow-y: auto;
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
    .list_container{
        position: relative;
        width: 80%;
        margin: 10px auto;
    }
    .row_list{
        display: flex;
        flex-wrap: wrap;
        position: relative;
    }
    .row_list_col{
        flex-basis: 50%;
        border: 1px dashed var(--border-color);
        margin-bottom: 5px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }
   .configure > .row_list_col{
        border-color: var(--repeat-color);
    }
    .text_list{
        font-weight: bold;
        font-size: 14px;
    }
    .input_list{
        width: 100%;
        padding: 5px;
        border-radius: 5px;
    }
    .configure_table_div.configure{
        background-color: var(--header-green);
        border-radius: 5px;
    }
    .configure_options{
        position: absolute;
        top: 0;
        right: -55px;
        background-color: var(--hover-color-secondary);
        border-radius: 5px;
        opacity: .5;
        font-size: 18px;
        padding: 3px !important;
    }
    .configure_table{
        position: static;
        margin-left: 5px;
        height: fit-content;
    }
    .configure_table > i {
        padding: 0 !important;
    }
    .configure_table_div{
        display: inline-flex;
        justify-items: center;
        align-items: center;
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
    .image_content{
        min-height: 300px;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .paragraph{
        font-size: 18px;
    }
    .table_container {
        display: flex;
        flex-direction: column;
        justify-content: start;
        margin: 20px;
        overflow-x: auto;
        scrollbar-width: thin; /* Ancho de la barra de desplazamiento */
        scrollbar-color: var(--border-color) rgba(0, 0, 0, 0.1); /* Color de la barra de desplazamiento y del track */
    }
    .table_options{
        margin-bottom: 5px;
    }
    .option_table{
        font-size: 14px;
        cursor: pointer;
    }
    .option_table:hover{
        background-color: #0d6efd !important;
        color: white;
    }
    .table {
        display: grid;
        grid-template-columns: repeat(3, 1fr) 60px;
        /*max-width: 800px;*/
        width: 100%;
    }
    .table_franco {
        display: grid;
        grid-template-columns: repeat(3, 1fr) 60px;
        /*max-width: 800px;*/
        width: 100%;
    }
    .header_table {
        background-color: #f4f4f4;
        font-weight: bold;
        text-align: center;
        padding: 10px;
        margin: 0 !important;
        border-radius: 0 !important;
        border: 1px solid #ddd;
    }
    .cell {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .options button {
        margin: 5px;
    }

    .p_border{
        border: 1px dashed #ccc;
        padding-left: 3px;
        padding-right: 3px;
    }
    .max_width_cell{
        max-width: 500px;
    }
    .input_cell{
        min-width: 250px;
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Registrar Orden de cuerpo</h2>
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
                <input type="hidden" name="" value="{{$oc_id}}" id="oc_id">
                <input type="hidden" name="" value="{{$duplicate}}" id="duplicate">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <div id="container_doc" class="card-body container_doc">
                </div>
            </div>
            <div class="row row-sm">
                <div class="col-lg mg-t-3 text-center">
                    <button class="btn btn-warning-gradient" id="btn_volver_orden_cuerpo" type="button"><i class="fa fa-th-list"></i> REGRESAR</button>
                    <button class="btn btn-success-gradient btn-movi" id="btn_guardar_orden_cuerpo" type="button"><i class="fa fa-save"></i> GUARDAR</button>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
<!-- End Row -->
</div>
<!-- Container closed -->
@endsection

@section('js')
<script type='text/javascript' src='/js/agentes_transito/orden_cuerpo/registrar.js'></script>
@endsection