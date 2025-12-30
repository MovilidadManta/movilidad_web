<div class="modal" id="modal-destino">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar Destinos</h1>
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
                    id="form-destino-cooperativa"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <input type="hidden" name="txt-id-cooperativa-destino" id="txt-id-cooperativa-destino">
                    <input type="hidden" name="txt-id-destino" id="txt-id-destino">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Destino</strong>
                            <select name="select-destino" id="select-destino" class="form-control">
                                <option value="0">Seleccione Destino</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <strong>Precio</strong>
                            <input
                                class="form-control"
                                name="txt-precio"
                                id="txt-precio"
                                placeholder="Ingresar precio"
                                type="text"
                            >
                        </div>
                        <div class="col-md-2 mg-t-10 mg-lg-t-0 marg-a">
                            <a class="btn background-btn-nuevo pad-nu " id="btn-guardar-destino-cooperativa">
                                <i class="fa fa-plus-square color-btn-nuevo"></i>
                                <strong class="color-btn-nuevo">Añadir</strong>
                            </a>
                        </div>
                        <div class="mg-t-30" id="div-table-destino"></div>
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