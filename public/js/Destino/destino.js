$(document).ready(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $('.dropify').dropify();
    get_destino()
})
//$("#global-loader").addClass("none");
//$("#global-loader").removeClass("block");

/*INICIO DE FUNCION PARA LISTAR LAS COOPERATIVAS*/
function get_cooperativa_select() {
    $("#select-cooperativa").html("<option value='0'>Cargando Cooperativas..</option>")
    $.ajax({
        url: '/get-cooperativa',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE COOPERATIVA</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.co_id + '>' + data.co_nombre + '</option>'
                })
                $("#select-cooperativa").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS COOPERATIVAS*/

/*INICIO DE FUNCION PARA LISTAR LAS COOPERATIVAS A MODIFICAR*/
function get_cooperativa_select_m() {
    $("#select-cooperativa").html("<option value='0'>Cargando Cooperativas..</option>")
    $.ajax({
        url: '/get-cooperativa',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Cooperativa</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.co_id + '>' + data.co_nombre + '</option>'
                })
                $("#select-cooperativa-m").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS COOPERATIVAS A MODIFICAR*/

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE ANADIR DESTINO */
$("#btn-añadir-destino").click(function () {
    $("#modal-destino").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  ANADIR DESTINO */

/*INICIO DE FUNCION PARA LISTAR DESTINOS */
function get_destino() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar destinos")
    $.ajax({
        url: '/get-destino',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-destino" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Destino</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Latitud</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Longitud</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">estado</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '				<td align="center" class="color-td">Manta - ' + data.de_destino + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.de_latitud + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.de_longitud + '</td>'
                    if (data.de_estado == 'A') {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-success me-1">Activo</span></td>'
                    } else if (data.de_estado == 'I') {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-danger me-1">Inactivo</span></td>'
                    }
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" id="' + data.de_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.de_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-destino").html(ht)

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR DESTINOS */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-destino").val(this.id)
                    $("#modal-destino-e").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR DESTINOS*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR DESTINOS*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-destino-m").val(this.id)
                    get_cooperativa_select_m()
                    get_destinos_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  DESTINOS*/

            }
            $("#table-destino").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR DESTINOS */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE DESTINO */
$("#btn-guardar-destino").click(function () {
    if (
        $('#txt-destino').val() == '' &&
        $('#txt-latitud').val() == '' &&
        $('#txt-longitud').val() == '' &&
        $('#txt-observacion').val() == '' &&
        $('#select-estado').val() == '0'
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-destino').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo destino esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-latitud').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo latitud esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-longitud').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo longitud esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($('#select-estado').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo estado no esta seleccionado",
            position: "right",
            autohide: false
        });
    }else if ($('#txt-observacion').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo observación esta vacio",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-guardar-destino").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
        guardar_destinos()
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE DESTINOS */

/*INICIO FUNCION PARA GUARDAR DE DESTINOS */
function guardar_destinos() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-destino")[0]);
    $.ajax({
        url: '/registrar-destino',
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
                    msg: "<b>Correcto:</b> Destino registrada",
                    type: "success"
                });
                $('#txt-destino').val('')
                $('#txt-latitud').val('')
                $('#txt-longitud').val('')
                $('#txt-observacion').val('')
                $('#select-estado').val('0')
                $("#modal-destino").modal('hide')
                $("#btn-guardar-destino").html("<i class='fa fa-save'></i> Guardar")
                get_destino()
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
/*FIN FUNCION PARA GUARDAR DE DESTINOS */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE DESTINOS */
$("#btn-eliminar-destino").click(function () {
    $("#btn-eliminar-destino").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Eliminando..</span>")
    eliminar_destinos_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE DESTINOS*/

/*INICIO FUNCION DE ELIMINAR DE DESTINOS*/
function eliminar_destinos_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-destino-e")[0]);
    $.ajax({
        url: '/eliminar-destino-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Destino eliminada",
                    type: "success"
                });
                $("#btn-eliminar-destino").html("<i class='fa fa-delete'></i> Eliminar")
                $("#modal-destino-e").modal('hide')
                get_destino()
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
/*FIN FUNCION DE ELIMINAR DE DESTINOS*/


/*INICIO PARA FUNCION CONSULTAR DESTINOSPOR ID*/
function get_destinos_id(id_destino) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar destinos por id")

    $.ajax({
        url: '/get-destino-id/' + id_destino,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#txt-latitud-m").val(data.de_latitud)
                    $("#txt-longitud-m").val(data.de_longitud)
                    $("#txt-destino-m").val(data.de_destino)
                    $("#txt-observacion-m").val(data.de_observacion)
                    $("#select-estado-m").val(data.de_estado)
                })
                $("#modal-destino-m").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR DESTINOSPOR ID*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DE DESTINOS*/
$("#btn-modificar-destino").click(function () {
    if (
        $('#txt-destino-m').val() == '' &&
        $('#txt-latitud-m').val() == '' &&
        $('#txt-longitud-m').val() == '' &&
        $('#txt-observacion-m').val() == '' &&
        $('#select-estado-m').val() == '0'
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-destino-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo destino esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-latitud-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo latitud esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-longitud-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo longitud esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($('#select-estado-m').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo estado no esta seleccionado",
            position: "right",
            autohide: false
        });
    }else if ($('#txt-observacion-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo observación esta vacio",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-modificar-destino").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Modificando..</span>")
        modificar_destinos()
    }

})
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DE DESTINOS*/

/*INICIO DE FUNCION PARA MODIFICAR DE DESTINOS POR ID */
function modificar_destinos() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-destino-m")[0]);
    $.ajax({
        url: '/modificar-destino',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Destino modificado",
                    type: "success"
                });
                $('#txt-destino-m').val('')
                $('#txt-latitud-m').val('')
                $('#txt-longitud-m').val('')
                $('#txt-observacion-m').val('')
                $('#select-estado-m').val('0')
                $("#modal-destino-m").modal('hide')
                $("#btn-modificar-destino").html("<i class='fa fa-editar'></i> Modificar")
                get_destino()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al modificar destinos",
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
/*FIN DE FUNCION PARA MODIFICAR DE DESTINOS POR ID */




