<div class="modal" id="{{$idModalIngresoVehiculoPatio}}">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Ingreso Vehiculo Patio</h1>
                <button
                    aria-label="Close"
                    class="close"
                    data-bs-dismiss="modal"
                    type="button"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input
                    type="hidden"
                    name="csrf-token"
                    value="{{csrf_token()}}"
                    id="csrf_token_{{$idModalIngresoVehiculoPatio}}"
                >
                <form
                    class="form"
                    novalidate
                    id="form_{{$idModalIngresoVehiculoPatio}}"
                    method="POST"
                >
                    <input type="hidden" name="ivp_id" id="id_{{$idModalIngresoVehiculoPatio}}">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-3">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu ">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li class=""><a href="#tab_datos_generales" class="active"
                                                data-bs-toggle="tab"><i class="fa fa-cube"></i> Datos Generales</a></li>
                                        <li><a href="#tab_inventario_vehiculos" data-bs-toggle="tab"><i
                                                    class="fas fa-car-alt"></i> Inventario del vehículo</a></li>
                                        <li><a href="#tab_documentos_vehiculos" data-bs-toggle="tab"><i
                                                    class="fab fa-wpforms"></i> Documentos Requeridos</a></li>
                                        <li><a href="#tab_responsable_ingreso" data-bs-toggle="tab"><i
                                                    class="fa fa-user"></i> Responsable del Ingreso del vehiculo</a></li>
                                        <li><a href="#tab_input_imagenes" data-bs-toggle="tab"><i
                                                            class="fa fa-window-restore"></i> Evidencias Golpes, Raspones, etc</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_datos_generales">
                                        <x-administrador.garita.ingreso_vehiculo_patio.components_ingreso.datos_generales idModalIngresoVehiculoPatio="{{$idModalIngresoVehiculoPatio}}">
                                        </x-administrador.garita.ingreso_vehiculo_patio.components_ingreso.datos_generales>
                                    </div>
                                    <div class="tab-pane" id="tab_inventario_vehiculos">
                                        <div id="container_items_iventario_vehiculo" class="container_inventario_vehiculo">

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_documentos_vehiculos">
                                        <div id="container_items_documentos_vehiculo" class="container-cards">
                                            
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_responsable_ingreso">
                                        <x-administrador.garita.ingreso_vehiculo_patio.components_ingreso.responsable_ingreso>
                                        </x-administrador.garita.ingreso_vehiculo_patio.components_ingreso.responsable_ingreso>
                                    </div>
                                    <div class="tab-pane" id="tab_input_imagenes">
                                        <x-controls.input_imagenes_multiple idInputImage="evidencia_raspones_golpes" idImagenes="id_evidencia_raspones_golpes" nameImagenes="Imagenes[]">
                                        </x-controls.input_imagenes_multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer-iv">
                <div class="btn_back_elegir_ingreso">
                    <span class="btn_tipo_ingreso_elegido" id="btn_tipo_ingreso_elegido">
                        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                        <img id="img_tipo_ingreso_elegido" src="" alt="">
                        <span id="span_tipo_ingreso_elegido"></span>
                    </span>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success-gradient btn-movi" id="btn_guardar_ingreso_vehiculo_patio-{{$idModalIngresoVehiculoPatio}}" type="button"><i class="fa fa-save"></i> <span id="text_save_ingreso_vehiculo_patio-{{$idModalIngresoVehiculoPatio}}">Guardar</span></button>
                    <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                        <i class="fas fa-times"></i> Salir
                    </button>
                </div>
            </div>
            
        </div>
    </div>
</div>