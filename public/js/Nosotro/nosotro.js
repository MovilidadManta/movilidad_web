$(document).ready(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    get_nosotros()
})
//$("#global-loader").addClass("none");
//$("#global-loader").removeClass("block");

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE MISION Y VISION */
$("#btn-añadir-nosotro").click(function () {
    $("#modal-nosotro").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  MISION Y VISION */

/*INICIO DE FUNCION PARA LISTAR MISION Y VISION */
function get_nosotros() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar nosotros")
    $.ajax({
        url: '/get-nosotro',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-nosotro" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Misión</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Visión</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '			    <td class="color-td">' + data.nos_mision + '</td>'
                    ht += '				<td class="color-td">' + data.nos_vision + '</td>'
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" id="'+data.nos_id+'" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="'+data.nos_id+'" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-nosotro").html(ht)

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR NOSOTROS (MISION Y VISION) */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-nosotro").val(this.id)
                    $("#modal-eliminar-nosotro").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR NOSOTROS (MISION Y VISION)*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR NOSOTROS (MISION Y VISION)*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-modificar-nosotro").val(this.id)
                    get_nosotros_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  NOSOTROS (MISION Y VISION)*/

            }
            $("#table-nosotro").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR MISION Y VISION */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE NOSOTROS(MISION Y VISION) */
$("#btn-guardar-nosotro").click(function () {
    guardar_nosotros()
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE NOSOTROS(MISION Y VISION) */

/*INICIO FUNCION PARA GUARDAR DE NOSOTROS(MISION Y VISION) */
function guardar_nosotros() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-nosotro")[0]);
    $.ajax({
        url: '/registrar-nosotro',
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
                    msg: "<b>Correcto:</b> Mision y Vision registrado",
                    type: "success"
                });
                $("#txt-mision").val("")
                $("#txt-vision").val("")
                $("#modal-nosotro").modal('hide')
                get_nosotros()
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
/*FIN FUNCION PARA GUARDAR DE NOSOTROS(MISION Y VISION) */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE NOSOTROS(MISION Y VISION) */
$("#btn-eliminar-nosotro").click(function () {
    eliminar_nosotros_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE NOSOTROS(MISION Y VISION)*/

/*INICIO FUNCION DE ELIMINAR DE NOSOTROS(MISION Y VISION)*/
function eliminar_nosotros_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-nosotro")[0]);
    $.ajax({
        url: '/eliminar-nosotro-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Mision y Vision eliminado",
                    type: "success"
                });
                $("#modal-eliminar-nosotro").modal('hide')
                get_nosotros()
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
/*FIN FUNCION DE ELIMINAR DE NOSOTROS(MISION Y VISION)*/


/*INICIO PARA FUNCION CONSULTAR EMPLEADO POR ID*/
function get_nosotros_id(id_nosotro) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar nosotros por id")
    
    $.ajax({
        url: '/get-nosotro-id/' + id_nosotro,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#txt-m-mision").val(data.nos_mision)
                    $("#txt-m-vision").val(data.nos_vision)
                })
                $("#modal-modificar-nosotro").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR EMPLEADO POR ID*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DE NOSOTROS(MISION Y VISION) */
$("#btn-modificar-nosotro").click(function(){
    modificar_nosotros()
})
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DE NOSOTROS(MISION Y VISION) */

/*INICIO DE FUNCION PARA MODIFICAR DE NOSOTROS(MISION Y VISION)  POR ID */
function modificar_nosotros() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-m-nosotro")[0]);
    $.ajax({
        url: '/modificar-nosotro',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
           if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Mision y Vision modificados",
                    type: "success"
                });
                $("#txt-m-mision").val("")
                $("#txt-m-vision").val("")
                $("#modal-modificar-nosotro").modal('hide')
                get_nosotros()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar nosotros",
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
/*FIN DE FUNCION PARA MODIFICAR DE NOSOTROS(MISION Y VISION)  POR ID */




