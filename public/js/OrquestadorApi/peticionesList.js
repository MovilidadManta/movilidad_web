let btnAnadirRegistro = document.getElementById('btn_add_proveedor_api');
let btnAnadirRegistroPeticion = document.getElementById('btn_add_peticion');
let btnBorrarRegistro = document.getElementById('btn_confirm_delete_proveedor_api');
let btnCancelBorrarRegistro = document.getElementById('btn_cancelar_delete_proveedor_api');
let btnBorrarRegistroPeticion = document.getElementById('btn_confirm_delete_peticion');
let btnCancelBorrarRegistroPeticion = document.getElementById('btn_cancelar_delete_peticion');
let modalConfirmDeleteRegister = "#modal_confirmacion_delete_proveedor_api";
let modalConfirmDeleteRegisterPeticion = "#modal_confirmacion_delete_peticion";
let id_table_proveedor_api = 'table_proveedor_api';
let id_table_peticiones = 'table_peticiones';
let id_table_proveedor_api_service = 'table_proveedor_service_api';
let idProveedorApiToDelete = 0;
let idPeticionToDelete = 0;
let idProveedorApiPetitions = 0;
let contOpciones = 0;

//controles formulario ingresar o modificar proveedores api
let btnSaveProveedor = document.getElementById('btn_guardar_proveedor_api');
let idProveedorApi = document.getElementById('id_modal_add_mod_proveedor');
let txtRuc = document.getElementById('txt_ruc_modal_add_mod_proveedor');
let txtEmpresa = document.getElementById('txt_empresa_modal_add_mod_proveedor');
let txtModulo = document.getElementById('txt_modulo_modal_add_mod_proveedor');
let accionFormulario = "ADD";
//------------------------------------

//controles formulario ingresar o modificar peticiones servicios
let btnSaveProveedorService = document.getElementById('btn_guardar_proveedor_servicio');
let btnAddProveedorService = document.getElementById('btn_add_proveedor_service');
let idProveedorApiService = document.getElementById('ps_id_modal_add_mod_proveedor_servicio');
let actionProveedorServicio = document.getElementById('ps_action_modal_add_mod_proveedor_servicio');
let selectTipoAPI = document.getElementById('select_format_api_modal_add_mod_proveedor_servicio');
let txtUrl = document.getElementById('txt_url_modal_add_mod_proveedor_servicio');
let txtNameService = document.getElementById('txt_name_modal_add_mod_proveedor_servicio');
let txtCont = document.getElementById('cont_modal_add_mod_proveedor_servicio');
let txtHeaders = document.getElementById('txt_headers_modal_add_mod_proveedor_servicio');
let listProveedoresApiUrl = [];
let contProveedoresApi = 0;
//------------------------------------

//controles formulario ingresar o modificar peticiones
let btnSavePeticion = document.getElementById('btn_guardar_peticion');
let txtPeticion = document.getElementById('txt_peticion_modal_add_mod_peticion');
let selectVerbSend = document.getElementById('select_verb_send_modal_add_mod_peticion');
let txtRequest = document.getElementById('txt_request_modal_add_mod_peticion');
let txtRequestAPI = document.getElementById('txt_request_api_modal_add_mod_peticion');
let idInput = document.getElementById('id_modal_add_mod_peticion');
let formulario = document.getElementById('form_modal_add_mod_peticion');
const select_url_peticiones = document.getElementById('select_ps_id_modal_add_mod_peticion');
let accionFormularioPeticion = "ADD";

let tbody_responses_peticiones = document.getElementById("tbody_configurar_respuestas");
//------------------------------------

//Controles configurar Respuestas
let accionConfigurarRespuesta = "ADD";
let txt_p_id_peticion = document.getElementById('p_id_peticion');
let txtCodigoRespuesta = document.getElementById('txt_codigo_respuesta');
let txtCodigoApi = document.getElementById('txt_codigo_api');
let txtFormatoRespuesta = document.getElementById('txt_formato_respuesta');
let txtFormatoApi = document.getElementById('txt_formato_api');
let txtOrden = document.getElementById('txt_orden');
let btnNuevoRespuesta = document.getElementById('btn_nuevo_respuesta');
let tituloConfigurarRespuesta = document.getElementById('title_modal_configurar_respuestas');
let btnGuardarRespuesta = document.getElementById('btn_guardar_respuesta');
let btnConfirmarDeletePeticionRespuesta = document.getElementById('btn_confirm_delete_peticion_respuesta');
let btnCancelarDeletePeticionRespuesta = document.getElementById('btn_cancelar_delete_peticion_respuesta');
let idPeticionRespuestaToDelete = {};
//-----------------------------------------

$(document).ready(function () {
    getListarProveedoresApi();

    setInputValidations('txt_peticion_modal_add_mod_peticion', ['notEmpty'], []);
    setInputValidations('txt_url_modal_add_mod_proveedor_servicio', ['notEmpty'], []);
    setInputValidations('txt_name_modal_add_mod_proveedor_servicio', ['notEmpty'], []);
    setInputValidations('txt_request_modal_add_mod_peticion', ['notEmpty'], []);
    setInputValidations('txt_request_api_modal_add_mod_peticion', ['notEmpty'], []);
    setInputValidations('txt_empresa_modal_add_mod_proveedor', ['notEmpty'], []);
    setInputValidations('txt_modulo_modal_add_mod_proveedor', ['notEmpty'], []);

    //Modal de Configurar Respuestas
    set_type_input('txt_codigo_respuesta', 'number');
    set_type_input('txt_codigo_api', 'number');
    set_type_input('txt_orden', 'number');
    set_type_input('txt_ruc_modal_add_mod_proveedor', 'number');
    setInputValidations('txt_codigo_respuesta', ['notEmpty'], []);
    setInputValidations('txt_codigo_api', ['notEmpty'], []);
    setInputValidations('txt_formato_respuesta', ['notEmpty'], []);
    setInputValidations('txt_formato_api', ['notEmpty'], []);
    setInputValidations('txt_orden', ['notEmpty'], []);

    idProveedorApi.value = 0;
});

btnSavePeticion.addEventListener('click', () => {
    let errores = '';

    errores += txtPeticion.validateInput();
    errores += txtRequest.validateInput();
    errores += txtRequestAPI.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar la peticion, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $(`#${btnSavePeticion.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando peticion..</span>");
        const token = $("#csrf_token_modal_add_mod_peticion").val();
        const datos = new FormData($("#form_modal_add_mod_peticion")[0]);

        if (accionFormularioPeticion == "ADD") {
            $.ajax({
                url: '/orquestadorapi/peticion/store',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSavePeticion.id}`).html("<i class='fa fa-save'></i> <span id='text_save_peticion'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito la petición",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarPeticiones();
                        $("#modal_add_mod_peticion").modal("hide");
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

        if (accionFormularioPeticion == "MOD") {
            $.ajax({
                url: '/orquestadorapi/peticion/update',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSavePeticion.id}`).html("<i class='fa fa-save'></i> <span id='text_save_peticion'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito la petición",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarPeticiones();
                        $("#modal_add_mod_peticion").modal("hide");
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

    $("#modal_add_mod_proveedor").modal("show");
    accionFormulario = "ADD";
    idProveedorApi.value = 0;
    txtRuc.value = "";
    txtEmpresa.value = "";
    txtModulo.value = "";
    listProveedoresApiUrl = [];
    getListarProveedoresServices();
});

function getListarPeticiones() {
    $.ajax({
        url: `/orquestadorapi/peticion/get_list/${idProveedorApiPetitions}`,
        type: "GET",
        dataType: "json",
        data: "",
        success: function (response) {
            let html = configureTableHtml(id_table_peticiones,
                ['#', 'MÓDULO', 'PETICIÓN', 'FORMATO', 'VERBO', 'OPCIONES'],
                ['p_id', 'p_modulo', 'p_peticion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.ps_format_api == 1) {
                                value = 'SOAP';
                            } else {
                                value = 'API';
                            }
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.p_verb_send == 1) {
                                value = 'GET';
                            } else if (item.p_verb_send == 2) {
                                value = 'POST';
                            } else if (item.p_verb_send == 3) {
                                value = 'PUT';
                            } else {
                                value = 'DELETE';
                            }
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            console.log(item);
                            return `<button type="button" class="btn btn-info btn-modal-show-response tooltip" Onclick ="show_responses_peticion(${item.p_id}, '${item.p_peticion}')"><span class="tooltiptext">Repuestas</span><i class="fa fa-list-alt tam-icono icon_elevated"></i></button>
                                    <button type="button" class="btn btn-warning btn-modal-editar tooltip" Onclick ="show_mod_peticion(${item.p_id})"><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
                                    <button type="button" class="btn btn-danger btn-modal-eliminar tooltip" Onclick ="show_delete_peticion(${item.p_id})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>`;

                        }
                    },
                ], response
            );

            $("#div_table_peticiones").html(html);

            $(`#${id_table_peticiones}`).DataTable({
                "order": [[0, 'asc']]
            });
        }
    });
}

btnCancelBorrarRegistroPeticion.addEventListener('click', () => {
    idPeticionToDelete = 0;
    $(modalConfirmDeleteRegisterPeticion).modal("hide");
});

function show_responses_peticion(p_id, p_peticion) {
    $.ajax({
        url: `/orquestadorapi/peticion/getResponses/${p_id}`,
        type: "GET",
        dataType: "json",
        data: "",
        success: function (response) {
            console.log(response);
            renderTableResponse(response);
            txt_p_id_peticion.value = p_id;
            tituloConfigurarRespuesta.innerText = p_peticion;
            btnNuevoRespuesta.click();
            $("#modal_configurar_respuestas").modal("show");
        }
    });
}

function renderTableResponse(data) {
    let itemsResponses = [];
    tbody_responses_peticiones.innerHTML = '';
    if (data.length == 0) {
        tbody_responses_peticiones.innerHTML = `
        <tr> 
            <td colspan="4" align="center" class="color-td"> No hay respuestas configuradas</td>
        </tr>`;
    }

    data.forEach(d => {
        contOpciones++;
        tbody_responses_peticiones.innerHTML += `
        <tr> 
            <td align="center" class="color-td">${d.r_codigo}</td>
            <td align="center" class="color-td">${d.r_codigo_response}</td>
            <td align="center" class="color-td">${d.r_orden}</td>
            <td align="center" class="color-td">
                <button type="button" id="btn_editar_respuesta_${contOpciones}" class="tam-btn btn btn-warning"><i class="fa fa-pencil tam-icono"></i></button>
                <button type="button" id="btn_eliminar_respuesta_${contOpciones}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>
            </td>
        </tr>`;

        itemsResponses.push({
            cont: contOpciones,
            item: d
        });

    });

    itemsResponses.forEach(i => {
        asingButtonEventsResponse(i.cont, i.item);
    });

}

function asingButtonEventsResponse(cont, item) {
    let editarRespuesta = document.getElementById(`btn_editar_respuesta_${cont}`);
    let borrarRespuesta = document.getElementById(`btn_eliminar_respuesta_${cont}`);

    editarRespuesta.addEventListener('click', () => {
        accionConfigurarRespuesta = "MOD";
        txtCodigoRespuesta.value = item.r_codigo;
        txtCodigoApi.value = item.r_codigo_response;
        txtFormatoRespuesta.value = item.r_response_api;
        txtFormatoApi.value = item.r_format_api;
        txtOrden.value = item.r_orden;
    });

    borrarRespuesta.addEventListener('click', () => {
        idPeticionRespuestaToDelete = {
            p_id: item.p_id,
            r_codigo: item.r_codigo,
            r_codigo_response: item.r_codigo_response,
            r_orden: item.r_orden
        };

        $("#modal_confirmacion_delete_peticion_respuesta").modal("show");
    });
}

btnNuevoRespuesta.addEventListener('click', () => {
    accionConfigurarRespuesta = "ADD";
    txtCodigoRespuesta.value = "";
    txtCodigoApi.value = "";
    txtFormatoRespuesta.value = "";
    txtFormatoApi.value = "";
    txtOrden.value = "";
});

btnGuardarRespuesta.addEventListener('click', () => {

    $(`#${btnGuardarRespuesta.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando respuesta..</span>");
    const token = $("#csrf_token_configurar_respuestas").val();
    const datos = new FormData();
    datos.append('p_id', txt_p_id_peticion.value);
    datos.append('r_codigo', txtCodigoRespuesta.value);
    datos.append('r_codigo_response', txtCodigoApi.value);
    datos.append('r_response_api', txtFormatoRespuesta.value);
    datos.append('r_format_api', txtFormatoApi.value);
    datos.append('r_orden', txtOrden.value);
    datos.append('r_estado', true);

    if (accionConfigurarRespuesta == "ADD") {
        $.ajax({
            url: '/orquestadorapi/peticion/storeRespuesta',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    $(`#${btnGuardarRespuesta.id}`).html("<i class='fa fa-save'></i> Guardar");
                    notif({
                        type: "success",
                        msg: "<b>Aviso: </b>Se ha guardado con éxito la respuesta",
                        position: "right",
                        autohide: true,
                        zindex: 99999
                    });
                    show_responses_peticion(txt_p_id_peticion.value, tituloConfigurarRespuesta.innerText);
                    btnNuevoRespuesta.click();
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

    if (accionConfigurarRespuesta == "MOD") {
        $.ajax({
            url: '/orquestadorapi/peticion/updateRespuesta',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    $(`#${btnGuardarRespuesta.id}`).html("<i class='fa fa-save'></i> Guardar");
                    notif({
                        type: "success",
                        msg: "<b>Aviso: </b>Se ha modificado con éxito la respuesta",
                        position: "right",
                        autohide: true,
                        zindex: 99999
                    });
                    show_responses_peticion(txt_p_id_peticion.value, tituloConfigurarRespuesta.innerText);
                    btnNuevoRespuesta.click();
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

});

btnConfirmarDeletePeticionRespuesta.addEventListener('click', () => {

    const token = $("#csrf_token_configurar_respuestas").val();

    $.ajax({
        url: `/orquestadorapi/peticion/deleteRespuesta/${idPeticionRespuestaToDelete.p_id}/${idPeticionRespuestaToDelete.r_codigo}/${idPeticionRespuestaToDelete.r_codigo_response}/${idPeticionRespuestaToDelete.r_orden}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Respuesta de Petición Eliminada!",
                    type: "success",
                    zindex: 99999
                });
                show_responses_peticion(txt_p_id_peticion.value, tituloConfigurarRespuesta.innerText);
                $("#modal_confirmacion_delete_peticion_respuesta").modal("hide");
                btnNuevoRespuesta.click();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la respuesta de la petición",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                show_responses_peticion(txt_p_id_peticion.value, tituloConfigurarRespuesta.innerText);
                $("#modal_confirmacion_delete_peticion_respuesta").modal("hide");
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

btnCancelarDeletePeticionRespuesta.addEventListener('click', () => {
    idPeticionRespuestaToDelete = {};
    $("#modal_confirmacion_delete_peticion_respuesta").modal("hide");
});

function show_mod_peticion(p_id) {

    $.ajax({
        url: `/orquestadorapi/peticion/get/${p_id}`,
        type: "GET",
        dataType: "json",
        data: "",
        success: function (response) {
            //console.log(response);
            accionFormularioPeticion = "MOD";
            idInput.value = response.p_id;
            txtPeticion.value = response.p_peticion;
            selectVerbSend.value = response.p_verb_send;
            txtRequest.value = response.p_request;
            txtRequestAPI.value = response.p_request_api;
            select_url_peticiones.value = response.ps_id;

            $("#modal_add_mod_peticion").modal("show");
        }
    });

}

function show_delete_peticion(id) {
    idPeticionToDelete = id;
    $("#modal_confirmacion_delete_peticion").modal("show");
}

btnBorrarRegistroPeticion.addEventListener('click', () => {
    let id = idPeticionToDelete;
    let token = $("#csrf-token").val();
    $("#modal_confirmacion_delete_peticion").modal('hide');
    $.ajax({
        url: `/orquestadorapi/peticion/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Petición Eliminado!",
                    type: "success",
                    zindex: 99999
                });
                idPeticionToDelete = 0;
                getListarPeticiones();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la petición",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirmacion_delete_peticion").modal('hide');
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

function getListarProveedoresApi() {
    $.ajax({
        url: '/orquestadorapi/peticion/get_proveedores_api',
        type: "GET",
        dataType: "json",
        data: "",
        success: function (response) {
            let html = configureTableHtml(id_table_proveedor_api,
                ['#', 'EMPRESA', 'RUC', 'MODULO', 'OPCIONES'],
                ['p_id', 'p_nombre_empresa',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return item.p_ruc ?? '';

                        }
                    }, 'p_modulo',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `<button type="button" class="btn btn-info btn-modal-show-response tooltip" Onclick ="show_proveedor_api_peticiones(${item.p_id})"><span class="tooltiptext">Peticiones</span><i class="fa fa-rss-square tam-icono icon_elevated"></i></button>
                                    <button type="button" class="btn btn-warning btn-modal-editar tooltip" Onclick ="show_mod_proveedor_api(${item.p_id},'${item.p_nombre_empresa}', '${item.p_ruc ?? ''}','${item.p_modulo}')"><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
                                    <button type="button" class="btn btn-danger btn-modal-eliminar tooltip" Onclick ="show_delete_proveedor_api(${item.p_id})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>`;

                        }
                    },
                ], response
            );

            $("#div_table_proveedor_api").html(html);

            $(`#${id_table_proveedor_api}`).DataTable({
                "order": [[0, 'asc']]
            });
        }
    });
}

function getListarProveedoresServices() {
    listProveedoresApiUrl = [];
    $.ajax({
        url: `/orquestadorapi/peticion/get_proveedores_service/${idProveedorApi.value}`,
        type: "GET",
        dataType: "json",
        data: "",
        success: function (response) {
            let html = configureTableHtml(id_table_proveedor_api_service,
                ['#', 'FORMATO', 'NOMBRE', 'URL', 'OPCIONES'],
                ['ps_id',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.ps_format_api == 1) {
                                value = 'SOAP';
                            } else {
                                value = 'API';
                            }
                            return value;
                        }
                    },
                    'ps_name',
                    'ps_url',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            contProveedoresApi++;
                            add_mod_eli_list_proveedor_api("LOAD", item.ps_id, item.ps_format_api, item.ps_name, item.ps_url, item.ps_headers_api);
                            return `<button type="button" class="btn btn-warning btn-modal-editar tooltip" Onclick ="show_mod_proveedor_api_service(${contProveedoresApi})"><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
                                    <button type="button" class="btn btn-danger btn-modal-eliminar tooltip" Onclick ="show_delete_proveedor_api_service(${contProveedoresApi})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>`;

                        }
                    },
                ], response
            );

            $("#div_table_proveedor_api_service").html(html);

            $(`#${id_table_proveedor_api_service}`).DataTable({
                "order": [[0, 'asc']]
            });
        }
    });
}

btnSaveProveedor.addEventListener('click', () => {

    let errores = '';

    errores += txtEmpresa.validateInput();
    errores += txtModulo.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar el proveedor, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $(`#${btnSaveProveedor.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando proveedor..</span>");
        const token = $("#csrf_token_modal_add_mod_proveedor").val();
        const datos = new FormData($("#form_modal_add_mod_proveedor")[0]);
        datos.append('services', JSON.stringify(listProveedoresApiUrl));

        if (accionFormulario == "ADD") {
            $.ajax({
                url: '/orquestadorapi/peticion/storeProveedor',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveProveedor.id}`).html("<i class='fa fa-save'></i> Guardar");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito el proveedor api",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarProveedoresApi();
                        $("#modal_add_mod_proveedor").modal("hide");
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
                url: '/orquestadorapi/peticion/updateProveedor',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveProveedor.id}`).html("<i class='fa fa-save'></i> Guardar");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito el proveedor api",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarProveedoresApi();
                        $("#modal_add_mod_proveedor").modal("hide");
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

function show_mod_proveedor_api(p_id, p_nombre_empresa, p_ruc, p_modulo) {
    accionFormulario = "MOD";
    idProveedorApi.value = p_id;
    txtRuc.value = p_ruc;
    txtEmpresa.value = p_nombre_empresa;
    txtModulo.value = p_modulo;
    getListarProveedoresServices();
    $("#modal_add_mod_proveedor").modal("show");
}

function show_delete_proveedor_api(p_id) {
    idProveedorApiToDelete = p_id;
    $(modalConfirmDeleteRegister).modal("show");
}

btnCancelBorrarRegistro.addEventListener('click', () => {
    idProveedorApiToDelete = 0;
    $(modalConfirmDeleteRegister).modal("hide");
});

btnBorrarRegistro.addEventListener('click', () => {
    let id = idProveedorApiToDelete;
    let token = $("#csrf-token").val();
    $(modalConfirmDeleteRegister).modal('hide');
    $.ajax({
        url: `/orquestadorapi/peticion/deleteProveedor/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Proveedor API Eliminado!",
                    type: "success",
                    zindex: 99999
                });
                idProveedorApiToDelete = 0;
                getListarProveedoresApi();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar el proveedor api",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirmacion_delete_peticion").modal('hide');
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


btnAddProveedorService.addEventListener('click', () => {
    actionProveedorServicio.value = "ADD";
    idProveedorApiService.value = 0;
    txtCont.value = 0;
    selectTipoAPI.value = 1;
    txtUrl.value = "";
    txtNameService.value = "";
    txtHeaders.value = "";
    $("#modal_add_mod_proveedor_servicio").modal('show');
});

function renderAddTableProveedorApiService(formato, name, url) {
    let table_proveedor_service = document.getElementById(id_table_proveedor_api_service);
    let tbody = table_proveedor_service.querySelector("tbody");
    const tdEmpty = tbody.querySelector(".dataTables_empty");
    let classTr = "odd";

    if (tdEmpty) {
        tdEmpty.parentElement.remove();
        table_proveedor_service = document.getElementById(id_table_proveedor_api_service);
        tbody = table_proveedor_service.querySelector("tbody");
    }

    const trs = tbody.querySelectorAll("tr");

    if (trs.length > 0 && trs[trs.length - 1].classList.contains("odd")) {
        classTr = "even";
    }

    contProveedoresApi++;

    let trRow = `
    <tr role="row" class="${classTr}">
        <td align="center" class="color-td sorting_1"></td>
        
        <td align="center" class="color-td">${formato == 1 ? 'SOAP' : 'API'}</td>
        
        <td align="center" class="color-td">${name.toUpperCase()}</td>
        <td align="center" class="color-td">${url}</td>
        
        <td align="center" class="color-td">
            <button type="button" class="btn btn-warning btn-modal-editar tooltip" onclick="show_mod_proveedor_api_service(${contProveedoresApi})"><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
            <button type="button" class="btn btn-danger btn-modal-eliminar tooltip" onclick="show_delete_proveedor_api_service(${contProveedoresApi})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>
        </td>
    </tr>
    `;

    tbody.innerHTML += trRow;
}

function add_mod_eli_list_proveedor_api(action, id_proveedor_service, select_tipo_api, name, url, headers, index = -1) {
    if (index == -1) {
        listProveedoresApiUrl.push({
            id: contProveedoresApi,
            ps_id: id_proveedor_service,
            action: action,
            select_tipo_api: select_tipo_api,
            url: url,
            name: name,
            headers: headers
        });
    } else {
        listProveedoresApiUrl[index] = {
            ...listProveedoresApiUrl[index],
            action: action,
            select_tipo_api: select_tipo_api,
            url: url,
            name: name,
            headers: headers
        }
    }
}

function show_mod_proveedor_api_service(id_contenedor) {
    actionProveedorServicio.value = "MOD";
    const itemUrl = listProveedoresApiUrl.find(i => i.id == id_contenedor);
    txtCont.value = id_contenedor;
    idProveedorApiService.value = itemUrl.ps_id;
    selectTipoAPI.value = itemUrl.select_tipo_api;
    txtUrl.value = itemUrl.url;
    txtNameService.value = itemUrl.name;
    txtHeaders.value = itemUrl.headers;
    $("#modal_add_mod_proveedor_servicio").modal('show');
}

function show_delete_proveedor_api_service(id_contenedor) {
    const itemUrl = listProveedoresApiUrl.find(i => i.id == id_contenedor);
    const itemIndex = listProveedoresApiUrl.findIndex(i => i.id == id_contenedor);

    if (itemUrl.ps_id != 0) {
        add_mod_eli_list_proveedor_api("ELI", itemUrl.ps_id, itemUrl.select_tipo_api, itemUrl.name, itemUrl.url, itemUrl.headers, itemIndex);
    } else {
        listProveedoresApiUrl.splice(itemIndex, 1);
    }
    renderEliTableProveedorApiService(id_contenedor);
}

btnSaveProveedorService.addEventListener('click', () => {

    let errores = '';

    errores += txtUrl.validateInput();
    errores += txtNameService.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar el servicio, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    }
    else {
        if (actionProveedorServicio.value == "ADD") {
            renderAddTableProveedorApiService(selectTipoAPI.value, txtNameService.value, txtUrl.value);
            add_mod_eli_list_proveedor_api("ADD", idProveedorApiService.value, selectTipoAPI.value, txtNameService.value, txtUrl.value, txtHeaders.value);
        } else {
            if (idProveedorApiService.value == 0) {
                actionProveedorServicio.value = "ADD";
            }
            let index = listProveedoresApiUrl.findIndex(i => i.id == txtCont.value);
            renderModTableProveedorApiService(selectTipoAPI.value, txtNameService.value, txtUrl.value, txtCont.value);
            add_mod_eli_list_proveedor_api(actionProveedorServicio.value, idProveedorApiService.value, selectTipoAPI.value, txtNameService.value, txtUrl.value, txtHeaders.value, index);
        }

    }
    $("#modal_add_mod_proveedor_servicio").modal('hide');
})

function renderModTableProveedorApiService(formato, name, url, idCont) {
    const table_proveedor_service = document.getElementById(id_table_proveedor_api_service);
    const tbody = table_proveedor_service.querySelector("tbody");
    const btnMod = tbody.querySelector(`button[onclick="show_mod_proveedor_api_service(${idCont})"]`);
    const trItem = btnMod.parentElement.parentElement;
    const tds = trItem.querySelectorAll("td");

    tds[1].innerText = formato == 1 ? 'SOAP' : 'API';
    tds[2].innerText = name.toUpperCase();
    tds[3].innerText = url;
}

function renderEliTableProveedorApiService(idCont) {
    const table_proveedor_service = document.getElementById(id_table_proveedor_api_service);
    const tbody = table_proveedor_service.querySelector("tbody");
    const btnMod = tbody.querySelector(`button[onclick="show_mod_proveedor_api_service(${idCont})"]`);
    const trItem = btnMod.parentElement.parentElement;
    trItem.remove();
}

function show_proveedor_api_peticiones(id_contenedor) {
    idProveedorApiPetitions = id_contenedor;
    $("#modal_view_peticiones").modal("show");
    getAllUrlService();
    getListarPeticiones();
}

function getAllUrlService() {
    $.ajax({
        url: `/orquestadorapi/peticion/get_peticiones_service/${idProveedorApiPetitions}`,
        type: "GET",
        dataType: "json",
        data: "",
        success: function (response) {
            select_url_peticiones.innerHTML = "";

            response.forEach(e => {
                select_url_peticiones.innerHTML += `<option value="${e.ps_id}">${e.ps_url}</option>`
            });

            if (response.length > 0)
                select_url_peticiones.selectedIndex = 0;
        }
    });
}

btnAnadirRegistroPeticion.addEventListener('click', () => {
    $("#modal_add_mod_peticion").modal("show");
    accionFormularioPeticion = "ADD";
    txtPeticion.value = "";
    selectVerbSend.value = 1;
    txtRequest.value = "";
    txtRequestAPI.value = "";
    idInput.value = "";
    select_url_peticiones.selectedIndex = 0;
});