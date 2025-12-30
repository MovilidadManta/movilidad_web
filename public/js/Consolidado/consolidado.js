$(document).ready(function () {
    get_indicadores()
    //get_perfiles()

})
function mayus(e) {
    e.value = e.value.toUpperCase();
}

var id_perfil = ""
var id_ind = ""
var id_jefatura_subdireccion = ""
var id_ti_ind = ""

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
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS DEPARTAMENTOS EN EL SELECT*/

/*INICIO DE FUNCION PARA LISTAR LAS DIRECCIONES DE MODIFICAR EN EL SELECT*/
function get_direcciones_modificar() {
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
                $("#select-direccion-m").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS DIRECCIONES DE MODIFICAR EN EL SELECT*/


/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */
$("#select-direccion").change(function () {
    console.log($("#select-direccion").val())
    var id_direccion = $("#select-direccion").val()
    get_jefaturas_subdirecciones(id_direccion)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */
$("#select-direccion-m").change(function () {
    console.log($("#select-direccion-m").val())
    var id_direccion = $("#select-direccion-m").val()
    get_jefaturas_subdirecciones_modificar(id_direccion)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */

/*INICIO DE FUNCION PARA LISTAR INDICADORES */
function get_indicadores() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar indicadores")
    $.ajax({
        url: '/get-indicador',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-indicador" border="2" class="table dataTable no-footer">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Año</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Mes</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Indicador</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">detalle</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">fecha</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">total</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '			    <td align="center" class="color-td">' + data.con_year + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.con_mes + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.in_indicador + '</td>'
                    ht += '				<td class="color-td" align="center">'
                    ht += '                 <button type="button" id="' + data.con_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-list tam-icono"></i></button>'
                    ht += '             </td>'
                    ht += '				<td align="center" class="color-td">' + data.con_fecha + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.con_total + '</td>'
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" id="' + data.con_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.con_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '             </td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-indicador").html(ht)
                $("#table-indicador").DataTable()

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR NOSOTROS (MISION Y VISION) */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-indicador").val(this.id)
                    $("#modal-eliminar-indicador").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR NOSOTROS (MISION Y VISION)*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR NOSOTROS (MISION Y VISION)*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-indicador-m").val(this.id)
                    get_direcciones_modificar()
                    get_indicadores_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  NOSOTROS (MISION Y VISION)*/

            }
            $("#table-nosotro").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR INDICADORES */

/*INICIO DE FUNCON PARA LISTAR LAS JEFATURAS*/
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
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS JEFATURAS*/

/*INICIO DE FUNCON PARA LISTAR LAS JEFATURAS DE MODIFICAR*/
function get_jefaturas_subdirecciones_modificar(id_direccion) {
    $("#select-jefatura-subdireccion-m").html("<option value='0'>CARGANDO JEFATURAS...</option>")
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
                $("#select-jefatura-subdireccion-m").html(ht)
                $("#select-jefatura-subdireccion-m> option[value='" + id_perfil + "'] ").attr('selected', 'selected');
                $("#select-jefatura-subdireccion-m").change()
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS JEFATURAS DE MODIFICAR*/

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA DE LOS INDICADORES DE ACUERDO A LAS JEFATURAS*/
$("#select-jefatura-subdireccion").change(function () {
    console.log($("#select-jefatura-subdireccion").val())
    var id = $("#select-jefatura-subdireccion").val()
    get_indicadores_select(id)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA DE LOS INDICADORES DE ACUERDO A LAS JEFATURAS */

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA DE LOS INDICADORES DE ACUERDO A LAS JEFATURAS PARAA MODIFICAR*/
$("#select-jefatura-subdireccion-m").change(function () {
    console.log(id_jefatura_subdireccion)
    var id = $("#select-jefatura-subdireccion-m").val()
    get_indicadores_select_modificar(id)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA DE LOS INDICADORES DE ACUERDO A LAS JEFATURAS PARAA MODIFICAR */


/*INICIO DE FUNCON PARA LISTAR INDICADORES DE ACUERDO A LA JEFATURA*/
function get_indicadores_select(id_jefatura) {
    $("#select-indicador").html("<option value='0'>CARGANDO INDICADORES...</option>")
    $.ajax({
        url: '/get-indicador-id/' + id_jefatura,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE INDICADOR</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.in_id + '>' + data.in_indicador + '</option>'
                })
                $("#select-indicador").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR INDICADORES DE ACUERDO A LA JEFATURA*/

/*INICIO DE FUNCON PARA LISTAR INDICADORES DE ACUERDO A LA JEFATURA*/
function get_indicadores_select_modificar(id_jefatura) {
    $("#select-indicador-m").html("<option value='0'>CARGANDO INDICADORES...</option>")
    $.ajax({
        url: '/get-indicador-id/' + id_jefatura,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE INDICADOR</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.in_id + '>' + data.in_indicador + '</option>'
                })
                $("#select-indicador-m").html(ht)
                $("#select-indicador-m> option[value='" + id_ind + "'] ").attr('selected', 'selected');
                $("#select-indicador-m").change()
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR INDICADORES DE ACUERDO A LA JEFATURA*/


/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA DE LOS INDICADORES DE ACUERDO A LAS JEFATURAS*/
$("#select-indicador").change(function () {
    console.log($("#select-indicador").val())
    var id_ = $("#select-indicador").val()
    get_indicadores_detalle_select(id_)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA DE LOS INDICADORES DE ACUERDO A LAS JEFATURAS */

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA DE LOS INDICADORES DE ACUERDO A LAS JEFATURAS PARA MODIFICAR*/
$("#select-indicador-m").change(function () {
    console.log($("#select-indicador-m").val())
    var id_ = $("#select-indicador-m").val()
    id_ti_ind = id_
    get_indicadores_detalle_select_modificar(id_)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA DE LOS INDICADORES DE ACUERDO A LAS JEFATURAS  PARA MODIFICAR*/

/*INICIO DE FUNCON PARA LISTAR INDICADORES DE ACUERDO AL INDICADOR*/
function get_indicadores_detalle_select(id_indicador) {
    $("#select-tipo-indicador").html("<option value='0'>CARGANDO TIPO...</option>")
    $.ajax({
        url: '/get-tipo-indicador-id/' + id_indicador,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE TIPO INDICADOR</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ti_id + '>' + data.ti_tipo_indicador + '</option>'
                })
                $("#select-tipo-indicador").html(ht)
                $("#div-table-detalle-indicador").addClass('block')
                $("#div-table-detalle-indicador").removeClass('none')
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR INDICADORES DE ACUERDO AL INDICADOR*/

/*INICIO DE FUNCON PARA LISTAR INDICADORES DE ACUERDO AL INDICADOR PARA MODIFICAR*/
function get_indicadores_detalle_select_modificar(id_indicador) {
    $("#select-tipo-indicador-m").html("<option value='0'>CARGANDO TIPO...</option>")
    $.ajax({
        url: '/get-tipo-indicador-id/' + id_indicador,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE TIPO INDICADOR</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ti_id + '>' + data.ti_tipo_indicador + '</option>'
                })
                $("#select-tipo-indicador-m").html(ht)
                //$("#select-tipo-indicador-m> option[value='" + id_ti_ind + "'] ").attr('selected', 'selected');
                $("#div-table-detalle-indicador-m").addClass('block')
                $("#div-table-detalle-indicador-m").removeClass('none')
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
                $("#modal-modificar-indicador").modal('show')
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR INDICADORES DE ACUERDO AL INDICADOR PARA MODIFICAR*/



/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE CONSOLIDADO */
$("#btn-añadir-consolidado").click(function () {
    get_direcciones()
    $("#tbody-table-detalle-indicador").html('')
    $("#modal-indicador").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE CONSOLIDADO */

/*INICIO CLICK AL BOTON AÑADIR PARA AÑADIR EL INDICADOR A LA TABLA */
$("#btn-añadir-indicador").click(function () {
    var t = document.getElementById("select-tipo-indicador");
    var selectedText = t.options[t.selectedIndex].text;

    console.log("indocadr")
    var id_prioridad = 1
    var ht = ''
    ht += '		    <tr align="center" id="' + $("#select-tipo-indicador").val() + '" class="tipo-indicador">'
    ht += '				<td align="center"  class="border-bottom-0 border ">' + selectedText + ''
    ht += '	                <input type="hidden" id="txt-indicador-' + $("#select-tipo-indicador").val() + '" value="' + $("#select-tipo-indicador").val() + '">'
    ht += '	            </td>'
    ht += '				<td align="center"  class="border-bottom-0 border">' + $("#txt-valor").val() + ''
    ht += '	                <input type="hidden"id="txt-valor-' + $("#select-tipo-indicador").val() + '" value="' + $("#txt-valor").val() + '">'
    ht += '             </td>'
    ht += '			    <td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
    ht += '			</tr>'
    $("#tbody-table-detalle-indicador").append(ht)
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
    $("#select-tipo-indicador").val('0')
    $("#txt-valor").val('')
})
/*FIN CLICK AL BOTON AÑADIR PARA AÑADIR EL INDICADOR A LA TABLA */


/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE INDICADORES */
$("#btn-guardar-indicador").click(function () {
    /*if (
        $("#txt-cedula").val() == "" &&
        $("#txt-nombre").val() == "" &&
        $("#txt-apellido").val() == "" &&
        $("#txt-telefono").val() == "" &&
        $("#select-sexo").val() == "0" &&
        $("#txt-fecha-nacimiento").val() == '' &&
        $("#txt-edad").val() == "" &&
        $("#txt-direccion-domicilio").val() == "" &&
        $("#select-direccion").val() == "0" &&
        $("#select-jefatura-subdireccion").val() == "0" &&
        $("#txt-cargo").val() == "" &&
        $("#select-regimen-contrato").val() == "0" &&
        $("#select-tipo-contrato").val() == "0" &&
        $("#txt-remuneracion").val() == "" &&
        $("#txt-fecha-ingreso").val() == "" &&
        $("#txt-fecha-salida").val() == "" &&
        $("#txt-observacion").val() == ""
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-cedula").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo cedula esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-nombre").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo nombre esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-apellido").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo apellido esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-telefono").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo telefono esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#select-sexo").val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo sexo no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-fecha-nacimiento").val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo fecha de nacimiento esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-edad").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo edad esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-direccion-domicilio").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo domicilio esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#select-direccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo direccion no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#select-direccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo direccion no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#select-jefatura-subdireccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo jefatura no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-cargo").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo cargo esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#select-regimen-contrato").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo regimen no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#select-tipo-contrato").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo mosalidad contractual no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-remuneracion").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo remuneracion esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-fecha-ingreso").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo fecha no esta seleccionada",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-observacion").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo observacion esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-titulo").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo titulo esta vacio",
            position: "right",
            autohide: false
        });
    } else {*/
    $("#btn-guardar-indicador").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Guardando..</span>")

    var id_tipo_indicador = []
    $('.tipo-indicador').each(function () {
        id_tipo_indicador.push($(this).attr("id"))
    })
    console.log('id: ' + id_tipo_indicador)

    n = id_tipo_indicador.length

    var indicador = []
    for (var i = 0; i < n; i++) {
        var indicador_ = {
            'id_id_tipo_detalle': $("#txt-indicador-" + id_tipo_indicador[i]).val(),
            'valor': $("#txt-valor-" + id_tipo_indicador[i]).val()
        }
        indicador.push(indicador_)
    }

    var data_indicadores = JSON.stringify(indicador)
    console.log('indicadores' + data_indicadores)
    $("#txt-json-indicador").val(data_indicadores)
    //guardar_empleado()
    //}
    guardar_indicador()
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DATOS DE INDICADORES */

/*INICIO FUNCION PARA GUARDAR INDICADOR */
function guardar_indicador() {
    
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-indicador")[0]);
    $.ajax({
        url: '/registrar-indicador',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            //$("#modal-indicador").modal('hide')
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Indicador registrado",
                    type: "success"
                });
                //$("#select-direccion").val("0")
                //$("#select-jefatura-subdireccion").val("0")
                //$("#select-indicador").val("0")
                $("#div-table-detalle-indicador").val("")

                $("#tbody-table-detalle-indicador").html('')
                $("#btn-guardar-indicador").html("<i class='fa fa-save'></i> Guardar")
                get_indicadores()
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar Indicador",
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
/*FIN FUNCION PARA GUARDAR INDICADOR*/

/**INICIO DE FUNCION PARA CONSULTAR LOS DATOS DEL INDICADOR  PARA MODIFICAR */
function get_indicadores_id(id_indicador) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $("#tbody-table-detalle-indicador-m").html('')
    $("#btn-modificar-indicador").html("<i class='fa fa-edit'></i> Modificar")
    console.log("listar empleado")
    $.ajax({
        url: '/get-indicador-modificar-id/' + id_indicador,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#select-direccion-m").val(data.in_id_direccion)
                    $("#select-jefatura-subdireccion-m").val(data.in_id_jefatura_subdireccion)
                    $("#select-indicador-m").val(data.con_id_indicador)
                    id_perfil = data.in_id_jefatura_subdireccion
                    id_jefatura_subdireccion = data.in_id_jefatura_subdireccion
                    id_ind = data.con_id_indicador
                    $("#select-direccion-m").change()
                })

                $(response.data_detalle).each(function (i, data) {
                    var t = document.getElementById("select-tipo-indicador");
                    var selectedText = t.options[t.selectedIndex].text;

                    console.log("indocadr")
                    var id_prioridad = 1
                    var ht = ''
                    ht += '		    <tr align="center" id="' + data.id_id_tipo_detalle + '" class="tipo-indicador-m">'
                    ht += '				<td align="center"  class="border-bottom-0 border ">' + data.ti_tipo_indicador + ''
                    ht += '	                <input type="hidden" id="txt-indicador-m-' + data.id_id_tipo_detalle + '" value="' + data.id_id_tipo_detalle + '">'
                    ht += '	            </td>'
                    ht += '				<td align="center"  class="border-bottom-0 border">' + data.id_valor + ''
                    ht += '	                <input type="hidden"id="txt-valor-m-' + data.id_id_tipo_detalle + '" value="' + data.id_valor.replace(/['"$]+/g, '') + '">'
                    ht += '             </td>'
                    ht += '			    <td align="center" class="border-bottom-0 border"><input type="button" class="borrar-m" value="Eliminar" /></td>'
                    ht += '			</tr>'
                    $("#tbody-table-detalle-indicador-m").append(ht)
                    $(document).on('click', '.borrar-m', function (event) {
                        event.preventDefault();
                        $(this).closest('tr').remove();
                    });
                    $("#select-tipo-indicador-m").val('0')
                    $("#txt-valor-m").val('')
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

/**FIN DE FUNCION PARA CONSULTAR LOS DATOS DEL INDICADOR  PARA MODIFICAR */

/*INICIO CLICK AL BOTON AÑADIR PARA AÑADIR EL INDICADOR A LA TABLA */
$("#btn-añadir-indicador-m").click(function () {
    var t = document.getElementById("select-tipo-indicador-m");
    var selectedText = t.options[t.selectedIndex].text;

    console.log("indocadr")
    var id_prioridad = 1
    var ht = ''
    ht += '		    <tr align="center" id="' + $("#select-tipo-indicador-m").val() + '" class="tipo-indicador-m">'
    ht += '				<td align="center"  class="border-bottom-0 border ">' + selectedText + ''
    ht += '	                <input type="hidden" id="txt-indicador-m-' + $("#select-tipo-indicador-m").val() + '" value="' + $("#select-tipo-indicador-m").val() + '">'
    ht += '	            </td>'
    ht += '				<td align="center"  class="border-bottom-0 border">' + $("#txt-valor-m").val() + ''
    ht += '	                <input type="hidden"id="txt-valor-m-' + $("#select-tipo-indicador-m").val() + '" value="' + $("#txt-valor-m").val() + '">'
    ht += '             </td>'
    ht += '			    <td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
    ht += '			</tr>'
    $("#tbody-table-detalle-indicador-m").append(ht)
    $(document).on('click', '.borrar-m', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
    $("#select-tipo-indicador-m").val('0')
    $("#txt-valor-m").val('')
})
/*FIN CLICK AL BOTON AÑADIR PARA AÑADIR EL INDICADOR A LA TABLA */



/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE INDICADORES */
$("#btn-modificar-indicador").click(function () {
    /*if (
        $("#txt-cedula").val() == "" &&
        $("#txt-nombre").val() == "" &&
        $("#txt-apellido").val() == "" &&
        $("#txt-telefono").val() == "" &&
        $("#select-sexo").val() == "0" &&
        $("#txt-fecha-nacimiento").val() == '' &&
        $("#txt-edad").val() == "" &&
        $("#txt-direccion-domicilio").val() == "" &&
        $("#select-direccion").val() == "0" &&
        $("#select-jefatura-subdireccion").val() == "0" &&
        $("#txt-cargo").val() == "" &&
        $("#select-regimen-contrato").val() == "0" &&
        $("#select-tipo-contrato").val() == "0" &&
        $("#txt-remuneracion").val() == "" &&
        $("#txt-fecha-ingreso").val() == "" &&
        $("#txt-fecha-salida").val() == "" &&
        $("#txt-observacion").val() == ""
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-cedula").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo cedula esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-nombre").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo nombre esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-apellido").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo apellido esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-telefono").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo telefono esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#select-sexo").val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo sexo no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-fecha-nacimiento").val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo fecha de nacimiento esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-edad").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo edad esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-direccion-domicilio").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo domicilio esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#select-direccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo direccion no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#select-direccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo direccion no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#select-jefatura-subdireccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo jefatura no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-cargo").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo cargo esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#select-regimen-contrato").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo regimen no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#select-tipo-contrato").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo mosalidad contractual no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-remuneracion").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo remuneracion esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-fecha-ingreso").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo fecha no esta seleccionada",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-observacion").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo observacion esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-titulo").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo titulo esta vacio",
            position: "right",
            autohide: false
        });
    } else {*/
    $("#btn-modificar-indicador").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Modificando..</span>")

    var id_tipo_indicador_m = []
    $('.tipo-indicador-m').each(function () {
        id_tipo_indicador_m.push($(this).attr("id"))
    })
    console.log('id: ' + id_tipo_indicador_m)

    n_m = id_tipo_indicador_m.length

    var indicador_m = []
    for (var i = 0; i < n_m; i++) {
        var indicador_m_ = {
            'id_id_tipo_detalle': $("#txt-indicador-m-" + id_tipo_indicador_m[i]).val(),
            'valor': $("#txt-valor-m-" + id_tipo_indicador_m[i]).val()
        }
        indicador_m.push(indicador_m_)
    }

    var data_indicadores_m = JSON.stringify(indicador_m)
    console.log('indicadores_m' + data_indicadores_m)
    $("#txt-json-indicador-m").val(data_indicadores_m)

    //guardar_empleado()
    //}
    modificar_indicador()
})
/*FIN BOTON CLICK PARA MODIFICAR LOS DATOS DATOS DE INDICADORES */

/*INICIO FUNCION PARA MODIFICAR INDICADOR */
function modificar_indicador() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-modificar-indicador")[0]);
    $.ajax({
        url: '/modificar-indicador',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            $("#modal-modificar-indicador").modal('hide')
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Indicador registrado",
                    type: "success"
                });
                $("#select-direccion-m").val("0")
                $("#select-jefatura-subdireccion-m").val("0")
                $("#select-indicador-m").val("0")
                $("#div-table-detalle-indicador-m").val("")

                $("#btn-modificar-indicador").html("<i class='fa fa-edit'></i> Modificar")
                get_indicadores()
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar Indicador",
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
/*FIN FUNCION PARA MODIFICAR INDICADOR*/

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR INDICADOR POR MEDIO DEL ID */
$("#btn-eliminar-indicador").click(function () {
    $("#btn-eliminar-indicador").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Eliminando..</span>")
    eliminar_indicador_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR INDICADOR POR MEDIO DEL ID*/

/*INICIO FUNCION DE ELIMINAR INDICADOR POR MEDIO DEL ID*/
function eliminar_indicador_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-indicador")[0]);
    $.ajax({
        url: '/eliminar-indicador-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Indicador eliminado",
                    type: "success"
                });
                $("#modal-eliminar-indicador").modal('hide')
                $("#btn-eliminar-indicador").html("<i class='fa fa-times-circle'></i> Eliminar")
                //$("#btn-eliminar-indicador").html()
                get_indicadores()
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
/*FIN FUNCION DE ELIMINAR INDICADOR POR MEDIO DEL ID*/







