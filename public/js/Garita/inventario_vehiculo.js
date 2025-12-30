const btnAgregarConfiguracionInventarioVehiculo = document.getElementById('btn_add_inventario_vehiculos');
const btnDeleteConfiguracionInventarioVehiculo = document.getElementById('btn_delete_iventario_vehiculo');

//controles formulario ingresar o modificar inventario de vehiculo
const id_inventario_vehiculo = document.getElementById("id_inventario_vehiculo-modal_agregar_inventario_vehiculo");
const txtTitulo = document.getElementById("txt_titulo-modal_agregar_inventario_vehiculo");
const txtDescripcion = document.getElementById("txt_descripcion-modal_agregar_inventario_vehiculo");
const btnGuardarConfiguracionInventarioVehiculo = document.getElementById('btn_guardar_inventario_vehiculo-modal_agregar_inventario_vehiculo');
let accionFormulario = "ADD";
let idInventarioVehiculoToDelete = 0;
//---------------------------------------------------------------------

//controles formulario ingresar o modificar inventario detalle de vehiculo
const btnAgregarDetalleInventarioDocumento = document.getElementById('btn_guardar_detalle_inventario_vehiculo-modal_agregar_inventario_vehiculo');
const txtDetalleTitulo = document.getElementById('txt_detalle_titulo-modal_agregar_inventario_vehiculo');
const SelectDetalleTipo = document.getElementById('select_detalle_tipo-modal_agregar_inventario_vehiculo');
const bodyDetalleInventario = document.getElementById("tbody_detalle_inventario-modal_agregar_inventario_vehiculo");
const textDetalleInventario = document.getElementById("text_btn_guardar_detalle_inventario_vehiculo-modal_agregar_inventario_vehiculo");
let idM = 1;
//--------------------------------------------------------------------------
$(document).ready(function () {

    getIventarioVehiculos();

    //Agregar
    setInputValidations('txt_titulo-modal_agregar_inventario_vehiculo', ['notEmpty'], []);
    setInputValidations('txt_descripcion-modal_agregar_inventario_vehiculo', ['notEmpty'], []);
    setInputValidations('txt_detalle_titulo-modal_agregar_inventario_vehiculo', ['notEmpty'], []);

    clearTrCamposDetalleInventario();

    $('#txt_titulo-modal_agregar_inventario_vehiculo').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_descripcion-modal_agregar_inventario_vehiculo').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_detalle_titulo-modal_agregar_inventario_vehiculo').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
});

btnAgregarConfiguracionInventarioVehiculo.addEventListener('click', () => {
    txtTitulo.value = "";
    txtDescripcion.value = "";
    txtDetalleTitulo.value = "";
    SelectDetalleTipo.value = 1;
    accionFormulario = "ADD";
    clearTrCamposDetalleInventario();
    $("#modal_agregar_inventario_vehiculo").modal("show");
});

function getIventarioVehiculos() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/garita/inventario_vehiculo/list',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table_inventario_vehiculos",
                ['#', 'TITULO', 'DESCRIPCION', 'OPCIONES'
                ],
                ['iv_id', 'iv_title', 'iv_descripcion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `
                            <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ='show_mod_inventario_vehiculo(${item.iv_id},"${item.iv_title}","${item.iv_descripcion}",${JSON.stringify(JSON.parse(item.list_detalle))})'><i class="fa fa-edit tam-icono"></i></button>
                            <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_inventario_vehiculo(${item.iv_id})"><i class="fa fa-trash tam-icono"></i></button>
                            `;
                        }
                    },
                ], response
            );

            $("#div_table_inventario_vehiculos").html(html);

            $("#table_inventario_vehiculos").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

btnGuardarConfiguracionInventarioVehiculo.addEventListener('click', () => {
    let errores = '';
    let detalle_inventario = [];

    errores += txtTitulo.validateInput();
    errores += txtDescripcion.validateInput();

    const items = bodyDetalleInventario.querySelectorAll('tr[id]');

    items.forEach(i => {
        detalle_inventario.push({
            ivd_title: i.dataset.detalle_titulo,
            ivd_tipo: i.dataset.detalle_tipo
        });
    });

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar la configuracion del inventario de vehiculo",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $(`#${btnGuardarConfiguracionInventarioVehiculo.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando...</span>");
        const token = $("#csrf_token_modal_agregar_inventario_vehiculo").val();
        const datos = new FormData($("#form_configuracion_inventario_vehiculo")[0]);
        datos.append('detalle_inventario', JSON.stringify(detalle_inventario));

        if (accionFormulario == "ADD") {
            $.ajax({
                url: '/garita/inventario_vehiculo/store',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnGuardarConfiguracionInventarioVehiculo.id}`).html("<i class='fa fa-save'></i> Guardar");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito la configuracion de inventario de vehiculo",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getIventarioVehiculos();
                        clearTrCamposDetalleInventario();
                        $("#modal_agregar_inventario_vehiculo").modal("hide");
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
                url: '/garita/inventario_vehiculo/update',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnGuardarConfiguracionInventarioVehiculo.id}`).html("<i class='fa fa-save'></i> Guardar");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito el inventario de vehiculo",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getIventarioVehiculos();
                        clearTrCamposDetalleInventario();
                        $("#modal_agregar_inventario_vehiculo").modal("hide");
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

function show_mod_inventario_vehiculo(iv_id, iv_title, iv_descripcion, list_detalle) {
    id_inventario_vehiculo.value = iv_id;
    txtTitulo.value = iv_title;
    txtDescripcion.value = iv_descripcion;
    accionFormulario = "MOD";

    clearTrCamposDetalleInventario();

    list_detalle.forEach(f => {
        agregarRegistroDetalleInventario(idM++, bodyDetalleInventario, f.ivd_title, f.ivd_tipo);
    });

    $("#modal_agregar_inventario_vehiculo").modal("show");
}

function show_delete_inventario_vehiculo(id) {
    $('#txt_id_delete_inventario_vehiculo').val(id);
    $("#modal_confirm_delete_inventario_vehiculo").modal("show");
}

btnDeleteConfiguracionInventarioVehiculo.addEventListener('click', function () {
    let id = $('#txt_id_delete_inventario_vehiculo').val();
    let token = $("#csrf-token-modal_confirm_delete_inventario_vehiculo").val();
    $.ajax({
        url: `/garita/inventario_vehiculo/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Configuración de inventario vehiculo eliminado!",
                    type: "success",
                    zindex: 99999
                });
                $('#txt-id-delete-configuracion-documento').val('');
                $("#modal_confirm_delete_inventario_vehiculo").modal('hide');
                getIventarioVehiculos();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la Configuración de inventario vehiculo eliminado!",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_inventario_vehiculo").modal('hide');
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

btnAgregarDetalleInventarioDocumento.addEventListener('click', e => {
    e.preventDefault();

    let errores = '';

    errores += txtDetalleTitulo.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar el detalle del inventario de vehiculo",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        agregarRegistroDetalleInventario(idM++, bodyDetalleInventario, txtDetalleTitulo.value, SelectDetalleTipo.value);
        txtDetalleTitulo.value = "";
        SelectDetalleTipo.value = 1;
        textDetalleInventario.innerText = "Añadir";
    }
});

function agregarRegistroDetalleInventario(idA, body, detalle_titulo, detalle_tipo) {
    let sinInfo = body.querySelector(`tr[data-info='sinInfo']`);
    let textDetalleTipo = SelectDetalleTipo.querySelector(`option[value="${detalle_tipo}"]`);

    if (sinInfo) {
        sinInfo.remove();
    }

    if (body.dataset.id == 0) {
        body.innerHTML += `<tr id="${idA}" data-detalle_titulo="${detalle_titulo}" data-detalle_tipo="${detalle_tipo}">
                                            <td align="center" class="color-td">${detalle_titulo.toUpperCase()}</td>
                                            <td align="center" class="color-td">${textDetalleTipo.innerText}</td>
                                            <td class="color-td" align="center">
                                                <button type="button" data-id="${idA}" data-detalle_titulo="${detalle_titulo}" data-detalle_tipo="${detalle_tipo}" id="btn_editar_detalle_inventario-${idA}" class="tam-btn btn btn-warning"><i class="fa fa-edit tam-icono"></i></button>'
                                                <button type="button" data-id="${idA}" id="btn_eliminar_detalle_inventario_tipo-${idA}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>'
                                            </td>
                                        </tr>`;
    } else {
        id = body.dataset.id;
        let itemModficado = body.querySelector(`tr[id="${id}"]`);
        itemModficado.dataset.detalle_titulo = detalle_titulo;
        itemModficado.dataset.detalle_tipo = detalle_tipo;
        itemModficado.innerHTML = `<td align="center" class="color-td">${detalle_titulo.toUpperCase()}</td>
                                    <td align="center" class="color-td">${textDetalleTipo.innerText}</td>
                                    <td class="color-td" align="center">
                                        <button type="button" data-id="${id}" data-detalle_titulo="${detalle_titulo}" data-detalle_tipo="${detalle_tipo}" id="btn_editar_detalle_inventario-${id}" class="tam-btn btn btn-warning"><i class="fa fa-edit tam-icono"></i></button>'
                                        <button type="button" data-id="${id}" id="btn_eliminar_detalle_inventario_tipo-${id}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>'
                                    </td>`;
    }

    modificarCampoDetalleInventario(body);
    eliminarCampoDetalleInventario(body);
}

function modificarCampoDetalleInventario(body) {
    let btns = body.querySelectorAll('tr[id] button[id^="btn_editar_detalle_inventario-"]');

    btns.forEach((b) => {
        b.addEventListener('click', () => {
            textDetalleInventario.innerText = "Modificar";
            body.dataset.id = b.dataset.id;
            txtDetalleTitulo.value = b.dataset.detalle_titulo;
            SelectDetalleTipo.value = b.dataset.detalle_tipo;
        });
    });
}

function eliminarCampoDetalleInventario(body) {
    let btns = body.querySelectorAll('tr[id] button[id^="btn_eliminar_detalle_inventario_tipo-"]');
    btns.forEach((b) => {
        b.addEventListener('click', () => {
            let itemEliminado = body.querySelector(`tr[id="${b.dataset.id}"]`);
            itemEliminado.remove();
            checkClearCamposDocumento(body.id);
        });
    });
}

function checkClearCamposDocumento(id) {
    let trs = document.querySelectorAll(`#${id} tr`).length;
    if (trs == 0) {
        clearTrCamposDetalleInventario();
    }
}

function clearTrCamposDetalleInventario() {
    $(`#tbody_detalle_inventario-modal_agregar_inventario_vehiculo`).html("<tr data-info='sinInfo'><td class='color-td' align='center' colspan='3'>No hay información disponible</td></tr>");
    $(`#tbody_detalle_inventario-modal_agregar_inventario_vehiculo`).attr("data-id", "0");
}