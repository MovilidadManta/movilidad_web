<div class="modal" id="modal-diagnosticos-medicos">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Diagnosticos Medicos</h1>
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
                    id="csrf-token-modal-diagnostico-medico"
                >
                <form
                    class="form"
                    novalidate
                    id="form-modal-diagnostico-medico"
                    method="POST"
                >
                    <input type="hidden" name="hidden-id" id="diagnostico-medico-hidden-id">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>CIE 10</strong>
                            <input
                                class="form-control"
                                name="txt-cie10"
                                id="diagnostico-medico-txt-cie10"
                                placeholder="Ingresar CIE10"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Descripción</strong>
                            <input
                                class="form-control"
                                name="txt-descripcion"
                                id="diagnostico-medico-txt-descripcion"
                                placeholder="Ingresar descripción diagnostico"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12 mg-t-10">
                            <div class="form-check form-switch" style="padding-left: 35px;">
                                <input class="form-check-input" type="checkbox" value="SI" name="check-requiere-cie10" id="diagnostico-medico-rb-requiere-cie10">
                                <label class="form-check-label" for="diagnostico-medico-rb-requiere-cie10">Es requerido CIE10</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-diagnostico-medico" type="button"><i class="fa fa-save"></i> <span id="text-save-diagnostico-medico">Guardar</span></button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>