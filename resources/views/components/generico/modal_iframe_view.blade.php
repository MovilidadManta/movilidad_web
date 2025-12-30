<div class="modal" id="{{$idModal}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">{{$titulo}}</h1>
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
                <iframe id="{{$idVisor}}" src="" style="width: 100%; height: 70vh;"></iframe>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-abrir-{{$idModal}}" type="button">
                    <i class="fa fa-eye"></i> Abrir en nueva pestaña
                </button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("load", function (event) {
        let btnOpenLink = document.getElementById('btn-abrir-{{$idModal}}');
        btnOpenLink.addEventListener('click', (e) => {
            let iframe = document.getElementById('{{$idVisor}}');
            window.open(iframe.src, '_blank');
        });
    });
</script>