$(document).ready(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    get_contactanos()
})
//$("#global-loader").addClass("none");
//$("#global-loader").removeClass("block");

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE CONTACTANOS */
$("#btn-añadir-contactano").click(function () {
    $("#modal-contactano").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  CONTACTANOS */

/*INICIO DE FUNCION PARA LISTAR CONTACTANOS */
function get_contactanos() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar contactanos")
    $.ajax({
        url: '/get-contactano',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-contactano" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Id</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Nombres</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Correo</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Mensaje</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '			    <td align="center" class="color-td">' + data.cont_id + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.cont_nombre + ' ' + data.cont_apellido + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.cont_correo + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.cont_mensaje + '</td>'
                    ht += '				<td align="center" class="color-td" align="center">'
                    ht += '              <button type="button" id="'+data.cont_id+'" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="'+data.cont_id+'" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-contactano").html(ht)

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR NOSOTROS (CONTACTANOS) */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-contactano").val(this.id)
                    $("#modal-eliminar-contactano").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR NOSOTROS (CONTACTANOS)*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR NOSOTROS (CONTACTANOS)*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-modificar-contactano").val(this.id)
                    get_contactanos_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  NOSOTROS (CONTACTANOS)*/

            }
            $("#table-contactano").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR CONTACTANOS */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE CONTACTANOS */
$("#btn-guardar-contactano").click(function () {
    $("#btn-guardar-contactano").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Guardando..</span>")
    guardar_contactanos()
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE CONTACTANOS */

/*INICIO FUNCION PARA GUARDAR DE CONTACTANOS */
function guardar_contactanos() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-contactano")[0]);
    $.ajax({
        url: '/registrar-contactano',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Mensaje de Contacto registrado",
                    type: "success"
                });
                $("#txt-nombre").val("")
                $("#txt-apellido").val("")
                $("#txt-correo").val("")
                $("#txt-mensaje").val("")
                $("#modal-contactano").modal('hide')
                $("#btn-guardar-contactano").html("<i class='fa fa-save'></i> Guardar")
                get_contactanos()
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
/*FIN FUNCION PARA GUARDAR DE CONTACTANOS */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE CONTACTANOS */
$("#btn-eliminar-contactano").click(function () {
    $("#btn-eliminar-contactano").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Eliminando..</span>")
    eliminar_contactanos_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE CONTACTANOS*/

/*INICIO FUNCION DE ELIMINAR DE CONTACTANOS*/
function eliminar_contactanos_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-contactano")[0]);
    $.ajax({
        url: '/eliminar-contactano-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b>Mensaje eliminado",
                    type: "success"
                });
                $("#btn-eliminar-contactano").html("<i class='fa fa-times'></i> Eliminar")
                $("#modal-eliminar-contactano").modal('hide')
                get_contactanos()
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
/*FIN FUNCION DE ELIMINAR DE CONTACTANOS*/


/*INICIO PARA FUNCION CONSULTAR CONTACTANOS POR ID*/
function get_contactanos_id(id_contactano) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar contactanos por id")
    
    $.ajax({
        url: '/get-contactano-id/' + id_contactano,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#txt-nombre-m").val(data.cont_nombre)
                    $("#txt-apellido-m").val(data.cont_apellido)
                    $("#txt-correo-m").val(data.cont_correo)
                    $("#txt-mensaje-m").val(data.cont_apellido)
                })
                $("#modal-modificar-contactano").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR CONTACTANOS POR ID*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DE CONTACTANOS */
$("#btn-modificar-contactano").click(function(){
    $("#btn-modificar-contactano").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Modificando..</span>")
    modificar_contactanos()
})
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DE CONTACTANOS */

/*INICIO DE FUNCION PARA MODIFICAR DE CONTACTANOS  POR ID */
function modificar_contactanos() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-contactano-m")[0]);
    $.ajax({
        url: '/modificar-contactano',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
           if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Mensaje modificados",
                    type: "success"
                });
                $("#btn-modificar-contactano").html("<i class='fa fa-edit'></i> Modificar")
                $("#txt-nombre-m").val("")
                $("#txt-apellido-m").val("")
                $("#txt-correo-m").val("")
                $("#txt-mensaje-m").val("")
                $("#modal-modificar-contactano").modal('hide')
                get_contactanos()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar mensaje",
                    position: "right",
                    autohide: false
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
/*FIN DE FUNCION PARA MODIFICAR DE CONTACTANOS  POR ID */




