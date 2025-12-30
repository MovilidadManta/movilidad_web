let btnAnadirRegistro = document.getElementById('btn_add_empresa');
let btnAnadirRegistroUser = document.getElementById('btn_add_user');
let btnBorrarRegistro = document.getElementById('btn_confirm_delete_user');
let btnCancelBorrarRegistro = document.getElementById('btn_cancelar_delete_user');
let modalConfirmDeleteRegister = "#modal_confirmacion_delete_user";
let btnBorrarRegistroEmpresa = document.getElementById('btn_confirm_delete_empresa');
let btnCancelBorrarRegistroEmpresa = document.getElementById('btn_cancelar_delete_empresa');
let modalConfirmDeleteRegisterEmpresa = "#modal_confirmacion_delete_user";
let id_table_empresas = 'table_empresas';
let id_table_users = 'table_users';
let idUserToDelete = 0;
let idEmpresaToDelete = 0;

//controles formulario ingresar o modificar empresa
let txtRuc = document.getElementById('txt_ruc_modal_add_mod_empresa');
let txtEmpresa = document.getElementById('txt_empresa_modal_add_mod_empresa');
let txtIp = document.getElementById('txt_ip_modal_add_mod_empresa');
let btnSaveEmpresa = document.getElementById('btn_guardar_empresa');
let idInputEmpresa = document.getElementById('id_modal_add_mod_empresa');
let accionFormularioEmpresa = "ADD";
//----------------------------------------------------

//controles formulario ingresar o modificar usuario
let btnSaveUser = document.getElementById('btn_guardar_user');
let txtUsername = document.getElementById('txt_username_modal_add_mod_user');
let id_empresa = document.getElementById('e_id_modal_add_mod_user');
let txtPassword = document.getElementById('txt_password_modal_add_mod_user');
let idInput = document.getElementById('id_modal_add_mod_user');
let formulario = document.getElementById('form_modal_add_mod_user');
let estado_control_peticiones = document.getElementById('chk_control_peticiones_modal_add_mod_user');
let estado_ips = document.getElementById('chk_ips_modal_add_mod_user');
let accionFormulario = "ADD";
//------------------------------------

//Controles de peticiones
const selectControlPeticiones = document.getElementById('select_peticion_modal_add_mod_control_peticiones');
const btnGuardarControlPeticiones = document.getElementById('btn_guardar_peticion_modal_add_mod_control_peticiones');
const idControlPeticionesUsuario = document.getElementById('u_id_modal_add_mod_control_peticiones');
const tableControlPeticiones = document.getElementById('tbody_control_peticiones');
let idControlPeticiones = 0;
let loadPeticionesSelect = false;
//-----------------------------------

//Controles de ips
const inputIP = document.getElementById('ui_ip_modal_add_mod_control_ips');
const btnGuardarControlIps = document.getElementById('btn_guardar_ip_modal_add_mod_control_ips');
const idControlIp = document.getElementById('id_modal_add_mod_control_ips');
const tableControlIp = document.getElementById('tbody_control_ips');
let idControlIps = 0;
//-----------------------------------

$(document).ready(function () {
    getListarEmpresas();

    setInputValidations('txt_ruc_modal_add_mod_empresa', ['notEmpty'], []);
    setInputValidations('txt_empresa_modal_add_mod_empresa', ['notEmpty'], []);
    setInputValidations('txt_username_modal_add_mod_user', ['notEmpty'], []);
    setInputValidations('txt_password_modal_add_mod_user', ['notEmpty'], []);

    set_type_input('txt_ruc_modal_add_mod_empresa', 'number');
    set_type_input('txt_ip_modal_add_mod_empresa', 'ipv4');

    setInputValidations(selectControlPeticiones.id, ['notEmpty'], [
        {
            function: function (item) {
                return item.value.trim() != "" && (item.dataset.value == undefined || item.dataset.value.trim() == "");
            },
            message: "Debe buscar y seleccionar una peticion"
        }
    ]);

    set_type_input(inputIP.id, 'ipv4');
    setInputValidations(inputIP.id, ['notEmpty'], []);
});

btnSaveUser.addEventListener('click', () => {
    let errores = '';

    errores += txtUsername.validateInput();
    errores += txtPassword.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar el nuevo usuario, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $(`#${btnSaveUser.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando usuario..</span>");
        const token = $("#csrf_token_modal_add_mod_user").val();
        const datos = new FormData($("#form_modal_add_mod_user")[0]);

        if (accionFormulario == "ADD") {
            $.ajax({
                url: '/orquestadorapi/users/store',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveUser.id}`).html("<i class='fa fa-save'></i> <span id='text_save_user'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito el usuario",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarUsers();
                        $("#modal_add_mod_user").modal("hide");
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
                url: '/orquestadorapi/users/update',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveUser.id}`).html("<i class='fa fa-save'></i> <span id='text_save_user'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito el usuario",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarUsers();
                        $("#modal_add_mod_user").modal("hide");
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
    txtRuc.value = "";
    txtEmpresa.value = "";
    txtIp.value = "";
    accionFormularioEmpresa = "ADD";
    $("#modal_add_mod_empresa").modal("show");
});

function getListarUsers() {
    $.ajax({
        url: `/orquestadorapi/users/get_list/${id_empresa.value}`,
        type: "GET",
        dataType: "json",
        data: "",
        success: function (response) {
            let html = configureTableHtml(id_table_users,
                ['#', 'USERNAME', 'OPCIONES'],
                ['u_id', 'u_username',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            console.log(item);
                            return `<button type="button" class="btn btn-warning btn-modal-editar tooltip" Onclick ="show_mod_user(${item.u_id}, '${item.u_ruc}','${item.u_nombre_empresa}', '${item.u_por_ip}', '${item.u_username}', '${item.u_password}', ${item.u_estado}, ${item.u_control_peticiones}, ${item.u_control_ips})"><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
                            <button type="button" class="btn btn-info tooltip" Onclick ="show_control_peticiones(${item.u_id})"><span class="tooltiptext">Control Peticiones</span><i class="fa fa-bars tam-icono icon_elevated"></i></button>
                            <button type="button" class="btn btn-success tooltip" Onclick ="show_control_ips(${item.u_id})"><span class="tooltiptext">Control Ips</span><i class="fa fa-laptop tam-icono icon_elevated"></i></button>        
                            <button type="button" class="btn btn-danger btn-modal-eliminar tooltip" Onclick ="show_delete_user(${item.u_id})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>`;

                        }
                    },
                ], response
            );

            $("#div_table_users").html(html);

            $(`#${id_table_users}`).DataTable({
                "order": [[0, 'asc']]
            });

        }
    });
}

btnCancelBorrarRegistro.addEventListener('click', () => {
    idUserToDelete = 0;
    $(modalConfirmDeleteRegister).modal("hide");
});

function show_mod_user(ca_id, u_ruc, u_nombre_empresa, u_por_ip, u_username, u_password, u_estado, u_control_peticiones, u_control_ips) {
    accionFormulario = "MOD";
    idInput.value = ca_id;
    txtRuc.value = u_ruc;
    txtEmpresa.value = u_nombre_empresa;
    txtIp.value = u_por_ip;
    txtUsername.value = u_username;
    txtPassword.value = u_password;
    estado_control_peticiones.checked = u_control_peticiones;
    estado_ips.checked = u_control_ips;

    estado_control_peticiones.dispatchEvent(new Event('change'));
    estado_ips.dispatchEvent(new Event('change'));
    $("#modal_add_mod_user").modal("show");
}

function show_delete_user(id) {
    idUserToDelete = id;
    $("#modal_confirmacion_delete_user").modal("show");
}

btnBorrarRegistro.addEventListener('click', () => {
    let id = idUserToDelete;
    let token = $("#csrf-token").val();
    $("#modal_confirmacion_delete_user").modal('hide');
    $.ajax({
        url: `/orquestadorapi/users/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Usuario Eliminado!",
                    type: "success",
                    zindex: 99999
                });
                idUserToDelete = 0;
                getListarUsers();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar el usuario",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirmacion_delete_user").modal('hide');
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


//Control peticiones funciones

function show_control_peticiones(u_id) {
    idControlPeticionesUsuario.value = u_id
    getListPeticionesUsuario(u_id);
    selectControlPeticiones.value = "";
    selectControlPeticiones.dataset.value = "";
    $("#modal_add_mod_control_peticiones").modal("show");

    let ajaxPrevPeticiones = null;

    if (!loadPeticionesSelect) {
        custom_search_input(selectControlPeticiones.id, {
            formatResult: function (item) {
                return {
                    value: item.p_id,
                    text: `${item.p_modulo} - ${item.p_peticion}`,
                    html: `${item.p_modulo} - ${item.p_peticion}`
                }
            },
            datasets: function (item) {
                return {}
            },
            search: function (text, callback) {
                if (ajaxPrevPeticiones != null)
                    ajaxPrevPeticiones.abort();

                let ajax = $.ajax(
                    `/orquestadorapi/peticion/get_list_search/100/${text}`
                ).done(function (res) {
                    callback(res.respuesta ? res.data : []);
                });

                ajaxPrevPeticiones = ajax;
            }
        });
        loadPeticionesSelect = true;
    }

}

function getListPeticionesUsuario(u_id) {
    $.ajax({
        url: `/orquestadorapi/users/get_list_control_peticiones/${u_id}`,
        type: 'GET',
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            tableControlPeticiones.innerHTML = "";

            response.forEach(d => {
                idControlPeticiones++;
                tableControlPeticiones.innerHTML += `<tr">
                                        <td align="center" class="color-td">${d.p_modulo}</td>
                                        <td align="center" class="color-td">${d.p_peticion}</td>
                                        <td class="color-td" align="center">
                                            <button type="button" data-p_id="${d.p_id}" id="btn_eliminar_peticion_${idControlPeticiones}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>
                                        </td>
                                    </tr>`;
            });

            const btnsBorrar = tableControlPeticiones.querySelectorAll("button[id^='btn_eliminar_peticion_']");

            btnsBorrar.forEach(b => {
                b.addEventListener('click', () => {
                    eliminarControlPeticiones(u_id, b.dataset.p_id);
                });
            });

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

function eliminarControlPeticiones(u_id, p_id) {
    let token = $("#csrf_token_modal_add_mod_control_peticiones").val();
    let datos = new FormData();
    datos.append('u_id', u_id);
    datos.append('p_id', p_id);

    $.ajax({
        url: '/orquestadorapi/users/deleteControlPeticion',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b>Peticion eliminada!",
                    type: "success",
                    zindex: 99999
                });
                getListPeticionesUsuario(u_id);
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido agregar la peticion!",
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
}

btnGuardarControlPeticiones.addEventListener('click', () => {
    let errores = '';

    errores += selectControlPeticiones.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar la peticion, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        let token = $("#csrf_token_modal_add_mod_control_peticiones").val();
        let datos = new FormData();
        datos.append('u_id', idControlPeticionesUsuario.value);
        datos.append('p_id', selectControlPeticiones.dataset.value);

        $.ajax({
            url: '/orquestadorapi/users/storeControlPeticion',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b>Peticion agregada exitosamente!",
                        type: "success",
                        zindex: 99999
                    });
                    getListPeticionesUsuario(idControlPeticionesUsuario.value);
                    selectControlPeticiones.value = "";
                    selectControlPeticiones.dataset.value = "";
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido agregar la peticion!",
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

    }
});

//------------------------------------

/*
//Controles de ips
const inputIP = document.getElementById('ui_ip_modal_add_mod_control_ips');
const btnGuardarControlIps = document.getElementById('btn_guardar_ip_modal_add_mod_control_ips');
const idControlIp = document.getElementById('id_modal_add_mod_control_ips');
const tableControlIp = document.getElementById('tbody_control_ips');
let idControlIps = 0;
//-----------------------------------
*/

function show_control_ips(u_id) {
    idControlIp.value = u_id;
    getListIpsUsuario(u_id);
    inputIP.value = "";
    $("#modal_add_mod_control_ips").modal("show");
}

function getListIpsUsuario(u_id) {
    $.ajax({
        url: `/orquestadorapi/users/get_list_control_ips/${u_id}`,
        type: 'GET',
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            tableControlIp.innerHTML = "";

            response.forEach(d => {
                idControlIps++;
                tableControlIp.innerHTML += `<tr">
                                        <td align="center" class="color-td">${d.ui_ip}</td>
                                        <td class="color-td" align="center">
                                            <button type="button" data-ui_ip="${d.ui_ip}" id="btn_eliminar_ips_${idControlIps}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>
                                        </td>
                                    </tr>`;
            });

            const btnsBorrar = tableControlIp.querySelectorAll("button[id^='btn_eliminar_ips_']");

            btnsBorrar.forEach(b => {
                b.addEventListener('click', () => {
                    eliminarControlIp(u_id, b.dataset.ui_ip);
                });
            });

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

function eliminarControlIp(u_id, ui_ip) {
    let token = $("#csrf_token_modal_add_mod_control_ips").val();
    let datos = new FormData();
    datos.append('u_id', u_id);
    datos.append('ui_ip', ui_ip);

    $.ajax({
        url: '/orquestadorapi/users/deleteControlIp',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b>IP eliminada!",
                    type: "success",
                    zindex: 99999
                });
                getListIpsUsuario(u_id);
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido agregar la ip!",
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
}

btnGuardarControlIps.addEventListener('click', () => {
    let errores = '';

    errores += inputIP.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar la ip, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        let token = $("#csrf_token_modal_add_mod_control_ips").val();
        let datos = new FormData();
        datos.append('u_id', idControlIp.value);
        datos.append('ui_ip', inputIP.value);

        $.ajax({
            url: '/orquestadorapi/users/storeControlIp',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b>IP agregada exitosamente!",
                        type: "success",
                        zindex: 99999
                    });
                    getListIpsUsuario(idControlIp.value);
                    inputIP.value = "";
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido agregar la ip!",
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

    }
});

btnSaveEmpresa.addEventListener('click', () => {

    let errores = '';

    errores += txtRuc.validateInput();
    errores += txtEmpresa.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar el nuevo usuario, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $(`#${btnSaveEmpresa.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando empresa..</span>");
        const token = $("#csrf_token_modal_add_mod_empresa").val();
        const datos = new FormData($("#form_modal_add_mod_empresa")[0]);

        if (accionFormularioEmpresa == "ADD") {
            $.ajax({
                url: '/orquestadorapi/users/store_empresa',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveEmpresa.id}`).html("<i class='fa fa-save'></i> <span id='text_save_user'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito la empresa",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarEmpresas();
                        $("#modal_add_mod_empresa").modal("hide");
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

        if (accionFormularioEmpresa == "MOD") {
            $.ajax({
                url: '/orquestadorapi/users/update_empresa',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveEmpresa.id}`).html("<i class='fa fa-save'></i> <span id='text_save_user'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito la empresa",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarEmpresas();
                        $("#modal_add_mod_empresa").modal("hide");
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

function getListarEmpresas() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/orquestadorapi/users/get_list_empresa',
        type: "GET",
        dataType: "json",
        data: "",
        success: function (response) {
            let html = configureTableHtml(id_table_empresas,
                ['#', 'RUC', 'EMPRESA', 'IP', 'OPCIONES'],
                ['e_id', 'e_ruc', 'e_nombre_empresa', 'e_ip',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            console.log(item);
                            return `<button type="button" class="btn btn-warning btn-modal-editar tooltip" Onclick ="show_mod_empresa(${item.e_id}, '${item.e_ruc}','${item.e_nombre_empresa}', '${item.e_ip}')"><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
                            <button type="button" class="btn btn-info tooltip" Onclick ="show_control_users(${item.e_id})"><span class="tooltiptext">Control Usuarios</span><i class="fa fa-users tam-icono icon_elevated"></i></button>     
                            <button type="button" class="btn btn-danger btn-modal-eliminar tooltip" Onclick ="show_delete_empresa(${item.e_id})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>`;

                        }
                    },
                ], response
            );

            $("#div_table_empresas").html(html);

            $(`#${id_table_empresas}`).DataTable({
                "order": [[0, 'asc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function show_mod_empresa(e_id, e_ruc, e_nombre_empresa, e_ip) {
    accionFormularioEmpresa = "MOD";
    txtRuc.value = e_ruc;
    txtEmpresa.value = e_nombre_empresa;
    txtIp.value = e_ip;
    idInputEmpresa.value = e_id;

    $("#modal_add_mod_empresa").modal("show");
}

function show_delete_empresa(id) {
    idEmpresaToDelete = id;
    $("#modal_confirmacion_delete_empresa").modal("show");
}

btnBorrarRegistroEmpresa.addEventListener('click', () => {
    let id = idEmpresaToDelete;
    let token = $("#csrf-token").val();
    $("#modal_confirmacion_delete_empresa").modal('hide');
    $.ajax({
        url: `/orquestadorapi/users/delete_empresa/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Empresa Eliminada!",
                    type: "success",
                    zindex: 99999
                });
                idUserToDelete = 0;
                getListarEmpresas();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la empresa",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirmacion_delete_user").modal('hide');
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

btnCancelBorrarRegistroEmpresa.addEventListener('click', () => {
    idEmpresaToDelete = 0;
    $(modalConfirmDeleteRegisterEmpresa).modal("hide");
});

function show_control_users(e_id) {
    id_empresa.value = e_id;
    getListarUsers();
    $("#modal_view_usuarios").modal("show");
}

btnAnadirRegistroUser.addEventListener('click', () => {
    accionFormulario = "ADD";
    txtUsername.value = "";
    txtPassword.value = "";
    estado_control_peticiones.checked = true;
    estado_ips.checked = true;
    estado_control_peticiones.dispatchEvent(new Event('change'));
    estado_ips.dispatchEvent(new Event('change'));
    $("#modal_add_mod_user").modal("show");
});