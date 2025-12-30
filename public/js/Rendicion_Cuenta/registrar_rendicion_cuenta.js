$(document).ready(function () {
    $('.dropify').dropify();
    get_literal_rendicion_cuenta()
    get_literal_rendicion_cuenta_select()
})

/*INICIO DE FUNCION PARA LISTAR LOS LITERALES LITERALES DE RENDICION DE CUENTAS EN EL SELECT*/
function get_literal_rendicion_cuenta_select() {
    $("#select-literal-rendicion-cuenta").html("<option value='0'>CARGANDO LITERALES..</option>")
    $.ajax({
        url: '/get-literal-rendicion-cuenta',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE LITERAL</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.lrc_id + '>' + data.lrc_literal + '</option>'
                })
                $("#select-literal-rendicion-cuenta").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS LITERALES DE RENDICION DE CUENTAS EN EL SELECT*/

//INICIO DE CLICK PARA AGREGAR LITERAL DE LA RENDICION DE CUENTA
$("#btn-añadir-literal-rendicion-cuenta").click(function () {

    if ($('#select-fase').val() == '0' && $('#select-literal-rendicion-cuenta').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($('#select-fase').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo fase",
            position: "right",
            autohide: false
        });
    } else if ($('#select-literal-rendicion-cuenta').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo Literal",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-añadir-literal-rendicion-cuenta").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
        guardar_literal_rendicion_cuenta()
    }
})
//FIN DE CLICK PARA AGREGAR LITERAL DE LA RENDICION DE CUENTA

/*INICIO FUNCION PARA GUARDAR LITERAL DE LA RENDICION DE CUENTA*/
function guardar_literal_rendicion_cuenta() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-literal-rendicion-cuenta")[0]);
    $.ajax({
        url: '/registrar-literal-rendicion-cuenta',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Literal Rendicion Cuenta registrado",
                    type: "success"
                });
                $("#select-fase").val("0")
                $("#txt-id-literal-rendicion-cuenta").val("")
                $("#select-literal-rendicion-cuenta").val("0")
                var drEvent2 = $('#txt-ruta-archivo').dropify();
                drEvent2 = drEvent2.data('dropify');
                drEvent2.resetPreview();
                drEvent2.clearElement();
                $("#btn-añadir-literal-rendicion-cuenta").html("<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir")
                get_literal_rendicion_cuenta()
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar Rendicion de Cuenta",
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
/*FIN FUNCION PARA GUARDAR LITERAL DE LA RENDICION DE CUENTA*/

/*INICIO DE FUNCION PARA LISTAR LITERALES DE LA RENDICION DE CUENTA POR FASES */
function get_literal_rendicion_cuenta() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    var id = $("#txt-id-rendicion-cuenta").val()
    $.ajax({
        url: '/get-literal-rendicion-cuenta-id/' + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            $("#div-table-detalle-rendicion-cuenta").html("")
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-literal-rendicion_cuenta" border="2" class="table dataTable no-footer">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Fase</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Literal</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">archivo</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    if (data.rcd_id_fase == 1) {
                        ht += '			    <td align="center" class="color-td">Fase 1: Planificación y facilitación del proceso desde la asamblea ciudadana</td>'
                    } else if (data.rcd_id_fase == 2) {
                        ht += '			    <td align="center" class="color-td">Fase 2: Evaluación de la gestión y redacción del informe de la institución</td>'
                    } else if (data.rcd_id_fase == 3) {
                        ht += '			    <td align="center" class="color-td">Fase 3: Evaluación ciudadana del informe institucional</td>'
                    } else if (data.rcd_id_fase == 4) {
                        ht += '			    <td align="center" class="color-td">Fase 4: Incorporación de la opinión ciudadana, retroalimentación y seguimiento</td>'
                    } else if (data.rcd_id_fase == 5) {
                        ht += '			    <td align="center" class="color-td">Resoluciones CPCCS proceso de rendición de cuentas</td>'
                    } else if (data.rcd_id_fase == 6) {
                        ht += '			    <td align="center" class="color-td">Anexos</td>'
                    }
                    ht += '			    <td align="center" class="color-td">' + data.lrc_literal + '</td>'
                    if (data.rcd_extension_archivo == "pdf") {
                        ht += '				<td align="center" class="color-td">'
                        ht += '				    <a href="/archivos_rendicion_cuenta/' + data.rcd_ruta_archivo + '" target="_blank" class="btn pad-nu">'
                        ht += '	                    <i class="far fa-file-pdf color-icono-pdf"></i>'
                        ht += '	                    <strong class="color-btn-nuevo"></strong>'
                        ht += '	                </a>'
                        ht += '				</td>'
                    } else if (data.rcd_extension_archivo == "xlsx") {
                        ht += '				<td align="center" class="color-td">'
                        ht += '				    <a href="/archivos_rendicion_cuenta/' + data.rcd_ruta_archivo + '" target="_blank" class="btn pad-nu">'
                        ht += '	                    <i class="far fa-file-excel color-icono-excell"></i>'
                        ht += '	                    <strong class="color-btn-nuevo"></strong>'
                        ht += '	                </a>'
                        ht += '				</td>'
                    }

                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" id="' + data.rcd_id + '" onClick="edit_literal_rendicion_cuenta(' + data.rcd_id + ')" class="tam-btn btn btn-warning btn-modal-editar-literal-rendicion-cuenta"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.rcd_id + '" onClick="delete_literal_rendicion_cuenta(' + data.rcd_id + ')" class="tam-btn btn btn-danger btn-modal-eliminar-literal-rendicion-cuenta"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '             </td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-detalle-rendicion-cuenta").html(ht)
                $("#table-literal-rendicion_cuenta").DataTable()

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR LITERAL DE RENDICION DE CUENTA*/
                /*
                $(".btn-modal-eliminar-literal-rendicion-cuenta").click(function () {
                    $("#txt-id-literal-rendicion-cuenta-e").val(this.id)
                    $("#modal-eliminar-literal-rendicion-cuenta").modal("show")
                })*/
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR LITERAL DE RENDICION DE CUENTA*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR LITERAL DE RENDICION DE CUENTA*/
                /*
                $(".btn-modal-editar-literal-rendicion-cuenta").click(function () {
                    $("#txt-id-literal-rendicion-cuenta").val(this.id)
                    //get_direcciones_modificar()
                    get_literales_rendicion_cuenta_id(this.id)
                })*/
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  LITERAL DE RENDICION DE CUENTA*/
            }
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })

}
/*FIN DE FUNCION PARA LISTAR LITERALES DE LA RENDICION DE CUENTA POR FASES  */

/*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR LITERAL DE RENDICION DE CUENTA*/
function edit_literal_rendicion_cuenta(id) {
    $("#txt-id-literal-rendicion-cuenta").val(id)
    get_literales_rendicion_cuenta_id(id)
}
/*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  LITERAL DE RENDICION DE CUENTA*/

/* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR LITERAL DE RENDICION DE CUENTA*/
function delete_literal_rendicion_cuenta(id) {
    $("#txt-id-literal-rendicion-cuenta-e").val(id)
    $("#modal-eliminar-literal-rendicion-cuenta").modal("show")
}
/* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR LITERAL DE RENDICION DE CUENTA*/

/**INICIO DE FUNCION PARA CONSULTAR LOS DATOS DEL LITERAL DE LA RENDICION DE CUENTA  PARA MODIFICAR */
function get_literales_rendicion_cuenta_id(id_literal) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    //$("#tbody-table-detalle-indicador-m").html('')
    //$("#btn-modificar-indicador").html("<i class='fa fa-edit'></i> Modificar")
    $.ajax({
        url: '/get-literal-rendicion-cuenta-modificar-id/' + id_literal,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    console.log(response.data)
                    $("#select-literal-rendicion-cuenta").val(data.rcd_id_literal_rendicion_cuenta)
                    $("#select-fase").val(data.rcd_id_fase)
                    var drEvent = $('#txt-ruta-archivo').dropify(
                        {
                            defaultFile: '/archivos_rendion_cuenta/' + data.rcd_ruta_archivo
                        });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = '/archivos_rendion_cuenta/' + data.rcd_ruta_archivo;
                    drEvent.destroy();
                    drEvent.init();
                })
            }
            $("#global-loader").addClass("none");
            $("#global-loader").removeClass("block");
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

/**FIN DE FUNCION PARA CONSULTAR LOS DATOS DEL LITERAL DE LA RENDICION DE CUENTA  PARA MODIFICAR */

$("#btn-nuevo-literal-lotaip").click(function () {
    $("#txt-id-literal-rendicion-cuenta").val("")
    $("#select-literal-rendicion-cuenta").val("0")
    $("#select-fase").val("0")
    var drEvent2 = $('#txt-ruta-archivo').dropify();
    drEvent2 = drEvent2.data('dropify');
    drEvent2.resetPreview();
    drEvent2.clearElement();
    $("#btn-añadir-literal-lotaip").html("<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir")
})

$("#btn-eliminar-literal-rendicion-cuenta").click(function () {
    $("#btn-eliminar-literal-rendicion-cuenta").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Eliminando..</span>")
    eliminar_literal_rendicion_cuenta_id()
})

/*INICIO FUNCION DE ELIMINAR LITERAL DE RENDICION DE CUENTA POR MEDIO DEL ID*/
function eliminar_literal_rendicion_cuenta_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-literal-rendicion-cuenta")[0]);
    $.ajax({
        url: '/eliminar-literal-rendicion-cuenta-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == true) {
                notif({
                    msg: "<b>Correcto:</b> Literal de Rendicion de cuenta eliminado",
                    type: "success"
                });
                $("#modal-eliminar-literal-rendicion-cuenta").modal('hide')
                $("#btn-eliminar-literal-rendicion-cuenta").html("<i class='fa fa-times-circle'></i> Eliminar")
                //$("#btn-eliminar-indicador").html()
                get_literal_rendicion_cuenta()
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
/*FIN FUNCION DE ELIMINAR LITERAL DE  RENDICION DE CUENTA POR MEDIO DEL ID*/




