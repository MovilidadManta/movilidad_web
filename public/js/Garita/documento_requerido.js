let btnAnadirRegistro = document.getElementById('btn_add_documento_requerido');
let btnBorrarRegistro = document.getElementById('btn_confirm_delete_documento_requerido');
let btnCancelBorrarRegistro = document.getElementById('btn_cancelar_delete_documento_requerido');
let modalConfirmDeleteRegister = "#modal_confirmacion_delete_documento_requerido";
let id_table_documento_requerido = 'table_documentos_requeridos';
let idDocumentoRequeridoToDelete = 0;

//controles formulario ingresar o modificar documentos requeridos
let btnSaveDocumentoRequerido = document.getElementById('btn_guardar_documento_requerido');
let txtNombre = document.getElementById('txt_nombre_modal_add_mod_documento_requerido');
let txtObservacion = document.getElementById('txt_observacion_modal_add_mod_documento_requerido');
let idInput = document.getElementById('id_modal_add_mod_documento_requerido');
let formulario = document.getElementById('form_modal_add_mod_documento_requerido');
let estado_requerido = document.getElementById('chk_estado_requerido_modal_add_mod_documento_requerido');
let accionFormulario = "ADD";
//------------------------------------

$(document).ready(function () {
    getListarDocumentoRequerido();
    $('.dropify').dropify();

    setInputValidations('txt_nombre_modal_add_mod_documento_requerido', ['notEmpty'], []);
});

btnSaveDocumentoRequerido.addEventListener('click', () => {
    let errores = '';

    errores += txtNombre.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar el documento requerido, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $(`#${btnSaveDocumentoRequerido.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando Documento requerido..</span>");
        const token = $("#csrf_token_modal_add_mod_documento_requerido").val();
        const datos = new FormData($("#form_modal_add_mod_documento_requerido")[0]);

        if (accionFormulario == "ADD") {
            $.ajax({
                url: '/garita/documento_requerido/store',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveDocumentoRequerido.id}`).html("<i class='fa fa-save'></i> <span id='text_save_documento_requerido'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito el documento requerido",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarDocumentoRequerido();
                        $("#modal_add_mod_documento_requerido").modal("hide");
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
                url: '/garita/documento_requerido/update',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveDocumentoRequerido.id}`).html("<i class='fa fa-save'></i> <span id='text_save_documento_requerido'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito el documento requerido",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarDocumentoRequerido();
                        $("#modal_add_mod_documento_requerido").modal("hide");
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

btnAnadirRegistro.addEventListener('click', () => {
    $("#modal_add_mod_documento_requerido").modal("show");

    accionFormulario = "ADD";
    txtNombre.value = "";
    txtObservacion.value = "";
    estado_requerido.checked = true;
    estado_requerido.dispatchEvent(new Event('change'));
});

function getListarDocumentoRequerido() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/garita/documento_requerido/list',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml(id_table_documento_requerido,
                ['#', 'NOMBRE', 'OBSERVACIONES', 'REQUERIDO', 'OPCIONES'],
                ['d_id', 'd_nombre', 'd_observacion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return item.d_es_requerido
                                ? '<span class= "badge bg-success me-1 status_document">SI <i class="fa fa-check-circle-o " aria-hidden="true"></i></span>'
                                : '<span class= "badge bg-danger me-1 status_document">NO <i class="fa fa-times " aria-hidden="true"></i></span>';
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `<button type="button" class="btn btn-warning btn-modal-editar tooltip" Onclick ="show_mod_documento_requerido(${item.d_id}, '${item.d_nombre}','${item.d_observacion}', ${item.d_es_requerido})"><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
                                    <button type="button" class="btn btn-danger btn-modal-eliminar tooltip" Onclick ="show_delete_documento_requerido(${item.d_id})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>`;

                        }
                    },
                ], response
            );

            $("#div_table_documentos_requeridos").html(html);

            $(`#${id_table_documento_requerido}`).DataTable({
                "order": [[0, 'asc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

btnCancelBorrarRegistro.addEventListener('click', () => {
    idDocumentoRequeridoToDelete = 0;
    $(modalConfirmDeleteRegister).modal("hide");
});

function show_mod_documento_requerido(id, nombre, observacion, es_requerido) {
    accionFormulario = "MOD";
    idInput.value = id;
    txtNombre.value = nombre;
    txtObservacion.value = observacion;
    estado_requerido.checked = es_requerido;
    estado_requerido.dispatchEvent(new Event('change'));

    $("#modal_add_mod_documento_requerido").modal("show");
}

function show_delete_documento_requerido(id) {
    idDocumentoRequeridoToDelete = id;
    $(modalConfirmDeleteRegister).modal("show");
}

btnBorrarRegistro.addEventListener('click', () => {
    let id = idDocumentoRequeridoToDelete;
    let token = $("#csrf-token").val();
    const datos = new FormData();
    $(modalConfirmDeleteRegister).modal('hide');
    $.ajax({
        url: `/garita/documento_requerido/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Documento Requerido Eliminado!",
                    type: "success",
                    zindex: 99999
                });
                idDocumentoRequeridoToDelete = 0;
                getListarDocumentoRequerido();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar el documento requerido",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
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