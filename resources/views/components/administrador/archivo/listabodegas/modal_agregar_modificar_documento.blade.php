<div class="modal" id="{{$idModalDocumento}}">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{$titulo}}</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div id="body_documento-{{$idModalDocumento}}" class="modal-body" style="display: none;">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token-{{$idModalDocumento}}">
                <form class="form" novalidate id="{{$idFormModalDocumento}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="id_documento-{{$idModalDocumento}}" name="id">
                    <input type="hidden" id="id_medio_almacenamiento-{{$idModalDocumento}}" name="ma_id">
                    <input type="hidden" name="accion" id="accion-{{$idModalDocumento}}" value="AGREGAR">
                    <div class="row">
                        <div class="col-xs-12 col-md-7">
                            <input type="file" id="file_pdf-{{$idModalDocumento}}" name="file_pdf" accept=".pdf" style="display: none;">
                            <div id="pdf_preview-{{$idModalDocumento}}" class="pdf_preview">
                                <i class="pdf_preview--icon fa fa-file-pdf-o" aria-hidden="true"></i>
                                <p class="pdf_preview--text">Subir PDF</p>
                            </div>
                            <iframe id="iframe_pdf_preview-{{$idModalDocumento}}" style="display: none;" class="pdf_preview_archive"></iframe>
                            <button class="btn btn-success-gradient btn-movi w-100" style="display: none;" id="btn_delete_imagen-{{$idModalDocumento}}" type="button"><i class="fa fa-trash"></i> Borrar PDF</button>
                        </div>
                        <div class="col-xs-12 col-md-5">
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    Unidad Productora
                                </label>
                                <select name="cup_id" id="cup_id-{{$idModalDocumento}}" class="form-control">
                                </select>
                                <span class="badge bg-danger" data-for="cup_id-{{$idModalDocumento}}"></span>
                            </div>
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    Unidad Productora Serie
                                </label>
                                <select name="cups_id" id="cups_id-{{$idModalDocumento}}" class="form-control">
                                </select>
                                <span class="badge bg-danger" data-for="cups_id-{{$idModalDocumento}}"></span>
                            </div>
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    Documento
                                </label>
                                <select name="cd_id" id="cd_id-{{$idModalDocumento}}" class="form-control">
                                </select>
                                <span class="badge bg-danger" data-for="cd_id-{{$idModalDocumento}}"></span>
                            </div>
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    CÓDIGO
                                </label>
                                <div class="pos-relative">
                                    <input class="form-control pd-r-80" type="text" id="txt_codigo-{{$idModalDocumento}}" 
                                    name="codigo" 
                                    placeholder="INGRESE EL CÓDIGO"
                                    data-label='Codigo'
                                    style="text-transform: uppercase;">
                                    <span class="badge bg-danger" data-for="txt_codigo-{{$idModalDocumento}}"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    NRO FOLIOS
                                </label>
                                <div class="pos-relative">
                                    <input class="form-control pd-r-80" type="text" id="txt_nro_folio-{{$idModalDocumento}}" 
                                    name="txt_nro_folio" 
                                    placeholder="INGRESE El NÚMERO DE FOLIOS"
                                    data-label='NRO FOLIOS'
                                    value="1"
                                    style="text-transform: uppercase;">
                                    <span class="badge bg-danger" data-for="txt_nro_folio-{{$idModalDocumento}}"></span>
                                </div>
                            </div>
                            <div id="campos-{{$idModalDocumento}}">

                            </div>
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    COMENTARIOS:
                                </label>
                                <div class="pos-relative">
                                    <textarea class="form-control" 
                                        placeholder="INGRESE EL COMENTARIO"
                                        name="comentario" 
                                        id="txt_comentario-{{$idModalDocumento}}" 
                                        rows="3"
                                        style="text-transform: uppercase;"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="body_charge_documento-{{$idModalDocumento}}" class="modal-body">
                <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
            </div>
            <div id="footer_documento-{{$idModalDocumento}}" class="modal-footer" style="display: none;">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_documento-{{$idModalDocumento}}" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
            <div id="footer_charge_documento-{{$idModalDocumento}}" class="modal-footer">
                <i class="fa fa-spinner icon_charge" aria-hidden="true"></i>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let divPdf = document.getElementById('pdf_preview-{{$idModalDocumento}}');
        let inputFile = document.getElementById('file_pdf-{{$idModalDocumento}}');
        let confUnidadProductora = document.getElementById('cup_id-{{$idModalDocumento}}');
        let confUnidadProductoraSerie = document.getElementById('cups_id-{{$idModalDocumento}}');
        let confDocumento = document.getElementById('cd_id-{{$idModalDocumento}}');
        let iframePDF = document.getElementById('iframe_pdf_preview-{{$idModalDocumento}}');
        let deleteImagen = document.getElementById('btn_delete_imagen-{{$idModalDocumento}}');
        let uploadFile = true;


        confUnidadProductora.setValueCombo = ((values, id) => {
            confUnidadProductora.innerHTML = "";
            if(id == 0)
                confUnidadProductora.innerHTML += "<option value='0' data-codigo='' data-serie='[]'>NO ASIGNADO</option>";
            values.forEach(v => {
                confUnidadProductora.innerHTML += `<option value='${v.cup_id}' data-codigo='${v.cup_codigo}' data-serie='${JSON.stringify(JSON.parse(v.campos_serie))}'>${v.cup_nombre}</option>`;
            });
        });

        confUnidadProductoraSerie.setValueCombo = ((values, id) => {
            confUnidadProductoraSerie.innerHTML = "";
            if(id == 0)
                confUnidadProductoraSerie.innerHTML += "<option value='0'>NO ASIGNADO</option>";
            values.forEach(v => {
                confUnidadProductoraSerie.innerHTML += `<option value='${v.cups_id}'>${v.cups_nombre}</option>`;
            });
        });

        confDocumento.setValueCombo = ((values, id) => {
            confDocumento.innerHTML = "";
            if(id == 0)
                confDocumento.innerHTML += "<option data-codigo='' value='0'>NO ASIGNADO</option>";
            values.forEach(v => {
                confDocumento.innerHTML += `<option data-codigo='${v.cd_codigo}' value='${v.cd_id}'>${v.cd_nombre}</option>`;
            });
        });

        inputFile.addEventListener('change', (event) => {
            let file = event.target.files[0];
            if(file && file.type === "application/pdf") {
                let reader = new FileReader();
                reader.onload = function(event) {
                    iframePDF.src = URL.createObjectURL(new Blob([event.target.result], { type: 'application/pdf' }));
                    divPdf.style.display = 'none';
                    iframePDF.style.display = 'block';
                    deleteImagen.style.display = 'inline-block';
                };
                reader.readAsArrayBuffer(file);
            } else {
                alert("Por favor, seleccione un archivo PDF.");
            }
        });

        divPdf.addEventListener('click', () => {
            if(uploadFile)
                inputFile.click();
        });

        deleteImagen.addEventListener('click', () =>{
            iframePDF.src = "";
            inputFile.value = "";
            iframePDF.style.display = 'none';
            divPdf.style.display = 'flex';
            deleteImagen.style.display = 'none';
        });

    });
</script>