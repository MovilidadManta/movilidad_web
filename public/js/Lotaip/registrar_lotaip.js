$(document).ready(function () {
    $(".dropify").dropify();
    get_literal_lotaips();
    get_literale_lotaip_select();
    //et_lotaips()
});

/*INICIO DE FUNCION PARA LISTAR LOS LITERALES DE LOTAIP EN EL SELECT*/
function get_literale_lotaip_select() {
    $("#select-literal-lotaip").html(
        "<option value='0'>CARGANDO LITERALES..</option>"
    );
    $.ajax({
        url: "/get-literal-lotaip",
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == true) {
                var ht = "";
                ht += '<option value="0">SELECCIONE LITERAL</option>';
                $(response.data).each(function (i, data) {
                    ht +=
                        "<option value=" +
                        data.li_id +
                        ">" +
                        data.li_literal +
                        "</option>";
                });
                $("#select-literal-lotaip").html(ht);
            }
        },
    });
}
/*FIN DE FUNCON PARA LISTAR LOS LITERALES DE LOTAIP EN EL SELECT*/

//INICIO DE CLICK PARA AGREGAR LITERALES DE LOTAIP
$("#btn-añadir-literal-lotaip").click(function () {
    if (
        $("#select-literal-lotaip").val() == "0" &&
        $("#select-mes").val() == "0"
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false,
        });
    } else if ($("#select-literal-lotaip").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo Literal",
            position: "right",
            autohide: false,
        });
    } else if ($("#select-mes").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione campo Mes",
            position: "right",
            autohide: false,
        });
    } /*else if($('#txt-ruta-archivo').val() == ''){
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Seleccione Archivo",
            position: "right",
            autohide: false
        });
    } */ else {
        $("#btn-añadir-literal-lotaip").html(
            "<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>"
        );
        let id_literal_detalle = $("#ip_id_lotaip_datelle").val();
        if (id_literal_detalle == "") {
            guardar_literal_lotaip();
        } else {
            update_literal_lotaip();
        }
    }
});
//FIN DE CLICK PARA AGREGAR LITERALES DE LOTAIP

/*INICIO FUNCION PARA lGUARDAR LOTAIP */
function update_literal_lotaip() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-literal-lotaip")[0]);
    $.ajax({
        url: "/update-literal-lotaip_document",
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        headers: { "X-CSRF-TOKEN": token },
        data: datos,
        success: function (response) {
            console.log(response);
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Literal Lotaip registrado",
                    type: "success",
                });
                $("#select-literal-lotaip").val("0");
                $("#select-mes").val("0");
                var drEvent2 = $("#txt-ruta-archivo").dropify();
                drEvent2 = drEvent2.data("dropify");
                drEvent2.resetPreview();
                drEvent2.clearElement();
                $("#btn-añadir-literal-lotaip").html(
                    "<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir"
                );
                get_literal_lotaips();
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar Lotaip",
                    position: "right",
                    autohide: false,
                });
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
/*FIN FUNCION PARA GUARDAR LOTAIP*/

/*INICIO FUNCION PARA lGUARDAR LOTAIP */
function guardar_literal_lotaip() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-literal-lotaip")[0]);
    $.ajax({
        url: "/registrar-literal-lotaip_document",
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false,
        headers: { "X-CSRF-TOKEN": token },
        data: datos,
        success: function (response) {
            console.log(response);
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Literal Lotaip registrado",
                    type: "success",
                });
                $("#select-literal-lotaip").val("0");
                $("#select-mes").val("0");
                var drEvent2 = $("#txt-ruta-archivo").dropify();
                drEvent2 = drEvent2.data("dropify");
                drEvent2.resetPreview();
                drEvent2.clearElement();
                $("#btn-añadir-literal-lotaip").html(
                    "<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir"
                );
                get_literal_lotaips();
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar Lotaip",
                    position: "right",
                    autohide: false,
                });
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
/*FIN FUNCION PARA GUARDAR LOTAIP*/

function eliminar_lotaip(id) {
    $("#txt-id-literal-lotaip-e").val(id);
    $("#modal-eliminar-literal-lotaip").modal("show");
}

function editar_lotaip(id) {
    $("#txt-id-literal-lotaip-e").val(id);
    $("#modal-eliminar-literal-lotaip").modal("show");
}

/*INICIO DE FUNCION PARA LISTAR LOTAIP */
function get_literal_lotaips() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    var id = $("#txt-id-lotaip").val();

    $.ajax({
        url: "/get-literal-lotaip/" + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data);
            $("#div-table-detalle-lotaip").html("");
            if (response.respuesta == true) {
                var ht = "";
                ht +=
                    '  <table id="table-literal-lotaip" border="2" class="table dataTable no-footer">';
                ht += '	    <thead class="background-thead">';
                ht += '		    <tr align="center">';
                ht +=
                    '				<th align="center" class="border-bottom-0 color-th">Mes</th>';
                ht +=
                    '				<th align="center" class="border-bottom-0 color-th">Literal Lotaip</th>';
                ht +=
                    '				<th align="center" class="border-bottom-0 color-th">archivo</th>';
                ht +=
                    '				<th align="center" class="border-bottom-0 color-th">Opciones</th>';
                ht += "			</tr>";
                ht += "		</thead>";
                ht += "		<tbody>";
                $(response.data).each(function (i, data) {
                    ht += "			<tr>";
                    if (data.ldl_mes == 1) {
                        ht +=
                            '			    <td align="center" class="color-td">Enero</td>';
                    } else if (data.ldl_mes == 2) {
                        ht +=
                            '			    <td align="center" class="color-td">Febrero</td>';
                    } else if (data.ldl_mes == 3) {
                        ht +=
                            '			    <td align="center" class="color-td">Marzo</td>';
                    } else if (data.ldl_mes == 4) {
                        ht +=
                            '			    <td align="center" class="color-td">Abril</td>';
                    } else if (data.ldl_mes == 5) {
                        ht +=
                            '			    <td align="center" class="color-td">Mayo</td>';
                    } else if (data.ldl_mes == 6) {
                        ht +=
                            '			    <td align="center" class="color-td">Junio</td>';
                    } else if (data.ldl_mes == 7) {
                        ht +=
                            '			    <td align="center" class="color-td">Julio</td>';
                    } else if (data.ldl_mes == 8) {
                        ht +=
                            '			    <td align="center" class="color-td">Agosto</td>';
                    } else if (data.ldl_mes == 9) {
                        ht +=
                            '			    <td align="center" class="color-td">Septiembre</td>';
                    } else if (data.ldl_mes == 10) {
                        ht +=
                            '			    <td align="center" class="color-td">Octubre</td>';
                    } else if (data.ldl_mes == 11) {
                        ht +=
                            '			    <td align="center" class="color-td">Noviembre</td>';
                    } else if (data.ldl_mes == 12) {
                        ht +=
                            '			    <td align="center" class="color-td">Diciembre</td>';
                    }
                    ht +=
                        '			    <td align="center" class="color-td">' +
                        data.li_literal +
                        "</td>";
                    if (data.ldl_extension_archivo == "pdf") {
                        ht += '				<td align="center" class="color-td">';
                        ht +=
                            '				    <a href="/archivos_lotaip/' +
                            data.ldl_ruta_archivo +
                            '" target="_blank" class="btn pad-nu">';
                        ht +=
                            '	                    <i class="far fa-file-pdf color-icono-pdf"></i>';
                        ht +=
                            '	                    <strong class="color-btn-nuevo"></strong>';
                        ht += "	                </a>";
                        ht += "				</td>";
                    } else if (data.ldl_extension_archivo == "xlsx" || data.ldl_extension_archivo == "xls") {
                        ht += '				<td align="center" class="color-td">';
                        ht +=
                            '				    <a href="/archivos_lotaip/' +
                            data.ldl_ruta_archivo +
                            '" target="_blank" class="btn pad-nu">';
                        ht +=
                            '	                    <i class="far fa-file-excel color-icono-excell"></i>';
                        ht +=
                            '	                    <strong class="color-btn-nuevo"></strong>';
                        ht += "	                </a>";
                        ht += "				</td>";
                    } else {
                        ht += '				<td align="center" class="color-td">';
                        ht += "				</td>";
                    }

                    ht += '				<td class="color-td" align="center">';
                    ht +=
                        '              <button type="button" id="' +
                        data.ldl_id +
                        '" class="tam-btn btn btn-warning btn-modal-editar-literal-lotaip" onclick= "get_literales_lotaip_id(' + data.ldl_id + ');"><i class="fa fa-edit tam-icono"></i></button>';
                    ht +=
                        '              <button type="button" id="' +
                        data.ldl_id +
                        '" class="tam-btn btn btn-danger btn-modal-eliminar-literal-lotaip" onclick= "eliminar_lotaip(' + data.ldl_id + ')"><i class="fa fa-trash tam-icono"></i></button>';
                    ht += "             </td>";
                    ht += "			</tr>";
                });
                ht += "		</tbody>";
                ht += "  </table>";
                $("#div-table-detalle-lotaip").html(ht);
                $("#table-literal-lotaip").DataTable();

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR LITERAL DE LOTAIP
                $(".btn-modal-eliminar-literal-lotaip").click(function () {
                    $("#txt-id-literal-lotaip-e").val(this.id);
                    $("#modal-eliminar-literal-lotaip").modal("show");
                });
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR LITERAL DE LOTAIP*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR LITERAL DE LOTAIP
                $(".btn-modal-editar-literal-lotaip").click(function () {
                    $("#txt-id-literal-lotaip").val(this.id);
                    //get_direcciones_modificar()
                    get_literales_lotaip_id(this.id);
                });
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  LITERAL DE LOTAIP*/
            }
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        },
    });
}
/*FIN DE FUNCION PARA LISTAR LOTAIP */

/**INICIO DE FUNCION PARA CONSULTAR LOS DATOS DEL INDICADOR  PARA MODIFICAR */
function get_literales_lotaip_id(id_literal) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $("#ip_id_lotaip_datelle").val(id_literal);
    //$("#tbody-table-detalle-indicador-m").html('')
    //$("#btn-modificar-indicador").html("<i class='fa fa-edit'></i> Modificar")
    console.log("listar literales lotaip");
    $.ajax({
        url: "/get-literal-lotaip-modificar-id/" + id_literal,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    console.log(response.data);
                    $("#select-literal-lotaip").val(data.ldl_id_literal_lotaip);
                    $("#select-mes").val(data.ldl_mes);
                    var drEvent = $("#txt-ruta-archivo").dropify({
                        defaultFile: "/archivos_lotaip/" + data.emp_ruta_foto,
                    });
                    drEvent = drEvent.data("dropify");
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile =
                        "/imagenes_empleados/" + data.ldl_ruta_archivo;
                    drEvent.destroy();
                    drEvent.init();
                });
            }
            $("#global-loader").addClass("none");
            $("#global-loader").removeClass("block");
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

/**FIN DE FUNCION PARA CONSULTAR LOS DATOS DEL INDICADOR  PARA MODIFICAR */

$("#btn-nuevo-literal-lotaip").click(function () {
    $("#txt-id-literal-lotaip").val("");
    $("#select-literal-lotaip").val("0");
    $("#select-mes").val("0");
    var drEvent2 = $("#txt-ruta-archivo").dropify();
    drEvent2 = drEvent2.data("dropify");
    drEvent2.resetPreview();
    drEvent2.clearElement();
    $("#btn-añadir-literal-lotaip").html(
        "<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir"
    );
});

$("#btn-eliminar-literal-lotaip").click(function () {
    $("#btn-eliminar-literal-lotaip").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Eliminando..</span>"
    );
    eliminar_literal_lotaip_id();
});

/*INICIO FUNCION DE ELIMINAR LITERAL DE LOTAIP POR MEDIO DEL ID*/
function eliminar_literal_lotaip_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-literal-lotaip")[0]);
    $.ajax({
        url: "/eliminar-literal-lotaip-id",
        type: "POST",
        dataType: "json",
        headers: { "X-CSRF-TOKEN": token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {

            if (response.respuesta == true) {
                console.log("entro literal")
                notif({
                    msg: "<b>Correcto:</b> Literal eliminado",
                    type: "success",
                });
                $("#modal-eliminar-literal-lotaip").modal("hide");
                $("#btn-eliminar-literal-lotaip").html("<i class='fa fa-times-circle'></i> Eliminar");
                get_literal_lotaips();
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
/*FIN FUNCION DE ELIMINAR LITERAL DE LOTAIP POR MEDIO DEL ID*/
