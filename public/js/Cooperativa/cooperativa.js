$(document).ready(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $('.dropify').dropify();
    get_destino_select()
    get_cooperativa()
})
//$("#global-loader").addClass("none");
//$("#global-loader").removeClass("block");

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE COOPERATIVAS */
$("#btn-añadir-cooperativa").click(function () {
    $("#modal-cooperativa").modal("show")
    clearTrHorariosEncomienda('tbody-encomienda-horario', '');
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  COOPERATIVAS */

/*INICIO DE FUNCION PARA LISTAR COOPERATIVAS */
function get_cooperativa() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar cooperativas")
    $.ajax({
        url: '/get-cooperativa',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            var ht = ""
            ht += '  <table id="table-cooperativa" border="2" class="table">'
            ht += '	    <thead class="background-thead">'
            ht += '		    <tr align="center">'
            ht += '				<th align="center" class="border-bottom-0 color-th">Foto</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Cooperativa</th>'
            ht += '			    <th align="center" class="border-bottom-0 color-th">Observacion</th>'
            ht += '			    <th align="center" class="border-bottom-0 color-th">Tipo</th>'
            ht += '			    <th align="center" class="border-bottom-0 color-th">Ubicación</th>'
            ht += '			    <th align="center" class="border-bottom-0 color-th">Estado</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
            ht += '			</tr>'
            ht += '		</thead>'
            ht += '		<tbody>'
            $(response.data).each(function (i, data) {
                ht += '			<tr align="center">'
                ht += '			    <td class="color-td"><img class="tam-ima-slider-ta" src="/imagenes_cooperativa/' + data.co_ruta_foto + '"></td>'
                ht += '				<td class="color-td">' + data.co_nombre + '</td>'
                ht += '				<td class="color-td">' + data.co_observacion + '</td>'
                if (data.co_tipo_cooperativa == '1') {
                    ht += '				<td class="color-td">Interprovincial</td>'
                } else if (data.co_tipo_cooperativa == '2') {
                    ht += '				<td class="color-td">Intercantonal</td>'
                }
                ht += '				<td class="color-td">' + data.co_ubicacion + '</td>'
                if (data.co_estado == 'A') {
                    ht += '				<td class="color-td"><span class="badge bg-success me-1">Activo</span></td>'
                } else if (data.co_estado == 'I') {
                    ht += '				<td class="color-td"><span class="badge bg-danger me-1">Inactivo</span></td>'
                }
                ht += '				<td class="color-td" align="center">'
                ht += '              <button type="button" id="' + data.co_id + '" class="tam-btn btn btn-info btn-modal-destino"><i class="fa fa-bars tam-icono"></i></button>'
                ht += '              <button type="button" id="' + data.co_id + '" class="tam-btn btn btn-warning btn-modal-editar-destino"><i class="fa fa-edit tam-icono"></i></button>'
                ht += '              <button type="button" id="' + data.co_id + '" class="tam-btn btn btn-danger btn-modal-eliminar-destino"><i class="fa fa-trash tam-icono"></i></button>'
                ht += '			    </td>'
                ht += '			</tr>'
            })
            ht += '		</tbody>'
            ht += '  </table>'
            $("#div-table-cooperativa").html(ht)

            /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR COOPERATIVAS */
            $(".btn-modal-eliminar-destino").click(function () {
                $("#txt-id-cooperativa").val(this.id)
                $("#modal-eliminar-cooperativa").modal("show")
            })
            /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR COOPERATIVAS*/

            /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR COOPERATIVAS*/
            $(".btn-modal-editar-destino").click(function () {
                $("#txt-id-cooperativa-m").val(this.id)
                get_cooperativas_id(this.id)
            })
            /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  COOPERATIVAS*/

            $(".btn-modal-destino").click(function () {
                //$("#" + this.id).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'></span>")
                $("#txt-id-cooperativa-destino").val(this.id)
                get_destino()
            })

            $("#table-cooperativa").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR  LISTAR COOPERATIVAS */

/*INICIO DE FUNCION PARA LISTAR LAS DESTINO*/
function get_destino_select() {
    $("#select-destino").html("<option value='0'>Cargando Destinos</option>")
    $.ajax({
        url: '/get-destino',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Destino</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.de_id + '>' + data.de_destino + '</option>'
                })
                $("#select-destino").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS DESTINO*/

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE COOPERATIVAS */
$("#btn-guardar-cooperativa").click(function () {
    if (
        $('#txt-nombre').val() == '' &&
        $('#txt-codigo').val() == '' &&
        $('#txt-abreviatura').val() == '' &&
        $('#select-tipo').val() == '0' &&
        $('#select-estado').val() == '0' &&
        $('#txt-correo').val() == '' &&
        $('#txt-convencional').val() == '' &&
        $('#txt-celular').val() == '' &&
        $('#txt-ubicacion').val() == '' &&
        $('#select-estado-encomienda').val() == '0' &&
        $('#txt-ubicacion-encomienda').val() == '' &&
        $('#txt-observacion').val() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-nombre').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo nombre esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-codigo').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo codigo esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-abreviatura').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo abreviatura esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#select-tipo').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo tipo no esta seleccionado",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#select-estado').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo estado no esta seleccionado",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-correo').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo correo esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-convencional').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo convencional esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-celular').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo celular esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-ubicacion').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Ubicación esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#select-estado-encomienda').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo realiza encomienda no esta seleccionado",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#select-estado-encomienda').val() == 'SI' && $('#txt-ubicacion-encomienda').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Ubicación de encomienda esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-observacion').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo observacion esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-cooperativa").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
        setHorarioEncomienda('');
        guardar_cooperativas()
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE COOPERATIVAS */

/*INICIO FUNCION PARA GUARDAR DE COOPERATIVAS */
function guardar_cooperativas() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-cooperativa")[0]);
    $.ajax({
        url: '/registrar-cooperativa',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Cooperativa registrada",
                    type: "success",
                    zindex: 99999
                });
                $("#txt-nombre").val("")
                $("#txt-codigo").val("")
                $("#txt-abreviatura").val("")
                $("#select-tipo").val("0")
                $("#select-estado").val("0")
                $("#txt-correo").val("")
                $("#txt-convencional").val("")
                $("#txt-celular").val("")
                $("#txt-ubicacion").val("")
                $("#select-estado-encomienda").val("0")
                $("#txt-ubicacion-encomienda").val("")
                $("#txt-observacion").val("")
                var drEvent2 = $('#txt-file-foto').dropify();
                drEvent2 = drEvent2.data('dropify');
                drEvent2.resetPreview();
                drEvent2.clearElement();
                $("#modal-cooperativa").modal('hide')
                $("#btn-guardar-cooperativa").html("<i class='fa fa-save'></i> Guardar")
                get_cooperativa()
            } else if (response.respuesta == 'imagen_vacia') {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>Subir una imagen de la cooperativa",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#btn-guardar-cooperativa").html("<i class='fa fa-save'></i> Guardar")
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
/*FIN FUNCION PARA GUARDAR DE COOPERATIVAS */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE COOPERATIVAS */
$("#btn-eliminar-cooperativa").click(function () {
    $("#btn-eliminar-cooperativa").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Eliminando..</span>")
    eliminar_cooperativas_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE COOPERATIVAS*/

/*INICIO FUNCION DE ELIMINAR DE COOPERATIVAS*/
function eliminar_cooperativas_id() {
    var token = $("#csrf-token-modal-eliminar-cooperativa").val();
    var datos = new FormData($("#form-eliminar-cooperativa")[0]);
    $.ajax({
        url: '/eliminar-cooperativa-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Cooperativa eliminada",
                    type: "success",
                    zindex: 99999
                });
                $("#btn-eliminar-cooperativa").html("<i class='fa fa-delete'></i> Eliminar")
                $("#modal-eliminar-cooperativa").modal('hide')
                get_cooperativa()
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
/*FIN FUNCION DE ELIMINAR DE COOPERATIVAS*/


/*INICIO PARA FUNCION CONSULTAR COOPERATIVAS POR ID*/
function get_cooperativas_id(id_cooperativa) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");

    $.ajax({
        url: '/get-cooperativa-id/' + id_cooperativa,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                clearTrHorariosEncomienda('tbody-encomienda-horario-m', '-m');
                $(response.data).each(function (i, data) {
                    var drEvent = $('#txt-file-foto-m').dropify(
                        {
                            defaultFile: '/imagenes_cooperativa/' + data.co_ruta_foto
                        });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = '/imagenes_cooperativa/' + data.co_ruta_foto;
                    drEvent.destroy();
                    drEvent.init();
                    $("#txt-nombre-m").val(data.co_nombre)
                    $("#txt-codigo-m").val(data.co_codigo)
                    $("#txt-abreviatura-m").val(data.co_abreviatura)
                    $("#select-tipo-m").val(data.co_tipo_cooperativa)
                    $("#select-estado-m").val(data.co_estado)
                    $("#txt-correo-m").val(data.co_correo)
                    $("#txt-convencional-m").val(data.co_convencional)
                    $("#txt-celular-m").val(data.co_celular)
                    $("#txt-ubicacion-m").val(data.co_ubicacion)
                    $("#select-estado-encomienda-m").val(data.co_estado_encomienda)
                    $("#txt-ubicacion-encomienda-m").val(data.co_ubicacion_encomienda)
                    $("#txt-observacion-m").val(data.co_observacion)
                    $("#txt-foto-anterior").val(data.co_ruta_foto)
                    $("#horario-encomienda-m").val(JSON.stringify(data.horarios_encomienda))
                    data.horarios_encomienda.forEach(h => {
                        agregarHorario('-m', h.ho_dias, h.ho_desde, h.ho_hasta);
                        $('#container-horario-encomienda-m').fadeIn();
                    });
                })
                $("#modal-cooperativa-m").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");

            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR COOPERATIVAS POR ID*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DE COOPERATIVAS */
$("#btn-modificar-cooperativa").click(function () {
    if (
        $('#txt-nombre-m').val() == '' &&
        $('#txt-codigo-m').val() == '' &&
        $('#txt-abreviatura-m').val() == '' &&
        $('#select-tipo-m').val() == '0' &&
        $('#select-estado-m').val() == '0' &&
        $('#txt-correo-m').val() == '' &&
        $('#txt-convencional-m').val() == '' &&
        $('#txt-celular-m').val() == '' &&
        $('#txt-ubicacion-m').val() == '' &&
        $('#select-estado-encomienda-m').val() == '0' &&
        $('#txt-ubicacion-encomienda-m').val() == '' &&
        $('#txt-observacion-m').val() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-nombre-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo nombre esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-codigo-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo codigo esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-abreviatura-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo abreviatura esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#select-tipo-m').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo tipo no esta seleccionado",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#select-estado-m').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo estado no esta seleccionado",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-correo-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo correo esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-convencional-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo convencional esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-celular-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo celular esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-ubicacion-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Ubicación esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#select-estado-encomienda-m').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo realiza encomienda no esta seleccionado",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#select-estado-encomienda-m').val() == 'SI' && $('#txt-ubicacion-encomienda-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Ubicación de encomienda esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-observacion-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo observacion esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-modificar-cooperativa").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Modificando..</span>")
        setHorarioEncomienda('-m');
        modificar_cooperativas()
    }
})
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DE COOPERATIVAS */

/*INICIO DE FUNCION PARA MODIFICAR DE COOPERATIVAS  POR ID */
function modificar_cooperativas() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-cooperativa-m")[0]);
    $.ajax({
        url: '/modificar-cooperativa',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Cooperativa modificados",
                    type: "success"
                });
                $("#txt-nombre-m").val('')
                $("#txt-codigo-m").val('')
                $("#txt-abreviatura-m").val('')
                $("#select-tipo-m").val('0')
                $("#select-estado-m").val('0')
                $("#txt-correo-m").val('')
                $("#txt-convencional-m").val('')
                $("#txt-celular-m").val('')
                $("#txt-ubicacion-m").val('')
                $("#select-estado-encomienda-m").val('0')
                $("#txt-ubicacion-encomienda-m").val('')
                $("#txt-observacion-m").val('')
                $("#btn-modificar-cooperativa").html("<i class='fa fa-edit'></i> Modificar")
                $("#modal-cooperativa-m").modal('hide')
                get_cooperativa()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar cooperativas",
                    position: "right",
                    autohide: false,
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
/*FIN DE FUNCION PARA MODIFICAR DE COOPERATIVAS  POR ID */

/*INICIO DE FUNCION PARA LISTAR DESTINOS */
function get_destino() {
    var id_cooperativa = $("#txt-id-cooperativa-destino").val()
    $.ajax({
        url: '/admin-get-destino-cooperativa/' + id_cooperativa,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            var ht = ""
            ht += '  <table id="table-destino" border="2" class="table">'
            ht += '	    <thead class="background-thead">'
            ht += '		    <tr align="center">'
            ht += '				<th align="center" class="border-bottom-0 color-th">Destino</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Precio</th>'
            ht += '			    <th align="center" class="border-bottom-0 color-th">Frecuencia</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
            ht += '			</tr>'
            ht += '		</thead>'
            ht += '		<tbody>'
            $(response.data).each(function (i, data) {
                ht += '			<tr>'
                ht += '				<td align="center" class="color-td">' + data.de_destino + '</td>'
                ht += '				<td align="center" class="color-td">$ ' + parseFloat(data.dc_precio).toFixed(2) + '</td>'
                ht += '				<td align="center" class="color-td">'
                ht += '				    <button type="button" id="destino-' + data.dc_id + '" class="tam-btn btn btn-warning-horario btn-modal-horario background-btn-nuevo"><i class="fa fa-clock tam-icono color-fre"></i></button></td>'
                ht += '				</td>'
                ht += '				<td class="color-td" align="center">'
                ht += '              <button type="button" id="destino-editar-' + data.dc_id + '" class="tam-btn btn btn-warning btn-editar-destino-cooperativa"><i class="fa fa-edit tam-icono"></i></button>'
                ht += '              <button type="button" id="destino-eliminar-' + data.dc_id + '" class="tam-btn btn btn-danger btn-eliminar-destino-cooperativa"><i class="fa fa-trash tam-icono"></i></button>'
                ht += '			</tr>'
            })
            ht += '		</tbody>'
            ht += '  </table>'
            $("#div-table-destino").html(ht)
            //$("#" + id_cooperativa).html('<img src="http://terminalmanta.gob.ec/assets/images/art/marker3.png" alt="" class="" style="width: 1rem;">')
            $("#table-destino").DataTable()
            $("#modal-destino").modal("show")

            /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR COOPERATIVAS */
            $(".btn-eliminar-destino-cooperativa").click(function () {
                var id = this.id
                var id_ = id.split("-")
                $("#txt-id-destino-cooperativa").val(id_[2])
                $("#modal-destino-cooperativa-e").modal('show')
            })
            /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR COOPERATIVAS*/

            /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR COOPERATIVAS*/
            $(".btn-editar-destino-cooperativa").click(function () {
                var id = this.id
                var id_ = id.split("-")
                $("#destino-editar-" + id_[2]).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'></span>")
                get_destino_cooperativa_id(id_[2])
            })
            /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  COOPERATIVAS*/

            $(".btn-modal-horario").click(function () {
                var id = this.id
                var id_ = id.split("-")
                $("#destino-" + id_[1]).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'></span>")
                $('#txt-id-destino-horario').val(id_[1])
                get_horario_destino()
            })
        }
    })
}
/*FIN DE FUNCION PARA LISTAR  LISTAR DESTINOS */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE COOPERATIVAS */
$("#btn-guardar-destino-cooperativa").click(function () {
    if (
        $('#select-destino').val() == '0' &&
        $('#txt-precio').val() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#select-destino').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo destino no esta seleccionado",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if ($('#txt-precio').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo precio esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-destino-cooperativa").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
        $("#div-table-destino").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span> Cargando Información..Espere por favor</span>")
        guardar_destino_cooperativa()
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE COOPERATIVAS */

/*INICIO FUNCION PARA GUARDAR DE DESTINOS DE COOPERATIVAS */
function guardar_destino_cooperativa() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-destino-cooperativa")[0]);
    $.ajax({
        url: '/registrar-destino-cooperativa',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == "true") {
                get_destino($("#select-destino").val())
                $("#select-destino").val("0")
                $("#txt-precio").val("")
                $("#txt-id-destino").val('')
                $("#btn-guardar-destino-cooperativa").html("<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir</strong>")
                notif({
                    msg: "<b>Correcto:</b>Destino de Cooperativa registrada",
                    type: "success",
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
/*FIN FUNCION PARA GUARDAR DE DESTINOS DE COOPERATIVAS */

/*INICIO PARA FUNCION CONSULTAR DESTINO DE COOPERATIVAS POR ID*/
function get_destino_cooperativa_id(id_destino_cooperativa) {
    $.ajax({
        url: '/get-destino-cooperativa-id/' + id_destino_cooperativa,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#select-destino").val(data.dc_id_destino)
                    $("#txt-precio").val(data.dc_precio)
                    $("#txt-id-destino").val(data.dc_id)
                })
            }
            $("#destino-editar-" + id_destino_cooperativa).html("<i class='fa fa-edit tam-icono'></i>")
        }
    })
}
/*FIN PARA FUNCION CONSULTAR DESTINO DE COOPERATIVAS POR ID*/

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DESTINO DE COOPERATIVAS */
$("#btn-eliminar-destino-cooperativa").click(function () {
    $("#btn-eliminar-destino-cooperativa").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Eliminando..</span>")
    eliminar_destino_cooperativa_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DESTINO DE COOPERATIVAS*/

/*INICIO FUNCION DE ELIMINAR DESTINO DE COOPERATIVAS*/
function eliminar_destino_cooperativa_id() {
    var token = $("#csrf-token-modal-destino-cooperativa-e").val();
    var datos = new FormData($("#form-destino-cooperativa-e")[0]);
    $.ajax({
        url: '/eliminar-destino-cooperativa-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                $("#txt-id-destino-cooperativa").val('')
                notif({
                    msg: "<b>Correcto:</b> Destino Cooperativa eliminada",
                    type: "success",
                    zindex: 99999
                });
                $("#btn-eliminar-destino-cooperativa").html("<i class='fa fa-delete'></i> Eliminar")
                $("#modal-destino-cooperativa-e").modal('hide')
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
/*FIN FUNCION DE ELIMINAR DESTINO  DE COOPERATIVAS*/

/*INICIO DE FUNCION PARA LISTAR HORARIOS DE LOS DESTINOS */
function get_horario_destino() {
    var id_destino = $("#txt-id-destino-horario").val()
    $.ajax({
        url: '/get-horario-destino-cooperativa/' + id_destino,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            var ht = ""
            ht += '  <table id="table-destino-horario" border="2" class="table">'
            ht += '	    <thead class="background-thead">'
            ht += '		    <tr align="center">'
            ht += '				<th align="center" class="border-bottom-0 color-th">Frecuencia</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
            ht += '			</tr>'
            ht += '		</thead>'
            ht += '		<tbody>'
            $(response.data).each(function (i, data) {
                ht += '			<tr>'
                ht += '				<td align="center" class="color-td">' + data.hs_hora_salida + '</td>'
                ht += '				<td class="color-td" align="center">'
                ht += '              <button type="button" id="destino-editar-' + data.hs_id + '" class="tam-btn btn btn-warning btn-editar-destino-cooperativa"><i class="fa fa-edit tam-icono"></i></button>'
                ht += '              <button type="button" id="destino-eliminar-' + data.hs_id + '" class="tam-btn btn btn-danger btn-eliminar-destino-cooperativa"><i class="fa fa-trash tam-icono"></i></button>'
                ht += '			</tr>'
            })
            ht += '		</tbody>'
            ht += '  </table>'
            $("#div-table-horario-destino").html(ht)
            $("#destino-" + id_destino).html('<i class="fa fa-clock tam-icono color-fre"></i>')
            $("#table-destino-horario").DataTable()
            $("#modal-destino-horario").modal("show")

            /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR HORARIO DE DESTINO DE LAS COOPERATIVAS */
            $(".btn-eliminar-destino-cooperativa").click(function () {
                var id = this.id
                var id_ = id.split("-")
                $("#txt-id-horario-destino-cooperativa").val(id_[2])
                $("#modal-horario-destino-cooperativa-e").modal('show')
            })
            /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR HORARIO DE DESTINO DE LAS COOPERATIVAS*/

            /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR HORARIO DE DESTINO DE LAS COOPERATIVAS*/
            $(".btn-editar-destino-cooperativa").click(function () {
                var id = this.id
                var id_ = id.split("-")
                $("#txt-id-horario-destino").val(id_[2])
                $("#destino-editar-" + id_[2]).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'></span>")
                get_horario_destino_cooperativa_id(id_[2])
            })
            /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  HORARIO DE DESTINO DE LAS COOPERATIVAS*/
        }
    })
}
/*FIN DE FUNCION PARA LISTAR HORARIOS DE LOS DESTINOS */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE FRECUENCIA DE COOPERATIVAS */
$("#btn-guardar-horario-destino-cooperativa").click(function () {
    if ($('#txt-frecuencia').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo frecuencia esta vacio",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-horario-destino-cooperativa").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
        $("#div-table-horario-destino").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span> Cargando Información..Espere por favor</span>")
        guardar_horario_destino_cooperativa()
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE FRECUENCIA DE COOPERATIVAS */

/*INICIO FUNCION PARA GUARDAR FRECUENCIA DE COOPERATIVAS */
function guardar_horario_destino_cooperativa() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-destino-cooperativa-horario")[0]);
    $.ajax({
        url: '/registrar-horario-destino-cooperativa',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == "true") {
                $("#txt-id-horario-destino").val('')
                get_horario_destino()
                document.getElementById("form-destino-cooperativa-horario").reset();
                $("#btn-guardar-horario-destino-cooperativa").html("<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir</strong>")
                notif({
                    msg: "<b>Correcto:</b>Frecuencia de Cooperativa registrada",
                    type: "success",
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
/*FIN FUNCION PARA GUARDAR FRECUENCIA DE COOPERATIVAS */

/*INICIO PARA FUNCION CONSULTAR DESTINO DE COOPERATIVAS POR ID*/
function get_horario_destino_cooperativa_id(id_horario_destino_cooperativa) {
    $.ajax({
        url: '/get-horario-destino-cooperativa-id/' + id_horario_destino_cooperativa,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#txt-frecuencia").val(data.hs_hora_salida)
                    $("#txt-id-horario-destino").val(data.hs_id)
                    $("#txt-id-destino-horario").val(data.hs_id_destino)
                })
            }
            $("#destino-editar-" + id_horario_destino_cooperativa).html("<i class='fa fa-edit tam-icono'></i>")
        }
    })
}
/*FIN PARA FUNCION CONSULTAR DESTINO DE COOPERATIVAS POR ID*/

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR HORARIOS DE DESTINO DE COOPERATIVAS */
$("#btn-eliminar-horario-destino-cooperativa").click(function () {
    $("#btn-eliminar-horario-destino-cooperativa").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Eliminando..</span>")
    eliminar_horario_destino_cooperativa_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR HORARIOS DE DESTINO DE COOPERATIVAS*/

/*INICIO FUNCION DE ELIMINAR DESTINO DE COOPERATIVAS*/
function eliminar_horario_destino_cooperativa_id() {
    var token = $("#csrf-token-modal-horario-destino-cooperativa-e").val();
    var datos = new FormData($("#form-horario-destino-cooperativa-e")[0]);
    $.ajax({
        url: '/eliminar-horario-destino-cooperativa-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            get_horario_destino()
            if (response.data == "eliminado") {
                $("#txt-id-horario-destino").val('')
                notif({
                    msg: "<b>Correcto:</b> Horarios de Destino Cooperativa eliminado",
                    type: "success",
                    zindex: 99999
                });
                $("#btn-eliminar-horario-destino-cooperativa").html("<i class='fa fa-delete'></i> Eliminar")
                $("#modal-horario-destino-cooperativa-e").modal('hide')
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
/*FIN FUNCION DE ELIMINAR DESTINO  DE HORARIOS DE DESTINO DE COOPERATIVAS*/

/* Funciones decimales caja de texto*/
let txtPrecio = document.getElementById('txt-precio');
txtPrecio.addEventListener('input', (e) => {
    e.target.value = e.target.value.replace(/[^0-9,.]/g, '');
});
/* Fin funciones decimales caja de texto */

/* Funcion para control de horario encomienda */

function DatesHorarioEncomienda(mod) {
    let txtDesde = document.getElementById(`txt-desde-horario${mod}`);
    let txtHasta = document.getElementById(`txt-hasta-horario${mod}`);
    txtDesde.addEventListener('change', (e) => {
        txtHasta.disabled = false;
        txtHasta.min = e.target.value
    });
    txtHasta.addEventListener('change', (e) => {
        if (e.target.value < e.target.min) {
            e.target.value = '';
            notif({
                type: "warning",
                msg: `<b>Aviso: </b>Seleccione una fecha superior a ${e.target.min}`,
                position: "right",
                autohide: false,
                zindex: 99999
            });
        }
    });
}

function SelectChangeHorarioEncomienda(mod) {
    $(`#select-estado-encomienda${mod}`).change(function () {
        $(`#container-horario-encomienda${mod}`).fadeOut();
        if ($(this).val() == 'SI') {
            $(`#container-horario-encomienda${mod}`).fadeIn();
        }
    });
}

function btnGuardarHorarioEncomienda(mod) {
    $(`#btn-guardar-horario-encomienda-cooperativa${mod}`).click(function () {
        let diasElements = document.querySelectorAll(`#container-horario-encomienda${mod} [id^='check-horario-encomienda${mod}-']`);
        let dias = '';
        diasElements.forEach((d) => {
            dias += d.checked ? `${d.value}, ` : '';
        });
        if ($(`#txt-desde-horario${mod}`).val() == '') {
            notif({
                type: "warning",
                msg: "<b>Aviso: </b>Campo Horario Desde está vacio",
                position: "right",
                autohide: true,
                zindex: 99999
            });
        } else if ($(`#txt-hasta-horario${mod}`).val() == '') {
            notif({
                type: "warning",
                msg: "<b>Aviso: </b>Campo Horario Hasta está vacio",
                position: "right",
                autohide: true,
                zindex: 99999
            });
        } else if (dias == '') {
            notif({
                type: "warning",
                msg: "<b>Aviso: </b> Debe seleccionar al menos un día",
                position: "right",
                autohide: true,
                zindex: 99999
            });
        } else {
            dias = dias.substring(0, dias.length - 2);
            agregarHorario(mod, dias, $(`#txt-desde-horario${mod}`).val(), $(`#txt-hasta-horario${mod}`).val());
        }
    });
}

function agregarHorario(mod, dias, desde, hasta) {
    let bodyTableHorario = document.getElementById(`tbody-encomienda-horario${mod}`);
    let count = $(`#container-horario-encomienda${mod} #tbody-encomienda-horario${mod} > tr[id^='horario-encomienda${mod}-id-']`).length;
    let sinInfo = document.querySelector(`#tbody-encomienda-horario${mod} tr[data-info='sinInfo']`);
    let id = count + 1;


    if (sinInfo) {
        sinInfo.remove();
    }


    if (bodyTableHorario.dataset.id == 0) {
        bodyTableHorario.innerHTML += `<tr id="horario-encomienda${mod}-id-${id}">
                                            <td align="center" class="color-td">Los ${dias} en el horario: ${desde}-${hasta}</td>
                                            <td class="color-td" align="center">
                                                <button type="button" data-id="${id}" data-dias="${dias}" data-desde="${desde}" data-hasta="${hasta}" id="horario-encomienda-editar${mod}-${id}" class="tam-btn btn btn-warning"><i class="fa fa-edit tam-icono"></i></button>'
                                                <button type="button" data-id="${id}" id="horario-encomienda-eliminar${mod}-${id}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>'
                                            </td>
                                        </tr>`;

    } else {
        id = bodyTableHorario.dataset.id
        let itemModficado = document.getElementById(`horario-encomienda${mod}-id-${id}`);
        itemModficado.innerHTML = ` <td align="center" class="color-td">Los ${dias} en el horario: ${desde}-${hasta}</td>
                                    <td class="color-td" align="center">
                                        <button type="button" data-id="${id}" data-dias="${dias}" data-desde="${desde}" data-hasta="${hasta}" id="horario-encomienda-editar${mod}-${id}" class="tam-btn btn btn-warning"><i class="fa fa-edit tam-icono"></i></button>'
                                        <button type="button" data-id="${id}" id="horario-encomienda-eliminar${mod}-${id}" class="tam-btn btn btn-danger"><i class="fa fa-trash tam-icono"></i></button>'
                                    </td>`;
    }

    modificarHorario(mod);
    eliminarHorario(mod);
    clearCheckDias(mod);

    bodyTableHorario.dataset.id = 0;

    $(`#txt-desde-horario${mod}`).val('');
    $(`#txt-hasta-horario${mod}`).val('');
    $(`#txt-hasta-horario${mod}`).attr('disabled', 'disabled');
    $(`#text-btn-añadir${mod}`).html('Añadir');

    setHorarioEncomienda(mod);
}

function modificarHorario(mod) {
    let btnsEditar = document.querySelectorAll(`#container-horario-encomienda${mod} #tbody-encomienda-horario${mod} button[id^='horario-encomienda-editar${mod}-']`);
    console.log(btnsEditar)
    btnsEditar.forEach((b) => {
        b.addEventListener('click', () => {
            let bodyTableHorario = document.getElementById(`tbody-encomienda-horario${mod}`);
            $(`#txt-desde-horario${mod}`).val(b.dataset.desde);
            $(`#txt-hasta-horario${mod}`).val(b.dataset.hasta);
            $(`#text-btn-añadir${mod}`).html('Modificar');
            ActivateCheckDias(mod, b.dataset.dias);
            bodyTableHorario.dataset.id = b.dataset.id;
            $(`#txt-hasta-horario${mod}`).removeAttr('disabled');
        });
    });
}

function eliminarHorario(mod) {
    let btnsEliminar = document.querySelectorAll(`#container-horario-encomienda${mod} #tbody-encomienda-horario${mod} button[id^='horario-encomienda-eliminar${mod}-']`);
    btnsEliminar.forEach((b) => {
        b.addEventListener('click', () => {
            let itemModficado = document.getElementById(`horario-encomienda${mod}-id-${b.dataset.id}`);
            itemModficado.remove();
            checkClearTrHorarioEncomienda(`tbody-encomienda-horario${mod}`, mod);
        });
    });
}

function clearCheckDias(mod) {
    ActivateCheckDias(mod, "lunes,martes,miercoles,jueves,viernes");
}

function ActivateCheckDias(mod, daysSplit) {

    let lunes = document.getElementById(`check-horario-encomienda${mod}-lunes`);
    let martes = document.getElementById(`check-horario-encomienda${mod}-martes`);
    let miercoles = document.getElementById(`check-horario-encomienda${mod}-miercoles`);
    let jueves = document.getElementById(`check-horario-encomienda${mod}-jueves`);
    let viernes = document.getElementById(`check-horario-encomienda${mod}-viernes`);
    let sabado = document.getElementById(`check-horario-encomienda${mod}-sabados`);
    let domingo = document.getElementById(`check-horario-encomienda${mod}-domingos`);

    lunes.checked = false;
    martes.checked = false;
    miercoles.checked = false;
    jueves.checked = false;
    viernes.checked = false;
    sabado.checked = false;
    domingo.checked = false;

    days = daysSplit.split(',');
    days.forEach(d => {
        let day = document.getElementById(`check-horario-encomienda${mod}-${d.toLowerCase().trim()}`);
        day.checked = true;
    });
}

function clearTrHorariosEncomienda(id, mod) {
    $(`#${id}`).html("<tr data-info='sinInfo'><td class='color-td' align='center' colspan='2'>No hay información disponible</td></tr>");
    let bodyTableHorario = document.getElementById(id);
    bodyTableHorario.dataset.id = 0;
    $(`#txt-desde-horario${mod}`).val('');
    $(`#txt-hasta-horario${mod}`).val('');
    $(`#txt-hasta-horario${mod}`).attr('disabled', 'disabled');
}

function checkClearTrHorarioEncomienda(id, mod) {
    let trs = document.querySelectorAll(`#${id} tr`).length;
    if (trs == 0) {
        clearTrHorariosEncomienda(id, mod);
    }
}

function setHorarioEncomienda(mod) {
    let InputhorarioEncomienda = document.getElementById(`horario-encomienda${mod}`);
    let horariosCargados = document.querySelectorAll(`#container-horario-encomienda${mod} #tbody-encomienda-horario${mod} button[id^='horario-encomienda-editar${mod}-']`);
    let data = [];
    horariosCargados.forEach(h => {
        data.push({
            dias: h.dataset.dias,
            hora_desde: h.dataset.desde,
            hora_hasta: h.dataset.hasta
        })
    });
    if ($(`#select-estado-encomienda${mod}`).val() == 'SI') {
        InputhorarioEncomienda.value = JSON.stringify(data);
    }
    else {
        InputhorarioEncomienda.value = '[]'
    }
}

DatesHorarioEncomienda('');
DatesHorarioEncomienda('-m');
btnGuardarHorarioEncomienda('');
btnGuardarHorarioEncomienda('-m');
SelectChangeHorarioEncomienda('');
SelectChangeHorarioEncomienda('-m');
/* */









