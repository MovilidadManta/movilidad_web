let btnAnadirRegistro = document.getElementById('btn_add_tipo_ingreso_vehicular');
let btnBorrarRegistro = document.getElementById('btn_confirm_delete_tipo_ingreso_vehicular');
let btnCancelBorrarRegistro = document.getElementById('btn_cancelar_delete_tipo_ingreso_vehicular');
let modalConfirmDeleteRegister = "#modal_confirmacion_delete_tipo_ingreso_vehicular";
let id_table_tipo_ingreso_vehicular = 'table_tipo_ingreso_vehicular';
let idTipoIngresoVehicularToDelete = 0;

//controles formulario ingresar o modificar convocatoria de arrendamiento
let btnSaveTipoIngresoVehicular = document.getElementById('btn_guardar_tipo_ingreso_vehicular');
let txtNombre = document.getElementById('txt_nombre_modal_add_mod_tipo_ingreso_vehicular');
let txtDiasRetencion = document.getElementById('txt_dias_retencion_modal_add_mod_tipo_ingreso_vehicular');
let txtObservacion = document.getElementById('txt_observacion_modal_add_mod_tipo_ingreso_vehicular');
let idInput = document.getElementById('id_modal_add_mod_tipo_ingreso_vehicular');
let formulario = document.getElementById('form_modal_add_mod_tipo_ingreso_vehicular');
let estado_tipo_ingreso_vehicular = document.getElementById('chk_estado_modal_add_mod_tipo_ingreso_vehicular');
let accionFormulario = "ADD";
//------------------------------------

//elementos para documentos requeridos
const containerDocumentosRequeridos = document.getElementById("container_documentos_requeridos");
//-----------------------------------

$(document).ready(function () {
    getListarTipoIngresoVehicular();
    getDocumentosRequeridos();
    $('.dropify').dropify();

    set_type_input('txt_dias_retencion_modal_add_mod_tipo_ingreso_vehicular', "number");
    setInputValidations('txt_nombre_modal_add_mod_tipo_ingreso_vehicular', ['notEmpty'], []);
    setInputValidations('txt_dias_retencion_modal_add_mod_tipo_ingreso_vehicular', ['notEmpty'], []);
});

btnSaveTipoIngresoVehicular.addEventListener('click', () => {
    let errores = '';
    let camposDocumentos = [];

    const elementsDocumentsCheckBox = containerDocumentosRequeridos.querySelectorAll('input[type="checkbox"]:checked');
    errores += txtNombre.validateInput();
    errores += txtDiasRetencion.validateInput();

    elementsDocumentsCheckBox.forEach(e => {
        camposDocumentos.push({
            d_id: e.value
        });
    });

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar el tipo de ingreso vehicular, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $(`#${btnSaveTipoIngresoVehicular.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando Tipo de ingreso Vehícular..</span>");
        const token = $("#csrf_token_modal_add_mod_tipo_ingreso_vehicular").val();
        const datos = new FormData($("#form_modal_add_mod_tipo_ingreso_vehicular")[0]);
        datos.append('campos', JSON.stringify(camposDocumentos));

        if (accionFormulario == "ADD") {
            $.ajax({
                url: '/garita/tipo_ingreso_vehicular/store',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveTipoIngresoVehicular.id}`).html("<i class='fa fa-save'></i> <span id='text_save_tipo_vehiculo'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito el tipo de ingreso vehicular",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarTipoIngresoVehicular();
                        $("#modal_add_mod_tipo_ingreso_vehicular").modal("hide");
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
                url: '/garita/tipo_ingreso_vehicular/update',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveTipoIngresoVehicular.id}`).html("<i class='fa fa-save'></i> <span id='text_save_tipo_vehiculo'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito el tipo de ingreso vehícular",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarTipoIngresoVehicular();
                        $("#modal_add_mod_tipo_ingreso_vehicular").modal("hide");
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
    $("#modal_add_mod_tipo_ingreso_vehicular").modal("show");

    accionFormulario = "ADD";
    txtNombre.value = "";
    txtDiasRetencion.value = "";
    txtObservacion.value = "";
    estado_tipo_ingreso_vehicular.checked = true;
});

function getListarTipoIngresoVehicular() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/garita/tipo_ingreso_vehicular/list',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml(id_table_tipo_ingreso_vehicular,
                ['#', 'NOMBRE', 'DIAS RETENCIÓN', 'OBSERVACIONES', 'ESTADO', 'OPCIONES'],
                ['tiv_id', 'tiv_nombre', 'tiv_dias_retencion', 'tiv_observacion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return item.tiv_estado
                                ? '<span class="badge bg-success me-1">Activo</span>'
                                : '<span class="badge bg-danger me-1">Inactivo</span>';
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `<button type="button" class="btn btn-warning btn-modal-editar tooltip" Onclick ='show_mod_tipo_ingreso_vehicular(${item.tiv_id}, "${item.tiv_nombre}","${item.tiv_dias_retencion}", "${item.tiv_observacion}", ${item.tiv_estado},${JSON.stringify(JSON.parse(item.list_documentos))})'><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
                                    <button type="button" class="btn btn-danger btn-modal-eliminar tooltip" Onclick ="show_delete_tipo_ingreso_vehicular(${item.tiv_id})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>`;

                        }
                    },
                ], response
            );

            $("#div_table_tipo_ingreso_vehicular").html(html);

            $(`#${id_table_tipo_ingreso_vehicular}`).DataTable({
                "order": [[0, 'asc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

btnCancelBorrarRegistro.addEventListener('click', () => {
    idTipoIngresoVehicularToDelete = 0;
    $(modalConfirmDeleteRegister).modal("hide");
});

function show_mod_tipo_ingreso_vehicular(id, nombre, dias_retencion, observacion, estado, list_documentos) {
    accionFormulario = "MOD";
    idInput.value = id;
    txtNombre.value = nombre;
    txtDiasRetencion.value = dias_retencion;
    txtObservacion.value = observacion;
    estado_tipo_ingreso_vehicular.checked = estado;
    const elementsDocumentsCheckBox = containerDocumentosRequeridos.querySelectorAll('input[type="checkbox"]');

    elementsDocumentsCheckBox.forEach(e => {
        e.checked = false;

        const itemFound = list_documentos.filter((i) => i.d_id == e.value);

        if (itemFound.length > 0)
            e.checked = true;
    });


    $("#modal_add_mod_tipo_ingreso_vehicular").modal("show");
}

function show_delete_tipo_ingreso_vehicular(id) {
    idTipoIngresoVehicularToDelete = id;
    $("#modal_confirmacion_delete_tipo_ingreso_vehicular").modal("show");
}

btnBorrarRegistro.addEventListener('click', () => {
    let id = idTipoIngresoVehicularToDelete;
    let token = $("#csrf-token").val();
    const datos = new FormData();
    $("#modal_confirmacion_delete_tipo_ingreso_vehicular").modal('hide');
    $.ajax({
        url: `/garita/tipo_ingreso_vehicular/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Tipo de Ingreso Vehicular Eliminado!",
                    type: "success",
                    zindex: 99999
                });
                idTipoVehiculoToDelete = 0;
                getListarTipoIngresoVehicular();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar el tipo de ingreso de vehicular",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirmacion_delete_tipo_ingreso_vehicular").modal('hide');
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

function getDocumentosRequeridos() {
    $.ajax({
        url: '/garita/documento_requerido/list',
        type: "GET",
        dataType: "json",
        success: function (response) {
            containerDocumentosRequeridos.innerHTML = "";
            response.forEach(r => {
                containerDocumentosRequeridos.innerHTML += `
                        <span>
                            <label for="c_${r.d_id}">${r.d_nombre}</label>
                            <input type="checkbox" id="c_${r.d_id}" value="${r.d_id}"  />
                        </span>
                    `;
            }
            );

        }
    });
}