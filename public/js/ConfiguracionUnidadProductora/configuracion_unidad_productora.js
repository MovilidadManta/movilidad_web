let btnAgregarConfiguracionUnidadProductora = document.getElementById('btn_añadir_configuracion_unidad_productora');
let btnGuardarConfiguracionUnidadProductora = document.getElementById('btn_guardar_configuracion_unidad_productora-modal_agregar_configuracion_unidad_productora');
let btnModificarConfiguracionUnidadProductora = document.getElementById('btn_guardar_configuracion_unidad_productora-modal_modificar_configuracion_unidad_productora');
let btnDeleteConfiguracionUnidadProductora = document.getElementById('btn_delete_configuracion_unidad_productora');
let btnAgregarUnidadProductoraSerie = document.getElementById('btn_guardar_unidad_productora_serie-modal_agregar_configuracion_unidad_productora');
let btnAgregarUnidadProductoraSerieMod = document.getElementById('btn_guardar_unidad_productora_serie-modal_modificar_configuracion_unidad_productora');
let accordionSeries = document.getElementById('acordionSeries');
let btnDeleteConfiguracionUnidadProductoraSerieDocumento = document.getElementById('btn_delete_configuracion_unidad_productora_serie_documento');
let bodyEliminarDocumentoSerie;
$(document).ready(function () {
    getConfiguracionUnidadProductora();

    btnAgregarConfiguracionUnidadProductora.addEventListener('click', () => {
        $("#modal_agregar_configuracion_unidad_productora").modal("show");
    });

    btnGuardarConfiguracionUnidadProductora.addEventListener('click', agregarConfiguracionUnidadProductora);
    btnModificarConfiguracionUnidadProductora.addEventListener('click', modificarConfiguracionUnidadProductora);

    btnAgregarUnidadProductoraSerie.addEventListener('click', ((e) => {
        e.preventDefault();
        agregarModificarUnidadProductoraSerie('modal_agregar_configuracion_unidad_productora');
    }));
    btnAgregarUnidadProductoraSerieMod.addEventListener('click', ((e) => {
        e.preventDefault();
        agregarModificarUnidadProductoraSerie('modal_modificar_configuracion_unidad_productora');
    }));

    //Agregar
    setInputValidations('txt_nombre-modal_agregar_configuracion_unidad_productora', ['notEmpty'], []);
    setInputValidations('txt_codigo-modal_agregar_configuracion_unidad_productora', ['notEmpty'], []);
    setInputValidations('txt_descripcion-modal_agregar_configuracion_unidad_productora', ['notEmpty'], []);
    setInputValidations('txt_nombre_serie-modal_agregar_configuracion_unidad_productora', ['notEmpty'], []);
    setInputValidations('txt_codigo_serie-modal_agregar_configuracion_unidad_productora', ['notEmpty'], []);
    setInputValidations('txt_descripcion_serie-modal_agregar_configuracion_unidad_productora', ['notEmpty'], []);
    //Modificar
    setInputValidations('txt_nombre-modal_modificar_configuracion_unidad_productora', ['notEmpty'], []);
    setInputValidations('txt_codigo-modal_modificar_configuracion_unidad_productora', ['notEmpty'], []);
    setInputValidations('txt_descripcion-modal_modificar_configuracion_unidad_productora', ['notEmpty'], []);
    setInputValidations('txt_nombre_serie-modal_modificar_configuracion_unidad_productora', ['notEmpty'], []);
    setInputValidations('txt_codigo_serie-modal_modificar_configuracion_unidad_productora', ['notEmpty'], []);
    setInputValidations('txt_descripcion_serie-modal_modificar_configuracion_unidad_productora', ['notEmpty'], []);

    $('#txt_nombre-modal_agregar_configuracion_unidad_productora').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_codigo-modal_agregar_configuracion_unidad_productora').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_nombre_serie-modal_agregar_configuracion_unidad_productora').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_codigo_serie-modal_agregar_configuracion_unidad_productora').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_nombre-modal_modificar_configuracion_unidad_productora').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_codigo-modal_modificar_configuracion_unidad_productora').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_nombre_serie-modal_modificar_configuracion_unidad_productora').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_codigo_serie-modal_modificar_configuracion_unidad_productora').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });

    clearTrUnidadProductoraSerie('modal_agregar_configuracion_unidad_productora');
    clearTrUnidadProductoraSerie('modal_modificar_configuracion_unidad_productora');
});

function getConfiguracionUnidadProductora() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/ConfiguracionUnidadProductora/get_configuracion_unidad_productora',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response)
            let html = configureTableHtml("table_configuracion_unidad_productora",
                ['#', 'NOMBRE', 'CÓDIGO', 'DESCRIPCION', 'SERIES', 'ESTADO', 'OPCIONES'
                ],
                ['cup_id', 'cup_nombre', 'cup_codigo', 'cup_descripcion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '<p style="white-space: pre-line;">';
                            JSON.parse(item.campos_serie).forEach(c => {
                                value += `[${c.cups_nombre},${c.cups_codigo}] \n`;
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
                            if (item.cup_estado) {
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
                            <a href="#" alt="Ver Lista" class="tooltip"><span class="tooltiptext">Configurar Series</span><button type="button" class="tam-btn btn btn-info btn-modal-editar" Onclick ='show_config_series(${item.cup_id},"${item.cup_nombre}",${JSON.stringify(JSON.parse(item.campos_serie))})'><i class="fa fa-list-alt tam-icono"></i></button></a>
                            <a href="#" alt="Modificar" class="tooltip"><span class="tooltiptext">Modificar</span><button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ='show_mod_configuracion_unidad_productora(${item.cup_id},"${item.cup_nombre}","${item.cup_codigo}","${item.cup_descripcion}",${JSON.stringify(JSON.parse(item.campos_serie))},${item.cup_estado})'><i class="fa fa-edit tam-icono"></i></button></a>
                            <a href="#" alt="Eliminar" class="tooltip"><span class="tooltiptext">Eliminar</span><button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_configuracion_unidad_productora(${item.cup_id})"><i class="fa fa-trash tam-icono"></i></button></a>
                            `;
                        }
                    },
                ], response
            );

            $("#div_table_configuracion_unidad_productora").html(html);

            $("#table_configuracion_unidad_productora").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function agregarConfiguracionUnidadProductora() {

    let nombreE = document.getElementById('txt_nombre-modal_agregar_configuracion_unidad_productora');
    let codigoE = document.getElementById('txt_codigo-modal_agregar_configuracion_unidad_productora');
    let descripcionE = document.getElementById('txt_descripcion-modal_agregar_configuracion_unidad_productora');
    let estadoE = document.getElementById('chk_estado-modal_agregar_configuracion_unidad_productora');
    let filasUnidadProductoraSerie = document.querySelectorAll('#tbody_unidad_productora_serie-modal_agregar_configuracion_unidad_productora tr[id]');
    let camposUnidadProductoraSerie = [];

    filasUnidadProductoraSerie.forEach(d => {
        camposUnidadProductoraSerie.push({
            id: d.dataset.id,
            nombre: d.dataset.nombre,
            codigo: d.dataset.codigo,
            descripcion: d.dataset.descripcion
        });
    });

    let errores = "";

    errores += nombreE.validateInput();
    errores += codigoE.validateInput();
    //errores += descripcionE.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede registrar la configuración de la unidad productora, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $("#btn_guardar_configuracion_documento-modal_agregar_configuracion_unidad_productora").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");

        let token = $("#csrf-token-modal_agregar_configuracion_unidad_productora").val();
        let datos = new FormData($("#form_agregar_configuracion_unidad_productora")[0]);
        datos.append('estado', estadoE.checked);
        datos.append('series', JSON.stringify(camposUnidadProductoraSerie));

        $.ajax({
            url: '/ConfiguracionUnidadProductora/store',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Configuración de la Unidad Productora Registrada!",
                        type: "success",
                        zindex: 99999
                    });
                    nombreE.value = "";
                    codigoE.value = "";
                    descripcionE.value = "";
                    estadoE.checked = true;
                    estadoE.dispatchEvent(new Event('change'));
                    clearTrUnidadProductoraSerie('modal_agregar_configuracion_unidad_productora');
                    $("#modal_agregar_configuracion_unidad_productora").modal('hide');
                    $("#btn_guardar_configuracion_documento-modal_agregar_configuracion_unidad_productora").html("<i class='fa fa-save'></i> Guardar");
                    getConfiguracionUnidadProductora();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido registrar la configuración de la Unidad Productora!",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn_guardar_configuracion_documento-modal_agregar_configuracion_unidad_productora").html("<i class='fa fa-save'></i> Guardar");
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

function show_mod_configuracion_unidad_productora(id, nombre, codigo, descripcion, series, estado) {
    let idModificar = document.getElementById('id_configuracion_unidad_productora-modal_modificar_configuracion_unidad_productora');
    let nombreE = document.getElementById('txt_nombre-modal_modificar_configuracion_unidad_productora');
    let codigoE = document.getElementById('txt_codigo-modal_modificar_configuracion_unidad_productora');
    let descripcionE = document.getElementById('txt_descripcion-modal_modificar_configuracion_unidad_productora');
    let estadoE = document.getElementById('chk_estado-modal_modificar_configuracion_unidad_productora');
    let bodyDocumento = document.getElementById('tbody_unidad_productora_serie-modal_modificar_configuracion_unidad_productora');
    let nombreSerieE = document.getElementById(`txt_nombre_serie-modal_modificar_configuracion_unidad_productora`);
    let codigoSerieE = document.getElementById(`txt_codigo_serie-modal_modificar_configuracion_unidad_productora`);
    let DescripcionSerieE = document.getElementById(`txt_descripcion_serie-modal_modificar_configuracion_unidad_productora`);
    let txtBtnAgregar = document.getElementById(`text_btn_añadir_unidad_productora_serie-modal_modificar_configuracion_unidad_productora`);
    let idM = 1;

    clearTrUnidadProductoraSerie('modal_modificar_configuracion_unidad_productora');

    series.forEach(f => {
        agregarRegistroUnidadProductoraSerie(idM++, bodyDocumento, f.cups_id, f.cups_nombre, nombreSerieE, f.cups_codigo, codigoSerieE, f.cups_descripcion, DescripcionSerieE, txtBtnAgregar, 'modal_modificar_configuracion_unidad_productora');
    });

    idModificar.value = id;
    nombreE.value = nombre;
    codigoE.value = codigo;
    descripcionE.value = descripcion;
    estadoE.checked = estado;

    estadoE.dispatchEvent(new Event('change'));

    $("#modal_modificar_configuracion_unidad_productora").modal("show");
}

function modificarConfiguracionUnidadProductora() {
    let nombreE = document.getElementById('txt_nombre-modal_modificar_configuracion_unidad_productora');
    let codigoE = document.getElementById('txt_codigo-modal_modificar_configuracion_unidad_productora');
    let descripcionE = document.getElementById('txt_descripcion-modal_modificar_configuracion_unidad_productora');
    let estadoE = document.getElementById('chk_estado-modal_modificar_configuracion_unidad_productora');
    let filasUnidadProductoraSerie = document.querySelectorAll('#tbody_unidad_productora_serie-modal_modificar_configuracion_unidad_productora tr[id]');
    let camposUnidadProductoraSerie = [];

    filasUnidadProductoraSerie.forEach(d => {
        camposUnidadProductoraSerie.push({
            id: d.dataset.id,
            nombre: d.dataset.nombre,
            codigo: d.dataset.codigo,
            descripcion: d.dataset.descripcion
        });
    });

    let errores = "";

    errores += nombreE.validateInput();
    errores += codigoE.validateInput();
    //errores += descripcionE.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede modificar la configuración de la unidad productora, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $("#btn_guardar_configuracion_documento-modal_modificar_configuracion_unidad_productora").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");

        let token = $("#csrf-token-modal_modificar_configuracion_unidad_productora").val();
        let datos = new FormData($("#form_modificar_configuracion_unidad_productora")[0]);
        datos.append('estado', estadoE.checked);
        datos.append('series', JSON.stringify(camposUnidadProductoraSerie));

        $.ajax({
            url: '/ConfiguracionUnidadProductora/update',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Configuración de la Unidad Productora Modificada!",
                        type: "success",
                        zindex: 99999
                    });
                    nombreE.value = "";
                    codigoE.value = "";
                    descripcionE.value = "";
                    estadoE.checked = true;
                    estadoE.dispatchEvent(new Event('change'));
                    $("#modal_modificar_configuracion_unidad_productora").modal('hide');
                    clearTrUnidadProductoraSerie('modal_modificar_configuracion_unidad_productora');
                    $("#btn_guardar_configuracion_documento-modal_modificar_configuracion_unidad_productora").html("<i class='fa fa-save'></i> Guardar");
                    getConfiguracionUnidadProductora();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido modificar la configuración de la Unidad Productora!",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn_guardar_configuracion_documento-modal_modificar_configuracion_unidad_productora").html("<i class='fa fa-save'></i> Guardar");
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

function show_delete_configuracion_unidad_productora(id) {
    $('#txt_id_delete_configuracion_unidad_productora').val(id);
    $("#modal_confirm_delete_configuracion_unidad_productora").modal("show");
}

btnDeleteConfiguracionUnidadProductora.addEventListener('click', function () {
    let id = $('#txt_id_delete_configuracion_unidad_productora').val();
    let token = $("#csrf-token-modal_confirm_delete_configuracion_unidad_productora").val();
    $.ajax({
        url: `/ConfiguracionUnidadProductora/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Configuración de la Unidad Productora Eliminada!",
                    type: "success",
                    zindex: 99999
                });
                $('#txt_id_delete_configuracion_unidad_productora').val('');
                $("#modal_confirm_delete_configuracion_unidad_productora").modal('hide');
                getConfiguracionUnidadProductora();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la Configuración de la Unidad Productora",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_configuracion_unidad_productora").modal('hide');
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

function checkClearUnidadProductoraSerie(id, modal) {
    let trs = document.querySelectorAll(`#${id} tr`).length;
    if (trs == 0) {
        clearTrUnidadProductoraSerie(modal);
    }
}

function clearTrUnidadProductoraSerie(modal) {
    $(`#tbody_unidad_productora_serie-${modal}`).html("<tr data-info='sinInfo'><td class='color-td' align='center' colspan='4'>No hay información disponible</td></tr>");
    $(`#tbody_unidad_productora_serie-${modal}`).attr("data-id", "0");
    $(`#txt_nombre_serie-${modal}`).val('');
    $(`#txt_codigo_serie-${modal}`).val('');
    $(`#txt_descripcion_serie-${modal}`).val('');
}

function agregarModificarUnidadProductoraSerie(modal) {
    let bodyTableUnidadProductoraSerie = document.getElementById(`tbody_unidad_productora_serie-${modal}`);
    let Trs = bodyTableUnidadProductoraSerie.querySelectorAll('tr[id]');
    let nombreSerieE = document.getElementById(`txt_nombre_serie-${modal}`);
    let codigoSerieE = document.getElementById(`txt_codigo_serie-${modal}`);
    let descripcionSerieE = document.getElementById(`txt_descripcion_serie-${modal}`);
    let btnAgregar = document.getElementById(`text_btn_añadir_unidad_productora_serie-${modal}`);
    let id = Trs.length == 0 ? 1 : parseInt(Trs[Trs.length - 1].id) + 1;
    let errores = "";

    errores += nombreSerieE.validateInput();
    //errores += codigoSerieE.validateInput();
    //errores += descripcionSerieE.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar la serie para la unidad productora, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {

        nombreSerieE.value = nombreSerieE.value.toUpperCase();
        codigoSerieE.value = codigoSerieE.value.toUpperCase();
        descripcionSerieE.value = descripcionSerieE.value.toUpperCase();

        agregarRegistroUnidadProductoraSerie(id, bodyTableUnidadProductoraSerie, 0, nombreSerieE.value, nombreSerieE, codigoSerieE.value, codigoSerieE, descripcionSerieE.value, descripcionSerieE, btnAgregar, modal);

        bodyTableUnidadProductoraSerie.dataset.id = 0;
        nombreSerieE.value = "";
        codigoSerieE.value = "";
        descripcionSerieE.value = "";
        btnAgregar.innerHTML = "Añadir";
    }
}

function agregarRegistroUnidadProductoraSerie(idA, body, idBase, nombreSerie, nombreSerieElement, codigoSerie, codigoSerieElement, descripcionSerie, descripcionSerieElement, btnAgregar, modal) {
    let sinInfo = body.querySelector(`tr[data-info='sinInfo']`);

    if (sinInfo) {
        sinInfo.remove();
    }

    if (body.dataset.id == 0) {
        body.innerHTML += `<tr id="${idA}" data-id="${idBase}" data-nombre="${nombreSerie}" data-codigo="${codigoSerie}" data-descripcion="${descripcionSerie}">
                                            <td align="center" class="color-td">${nombreSerie}</td>
                                            <td align="center" class="color-td">${codigoSerie}</td>
                                            <td align="center" class="color-td">${descripcionSerie}</td>
                                            <td class="color-td" align="center">
                                                <button type="button" data-id="${idA}" data-nombre="${nombreSerie}" data-codigo="${codigoSerie}" data-descripcion="${descripcionSerie}" id="btn_editar_unidad_productora_serie-${idA}" class="tam-btn btn btn-warning"><i class="fa fa-edit tam-icono"></i></button>'
                                                <button type="button" data-id="${idA}" id="btn_eliminar_unidad_productora_serie-${idA}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>'
                                            </td>
                                        </tr>`;
    } else {
        id = body.dataset.id;
        let itemModficado = body.querySelector(`tr[id="${id}"]`);
        itemModficado.dataset.nombre = nombreSerie;
        itemModficado.dataset.codigo = codigoSerie;
        itemModficado.dataset.descripcion = descripcionSerie;
        itemModficado.innerHTML = `<td align="center" class="color-td">${nombreSerie}</td>
                                    <td align="center" class="color-td">${codigoSerie}</td>
                                    <td align="center" class="color-td">${descripcionSerie}</td>
                                    <td class="color-td" align="center">
                                        <button type="button" data-id="${id}" data-nombre="${nombreSerie}" data-codigo="${codigoSerie}" data-descripcion="${descripcionSerie}" id="btn_editar_unidad_productora_serie-${id}" class="tam-btn btn btn-warning"><i class="fa fa-edit tam-icono"></i></button>'
                                        <button type="button" data-id="${id}" id="btn_eliminar_unidad_productora_serie-${id}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>'
                                    </td>`;
    }

    modificarUnidadProductoraSerie(body, nombreSerieElement, codigoSerieElement, descripcionSerieElement, btnAgregar);
    eliminarUnidadProductoraSerie(body, modal);
}

function modificarUnidadProductoraSerie(body, nombreSerie, codigoSerie, descripcionSerie, btnAgregar) {
    let btns = body.querySelectorAll('tr[id] button[id^="btn_editar_unidad_productora_serie-"]');

    btns.forEach((b) => {
        b.addEventListener('click', () => {
            btnAgregar.innerHTML = "Modificar";
            body.dataset.id = b.dataset.id;
            nombreSerie.value = b.dataset.nombre;
            codigoSerie.value = b.dataset.codigo;
            descripcionSerie.value = b.dataset.descripcion;
        });
    });
}

function eliminarUnidadProductoraSerie(body, modal) {
    let btns = body.querySelectorAll('tr[id] button[id^="btn_eliminar_unidad_productora_serie-"]');
    btns.forEach((b) => {
        b.addEventListener('click', () => {
            let itemModficado = body.querySelector(`tr[id="${b.dataset.id}"]`);
            itemModficado.remove();
            checkClearUnidadProductoraSerie(body.id, modal);
        });
    });
}

function show_config_series(id, nombre, series) {

    $("#modal_configurar_series").modal("show");
    $('#title_modal_configurar_series').html(nombre);
    $('#unidad_productora_id_modal').val(id);

    accordionSeries.innerHTML = "";

    series.forEach(f => {
        accordionSeries.innerHTML += `
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="${f.cups_id}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${f.cups_id}" aria-expanded="true" aria-controls="collapse${f.cups_id}">
                            ${f.cups_nombre}(${f.cups_codigo})
                        </button>
                      </h2>
                      <div id="collapse${f.cups_id}" class="accordion-collapse collapse show" aria-labelledby="${f.cups_id}" data-bs-parent="#accordionSeries">
                        <div class="accordion-body">
                            <div class="alert alert-secondary" role="alert">
                                ${f.cups_descripcion}
                            </div>
                            <div class="row mb-3">
                                <div class="col-xs-12 col-md-9">
                                    <strong>Documento:</strong>
                                    <input id="txt-search-documento-${f.cups_id}" data-label='Documento' class="form-control input-mayus" data-noresults_text="No se encontraron resultados" data-wait_search="Buscando Documentos..." type="text" autocomplete="off" placeholder="Buscar documento..."
                                    value=""
                                    data-value=""
                                    data-text=""
                                    >
                                    <span class="badge bg-danger" data-for="txt-search-documento-${f.cups_id}"></span>
                                </div>
                                <div class="col-xs-12 col-md-3 d-flex justify-content-end align-items-end">
                                    <button class="btn btn-success-gradient btn-movi" data-id="${f.cups_id}" data-documento="${f.cups_nombre}" data-codigo="${f.cups_codigo}" data-descripcion="${f.cups_descripcion}" id="btn_guardar_documento-serie-${f.cups_id}" type="button"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </div>
                            <div class="row">
                                <table border="2" class="table">
                                    <thead class="background-thead">
                                        <tr align="center">
                                            <th align="center" class="border-bottom-0 color-th">Documento</th>
                                            <th align="center" class="border-bottom-0 color-th">Descripción</th>
                                            <th align="center" class="border-bottom-0 color-th">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_configurar_series_documentos-${f.cups_id}" data-id='0'>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                    </div>
        `;
    });

    cargarBuscarDocumentosSeries(accordionSeries);
    clearTrSerieDocumentoAll(accordionSeries);
    btnsGuardarDocumentoSerie(accordionSeries);
    cargarInformacionDocumentosSeries();
}

function cargarBuscarDocumentosSeries(accordionSeries) {
    let inputs = accordionSeries.querySelectorAll('input[id^="txt-search-documento-"]');

    let ajaxPrevDocumentosSeries = null;
    inputs.forEach((i) => {
        setInputValidations(i.id, ['notEmpty'], [
            {
                function: function (item) {
                    return item.value.trim() != "" && (item.dataset.value == undefined || item.dataset.value.trim() == "");
                },
                message: "Debe buscar y seleccionar un documento"
            }
        ]);

        custom_search_input(i.id, {
            formatResult: function (item) {
                return {
                    value: item.cd_id,
                    text: `${item.cd_nombre} ${item.cd_codigo.trim() != "" ? `(${item.cd_codigo.trim()})` : ''}`,
                    html: `${item.cd_nombre} ${item.cd_codigo.trim() != "" ? `(${item.cd_codigo.trim()})` : ''}`
                }
            },
            datasets: function (item) {
                return {
                    codigo: item.cd_codigo,
                    descripcion: item.cd_descripcion
                }
            },
            search: function (text, callback) {
                if (ajaxPrevDocumentosSeries != null)
                    ajaxPrevDocumentosSeries.abort();

                let ajax = $.ajax(
                    `/ConfiguracionDocumentosArchivo/get_search_active_documents/1/100/${text}`
                ).done(function (res) {
                    callback(res.respuesta ? res.data : []);
                });

                ajaxPrevDocumentosSeries = ajax;
            }
        });
    });
}

function btnsGuardarDocumentoSerie(accordionSeries) {
    let buttons = accordionSeries.querySelectorAll('button[id^="btn_guardar_documento-serie-"]');
    let idUnidadProductora = $('#unidad_productora_id_modal').val();
    buttons.forEach(b => {
        b.addEventListener('click', () => {
            let txtDocumento = document.getElementById(`txt-search-documento-${b.dataset.id}`);
            let tableButton = document.getElementById(`tbody_configurar_series_documentos-${b.dataset.id}`);

            if (txtDocumento.validateInput().trim() != "") {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se puede agregar el documento, favor verifique los datos ingresados",
                    position: "right",
                    autohide: true,
                    zindex: 99999
                });
            } else {
                let token = $("#csrf-token-configurar_series").val();
                let datos = new FormData();
                datos.append('cups_id', b.dataset.id);
                datos.append('cup_id', idUnidadProductora);
                datos.append('cd_id', txtDocumento.dataset.value);

                $.ajax({
                    url: '/ConfiguracionUnidadProductora/store_serie_documento',
                    type: 'POST',
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': token },
                    contentType: false,
                    processData: false,
                    data: datos,
                    success: function (response) {
                        if (response.respuesta == "true") {
                            notif({
                                msg: "<b>Correcto:</b>Documento agregado a la serie!",
                                type: "success",
                                zindex: 99999
                            });
                            agregarRegistroSerieDocumento(response.data, tableButton, txtDocumento.value, b.dataset.descripcion);
                            txtDocumento.value = "";
                        } else {
                            notif({
                                type: "warning",
                                msg: "<b>Aviso: </b>No se ha podido agregar el documento a la serie!",
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
    });
}

function clearTrSerieDocumentoAll(accordionSeries) {
    let bodyTables = accordionSeries.querySelectorAll('tbody[id^="tbody_configurar_series_documentos-"]');
    bodyTables.forEach(t => {
        clearTrSerieDocumento(t.id);
    });
}

function clearTrSerieDocumento(id) {
    $(`#${id}`).html("<tr data-info='sinInfo'><td class='color-td' align='center' colspan='3'>No hay información disponible</td></tr>");
    $(`#${id}`).attr("data-id", "0");
}

function agregarRegistroSerieDocumento(id, body, documento, descripcion) {
    let sinInfo = body.querySelector(`tr[data-info='sinInfo']`);

    if (sinInfo) {
        sinInfo.remove();
    }

    body.innerHTML += `<tr id="${id}">
                                        <td align="center" class="color-td">${documento}</td>
                                        <td align="center" class="color-td">${descripcion}</td>
                                        <td class="color-td" align="center">
                                            <button type="button" data-id="${id}" id="btn_eliminar_serie_documento-${id}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>'
                                        </td>
                                    </tr>`;
    getButtonsEliminarSerieDocumento(body);
}

function cargarInformacionDocumentosSeries() {
    let idUnidadProductora = $('#unidad_productora_id_modal').val();
    let token = $("#csrf-token-configurar_series").val();
    $.ajax({
        url: `/ConfiguracionUnidadProductora/get_configuracion_serie_documento/${idUnidadProductora}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            response.forEach(d => {
                let body = document.querySelector(`#tbody_configurar_series_documentos-${d.cups_id}`);
                if (body)
                    agregarRegistroSerieDocumento(d.cupsd_id, body, d.cd_nombre, d.cd_descripcion);
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

function getButtonsEliminarSerieDocumento(body) {
    let btns = body.querySelectorAll('button[id^="btn_eliminar_serie_documento-"]');

    btns.forEach(b => {
        b.addEventListener('click', () => {
            $('#txt_id_delete_configuracion_unidad_productora_serie_documento').val(b.dataset.id);
            bodyEliminarDocumentoSerie = body;
            $("#modal_confirm_delete_configuracion_unidad_productora_serie_documento").modal("show");
        });
    });
}

btnDeleteConfiguracionUnidadProductoraSerieDocumento.addEventListener('click', () => {
    let token = $("#csrf-token-modal_confirm_delete_configuracion_unidad_productora_serie_documento").val();
    let id = $('#txt_id_delete_configuracion_unidad_productora_serie_documento').val();
    $.ajax({
        url: `/ConfiguracionUnidadProductora/delete_serie_documento/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b>Documento eliminado de la serie!",
                    type: "success",
                    zindex: 99999
                });
                let itemEliminar = bodyEliminarDocumentoSerie.querySelector(`tr[id="${id}"]`);
                itemEliminar.remove();
                $("#modal_confirm_delete_configuracion_unidad_productora_serie_documento").modal("hide");
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar el documento a la serie!",
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