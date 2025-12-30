$(document).ready(function () {
    get_rendicion_cuenta()
})

function mayus(e) {
    e.value = e.value.toUpperCase();
}

var id_perfil = ""
var id_ind = ""
var id_jefatura_subdireccion = ""
var id_ti_ind = ""

/*INICIO DE FUNCION PARA LISTAR LOS LITERALES DE LOTAIP EN EL SELECT*/
function get_literale_lotaip() {
    $("#select-literal-lotaip").html("<option value='0'>CARGANDO LITERALES..</option>")
    $.ajax({
        url: '/get-literal-lotaip',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE LITERAL</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.li_id + '>' + data.li_literal + '</option>'
                })
                $("#select-literal-lotaip").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS LITERALES DE LOTAIP EN EL SELECT*/


/*INICIO DE FUNCION PARA LISTAR RENDICION DE CUENTA */
function get_rendicion_cuenta() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/get-rendicion-cuenta',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.respuesta)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-rendicion-cuenta" border="2" class="table dataTable no-footer">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Año</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Literales</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '			    <td align="center" class="color-td">' + data.rc_year + '</td>'
                    ht += '				<td align="center" class="color-td">'
                    ht += '				    <a href="/admin-literal-rendicion-cuenta/' + data.rc_id + '/' + data.rc_year + '" class="  color-add-li">'
                    ht += '	                    <i class="fa fa-plus-square font-size-li color-add-li"></i>'
                    ht += '	                    <strong class="font-size-li"></strong>'
                    ht += '	                </a>'
                    ht += '				</td>'
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" id="' + data.rc_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.rc_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '             </td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-rendicion-cuenta").html(ht)
                $("#table-rendicion-cuenta").DataTable()

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR RENDICION DE CUENTA */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-rendicion-cuenta").val(this.id)
                    $("#modal-eliminar-rendicion-cuenta").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR RENDICION DE CUENTA*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR RENDICION DE CUENTAS*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-rendicion-cuenta-m").val(this.id)
                    //get_direcciones_modificar()
                    get_rendicion_cuenta_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  RENDICION DE CUENTAS*/

            }
            $("#table-lotaip").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR  LISTAR RENDICION DE CUENTA */

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE RENDICION DE CUENTAS */
$("#btn-modal-rendicion-cuenta").click(function () {
    //get_literale_lotaip()
    $("#modal-rendicion-cuenta").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE RENDICION DE CUENTAS */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE RENDICION DE CUENTAS */
$("#btn-guardar-rendicion-cuenta").click(function () {
    
    if ($('#txt-year').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-guardar-rendicion-cuenta").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Guardando..</span>")
        guardar_rendicion_cuenta()
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DATOS DE RENDICION DE CUENTAS */

/*INICIO FUNCION PARA GUARDAR RENDICION DE CUENTAS */
function guardar_rendicion_cuenta() {
    $("#btn-guardar-rendicion-cuenta").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Guardando..</span>")
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-rendicion-cuenta")[0]);
    $.ajax({
        url: '/registrar-rendicion-cuenta',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            $("#modal-rendicion-cuenta").modal('hide')
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Año de Rendicion de Cuenta registrado",
                    type: "success"
                });
                $("#txt-year").val("")
                //$("#select-jefatura-subdireccion").val("0")
                //$("#select-indicador").val("0")
                $("#btn-guardar-rendicion-cuenta").html("<i class='fa fa-save'></i> Guardar")
                get_rendicion_cuenta()
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar Año de Rendicion de Cuenta",
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
/*FIN FUNCION PARA GUARDAR RENDICION DE CUENTAS*/

/**INICIO DE FUNCION PARA CONSULTAR LOS DATOS DEL RENDICION DE CUENTAS POR ID PARA MODIFICAR */
function get_rendicion_cuenta_id(id_rendicion_cuenta) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $("#tbody-table-detalle-indicador-m").html('')
    $("#btn-modificar-rendicion-cuenta").html("<i class='fa fa-edit'></i> Modificar")
    console.log("listar empleado")
    $.ajax({
        url: '/get-rendicion-cuenta-modificar-id/' + id_rendicion_cuenta,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#txt-year-m").val(data.rc_year)
                })
                $("#modal-rendicion-cuenta-m").modal('show')
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
/**FIN DE FUNCION PARA CONSULTAR LOS DATOS DEL RENDICION DE CUENTAS POR ID PARA MODIFICAR */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE RENDICION DE CUENTAS */
$("#btn-modificar-rendicion-cuenta").click(function () {
    $("#btn-modificar-rendicion-cuenta").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Modificando..</span>")
    if ($('#txt-year').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else {
        modificar_rendicion_cuenta()
    }
})
/*FIN BOTON CLICK PARA MODIFICAR LOS DATOS DATOS DE RENDICION DE CUENTAS */

/*INICIO FUNCION PARA MODIFICAR RENDICION DE CUENTAS */
function modificar_rendicion_cuenta() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-modificar-rendicion-cuenta-m")[0]);
    $.ajax({
        url: '/modificar-rendicion-cuenta',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            $("#modal-rendicion-cuenta-m").modal('hide')
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Año de Rendicion de Cuenta Modificado",
                    type: "success"
                });
                $("#txt-year-m").val("")

                $("#btn-modificar-rendicion-cuenta").html("<i class='fa fa-edit'></i> Modificar")
                get_rendicion_cuenta()
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar Año de Rendicion de Cuenta",
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
/*FIN FUNCION PARA MODIFICAR RENDICION DE CUENTAS*/

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR RENDICION DE CUENTA POR MEDIO DEL ID */
$("#btn-eliminar-rendicion-cuenta").click(function () {
    $("#btn-eliminar-rendicion-cuenta").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Eliminando..</span>")
    eliminar_rendicion_cuenta_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR RENDICION DE CUENTA POR MEDIO DEL ID*/

/*INICIO FUNCION DE ELIMINAR RENDICION DE CUENTA POR MEDIO DEL ID*/
function eliminar_rendicion_cuenta_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-rendicion-cuenta")[0]);
    $.ajax({
        url: '/eliminar-rendicion-cuenta-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Año de Rendicion de Cuenta eliminado",
                    type: "success"
                });
                $("#modal-eliminar-rendicion-cuenta").modal('hide')
                $("#btn-eliminar-rendicion-cuenta").html("<i class='fa fa-times-circle'></i> Eliminar")
                //$("#btn-eliminar-indicador").html()
                get_rendicion_cuenta()
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
/*FIN FUNCION DE ELIMINAR RENDICION DE CUENTA POR MEDIO DEL ID*/






