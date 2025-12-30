let btnAgregarConfiguracionUnidadAlmacenamiento = document.getElementById('btn-añadir-configuracion-unidades-almacenamiento');
let btnGuardarConfiguracionUnidadAlmacenamiento = document.getElementById('btn-guardar-configuracion-unidad-almacenamiento-modal_agregar_configuracion_unidades_almacenamiento');
let btnModificarConfiguracionUnidadAlmacenamiento = document.getElementById('btn-guardar-configuracion-unidad-almacenamiento-modal_modificar_configuracion_unidades_almacenamiento');
let btnDeleteConfiguracionUnidadAlmacenamiento = document.getElementById('btn-delete-configuracion-unidades-almacenamiento');
let containerIconsAgregar = document.getElementById('container_icon-modal_agregar_configuracion_unidades_almacenamiento');
let containerIconsModificar = document.getElementById('container_icon-modal_modificar_configuracion_unidades_almacenamiento');
let containerUnidadesAgregar = document.getElementById('container_unidades-modal_agregar_configuracion_unidades_almacenamiento');
let containerUnidadesModificar = document.getElementById('container_unidades-modal_modificar_configuracion_unidades_almacenamiento');
let list_unidades_almacenamiento = [];

$(document).ready(function () {
    $('.dropify').dropify();
    getConfiguracionUnidadesAlmacenamiento();

    btnAgregarConfiguracionUnidadAlmacenamiento.addEventListener('click', () => {
        containerUnidadesAgregar.renderCards(list_unidades_almacenamiento.map(c => ({
            icon: c.cma_icono,
            text: c.cma_tipo,
            value: c.cma_id
        })));
        $("#modal_agregar_configuracion_unidades_almacenamiento").modal("show");
    });

    btnGuardarConfiguracionUnidadAlmacenamiento.addEventListener('click', agregarConfiguracionUnidadAlmacenamientoModal);
    btnModificarConfiguracionUnidadAlmacenamiento.addEventListener('click', modificarConfiguracionUnidadAlmacenamientoModal);
    //Agregar
    setInputValidations('txt_tipo-modal_agregar_configuracion_unidades_almacenamiento', ['notEmpty'], []);
    setInputValidations('txt_codigo-modal_agregar_configuracion_unidades_almacenamiento', ['notEmpty'], []);
    setInputValidations('txt_capacidad-modal_agregar_configuracion_unidades_almacenamiento', ['notEmpty'], []);
    setInputValidations('txt_caracteristicas-modal_agregar_configuracion_unidades_almacenamiento', ['notEmpty'], []);
    //Modificar
    setInputValidations('txt_tipo-modal_modificar_configuracion_unidades_almacenamiento', ['notEmpty'], []);
    setInputValidations('txt_codigo-modal_modificar_configuracion_unidades_almacenamiento', ['notEmpty'], []);
    setInputValidations('txt_capacidad-modal_modificar_configuracion_unidades_almacenamiento', ['notEmpty'], []);
    setInputValidations('txt_caracteristicas-modal_modificar_configuracion_unidades_almacenamiento', ['notEmpty'], []);

    $('#txt_tipo-modal_agregar_configuracion_unidades_almacenamiento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_codigo-modal_agregar_configuracion_unidades_almacenamiento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_capacidad-modal_agregar_configuracion_unidades_almacenamiento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_caracteristicas-modal_agregar_configuracion_unidades_almacenamiento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_tipo-modal_modificar_configuracion_unidades_almacenamiento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_codigo-modal_modificar_configuracion_unidades_almacenamiento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_capacidad-modal_modificar_configuracion_unidades_almacenamiento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });
    $('#txt_caracteristicas-modal_modificar_configuracion_unidades_almacenamiento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });

    let valuesIcons = [
        {
            icon: 'fa fa-th',
            text: 'fa-th',
            value: 'fa fa-th'
        },
        {
            icon: 'fa fa-inbox',
            text: 'fa-inbox',
            value: 'fa fa-inbox'
        },
        {
            icon: 'fa fa-dropbox',
            text: 'fa-dropbox',
            value: 'fa fa-dropbox'
        },
        {
            icon: 'fa fa-folder-open',
            text: 'fa-folder-open',
            value: 'fa fa-folder-open'
        }
    ];

    setTimeout(() => {
        containerIconsAgregar.renderCards(valuesIcons);
        containerIconsModificar.renderCards(valuesIcons);
    }, 1000);
});

function getConfiguracionUnidadesAlmacenamiento() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/ConfiguracionUnidadesAlmacenamiento/get_configuracion_unidades_almacenamiento',
        type: "GET",
        dataType: "json",
        success: function (response) {
            list_unidades_almacenamiento = response;
            let html = configureTableHtml("table-configuracion-unidades-almacenamiento",
                ['#', 'ICONO', 'TIPO', 'CÓDIGO', 'CAPACIDAD', 'CARACTERÍSTICAS', 'SUBE ARCHIVOS', 'ESTADO', 'OPCIONES'
                ],
                ['cma_id', {
                    align: 'center',
                    class: 'color-td',
                    functionValue: function (item) {
                        return `<i class="${item.cma_icono}"></i>`;
                    }
                },
                    'cma_tipo', 'cma_codigo', 'cma_capacidad', 'cma_caracteristicas',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.cma_upload_archive) {
                                value = '<i class="fa fa-check-square-o"></i>';
                            } else {
                                value = '<i class="fa fa-times-circle"></i>';
                            }
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.cma_estado) {
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
                            <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ="show_mod_configuracion_unidad_almacenamiento(${item.cma_id},'${item.cma_tipo}','${item.cma_codigo}','${item.cma_capacidad}','${item.cma_caracteristicas}','${item.cma_icono}','${item.unidades_asociadas}',${item.cma_upload_archive},${item.cma_estado})"><i class="fa fa-edit tam-icono"></i></button>
                            <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_configuracion_unidad_almacenamiento(${item.cma_id})"><i class="fa fa-trash tam-icono"></i></button>
                            `;
                        }
                    },
                ], response
            );

            $("#div-table-configuracion-unidades-almacenamiento").html(html);

            $("#table-configuracion-unidades-almacenamiento").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function agregarConfiguracionUnidadAlmacenamientoModal() {

    let tipoE = document.getElementById('txt_tipo-modal_agregar_configuracion_unidades_almacenamiento');
    let codigoE = document.getElementById('txt_codigo-modal_agregar_configuracion_unidades_almacenamiento');
    let capacidadE = document.getElementById('txt_capacidad-modal_agregar_configuracion_unidades_almacenamiento');
    let caracteristicasE = document.getElementById('txt_caracteristicas-modal_agregar_configuracion_unidades_almacenamiento');
    let estadoE = document.getElementById('chk_estado-modal_agregar_configuracion_unidades_almacenamiento');
    let uploadArchiveE = document.getElementById('chk_upload_archive-modal_agregar_configuracion_unidades_almacenamiento');
    let dangerElement = document.querySelector('span[data-for="container_card-modal_agregar_configuracion_unidades_almacenamiento"]');
    dangerElement.innerHTML = "";
    let errores = "";

    errores += tipoE.validateInput();
    errores += codigoE.validateInput();
    errores += capacidadE.validateInput();
    errores += caracteristicasE.validateInput();
    if (containerIconsAgregar.dataset.value.trim() == "") {
        let messageDangerElement = "Debe seleccionar un icono para la configuración";
        dangerElement.innerHTML = messageDangerElement;
        errores += messageDangerElement;
    }

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede registrar la configuración de la unidad de almacenamiento, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-configuracion-unidad-almacenamiento-modal_agregar_configuracion_unidades_almacenamiento").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");

        let token = $("#csrf-token-modal_agregar_configuracion_unidades_almacenamiento").val();
        let datos = new FormData($("#form_agregar_configuracion_unidades_almacenamiento")[0]);
        datos.append('estado', estadoE.checked);
        datos.append('upload_archive', uploadArchiveE.checked);
        datos.append('icono', containerIconsAgregar.dataset.value.trim());
        datos.append('list_unidades', containerUnidadesAgregar.dataset.value.trim());

        $.ajax({
            url: '/ConfiguracionUnidadesAlmacenamiento/store',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Configuración de Unidad de Almacenamiento Registrada!",
                        type: "success",
                        zindex: 99999
                    });
                    tipoE.value = "";
                    capacidadE.value = "";
                    caracteristicasE.value = "";
                    containerIconsAgregar.clearValues();
                    estadoE.checked = true;
                    estadoE.dispatchEvent(new Event('change'));
                    uploadArchiveE.checked = false;
                    uploadArchiveE.dispatchEvent(new Event('change'));
                    $("#modal_agregar_configuracion_unidades_almacenamiento").modal('hide');
                    $("#btn-guardar-configuracion-unidad-almacenamiento-modal_agregar_configuracion_unidades_almacenamiento").html("<i class='fa fa-save'></i> Guardar");
                    getConfiguracionUnidadesAlmacenamiento();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido registrar la Configuración Unidad de Almacenamiento",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-configuracion-unidad-almacenamiento-modal_agregar_configuracion_unidades_almacenamiento").html("<i class='fa fa-save'></i> Guardar");
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

function show_mod_configuracion_unidad_almacenamiento(id, tipo, codigo, capacidad, caracteristicas, icono, unidades_asociadas, uploadArchive, estado) {
    let idModificar = document.getElementById('id-configuracion-unidad-almacenamiento-modal_modificar_configuracion_unidades_almacenamiento');
    let tipoModificar = document.getElementById('txt_tipo-modal_modificar_configuracion_unidades_almacenamiento');
    let codigoModificar = document.getElementById('txt_codigo-modal_modificar_configuracion_unidades_almacenamiento');
    let capacidadModificar = document.getElementById('txt_capacidad-modal_modificar_configuracion_unidades_almacenamiento');
    let caracteristicasModificar = document.getElementById('txt_caracteristicas-modal_modificar_configuracion_unidades_almacenamiento');
    let estadoModificar = document.getElementById('chk_estado-modal_modificar_configuracion_unidades_almacenamiento');
    let uploadArchiveE = document.getElementById('chk_upload_archive-modal_modificar_configuracion_unidades_almacenamiento');
    let dangerElement = document.querySelector('span[data-for="container_card-modal_modificar_configuracion_unidades_almacenamiento"]')

    idModificar.value = id;
    tipoModificar.value = tipo;
    codigoModificar.value = codigo;
    capacidadModificar.value = capacidad;
    caracteristicasModificar.value = caracteristicas;
    uploadArchiveE.checked = uploadArchive;
    estadoModificar.checked = estado;
    dangerElement.innerHTML = "";
    containerIconsModificar.setActive(icono);

    uploadArchiveE.dispatchEvent(new Event('change'));
    estadoModificar.dispatchEvent(new Event('change'));

    containerUnidadesModificar.renderCards(list_unidades_almacenamiento.filter(e => e.cma_id != id).map(c => ({
        icon: c.cma_icono,
        text: c.cma_tipo,
        value: c.cma_id
    })));

    containerUnidadesModificar.setActive(unidades_asociadas.trim() == "" ? [] : unidades_asociadas.split(","));

    $("#modal_modificar_configuracion_unidades_almacenamiento").modal("show");
}

function modificarConfiguracionUnidadAlmacenamientoModal() {
    let tipoE = document.getElementById('txt_tipo-modal_modificar_configuracion_unidades_almacenamiento');
    let codigoE = document.getElementById('txt_codigo-modal_modificar_configuracion_unidades_almacenamiento');
    let capacidadE = document.getElementById('txt_capacidad-modal_modificar_configuracion_unidades_almacenamiento');
    let caracteristicasE = document.getElementById('txt_caracteristicas-modal_modificar_configuracion_unidades_almacenamiento');
    let estadoE = document.getElementById('chk_estado-modal_modificar_configuracion_unidades_almacenamiento');
    let uploadArchiveE = document.getElementById('chk_upload_archive-modal_modificar_configuracion_unidades_almacenamiento');
    let dangerElement = document.querySelector('span[data-for="container_card-modal_modificar_configuracion_unidades_almacenamiento"]');
    dangerElement.innerHTML = "";
    let errores = "";

    errores += tipoE.validateInput();
    errores += codigoE.validateInput();
    errores += capacidadE.validateInput();
    errores += caracteristicasE.validateInput();
    if (containerIconsModificar.dataset.value.trim() == "") {
        let messageDangerElement = "Debe seleccionar un icono para la configuración";
        dangerElement.innerHTML = messageDangerElement;
        errores += messageDangerElement;
    }

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede modificar la configuración de la unidad de almacenamiento, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-configuracion-unidad-almacenamiento-modal_modificar_configuracion_unidades_almacenamiento").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");

        let token = $("#csrf-token-modal_modificar_configuracion_unidades_almacenamiento").val();
        let datos = new FormData($("#form_modificar_configuracion_unidades_almacenamiento")[0]);
        datos.append('estado', estadoE.checked);
        datos.append('upload_archive', uploadArchiveE.checked);
        datos.append('icono', containerIconsModificar.dataset.value.trim());
        datos.append('list_unidades', containerUnidadesModificar.dataset.value.trim());

        $.ajax({
            url: `/ConfiguracionUnidadesAlmacenamiento/update`,
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Configuración de Unidad de Almacenamiento Modificada!",
                        type: "success",
                        zindex: 99999
                    });
                    tipoE.value = "";
                    capacidadE.value = "";
                    caracteristicasE.value = "";
                    containerIconsModificar.clearValues();
                    estadoE.checked = true;
                    estadoE.dispatchEvent(new Event('change'));
                    uploadArchiveE.checked = false;
                    uploadArchiveE.dispatchEvent(new Event('change'));
                    $("#modal_modificar_configuracion_unidades_almacenamiento").modal('hide');
                    $("#btn-guardar-configuracion-unidad-almacenamiento-modal_modificar_configuracion_unidades_almacenamiento").html("<i class='fa fa-save'></i> Guardar");
                    getConfiguracionUnidadesAlmacenamiento();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido registrar la Unidad de Almacenamiento",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-configuracion-unidad-almacenamiento-modal_modificar_configuracion_unidades_almacenamiento").html("<i class='fa fa-save'></i> Guardar");
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

function show_delete_configuracion_unidad_almacenamiento(id) {
    $('#txt-id-delete-configuracion-unidades-almacenamiento').val(id);
    $("#modal_confirm_delete_configuracion_unidades_almacenamiento").modal("show");
}

btnDeleteConfiguracionUnidadAlmacenamiento.addEventListener('click', function () {
    let id = $('#txt-id-delete-configuracion-unidades-almacenamiento').val();
    let token = $("#csrf-token-modal_confirm_delete_configuracion_unidades_almacenamiento").val();
    $.ajax({
        url: `/ConfiguracionUnidadesAlmacenamiento/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Unidad de Almacenamiento Eliminado!",
                    type: "success",
                    zindex: 99999
                });
                $('#txt-id-delete-configuracion-unidades-almacenamiento').val('');
                $("#modal_confirm_delete_configuracion_unidades_almacenamiento").modal('hide');
                getConfiguracionUnidadesAlmacenamiento();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la Unidad de Almacenamiento",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_configuracion_unidades_almacenamiento").modal('hide');
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