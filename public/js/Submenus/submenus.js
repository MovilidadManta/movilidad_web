$(document).ready(function () {
    Get_submenus();
    _AJAX_("/get_project", "GET", "", "", 1);
});
/*INICIO DE FUNCION PARA LISTAR USUARIO */
function Get_submenus() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    _AJAX_("/get_submenu", "GET", "", "", 0);
}

$("#btn_add").click(function () {
    $("#modal_created").modal("show");
    //_AJAX_("/get_submenu", "GET", "", "", 1);
});

$("#btn_save").click(function () {
    let id_menu = $("#sel_menu").val();
    let submenu = $("#ip_submenu").val();
    let tipo = $('input[name="rd_tipo"]:checked').val(); //.is(':checked')
    let link = $("#ip_link").val();

    if (id_menu == "") {
        notif({
            type: "error",
            msg: "<b>Aviso: </b>Por favor ingrese el nombre de un proyecto",
            position: "bottom",
            autohide: false,
        });
    } else if (submenu == "") {
        notif({
            type: "error",
            msg: "<b>Aviso: </b>Por favor ingrese el nombre del submenu",
            position: "bottom",
        });
    } else if (tipo === undefined) {
        notif({
            type: "error",
            msg: "<b>Aviso: </b>Por favor seleccione un tipo de link",
            position: "bottom",
        });
    } else {
        $("#btn_save").html(
            "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Guardando..</span>"
        );
        let datos = {
            id_menu: id_menu,
            submenu: submenu,
            tipo: tipo,
            link: link,
        };
        let token = $("#csrf-token").val();
        _AJAX_("/store_submenu", "POST", token, datos, 0);
    }
});

function modal_editar(id, submenu, estado, id_menu, tipo_link, link, id_proyecto) {
    let tipo_interno = document.getElementById('rd_tipo_in-m');
    let tipo_externo = document.getElementById('rd_tipo_ex-m');
    let check_estado = document.getElementById('chk_estado-m');
    tipo_interno.checked = false;
    tipo_externo.checked = false;
    check_estado.checked = false;
    $("#select-proyecto-m").val(id_proyecto);
    $("#id_mod_submenu").val(id);
    get_menus_m();
    setTimeout(() => {
        $("#sel_menu-m").val(id_menu);
    }, 2700);
    $("#ip_submenu-m").val(submenu);
    if (tipo_link == "interno") {
        tipo_interno.checked = true;
    } else {
        tipo_externo.checked = true;
    }
    if (estado == 1) {
        check_estado.checked = true;
    }
    check_estado.dispatchEvent(new Event('change'));
    $("#ip_link-m").val(link);
    $("#modal_editar_submenu").modal("show");
}

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
        id_submenu: $("#ip_id_proyecto_delete").val(),
    };
    _AJAX_("/delete_submenu", "POST", token, datos, 2);
}
/*FIN FUNCION DE ELIMINAR DE USUARIOS*/

$("#chk_estado-m").change(function () {
    if (document.getElementById("chk_estado-m").checked) {
        $("#l_estado_h").html("Activo");
        //estado = 1;
    } else {
        $("#l_estado_h").html("Inactivo");
        //estado = 0;
    }
    // let estado = $("#chk_estado").val();
});
function get_menus() {
    let id_proyecto = $("#select-proyecto").val();
    if (id_proyecto == 0) {
    } else {
        //  alert(id_proyecto);
        $("#load_m").show();
        _AJAX_("/get_menus/" + id_proyecto, "GET", "", "", 2);
    }
}

function get_menus_m() {
    let id_proyecto = $("#select-proyecto-m").val();
    if (id_proyecto == 0) {
    } else {
        //  alert(id_proyecto);
        $("#load_m-m").show();
        _AJAX_("/get_menus/" + id_proyecto, "GET", "", "", 2, "-m");
    }
}

function _AJAX_(ruta, tipo, token, datos, p, m = "") {
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
                            "Muy bien!",
                            `se ha ${m == "" ? 'creado' : 'modificado'} un ${m == "" ? 'nuevo' : ''} submenu`,
                            "success"
                        );
                        _AJAX_("/get_submenu", "GET", "", "", 0);
                        $(`#btn_save${m}`).html(
                            '<i class="fa fa-save"></i> Guardar'
                        );
                        $("#ip_submenu").val('');
                        $("#modal_created").modal("hide");
                        $("#modal_editar_submenu").modal("hide");
                    }
                } else if (p == 1) {
                    if (res.respuesta) {
                        notif({
                            msg: "<b>Correcto:</b> Proyecto modificado",
                            type: "success",
                        });
                        $("#modal_editar_submenu").modal("hide");
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

                        _AJAX_("/get_submenu", "GET", "", "", 0);
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
                            '  <table id="table_re" border="2" class="table dataTable no-footer">';
                        ht += '	    <thead class="background-thead">';
                        ht += '		    <tr align="center">';
                        ht +=
                            '				<th align="center" class="border-bottom-0 color-th">#</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">MENU</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">SUBMENU</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">FECHA</th>';
                        ht +=
                            '			    <th align="center" class="border-bottom-0 color-th">ESTADO</th>';
                        ht +=
                            '				<th align="center" class="border-bottom-0 color-th">Opciones</th>';
                        ht += "			</tr>";
                        ht += "		</thead>";
                        ht += "		<tbody>";
                        $(res.data).each(function (i, data) {
                            let submenu = "'" + data.submenu + "'";
                            ht += "			<tr>";
                            ht +=
                                '			    <td class="color-td" align="center">' +
                                data.id_submenu +
                                "</td>";
                            ht +=
                                '				<td class="color-td" align="center">' +
                                data.menu +
                                "</td>";
                            ("</td>");
                            ht +=
                                '				<td class="color-td" align="center">' +
                                data.submenu +
                                "</td>";
                            ht +=
                                '<td class="color-td" align="center">' +
                                data.fecha +
                                "</td>";
                            if (data.estado == 1) {
                                ht +=
                                    '<td class="color-td" align="center"><span class="badge bg-success me-1">Activo</span></td>';
                            } else {
                                ht +=
                                    '<td class="color-td" align="center"><span class="badge bg-danger me-1">Inactivo</span></td>';
                            }

                            ht += '<td class="color-td" align="center">';
                            ht +=
                                '<button type="button" onclick="modal_editar(' +
                                data.id_submenu +
                                "," +
                                submenu +
                                "," +
                                data.estado +
                                "," +
                                data.id_menu +
                                ",'" +
                                data.tipo_link +
                                "','" +
                                data.link +
                                "'," +
                                data.id_proyecto +
                                ')" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>';
                            ht +=
                                '              <button type="button" onclick="modal_delete(' +
                                data.id_submenu +
                                ')" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>';
                            ht += "			</td></tr>";
                        });
                        ht += "		</tbody>";
                        ht += "  </table>";
                        $("#div-table").html(ht);
                    }
                    $("#table_re").DataTable();
                    $("#global-loader").removeClass("block");
                    $("#global-loader").addClass("none");
                } else if (p == 1) {
                    if (res.respuesta) {
                        html_ +=
                            '<option value="0">Seleccione un proyecto</option>';
                        $(res.data).each(function (i, dat) {
                            html_ +=
                                '<option value="' +
                                dat.pro_id +
                                '">' +
                                dat.pro_nombre +
                                "</option>";
                        });
                        $("#select-proyecto").html(html_);
                        $("#select-proyecto-m").html(html_);
                    } else {
                        alert("Error al obtener los datos intente de nuevo");
                    }
                } else if (p == 2) {
                    if (res.respuesta) {
                        html_ +=
                            '<option value="0">Seleccione un Menu..</option>';
                        $(res.data).each(function (i, dat) {
                            html_ +=
                                '<option value="' +
                                dat.me_id +
                                '">' +
                                dat.me_menu +
                                "</option>";
                        });
                        $(`#sel_menu${m}`).html(html_);
                        $(`#load_m${m}`).hide();
                    } else {
                        alert("Error al obtener los datos intente de nuevo");
                    }
                }
            },
        }).fail(function (jqXHR, textStatus, errorthrown) {
            $("#load_m").hide();
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

$("#btn_save-m").click(function () {
    let id = $("#id_mod_submenu").val();
    let id_menu = $("#sel_menu-m").val();
    let submenu = $("#ip_submenu-m").val();
    let tipo = $('input[name="rd_tipo-m"]:checked').val(); //.is(':checked')
    let link = $("#ip_link-m").val();
    let check_estado = document.getElementById('chk_estado-m');

    if (id_menu == "") {
        notif({
            type: "error",
            msg: "<b>Aviso: </b>Por favor ingrese el nombre de un proyecto",
            position: "bottom",
            autohide: false,
        });
    } else if (submenu == "") {
        notif({
            type: "error",
            msg: "<b>Aviso: </b>Por favor ingrese el nombre del submenu",
            position: "bottom",
        });
    } else if (tipo === undefined) {
        notif({
            type: "error",
            msg: "<b>Aviso: </b>Por favor seleccione un tipo de link",
            position: "bottom",
        });
    } else {
        $("#btn_save-m").html(
            "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Guardando..</span>"
        );
        let datos = {
            id: id,
            id_menu: id_menu,
            submenu: submenu,
            tipo: tipo,
            link: link,
            estado: check_estado.checked ? 1 : 0
        };
        let token = $("#csrf-token").val();
        _AJAX_("/update_submenu", "POST", token, datos, 0, "-m");
    }
});
