<div 
    class="modal modal-blur fade show" 
    id="{{$modalConfirm}}" 
    role="dialog" 
    aria-modal="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button
                    aria-label="Close"
                    class="close"
                    data-bs-dismiss="modal"
                    type="button"
                >
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-status bg-success"></div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <label class="form-label">Codigo de autorización</label>
                    <p>Por favor revise su correo institucional el código de autorización</p>
                    <input type="text" class="form-control" id="txt_autorizacion_{{$modalConfirm}}" placeholder="Escriba su código de autorización">
                </div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-success w-100" id="btn_estampar_codigo_{{$modalConfirm}}">
                                Estampar código
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>