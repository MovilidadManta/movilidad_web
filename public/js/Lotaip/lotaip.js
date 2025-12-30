$(document).ready(function () {
    $('.dropify').dropify();
    get_lotaips()
    get_solicitudes_lotaips()
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


/*INICIO DE FUNCION PARA LISTAR LOTAIP */
function get_lotaips() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar lotaip")
    $.ajax({
        url: '/get-lotaip',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-lotaip" border="2" class="table dataTable no-footer">'
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
                    ht += '			    <td align="center" class="color-td">' + data.lo_year + '</td>'
                    ht += '				<td align="center" class="color-td">'
                    ht += '				    <a href="/admin-lotaip/' + data.lo_id + '/' + data.lo_year + '" class="  color-add-li">'
                    ht += '	                    <i class="fa fa-plus-square font-size-li color-add-li"></i>'
                    ht += '	                    <strong class="font-size-li"></strong>'
                    ht += '	                </a>'
                    ht += '				</td>'
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" id="' + data.lo_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.lo_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '             </td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-lotaip").html(ht)
                $("#table-lotaip").DataTable()

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
            $("#table-lotaip").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR LOTAIP */

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE LOTAIP */
$("#btn-añadir-lotaip").click(function () {
    //get_literale_lotaip()
    $("#tbody-table-detalle-indicador").html('')
    $("#modal-lotaip").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE LOTAIP */


/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE LOTAIP */
$("#btn-guardar-lotaip").click(function () {
    if ($("#txt-year").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-year").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo año esta vacio",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-guardar-lotaip").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Guardando..</span>")
        guardar_lotaip()
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DATOS DE LOTAIP */

/*INICIO FUNCION PARA GUARDAR LOTAIP */
function guardar_lotaip() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-lotaip")[0]);
    $.ajax({
        url: '/registrar-lotaip',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            $("#modal-lotaip").modal('hide')
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Lotaip registrado",
                    type: "success"
                });
                //$("#select-direccion").val("0")
                //$("#select-jefatura-subdireccion").val("0")
                //$("#select-indicador").val("0")
                $("#btn-guardar-lotaip").html("<i class='fa fa-save'></i> Guardar")
                get_lotaips()
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar Lotaip",
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
/*FIN FUNCION PARA GUARDAR LOTAIP*/


/**INICIO DE FUNCION PARA CONSULTAR LOS DATOS DE LOTAIP PARA MODIFICAR */
function get_lotaip_id(id_lotaip) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/get-lotaip-modificar-id/' + id_lotaip,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#txt-year-m").val(data.lo_year)
                    $('#modal-lotaip-m').modal('show')
                    $("#global-loader").addClass("none");
                    $("#global-loader").removeClass("block");
                })
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

/**FIN DE FUNCION PARA CONSULTAR LOS DATOS DE LOTAIP PARA MODIFICAR */

/*INICIO BOTON CLICK PARA MODIFICAR LOS DATOS DE LOTAIP DE CUENTAS */
$('#btn-modificar-lotaip').click(function(){
    if($('#txt-year-m').val()==''){
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    }else{
        $("#btn-modificar-lotaip").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Modificando..</span>")
        modificar_lotaip()
    }
    
})
/*INICIO BOTON CLICK PARA MODIFICAR LOS DATOS DE LOTAIP DE CUENTAS */

/*INICIO FUNCION PARA MODIFICAR LOTAIP */
function modificar_lotaip() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-lotaip-m")[0]);
    $.ajax({
        url: '/modificar-lotaip',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            $
            if (response.respuesta == 'true') {
                $("#txt-year").val("")
                $("#modal-lotaip-m").modal('hide')
                $("#btn-modificar-lotaip").html("<i class='fa fa-edit'></i> Modificar")
                get_lotaips()
                notif({
                    msg: "<b>Correcto:</b> Lotaip Modificado",
                    type: "success"
                });
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al modificar Lotaip",
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
/*FIN FUNCION PARA MODIFICAR LOTAIP*/

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR LOTAIP POR MEDIO DEL ID */
$("#btn-eliminar-lotaip").click(function () {
    $("#btn-eliminar-lotaip").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Eliminando..</span>")
    eliminar_lotaip_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR LOTAIP POR MEDIO DEL ID*/

/*INICIO FUNCION DE ELIMINAR INDICADOR POR MEDIO DEL ID*/
function eliminar_lotaip_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-lotaip")[0]);
    $.ajax({
        url: '/eliminar-lotaip-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Lotaip eliminado",
                    type: "success"
                });
                $("#modal-eliminar-lotaip").modal('hide')
                $("#btn-eliminar-lotaip").html("<i class='fa fa-times-circle'></i> Eliminar")
                get_lotaips()
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
/*FIN FUNCION DE ELIMINAR LOTAIP POR MEDIO DEL ID*/

/*INICIO DE FUNCION PARA LISTAR LOTAIP */
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
                ht += '  <table id="table-solicitud-lotaip" border="2" class="table dataTable no-footer">'
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
                    ht += '			    <td align="center" class="color-td">' + data.sl_mensaje + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.sl_telefono + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.sl_archivo + '</td>'
                    /*ht += '				<td align="center" class="color-td">'
                    ht += '				    <a href="/admin-lotaip/' + data.lo_id + '/' + data.lo_year + '" class="  color-add-li">'
                    ht += '	                    <i class="fa fa-plus-square font-size-li color-add-li"></i>'
                    ht += '	                    <strong class="font-size-li"></strong>'
                    ht += '	                </a>'
                    ht += '				</td>'*/
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" id="' + data.sl_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.sl_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
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
/*FIN DE FUNCION PARA LISTAR LOTAIP */






