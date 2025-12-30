$(document).ready(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $('.dropify').dropify();
    get_organigrama()
})
//$("#global-loader").addClass("none");
//$("#global-loader").removeClass("block");

/*INICIO DE FUNCION PARA LISTAR LOS DEPARTAMENTOS EN EL SELECT*/
function get_direcciones() {
    $("#select-direccion").html("<option value='0'>Cargando direcciones..</option>")
    $.ajax({
        url: '/get-direccion',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Dirección</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.dep_id + '>' + data.dep_departamento + '</option>'
                })
                $("#select-direccion").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS DEPARTAMENTOS EN EL SELECT*/

/*INICIO DE FUNCION PARA LISTAR LOS DEPARTAMENTOS EN EL SELECT MODIFICAR*/
function get_direcciones_m(id_direc) {
    $("#select-direccion-m").html("<option value='0'>Cargando direcciones..</option>")
    $.ajax({
        url: '/get-direccion',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Dirección</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.dep_id + '>' + data.dep_departamento + '</option>'
                })
                $("#select-direccion-m").html(ht)
                $("#select-direccion-m> option[value='" + id_direc + "'] ").attr('selected', 'selected');
                $("#select-direccion-m").change()
            }
        }
    })

}
/*FIN DE FUNCON PARA LISTAR LOS DEPARTAMENTOS EN EL SELECT MODIFICAR*/

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */
$("#select-direccion").change(function () {
    console.log($("#select-direccion").val())
    var id_direccion = $("#select-direccion").val()
    get_jefaturas_subdirecciones(id_direccion)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */

/*INICIO DE FUNCON PARA LISTAR LOS PERFILES*/
function get_jefaturas_subdirecciones(id_direccion) {
    $("#select-jefatura-subdireccion").html("<option value='0'>Cargando Jefaturas...</option>")
    $.ajax({
        url: '/get-jefatura-subdireccion/' + id_direccion,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Jefaturas</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.per_id + '>' + data.per_perfil + '</option>'
                })
                $("#select-jefatura-subdireccion").html(ht)

            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS PERFILES*/


/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION*/
$("#select-direccion-m").change(function () {
    console.log($("#select-direccion-m").val())
    var id_direccion = $("#select-direccion-m").val()
    get_jefaturas_subdirecciones_m(id_direccion)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */

/*INICIO DE FUNCON PARA LISTAR LOS PERFILES MODIFICAR*/
var id_jefatura = 0
function get_jefaturas_subdirecciones_m(id_direccion) {
    $("#select-jefatura-subdireccion-m").html("<option value='0'>Cargando Jefaturas...</option>")
    //var id_jefatura = $("#select-jefatura-subdireccion-m").val()
    //alert(id_jefatura)
    $.ajax({
        url: '/get-jefatura-subdireccion/' + id_direccion,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Jefaturas</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.per_id + '>' + data.per_perfil + '</option>'
                })
                $("#select-jefatura-subdireccion-m").html(ht)
                $("#select-jefatura-subdireccion-m> option[value='" + id_jefatura + "'] ").attr('selected', 'selected');
                $("#select-jefatura-subdireccion-m").change()
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS PERFILES MODIFICAR*/

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS */
$("#select-jefatura-subdireccion").change(function () {
    console.log($("#select-jefatura-subdireccion").val())
    var id_direccion = $("#select-direccion").val()
    var id_jefatura = $("#select-jefatura-subdireccion").val()
    get_cargos(id_direccion, id_jefatura)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS */

function get_organigrama_in() {
    $("#text-organigrama").val($("#select-organigrama option:selected").text());
}
/*INICIO DE FUNCON PARA LISTAR LOS CARGOS*/
function get_cargos(id_direccion, id_jefatura) {
    $("#select-cargo").html("<option value='0'>Cargando cargos...</option>")
    $.ajax({
        url: '/get-cargo/' + id_direccion + '/' + id_jefatura,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione cargo</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_cargo + '</option>'
                })
                $("#select-cargo").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS CARGOS*/

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS */
$("#select-jefatura-subdireccion-m").change(function () {
    var id_direccion = $("#select-direccion-m").val()
    var id_jefatura = $("#select-jefatura-subdireccion-m").val()
    get_cargos_m(id_direccion, id_jefatura)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS */

/*INICIO DE FUNCON PARA LISTAR LOS CARGOS*/
var id_cargo = 0
function get_cargos_m(id_direccion, id_jefatura) {
    $("#select-cargo-m").html("<option value='0'>Cargando cargos...</option>")
    $.ajax({
        url: '/get-cargo/' + id_direccion + '/' + id_jefatura,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione cargo</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_cargo + '</option>'
                })
                $("#select-cargo-m").html(ht)
                $("#select-cargo-m> option[value='" + id_cargo + "'] ").attr('selected', 'selected');
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS CARGOS*/


/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE ANADIR organigrama */
$("#btn-añadir-organigrama").click(function () {
    get_direcciones()
    $("#modal-organigrama").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  ANADIR organigrama */

/*INICIO DE FUNCION PARA LISTAR organigramaS */
function get_organigrama() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar organigramas")
    $.ajax({
        url: '/get-organigrama',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-organigrama" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Id</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Direción</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Jefatura</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Cargo</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Nivel</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Año</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Descripción</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">estado</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '				<td align="center" class="color-td">' + data.eo_id + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.dep_departamento + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.per_perfil + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.ca_cargo + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.eo_nivel + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.eo_year + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.eo_descripcion + '</td>'
                    if (data.eo_estado == '1') {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-success me-1">Activo</span></td>'
                    } else if (data.eo_estado == '0' || data.eo_estado == '2') {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-danger me-1">Inactivo</span></td>'
                    }
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ="get_organigramas_id(' + data.eo_id + ')"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" onclick ="mostrar_modal_eliminar(' + data.eo_id + ')"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-organigrama").html(ht)
            }
            $("#table-organigrama").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR organigramaS */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE organigrama */
$("#btn-guardar-organigrama").click(function () {
    if (
        $('#select-direccion').val() == 0 &&
        $('#select-jefatura-subdireccion').val() == 0 &&
        $('#select-cargo').val() == 0 &&
        $('#select-nivel').val() == 0 &&
        $('#txt-descripcion').val() == '' &&
        $('#select-estado').val() == '0'
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($('#select-direccion').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo dirección",
            position: "right",
            autohide: false
        });
    } else if ($('#select-jefatura-subdireccion').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo Jefatura",
            position: "right",
            autohide: false
        });
    } else if ($('#select-cargo').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo cargo",
            position: "right",
            autohide: false
        });
    } else if ($('#select-nivel').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo nivel",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-descripcion').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo organigrama esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($('#select-estado').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Estado esta vació",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-guardar-organigrama").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
        guardar_organigramas()
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE organigramaS */

/*INICIO FUNCION PARA GUARDAR DE organigramaS */
function guardar_organigramas() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-organigrama")[0]);
    $.ajax({
        url: '/admin-registrar-organigrama',
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
                    msg: "<b>Correcto:</b> Estructura Organica registrada",
                    type: "success"
                });
                $('#select-dirección').val('0')
                $('#select-jefatura-subdireccion').val('0')
                $('#select-cargo').val('0')
                $('#select-nivel').val('0')
                $('#txt-descripcion').val('')
                $('#select-estado').val('0')
                $("#modal-organigrama").modal('hide')
                $("#btn-guardar-organigrama").html("<i class='fa fa-save'></i> Guardar")
                get_organigrama()
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
/*FIN FUNCION PARA GUARDAR DE organigramaS */

/* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR organigramaS */
function mostrar_modal_eliminar(id) {
    $("#txt-id-organigrama").val(id)
    $("#modal-organigrama-e").modal("show")
}
/* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR organigramaS*/


/*INICIO FUNCION DE ELIMINAR DE CARGOS*/
function eliminar_organigramas_id() {
    $("#btn-eliminar-organigrama").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Eliminando..</span>")
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-organigrama-e")[0]);
    $.ajax({
        url: '/eliminar-organigrama-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> organigrama eliminada",
                    type: "success"
                });
                $("#btn-eliminar-organigrama").html("<i class='fa fa-delete'></i> Eliminar")
                $("#modal-organigrama-e").modal('hide')
                get_organigrama()
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
/*FIN FUNCION DE ELIMINAR DE CARGOS*/


/*INICIO PARA FUNCION CONSULTAR CARGOS POR ID*/
function get_organigramas_id(id_organigrama) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");

    $.ajax({
        url: '/get-organigrama-id/' + id_organigrama,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {

                    $("#txt-id-organigrama-m").val(data.eo_id)

                    $("#select-direccion-m").val(data.eo_id_direccion)
                    get_direcciones_m(data.eo_id_direccion)
                    //$("#select-direccion-m").change()

                    id_jefatura = data.eo_id_jefatura
                    $("#select-jefatura-subdireccion-m").val(data.eo_id_jefatura)

                    id_cargo = data.eo_id_cargo
                    $("#select-cargo-m").val(data.eo_id_cargo)
                    // get_cargos_m(data.eo_id_direccion,data.eo_id_jefatura,data.eo_id_cargo)

                    $("#select-estado-m").val(data.eo_estado)
                    $("#select-nivel-m").val(data.eo_nivel)
                    $("#txt-descripcion-m").val(data.eo_descripcion)
                })

                $("#modal-organigrama-m").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR organigramaSPOR ID*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DE organigramaS*/
$("#btn-modificar-organigrama").click(function () {
    if (
        $('#select-direccion-m').val() == 0 &&
        $('#select-jefatura-subdireccion-m').val() == 0 &&
        $('#select-organigrama-superior-m').val() == 0 &&
        $('#txt-organigrama-m').val() == '' &&
        $('#select-estado-m').val() == '0'
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($('#select-direccion-m').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo dirección",
            position: "right",
            autohide: false
        });
    } else if ($('#select-jefatura-subdireccion-m').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo Jefatura",
            position: "right",
            autohide: false
        });
    } else if ($('#select-organigrama-superior-m').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo organigrama superior",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-organigrama-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo organigrama esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($('#select-estado-m').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Estado esta vació",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-modificar-organigrama").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Modificando..</span>")
        modificar_organigramas()
    }

})
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DE organigramaS*/

/*INICIO DE FUNCION PARA MODIFICAR DE organigramaS POR ID */
function modificar_organigramas() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-organigrama-m")[0]);
    $.ajax({
        url: '/admin-modificar-organigrama',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> organigrama modificado",
                    type: "success"
                });
                $('#select-dirección-m').val('0')
                $('#select-jefatura-subdireccion-m').val('0')
                $('#select-organigrama-superior-m').val('0')
                $('#txt-organigrama-m').val('')
                $('#select-estado-m').val('0')
                $("#modal-organigrama-m").modal('hide')
                $("#btn-modificar-organigrama").html("<i class='fa fa-save'></i> Modificar")
                get_organigrama()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al modificar organigramas",
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
/*FIN DE FUNCION PARA MODIFICAR DE organigramaS POR ID */




