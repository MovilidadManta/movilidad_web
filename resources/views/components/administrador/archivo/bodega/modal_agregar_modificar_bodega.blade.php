<div class="modal" id="{{$idModalBodega}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">{{$titulo}}</h1><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-{{$idModalBodega}}">
                <form class="form" novalidate id="{{$idFormModalBodega}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id-bodega-{{$idModalBodega}}">
                    <div class="row">
                        <div class="col-md-12 mg-t-10">
                            <strong>Empresa</strong>
                            <select name="select-empresa" id="select-empresa-{{$idModalBodega}}" class="form-control">
                                <option value='0'>Seleccione una Empresa</option>
                            </select>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Archivo</strong>
                            <input class="form-control" name="txt-archivo" id="txt-archivo-{{$idModalBodega}}" placeholder="Digite el nombre de archivo"
                                type="text" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Ubicación</strong>
                            <input class="form-control" name="txt-ubicacion" id="txt-ubicacion-{{$idModalBodega}}" placeholder="Digite el nombre de la ubicación"
                                type="text" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <div class="form-check form-switch">
                                <div style="margin-left: 35px;">
                                    <input class="form-check-input" type="checkbox" id="chk_estado-{{$idModalBodega}}" name="check_estado" checked>
                                    <label for="">Estado: <span id="text-check-estado-{{$idModalBodega}}">Activo</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-bodega-{{$idModalBodega}}" type="button"><i
                        class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let checkEstado = document.getElementById('chk_estado-{{$idModalBodega}}');
        let textCheckEstado = document.getElementById('text-check-estado-{{$idModalBodega}}');
        checkEstado.addEventListener('change', (e)=>{
            textCheckEstado.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstado.innerHTML = "Activo";
        });
    });
</script>