<div class="modal" id="{{$idModalEvento}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{$titulo}}</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-{{$idModalEvento}}">
                <form class="form" novalidate id="{{$idFormModalEvento}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id-evento-{{$idModalEvento}}">
                    <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                TITULO
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="ip_titulo-{{$idModalEvento}}" name="ip_titulo" placeholder="INGRESE EL TÍTULO">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                EVENTO
                            </label>
                            <div class="pos-relative">
                                <textarea class="form-control" placeholder="Ingrese información del evento" name="ip_contenido" id="ip_contenido-{{$idModalEvento}}" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                        FECHA INICIO
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                        <input class="form-control" name="ip_fini" id="ip_fini-{{$idModalEvento}}" type="date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                        FECHA CADUCA
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                        </div>
                                        <input class="form-control" name="ip_ffin" id="ip_ffin-{{$idModalEvento}}" type="date">
                                    </div>
                                </div>
                            </div>
    
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                IMAGEN (jpg;jpeg)
                            </label>
                            <input type="file" class="dropify" name="txt-ruta-foto" id="txt-ruta-foto-{{$idModalEvento}}" accept="image/jpeg" data-max-file-size="3M" />
                            <div id="div_imagen_cargada-{{$idModalEvento}}" style="display: none; text-align:center; margin-top:10px;">
                                <img id="imagen_cargada-{{$idModalEvento}}" src="" alt="Imagen Previa" style="max-height: 200px;" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                TIPO DE EVENTO
                            </label>
                            <select class="form-control" id="select-tipo-{{$idModalEvento}}" name="select-tipo">
                                <option value="S">Seleccione el destino</option>
                                <option value="0">Evento en Transito</option>
                                <option value="1">Evento en Terminal</option>
                                <option value="2">Evento en Intranet</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <div style="margin-left: 35px;">
                                    <input class="form-check-input" type="checkbox" id="chk_estado-{{$idModalEvento}}" name="check_estado" checked>
                                    <label for="">Estado: <span id="text-check-estado-{{$idModalEvento}}">Activo</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-evento-{{$idModalEvento}}" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let checkEstado = document.getElementById('chk_estado-{{$idModalEvento}}');
        let textCheckEstado = document.getElementById('text-check-estado-{{$idModalEvento}}');
        checkEstado.addEventListener('change', (e)=>{
            textCheckEstado.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstado.innerHTML = "Activo";
        });
    });
</script>