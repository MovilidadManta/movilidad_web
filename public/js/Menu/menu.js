$(document).ready(function () {
    get_menu();
});

/*INICIO DE FUNCION PARA LISTAR MENUS */
function get_menu() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar menu");
    $.ajax({
        url: "/get-menu",
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == true) {
                var ht = "";
                ht += '  <table id="table-menu" border="2" class="table">';
                ht += '	    <thead class="background-thead">';
                ht += '		    <tr align="center">';
                ht +=
                    '				<th align="center" class="border-bottom-0 color-th">Id</th>';
                ht +=
                    '			    <th align="center" class="border-bottom-0 color-th">Proyecto</th>';
                ht +=
                    '			    <th align="center" class="border-bottom-0 color-th">Menu</th>';
                ht +=
                    '			    <th align="center" class="border-bottom-0 color-th">Estado</th>';
                ht +=
                    '			    <th align="center" class="border-bottom-0 color-th">Fecha</th>';
                ht +=
                    '			    <th align="center" class="border-bottom-0 color-th">Fecha Update</th>';
                ht +=
                    '				<th align="center" class="border-bottom-0 color-th">Opciones</th>';
                ht += "			</tr>";
                ht += "		</thead>";
                ht += "		<tbody>";
                $(response.data).each(function (i, data) {
                    ht += "			<tr>";
                    ht +=
                        '			    <td align="center" class="color-td">' +
                        data.me_id +
                        "</td>";
                    ht +=
                        '				<td align="center" class="color-td">' +
                        data.pro_nombre +
                        "</td>";
                    ht +=
                        '				<td align="center" class="color-td">' +
                        data.me_menu +
                        "</td>";
                    if (data.me_estado == 1) {
                        ht +=
                            '<td class="color-td" align="center"><span class="badge bg-success me-1">Activo</span></td>';
                    } else {
                        ht +=
                            '<td class="color-td" align="center"><span class="badge bg-danger me-1">Inactivo</span></td>';
                    }
                    ht +=
                        '				<td align="center" class="color-td">' +
                        data.me_fecha +
                        "</td>";
                    ht +=
                        '				<td align="center" class="color-td">' +
                        data.me_fecha_update +
                        "</td>";
                    ht += '				<td class="color-td" align="center">';
                    ht +=
                        '              <button type="button" id="' +
                        data.me_id +
                        '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>';
                    ht +=
                        '              <button type="button" id="' +
                        data.me_id +
                        '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>';
                    ht += "			</tr>";
                });
                ht += "		</tbody>";
                ht += "  </table>";
                $("#div-table-menu").html(ht);

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR MENU */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-menu-e").val(this.id);
                    $("#modal-eliminar-menu").modal("show");
                });
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR MENU*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR MENU*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-menu-m").val(this.id);
                    get_proyectos_m();
                    get_menu_id(this.id);
                });
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  MENU*/
            }
            $("#table-menu").DataTable();
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        },
    });
}
/*FIN DE FUNCION PARA LISTAR NOTICIAS */

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE MENU */
$("#btn-añadir-menu").click(function () {
    get_proyectos();
});
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  MENU */

/*INICIO DE FUNCION PARA LISTAR LOS PROYECTO EN EL SELECT DE ANADIR MENU*/
function get_proyectos() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $("#select-proyecto").html("<option value='0'>Cargando menus...</option>");
    $.ajax({
        url: "/get_project",
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == true) {
                var ht = "";
                ht += '<option value="0">Seleccione menu</option>';
                $(response.data).each(function (i, data) {
                    ht +=
                        "<option value=" +
                        data.pro_id +
                        ">" +
                        data.pro_nombre +
                        "</option>";
                });
                $("#select-proyecto").html(ht);
                $("#modal-menu").modal("show");
            }
        },
    });
    $("#global-loader").removeClass("block");
    $("#global-loader").addClass("none");
}
/*INICIO DE FUNCION PARA LISTAR LOS PROYECTO EN EL SELECT DE ANADIR MENU*/

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE MENU */
$("#btn-guardar-menu").click(function () {
    $("#btn-guardar-menu").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Guardando..</span>"
    );
    if (
        $("#select-proyecto").val() == "S" &&
        $("#txt-menu").val() == "" &&
        $("#select-estado").val() == "S"
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false,
        });
        $("#btn-guardar-menu").html("<i class='fa fa-save'></i> Guardar");
    } else if ($("#select-proyecto").val() == "S") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo proyecto no esta seleccionado",
            position: "right",
            autohide: false,
        });
        $("#btn-guardar-menu").html("<i class='fa fa-save'></i> Guardar");
    } else if ($("#txt-menu").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Menu esta vacio",
            position: "right",
            autohide: false,
        });
        $("#btn-guardar-menu").html("<i class='fa fa-save'></i> Guardar");
    } else if ($("#select-estado").val() == "S") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo estado no esta seleccionado",
            position: "right",
            autohide: false,
        });
        $("#btn-guardar-menu").html("<i class='fa fa-save'></i> Guardar");
    } else {
        guardar_menu();
    }
});
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE MENU */

/*INICIO FUNCION PARA GUARDAR DE MENU */
function guardar_menu() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-menu")[0]);
    $.ajax({
        url: "/registrar-menu",
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
                    msg: "<b>Correcto:</b> Menu registrado",
                    type: "success",
                });
                $("#select-proyecto").val("S");
                $("#txt-menu").val("");
                $("#select-estado").val("S");
                $("#select-icono").val("S");
                $("#btn-guardar-menu").html(
                    "<i class='fa fa-save'></i> Guardar"
                );
                $("#modal-menu").modal("hide");
                get_menu();
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
/*FIN FUNCION PARA GUARDAR MENU */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE MENU */
$("#btn-eliminar-menu").click(function () {
    $("#btn-eliminar-menu").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Eliminando..</span>"
    );
    eliminar_menu_id();
});
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE MENU*/

/*INICIO FUNCION DE ELIMINAR DE MENU*/
function eliminar_menu_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-menu")[0]);
    $.ajax({
        url: "/eliminar-menu-id",
        type: "POST",
        dataType: "json",
        headers: { "X-CSRF-TOKEN": token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> menu eliminada",
                    type: "success",
                });
                $("#btn-eliminar-menu").html(
                    "<i class='fa fa-times'></i> Eliminar"
                );
                $("#modal-eliminar-menu").modal("hide");
                get_menu();
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
/*FIN FUNCION DE ELIMINAR DE MENU*/

/*INICIO DE FUNCION PARA LISTAR LOS PROYECTO EN EL SELECT DE ANADIR MENU*/
function get_proyectos_m() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $("#select-proyecto-m").html(
        "<option value='0'>Cargando proyectos...</option>"
    );
    $.ajax({
        url: "/get_project",
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == true) {
                var ht = "";
                ht += '<option value="0">Seleccione proyecto</option>';
                $(response.data).each(function (i, data) {
                    ht +=
                        "<option value=" +
                        data.pro_id +
                        ">" +
                        data.pro_nombre +
                        "</option>";
                });
                $("#select-proyecto-m").html(ht);
                $("#global-loader").removeClass("block");
                $("#global-loader").addClass("none");
            }
        },
    });
}
/*INICIO DE FUNCION PARA LISTAR LOS PROYECTO EN EL SELECT DE ANADIR MENU*/

/*INICIO PARA FUNCION CONSULTAR NOTICIAS POR ID*/
function get_menu_id(id_menu) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar noticia por id");

    $.ajax({
        url: "/get-menu-id/" + id_menu,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#select-proyecto-m").val(data.me_id_proyecto);
                    $("#txt-menu-m").val(data.me_menu);
                    $("#select-estado-m").val(data.me_estado);
                });
                $("#modal-menu-m").modal("show");
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        },
    });
}
/*FIN PARA FUNCION CONSULTAR EMPLEADO POR ID*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DE MENU */
$("#btn-modificar-menu").click(function () {
    $("#btn-modificar-menu").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Modificando..</span>"
    );
    modificar_menu();
});
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DE MENU */

/*INICIO DE FUNCION PARA MODIFICAR DE MENU  POR ID */
function modificar_menu() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-menu-m")[0]);
    $.ajax({
        url: "/modificar-menu",
        type: "POST",
        dataType: "json",
        headers: { "X-CSRF-TOKEN": token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Menu modificado",
                    type: "success",
                });
                $("#txt-id-menu-m").val("");
                $("#txt-menu-m").val("");
                $("#select-proyecto-m").val("0");
                $("#select-estado-m").val("0");
                $("#modal-menu-m").modal("hide");
                $("#btn-modificar-menu").html(
                    "<i class='fa fa-edit'></i> Modificar"
                );
                get_menu();
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar menu",
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
/*FIN DE FUNCION PARA MODIFICAR DE MENU POR ID */
