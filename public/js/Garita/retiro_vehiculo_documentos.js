const idContainerRetiroVehiculo = document.getElementById('id_modal_documentos_vehiculo');
const containerDocumentosVehiculoModal = document.getElementById('container_items_documentos_retiro');
let cont_input_documento_modal = 1;

function show_documentos_vehiculo(id, tiv_id) {
    idContainerRetiroVehiculo.value = id;

    $.ajax({
        url: `/garita/ingreso_vehiculo_patio/get_documentos_vehiculo/${tiv_id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            containerDocumentosVehiculoModal.innerHTML = "";

            response.forEach(i => {
                containerDocumentosVehiculoModal.innerHTML += `
                <input type="file" data-sec="${cont_input_documento_modal}" id="file_pdf_documento-${cont_input_documento_modal}" data-name="${i.d_nombre}" data-es_requerido="${i.d_es_requerido}" data-id="${i.d_id}" name="file_pdf" accept=".pdf" style="display: none;">
                <div id="pdf_preview-${cont_input_documento_modal}" data-sec="${cont_input_documento_modal}" class="pdf_preview" data-div_notloaded="${cont_input_documento_modal}">
                    <i class="pdf_preview--icon fa fa-file-pdf-o" aria-hidden="true"></i>
                    <p class="pdf_preview--text">${i.d_nombre}</p>
                    <span class="badge bg-danger" data-sec="${cont_input_documento_modal}" style="display: none;">Falta cargar documento</span>
                </div>
                <div class="card h-100 card_unidad_productora text-center card_medio_almacenamiento" style="display: none;" data-div_loaded="${cont_input_documento_modal}">
                    <img class="card-img-top w-100 card_unidad_productora__img border_dashed" src="/imagenes_garita/pdf-upload.svg" alt="PDF IMAGEN">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h4 class="card-title mb-3">${i.d_nombre}</h4>
                        <a class="btn btn-primary mb-2"
                        data-btn_view="${cont_input_documento_modal}"
                        href="#"><i class="fa fa-eye"></i> Ver PDF</a>
                        <a class="btn btn-danger"
                        data-btn_delete="${cont_input_documento_modal}"
                        href="#"><i class="fa fa-trash"></i> Borrar PDF</a>
                    </div>
                </div>
                `;
                cont_input_documento_modal++;
            });

            const list_files_documentos = containerDocumentosVehiculoModal.querySelectorAll("div[id^='pdf_preview-']");
            list_files_documentos.forEach(e => {
                setFunctionSubirDocumentoVehiculoRetiro(e)
            });

            cargarDocumentosRetiroVehiculo(id)

            $("#modal_documentos_vehiculo").modal("show");

        }
    });
}

function setFunctionSubirDocumentoVehiculoRetiro(element) {
    const inputDocument = containerDocumentosVehiculoModal.querySelector(`input[id='file_pdf_documento-${element.dataset.sec}']`);
    const divLoaded = containerDocumentosVehiculoModal.querySelector(`div[data-div_loaded="${element.dataset.sec}"]`);
    const divNotLoaded = containerDocumentosVehiculoModal.querySelector(`div[data-div_notloaded="${element.dataset.sec}"]`);
    const btnViewPDF = divLoaded.querySelector('a[data-btn_view]');
    const btnDeletePDF = divLoaded.querySelector('a[data-btn_delete]');

    inputDocument.addEventListener('change', (event) => {
        let file = event.target.files[0];
        if (file && file.type === "application/pdf") {
            divLoaded.style.display = 'block';
            divNotLoaded.style.display = 'none';
            /*
            
            */
        } else {
            alert("Por favor, seleccione un archivo PDF.");
        }
    });

    element.addEventListener('click', () => {
        inputDocument.click();
    });

    btnViewPDF.addEventListener('click', () => {
        let file = inputDocument.files[0];
        let reader = new FileReader();
        reader.onload = function (event) {
            iframePDF.src = URL.createObjectURL(new Blob([event.target.result], { type: 'application/pdf' }));
            $("#modal_view_pdf").modal("show");
            iframePDF.style.display = 'block';
        };
        reader.readAsArrayBuffer(file);
    });

    btnDeletePDF.addEventListener('click', () => {
        inputDocument.value = "";

        divLoaded.style.display = 'none';
        divNotLoaded.style.display = 'flex';
    });
}

function cargarDocumentosRetiroVehiculo(ivp_id) {
    $.ajax({
        url: `/garita/ingreso_vehiculo_patio/get/${ivp_id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let documentos_vehiculo = JSON.parse(response.list_documentos);
            documentos_vehiculo.forEach(d => {
                let inputFile = containerDocumentosVehiculoModal.querySelector(`input[data-id="${d.d_id}"]`);

                fetch(`/garita/ingreso_vehiculo_patio/getDocumento/${d.ivd_archivo_generado}`)
                    .then(response => {
                        if (!response.ok) {
                            console.warn(`No se encontró el archivo: ${d.ivd_archivo_generado}`);
                            return null;
                        }
                        return response.blob();
                    })
                    .then(blob => {
                        if (!blob) return;

                        let file = new File([blob], d.ivd_archivo_original, { type: "application/pdf" });

                        let dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);

                        inputFile.files = dataTransfer.files;
                        inputFile.dispatchEvent(new Event("change"));
                    })
                    .catch(error => {
                        console.error(`Error al obtener el archivo ${d.ivd_archivo_generado}:`, error);
                    });
            });
        }
    });
}