<div class="modal" id="modal-causas-medicas">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Causas Medicas</h1>
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
                    id="csrf-token-modal-causas-medicas"
                >
                <form
                    class="form"
                    novalidate
                    id="form-modal-causas-medicas"
                    method="POST"
                >
                    <input type="hidden" name="hidden-id" id="causa-medica-hidden-id">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>Descripción</strong>
                            <input
                                class="form-control"
                                name="txt-descripcion"
                                id="causa-medica-txt-descripcion"
                                placeholder="Ingresar Causa medica"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-causa-medica" type="button"><i class="fa fa-save"></i> <span id="text-save-causas-medicas">Guardar</span></button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>