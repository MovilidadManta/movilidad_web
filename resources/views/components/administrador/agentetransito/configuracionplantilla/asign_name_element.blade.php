<div class="modal" id="{{$idModalAsignNameElement}}">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Asignar nombre a elemento</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            NOMBRE DE ELEMENTO
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="txt_name-{{$idModalAsignNameElement}}" 
                            name="txt_text" 
                            placeholder="INGRESE EL TEXTO PARA EL ELEMENTO"
                            data-label='Texto'>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_nombre-{{$idModalAsignNameElement}}" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>