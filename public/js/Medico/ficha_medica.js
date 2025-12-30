$(document).ready(function () {
    getCertificadosMedicos();
    $('.dropify').dropify();
});

let iframe_view_document = document.getElementById('iframe_visor_certificado');
let iframe_aprove_document = document.getElementById('frame-certificado-medico');
let file_name_, file_type_, file_size_, fileURL_;
function getCertificadosMedicos() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/get-list-certificados-medicos',
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-certificados-medicos" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Foto</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Cedula</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Funcionario</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Cargo</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Fecha Recepción</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Causa</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Diagnóstico</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Días de reposo</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Observación</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Archivo</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody class="tam-em">'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    if (data.emp_estado_ruta_foto == true) {
                        ht += '				<td class="color-td" align="center"><img class="tam-ima-emp-ta" src="/imagenes_empleados/' + data.emp_ruta_foto + '"></td>'
                    } else {
                        ht += '				<td class="color-td" align="center"><img class="tam-ima-emp-ta" src="https://ui-avatars.com/api/?name=' + data.emp_nombre + ' ' + data.emp_apellido + '&background=0D8ABC&color=fff"></td>'
                    }
                    ht += '			    <td class="color-td" align="center">' + data.emp_cedula + '</td>'
                    ht += '				<td class="color-td" align="center">' + data.emp_apellido + ' ' + data.emp_nombre + '</td>'
                    ht += '				<td class="color-td" align="center">' + data.emp_cargo + '</td>'
                    ht += '				<td class="color-td" align="center">' + data.fm_fecha_recepcion + '</td>'
                    ht += '				<td class="color-td" align="center">' + data.cm_descripcion + '</td>'
                    ht += '				<td class="color-td" align="center">' + data.dm_descripcion + '</td>'
                    ht += '				<td class="color-td" align="center">' + (data.fm_tipo_certificado != 3 ? data.fm_dias_certificado : 'NO') + '</td>'
                    ht += '				<td class="color-td" align="center">' + data.fm_observacion + '</td>'
                    ht += '			    <td class="color-td" align="center">'
                    ht += '			        <button type="button" onClick="view_certificado_pdf(' + data.fm_id + ')" class="tooltip"><span class="tooltiptext">Ver certificado</span> <i class="far fa-file-pdf tam-pdf"></i></a>'
                    ht += '             </td>'
                    ht += '				<td class="color-td" align="center">'
                    ht += '                 <a href="/modificar_ficha_medica/' + data.fm_id + '" alt="Editar" class="tooltip"><span class="tooltiptext">Editar Certificado</span><button type="button" id="editar_certificado_' + data.fm_id + '" data-id="' + data.fm_id + '" class="tam-btn btn btn-warning"><i class="fa fa-edit tam-icono"></i></button></a>'
                    if (data.fm_tipo_certificado != 3) {
                        ht += '                 <button type="button" onClick="modal_aprobar_certificado_medico(' + data.fm_id + ', ' + data.aprobado + ',`' + data.fm_archivo_generado_aprobacion + '`,`' + data.fm_archivo_original_aprobacion + '`)" class="btn ' + (data.aprobado ? 'btn-info' : 'btn-success') + ' tam-btn"><div class="tooltip"><span class="tooltiptext">Aprobar Certificado</span><i class="' + (data.aprobado ? 'fa fa-eye' : 'fa fa-check-square-o') + ' tam-icono"></i></div></button>'
                    }
                    ht += '				</td>'
                    ht += '			</tr>'

                });
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-ficha").html(ht);
            }
            $("#table-certificados-medicos").DataTable();
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function view_certificado_pdf(id) {
    iframe_view_document.style.display = "none";
    iframe_view_document.src = `/show_certificado_medico/${id}`;
    $("#modal_view_pdf_certificado").modal("show");
}

function modal_aprobar_certificado_medico(id, aprobado, archivo_generado, archivo_original) {
    $('#hidden-id-ficha-medica').val(id);
    $('.form_ficha_medica_save').fadeIn();
    iframe_aprove_document.style.display = "none";
    if (!aprobado) {
        iframe_aprove_document.src = `/show_certificado_medico/${id}/0`;
    } else {
        $('.form_ficha_medica_save').fadeOut();
        iframe_aprove_document.src = `/archivos_aprobacion_certificados_medicos/${archivo_generado}`;
    }
    let inputArchivo = document.getElementById('txt-file-certificado');
    inputArchivo.value = "";
    inputArchivo.dispatchEvent(new Event("change"));
    $("#modal-aprobar-certificado-medico").modal("show");
}

$("#btn-añadir-ficha").click(function () {
    location.href = "/registrar_ficha_medica";
});

iframe_view_document.addEventListener('load', () => {
    iframe_view_document.style.display = "block";
});

iframe_aprove_document.addEventListener('load', () => {
    iframe_aprove_document.style.display = "block";
});

function guardar_aprobacion_certificado_medico() {
    if ($("#txt-file-certificado").val() == "") {
        Swal.fire("Alerta!", "Estimado por favor cargue un archivo adjunto", "error");
        $("#btn-guardar-contestacion-solicitud-lotaip-fisico").html('<i class="fa fa-save"></i> Aprobar');
    } else {
        $("#modal_confirmacion_aprobar_certificado").modal("show");
    }
}


$("#btn_confirm_generate_certificate").click(function () {
    $("#modal_confirmacion_aprobar_certificado").modal("hide");
    $("#btn-guardar-aprobacion-certificado-medico").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Guardando....</span>");

    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-aprobar-certificado-medico")[0]);
    $.ajax({
        url: '/aprobar-certificado-medico',
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
                    'Certificado aprobado correctamente',
                    'success'
                )
                /*notif({
                    msg: "<b>Correcto:</b> Mision y Vision registrado",
                    type: "success"
                });*/
                if (response.ficha.enviar_certificado) {
                    enviar_peticion_permiso_medico(response.url_permiso_medico, response.ficha, response.tipo_permiso);
                }
                getCertificadosMedicos()
                var drEvent2 = $('#txt-file-certificado').dropify();
                drEvent2 = drEvent2.data('dropify');
                drEvent2.resetPreview();
                drEvent2.clearElement();
                $("#modal-aprobar-certificado-medico").modal('hide');
                $("#btn-guardar-aprobacion-certificado-medico").html('<i class="fa fa-save"></i> Aprobar');
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


$("#btn_cancelar_generate_certificate").click(function () {
    $("#btn-guardar-aprobacion-certificado-medico").html('<i class="fa fa-save"></i> Aprobar');
});

$("#txt-file-certificado").on("change", function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        file_name_ = file.name;
        file_type_ = file.type;
        file_size_ = file.size;
        reader.onloadend = () => {
            fileURL_ = reader.result;
            console.log(fileURL_);
        };
        reader.readAsDataURL(file);
    }
});

function enviar_peticion_permiso_medico(url, ficha, tipoPermiso) {
    var datos = new FormData();

    let str = ficha.fm_fecha_recepcion;
    const [year, month, day] = str.split('-');

    str = ficha.fm_fecha_inicio_certificado;
    const [yearInicio, monthInicio, dayInicio] = str.split('-');

    str = ficha.fm_tipo_certificado == 2 ? ficha.fm_hora_inicio_certificado : '00:00:00';
    const [hourInicio, minuteInicio, secondInicio] = str.split(':');

    str = ficha.fm_fecha_fin_certificado;
    const [yearFin, monthFin, dayFin] = str.split('-');

    str = ficha.fm_tipo_certificado == 2 ? ficha.fm_hora_fin_certificado : '00:00:00';
    const [hourFin, minuteFin, secondFin] = str.split(':');

    const dateInicio = new Date(Number(yearInicio), Number(monthInicio) - 1, Number(dayInicio), Number(hourInicio), Number(minuteInicio), Number(secondInicio));
    const dateFin = new Date(Number(yearFin), Number(monthFin) - 1, Number(dayFin), Number(hourFin), Number(minuteFin), Number(secondFin));
    const horasDia = dateFin.getTime() - dateInicio.getTime();
    const horasMin = horasDia / (1000 * 60);
    let horasString = horasMin % 60 == 0 ? `${horasMin / 60} horas` : `${(horasMin - (horasMin % 60)) / 60} horas y ${horasMin % 60} minutos`;

    datos.append("cedula_solicitante", ficha.emp_cedula);
    datos.append("sel_tipo_permiso", tipoPermiso.id);
    datos.append("desde", ficha.fm_fecha_inicio_certificado);
    datos.append("hasta", ficha.fm_fecha_fin_certificado);
    datos.append("hora_inicial", ficha.fm_tipo_certificado == 2 ? ficha.fm_hora_inicio_certificado : '00:00');
    datos.append("hora_final", ficha.fm_tipo_certificado == 2 ? ficha.fm_hora_fin_certificado : '00:00');
    datos.append("observacion", `${ficha.dm_cie10 ? `[${ficha.dm_cie10}] ` : ''} ${ficha.dm_descripcion}`);
    datos.append("diasDeDiferencia", ficha.fm_tipo_certificado == 1 ? ficha.fm_dias_certificado : 0);
    datos.append("total_horas", ficha.fm_tipo_certificado == 1 ? `${ficha.fm_dias_certificado} días` : horasString);
    datos.append("tipo_enfermedad", ficha.cm_descripcion);
    datos.append("estado_documento", tipoPermiso.estado_documento);
    datos.append("file_name_", file_name_);
    datos.append("fileURL_", fileURL_);
    datos.append("file_type_", file_type_);
    datos.append("file_size_", file_size_);
    datos.append("tipo_solicitud", tipoPermiso.id);
    datos.append("fecha_inicial", ficha.fm_fecha_inicio_certificado);
    datos.append("fecha_final", ficha.fm_fecha_fin_certificado);
    datos.append("fecha_solicitud", `${day}/${month}/${year}`);
    datos.append("estado", 'INGRESADO');
    datos.append("fm_id", ficha.fm_id);
    datos.append("dm_id", ficha.dm_id);
    datos.append("select_entidad_certifica", 0);

    $("#table-responsive_charge").show();
    $("#table-responsive").hide();

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            $("#table-responsive_charge").hide();
            $("#table-responsive").show();
            if (response.respuesta == true) {
                notif({
                    type: "success",
                    msg: "<b>Aviso: </b>Se envio con éxito el permiso al empleado",
                    position: "right",
                    autohide: true,
                    zindex: 99999
                });
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>Ocurrio un error al enviar la peticion para el permiso: " + response.sms,
                    position: "right",
                    autohide: true,
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