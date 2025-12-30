<div class="modal" id="{{$idModalUnidadAlmacenamiento}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{$titulo}}</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div id="body_medio_almacenamiento-{{$idModalUnidadAlmacenamiento}}" class="modal-body" style="display: none;">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-{{$idModalUnidadAlmacenamiento}}">
                <form class="form" novalidate id="{{$idFormModalUnidadAlmacenamiento}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id_unidad_almacenamiento-{{$idModalUnidadAlmacenamiento}}" name="id">
                    <input type="hidden" id="id_configuracion_unidad_almacenamiento-{{$idModalUnidadAlmacenamiento}}" name="cma_id">
                    <input type="hidden" id="ma_id_padre-{{$idModalUnidadAlmacenamiento}}" name="ma_id_padre">
                    <input type="hidden" name="id_bodega" id="id_bodega-{{$idModalUnidadAlmacenamiento}}" value="{{$idBodega}}">
                    <input type="hidden" name="accion" id="accion-{{$idModalUnidadAlmacenamiento}}" value="AGREGAR">
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    Imagen
                                </label>
                                <input type="file" id="imagen-{{$idModalUnidadAlmacenamiento}}" name="file_imagen" accept="image/*" style="display: none;">
                                <div id="img_preview-{{$idModalUnidadAlmacenamiento}}" class="img_preview">
                                    <i class="img_preview--icon fa fa-upload" aria-hidden="true"></i>
                                    <p class="img_preview--text">Subir Imagen</p>
                                    <span id="btn_delete_image-{{$idModalUnidadAlmacenamiento}}" style="display: none;" class="btn_delete_img">
                                        <i class="btn_delete_image--icon fa fa-trash"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-8">
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    Unidad Productora
                                </label>
                                <select name="cup_id" id="cup_id-{{$idModalUnidadAlmacenamiento}}" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    Unidad Productora Serie
                                </label>
                                <select name="cups_id" id="cups_id-{{$idModalUnidadAlmacenamiento}}" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    Documento
                                </label>
                                <select name="cd_id" id="cd_id-{{$idModalUnidadAlmacenamiento}}" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="alert alert-primary" role="alert">
                            <p>CAPACIDAD: <span id="capacidad-{{$idModalUnidadAlmacenamiento}}"></span></p>
                            <p>CARACTERÍSTICAS: <span id="caracteristicas-{{$idModalUnidadAlmacenamiento}}"></span></p>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                CÓDIGO
                            </label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt_codigo-{{$idModalUnidadAlmacenamiento}}" 
                                name="ma_codigo" 
                                placeholder="INGRESE EL CÓDIGO"
                                data-label='Codigo'
                                readonly
                                style="text-transform: uppercase;">
                                <span class="badge bg-danger" data-for="txt_codigo-{{$idModalUnidadAlmacenamiento}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                DESCRIPCIÓN
                            </label>
                            <div class="pos-relative">
                                <textarea class="form-control" 
                                placeholder="INGRESE LA DESCRIPCIÓN"
                                data-label='Descripción'
                                name="ma_descripcion" 
                                id="txt_descripcion-{{$idModalUnidadAlmacenamiento}}" 
                                rows="3"
                                style="text-transform: uppercase;"
                                ></textarea>
                                <span class="badge bg-danger" data-for="txt_descripcion-{{$idModalUnidadAlmacenamiento}}"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                FECHAS
                                <span class="form-switch" style="margin-left: 35px;">
                                    <input style="margin-top:0;" class="form-check-input" type="checkbox" id="chk_estado_fechas-{{$idModalUnidadAlmacenamiento}}" name="chec_estado_fecha">
                                    <label for="">Estado: <span id="text_check_estado_fechas-{{$idModalUnidadAlmacenamiento}}">Inactivo</span></label>
                                </span>
                            </label>
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <input class="form-control" name="ma_fecha_desde" id="fecha_inicio-{{$idModalUnidadAlmacenamiento}}" type="date" readonly>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <input class="form-control" name="ma_fecha_hasta" id="fecha_final-{{$idModalUnidadAlmacenamiento}}" type="date" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="body_charge_medio_almacenamiento-{{$idModalUnidadAlmacenamiento}}" class="modal-body">
                <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
            </div>
            <div id="footer_medio_almacenamiento-{{$idModalUnidadAlmacenamiento}}" class="modal-footer" style="display: none;">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_unidad_almacenamiento-{{$idModalUnidadAlmacenamiento}}" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
            <div id="footer_charge_medio_almacenamiento-{{$idModalUnidadAlmacenamiento}}" class="modal-footer">
                <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let confUnidadProductora = document.getElementById('cup_id-{{$idModalUnidadAlmacenamiento}}');
        let confUnidadProductoraSerie = document.getElementById('cups_id-{{$idModalUnidadAlmacenamiento}}');
        let confDocumento = document.getElementById('cd_id-{{$idModalUnidadAlmacenamiento}}');
        let inputImagen = document.getElementById('imagen-{{$idModalUnidadAlmacenamiento}}');
        let divImagen = document.getElementById('img_preview-{{$idModalUnidadAlmacenamiento}}');
        let checkEstado = document.getElementById('chk_estado_fechas-{{$idModalUnidadAlmacenamiento}}');
        let textCheckEstado = document.getElementById('text_check_estado_fechas-{{$idModalUnidadAlmacenamiento}}');
        let inputFechaDesde = document.getElementById('fecha_inicio-{{$idModalUnidadAlmacenamiento}}');
        let inputFechaHasta = document.getElementById('fecha_final-{{$idModalUnidadAlmacenamiento}}');
        let btnDeleteImage = document.getElementById('btn_delete_image-{{$idModalUnidadAlmacenamiento}}');
        let uploadImage = true;

        checkEstado.addEventListener('change', (e)=>{
            textCheckEstado.innerHTML = "Inactivo";
            inputFechaDesde.readOnly = true;
            inputFechaHasta.readOnly = true;
            if(e.target.checked){
                textCheckEstado.innerHTML = "Activo";
                inputFechaDesde.readOnly = false;
                inputFechaHasta.readOnly = false;
            }  
        });

        confUnidadProductora.setValueCombo = ((values, id) => {
            confUnidadProductora.innerHTML = "";
            if(id == 0){
                confUnidadProductora.innerHTML += "<option value='0' data-serie='[]' data-codigo=''>NO ASIGNADO</option>";
            }
            values.forEach(v => {
                confUnidadProductora.innerHTML += `<option value='${v.cup_id}' data-serie='${JSON.stringify(JSON.parse(v.campos_serie))}' data-codigo='${v.cup_codigo}'>${v.cup_nombre}</option>`;
            });
        });

        confUnidadProductoraSerie.setValueCombo = ((values, id) => {
            confUnidadProductoraSerie.innerHTML = "";
            if(id == 0){
                confUnidadProductoraSerie.innerHTML += "<option value='0'>NO ASIGNADO</option>";
            }
            values.forEach(v => {
                confUnidadProductoraSerie.innerHTML += `<option value='${v.cups_id}'>${v.cups_nombre}</option>`;
            });
        });

        confDocumento.setValueCombo = ((values, id) => {
            confDocumento.innerHTML = "";
            if(id == 0){
                confDocumento.innerHTML += "<option value='0'>NO ASIGNADO</option>";
            }
            values.forEach(v => {
                confDocumento.innerHTML += `<option value='${v.cd_id}'>${v.cd_nombre}</option>`;
            });
        });

        inputImagen.addEventListener('change', (event) => {
            let file = event.target.files[0];
            let reader = new FileReader();
            
            reader.onload = function(e) {
                divImagen.style.backgroundImage = "url('" + e.target.result + "')";
                divImagen.querySelector('.img_preview--icon').style.display = 'none';
                divImagen.querySelector('.img_preview--text').style.display = 'none';
                uploadImage = false;
                btnDeleteImage.style.display = 'flex';
            };
            
            reader.readAsDataURL(file);
        });

        divImagen.addEventListener('click', () => {
            if(uploadImage)
                inputImagen.click();
        });

        btnDeleteImage.addEventListener('click', (e) => {
            e.stopPropagation();
            btnDeleteImage.style.display = 'none';
            inputImagen.value = '';
            divImagen.style.backgroundImage = "";
            divImagen.querySelector('.img_preview--icon').style.display = 'block';
            divImagen.querySelector('.img_preview--text').style.display = 'block';
            uploadImage = true;
        });
    });
</script>