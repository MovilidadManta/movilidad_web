<div class="modal" id="{{$idModalCargarDocumentos}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Ver Documentos</h1>
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
                    id="csrf_token_{{$idModalCargarDocumentos}}"
                >
                <form
                    class="form"
                    novalidate
                    id="form_{{$idModalCargarDocumentos}}"
                    method="POST"
                >
                    <input type="hidden" name="ivp_id" id="id_{{$idModalCargarDocumentos}}">
                    <div id="container_items_documentos_retiro" class="container-cards container-cards--space">
                                            
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_documentos_vehiculo_patio-{{$idModalCargarDocumentos}}" type="button"><i class="fa fa-save"></i> <span id="text_save_ingreso_vehiculo_patio-{{$idModalCargarDocumentos}}">Guardar</span></button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>