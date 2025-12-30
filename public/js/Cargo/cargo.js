$(document).ready(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $('.dropify').dropify();
    get_cargo()
    get_direcciones()
    
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
                ht += '<option value="0">Seleccione Jefatura</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.per_id + '>' + data.per_perfil + '</option>'
                })
                $("#select-jefatura-subdireccion").html(ht)
                
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS PERFILES*/


/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */
var id_jefatura = 0
$("#select-direccion-m").change(function () {
    console.log($("#select-direccion-m").val())
    var id_direccion = $("#select-direccion-m").val()
    get_jefaturas_subdirecciones_m(id_direccion)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */

/*INICIO DE FUNCON PARA LISTAR LOS PERFILES MODIFICAR*/
function get_jefaturas_subdirecciones_m(id_direccion) {
    $("#select-jefatura-subdireccion-m").html("<option value='0'>Cargando Jefaturas...</option>")
    $.ajax({
        url: '/get-jefatura-subdireccion/' + id_direccion,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Jefatura</option>'
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
    get_cargos(id_direccion,id_jefatura)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS */

function get_cargo_in() {
    $("#text-cargo").val($("#select-cargo option:selected").text());
}


/*INICIO DE FUNCON PARA LISTAR LOS CARGOS*/
/*function get_cargos(id_direccion,id_jefatura) {
    $("#select-cargo-superior").html("<option value='0'>CARGANDO CARGOS...</option>")
    $.ajax({
        url: '/get-cargo/' + id_direccion+'/'+id_jefatura,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE CARGO</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_cargo + '</option>'
                })
                $("#select-cargo-superior").html(ht)
            }
        }
    })
}*/
/*FIN DE FUNCON PARA LISTAR LOS CARGOS*/


/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS */
/*$("#select-jefatura-subdireccion-m").change(function () {
    var id_direccion = $("#select-direccion-m").val()
    var id_jefatura = $("#select-jefatura-subdireccion-m").val()
    get_cargos_m(id_direccion,id_jefatura,0)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS */

/*INICIO DE FUNCON PARA LISTAR LOS CARGOS*/
/*function get_cargos_m(id_direccion,id_jefatura,id_cargo) {
    $("#select-cargo-superior-m").html("<option value='0'>CARGANDO CARGOS...</option>")
    $.ajax({
        url: '/get-cargo/' + id_direccion+'/'+id_jefatura,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE CARGO</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_cargo + '</option>'
                })
                $("#select-cargo-superior-m").html(ht)
                $("#select-cargo-superior-m> option[value='" + id_cargo + "'] ").attr('selected', 'selected');
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS CARGOS*/


/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE ANADIR cargo */
$("#btn-añadir-cargo").click(function () {
    $("#modal-cargo").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  ANADIR cargo */

/*INICIO DE FUNCION PARA LISTAR cargoS */
function get_cargo() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar cargos")
    $.ajax({
        url: '/get-cargo',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-cargo" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Id</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Direción</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Jefatura</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Cargo</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">estado</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '				<td align="center" class="color-td">' + data.ca_id + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.dep_departamento + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.per_perfil + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.ca_cargo + '</td>'
                    if (data.ca_estado == 'A') {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-success me-1">Activo</span></td>'
                    } else if (data.ca_estado == 'I') {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-danger me-1">Inactivo</span></td>'
                    }
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button"  class="tam-btn btn btn-warning btn-modal-editar" Onclick ="get_cargos_id('+ data.ca_id +')"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button"  class="tam-btn btn btn-danger btn-modal-eliminar" onclick ="mostrar_modal_eliminar('+ data.ca_id +')"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-cargo").html(ht)
            }
            $("#table-cargo").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR cargoS */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE cargo */
$("#btn-guardar-cargo").click(function () {
    if (
        $('#select-direccion').val() == 0 &&
        $('#select-jefatura-subdireccion').val() == 0 &&
        $('#select-cargo-superior').val() == 0 &&
        $('#txt-cargo').val() == '' &&
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
    } else if ($('#txt-cargo').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo cargo esta vacio",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-guardar-cargo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
        guardar_cargos()
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE cargoS */

/*INICIO FUNCION PARA GUARDAR DE cargoS */
function guardar_cargos() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-cargo")[0]);
    $.ajax({
        url: '/registrar-cargo',
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
                    msg: "<b>Correcto:</b> cargo registrada",
                    type: "success"
                });
                $('#select-direccion').val('0')
                $('#select-jefatura-subdireccion').val('0')
                $('#txt-cargo').val('')
                $('#select-estado').val('0')
                $("#modal-cargo").modal('hide')
                $("#btn-guardar-cargo").html("<i class='fa fa-save'></i> Guardar")
                get_cargo()
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
/*FIN FUNCION PARA GUARDAR DE cargoS */

/* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR cargoS */
function mostrar_modal_eliminar(id){
    $("#txt-id-cargo").val(id)
    $("#modal-cargo-e").modal("show")
}
/* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR cargoS*/


/*INICIO FUNCION DE ELIMINAR DE CARGOS*/
function eliminar_cargos_id() {
    $("#btn-eliminar-cargo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Eliminando..</span>")
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-cargo-e")[0]);
    $.ajax({
        url: '/eliminar-cargo-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> cargo eliminada",
                    type: "success"
                });
                $("#btn-eliminar-cargo").html("<i class='fa fa-delete'></i> Eliminar")
                $("#modal-cargo-e").modal('hide')
                get_cargo()
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
function get_cargos_id(id_cargo) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");

    $.ajax({
        url: '/get-cargo-id/' + id_cargo,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {

                    $("#txt-id").val(data.ca_id)

                    $("#select-direccion-m").val(data.ca_id_direccion)
                    get_direcciones_m(data.ca_id_direccion)

                    id_jefatura = data.ca_id_jefatura

                    $("#select-jefatura-subdireccion-m").val(data.ca_id_jefatura)

                    /*$("#select-cargo-superior-m").val(data.ca_id_cargo_superior)
                    get_cargos_m(data.ca_id_direccion,data.ca_id_jefatura,data.ca_id_cargo_superior)*/

                    $("#select-estado-m").val(data.ca_estado)
                    $("#txt-cargo-m").val(data.ca_cargo)
                })
                
                $("#modal-cargo-m").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR cargoSPOR ID*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DE cargoS*/
$("#btn-modificar-cargo").click(function () {
    if (
        $('#select-direccion-m').val() == 0 &&
        $('#select-jefatura-subdireccion-m').val() == 0 &&
        $('#select-cargo-superior-m').val() == 0 &&
        $('#txt-cargo-m').val() == '' &&
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
    } else if ($('#select-cargo-superior-m').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo cargo superior",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-cargo-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo cargo esta vacio",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-modificar-cargo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Modificando..</span>")
        modificar_cargos()
    }

})
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DE cargoS*/

/*INICIO DE FUNCION PARA MODIFICAR DE cargoS POR ID */
function modificar_cargos() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-cargo-m")[0]);
    $.ajax({
        url: '/modificar-cargo',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> cargo modificado",
                    type: "success"
                });
                $('#select-dirección-m').val('0')
                $('#select-jefatura-subdireccion-m').val('0')
                $('#select-cargo-superior-m').val('0')
                $('#txt-cargo-m').val('')
                $('#select-estado-m').val('0')
                $("#modal-cargo-m").modal('hide')
                $("#btn-modificar-cargo").html("<i class='fa fa-save'></i> Modificar")
                get_cargo()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al modificar cargos",
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
/*FIN DE FUNCION PARA MODIFICAR DE cargoS POR ID */




