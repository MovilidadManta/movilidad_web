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
            console.log(response.data)
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
                ht += '				<th align="center" class="border-bottom-0 color-th">archivo</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '			    <td align="center" class="color-td">' + data.sl_cedula + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.sl_nombres + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.sl_email + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.sl_descripcion + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.sl_telefono + '</td>'
                    ht += '			    <td class="color-td" align="center">'
                    ht += '			        <a href="/descargar-archivo-solicitud/' + data.sl_archivo + '"  id="' + data.sl_id + '"><i class="far fa-file-pdf tam-pdf"></i></a>'
                    ht += '             </td>'
                    ht += '				<td class="color-td" align="center">'
                    ht +=
                        '<button type="button" onclick="get_solicitud_lotaip_id(' + data.sl_id + ')" class="tam-btn btn btn-info"><i class="fa fa-bars tam-icono"></i></button>';
                    /*ht += '              <button type="button" id="' + data.sl_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.sl_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'*/
                    ht += '             </td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-solicitud-lotaip").html(ht)
                $("#table-solicitud-lotaip").DataTable()

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
function get_solicitud_lotaip_id(id_solicitud) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar noticia por id")

    $.ajax({
        url: '/get-solicitud-lotaip-id/' + id_solicitud,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {

                    $("#hidden-id-solicitud").val(data.sl_id)
                })


                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
            $("#modal-contestar-solicitud-lotaip").modal("show")
        }
    })
}
/*FIN PARA FUNCION CONSULTAR SOLICITUD DE LOTAIP POR ID*/

/*INICIO FUNCION PARA GUARDAR CONTESTACION DE SOLICITUD DE LOTAIP */
function guardar_contestacion_solicitud_lotaip() {
    $("#btn-guardar-contestacion-solicitud-lotaip").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Contestando....</span>")

    if ($("#txt-descripcion").val() == "") {
        Swal.fire("Alerta!", "Estimado por favor ingrese su respuesta", "error");
        $("#btn-guardar-contestacion-solicitud-lotaip").html("Enviar")
        $("#txt-nombre").focus();
    } else {
        let mensaje = $(".note-editable").html();
        $("#txt-respuesta").val(mensaje)
        var token = $("#csrf-token").val();
        var datos = new FormData($("#form-contestacion-solicitud-lotaip")[0]);
        $.ajax({
            url: '/registrar-contestacion-solicitud-lotaip',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                console.log(response.data)
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
                    var drEvent2 = $('#txt-file').dropify();
                    drEvent2 = drEvent2.data('dropify');
                    drEvent2.resetPreview();
                    drEvent2.clearElement();
                    $("#modal-contestar-solicitud-lotaip").modal('hide')
                    $("#btn-guardar-contestacion-solicitud-lotaip").html("Enviar")
                }
            }F
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
/*FIN FUNCION PARA GUARDAR CONTESTACION DE SOLICITUD DE LOTAIP */


function get_forma_recepcion_informacion(id) {
    console.log(id.value)
    if (id.value == 1) {

    } else if (id.value == 2) {
        $("#div-correo-archivo").removeClass('none')
        $("#div-correo-archivo").addClass('block')
        $("#div-correo-respuesta").removeClass('none')
        $("#div-correo-respuesta").addClass('block')
    }
}

function get_forma_recepcion_informacion(id) {
    console.log(id.value)
    if (id.value == 1) {

    } else if (id.value == 2) {
        $("#div-correo-archivo").removeClass('none')
        $("#div-correo-archivo").addClass('block')
        $("#div-correo-respuesta").removeClass('none')
        $("#div-correo-respuesta").addClass('block')
    }
}