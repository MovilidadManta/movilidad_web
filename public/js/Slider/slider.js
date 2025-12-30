$(document).ready(function () {
    $('.dropify').dropify();
    get_sliders()
})

/*INICIO DE FUNCION PARA LISTAR SLIDER DEL INDEX */
function get_sliders() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar nosotros")
    $.ajax({
        url: '/get-slider-index',
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-slider" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Id</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Foto</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Titulo</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Descripción</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Tipo</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Estado</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '			    <td width="5%" class="color-td" align="center">' + data.sl_id + '</td>'
                    ht += '				<td width="20%" class="color-td" align="center"><img class="tam-ima-slider-ta " src="/imagenes_slider/' + data.sl_ruta_foto + '"></td>'
                    ht += '				<td width="30%" class="color-td" align="center">' + data.sl_titulo + '</td>'
                    ht += '				<td width="40%" class="color-td" align="center">' + data.sl_descripcion + '</td>'
                    if (data.sl_tipo == 'MOV') {
                        ht += '				<td width="40%" class="color-td" align="center">Movilidad</td>'
                    } else if (data.sl_tipo == 'TER') {
                        ht += '				<td width="40%" class="color-td" align="center">Terminal</td>'
                    } else if (data.sl_tipo == 'ANT') {
                        ht += '				<td width="40%" class="color-td" align="center">ANT</td>'
                    } else if (data.sl_tipo == 'INT') {
                        ht += '				<td width="40%" class="color-td" align="center">INTRANET</td>'
                    }
                    if (data.sl_estado == 'A') {
                        ht += '				<td width="40%" class="color-td" align="center">Activo</td>'
                    } else {
                        ht += '				<td width="40%" class="color-td" align="center">Inactivo</td>'
                    }
                    ht += '				<td width="10%"class="color-td" align="center">'
                    ht += '              <button type="button" id="' + data.sl_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.sl_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-slider").html(ht)
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR SLIDER DEL INDEX */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-slider-e").val(this.id)
                    $("#modal-slider-e").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR SLIDER DEL INDEX*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR SLIDER DEL INDEX*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-modificar-slider").val(this.id)
                    get_sliders_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  SLIDER DEL INDEX*/

            }
            $("#table-slider").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR STAR SLIDER DEL INDEX */

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE SLIDER DEL INDEX */
$("#btn-añadir-slider").click(function () {
    $("#modal-slider").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  SLIDER DEL INDEX */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE SLIDER DEL INDEX */
$("#btn-guardar-slider_intranet").click(function () {
    if (
        $("#txt-file-foto").val() == "" &&
        $("#txt-titulo").val() == "" &&
        $("#txt-descripcion").val() == ""
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false,
        });
    } else if ($("#txt-file-foto").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b> Campo foto esta vacio",
            position: "right",
            autohide: false,
        });
    } else if ($("#txt-titulo").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b> Campo titulo esta vacio",
            position: "right",
            autohide: false,
        });
    } else if ($("#txt-descripcion").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b> Campo descripcion esta vacio",
            position: "right",
            autohide: false,
        });
    } else {
        $("#btn-guardar-slider").html(
            "<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>"
        );
        guardar_slider_index();
    }
});
$("#btn-guardar-slider").click(function () {
    if (
        $("#txt-file-foto").val() == "" &&
        $("#txt-titulo").val() == "" &&
        $("#txt-descripcion").val() == ""
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false,
        });
    } else if ($("#txt-file-foto").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b> Campo foto esta vacio",
            position: "right",
            autohide: false,
        });
    } else if ($("#txt-titulo").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b> Campo titulo esta vacio",
            position: "right",
            autohide: false,
        });
    } else if ($("#txt-descripcion").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b> Campo descripcion esta vacio",
            position: "right",
            autohide: false,
        });
    } else {
        $("#btn-guardar-slider").html(
            "<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>"
        );
        guardar_slider_index();
    }
});
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE SLIDER DEL INDEX */

/*INICIO FUNCION PARA GUARDAR DE SLIDER DEL INDEX */
function guardar_slider_index() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-slider")[0]);
    $.ajax({
        url: "/registrar-slider",
        type: "POST",
        dataType: "json",
        headers: { "X-CSRF-TOKEN": token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Slider registrado",
                    type: "success",
                });
                $("#txt-file-foto").val("");
                $("#txt-titulo").val("");
                $("#txt-descripcion").val("");
                $("#select-tipo-m").val("0");
                $("#select-estado-m").val("0");
                $("#modal-slider").modal("hide");
                var drEvent2 = $("#txt-file-foto").dropify();
                drEvent2 = drEvent2.data("dropify");
                drEvent2.resetPreview();
                drEvent2.clearElement();
                $("#btn-guardar-slider").html(
                    "<i class='fa fa-save'></i> Guardar"
                );
                get_sliders();
            }
        },
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 0) {
            alert("Not connect: Verify Network.");
        } else if (jqXHR.status == 404) {
            alert("Requested page not found [404]");
        } else if (jqXHR.status == 500) {
            alert("Internal Server Error [500]. Intente nuevamente");
        } else if (textStatus === "timeout") {
            alert("Time out error.");
        } else if (textStatus === "abort") {
            alert("Ajax request aborted.");
        }
    });
}

function guardar_slider_int() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-slider")[0]);
    $.ajax({
        url: "/registrar-slider_intranet",
        type: "POST",
        dataType: "json",
        headers: { "X-CSRF-TOKEN": token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Slider registrado",
                    type: "success",
                });
                $("#txt-file-foto").val("");
                $("#txt-titulo").val("");
                $("#txt-descripcion").val("");
                $("#select-tipo-m").val("0");
                $("#select-estado-m").val("0");
                $("#modal-slider").modal("hide");
                var drEvent2 = $("#txt-file-foto").dropify();
                drEvent2 = drEvent2.data("dropify");
                drEvent2.resetPreview();
                drEvent2.clearElement();
                $("#btn-guardar-slider").html(
                    "<i class='fa fa-save'></i> Guardar"
                );
                get_sliders();
            }
        },
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 0) {
            alert("Not connect: Verify Network.");
        } else if (jqXHR.status == 404) {
            alert("Requested page not found [404]");
        } else if (jqXHR.status == 500) {
            alert("Internal Server Error [500]. Intente nuevamente");
        } else if (textStatus === "timeout") {
            alert("Time out error.");
        } else if (textStatus === "abort") {
            alert("Ajax request aborted.");
        }
    });
}
/*FIN FUNCION PARA GUARDAR DE SLIDER DEL INDEX */

/*INICIO PARA FUNCION CONSULTAR SLIDER DEL INDEX POR ID*/
function get_sliders_id(id) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/get-slider-id/' + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#txt-titulo-m").val(data.sl_titulo)
                    $("#txt-descripcion-m").val(data.sl_descripcion)
                    $("#txt-ruta-anterior-m").val(data.sl_ruta_foto)
                    $("#select-estado-m").val(data.sl_estado)
                    $("#select-tipo-m").val(data.sl_tipo)
                    var drEvent = $('#txt-file-foto-m').dropify(
                        {
                            defaultFile: '/imagenes_slider/' + data.sl_ruta_foto
                        });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = '/imagenes_slider/' + data.sl_ruta_foto;
                    drEvent.destroy();
                    drEvent.init();
                })
                $("#modal-modificar-slider").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR SLIDER DEL INDEX POR ID*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DE SLIDER DEL INDEX POR ID */
$("#btn-modificar-slider").click(function () {
    if ($('#txt-titulo-m').val() == '' && $('#txt-descripcion-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-titulo-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b> Campo titulo esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-descripcion-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b> Campo descripcion esta vacio",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-modificar-slider").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Modificando..</span>")
        modificar_slider()
    }
})
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DE SLIDER DEL INDEX POR ID */

/*INICIO DE FUNCION PARA MODIFICAR LOS DATOS DE SLIDER DEL INDEX POR ID */
function modificar_slider() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-slider-m")[0]);
    $.ajax({
        url: '/modificar-slider',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Slider modificado",
                    type: "success"
                });
                $("#txt-file-foto-m").val("")
                $("#txt-titulo-m").val("")
                $("#txt-descripcion-m").val("")
                $("#sel-tipo").val("0")
                $("#sel-estado").val("0")
                $("#modal-modificar-slider").modal('hide')
                var drEvent2 = $('#txt-file-foto-m').dropify();
                drEvent2 = drEvent2.data('dropify');
                drEvent2.resetPreview();
                drEvent2.clearElement();
                $("#btn-modificar-slider").html("<i class='fa fa-edit'></i> Modificar")
                get_sliders()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar Slider",
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
/*FIN DE FUNCION PARA MODIFICAR DLOS DATOS DE SLIDER DEL INDEX POR ID */

/*INICIO DE FUNCION PARA ELIMINAR LOS DATOS DE SLIDER DEL INDEX POR ID */
$("#btn-eliminar-slider").click(function () {
    $("#btn-eliminar-slider").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Eliminando..</span>")
    eliminar_slider_id()
})
/*FIN DE FUNCION PARA ELIMINAR LOS DATOS DE SLIDER DEL INDEX POR ID */

/*INICIO FUNCION DE ELIMINAR DE SLIDER DEL INDEX POR ID*/
function eliminar_slider_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-slider-e")[0]);
    $.ajax({
        url: '/eliminar-slider-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Slider eliminado",
                    type: "success"
                });
                $("#btn-eliminar-slider").html("<i class='fa fa-save'></i> Eliminar")
                $("#modal-slider-e").modal('hide')
                get_sliders()
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
/*FIN FUNCION DE ELIMINAR DE SLIDER DEL INDEX POR ID*/


