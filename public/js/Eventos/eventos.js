let btnAgregarEventos = document.getElementById('btn-añadir-eventos');
let btnGuardarEventos = document.getElementById('btn-guardar-evento-modal_agregar_evento');
let btnModificarEventos = document.getElementById('btn-guardar-evento-modal_modificar_evento');
let btnDeleteEventos = document.getElementById('btn-delete-evento');

$(document).ready(function () {
    $('.dropify').dropify();
    getEventos();

    btnAgregarEventos.addEventListener('click', () => {
        let drEvent2 = $('#txt-ruta-foto-modal_agregar_evento').dropify();
        drEvent2 = drEvent2.data('dropify');
        drEvent2.resetPreview();
        drEvent2.clearElement();
        $("#modal_agregar_evento").modal("show");
    });

    btnGuardarEventos.addEventListener('click', agregarEventosModal);
    btnModificarEventos.addEventListener('click', modificarEventosModal);
});

function getEventos() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/AdminIntra/get_eventos',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table-eventos",
                ['#', 'TITULO', 'EVENTO', 'FECHA INICIO', 'FECHA FIN', 'ESTADO', 'OPCIONES'
                ],
                ['ev_id', 'ev_titulo', 'ev_contenido', , 'ev_fechai', 'ev_fechaf',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.ev_estado == 1) {
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
                            <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ="show_mod_evento(${item.ev_id},'${item.ev_titulo}','${item.ev_contenido}','${item.ev_fechai}','${item.ev_fechaf}',${item.ev_tipo}, ${item.ev_estado}, '${item.ev_archivo}')"><i class="fa fa-edit tam-icono"></i></button>
                            <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_evento(${item.ev_id})"><i class="fa fa-trash tam-icono"></i></button>
                            `;
                        }
                    },
                ], response
            );

            $("#div-table-eventos").html(html);

            $("#table-eventos").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function agregarEventosModal() {
    if ($("#ip_titulo-modal_agregar_evento").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un Título",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($("#ip_contenido-modal_agregar_evento").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un Evento",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($("#ip_fini-modal_agregar_evento").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese la fecha de inicio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
        fec_in.focus();
    } else if ($("#ip_ffin-modal_agregar_evento").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese la fecha de caducidad",
            position: "right",
            autohide: false,
            zindex: 99999
        });
        fec_fi.focus();
    } else if ($("#select-tipo-modal_agregar_evento").val() == "S") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor seleccione un Tipo de Evento",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($("#txt-ruta-foto-modal_agregar_evento").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor debe subir una Imagen",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-evento-modal_agregar_evento").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");
        let titulo = document.getElementById('ip_titulo-modal_agregar_evento');
        let contenido = document.getElementById('ip_contenido-modal_agregar_evento');
        let fechaInicio = document.getElementById('ip_fini-modal_agregar_evento');
        let fechaFin = document.getElementById('ip_ffin-modal_agregar_evento');
        let tipo = document.getElementById('select-tipo-modal_agregar_evento');
        let estado = document.getElementById('chk_estado-modal_agregar_evento');
        let imagen = document.getElementById('txt-ruta-foto-modal_agregar_evento');

        let token = $("#csrf-token-modal_agregar_evento").val();
        let datos = new FormData($("#form_agregar_evento")[0]);
        datos.append('estado', estado.checked ? 1 : 0);

        $.ajax({
            url: '/AdminIntra/store_evento',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Evento Registrado",
                        type: "success",
                        zindex: 99999
                    });
                    titulo.value = "";
                    contenido.value = "";
                    fechaInicio.value = "";
                    fechaFin.value = "";
                    tipo.value = "S";
                    estado.checked = true;
                    estado.dispatchEvent(new Event('change'));
                    $("#modal_agregar_evento").modal('hide');
                    $("#btn-guardar-evento-modal_agregar_evento").html("<i class='fa fa-save'></i> Guardar");
                    getEventos();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido registrar el Evento",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-evento-modal_agregar_evento").html("<i class='fa fa-save'></i> Guardar");
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

//show_mod_evento(${item.ev_id},'${item.ev_titulo}','${item.ev_contenido}','${item.ev_fechai}','${item.ev_fechaf}',${item.ev_tipo}, ${item.ev_estado})
function show_mod_evento(id, titulo, contenido, fechaI, fechaF, tipo, estado, ruta) {
    let idE = document.getElementById('id-evento-modal_modificar_evento');
    let tituloE = document.getElementById('ip_titulo-modal_modificar_evento');
    let contenidoE = document.getElementById('ip_contenido-modal_modificar_evento');
    let fechaInicio = document.getElementById('ip_fini-modal_modificar_evento');
    let fechaFin = document.getElementById('ip_ffin-modal_modificar_evento');
    let tipoE = document.getElementById('select-tipo-modal_modificar_evento');
    let estadoE = document.getElementById('chk_estado-modal_modificar_evento');

    idE.value = id;
    tituloE.value = titulo;
    contenidoE.value = contenido;
    fechaInicio.value = fechaI;
    fechaFin.value = fechaF;
    tipoE.value = tipo;
    estadoE.checked = estado;

    estadoE.dispatchEvent(new Event('change'));

    let drEvent2 = $('#txt-ruta-foto-modal_modificar_evento').dropify();
    drEvent2 = drEvent2.data('dropify');
    drEvent2.resetPreview();
    drEvent2.clearElement();

    $("#modal_modificar_evento").modal("show");
    $('#div_imagen_cargada-modal_modificar_evento').fadeIn();
    $("#imagen_cargada-modal_modificar_evento").attr('src', `../${ruta}`);

}

function modificarEventosModal() {
    if ($("#ip_titulo-modal_modificar_evento").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un Título",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($("#ip_contenido-modal_modificar_evento").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un Evento",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($("#ip_fini-modal_modificar_evento").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese la fecha de inicio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
        fec_in.focus();
    } else if ($("#ip_ffin-modal_modificar_evento").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese la fecha de caducidad",
            position: "right",
            autohide: false,
            zindex: 99999
        });
        fec_fi.focus();
    } else if ($("#select-tipo-modal_modificar_evento").val() == "S") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor seleccione un Tipo de Evento",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-evento-modal_modificar_evento").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");
        let id = document.getElementById('id-evento-modal_modificar_evento');
        let titulo = document.getElementById('ip_titulo-modal_modificar_evento');
        let contenido = document.getElementById('ip_contenido-modal_modificar_evento');
        let fechaInicio = document.getElementById('ip_fini-modal_modificar_evento');
        let fechaFin = document.getElementById('ip_ffin-modal_modificar_evento');
        let tipo = document.getElementById('select-tipo-modal_modificar_evento');
        let estado = document.getElementById('chk_estado-modal_modificar_evento');
        let imagen = document.getElementById('txt-ruta-foto-modal_modificar_evento');

        let token = $("#csrf-token-modal_modificar_evento").val();
        let datos = new FormData($("#form_modificar_evento")[0]);
        datos.append('estado', estado.checked ? 1 : 0);

        $.ajax({
            url: `/AdminIntra/update/${id.value}`,
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Evento Modificado",
                        type: "success",
                        zindex: 99999
                    });
                    titulo.value = "";
                    contenido.value = "";
                    fechaInicio.value = "";
                    fechaFin.value = "";
                    tipo.value = "S";
                    estado.checked = true;
                    estado.dispatchEvent(new Event('change'));
                    $("#modal_modificar_evento").modal('hide');
                    $("#btn-guardar-evento-modal_modificar_evento").html("<i class='fa fa-save'></i> Guardar");
                    getEventos();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido modificar el Evento",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-evento-modal_modificar_evento").html("<i class='fa fa-save'></i> Guardar");
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

function show_delete_evento(id) {
    $('#txt-id-delete-evento').val(id);
    $("#modal_confirm_delete_evento").modal("show");
}

btnDeleteEventos.addEventListener('click', function () {
    let id = $('#txt-id-delete-evento').val();
    let token = $("#csrf-token-modal_confirm_delete_evento").val();
    $.ajax({
        url: `/AdminIntra/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Evento Eliminado",
                    type: "success",
                    zindex: 99999
                });
                $('#txt-id-delete-evento').val('');
                $("#modal_confirm_delete_evento").modal('hide');
                getEventos();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar el evento",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_evento").modal('hide');
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