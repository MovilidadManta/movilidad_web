<div class="modal" id="{{$idModalConfiguracionUnidadesAlmacenamiento}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{$titulo}}</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-{{$idModalConfiguracionUnidadesAlmacenamiento}}">
                <form class="form" novalidate id="{{$idFormModalConfiguracionUnidadesAlmacenamiento}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id-configuracion-unidad-almacenamiento-{{$idModalConfiguracionUnidadesAlmacenamiento}}" name="id">
                    <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                Icono
                            </label>
                            <x-controls.container_multiple_icons 
                                classContainerCards="container-cards"
                                idContainerCards="container_icon-{{$idModalConfiguracionUnidadesAlmacenamiento}}"
                                multipleSelect="false"
                                classCardClick="container_cards_click"
                                classCard="control-card"
                                classCardIcon="control-card__icon"
                                classCardText="control-card__text"
                                classCardActive="control-card_active"
                            >
                            </x-controls.container_multiple_icons>
                            <span class="badge bg-danger" data-for="container_card-{{$idModalConfiguracionUnidadesAlmacenamiento}}"></span>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                TIPO
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_tipo-{{$idModalConfiguracionUnidadesAlmacenamiento}}" 
                                name="txt_tipo" 
                                placeholder="INGRESE EL TIPO DE CONTENEDOR"
                                data-label='Tipo'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_tipo-{{$idModalConfiguracionUnidadesAlmacenamiento}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                CÓDIGO
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_codigo-{{$idModalConfiguracionUnidadesAlmacenamiento}}" 
                                name="txt_codigo" 
                                placeholder="INGRESE EL CÓDIGO DE CONTENEDOR"
                                data-label='Código'
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_codigo-{{$idModalConfiguracionUnidadesAlmacenamiento}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                CAPACIDAD
                            </label>
                            <div class="pos-relative">
                                <textarea class="form-control" 
                                placeholder="INGRESE LA CAPACIDAD DEL CONTENEDOR"
                                data-label='Capacidad'
                                name="txt_capacidad" 
                                id="txt_capacidad-{{$idModalConfiguracionUnidadesAlmacenamiento}}" 
                                rows="3"
                                style="text-transform: uppercase;"
                                ></textarea>
                                <span class="badge bg-danger" data-for="txt_capacidad-{{$idModalConfiguracionUnidadesAlmacenamiento}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                CARATERÍSTICAS
                            </label>
                            <div class="pos-relative">
                                <textarea class="form-control" 
                                placeholder="INGRESE LAS CARACTERÍSTICAS DEL CONTENEDOR"
                                data-label='Características'
                                name="txt_caracteristicas" 
                                id="txt_caracteristicas-{{$idModalConfiguracionUnidadesAlmacenamiento}}" 
                                rows="3"
                                style="text-transform: uppercase;"
                                ></textarea>
                                <span class="badge bg-danger" data-for="txt_caracteristicas-{{$idModalConfiguracionUnidadesAlmacenamiento}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                UNIDADES ASOCIADAS
                            </label>
                            <x-controls.container_multiple_icons 
                                classContainerCards="container-cards"
                                idContainerCards="container_unidades-{{$idModalConfiguracionUnidadesAlmacenamiento}}"
                                multipleSelect="true"
                                classCardClick="container_unidades_click"
                                classCard="control-card"
                                classCardIcon="control-card__icon"
                                classCardText="control-card__text"
                                classCardActive="control-card_active"
                            >
                            </x-controls.container_multiple_icons>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <div style="margin-left: 35px;">
                                    <input class="form-check-input" type="checkbox" id="chk_upload_archive-{{$idModalConfiguracionUnidadesAlmacenamiento}}" name="upload_archive">
                                    <label for="">Subir Archivos: <span id="text-check-upload_archive-{{$idModalConfiguracionUnidadesAlmacenamiento}}">Deshabilitado</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-switch">
                                <div style="margin-left: 35px;">
                                    <input class="form-check-input" type="checkbox" id="chk_estado-{{$idModalConfiguracionUnidadesAlmacenamiento}}" name="check_estado" checked>
                                    <label for="">Estado: <span id="text-check-estado-{{$idModalConfiguracionUnidadesAlmacenamiento}}">Activo</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-configuracion-unidad-almacenamiento-{{$idModalConfiguracionUnidadesAlmacenamiento}}" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let checkEstado = document.getElementById('chk_estado-{{$idModalConfiguracionUnidadesAlmacenamiento}}');
        let checkUploadArchive = document.getElementById('chk_upload_archive-{{$idModalConfiguracionUnidadesAlmacenamiento}}');
        let textCheckEstado = document.getElementById('text-check-estado-{{$idModalConfiguracionUnidadesAlmacenamiento}}');
        let textCheckUploadArchive = document.getElementById('text-check-upload_archive-{{$idModalConfiguracionUnidadesAlmacenamiento}}');
        checkEstado.addEventListener('change', (e)=>{
            textCheckEstado.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstado.innerHTML = "Activo";
        });

        checkUploadArchive.addEventListener('change', (e)=>{
            textCheckUploadArchive.innerHTML = "Deshabilitado";
            if(e.target.checked)
            textCheckUploadArchive.innerHTML = "Habilitado";
        });
    });
</script>