<div class="modal" id="{{$idModalContenedor}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">{{$titulo}}</h1><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-{{$idModalContenedor}}">
                <form class="form" novalidate id="{{$idFormModalContenedor}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id-contenedor-{{$idModalContenedor}}">
                    <div class="row">
                        <div class="col-md-12 mg-t-10">
                            <strong>Tipo</strong>
                            <input class="form-control" name="txt-tipo" id="txt-tipo-{{$idModalContenedor}}" placeholder="Digite el Tipo del Contenedor"
                                type="text" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Alias</strong>
                            <input class="form-control" name="txt-letra" id="txt-letra-{{$idModalContenedor}}" placeholder="Digite el Alias del Contenedor"
                                type="text" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Numeración</strong>
                            <input class="form-control" name="txt-numeracion" id="txt-numeracion-{{$idModalContenedor}}" placeholder="Digite la númeracion del Contenedor"
                                type="text" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <div class="form-check form-switch">
                                <div style="margin-left: 35px;">
                                    <input class="form-check-input" type="checkbox" id="chk_estado-{{$idModalContenedor}}" name="check_estado" checked>
                                    <label for="">Estado: <span id="text-check-estado-{{$idModalContenedor}}">Activo</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-contenedor-{{$idModalContenedor}}" type="button"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let checkEstado = document.getElementById('chk_estado-{{$idModalContenedor}}');
        let textCheckEstado = document.getElementById('text-check-estado-{{$idModalContenedor}}');
        checkEstado.addEventListener('change', (e)=>{
            textCheckEstado.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstado.innerHTML = "Activo";
        });
    });
</script>