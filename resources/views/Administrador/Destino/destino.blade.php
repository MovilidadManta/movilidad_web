@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.41.0/mapbox-gl.css' rel='stylesheet' />
<link href="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.css" rel="stylesheet">
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestion de Destinos</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-destino">
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
                                <div id="div-table-destino"></div>
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

<!-- INICIO MODAL AÑADIR DESTINOS -->
<div class="modal" id="modal-destino">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar Destinos</h1><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-destino" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Destino</strong>
                            <input class="form-control" name="txt-destino" id="txt-destino" placeholder="Ingresar lugar de salida" type="text">
                        </div>

                        <div class="col-md-6 ">
                            <strong>Estado</strong>
                            <select name="select-estado" id="select-estado" class="form-control">
                                <option value="0">Seleccione Estado</option>
                                <option value="A">Activo</option>
                                <option value="I">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-6 mg-t-10">
                            <strong>Latitud</strong>
                            <input class="form-control" name="txt-latitud" id="txt-latitud" placeholder="Ingresar Latitud" type="text">
                        </div>

                        <div class="col-md-6 mg-t-10">
                            <strong>Longitud</strong>
                            <input class="form-control" name="txt-longitud" id="txt-longitud" placeholder="Ingresar Longitud" type="text">
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Observación</strong>
                            <input class="form-control" name="txt-observacion" id="txt-observacion" placeholder="Ingresar observación" type="text">
                        </div>
                    </div>
                    <div id="map"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-destino" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR DESTINOS -->

<!--INICIO MODAL ELIMINAR DESTINOS -->
<div class="modal show" id="modal-destino-e" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-destino-e" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-destino" name="txt-id-destino">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar la destino</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-destino" type="button"><i class="fa fa-delete"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR DESTINOS -->

<!-- INICIO MODAL MODIFICAR DESTINOS -->
<div class="modal" id="modal-destino-m">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Modificar Destinos</h1><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-destino-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-destino-m" id="txt-id-destino-m">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Destino</strong>
                            <input class="form-control" name="txt-destino-m" id="txt-destino-m" placeholder="Ingresar lugar de salida" type="text">
                        </div>

                        <div class="col-md-6 ">
                            <strong>Estado</strong>
                            <select name="select-estado-m" id="select-estado-m" class="form-control">
                                <option value="0">Seleccione Estado</option>
                                <option value="A">Activo</option>
                                <option value="I">Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-6 mg-t-10">
                            <strong>Latitud</strong>
                            <input class="form-control" name="txt-latitud-m" id="txt-latitud-m" placeholder="Ingresar Latitud" type="text">
                        </div>

                        <div class="col-md-6 mg-t-10">
                            <strong>Longitud</strong>
                            <input class="form-control" name="txt-longitud-m" id="txt-longitud-m" placeholder="Ingresar Longitud" type="text">
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <strong>Observación</strong>
                            <input class="form-control" name="txt-observacion-m" id="txt-observacion-m" placeholder="Ingresar observación" type="text">
                        </div>
                    </div>
                    <div id="map"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-destino" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR DESTINOS -->

@endsection

@section('js')
<!-- Mapa box-->
<script src="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.js"></script>
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.41.0/mapbox-gl.js'></script>
<script type='text/javascript' src='/js/Destino/destino.js'></script>
<script>
    // TO MAKE THE MAP APPEAR YOU MUST
    // ADD YOUR ACCESS TOKEN FROM
    // https://account.mapbox.com
    mapboxgl.accessToken = 'pk.eyJ1IjoiamhvbnkyNyIsImEiOiJjajQ0ZDBrc3kwMHVrMzN1YnAybGMzY2pxIn0.m6oCm21xzIXCVTHN9d7stA';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-79.4512, 43.6568],
        zoom: 13
    });

    // Add the control to the map.
    map.addControl(
        new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        })
    );
</script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif