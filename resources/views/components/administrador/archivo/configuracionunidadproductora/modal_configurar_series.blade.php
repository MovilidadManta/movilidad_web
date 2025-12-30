<div class="modal" id="modal_configurar_series">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Configurar Series y documentos - <span id="title_modal_configurar_series"></span></h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-configurar_series">
                <input type="hidden" id="unidad_productora_id_modal">
                <div class="accordion" id="acordionSeries"> 
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        
    });
</script>