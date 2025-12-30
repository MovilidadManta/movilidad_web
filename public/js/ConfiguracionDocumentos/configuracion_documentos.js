let btnAgregarConfiguracionDocumento = document.getElementById('btn-añadir-configuracion-documentos');
let btnGuardarConfiguracionDocumento = document.getElementById('btn-guardar-configuracion-documento-modal_agregar_configuracion_documento');
let btnModificarConfiguracionDocumento = document.getElementById('btn-guardar-configuracion-documento-modal_modificar_configuracion_documento');
let btnDeleteConfiguracionDocumento = document.getElementById('btn-delete-configuracion-documento');
let btnAgregarCamposDocumento = document.getElementById('btn-guardar-documento-campo-modal_agregar_configuracion_documento');
let btnAgregarCamposDocumentoMod = document.getElementById('btn-guardar-documento-campo-modal_modificar_configuracion_documento');

$(document).ready(function () {
    getConfiguracionDocumentos();

    btnAgregarConfiguracionDocumento.addEventListener('click', () => {
        $("#modal_agregar_configuracion_documento").modal("show");
    });

    btnGuardarConfiguracionDocumento.addEventListener('click', agregarConfiguracionDocumento);
    btnModificarConfiguracionDocumento.addEventListener('click', modificarConfiguracionDocumento);

    btnAgregarCamposDocumento.addEventListener('click', ((e) => {
        e.preventDefault();
        agregarModificarCampoDocumento('modal_agregar_configuracion_documento');
    }));
    btnAgregarCamposDocumentoMod.addEventListener('click', ((e) => {
        e.preventDefault();
        agregarModificarCampoDocumento('modal_modificar_configuracion_documento');
    }));

    //Agregar
    setInputValidations('txt_nombre-modal_agregar_configuracion_documento', ['notEmpty'], []);
    setInputValidations('txt_codigo-modal_agregar_configuracion_documento', ['notEmpty'], []);
    setInputValidations('txt_descripcion-modal_agregar_configuracion_documento', ['notEmpty'], []);
    setInputValidations('txt_nombre_campo-modal_agregar_configuracion_documento', ['notEmpty'], []);
    //Modificar
    setInputValidations('txt_nombre-modal_modificar_configuracion_documento', ['notEmpty'], []);
    setInputValidations('txt_codigo-modal_modificar_configuracion_documento', ['notEmpty'], []);
    setInputValidations('txt_descripcion-modal_modificar_configuracion_documento', ['notEmpty'], []);
    setInputValidations('txt_nombre_campo-modal_modificar_configuracion_documento', ['notEmpty'], []);

    $('#txt_nombre-modal_agregar_configuracion_documento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_codigo-modal_agregar_configuracion_documento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_nombre_campo-modal_agregar_configuracion_documento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_nombre-modal_modificar_configuracion_documento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_codigo-modal_modificar_configuracion_documento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_nombre_campo-modal_modificar_configuracion_documento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });

    clearTrCamposDocumento('modal_agregar_configuracion_documento');
    clearTrCamposDocumento('modal_modificar_configuracion_documento');
});

function getConfiguracionDocumentos() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/ConfiguracionDocumentosArchivo/get_configuracion_documentos',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table-configuracion-documentos",
                ['#', 'NOMBRE', 'CÓDIGO', 'DESCRIPCION', 'CAMPOS', 'ESTADO', 'OPCIONES'
                ],
                ['cd_id', 'cd_nombre', 'cd_codigo', 'cd_descripcion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '<p style="white-space: pre-line;">';
                            JSON.parse(item.campos_unidades).forEach(c => {
                                value += `[${c.cdc_nombre},${c.cdc_tipo}] \n`;
                            });
                            value += '</p>'
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.cd_estado) {
                                value = '<span class="badge bg-success me-1">Activo</span>';
                            } else {
                                value = '<span class="badge bg-warning me-1">Inactivo</span>';
                            }
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `
                            <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ='show_mod_configuracion_documento(${item.cd_id},"${item.cd_nombre}","${item.cd_codigo}","${item.cd_descripcion}",${JSON.stringify(JSON.parse(item.campos_unidades))},${item.cd_estado})'><i class="fa fa-edit tam-icono"></i></button>
                            <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_configuracion_documento(${item.cd_id})"><i class="fa fa-trash tam-icono"></i></button>
                            `;
                        }
                    },
                ], response
            );

            $("#div-table-configuracion-documentos").html(html);

            $("#table-configuracion-documentos").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function agregarConfiguracionDocumento() {

    let nombreE = document.getElementById('txt_nombre-modal_agregar_configuracion_documento');
    let codigoE = document.getElementById('txt_codigo-modal_agregar_configuracion_documento');
    let descripcionE = document.getElementById('txt_descripcion-modal_agregar_configuracion_documento');
    let estadoE = document.getElementById('chk_estado-modal_agregar_configuracion_documento');
    let filasCamposDocumentos = document.querySelectorAll('#tbody-documentos-campos-modal_agregar_configuracion_documento tr[id]');
    let camposDocumentos = [];

    filasCamposDocumentos.forEach(d => {
        camposDocumentos.push({
            nombre: d.dataset.nombre,
            tipo: d.dataset.tipo
        });
    });

    let errores = "";

    errores += nombreE.validateInput();
    //errores += codigoE.validateInput();
    //errores += descripcionE.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede registrar la configuración del documento, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-configuracion-documento-modal_agregar_configuracion_documento").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");

        let token = $("#csrf-token-modal_agregar_configuracion_documento").val();
        let datos = new FormData($("#form_agregar_configuracion_documento")[0]);
        datos.append('estado', estadoE.checked);
        datos.append('campos', JSON.stringify(camposDocumentos));

        $.ajax({
            url: '/ConfiguracionDocumentosArchivo/store',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Configuración de Documento Registrada!",
                        type: "success",
                        zindex: 99999
                    });
                    nombreE.value = "";
                    codigoE.value = "";
                    descripcionE.value = "";
                    estadoE.checked = true;
                    estadoE.dispatchEvent(new Event('change'));
                    clearTrCamposDocumento('modal_agregar_configuracion_documento');
                    $("#modal_agregar_configuracion_documento").modal('hide');
                    $("#btn-guardar-configuracion-documento-modal_agregar_configuracion_documento").html("<i class='fa fa-save'></i> Guardar");
                    getConfiguracionDocumentos();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido registrar la configuración de documento",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-configuracion-documento-modal_agregar_configuracion_documento").html("<i class='fa fa-save'></i> Guardar");
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

function show_mod_configuracion_documento(id, nombre, codigo, descripcion, campos, estado) {
    let idModificar = document.getElementById('id-configuracion-documento-modal_modificar_configuracion_documento');
    let nombreE = document.getElementById('txt_nombre-modal_modificar_configuracion_documento');
    let codigoE = document.getElementById('txt_codigo-modal_modificar_configuracion_documento');
    let descripcionE = document.getElementById('txt_descripcion-modal_modificar_configuracion_documento');
    let estadoE = document.getElementById('chk_estado-modal_modificar_configuracion_documento');
    let bodyDocumento = document.getElementById('tbody-documentos-campos-modal_modificar_configuracion_documento');
    let nombreDocumentoE = document.getElementById(`txt_nombre_campo-modal_modificar_configuracion_documento`);
    let tipoDocumentoE = document.getElementById(`select_tipo_campo-modal_modificar_configuracion_documento`);
    let btnAgregar = document.getElementById(`text-btn-añadir-documento-campo-modal_modificar_configuracion_documento`);
    let idM = 1;
    clearTrCamposDocumento('modal_modificar_configuracion_documento');

    campos.forEach(f => {
        agregarRegistroCampoDocumento(idM++, bodyDocumento, f.cdc_nombre, nombreDocumentoE, f.cdc_tipo, tipoDocumentoE, btnAgregar, 'modal_modificar_configuracion_documento');
    });

    idModificar.value = id;
    nombreE.value = nombre;
    codigoE.value = codigo;
    descripcionE.value = descripcion;
    estadoE.checked = estado;

    estadoE.dispatchEvent(new Event('change'));

    $("#modal_modificar_configuracion_documento").modal("show");
}

function modificarConfiguracionDocumento() {
    let nombreE = document.getElementById('txt_nombre-modal_modificar_configuracion_documento');
    let codigoE = document.getElementById('txt_codigo-modal_modificar_configuracion_documento');
    let descripcionE = document.getElementById('txt_descripcion-modal_modificar_configuracion_documento');
    let estadoE = document.getElementById('chk_estado-modal_modificar_configuracion_documento');
    let filasCamposDocumentos = document.querySelectorAll('#tbody-documentos-campos-modal_modificar_configuracion_documento tr[id]');
    let camposDocumentos = [];

    filasCamposDocumentos.forEach(d => {
        camposDocumentos.push({
            nombre: d.dataset.nombre,
            tipo: d.dataset.tipo
        });
    });

    let errores = "";

    errores += nombreE.validateInput();
    //errores += codigoE.validateInput();
    //errores += descripcionE.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede registrar la configuración del documento, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-configuracion-documento-modal_modificar_configuracion_documento").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");

        let token = $("#csrf-token-modal_modificar_configuracion_documento").val();
        let datos = new FormData($("#form_modificar_configuracion_documento")[0]);
        datos.append('estado', estadoE.checked);
        datos.append('campos', JSON.stringify(camposDocumentos));

        $.ajax({
            url: '/ConfiguracionDocumentosArchivo/update',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Configuración de Documento Actualizada!",
                        type: "success",
                        zindex: 99999
                    });
                    nombreE.value = "";
                    codigoE.value = "";
                    descripcionE.value = "";
                    estadoE.checked = true;
                    estadoE.dispatchEvent(new Event('change'));
                    clearTrCamposDocumento('modal_modificar_configuracion_documento');
                    $("#modal_modificar_configuracion_documento").modal('hide');
                    $("#btn-guardar-configuracion-documento-modal_modificar_configuracion_documento").html("<i class='fa fa-save'></i> Guardar");
                    getConfiguracionDocumentos();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido actualizar la configuración de documento",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-configuracion-documento-modal_modificar_configuracion_documento").html("<i class='fa fa-save'></i> Guardar");
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

function show_delete_configuracion_documento(id) {
    $('#txt-id-delete-configuracion-documento').val(id);
    $("#modal_confirm_delete_configuracion_documento").modal("show");
}

btnDeleteConfiguracionDocumento.addEventListener('click', function () {
    let id = $('#txt-id-delete-configuracion-documento').val();
    let token = $("#csrf-token-modal_confirm_delete_configuracion_documento").val();
    $.ajax({
        url: `/ConfiguracionDocumentosArchivo/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Configuración de documento Eliminada!",
                    type: "success",
                    zindex: 99999
                });
                $('#txt-id-delete-configuracion-documento').val('');
                $("#modal_confirm_delete_configuracion_documento").modal('hide');
                getConfiguracionDocumentos();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la Configuración de documento",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_configuracion_documento").modal('hide');
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

function checkClearCamposDocumento(id, modal) {
    let trs = document.querySelectorAll(`#${id} tr`).length;
    if (trs == 0) {
        clearTrCamposDocumento(modal);
    }
}

function clearTrCamposDocumento(modal) {
    $(`#tbody-documentos-campos-${modal}`).html("<tr data-info='sinInfo'><td class='color-td' align='center' colspan='3'>No hay información disponible</td></tr>");
    $(`#tbody-documentos-campos-${modal}`).attr("data-id", "0");
    $(`#txt_nombre_campo-${modal}`).val('');
}

function agregarModificarCampoDocumento(modal) {
    let bodyTableDocumentos = document.getElementById(`tbody-documentos-campos-${modal}`);
    let Trs = bodyTableDocumentos.querySelectorAll('tr[id]');
    let nombreDocumentoE = document.getElementById(`txt_nombre_campo-${modal}`);
    let tipoDocumentoE = document.getElementById(`select_tipo_campo-${modal}`);
    let btnAgregar = document.getElementById(`text-btn-añadir-documento-campo-${modal}`);
    let id = Trs.length == 0 ? 1 : parseInt(Trs[Trs.length - 1].id) + 1;
    let errores = "";

    errores += nombreDocumentoE.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar el campo de documento, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {

        nombreDocumentoE.value = nombreDocumentoE.value.toUpperCase();

        agregarRegistroCampoDocumento(id, bodyTableDocumentos, nombreDocumentoE.value, nombreDocumentoE, tipoDocumentoE.value, tipoDocumentoE, btnAgregar, modal);

        bodyTableDocumentos.dataset.id = 0;
        nombreDocumentoE.value = "";
        tipoDocumentoE.value = "TEXTO";
        btnAgregar.innerHTML = "Añadir";
    }
}

function agregarRegistroCampoDocumento(idA, body, nombreDocumento, nombreDocumentoElement, tipoDocumento, tipoDocumentoElement, btnAgregar, modal) {
    let sinInfo = body.querySelector(`tr[data-info='sinInfo']`);

    if (sinInfo) {
        sinInfo.remove();
    }

    if (body.dataset.id == 0) {
        body.innerHTML += `<tr id="${idA}" data-nombre="${nombreDocumento}" data-tipo="${tipoDocumento}">
                                            <td align="center" class="color-td">${nombreDocumento}</td>
                                            <td align="center" class="color-td">${tipoDocumento}</td>
                                            <td class="color-td" align="center">
                                                <button type="button" data-id="${idA}" data-nombre="${nombreDocumento}" data-tipo="${tipoDocumento}" id="btn_editar_campo_documento-${idA}" class="tam-btn btn btn-warning"><i class="fa fa-edit tam-icono"></i></button>'
                                                <button type="button" data-id="${idA}" id="btn_eliminar_campo_documento-${idA}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>'
                                            </td>
                                        </tr>`;
    } else {
        id = body.dataset.id;
        let itemModficado = body.querySelector(`tr[id="${id}"]`);
        itemModficado.dataset.nombre = nombreDocumento;
        itemModficado.dataset.tipo = tipoDocumento;
        itemModficado.innerHTML = `<td align="center" class="color-td">${nombreDocumento}</td>
                                    <td align="center" class="color-td">${tipoDocumento}</td>
                                    <td class="color-td" align="center">
                                        <button type="button" data-id="${id}" data-nombre="${nombreDocumento}" data-tipo="${tipoDocumento}" id="btn_editar_campo_documento-${id}" class="tam-btn btn btn-warning"><i class="fa fa-edit tam-icono"></i></button>'
                                        <button type="button" data-id="${id}" id="btn_eliminar_campo_documento-${id}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>'
                                    </td>`;
    }

    modificarCampoDocumento(body, nombreDocumentoElement, tipoDocumentoElement, btnAgregar);
    eliminarCampoDocumento(body, modal);
}

function modificarCampoDocumento(body, nombreDocumento, tipoDocumento, btnAgregar) {
    let btns = body.querySelectorAll('tr[id] button[id^="btn_editar_campo_documento-"]');

    btns.forEach((b) => {
        b.addEventListener('click', () => {
            btnAgregar.innerHTML = "Modificar";
            body.dataset.id = b.dataset.id;
            nombreDocumento.value = b.dataset.nombre;
            tipoDocumento.value = b.dataset.tipo;
        });
    });
}

function eliminarCampoDocumento(body, modal) {
    let btns = body.querySelectorAll('tr[id] button[id^="btn_eliminar_campo_documento-"]');
    btns.forEach((b) => {
        b.addEventListener('click', () => {
            let itemModficado = body.querySelector(`tr[id="${b.dataset.id}"]`);
            itemModficado.remove();
            checkClearCamposDocumento(body.id, modal);
        });
    });
}