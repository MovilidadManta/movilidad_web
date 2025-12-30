<div class="modal" id="{{$idModalDocumento}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Peticiones</h1>
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
                    id="csrf_token_{{$idModalDocumento}}"
                >
                <form
                    class="form"
                    novalidate
                    id="form_{{$idModalDocumento}}"
                    method="POST"
                >
                    <input type="hidden" name="id" id="id_{{$idModalDocumento}}">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>SERVICIO</strong>
                            <select name="ps_id" id="select_ps_id_{{$idModalDocumento}}" class="form-control">
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <strong>PETICION</strong>
                            <input
                                class="form-control"
                                name="txt_peticion"
                                data-label='Petición'
                                id="txt_peticion_{{$idModalDocumento}}"
                                placeholder="Ingresar Petición"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                            <span class="badge bg-danger" data-for="txt_peticion_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>Verbo API</strong>
                            <select name="select_verb_send" id="select_verb_send_{{$idModalDocumento}}" class="form-control">
                                <option value="1">GET</option>
                                <option value="2">POST</option>
                                <option value="3">PUT</option>
                                <option value="4">DELETE</option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <strong>Request</strong>
                            <textarea class="form-control"
                                data-label='Request'
                                placeholder="INGRESE REQUEST"
                                name="txt_request"
                                id="txt_request_{{$idModalDocumento}}"
                                rows="3"
                            ></textarea>
                            <span class="badge bg-danger" data-for="txt_request_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>Request API</strong>
                            <textarea class="form-control"
                                data-label='Request API'
                                placeholder="INGRESE REQUEST API"
                                name="txt_request_api"
                                id="txt_request_api_{{$idModalDocumento}}"
                                rows="3"
                            ></textarea>
                            <span class="badge bg-danger" data-for="txt_request_api_{{$idModalDocumento}}"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_peticion" type="button"><i class="fa fa-save"></i> <span id="text_save_peticion">Guardar</span></button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>