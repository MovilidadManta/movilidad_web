$(document).ready(function () {
    GET_proyectos();
});
/*INICIO DE FUNCION PARA LISTAR USUARIO */
function GET_proyectos() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    _AJAX_("/get_project", "GET", "", "", 0);
}

$("#btn_add_projet").click(function () {
    $("#modal-project").modal("show");
});

$("#btn_save_project").click(function () {
    let proyecto = $("#ip_nombre_proyecto");
    if (proyecto.val() == "") {
        notif({
            type: "error",
            msg: "<b>Aviso: </b>Por favor ingrese el nombre de un proyecto",
            position: "bottom",
            autohide: false,
        });
        proyecto.focus();
    } else {
        $("#btn_save_project").html(
            "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Guardando..</span>"
        );
        let datos = {
            project: proyecto.val(),
        };
        let token = $("#csrf-token").val();
        _AJAX_("/store_project", "POST", token, datos, 0);
    }
});

function modal_editar(id, proyecto, estado) {
    SimpleSwitch.init();
    let myCheckbox = document.getElementById("chk_estado_2");
    $("#ip_proyecto_edit").val(proyecto);
    $("#ip_id_proyecto_edit").val(id);
    if (estado == 1) {
        //SimpleSwitch.toggle(myCheckbox);
        $("#l_estado_h").html("activo");
        SimpleSwitch.toggle(myCheckbox, true);
        // $("#chk_estado").attr("checked", true);
    } else if (estado == 0) {
        SimpleSwitch.toggle(myCheckbox, false);
        $("#l_estado_h").html("inactivo");
        //$("#chk_estado").attr("checked", false);
    }
    $("#modal_editar_proyecto").modal("show");
}

/*INICIO DEL CLICK DEL BOTON PARA MODIFICAR EL PROYECTO POR MEDIO DEL ID*/
$("#btn-modificar-proyecto").click(function () {
    $("#btn-modificar-proyecto").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Modificando..</span>"
    );
    modificar_proyecto_id();
});
/*FIN DEL CLICK DEL BOTON PARA MODIFICAR EL PROYECTO POR MEDIO DEL ID*/

/*INICIO FUNCION PARA MODIFICAR PROYECTO CON EL ID */
function modificar_proyecto_id() {
    let token = $("#csrf-token").val();
    let estado = null;
    if (document.getElementById("chk_estado_2").checked) {
        estado = 1;
    } else {
        estado = 0;
    }
    let datos = {
        ip_id_proyecto_edit: $("#ip_id_proyecto_edit").val(),
        ip_proyecto_edit: $("#ip_proyecto_edit").val(),
        estado_edit: estado,
    };
    _AJAX_("/update_project", "POST", token, datos, 1);
}
/*FIN FUNCION PARA MODIFICAR PROYECTO CON EL ID */

function modal_delete(id) {
    $("#ip_id_proyecto_delete").val(id);
    $("#modal_delete_proyecto").modal("show");
}

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE USUARIOS */
$("#btn-eliminar-proyecto").click(function () {
    $("#btn-eliminar-proyecto").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Eliminando..</span>"
    );
    eliminar_proyecto_id();
});
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE USUARIOS*/

/*INICIO FUNCION DE ELIMINAR DE USUARIOS*/
function eliminar_proyecto_id() {
    var token = $("#csrf-token").val();
    let datos = {
        id_proyecto: $("#ip_id_proyecto_delete").val(),
    };
    _AJAX_("/delete_project", "POST", token, datos, 2);
}
/*FIN FUNCION DE ELIMINAR DE USUARIOS*/

$("#chk_estado_2").change(function () {
    if (document.getElementById("chk_estado_2").checked) {
        $("#l_estado_h").html("activo");
        //estado = 1;
    } else {
        $("#l_estado_h").html("Inactivo");
        //estado = 0;
    }
    // let estado = $("#chk_estado").val();
});

function _AJAX_(ruta, tipo, token, datos, p) {
    if (tipo == "POST") {
        $.ajax({
            url: ruta,
            type: tipo,
            dataType: "json",
            headers: { "X-CSRF-TOKEN": token },
            data: datos,
            success: function (res) {
                if (p == 0) {
                    if (res.respuesta) {
                        Swal.fire(
                            "Tramites!",
                            "los tramites han sido reagsinado.",
                            "success"
                        );
                        _AJAX_("/get_project", "GET", "", "", 0);
                        $("#btn_save_project").html(
                            '<i class="fa fa-save"></i> Guardar'
                        );
                        $("#modal-project").modal("hide");
                    }
                } else if (p == 1) {
                    if (res.respuesta) {
                        notif({
                            msg: "<b>Correcto:</b> Proyecto modificado",
                            type: "success",
                        });
                        $("#modal_editar_proyecto").modal("hide");
                        $("#btn-modificar-proyecto").html(
                            "<i class='fa fa-save'></i> Modificar"
                        );
                        _AJAX_("/get_project", "GET", "", "", 0);
                    }
                } else if (p == 2) {
                    if (res.data == "eliminado") {
                        notif({
                            msg: "<b>Correcto:</b> Proyecto eliminado",
                            type: "success",
                        });
                        $("#btn-eliminar-proyecto").html(
                            "<i class='fa fa-save'></i> Eliminar"
                        );
                        $("#modal_delete_proyecto").modal("hide");

                        _AJAX_("/get_project", "GET", "", "", 0);
                    }
                }
            },
        }).fail(function (jqXHR, textStatus, errorthrown) {
            if (jqXHR.status === 0) {
                alert("Not connect: Verify Network.");
            } else if (jqXHR.status == 404) {
                alert("Requested page not found [404]");
            } else if (jqXHR.status == 500) {
                alert("Internal Server Error [500].");
            } else if (textStatus === "parsererror") {
                alert("Requested JSON parse failed.");
            } else if (textStatus === "timeout") {
                alert("Time out error.");
            } else if (textStatus === "abort") {
                alert("Ajax request aborted.");
            } else {
                alert("Uncaught Error: " + jqXHR.responseText);
            }
        });
    } else if (tipo == "GET") {
        $.ajax({
            url: ruta,
            type: tipo,
            dataType: "json",
            success: function (res) {
                let html_ = "";
                if (p == 0) {
                    if (res.respuesta == true) {
                        var ht = "";
                        ht +=
                            '  <table id="table-proyectos" border="2" class="table dataTable no-footer">';
                        ht += '	    <thead class="background-thead">';
                        ht += '		    <tr align="center">';
                        ht +=
                            '				<th align="center" class="border-bottom-0 color-th">#</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">PROYECTO</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">ESTADO</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">FECHA</th>';
                        ht +=
                            '				<th align="center" class="border-bottom-0 color-th">Opciones</th>';
                        ht += "			</tr>";
                        ht += "		</thead>";
                        ht += "		<tbody>";
                        $(res.data).each(function (i, data) {
                            let proyecto = "'" + data.pro_nombre + "'";
                            ht += "			<tr>";
                            ht +=
                                '			    <td class="color-td" align="center">' +
                                data.pro_id +
                                "</td>";
                            ht +=
                                '				<td class="color-td" align="center">' +
                                data.pro_nombre +
                                "</td>";
                            if (data.pro_estado == 1) {
                                ht +=
                                    '<td class="color-td" align="center"><span class="badge bg-success me-1">Activo</span></td>';
                            } else {
                                ht +=
                                    '<td class="color-td" align="center"><span class="badge bg-danger me-1">Inactivo</span></td>';
                            }
                            ht +=
                                '<td class="color-td" align="center">' +
                                data.pro_fecha +
                                "</td>";
                            ht += '<td class="color-td" align="center">';
                            ht +=
                                '<button type="button" onclick="modal_editar(' +
                                data.pro_id +
                                "," +
                                proyecto +
                                "," +
                                data.pro_estado +
                                ')" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>';
                            ht +=
                                '              <button type="button" onclick="modal_delete(' +
                                data.pro_id +
                                ')" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>';
                            ht += "			</td></tr>";
                        });
                        ht += "		</tbody>";
                        ht += "  </table>";
                        $("#div-table-proyectos").html(ht);
                    }
                    $("#table-proyectos").DataTable();
                    $("#global-loader").removeClass("block");
                    $("#global-loader").addClass("none");
                }
            },
        }).fail(function (jqXHR, textStatus, errorthrown) {
            if (jqXHR.status === 0) {
                alert("Not connect: Verify Network.");
            } else if (jqXHR.status == 404) {
                alert("Requested page not found [404]");
            } else if (jqXHR.status == 500) {
                alert("Internal Server Error [500].");
            } else if (textStatus === "parsererror") {
                alert("Requested JSON parse failed.");
            } else if (textStatus === "timeout") {
                alert("Time out error.");
            } else if (textStatus === "abort") {
                alert("Ajax request aborted.");
            } else {
                alert("Uncaught Error: " + jqXHR.responseText);
            }
        });
    }
}
