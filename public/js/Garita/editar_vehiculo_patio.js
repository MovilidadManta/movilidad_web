const containerInventarioVehiculo = document.getElementById('container_items_iventario_vehiculo');
const containerDocumentosVehiculo = document.getElementById('container_items_documentos_vehiculo');

const sectionMotivoIngreso = document.getElementById("section_motivo_ingreso");

//controles formulario ingresar o modificar inventario de vehiculo
const id_ingreso_vehiculo_patio = document.getElementById("id_modal_agregar_ingreso_vehiculo_patio");
const txt_articulo = document.getElementById("txt_articulo_modal_agregar_ingreso_vehiculo_patio");
const txt_numeral = document.getElementById("txt_numeral_modal_agregar_ingreso_vehiculo_patio");
const txt_literal = document.getElementById("txt_literal_modal_agregar_ingreso_vehiculo_patio");
const txt_resolucion = document.getElementById("txt_resolucion_modal_agregar_ingreso_vehiculo_patio");
const txt_autoridad = document.getElementById("txt_autoridad_modal_agregar_ingreso_vehiculo_patio");
const txt_oficio = document.getElementById("txt_oficio_modal_agregar_ingreso_vehiculo_patio");

const txt_cedula_conductor = document.getElementById("txt_cedula_pasaporte_conductor_modal_agregar_ingreso_vehiculo_patio");
const txt_nombre_conductor = document.getElementById("txt_nombre_conductor_modal_agregar_ingreso_vehiculo_patio");
const txt_tipo_licencia_conductor = document.getElementById("tipo_licencia_conductor_modal_agregar_ingreso_vehiculo_patio");

const txt_placa_vehiculo = document.getElementById("txt_placa_vehiculo_modal_agregar_ingreso_vehiculo_patio");
const txt_tipo_placa_vehiculo = document.getElementById("tipo_placa_vehiculo_modal_agregar_ingreso_vehiculo_patio");
const txt_marca_vehiculo = document.getElementById("txt_marca_vehiculo_modal_agregar_ingreso_vehiculo_patio");
const txt_modelo_vehiculo = document.getElementById("txt_modelo_vehiculo_modal_agregar_ingreso_vehiculo_patio");
const txt_color1_vehiculo = document.getElementById("txt_color1_vehiculo_modal_agregar_ingreso_vehiculo_patio");
const txt_ramv_vehiculo = document.getElementById("txt_ramv_vehiculo_modal_agregar_ingreso_vehiculo_patio");
const txt_chasis_vehiculo = document.getElementById("txt_chasis_vehiculo_modal_agregar_ingreso_vehiculo_patio");
const txt_motor_vehiculo = document.getElementById("txt_motor_vehiculo_modal_agregar_ingreso_vehiculo_patio");
const txt_servicio_vehiculo = document.getElementById("tipo_servicio_vehiculo_modal_agregar_ingreso_vehiculo_patio");

const select_medio_ingreso = document.getElementById("select_medio_ingreso_modal_agregar_ingreso_vehiculo_patio");
const txt_medio_ingreso_empresa = document.getElementById("txt_medio_ingreso_empresa_modal_agregar_ingreso_vehiculo_patio");
const txt_medio_ingreso_datos_translado = document.getElementById("txt_medio_ingreso_datos_translado_modal_agregar_ingreso_vehiculo_patio");
const label_medio_ingreso_empresa = document.getElementById("label_medio_ingreso_empresa_modal_agregar_ingreso_vehiculo_patio");
const label_medio_ingreso_datos_translado = document.getElementById("label_medio_ingreso_datos_translado_modal_agregar_ingreso_vehiculo_patio");
const badge_medio_ingreso_empresa = document.getElementById("badge_medio_ingreso_empresa_modal_agregar_ingreso_vehiculo_patio");
const badge_medio_ingreso_datos_translado = document.getElementById("badge_medio_ingreso_datos_translado_modal_agregar_ingreso_vehiculo_patio");

const btnGuardarIngresoVehiculoPatio = document.getElementById('btn_guardar_ingreso_vehiculo_patio-modal_agregar_ingreso_vehiculo_patio');
const TextSaveIngresoVehiculoPatio = document.getElementById('text_save_ingreso_vehiculo_patio-modal_agregar_ingreso_vehiculo_patio');
let accionFormulario = "ADD";
let cont_checkbox = 1;
let cont_input_documento = 1;
let id_inventario_vehiculo = 0;
const tipo_ingreso_vehicular = document.getElementById("tiv_id_modal_tipo_ingreso");
const descripcion_ingreso_vehicular = document.getElementById("ivp_descripcion_modal_tipo_ingreso");
const iframePDF = document.getElementById('iframe_visor_pdf');
const btnSiguienteIngresoVehicular = document.getElementById('btn_siguiente-modal_tipo_ingreso');
const sectionDatosGenerales = document.querySelector("a[href='#tab_datos_generales']");
const inputImagenes = document.getElementById('id_evidencia_raspones_golpes');
//---------------------------------------------------------------------

// Controles de agentes que ingresan el vehiculo
const txt_cedula_agente_retiene = document.getElementById("txt_cedula_agente_retiene");
const txt_nombre_agente_retiene = document.getElementById("txt_nombre_agente_retiene");
const txt_email_agente_retiene = document.getElementById("txt_email_agente_retiene");
const txt_cedula_agente_ingresa = document.getElementById("txt_cedula_agente_ingresa");
const txt_nombre_agente_ingresa = document.getElementById("txt_nombre_agente_ingresa");
const txt_cedula_responsable = document.getElementById("txt_cedula_responsable");
const txt_nombre_responsable = document.getElementById("txt_nombre_responsable");
const txt_email_responsable = document.getElementById("txt_email_responsable");
//--------------------------------------------------------------------

//botoncito volver a  descripcion
const imgTipoIngreso = document.getElementById('img_tipo_ingreso_elegido');
const btnTipoIngreso = document.getElementById('btn_tipo_ingreso_elegido');
const labelTipoIngreso = document.getElementById('span_tipo_ingreso_elegido');
const panelOrdenanza = document.getElementById('panel_ordenanza');
//------------------------------------------

$(document).ready(function () {

    setInputValidations('txt_articulo_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_numeral_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_literal_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_resolucion_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_autoridad_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_oficio_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);

    setInputValidations('txt_cedula_pasaporte_conductor_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_nombre_conductor_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('tipo_licencia_conductor_modal_agregar_ingreso_vehiculo_patio', [], [
        {
            function: function (item) {
                return item.value == -1;
            },
            message: "Debe buscar y seleccionar un Tipo de Licencia"
        }
    ]);

    setInputValidations('txt_placa_vehiculo_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('tipo_placa_vehiculo_modal_agregar_ingreso_vehiculo_patio', [], [
        {
            function: function (item) {
                return item.value == -1;
            },
            message: "Debe buscar y seleccionar un Tipo de Vehiculo"
        }
    ]);
    setInputValidations('txt_marca_vehiculo_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_modelo_vehiculo_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_color1_vehiculo_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_ramv_vehiculo_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_chasis_vehiculo_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_motor_vehiculo_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('tipo_servicio_vehiculo_modal_agregar_ingreso_vehiculo_patio', [], [
        {
            function: function (item) {
                return item.value == -1;
            },
            message: "Debe buscar y seleccionar un Tipo de Servicio"
        }
    ]);

    setInputValidations('select_medio_ingreso_modal_agregar_ingreso_vehiculo_patio', [], [
        {
            function: function (item) {
                return item.value == -1;
            },
            message: "Debe buscar y seleccionar un Medio de ingreso"
        }
    ]);

    setInputValidations('txt_medio_ingreso_empresa_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_medio_ingreso_datos_translado_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);

    setInputValidations('txt_cedula_agente_retiene', ['notEmpty'], []);
    setInputValidations('txt_nombre_agente_retiene', ['notEmpty'], []);
    setInputValidations('txt_email_agente_retiene', ['notEmpty'], []);
    setInputValidations('txt_cedula_agente_ingresa', ['notEmpty'], []);
    setInputValidations('txt_nombre_agente_ingresa', ['notEmpty'], []);
    setInputValidations('txt_cedula_responsable', ['notEmpty'], []);
    setInputValidations('txt_nombre_responsable', ['notEmpty'], []);
    setInputValidations('txt_email_responsable', ['notEmpty'], []);

    set_type_input("txt_cedula_pasaporte_conductor_modal_agregar_ingreso_vehiculo_patio", "number");
    set_type_input("txt_cedula_agente_retiene", "number");
    set_type_input("txt_cedula_agente_ingresa", "number");
    set_type_input("txt_cedula_responsable", "number");

    let allInputsModal = document.querySelectorAll('#form_modal_agregar_ingreso_vehiculo_patio input[id$="_modal_agregar_ingreso_vehiculo_patio"], #id_evidencia_raspones_golpes');

    allInputsModal.forEach(e => {
        if (e.which === 13) {
            e.preventDefault();
        }
    });

    getConfTipoVehiculo();

});

function getConfTipoVehiculo() {
    txt_tipo_placa_vehiculo.innerHTML = "<option value='-1'>SELECCIONE</option>";
    $.ajax({
        url: `/garita/tipo_vehiculo/list`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            response.forEach(r => {
                txt_tipo_placa_vehiculo.innerHTML += `<option value="${r.tv_id}">${r.tv_nombre}</option>`;
            });
        }
    });
}

function getDocumentosVehiculo(tipo_ingreso_vehicular, functionAddtional = undefined) {
    $.ajax({
        url: `/garita/ingreso_vehiculo_patio/get_documentos_vehiculo/${tipo_ingreso_vehicular}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            containerDocumentosVehiculo.innerHTML = "";

            response.forEach(i => {
                containerDocumentosVehiculo.innerHTML += `
                <input type="file" data-sec="${cont_input_documento}" id="file_pdf_documento-${cont_input_documento}" data-name="${i.d_nombre}" data-es_requerido="${i.d_es_requerido}" data-id="${i.d_id}" name="file_pdf" accept=".pdf" style="display: none;">
                <div id="pdf_preview-${cont_input_documento}" data-sec="${cont_input_documento}" class="pdf_preview" data-div_notloaded="${cont_input_documento}">
                    <i class="pdf_preview--icon fa fa-file-pdf-o" aria-hidden="true"></i>
                    <p class="pdf_preview--text">${i.d_nombre}</p>
                    <span class="badge bg-danger" data-sec="${cont_input_documento}" style="display: none;">Falta cargar documento</span>
                </div>
                <div class="card h-100 card_unidad_productora text-center card_medio_almacenamiento" style="display: none;" data-div_loaded="${cont_input_documento}">
                    <img class="card-img-top w-100 card_unidad_productora__img border_dashed" src="/imagenes_garita/pdf-upload.svg" alt="PDF IMAGEN">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h4 class="card-title mb-3">${i.d_nombre}</h4>
                        <a class="btn btn-primary mb-2"
                        data-btn_view="${cont_input_documento}"
                        href="#"><i class="fa fa-eye"></i> Ver PDF</a>
                        <a class="btn btn-danger"
                        data-btn_delete="${cont_input_documento}"
                        href="#"><i class="fa fa-trash"></i> Borrar PDF</a>
                    </div>
                </div>
                `;
                cont_input_documento++;
            });

            const list_files_documentos = containerDocumentosVehiculo.querySelectorAll("div[id^='pdf_preview-']");
            list_files_documentos.forEach(e => {
                setFunctionSubirDocumentoVehiculo(e)
            });

            if (functionAddtional != undefined) {
                functionAddtional();
            }

        }
    });
}

function setFunctionSubirDocumentoVehiculo(element) {
    const inputDocument = containerDocumentosVehiculo.querySelector(`input[id='file_pdf_documento-${element.dataset.sec}']`);
    const divLoaded = containerDocumentosVehiculo.querySelector(`div[data-div_loaded="${element.dataset.sec}"]`);
    const divNotLoaded = containerDocumentosVehiculo.querySelector(`div[data-div_notloaded="${element.dataset.sec}"]`);
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

function getIventarioVehiculo(TipoInventario) {
    $.ajax({
        url: `/garita/ingreso_vehiculo_patio/get_inventario_vehiculo/${TipoInventario}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            renderInventarioVehiculo(response)
        }
    });
}

function renderInventarioVehiculo(items) {
    containerInventarioVehiculo.innerHTML = '';
    items.forEach(i => {
        if (i.ivd_tipo == 1) {
            containerInventarioVehiculo.innerHTML += `
            <p>${i.ivd_title}</p>
            `;
            containerInventarioVehiculo.innerHTML += `
                <div class="checkbox-wrapper-1">
                    <input id="example-${cont_checkbox}" data-name="${i.ivd_title}" class="substituted" data-id="${i.ivd_id}" type="checkbox" value="1" aria-hidden="true" ${i.ivd_valor == "true" ? 'checked' : ''} />
                    <label for="example-${cont_checkbox}"></label>
                </div>
                `;
            cont_checkbox++;
        }
        if (i.ivd_tipo == 2) {
            containerInventarioVehiculo.innerHTML += `
            <p>${i.ivd_title}</p>
            `;
            containerInventarioVehiculo.innerHTML += `
                <i>
                    <input data-name="${i.ivd_title}" data-id="${i.ivd_id}" type="number" value="${i.ivd_valor != undefined ? i.ivd_valor : 1}" />
                </i>
                `;
        }
        if (i.ivd_tipo == 3) {
            containerInventarioVehiculo.innerHTML += `
            <p class="margin-10">${i.ivd_title}</p>
            `;
            containerInventarioVehiculo.innerHTML += `
                <p class="item_full_width">
                    <input class="form-control" style="text-transform: uppercase;" data-name="${i.ivd_title}" data-id="${i.ivd_id}" type="text" value="${i.ivd_valor != undefined ? i.ivd_valor : ''}" maxlength="40" />
                </p>
                `;
        }
    });
}

select_medio_ingreso.addEventListener('change', e => {

    txt_medio_ingreso_empresa.value = "";
    txt_medio_ingreso_datos_translado.value = "";
    txt_medio_ingreso_empresa.style.display = "none";
    txt_medio_ingreso_datos_translado.style.display = "none";
    label_medio_ingreso_empresa.style.display = "none";
    label_medio_ingreso_datos_translado.style.display = "none";
    badge_medio_ingreso_empresa.style.display = "none";
    badge_medio_ingreso_datos_translado.style.display = "none";

    if (e.target.value > 0) {
        txt_medio_ingreso_empresa.style.display = "block";
        txt_medio_ingreso_datos_translado.style.display = "block";
        label_medio_ingreso_empresa.style.display = "block";
        label_medio_ingreso_datos_translado.style.display = "block";
        if (badge_medio_ingreso_empresa.innerText.trim() != "") {
            badge_medio_ingreso_empresa.style.display = "inline-block";
        }

        if (badge_medio_ingreso_datos_translado.innerText.trim() != "") {
            badge_medio_ingreso_datos_translado.style.display = "inline-block";
        }
    }
});

function validarControlesInventarioVehiculo() {
    let errores = '';

    errores += txt_articulo.validateInput();
    errores += txt_numeral.validateInput();
    errores += txt_literal.validateInput();
    errores += txt_resolucion.validateInput();
    errores += txt_autoridad.validateInput();
    errores += txt_oficio.validateInput();

    errores += txt_cedula_conductor.validateInput();
    errores += txt_nombre_conductor.validateInput();
    errores += txt_tipo_licencia_conductor.validateInput();

    errores += txt_placa_vehiculo.validateInput();
    errores += txt_tipo_placa_vehiculo.validateInput();
    errores += txt_marca_vehiculo.validateInput();
    errores += txt_modelo_vehiculo.validateInput();
    errores += txt_color1_vehiculo.validateInput();
    errores += txt_ramv_vehiculo.validateInput();
    errores += txt_chasis_vehiculo.validateInput();
    errores += txt_motor_vehiculo.validateInput();
    errores += txt_servicio_vehiculo.validateInput();

    errores += select_medio_ingreso.validateInput();

    errores += txt_cedula_agente_retiene.validateInput();
    errores += txt_nombre_agente_retiene.validateInput();
    errores += txt_email_agente_retiene.validateInput();
    errores += txt_cedula_agente_ingresa.validateInput();
    errores += txt_nombre_agente_ingresa.validateInput();
    errores += txt_cedula_responsable.validateInput();
    errores += txt_nombre_responsable.validateInput();
    errores += txt_email_responsable.validateInput();

    if (select_medio_ingreso.value > 0) {
        errores += txt_medio_ingreso_empresa.validateInput();
        errores += txt_medio_ingreso_datos_translado.validateInput();
        badge_medio_ingreso_empresa.style.display = "inline-block";
        badge_medio_ingreso_datos_translado.style.display = "inline-block";
    }

    /*
    const listInputDocumentos = containerDocumentosVehiculo.querySelectorAll("input[type='file'][id^='file_pdf_documento-']");

    listInputDocumentos.forEach(i => {
        const badge = containerDocumentosVehiculo.querySelector(`span[data-sec="${i.dataset.sec}"]`);
        badge.style.display = "none";
        if (i.value == "" && i.dataset.es_requerido == "true") {
            errores += `No se ha cargado el documento de ${i.dataset.name}`;
            badge.style.display = "inline-block";
        }
    });
    */
}

btnGuardarIngresoVehiculoPatio.addEventListener('click', () => {
    errores = validarControlesInventarioVehiculo();

    let detalle_inventario_vehiculo = [];

    const items = containerInventarioVehiculo.querySelectorAll('input');

    let orden_conteo = 1;
    items.forEach(i => {

        if (i.type == "checkbox") {
            detalle_inventario_vehiculo.push({
                iv_id: id_inventario_vehiculo,
                iv_title: i.dataset.name,
                iv_tipo: 1,
                iv_valor: i.checked,
                iv_orden: orden_conteo
            });
        }


        if (i.type == "number") {
            detalle_inventario_vehiculo.push({
                iv_id: id_inventario_vehiculo,
                iv_title: i.dataset.name,
                iv_tipo: 2,
                iv_valor: i.value,
                iv_orden: orden_conteo
            });
        }

        if (i.type == "text") {
            detalle_inventario_vehiculo.push({
                iv_id: id_inventario_vehiculo,
                iv_title: i.dataset.name,
                iv_tipo: 3,
                iv_valor: i.value.toUpperCase(),
                iv_orden: orden_conteo
            });
        }

        orden_conteo++;

    });

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede ingresar el vehiculo al patio",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    }
    else {
        $(`#${TextSaveIngresoVehiculoPatio.id}`).html("Guardando...");
        const token = $("#csrf_token_modal_agregar_ingreso_vehiculo_patio").val();
        const datos = new FormData($("#form_modal_agregar_ingreso_vehiculo_patio")[0]);
        datos.append('tiv_id', tipo_ingreso_vehicular.value);
        datos.append('ivp_descripcion', descripcion_ingreso_vehicular.value.toUpperCase());
        datos.append('detalle_inventario_vehiculo', JSON.stringify(detalle_inventario_vehiculo));
        if (txt_tipo_placa_vehiculo.disabled) {
            datos.append('ivp_vehiculo_tipo', txt_tipo_placa_vehiculo.value);
        }

        if (txt_servicio_vehiculo.disabled) {
            datos.append('ivp_vehiculo_servicio', txt_servicio_vehiculo.value);
        }

        inputImagenes.getImagenes().forEach(file => {
            datos.append('imagenes[]', file);
        });

        listInputDocumentos.forEach((i, k) => {
            const file = i.files[0];
            const documentoId = i.getAttribute('data-id');

            if (file) {
                // Enviar el archivo con su ID asociado (usamos array para que Laravel lo interprete)
                datos.append(`documentos[${k}][file]`, file);
                datos.append(`documentos[${k}][id]`, documentoId);
            }
        });

        if (accionFormulario == "ADD") {
            $.ajax({
                url: '/garita/ingreso_vehiculo_patio/store',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${TextSaveIngresoVehiculoPatio.id}`).html("Guardar");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito el vehiculo en el patio",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getIngresoVehiculoPatio();
                        $("#modal_agregar_ingreso_vehiculo_patio").modal("hide");
                    }
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 0) {
                    alert('Not connect: Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500]. Intente nuevamente');
                } else if (textStatus === 'timeout') {
                    alert('Time out error.');
                } else if (textStatus === 'abort') {
                    alert('Ajax request aborted.');
                }
            });
        }

        if (accionFormulario == "MOD") {
            $.ajax({
                url: '/garita/ingreso_vehiculo_patio/update',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${TextSaveIngresoVehiculoPatio.id}`).html("Guardar");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito el vehiculo en el patio",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getIngresoVehiculoPatio();
                        $("#modal_agregar_ingreso_vehiculo_patio").modal("hide");
                    }
                }
            }).fail(function (jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 0) {
                    alert('Not connect: Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500]. Intente nuevamente');
                } else if (textStatus === 'timeout') {
                    alert('Time out error.');
                } else if (textStatus === 'abort') {
                    alert('Ajax request aborted.');
                }
            });
        }
    }
});

function show_mod_ingreso_vehiculo_patio(ivp_id) {

    $.ajax({
        url: `/garita/ingreso_vehiculo_patio/get/${ivp_id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            accionFormulario = "ADD";
            id_ingreso_vehiculo_patio.value = ivp_id;

            descripcion_ingreso_vehicular.value = response.ivp_descripcion;

            clearClickeado();
            const cardIngresoElegido = document.querySelector(`.card_ingreso[data-id="${response.tiv_id}"]`);

            if (cardIngresoElegido) {
                cardIngresoElegido.dispatchEvent(new Event("click"));
            }

            renderBtnIngresoElegido();

            deshabilitar_deshabilitar_ordenanza()
            id_inventario_vehiculo = 1;
            if (response.tiv_id == 1) {
                id_inventario_vehiculo = 2;
                habilitar_deshabilitar_ordenanza();
            }

            accionFormulario = "MOD";

            txt_articulo.value = response.ivp_articulo;
            txt_numeral.value = response.ivp_numeral;
            txt_literal.value = response.ivp_literal;
            txt_resolucion.value = response.ivp_resolucion;
            txt_autoridad.value = response.ivp_autoridad;
            txt_oficio.value = response.ivp_oficio;
            txt_cedula_conductor.value = response.ivp_conductor_identificacion;
            txt_nombre_conductor.value = response.ivp_conductor_nombres;
            txt_tipo_licencia_conductor.value = response.ivp_conductor_tipo_licencia;
            txt_placa_vehiculo.value = response.ivp_vehiculo_placa;
            txt_tipo_placa_vehiculo.value = response.ivp_vehiculo_tipo;
            txt_marca_vehiculo.value = response.ivp_vehiculo_marca;
            txt_modelo_vehiculo.value = response.ivp_vehiculo_modelo;
            txt_color1_vehiculo.value = response.ivp_vehiculo_color1;
            txt_ramv_vehiculo.value = response.ivp_vehiculo_ramv;
            txt_chasis_vehiculo.value = response.ivp_vehiculo_chasis;
            txt_motor_vehiculo.value = response.ivp_vehiculo_motor;
            txt_servicio_vehiculo.value = response.ivp_vehiculo_servicio;
            select_medio_ingreso.value = response.ivp_medio_ingreso;
            select_medio_ingreso.dispatchEvent(new Event("change"));
            txt_medio_ingreso_empresa.value = response.ivp_medio_ingreso_empresa;
            txt_medio_ingreso_datos_translado.value = response.ivp_medio_ingreso_datos_translado;

            txt_cedula_agente_retiene.value = response.ivp_agente_retiene_cedula;
            txt_nombre_agente_retiene.value = response.ivp_agente_retiene_nombre;
            txt_email_agente_retiene.value = response.ivp_agente_retiene_email;
            txt_cedula_agente_ingresa.value = response.ivp_agente_ingresa_cedula;
            txt_nombre_agente_ingresa.value = response.ivp_agente_ingresa_nombre;
            txt_cedula_responsable.value = response.ivp_responsable_cedula;
            txt_nombre_responsable.value = response.ivp_responsable_nombre;
            txt_email_responsable.value = response.ivp_responsable_email;

            //Render de la lista de inventario de vehiculo
            let items_inventario = JSON.parse(response.list_inventario);

            items_inventario = items_inventario.map(i => {
                return {
                    ivd_id: i.iv_id,
                    ivd_tipo: i.iv_tipo,
                    ivd_title: i.iv_title,
                    ivd_valor: i.iv_valor
                };
            });

            renderInventarioVehiculo(items_inventario)
            //-------------------------------------------

            //Render de documentos de vehiculo
            let documentos_vehiculo = JSON.parse(response.list_documentos);
            getDocumentosVehiculo(response.tiv_id, () => {
                documentos_vehiculo.forEach(d => {
                    let inputFile = containerDocumentosVehiculo.querySelector(`input[data-id="${d.d_id}"]`);

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
            });
            //--------------------------------------------

            //Render Imagenes de evidencia, Golpes, Raspones
            inputImagenes.clearImagenes();
            let list_images = JSON.parse(response.list_evidencias);
            // Crear un objeto DataTransfer fuera del loop para acumular todos los archivos
            let dataTransfer_evidencias = new DataTransfer();

            let archivosProcesados = 0;

            list_images.forEach(i => {
                fetch(`/garita/ingreso_vehiculo_patio/getImagenesEvidencia/${i.ive_archivo_generado}`)
                    .then(response => {
                        if (!response.ok) {
                            console.warn(`Archivo no encontrado: ${i.ive_archivo_generado}`);
                            return null;
                        }

                        const contentType = response.headers.get('Content-Type') || 'image/jpeg';
                        return response.blob().then(blob => ({ blob, contentType }));
                    })
                    .then(data => {
                        archivosProcesados++;

                        if (!data) {
                            // Si el archivo no existe, simplemente salta
                            verificarCargaCompleta(dataTransfer_evidencias, list_images, archivosProcesados);
                            return;
                        }

                        const { blob, contentType } = data;

                        let file = new File([blob], i.ive_archivo_original, { type: contentType });
                        dataTransfer_evidencias.items.add(file);

                        verificarCargaCompleta(dataTransfer_evidencias, list_images, archivosProcesados);
                    })
                    .catch(error => {
                        archivosProcesados++;
                        console.error(`Error cargando evidencia ${i.ive_archivo_generado}:`, error);
                        verificarCargaCompleta(dataTransfer_evidencias, list_images, archivosProcesados);
                    });
            });
            //--------------------------------------------

            $("#modal_agregar_ingreso_vehiculo_patio").modal("show");
        }
    });


}

function verificarCargaCompleta(dataTransfer_evidencias, list_images, archivosProcesados) {
    if (archivosProcesados === list_images.length) {
        inputImagenes.files = dataTransfer_evidencias.files;
        inputImagenes.dispatchEvent(new Event("change"));
    }
}

function clearClickeado() {
    const cardIngresoClickeado = document.querySelector('.card_ingreso.clickeado');

    if (cardIngresoClickeado) {
        cardIngresoClickeado.dispatchEvent(new Event("click"));
    }
}

btnSiguienteIngresoVehicular.addEventListener('click', e => {
    if (descripcion_ingreso_vehicular.value.trim() == "") {
        notif({
            msg: "<b>Error:</b> Falta agregar Descripcion!",
            type: "error",
            zindex: 99999
        });
        return;
    }

    deshabilitar_deshabilitar_ordenanza()
    id_inventario_vehiculo = 1;
    if (tipo_ingreso_vehicular.value == 1) {
        id_inventario_vehiculo = 2;
        habilitar_deshabilitar_ordenanza();
    }

    if (accionFormulario == "ADD") {
        renderBtnIngresoElegido();
        getIventarioVehiculo(id_inventario_vehiculo);
        getDocumentosVehiculo(tipo_ingreso_vehicular.value);
    }

    $("#modal_tipo_ingreso").modal("hide");
    $("#modal_agregar_ingreso_vehiculo_patio").modal("show");

});

function renderBtnIngresoElegido() {
    const cardIngresoClickeado = document.querySelector('.card_ingreso.clickeado');
    const imgchoose = cardIngresoClickeado.querySelector('img.card-img-top');
    imgTipoIngreso.src = imgchoose.src;
    const label = cardIngresoClickeado.querySelector('.card-title');
    labelTipoIngreso.innerHTML = label.innerHTML;
}

btnTipoIngreso.addEventListener('click', () => {
    $("#modal_agregar_ingreso_vehiculo_patio").modal("hide");
    $("#modal_tipo_ingreso").modal("show");
});

function habilitar_deshabilitar_ordenanza() {
    sectionMotivoIngreso.style.display = "none";
    txt_articulo.value = "C";
    txt_numeral.value = "C";
    txt_literal.value = "C";
    txt_resolucion.value = "C";
    txt_autoridad.value = "C";
    txt_oficio.value = "C";
    txt_tipo_placa_vehiculo.value = 1;
    txt_tipo_placa_vehiculo.disabled = true;
    txt_servicio_vehiculo.value = 0;
    txt_servicio_vehiculo.disabled = true;
    panelOrdenanza.style.display = 'block';
}

function deshabilitar_deshabilitar_ordenanza() {
    sectionMotivoIngreso.style.display = "block";
    txt_tipo_placa_vehiculo.disabled = false;
    txt_servicio_vehiculo.disabled = false;
    panelOrdenanza.style.display = 'none';
}

$(".card_ingreso").click(function () {

    if (accionFormulario == "MOD") {
        return;
    }

    const $this = $(this);

    // Si ya tenía la clase, desactiva todo
    if ($this.hasClass("clickeado")) {
        $this.removeClass("clickeado");
        $this.find("i").addClass("card_ingreso--check--oculto");
        tipo_ingreso_vehicular.value = "0";
        btnSiguienteIngresoVehicular.disabled = true;
    } else {
        // Quita la clase y oculta el ícono de todas las tarjetas
        $(".card_ingreso").removeClass("clickeado");
        $(".card_ingreso i").addClass("card_ingreso--check--oculto");

        // Activa esta tarjeta y muestra su ícono
        $this.addClass("clickeado");
        $this.find("i").removeClass("card_ingreso--check--oculto");
        tipo_ingreso_vehicular.value = $this.data("id");
        btnSiguienteIngresoVehicular.disabled = false;
    }
});