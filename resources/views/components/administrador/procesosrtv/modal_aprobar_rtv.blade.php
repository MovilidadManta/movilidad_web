<div class="modal" id="{{$idModalFormulario}}">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Aprobar RTV</h1>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input
                    type="hidden"
                    name="csrf-token"
                    value="{{csrf_token()}}"
                    id="csrf_token_{{$idModalFormulario}}"
                >
                <form
                    class="form"
                    novalidate
                    id="form_{{$idModalFormulario}}"
                    method="POST"
                    style="margin-top: 20px;"
                >
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>Clase de Servicio</strong>
                            <input
                                class="form-control"
                                name="clase_servicio"
                                id="txt_clase_servicio_{{$idModalFormulario}}"
                                placeholder="Clase de servicio"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Clase de transporte</strong>
                            <input
                                class="form-control"
                                name="clase_transporte"
                                id="txt_clase_transporte_{{$idModalFormulario}}"
                                placeholder="Clase de transporte"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Tipo de servicio</strong>
                            <input
                                class="form-control"
                                name="tipo_servicio"
                                id="txt_tipo_servicio_{{$idModalFormulario}}"
                                placeholder="Tipo de servicio"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Número de revisión</strong>
                            <input
                                class="form-control"
                                name="numero_revision"
                                id="txt_numero_revision_{{$idModalFormulario}}"
                                placeholder="Número de revisión"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Solicitud</strong>
                            <input
                                class="form-control"
                                name="solicitud"
                                id="txt_solicitud_{{$idModalFormulario}}"
                                placeholder="Solicitud"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Placa</strong>
                            <input
                                class="form-control"
                                name="placa"
                                id="txt_placa_{{$idModalFormulario}}"
                                placeholder="Placa"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Vin</strong>
                            <input
                                class="form-control"
                                name="vin"
                                id="txt_vin_{{$idModalFormulario}}"
                                placeholder="Vin"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Orden Generada</strong>
                            <input
                                class="form-control"
                                id="txt_orden_generada_{{$idModalFormulario}}"
                                placeholder="Orden Generada"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Mensaje Orden</strong>
                            <input
                                class="form-control"
                                id="txt_mensaje_orden_{{$idModalFormulario}}"
                                placeholder="Mensaje Orden"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_aprobar_rtv" type="button"><i class="fa fa-save"></i> Aprobar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>