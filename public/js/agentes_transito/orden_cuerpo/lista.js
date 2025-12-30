let btnAnadirRegistro = document.getElementById('btn_anadir_orden_cuerpo');
let btnDeleteOrdenCuerpo = document.getElementById('btn_delete_orden_cuerpo');
let iframe_view_document = document.getElementById('iframe_visor_orden_cuerpo');
let modalSendEmail = "#modal_confirm_send_email_orden_cuerpo";
let modalSendQr = "#modal_confirm_autorizacion_qr";
let btnConfirmSendEmail = document.getElementById('btn_confirm_send_email');
let btnCancelSendEmail = document.getElementById('btn_cancel_send_email');
let btnEstamparCodigo = document.getElementById('btn_estampar_codigo_modal_confirm_autorizacion_qr');
let codigoEstamparCodigo = document.getElementById('txt_autorizacion_modal_confirm_autorizacion_qr');
let id_table_orden_cuerpo = 'table_orden_cuerpo';
let idSendEmail = 0;

$(document).ready(function () {
    getListaOrdenCuerpo();
});

iframe_view_document.addEventListener('load', () => {
    iframe_view_document.style.display = "block";
});

btnAnadirRegistro.addEventListener('click', () => {
    window.location.replace('/orden_cuerpo/register');
});

function getListaOrdenCuerpo() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/orden_cuerpo/lista_orden_cuerpo',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml(id_table_orden_cuerpo,
                ['#', 'TITULO', 'FECHA', 'PDF', 'PROCESAR ORDEN', 'OPCIONES'],
                ['oc_id',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            datos = JSON.parse(item.oc_datos);
                            const title = datos.find(i => i.name === "title_document");
                            return `
                                <p>${title.text}</p>
                            `;
                        }
                    }
                    , 'oc_fecha',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `
                                <button type="button" onClick="view_orden_cuerpo_pdf(${item.oc_id})" class="tooltip"><span class="tooltiptext">Ver certificado</span> <i class="far fa-file-pdf tam-pdf"></i></button>
                            `;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let button = `<button type="button" onClick="send_email(${item.oc_id})" class="btn btn-primary tooltip"><span class="tooltiptext">Procesar Orden</span> <i class="fa fa-floppy-o icon_email"></i></button>`;
                            let pending_elemento = false;
                            if (item.total_emails != 0) {
                                pending_elemento = true;
                                button = `<i class="fa fa-spinner icon_process" aria-hidden="true"></i> Enviados ${item.total_emails_enviados} de ${item.total_emails}`;
                                if (item.total_emails_pendientes == 0) {
                                    pending_elemento = false;
                                    button = "<i class='fa fa-check-circle-o icon_success' aria-hidden='true'></i>";
                                }
                            }

                            let itemButton = `<span id='text_send_email_${item.oc_id}' data-oc_id="${item.oc_id}" data-pending="${pending_elemento}">
                                ${button}
                            </span>`;

                            return itemButton;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let buttons = `
                            <button type="button" class="btn btn-success btn-modal-agregar tooltip" Onclick ='duplicar_orden_cuerpo(${item.oc_id})'><span class="tooltiptext">Agregar a partir...</span><i class="fa fa-plus-square tam-icono icon_elevated"></i></button>
                            `;

                            if (item.total_emails == 0)
                                buttons += `
                                    <button type="button" class="btn btn-warning btn-modal-editar tooltip button_mod_${item.oc_id}" Onclick ='show_mod_orden_cuerpo(${item.oc_id})'><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
                                    <button type="button" class="btn btn-danger btn-modal-eliminar tooltip button_del_${item.oc_id}" Onclick ="show_delete_orden_cuerpo(${item.oc_id})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>
                            `;

                            return buttons;
                        }
                    },
                ], response
            );

            $("#div_table_orden_cuerpo").html(html);

            $(`#${id_table_orden_cuerpo}`).DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");

            let pendingSendEmails = document.getElementById(`${id_table_orden_cuerpo}`).querySelectorAll('span[data-pending="true"]');
            pendingSendEmails.forEach(p => {
                getStatusOC(p.dataset.oc_id, p);
            });
        }
    });
}

function send_email(id) {
    idSendEmail = id;
    $(modalSendEmail).modal("show");
}

function send_email_qr() {
    const formData = new FormData();
    let token = $("#csrf-token").val();
    $.ajax({
        url: '/orden_cuerpo/enviar_code_qr',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
            $(modalSendEmail).modal("hide");
            btnConfirmSendEmail.innerHTML = "<i class='fa fa-check'></i> Confirmar";
            btnConfirmSendEmail.disabled = false;
            $(modalSendQr).modal("show");
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        btnConfirmSendEmail.innerHTML("<i class='fa fa-check'></i> Confirmar");
        btnConfirmSendEmail.disabled = false;
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

btnEstamparCodigo.addEventListener('click', () => {
    btnEstamparCodigo.innerHTML = "<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Aprobando..</span>";
    btnEstamparCodigo.disabled = true;
    const formData = new FormData();
    formData.append('oc_id', idSendEmail);
    formData.append('codigo', codigoEstamparCodigo.value);
    let token = $("#csrf-token").val();
    $.ajax({
        url: '/orden_cuerpo/fimar_code_qr',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: formData,
        success: function (response) {
            btnEstamparCodigo.innerHTML = "Estampar código";
            btnEstamparCodigo.disabled = false;
            if (response.respuesta == false) {
                notif({
                    type: "warning",
                    msg: `<b>Aviso: </b> ${response.message}`,
                    position: "right",
                    autohide: true,
                    zindex: 99999
                });
            } else {
                notif({
                    type: "success",
                    msg: `Se ha aprobado la orden de cuerpo`,
                    position: "right",
                    autohide: true,
                    zindex: 99999
                });
                codigoEstamparCodigo.value = "";
                let table = document.getElementById(id_table_orden_cuerpo);
                let modButton = table.querySelector(`button.button_mod_${idSendEmail}`);
                let delButton = table.querySelector(`button.button_del_${idSendEmail}`);
                let spanProcess = table.querySelector(`#text_send_email_${idSendEmail}`);
                modButton.style.display = "none";
                delButton.style.display = "none";
                spanProcess.innerHTML = '<i class="fa fa-spinner icon_process" aria-hidden="true"></i>';
                getStatusOC(idSendEmail, spanProcess);
                $(modalSendQr).modal("hide");
            }
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        btnEstamparCodigo.innerHTML = "Estampar código";
        codigoEstamparCodigo.value = "";
        btnEstamparCodigo.disabled = false;
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

btnConfirmSendEmail.addEventListener('click', () => {
    btnConfirmSendEmail.innerHTML = "<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Generando código..</span>";
    btnConfirmSendEmail.disabled = true;
    send_email_qr();
});

function getStatusOC(id, element) {
    $.ajax({
        url: `/orden_cuerpo/lista_orden_cuerpo/${id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            register = response[0];

            if (register.total_emails_enviados == register.total_emails) {
                element.innerHTML = "<i class='fa fa-check-circle-o icon_success' aria-hidden='true'></i>";
            }
            else {
                element.innerHTML = `
                <i class= "fa fa-spinner icon_process" aria-hidden="true" ></i> Enviados ${register.total_emails_enviados} de ${register.total_emails}
                `;

                setTimeout(() => {
                    getStatusOC(id, element);
                }, 2000);
            }
        }
    });
}

btnCancelSendEmail.addEventListener('click', () => {
    idSendEmail = 0;
    $(modalSendEmail).modal("hide");
});

function view_orden_cuerpo_pdf(id) {
    iframe_view_document.style.display = "none";
    iframe_view_document.src = `/orden_cuerpo/show_pdf_orden_cuerpo/${id}`;
    $("#modal_view_pdf_orden_cuerpo").modal("show");
}

function duplicar_orden_cuerpo(id) {
    window.location.replace(`/orden_cuerpo/register/${id}/true`);
}

function show_mod_orden_cuerpo(id) {
    window.location.replace(`/orden_cuerpo/register/${id}`);
}

function show_delete_orden_cuerpo(id) {
    $('#txt_id_delete_orden_cuerpo').val(id);
    $("#modal_confirm_delete_orden_cuerpo").modal("show");
}

btnDeleteOrdenCuerpo.addEventListener('click', () => {
    let id = $('#txt_id_delete_orden_cuerpo').val();
    let token = $("#csrf-token").val();
    $.ajax({
        url: `/orden_cuerpo/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Orden de cuerpo Eliminada!",
                    type: "success",
                    zindex: 99999
                });
                $('#txt_id_delete_orden_cuerpo').val('');
                $("#modal_confirm_delete_orden_cuerpo").modal('hide');
                getListaOrdenCuerpo();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la orden de cuerpo",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_orden_cuerpo").modal('hide');
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