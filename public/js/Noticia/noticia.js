$(document).ready(function () {
    $('.dropify').dropify();
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    get_noticias()
})
//$("#global-loader").addClass("none");
//$("#global-loader").removeClass("block");

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE NOTICIAS */
$("#btn-añadir-noticia").click(function () {
    $("#modal-noticia").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  NOTICIAS */

/*INICIO DE FUNCION PARA LISTAR NOTICIAS */
function get_noticias() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar noticias")
    $.ajax({
        url: '/get-noticia',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-noticia" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Foto</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Titulo</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Descripcion</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Ubicacion</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Estado</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '				<td align="center" class="color-td"><img class="tam-ima-emp-ta" src="/imagenes_noticias/' + data.no_ruta_foto + '"></td>'
                    ht += '				<td align="center" class="color-td">' + data.no_titulo + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.no_descripcion + '</td>'
                    if (data.no_tipo == 1) {
                        ht += '				<td align="center" class="color-td">DTM</td>'
                    } else {
                        ht += '				<td align="center" class="color-td">TTM</td>'
                    }
                    if (data.no_estado == 1) {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-success me-1">Activo</span></td>'
                    } else if (data.no_estado == 2) {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-danger me-1">Inactivo</span></td>'
                    }
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" id="' + data.no_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.no_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-noticia").html(ht)

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR NOTICIAS */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-noticia").val(this.id)
                    $("#modal-eliminar-noticia").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR NOTICIAS*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR NOTICIAS*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-modificar-noticia").val(this.id)
                    get_noticias_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  NOTICIAS*/

            }
            $("#table-noticia").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR NOTICIAS */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE NOTICIAS */
$("#btn-guardar-noticia").click(function () {
    $("#btn-guardar-noticia").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Guardando..</span>")
    let mensaje = $(".note-editable").html();
    $("#txt-descripcion").val(mensaje)
    //alert( $("#txt-descripcion").val())
    guardar_noticias()
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE NOTICIAS */

/*INICIO FUNCION PARA GUARDAR DE NOTICIAS */
function guardar_noticias() {

    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-noticia")[0]);
    $.ajax({
        url: '/registrar-noticia',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                notif({
                    msg: "<b>Correcto:</b> Noticia registrado",
                    type: "success"
                });
                $("#txt-titulo").val("")
                $("#txt-descripcion").val("")
                var drEvent2 = $('#txt-file-foto').dropify();
                drEvent2 = drEvent2.data('dropify');
                drEvent2.resetPreview();
                drEvent2.clearElement();
                $("#btn-guardar-noticia").html("<i class='fa fa-save'></i> Guardar")
                $("#modal-noticia").modal('hide')
                get_noticias()
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
/*FIN FUNCION PARA GUARDAR DE NOTICIAS */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE NOTICIAS */
$("#btn-eliminar-noticia").click(function () {
    $("#btn-eliminar-noticia").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Guardando..</span>")
    eliminar_noticias_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE NOTICIAS*/

/*INICIO FUNCION DE ELIMINAR DE NOTICIAS*/
function eliminar_noticias_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-noticia")[0]);
    $.ajax({
        url: '/eliminar-noticia-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Noticia eliminada",
                    type: "success"
                });
                $("#btn-eliminar-noticia").html("<i class='fa fa-times'></i> Eliminar")
                $("#modal-eliminar-noticia").modal('hide')
                get_noticias()
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
/*FIN FUNCION DE ELIMINAR DE NOTICIAS*/


/*INICIO PARA FUNCION CONSULTAR NOTICIAS POR ID*/
function get_noticias_id(id_noticia) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar noticia por id")

    $.ajax({
        url: '/get-noticia-id/' + id_noticia,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#txt-titulo-m").val(data.no_titulo)
                    $("#txt-descripcion-m").val(data.no_descripcion)
                    $("#txt-ruta-anterior").val(data.no_ruta_foto)
                    $("#select-estado-m").val(data.no_estado)
                    $("#select-ubicacion-m").val(data.no_tipo)
                    $(".note-editable").html(data.no_descripcion);
                    var drEvent = $('#txt-file-foto-m').dropify(
                        {
                            defaultFile: '/imagenes_noticias/' + data.no_ruta_foto
                        });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = '/imagenes_noticias/' + data.no_ruta_foto;
                    drEvent.destroy();
                    drEvent.init();
                })


                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
            $("#modal-noticia-m").modal("show")
        }
    })
}
/*FIN PARA FUNCION CONSULTAR EMPLEADO POR ID*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DE NOTICIAS */
$("#btn-modificar-noticia").click(function () {
    $("#btn-modificar-noticia").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Modificando..</span>")
    let mensaje = $('#summernote-m').summernote('code');
    //$('.note-editable').summernote('destroy');
    $("#txt-descripcion-m").val(mensaje)
    modificar_noticias()
})
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DE NOTICIAS */

/*INICIO DE FUNCION PARA MODIFICAR DE NOTICIAS  POR ID */
function modificar_noticias() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-noticia-m")[0]);
    $.ajax({
        url: '/modificar-noticia',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Noticia modificada",
                    type: "success"
                });
                $("#txt-titulo-m").val("")
                $("#txtdescripcion-m").val("")
                var drEvent = $('#txt-file-foto-m').dropify();
                drEvent = drEvent.data('dropify');
                drEvent.clearElement();
                $("#modal-noticia-m").modal('hide')
                $("#btn-modificar-noticia").html("<i class='fa fa-edit'></i> Modificar")
                get_noticias()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar noticias",
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
/*FIN DE FUNCION PARA MODIFICAR DE NOTICIAS  POR ID */




