@extends('Administrador.Layout.app')

@section('css')
<style>
    :root{
        --load-success: #198754;
        --load-waiting: #ffc107;
        --font-refresh:#007bff;
    }
    .card{
        overflow-x: auto;
    }
    .container_agents{
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        min-width: 1200px;
        margin-top: 20px;
    }
    .container_agents_charge{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 60vh;
    }
    .container_agents__headers{
        text-align: center;
        font-weight: bold;
    }
    .container_agents_items__cell{
        margin: auto;
    }
    .container_agents_items__cell--start{
        margin-left: 0;
    }
    .container_agents_items__input{
        font-size: 16px;
        border-radius: 5px;
        height: 100%;
        width: 100%;
        outline: none;
    }
    .container_agents_items__input--success,
    .container_agents_items__input--success:hover,
    .container_agents_items__input--success:focus-visible{
        border: 1.5px solid var(--load-success);
    }
    .container_agents_items__input--waiting,
    .container_agents_items__input--waiting:hover,
    .container_agents_items__input--waiting:focus-visible{
        border: 1.5px solid var(--load-waiting);
    }
    .container_agents_items__container_input{
        position: relative;
    }
    .container_agents_items__charge{
        position: absolute;
        top: 5px;
        right: 7px;
        animation: rotate 2s linear infinite;
    }
    .container_agents_items__charge--success{
        color: var(--load-success);
    }
    .container_agents_items__charge--waiting{
        color: var(--load-waiting);
    }
    .container_agents_items{
        min-height: 60vh;
        max-height: 60vh;
        overflow-y: auto;
        grid-column: span 6;
        display: grid;
        align-content: start;
        grid-template-columns: repeat(6, minmax(min-content, 1fr));
        grid-auto-rows: minmax(45px, auto);
        gap: 15px 10px;
    }
    .container_agetns_buttons_actions{
        display: flex;
        justify-content: start;
        padding: 10px 0;
    }
    .container_agetns_buttons_actions__btn_refresh:hover{
        color: var(--font-refresh);
    }
    .border_dashed{
        border-bottom: 1px dashed #009ee2;
        padding-bottom: 10px;
    }
    .icon_charge {
        font-size: 3em; /* Tamaño del icono */
        color: #007bff; /* Color del icono */
        animation: rotate 2s linear infinite; /* Inicia la animación de rotación */
    }
    .txt_busqueda{
        padding: 0 10px;
    }
    @keyframes rotate {
        0% {
            transform: rotate(0deg); /* Comienza sin rotación */
        }
        100% {
            transform: rotate(360deg); /* Rota 360 grados */
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
                <div class="col-md-12">
                    <h1 class="content-title mb-0 my-auto color-titulo">Configuración de agentes civiles de tránsito</h1>
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
                    <div class="row border_dashed">
                        <div class="col-xs-12 mb-3">
                            <div class="col-xs-12 mt-3">
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                    id="txt_busqueda"
                                    name="txt_busqueda"
                                    class="txt_busqueda"
                                    placeholder="Buscar Agente..." 
                                    aria-label="Buscar Agente..."
                                    style="text-transform: uppercase;"
                                    aria-describedby="btn_buscar_documento">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container_agetns_buttons_actions">
                        <button id="btn_refresh" type="button" class="btn btn-light container_agetns_buttons_actions__btn_refresh"><i class="fa fa-refresh" aria-hidden="true"></i> Refrescar</button>
                    </div>
                    <div id="container_agents_charge" class="container_agents_charge">
                        <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
                    </div>
                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                    <div id="container_agents" class="container_agents" style="display: none;">
                        <p class="container_agents__headers">Código</p>
                        <p class="container_agents__headers">Apelidos y nombres</p>
                        <p class="container_agents__headers">Cédula</p>
                        <p class="container_agents__headers">Dirección</p>
                        <p class="container_agents__headers">Jefatura</p>
                        <p class="container_agents__headers">Cargo</p>
                        <div id="container_agents_items" class="container_agents_items">
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
@endsection

@section('js')
<script type='text/javascript' src='/js/agentes_transito/configuracion_agentes_transito.js'></script>
@endsection