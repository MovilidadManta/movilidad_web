<div class="modal" id="{{$idModalDireccion}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">{{$titulo}}</h1><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-{{$idModalDireccion}}">
                <form class="form" novalidate id="{{$idFormModalDireccion}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id-departamento-{{$idModalDireccion}}">
                    <div class="row">
                        <div class="col-md-12 mg-t-10">
                            <strong>Departamento</strong>
                            <input class="form-control" name="txt-departamento-{{$idModalDireccion}}" id="txt-departamento-{{$idModalDireccion}}" name="txt-departamento" placeholder="Ingresar Departamento"
                                type="text" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <div class="form-check form-switch">
                                <div style="margin-left: 35px;">
                                    <input class="form-check-input" type="checkbox" id="chk_departamento-{{$idModalDireccion}}" name="check_departamento" checked>
                                    <label for="">Estado: <span id="text-check-departamento-{{$idModalDireccion}}">Activo</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-departamento-{{$idModalDireccion}}" type="button"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let checkEstado = document.getElementById('chk_departamento-{{$idModalDireccion}}');
        let textCheckEstado = document.getElementById('text-check-departamento-{{$idModalDireccion}}');
        checkEstado.addEventListener('change', (e)=>{
            textCheckEstado.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstado.innerHTML = "Activo";
        });
    });
</script>