$(document).ready(function () {
    $('.dropify').dropify();
    get_proceso()
})

function mayus(e) {
    e.value = e.value.toUpperCase();
}

/*INICIO DE FUNCION PARA LISTAR PROCESOS */
function get_proceso() {
    $("#div-table-proceso").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Cargando..</span>")
    console.log("listar procesos")
    $("#global-loader").removeClass("none");
    $("#global-loader").addClass("block");
    $.ajax({
        url: '/get-proceso',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            var ht = ""
            ht += '  <table id="table-proceso" border="2" class="table dataTable no-footer">'
            ht += '	    <thead class="background-thead">'
            ht += '		    <tr align="center">'
            ht += '				<th align="center" class="border-bottom-0 color-th">identificador</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">jefatura</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">año</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">tipo de proceso</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">digitador</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">fecha</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">archivo</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
            ht += '			</tr>'
            ht += '		</thead>'
            ht += '		<tbody>'
            $(response.data).each(function (i, data) {
                ht += '			<tr>'
                ht += '			    <td align="center" class="color-td">' + data.pro_identificacion + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.per_perfil + '</td>'

                ht += '			    <td align="center" class="color-td">' + data.pro_year + '</td>'
                if (data.pro_id_tipo_proceso == 1) {
                    ht += '			    <td align="center" class="color-td">REVISION</td>'
                } else if (data.pro_id_tipo_proceso == 2) {
                    ht += '			    <td align="center" class="color-td">TRASPASO</td>'
                } if (data.pro_id_tipo_proceso == 3) {
                    ht += '			    <td align="center" class="color-td">CAMBIO SERVICIO</td>'
                } if (data.pro_id_tipo_proceso == 4) {
                    ht += '			    <td align="center" class="color-td">DUPLICADO</td>'
                } if (data.pro_id_tipo_proceso == 5) {
                    ht += '			    <td align="center" class="color-td">EMISION DE MATRICULA</td>'
                } if (data.pro_id_tipo_proceso == 6) {
                    ht += '			    <td align="center" class="color-td">PRIMERA VEZ</td>'
                } if (data.pro_id_tipo_proceso == 7) {
                    ht += '			    <td align="center" class="color-td">ROLES</td>'
                } if (data.pro_id_tipo_proceso == 8) {
                    ht += '			    <td align="center" class="color-td">LIQUIDACIÓN</td>'
                } if (data.pro_id_tipo_proceso == 9) {
                    ht += '			    <td align="center" class="color-td">INFORMES</td>'
                } if (data.pro_id_tipo_proceso == 10) {
                    ht += '			    <td align="center" class="color-td">MEMOS INTERNOS</td>'
                } if (data.pro_id_tipo_proceso == 11) {
                    ht += '			    <td align="center" class="color-td">COMPROBANTES INGRESOS</td>'
                } if (data.pro_id_tipo_proceso == 12) {
                    ht += '			    <td align="center" class="color-td">COMPROBANTES EGRESOS</td>'
                } if (data.pro_id_tipo_proceso == 13) {
                    ht += '			    <td align="center" class="color-td">CRUZE DE CUENTAS</td>'
                } if (data.pro_id_tipo_proceso == 14) {
                    ht += '			    <td align="center" class="color-td">DIARIO GARANTIA</td>'
                } if (data.pro_id_tipo_proceso == 15) {
                    ht += '			    <td align="center" class="color-td">DIARIO ACTIVO FIJO</td>'
                } if (data.pro_id_tipo_proceso == 16) {
                    ht += '			    <td align="center" class="color-td">DIARIO INVENTARIO</td>'
                } if (data.pro_id_tipo_proceso == 17) {
                    ht += '			    <td align="center" class="color-td">CONCILIACIONES BANCARIAS</td>'
                } if (data.pro_id_tipo_proceso == 18) {
                    ht += '			    <td align="center" class="color-td">FINANZAS</td>'
                } if (data.pro_id_tipo_proceso == 19) {
                    ht += '			    <td align="center" class="color-td">ORDENES DE PAGO</td>'
                } if (data.pro_id_tipo_proceso == 20) {
                    ht += '			    <td align="center" class="color-td">ORDENES DE CONTABILIZACIÓN</td>'
                } if (data.pro_id_tipo_proceso == 21) {
                    ht += '			    <td align="center" class="color-td">ORDENES DE TRABAJO</td>'
                } if (data.pro_id_tipo_proceso == 22) {
                    ht += '			    <td align="center" class="color-td">RESOLUCIONES DIRECTORIO</td>'
                } if (data.pro_id_tipo_proceso == 23) {
                    ht += '			    <td align="center" class="color-td">OFICIOS INTERNOS</td>'
                }

                ht += '			    <td align="center" class="color-td">' + data.emp_nombre + ' ' + data.emp_apellido + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.pro_fecha + '</td>'
                ht += '			    <td align="center" class="color-td"><a href="/descargar-archivo-proceso/' + data.pro_archivo + '" target="_blank" id="' + data.pro_id + '"><i class="far fa-file-pdf tam-pdf"></i></a></td>'
                ht += '				<td class="color-td" align="center">'
                //ht += '              <button type="button" id="' + data.pro_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                ht += '              <button type="button" id="' + data.pro_id + '-' + data.pro_archivo + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                ht += '             </td>'
                ht += '			</tr>'
            })
            ht += '		</tbody>'
            ht += '  </table>'
            $("#div-table-proceso").html(ht)
            $("#table-proceso").DataTable()

            /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR proceso */
            $(".btn-modal-eliminar").click(function () {
                var id = this.id
                var id_ = id.split('-')
                $("#txt-id-proceso").val(id_[0])
                $("#txt-archivo-anterior-e").val(id_[1])
                $("#modal-proceso-e").modal("show")
            })
            /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR proceso*/

            /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR proceso*/
            $(".btn-modal-editar").click(function () {
                $("#txt-id-proceso-m").val(this.id)
                get_procesos_id(this.id)
            })
            /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  proceso*/

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA FUNCION PARA LISTAR PROCESOS*/

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE PROCESOS */
$("#btn-añadir-proceso").click(function () {
    var session_id_jefatura = $('#session_id_jefatura').val()
    var session_id_departamento = $('#session_id_departamento').val()
    //alert(session_id_jefatura)

    get_direcciones()
    $("#modal-proceso").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE PROCESOS */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE PROCESOS */
$("#btn-guardar-proceso").click(function () {
    if ($("#txt-numero-orden").val() == "" &&
        $("#txt-identificacion").val() == "" &&
        $('#select-tipo-proceso').val('0') &&
        $('#select-direccion').val('0') &&
        $('#select-jefatura-subdireccion').val('0') &&
        $('#select-digitador').val('0') &&
        $('#txt-fecha').val('') &&
        $('#txt-descripcion').val('') &&
        $('#txt-file-proceso').val('')) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-numero-orden").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo numero de orden esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-identificacion").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo identificador esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#select-tipo-proceso").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo tipo de proceso no esta seleccionado",
            position: "right",
            autohide: false
        });
    }else if ($("#select-direccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo direccion no esta seleccionado",
            position: "right",
            autohide: false
        });
    }else if ($("#select-jefatura-subdireccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo jefatura no esta seleccionado",
            position: "right",
            autohide: false
        });
    }else if ($("#select-digitador").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo digitador no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-fecha").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo fecha esta vacio",
            position: "right",
            autohide: false
        });
    }  else if ($("#txt-descripcion").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo descripcion esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-file-proceso").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo archivo esta vacio",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-guardar-proceso").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Guardando..</span>")
        guardar_proceso()
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DATOS DE PROCESOS */


/*INICIO FUNCION PARA GUARDAR PROCESO */
function guardar_proceso() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-proceso")[0]);
    $.ajax({
        url: '/registrar-proceso',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            $("#txt-identificacion").val('')
            $("#txt-numero-orden").val('')
            $('#select-digitador').val('0')
            $('#txt-fecha').val('')
            $('#select-tipo-proceso').val('0')
            $('#txt-descripcion').val('')
            var drEvent2 = $('#txt-file-proceso').dropify();
            drEvent2 = drEvent2.data('dropify');
            drEvent2.resetPreview();
            drEvent2.clearElement();
            $("#modal-proceso").modal('hide')
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> proceso registrado",
                    type: "success"
                });
                //$("#select-direccion").val("0")
                //$("#select-jefatura-subdireccion").val("0")
                //$("#select-indicador").val("0")
                $("#btn-guardar-proceso").html("<i class='fa fa-save'></i> Guardar")
                get_proceso()
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar proceso",
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
/*FIN FUNCION PARA GUARDAR PROCESO*/


/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE PROCESO */
$("#btn-eliminar-proceso").click(function () {
    $("#btn-eliminar-proceso").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Eliminando..</span>")
    eliminar_procesos_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE PROCESO*/

/*INICIO FUNCION DE ELIMINAR DE PROCESO*/
function eliminar_procesos_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-proceso-e")[0]);
    $.ajax({
        url: '/eliminar-proceso-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Proceso eliminada",
                    type: "success"
                });
                $("#btn-eliminar-proceso").html("<i class='fa fa-delete'></i> Eliminar")
                $("#modal-proceso-e").modal('hide')
                get_proceso()
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
/*FIN FUNCION DE ELIMINAR DE PROCESO*/
/*INICIO DE FUNCION PARA LISTAR LOS DEPARTAMENTOS EN EL SELECT*/
function get_direcciones() {
    $("#select-direccion").html("<option value='0'>CARGANDO DIRECCIONES..</option>")
    $.ajax({
        url: '/get-direccion',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE DIRECCIÓN</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.dep_id + '>' + data.dep_departamento + '</option>'
                })
                $("#select-direccion").html(ht)
                var session_id_jefatura = $('#session_id_jefatura').val()
                if (session_id_jefatura == 13 || session_id_jefatura == 17 || session_id_jefatura == 6) {
                    document.getElementById("select-direccion").disabled = true;
                    document.getElementById("select-jefatura-subdireccion").disabled = true;
                    document.getElementById("select-digitador").disabled = true;
                    $("#select-direccion").val($('#session_id_departamento').val())
                    $("#select-direccion> option[value='" + $('#session_id_departamento').val() + "'] ").attr('selected', 'selected');
                    $("#select-direccion").change()
                }
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS DEPARTAMENTOS EN EL SELECT*/

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */
$("#select-direccion").change(function () {
    console.log($("#select-direccion").val())
    var id_direccion = $("#select-direccion").val()
    get_jefaturas_subdirecciones(id_direccion)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */

/*INICIO DE FUNCON PARA LISTAR LOS PERFILES*/
function get_jefaturas_subdirecciones(id_direccion) {
    $("#select-jefatura-subdireccion").html("<option value='0'>CARGANDO JEFATURAS...</option>")
    $.ajax({
        url: '/get-jefatura-subdireccion/' + id_direccion,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE JEFATURA</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.per_id + '>' + data.per_perfil + '</option>'
                })
                $("#select-jefatura-subdireccion").html(ht)
                var session_id_jefatura = $('#session_id_jefatura').val()
                if (session_id_jefatura == 13 || session_id_jefatura == 17 || session_id_jefatura == 6) {
                    document.getElementById("select-direccion").disabled = true;
                    document.getElementById("select-jefatura-subdireccion").disabled = true;
                    document.getElementById("select-digitador").disabled = true;
                    $("#select-jefatura-subdireccion").val($('#session_id_jefatura').val())
                    $("#select-jefatura-subdireccion> option[value='" + $('#session_id_jefatura').val() + "'] ").attr('selected', 'selected');
                    $("#select-jefatura-subdireccion").change()
                }
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS PERFILES*/

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS EMPLEADOS CON LAS JEFATURAS DE ACUERDO A LA DIRECCION */
$("#select-jefatura-subdireccion").change(function () {
    var id_direccion = $("#select-jefatura-subdireccion").val()
    get_digitadores_id_direccion(id_direccion)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS EMPLEADOS CON LAS JEFATURAS DE ACUERDO A LA DIRECCION */

/*INICIO DE FUNCON PARA LISTAR LOS PERFILES*/
function get_digitadores_id_direccion(id_direccion) {
    $("#select-digitador").html("<option value='0'>CARGANDO DIGITADORES...</option>")
    $.ajax({
        url: '/get-empleado-jefatura-subdireccion/' + id_direccion,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE DIGITADOR</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.emp_id + '>' + data.emp_nombre + ' ' + data.emp_apellido + '</option>'
                })
                $("#select-digitador").html(ht)
                var session_id_jefatura = $('#session_id_jefatura').val()
                if (session_id_jefatura == 13 || session_id_jefatura == 17) {
                    document.getElementById("select-direccion").disabled = true;
                    document.getElementById("select-jefatura-subdireccion").disabled = true;
                    document.getElementById("select-digitador").disabled = true;
                    $("#select-digitador").val($('#session_id_empleado').val())
                    $("#select-digitador> option[value='" + $('#session_id_empleado').val() + "'] ").attr('selected', 'selected');

                } else if (session_id_jefatura == 6) {
                    document.getElementById("select-digitador").disabled = false;
                }
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS PERFILES*/
