<div class="modal" id="modal-destino-horario">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar Frecuencias</h1>
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
                    id="csrf-token"
                >
                <form
                    class="form"
                    novalidate
                    id="form-destino-cooperativa-horario"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <input type="hidden" name="txt-id-destino-horario" id="txt-id-destino-horario">
                    <input type="hidden" name="txt-id-horario-destino" id="txt-id-horario-destino">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Frecuencia</strong>
                            <input
                                class="form-control"
                                name="txt-frecuencia"
                                id="txt-frecuencia"
                                placeholder="Ingresar frecuencia"
                                type="time"
                            >
                        </div>
                        <div class="col-md-8 mg-t-10 mg-lg-t-0 marg-a">
                            <a class="btn background-btn-nuevo pad-nu " id="btn-guardar-horario-destino-cooperativa">
                                <i class="fa fa-plus-square color-btn-nuevo"></i>
                                <strong class="color-btn-nuevo">Añadir</strong>
                            </a>
                        </div>
                        <div class="mg-t-30" id="div-table-horario-destino"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <!--<button class="btn btn-success-gradient btn-movi" id="btn-guardar-destino" type="button"><i class="fa fa-save"></i> Guardar</button>-->
                    <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                        <i class="fas fa-times"></i> Salir
                    </button>
                </div>
            </div>
        </div>
    </div>