<div class="modal" id="{{$idModalDocumento}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Empresa</h1>
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
                    <input type="hidden" name="e_id" id="id_{{$idModalDocumento}}">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>RUC</strong>
                            <input
                                class="form-control"
                                name="e_ruc"
                                data-label='RUC'
                                id="txt_ruc_{{$idModalDocumento}}"
                                placeholder="Ingresar RUC"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                            <span class="badge bg-danger" data-for="txt_ruc_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>EMPRESA</strong>
                            <input
                                class="form-control"
                                name="nombre_empresa"
                                data-label='Empresa'
                                id="txt_empresa_{{$idModalDocumento}}"
                                placeholder="Ingresar Empresa"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                            <span class="badge bg-danger" data-for="txt_empresa_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>IP</strong>
                            <input
                                class="form-control"
                                name="e_ip"
                                data-label='IP'
                                id="txt_ip_{{$idModalDocumento}}"
                                placeholder="Ingresar IP"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                            <span class="badge bg-danger" data-for="txt_ip_{{$idModalDocumento}}"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_empresa" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>