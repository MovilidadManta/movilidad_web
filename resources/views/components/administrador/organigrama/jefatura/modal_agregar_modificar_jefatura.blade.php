<div class="modal" id="{{$idModalJefatura}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">{{$titulo}}</h1><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-{{$idModalJefatura}}">
                <form class="form" novalidate id="{{$idFormModalJefatura}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id-jefatura-{{$idModalJefatura}}">
                    <div class="row">
                        <div class="col-md-12 mg-t-10">
                            <strong>Dirección</strong>
                            <select name="select-direccion" id="select-direccion-{{$idModalJefatura}}" class="form-control">
                                <option value='0'>Seleccione una dirección</option>
                            </select>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Perfil</strong>
                            <input class="form-control" name="txt-perfil" id="txt-perfil-{{$idModalJefatura}}" name="txt-perfil" placeholder="Ingresar Perfil"
                                type="text" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Estado Dirección</strong>
                            <select name="select-estado-direccion" id="select-estado-direccion-{{$idModalJefatura}}" class="form-control">
                                <option value='-1'>Seleccione una dirección</option>
                                <option value='1'>Con Dirección</option>
                                <option value='0'>Sin Dirección</option>
                            </select>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <div class="form-check form-switch">
                                <div style="margin-left: 35px;">
                                    <input class="form-check-input" type="checkbox" id="chk_jefatura-{{$idModalJefatura}}" name="check_jefatura" checked>
                                    <label for="">Estado: <span id="text-check-jefatura-{{$idModalJefatura}}">Activo</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-jefatura-{{$idModalJefatura}}" type="button"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let checkEstado = document.getElementById('chk_jefatura-{{$idModalJefatura}}');
        let textCheckEstado = document.getElementById('text-check-jefatura-{{$idModalJefatura}}');
        checkEstado.addEventListener('change', (e)=>{
            textCheckEstado.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstado.innerHTML = "Activo";
        });
    });
</script>