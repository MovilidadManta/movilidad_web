<div class="modal" id="{{$idModalFormulario}}">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Administracion de Proveedores API</h1>
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
                    <input type="hidden" name="id" id="id_{{$idModalFormulario}}">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <strong>RUC</strong>
                            <input
                                class="form-control"
                                name="p_ruc"
                                data-label='RUC'
                                id="txt_ruc_{{$idModalFormulario}}"
                                placeholder="Ingresar RUC"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                            <span class="badge bg-danger" data-for="txt_ruc_{{$idModalFormulario}}"></span>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <strong>EMPRESA</strong>
                            <input
                                class="form-control"
                                name="p_nombre_empresa"
                                data-label='Empresa'
                                id="txt_empresa_{{$idModalFormulario}}"
                                placeholder="Ingresar Empresa"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                            <span class="badge bg-danger" data-for="txt_empresa_{{$idModalFormulario}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>MODULO</strong>
                            <input
                                class="form-control"
                                name="p_modulo"
                                data-label='Módulo'
                                id="txt_modulo_{{$idModalFormulario}}"
                                placeholder="Ingresar Módulo"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                            <span class="badge bg-danger" data-for="txt_modulo_{{$idModalFormulario}}"></span>
                        </div>
                    </div>
                </form>
                <div class="col-xs-12" style="margin-top: 10px;">
                    <a class="btn background-btn-nuevo pad-nu" id="btn_add_proveedor_service">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
                    </a>
                </div>
                <div id="div_table_proveedor_api_service" style="margin-top: 20px;"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_proveedor_api" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>