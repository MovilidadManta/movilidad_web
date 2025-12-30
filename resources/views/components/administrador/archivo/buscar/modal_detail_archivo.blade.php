<div class="modal" id="{{$idModalDetalleArchivo}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Detalle de Archivo</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                    <div class="form-group">
                        <label class="main-content-label tx-medium tx-gray-600">
                            BODEGA
                        </label>
                        <p id="{{$idModalDetalleArchivo}}_bodega"></p>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-medium tx-gray-600">
                            UNIDAD PRODUCTORA
                        </label>
                        <p id="{{$idModalDetalleArchivo}}_unidad_productora"></p>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-medium tx-gray-600">
                            SERIE
                        </label>
                        <p id="{{$idModalDetalleArchivo}}_serie"></p>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-medium tx-gray-600">
                            TIPO DE DOCUMENTO
                        </label>
                        <p id="{{$idModalDetalleArchivo}}_documento"></p>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-medium tx-gray-600">
                            CODIGO DE DOCUMENTO
                        </label>
                        <p id="{{$idModalDetalleArchivo}}_codigo_documento"></p>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-medium tx-gray-600">
                            NOMBRE DE DOCUMENTO
                        </label>
                        <p id="{{$idModalDetalleArchivo}}_nombre_documento"></p>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-medium tx-gray-600">
                            CAMPOS
                        </label>
                        <p class="white_space" id="{{$idModalDetalleArchivo}}_campos"></p>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-medium tx-gray-600">
                            NÚMERO DE FOLIOS
                        </label>
                        <p id="{{$idModalDetalleArchivo}}_nro_folio"></p>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-medium tx-gray-600">
                            COMENTARIO
                        </label>
                        <p id="{{$idModalDetalleArchivo}}_comentario"></p>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-medium tx-gray-600">
                            UBICACIÓN
                        </label>
                        <p class="white_space" id="{{$idModalDetalleArchivo}}_ubicacion"></p>
                        <span class="center_ubicacion">
                            <a id="{{$idModalDetalleArchivo}}_link" href="" class="tam-btn btn btn-info btn-modal-editar tooltip" target="_blank"><span class="tooltiptext">Ver en Sistema de Archivo</span><i class="fa fa-sign-in tam-icono"></i></a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>