<div class="modal" id="{{$idModalDocumento}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Servicios</h1>
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
                    <input type="hidden" name="ps_id" id="ps_id_{{$idModalDocumento}}">
                    <input type="hidden" name="cont_action" id="cont_{{$idModalDocumento}}">
                    <input type="hidden" id="ps_action_{{$idModalDocumento}}">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>Tipo API</strong>
                            <select name="select_format_api" id="select_format_api_{{$idModalDocumento}}" class="form-control">
                                <option value="1">SOAP</option>
                                <option value="2">API</option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <strong>NOMBRE</strong>
                            <input
                                class="form-control"
                                name="ps_name"
                                data-label='NOMBRE'
                                id="txt_name_{{$idModalDocumento}}"
                                placeholder="Ingresar Nombre"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                            <span class="badge bg-danger" data-for="txt_name_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>URL</strong>
                            <input
                                class="form-control"
                                name="txt_url"
                                data-label='URL'
                                id="txt_url_{{$idModalDocumento}}"
                                placeholder="Ingresar Petición"
                                type="text"
                            >
                            <span class="badge bg-danger" data-for="txt_url_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>Headers</strong>
                            <textarea class="form-control"
                                data-label='Headers'
                                placeholder="INGRESE HEADERS"
                                name="txt_headers"
                                id="txt_headers_{{$idModalDocumento}}"
                                rows="3"
                            ></textarea>
                            <span class="badge bg-danger" data-for="txt_headers_{{$idModalDocumento}}"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_proveedor_servicio" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>