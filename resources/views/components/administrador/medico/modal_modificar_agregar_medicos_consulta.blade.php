<div class="modal" id="modal-medicos-consulta">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Médicos</h1>
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
                    id="csrf-token-modal-medicos-consulta"
                >
                <form
                    class="form"
                    novalidate
                    id="form-modal-medicos-consulta"
                    method="POST"
                >
                    <input type="hidden" name="hidden-id" id="medico-consulta-hidden-id">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>Cédula</strong>
                            <input
                                class="form-control"
                                name="txt-cedula"
                                id="medico-consulta-txt-cedula"
                                placeholder="Ingresar Cédula"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Apellidos</strong>
                            <input
                                class="form-control"
                                name="txt-apellidos"
                                id="medico-consulta-txt-apellidos"
                                placeholder="Ingresar Apellidos"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Nombres</strong>
                            <input
                                class="form-control"
                                name="txt-nombres"
                                id="medico-consulta-txt-nombres"
                                placeholder="Ingresar Nombres"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                        <div class="col-xs-12">
                            <strong>Sexo</strong>
                            <select name="select-sexo" id="medico-consulta-select-sexo" class="form-control">
                                <option value="I">Indeterminado</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <div class="col-xs-12">
                            <strong>Centro Médico</strong>
                            <input
                                class="form-control"
                                name="txt-centro_medico"
                                id="medico-consulta-txt-centro_medico"
                                placeholder="Ingresar Centro Médico"
                                type="text"
                                style="text-transform: uppercase;"
                            >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-medico-consulta" type="button"><i class="fa fa-save"></i> <span id="text-save-medico-consulta">Guardar</span></button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        set_type_input('medico-consulta-txt-cedula', 'number');
    });
</script>
