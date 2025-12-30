let btnAnadirRegistro = document.getElementById('btn_add_arrendamiento');
let btnBorrarRegistro = document.getElementById('btn_confirm_delete_arrendamiento');
let btnCancelBorrarRegistro = document.getElementById('btn_cancelar_delete_arrendamiento');
let iframe_view_document = document.getElementById('iframe_visor_convocatoria');
let modalConfirmDeleteRegister = "#modal_confirmacion_delete_arrendamiento";
let id_table_convocatoria_arrendamiento = 'table_convocatoria_arrendamiento';
let idConvocatoriaArrendamientoToDelete = 0;
let archivoConvocatoriaArrendamientoToDelete = '';

//controles formulario ingresar o modificar convocatoria de arrendamiento
let btnSaveConvocatoriaArrendamiento = document.getElementById('btn_guardar_convocatoria_arrendamiento');
let txtDescripcion = document.getElementById('txt_descripcion_modal_add_mod_convocatoria_arrendamiento');
let inputPdf = document.getElementById('txt_file_archivo_modal_add_mod_convocatoria_arrendamiento');
let idInput = document.getElementById('id_modal_add_mod_convocatoria_arrendamiento');
let archivoOld = document.getElementById('archivo_old_modal_add_mod_convocatoria_arrendamiento');
let formulario = document.getElementById('form_modal_add_mod_convocatoria_arrendamiento');
let estado_convocatoria = document.getElementById('chk_estado_modal_add_mod_convocatoria_arrendamiento');
let accionFormulario = "ADD";
//------------------------------------

$(document).ready(function () {
    getListarConvocatoriaArriendamiento();
    $('.dropify').dropify();

    setInputValidations('txt_descripcion_modal_add_mod_convocatoria_arrendamiento', ['notEmpty'], []);
    setInputValidations('txt_file_archivo_modal_add_mod_convocatoria_arrendamiento', ['notEmpty'], []);
});

btnSaveConvocatoriaArrendamiento.addEventListener('click', () => {
    let errores = '';

    errores += txtDescripcion.validateInput();
    errores += inputPdf.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar la nueva convocatoria, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $(`#${btnSaveConvocatoriaArrendamiento.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando convocatoria..</span>");
        const token = $("#csrf_token_modal_add_mod_convocatoria").val();
        const datos = new FormData($("#form_modal_add_mod_convocatoria_arrendamiento")[0]);

        if (accionFormulario == "ADD") {
            $.ajax({
                url: '/convocatoria_arrendamiento/store',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveConvocatoriaArrendamiento.id}`).html("<i class='fa fa-save'></i> <span id='text_save_convocatoria_arrendamiento'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito la convocatoria de arrendamiento",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarConvocatoriaArriendamiento();
                        $("#modal_add_mod_convocatoria_arrendamiento").modal("hide");
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
                url: '/convocatoria_arrendamiento/update',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveConvocatoriaArrendamiento.id}`).html("<i class='fa fa-save'></i> <span id='text_save_convocatoria_arrendamiento'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito la convocatoria de arrendamiento",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarConvocatoriaArriendamiento();
                        $("#modal_add_mod_convocatoria_arrendamiento").modal("hide");
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

iframe_view_document.addEventListener('load', () => {
    iframe_view_document.style.display = "block";
});

btnAnadirRegistro.addEventListener('click', () => {
    $("#modal_add_mod_convocatoria_arrendamiento").modal("show");
    accionFormulario = "ADD";
    txtDescripcion.value = "";
    inputPdf.value = "";
    estado_convocatoria.checked = true;
    var drEvent2 = $(`#${inputPdf.id}`).dropify();
    drEvent2 = drEvent2.data('dropify');
    drEvent2.resetPreview();
    drEvent2.clearElement();
});

function getListarConvocatoriaArriendamiento() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/convocatoria_arrendamiento/get_list',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml(id_table_convocatoria_arrendamiento,
                ['#', 'DESCRIPCION', 'PDF', 'OPCIONES'],
                ['ca_id', 'ca_descripcion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `
                                <button type="button" onClick="view_convocatoria_arrendamiento_pdf('${item.ca_nombre_archivo}')" class="tooltip"><span class="tooltiptext">Ver documento</span> <i class="far fa-file-pdf tam-pdf"></i></button>
                            `;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            console.log(item);
                            return `<button type="button" class="btn btn-warning btn-modal-editar tooltip" Onclick ="show_mod_convocatoria_arrendamiento(${item.ca_id}, '${item.ca_descripcion}','${item.ca_nombre_archivo}', '${item.ca_nombre_archivo_original}', ${item.ca_estado})"><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
                                    <button type="button" class="btn btn-danger btn-modal-eliminar tooltip" Onclick ="show_delete_convocatoria_arrendamiento(${item.ca_id},'${item.ca_nombre_archivo}')"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>`;

                        }
                    },
                ], response
            );

            $("#div_table_convocatoria_arrendamiento").html(html);

            $(`#${id_table_convocatoria_arrendamiento}`).DataTable({
                "order": [[0, 'asc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

btnCancelBorrarRegistro.addEventListener('click', () => {
    idConvocatoriaArrendamientoToDelete = 0;
    $(modalConfirmDeleteRegister).modal("hide");
});

function view_convocatoria_arrendamiento_pdf(nombre_archivo) {
    iframe_view_document.style.display = "none";
    iframe_view_document.src = `/convocatoria_arrendamiento/archivo/${nombre_archivo}`;
    $("#modal_view_pdf_convocatoria").modal("show");
}

function show_mod_convocatoria_arrendamiento(id, descripcion, nombre_archivo, nombre_archivo_original, estado) {
    console.log(estado);
    accionFormulario = "MOD";
    idInput.value = id;
    txtDescripcion.value = descripcion;
    archivoOld.value = nombre_archivo;
    estado_convocatoria.checked = estado;

    fetch(`/convocatoria_arrendamiento/archivo/${nombre_archivo}`)
        .then(response => response.blob())
        .then(blob => {
            // Crear un objeto File a partir del Blob
            let file = new File([blob], nombre_archivo_original, { type: "application/pdf" });

            // Crear un objeto DataTransfer para simular la selección del archivo
            let dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);

            // Establecer los archivos seleccionados en el input
            inputPdf.files = dataTransfer.files;

            // Disparar el evento change en el input para simular la selección del archivo
            inputPdf.dispatchEvent(new Event("change"));
        });

    $("#modal_add_mod_convocatoria_arrendamiento").modal("show");
}

function show_delete_convocatoria_arrendamiento(id, archivo) {
    idConvocatoriaArrendamientoToDelete = id;
    archivoConvocatoriaArrendamientoToDelete = archivo;
    $("#modal_confirmacion_delete_arrendamiento").modal("show");
}

btnBorrarRegistro.addEventListener('click', () => {
    let id = idConvocatoriaArrendamientoToDelete;
    let token = $("#csrf-token").val();
    const datos = new FormData();
    datos.append('archivo', archivoConvocatoriaArrendamientoToDelete);
    $("#modal_confirmacion_delete_arrendamiento").modal('hide');
    $.ajax({
        url: `/convocatoria_arrendamiento/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Convocatoria de Arrendamiento Eliminada!",
                    type: "success",
                    zindex: 99999
                });
                idConvocatoriaArrendamientoToDelete = 0;
                getListarConvocatoriaArriendamiento();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la convocatoria de arrendamiento",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirmacion_delete_arrendamiento").modal('hide');
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
});