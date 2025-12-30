$(document).ready(function () {
    $('.dropify').dropify();
    get_solicitudes_lotaips();
});

/*INICIO DE FUNCION PARA LISTAR SOLICITUDES DE LOTAIP */
/*INICIO DE FUNCION PARA LISTAR SOLICITUDES DE LOTAIP */
function get_solicitudes_lotaips() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/get-solicitud-lotaip',
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-solicitud-lotaip" border="2" class="table display">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Cedula</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Nombres</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">email</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">mensaje</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Télefono</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Estado</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">archivo</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '			    <td align="center" class="color-td">' + data.sl_cedula + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.sl_nombres + ' ' + data.sl_apellidos + '</td>'
                    ht += `			    <td align="center" class="color-td">${data.sl_email.trim() == "" ? 'Retiro de la información en la institución' : data.sl_email}</td>`
                    ht += '			    <td align="center" class="color-td">' + data.sl_descripcion + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.sl_telefono + '</td>'
                    ht += `			    <td align="center" class="color-td">${data.contestado == 1 ? '<span class="badge bg-success">Contestado</span>' : '<span class="badge bg-secondary">No contestado</span>'}</td>`
                    ht += '			    <td class="color-td" align="center">'
                    ht += '			        <a href="/descargar-archivo-solicitud/' + data.sl_archivo + '"  id="' + data.sl_id + '"><i class="far fa-file-pdf tam-pdf"></i></a>'
                    ht += '             </td>'
                    ht += '				<td class="color-td" align="center">'
                    ht +=
                        `
                        <button type="button" onclick="${data.sl_forma_recepcion == 1 ? 'get_solicitud_lotaip_fisico_id(' + data.sl_id + ')' : 'get_solicitud_lotaip_email_id(' + data.sl_id + ')'}" class="tam-btn btn ${data.sl_forma_recepcion == 1 ? 'btn-danger' : 'btn-success'}" ${data.contestado == 1 ? 'style="display:none;"' : ''} title="${data.sl_forma_recepcion == 1 ? 'Ver/Responder comprobante' : 'Enviar Correo'}"><i class="fa ${data.sl_forma_recepcion == 1 ? 'fa-file-pdf-o' : 'fa-envelope-o'} tam-icono"></i></button>
                        <button type="button" onclick="${data.sl_forma_recepcion == 1 ? 'get_respuesta_lotaip_fisico_id(' + data.sl_id + ')' : 'get_respuesta_lotaip_email_id(' + data.sl_id + ')'}" class="tam-btn btn btn-info" ${data.contestado == 0 ? 'style="display:none;"' : ''} title="Ver respuesta"><i class="fa fa-eye tam-icono"></i></button>
                        `;
                    /*ht += '              <button type="button" id="' + data.sl_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.sl_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'*/
                    ht += '             </td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-solicitud-lotaip").html(ht)
                $("#table-solicitud-lotaip").DataTable({
                    "aaSorting": []
                })

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR LOTAIP POR ID */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-lotaip").val(this.id)
                    $("#modal-eliminar-lotaip").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR LOTAIP POR ID*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR LOTAIP POR ID*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-lotaip-m").val(this.id)
                    get_lotaip_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  LOTAIP POR ID*/

            }
            $("#table-solicitud-lotaip").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR SOLICITUDES DE LOTAIP */



/*INICIO PARA FUNCION CONSULTAR SOLICITUD DE LOTAIP POR ID*/
function get_solicitud_lotaip_email_id(id_solicitud) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $('.form_lotaip_fisico_save').fadeIn();
    $('.note-editor').fadeIn();
    $('.form_lotaip_fisico_show').fadeOut();
    $('#email_text_send-email').html('El email se enviara al siguiente correo:');
    $.ajax({
        url: '/get-solicitud-lotaip-id/' + id_solicitud,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {

                    $("#hidden-id-solicitud").val(data.sl_id)
                    $("#correo_mostrar_email").html(data.sl_email)
                    $("#hidden-email-solicitud").val(data.sl_email)
                    $("#hidden-numero-solicitud").val(data.sl_numero_solicitud)
                    $("#tbody_files_email").html(`<tr>
                                                        <td class="color-td" align="center" colspan="3">No existen archivos cargados</td>
                                                    </tr>`);
                })


                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
            $("#modal-contestar-solicitud-lotaip-email").modal("show")
        }
    })
}

function get_respuesta_lotaip_email_id(id_solicitud) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $('.form_lotaip_fisico_save').fadeOut();
    $('.note-editor').fadeOut();
    $('.form_lotaip_fisico_show').fadeIn();
    $('#email_text_send-email').html('El email se envió al siguiente correo:');
    $.ajax({
        url: '/get-solicitud-lotaip-id/' + id_solicitud,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {

                    let body = document.getElementById('tbody_files_email');
                    body.innerHTML = '';
                    data.archivos_adjuntos.map((f) => {
                        body.innerHTML += `
                        <tr>
                            <td class="color-td" align="center">${f.ar_archivo_original}</td>
                            <td class="color-td" align="center">
                                ${f.ar_descripcion_archivo}
                            </td>
                            <td class="color-td" align="center">
                                <a href="/archivos_contestacion_solicitudes_lotaip/${f.ar_archivo_generado}" target="_blank" download="${f.ar_archivo_original}">
                                    <button type="button" class="btn btn-success" style="width:32px; padding: 5px;"><i class="fa fa-download" aria-hidden="true"></i></button>
                                </a>
                            </td>
                        </tr>
                        `;
                    });

                    $("#hidden-id-solicitud").val(data.sl_id)
                    $("#correo_mostrar_email").html(data.sl_email)
                    $("#hidden-email-solicitud").val(data.sl_email)
                    $("#hidden-numero-solicitud").val(data.sl_numero_solicitud)
                    $("#txt-respuesta-email-show").val(data.csl_respuesta)
                })


                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
            $("#modal-contestar-solicitud-lotaip-email").modal("show")
        }
    })
}

function get_solicitud_lotaip_fisico_id(id_solicitud) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $('#frame-recibido-lotaip').attr('src', '');
    $('.form_lotaip_fisico_save').fadeIn();
    $.ajax({
        url: '/get-solicitud-lotaip-id/' + id_solicitud,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {

                    $("#hidden-id-solicitud-fisico").val(data.sl_id);
                    $("#txt-respuesta-fisico").val('');
                    $('#txt-respuesta-fisico').attr('readonly', false);
                    $("#text_respuesta_archivo_fisico").html("Archivo de recibo");
                    $('#frame-recibido-lotaip').attr('src', `/ver-entrega-informacion-publica/${data.sl_id}`);
                })


                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
            $("#modal-contestar-solicitud-lotaip-fisico").modal("show")
        }
    })
}

function get_respuesta_lotaip_fisico_id(id_solicitud) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $('#frame-recibido-lotaip').attr('src', '');
    $('.form_lotaip_fisico_save').fadeOut();
    $.ajax({
        url: '/get-solicitud-lotaip-id/' + id_solicitud,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {

                    $("#hidden-id-solicitud-fisico").val(data.sl_id)
                    $("#txt-respuesta-fisico").val(data.csl_respuesta);
                    $('#txt-respuesta-fisico').attr('readonly', true);
                    $("#text_respuesta_archivo_fisico").html("Archivo");
                    $('#frame-recibido-lotaip').attr('src', `/archivos_contestacion_solicitudes_lotaip/${data.csl_archivo}`);
                })


                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
            $("#modal-contestar-solicitud-lotaip-fisico").modal("show")
        }
    })
}
/*FIN PARA FUNCION CONSULTAR SOLICITUD DE LOTAIP POR ID*/

/*INICIO FUNCION PARA GUARDAR CONTESTACION DE SOLICITUD DE LOTAIP */
function guardar_contestacion_solicitud_lotaip_email() {
    reordenarFilasArchivos();
    $("#btn-guardar-contestacion-solicitud-lotaip-email").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Contestando....</span>")
    const filesLength = document.querySelectorAll('#tbody_files_email input[type="file"][id^="txt-file-email-"]').length;

    if ($(".note-editable").html().trim() == "") {
        Swal.fire("Alerta!", "Estimado por favor ingrese su respuesta", "error");
        $("#btn-guardar-contestacion-solicitud-lotaip-email").html("<i class='fa fa-save'></i> Enviar");
    } else if (filesLength == 0) {
        Swal.fire("Alerta!", "Por favor agregue al menos un archivo para adjuntar a la respuesta", "error");
        $("#btn-guardar-contestacion-solicitud-lotaip-email").html("<i class='fa fa-save'></i> Enviar")
    } else {
        let mensaje = $(".note-editable").html();
        $("#txt-respuesta").val(mensaje)
        var token = $("#csrf-token").val();
        var datos = new FormData($("#form-contestacion-solicitud-lotaip-email")[0]);
        $.ajax({
            url: '/registrar-contestacion-solicitud-lotaip-email',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    Swal.fire(
                        'Correcto!',
                        'Respuesta de solicitud enviada correctamente',
                        'success'
                    )
                    /*notif({
                        msg: "<b>Correcto:</b> Mision y Vision registrado",
                        type: "success"
                    });*/
                    $("#txt-respuesta").val("")
                    $(".note-editable").html("");
                    /*var drEvent2 = $('#txt-file').dropify();
                    drEvent2 = drEvent2.data('dropify');
                    drEvent2.resetPreview();
                    drEvent2.clearElement();*/
                    $("#modal-contestar-solicitud-lotaip-email").modal('hide');
                    $("#btn-guardar-contestacion-solicitud-lotaip-email").html("<i class='fa fa-save'></i> Enviar");
                }
                get_solicitudes_lotaips();
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
            $("#txt-respuesta").val("");
            $(".note-editable").html("");
            $("#modal-contestar-solicitud-lotaip-email").modal('hide');
            $("#btn-guardar-contestacion-solicitud-lotaip-email").html("<i class='fa fa-save'></i> Enviar");
            Swal.fire("Alerta!", "No se pudo enviar la respuesta, por favor contacte a soporte", "error");
            get_solicitudes_lotaips();
        });
    }
}
/*FIN FUNCION PARA GUARDAR CONTESTACION DE SOLICITUD DE LOTAIP */


function guardar_contestacion_solicitud_lotaip_fisico() {
    $("#btn-guardar-contestacion-solicitud-lotaip-fisico").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Contestando....</span>");

    if ($("#txt-descripcion-fisico").val() == "") {
        Swal.fire("Alerta!", "Estimado por favor ingrese su respuesta", "error");
        $("#btn-guardar-contestacion-solicitud-lotaip-fisico").html("<i class='fa fa-save'></i> Enviar")
    } else if ($("#txt-file-fisico").val() == "") {
        Swal.fire("Alerta!", "Estimado por favor cargue un archivo adjunto", "error");
        $("#btn-guardar-contestacion-solicitud-lotaip-fisico").html("<i class='fa fa-save'></i> Enviar")
    } else {
        var token = $("#csrf-token").val();
        var datos = new FormData($("#form-contestacion-solicitud-lotaip-fisico")[0]);
        $.ajax({
            url: '/registrar-contestacion-solicitud-lotaip-fisico',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    Swal.fire(
                        'Correcto!',
                        'Respuesta de solicitud enviada correctamente',
                        'success'
                    )
                    /*notif({
                        msg: "<b>Correcto:</b> Mision y Vision registrado",
                        type: "success"
                    });*/
                    get_solicitudes_lotaips()
                    $("#txt-respuesta-fisico").val("")
                    $(".note-editable").html("");
                    var drEvent2 = $('#txt-file-fisico').dropify();
                    drEvent2 = drEvent2.data('dropify');
                    drEvent2.resetPreview();
                    drEvent2.clearElement();
                    $("#modal-contestar-solicitud-lotaip-fisico").modal('hide')
                    $("#btn-guardar-contestacion-solicitud-lotaip-fisico").html("Enviar")
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



$('#btn_add_file_email').click(function () {
    reordenarFilasArchivos();
    const files = document.querySelectorAll('#tbody_files_email input[type="file"][id^="txt-file-email-"]').length;
    let body = document.getElementById('tbody_files_email');
    const idNew = files + 1;
    let inputFile = document.createElement('input');
    inputFile.type = 'file';
    inputFile.name = `txt-file-email-${idNew}`;
    inputFile.id = `txt-file-email-${idNew}`;
    inputFile.style.display = 'none';


    inputFile.addEventListener('change', (e) => {

        let tr = document.createElement('tr');
        tr.id = `fila-enviar-email-${idNew}`;

        tr.innerHTML = `
                <td class="color-td" align="center">${inputFile.files[0].name}</td>
                <td class="color-td" align="center">
                    <input type="text" class="form-label" id="txt-descripcion-archivo-email-${idNew}" name="txt-descripcion-archivo-email-${idNew}" style="padding:10px;font-size: 14px;" placeholder="Ingresar una descripcion">
                </td>
                <td class="color-td" align="center">
                    <button type="button" class="btn btn-danger" id="delete-row-email-${idNew}" data-id="${idNew}" style="width:32px; padding: 5px;"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </td>
        `;

        if (files == 0)
            body.innerHTML = '';

        body.appendChild(tr);

        let filaAdd = document.getElementById(`fila-enviar-email-${idNew}`);
        let buttonsfilaDelete = document.querySelectorAll('#tbody_files_email button[id^="delete-row-email-"]');
        filaAdd.appendChild(inputFile);


        buttonsfilaDelete.forEach((f) => {
            f.addEventListener('click', (e) => {
                let filaDelete = document.getElementById(`fila-enviar-email-${f.dataset.id}`);
                let inputDelete = document.getElementById(`txt-file-email-${f.dataset.id}`);
                filaDelete.remove();
                inputDelete.remove();
                verificarFilasEmpty();
            });
        });

    });

    inputFile.click();
});

function verificarFilasEmpty() {
    const files = document.querySelectorAll('#tbody_files_email input[type="file"][id^="txt-file-email-"]').length;
    let body = document.getElementById('tbody_files_email');
    if (files == 0)
        body.innerHTML = `
            <tr>
                <td class="color-td" align="center" colspan="3">No existen archivos cargados</td>
            </tr>
        `;
}

function reordenarFilasArchivos() {
    const filas = document.querySelectorAll('#tbody_files_email tr[id^="fila-enviar-email-"]');
    const inputsDescripcionFilas = document.querySelectorAll('#tbody_files_email input[id^="txt-descripcion-archivo-email-"]');
    const inputsFileFilas = document.querySelectorAll('#tbody_files_email input[id^="txt-file-email-"]');
    const buttonsDeleteFilas = document.querySelectorAll('#tbody_files_email button[id^="delete-row-email-"]');
    let count = 1;

    filas.forEach((f) => {
        f.id = `fila-enviar-email-${count++}`;
    });

    count = 1;

    inputsDescripcionFilas.forEach((f) => {
        f.id = `txt-descripcion-archivo-email-${count}`;
        f.name = `txt-descripcion-archivo-email-${count++}`;
    });

    count = 1;

    buttonsDeleteFilas.forEach((f) => {
        f.id = `delete-row-email-${count}`;
        f.dataset.id = `${count++}`;
    });

    count = 1;

    inputsFileFilas.forEach((f) => {
        f.id = `txt-file-email-${count}`;
        f.name = `txt-file-email-${count++}`;
    });
}
