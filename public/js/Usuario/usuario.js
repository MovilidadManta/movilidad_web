$(document).ready(function () {
    //$("#global-loader").addClass("block");
    //$("#global-loader").removeClass("none");
    get_usuarios();
    var id_empleado = "";
});

var id_subdireccion = "";
var id_estado = "";
/*INICIO DE FUNCION PARA LISTAR USUARIO */
function get_usuarios() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: "/get-usuario",
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == true) {
                var ht = "";
                ht +=
                    '  <table id="table-usuario" border="2" class="table dataTable no-footer">';
                ht += '	    <thead class="background-thead">';
                ht += '		    <tr align="center">';
                ht +=
                    '				<th align="center" class="border-bottom-0 color-th">Cedula</th>';
                ht +=
                    '			    <th align="center" class="border-bottom-0 color-th">Funcionario</th>';
                ht +=
                    '			    <th align="center" class="border-bottom-0 color-th">correo</th>';
                ht +=
                    '			    <th align="center" class="border-bottom-0 color-th">estado</th>';
                ht +=
                    '				<th align="center" class="border-bottom-0 color-th">Opciones</th>';
                ht += "			</tr>";
                ht += "		</thead>";
                ht += "		<tbody>";
                $(response.data).each(function (i, data) {
                    ht += "			<tr>";
                    ht +=
                        '			    <td class="color-td" align="center">' +
                        data.emp_cedula +
                        "</td>";
                    ht +=
                        '				<td class="color-td" align="center">' +
                        data.emp_apellido +
                        " " +
                        data.emp_nombre +
                        "</td>";
                    ht +=
                        '				<td class="color-td" align="center">' +
                        data.usu_correo +
                        "</td>";
                    if (data.usu_estado == "A") {
                        ht +=
                            '				<td class="color-td" align="center"><span class="badge bg-success me-1">Activo</span></td>';
                    } else if (data.usu_estado == "I") {
                        ht +=
                            '				<td class="color-td" align="center"><span class="badge bg-danger me-1">Inactivo</span></td>';
                    }
                    ht += '				<td class="color-td" align="center">';
                    ht +=
                        '<button type="button" onclick="asignar_menus(' +
                        data.usu_id +
                        ')" class="tam-btn btn btn-info"><i class="fa fa-bars tam-icono"></i></button>';
                    ht +=
                        '              <button type="button" id="' +
                        data.usu_id +
                        '" class="tam-btn btn btn-info btn-modal-cambiar-clave"><i class="fa fa-key tam-icono"></i></button>';
                    ht +=
                        '              <button type="button" id="' +
                        data.usu_id +
                        '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>';
                    ht +=
                        '              <button type="button" id="' +
                        data.usu_id +
                        '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>';
                    ht += "			</tr>";
                });
                ht += "		</tbody>";
                ht += "  </table>";
                $("#div-table-usuario").html(ht);

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR USUARIOS */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-usuario").val(this.id);
                    $("#modal-eliminar-usuario").modal("show");
                });
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR USUARIOS*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR USUARIOS*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-modificar-usuario").val(this.id);
                    get_usuario_id(this.id);
                });
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  USUARIOS*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE CAMBIAR CLAVE USUARIOS*/
                $(".btn-modal-cambiar-clave").click(function () {
                    $("#txt-id-cambiar-clave-usuario").val(this.id);
                    get_usuario_cambiar_clave_usuario_id();
                });
                /*FIN CLICK PARA ABRIR EL MODAL DE CAMBIAR CLAVE USUARIOS*/
            }
            $("#table-usuario").DataTable();
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        },
    });
}
/*FIN DE FUNCION PARA LISTAR USUARIO */

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE USUARIOS */
$("#btn-añadir-usuario").click(function () {
    $("#modal-usuario").modal("show");
});
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  USUARIOS */

/**INICIO BUSQUEDA DEL EMPLEADO POR MEDIO DE CEDULA Y NOMBRES */
$("#txt-buscar-emp").on("keyup", function () {
    var txt_buscar = $("#txt-buscar-emp").val();
    if (txt_buscar.length >= 5 && txt_buscar.length <= 10) {
        $("#div-busqueda").html(
            '<label align="center"><i  class="fa fa-spinner color-letra-sugerencia"> Buscando Datos</i></label>'
        );
        console.log($("#txt-buscar").val());
        var tipo = $("#select-tipo-buscar").val();
        var valor = $("#txt-buscar-emp").val();
        get_empleado_tipo_busqueda(tipo, valor);
    } else {
        $("#div-busqueda").html("");
        $("#div-form-empleado").html("");
    }
});
/**FIN BUSQUEDA DEL EMPLEADO POR MEDIO DE CEDULA Y NOMBRES */

/*INICIO PARA FUNCION CONSULTAR EMPLEADO POR TIPO CEDULA O NOMBRE*/
function get_empleado_tipo_busqueda(tipo, valor) {
    console.log("listar empleado");
    $.ajax({
        url: "/get-empleado-tipo/" + tipo + "/" + valor,
        type: "GET",
        dataType: "json",
        success: function (response) {
            var ht = "";
            if (response.respuesta == "true") {
                console.log(response.data);
                ht += '  <table id="table-empleado" border="2" class="table">';
                $(response.data).each(function (i, data) {
                    ht += "			<tr>";
                    ht +=
                        '				<td id="' +
                        data.emp_id +
                        '" class="btn-empleado color-td">' +
                        data.emp_nombre +
                        " " +
                        data.emp_apellido +
                        "</td>";
                    ht += "			</tr>";
                });
                ht += "		</tbody>";
                ht += "  </table>";
                $("#div-busqueda").html(ht);
                $(".btn-empleado").click(function () {
                    $("#div-busqueda").html("");
                    $("#div-form-empleado").html("");
                    $("#div-form-empleado").html(
                        '<label align="center" class="mar-carg"><i  class="mar-carg fa fa-spinner color-letra-sugerencia"> Cargando Informacion</i></label>'
                    );
                    var id = this.id;
                    console.log("id empleado=" + id);
                    get_empleado_id(this.id);
                    //$("#txt-id-empleado").val(id)
                    //llenar_tabla_marcaciones($("#txt-id-empleado").val())
                    //$("#txt-buscar-empleado").val("")
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
/*FIN PARA FUNCION CONSULTAR EMPLEADO POR ID*/

/*INICIO PARA FUNCION CONSULTAR EMPLEADO POR ID*/
function get_empleado_id($id_empleado) {
    $("#global-loader-modal").addClass("block");
    $("#global-loader-modal").removeClass("none");
    console.log("listar empleado");
    id_empleado = $id_empleado;
    $("#txt-id-empleado").val(id_empleado);
    $.ajax({
        url: "/get-empleado-acuerdo-id/" + id_empleado,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                var ht = "";
                console.log(response.data);
                $(response.data).each(function (i, data) {
                    ht += '<div class="row row-sm div-bus-em">';
                    ht += '<div class="row row-sm">';
                    ht += '    <div class="col-lg">';
                    ht +=
                        '        <strong>Cedula <span id="va-ced"></span></strong>';
                    ht +=
                        '        <input class="form-control" name="txt-cedula" id="txt-cedula" placeholder="Ingresar cedula" value="' +
                        data.emp_cedula +
                        '" type="text" readonly>';
                    ht += "    </div>";
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>Nombres</strong>";
                    ht +=
                        '        <input class="form-control" name="txt-nombre" id="txt-nombre" placeholder="Ingresar Nombre" type="text" value="' +
                        data.emp_nombre +
                        '" onkeypress="mayus(this); " readonly>';
                    ht += "    </div>";
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>Apellidos</strong>";
                    ht +=
                        '        <input class="form-control" name="txt-apellido" id="txt-apellido" placeholder="Ingresar Apellido" value="' +
                        data.emp_apellido +
                        '" type="text" onkeypress="mayus(this);" readonly>';
                    ht += "    </div>";
                    ht += "</div>";
                    ht += '<div class="row row-sm mg-t-20">';
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>Corrreo</strong>";
                    ht +=
                        '        <input class="form-control" name="txt-correo" id="txt-correo" placeholder="INGRESAR CORREO" type="text">';
                    ht += "    </div>";
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>clave</strong>";
                    ht +=
                        '        <input class="form-control" name="txt-clave" id="txt-clave" placeholder="INGRESAR CONTRASEÑA" type="text" >';
                    ht += "    </div>";

                    ht += "</div>";
                    ht += '<div class="row row-sm mg-t-20">';
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>Tipo</strong>";
                    ht +=
                        '        <select name="select-jefatura-subdireccion" id="select-jefatura-subdireccion" class="form-control">';
                    ht +=
                        '            <option value="0">SELECCIONE TIPO DE USUARIO</option>';
                    ht += "        </select>";
                    ht += "    </div>";
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>Estado</strong>";
                    ht +=
                        '        <select name="select-estado" id="select-estado" class="form-control">';
                    ht +=
                        '            <option value="0">SELECCIONE ESTADO</option>';
                    ht += '            <option value="A">ACTIVO</option>';
                    ht += '            <option value="I">INACTIVO</option>';
                    ht += "        </select>";
                    ht += "    </div>";
                    ht += "</div>";
                    ht += "</div>";
                    $("#div-table-empleado").html(ht);

                    $("#div-busqueda-empleado").html("");
                    $(".btn-modal-subir-acuerdo-responsabilidad").click(
                        function () {
                            $("#txt-id-empleado").val(this.id);
                            $("#txt-tipo-acuerdo").val("AR");
                            $(
                                "#modal-subir-acuerdo-responsabilidad-condifencialidad"
                            ).modal("show");
                        }
                    );
                    $(".btn-modal-subir-acuerdo-confidencialidad").click(
                        function () {
                            $("#txt-id-empleado").val(this.id);
                            $("#txt-tipo-acuerdo").val("AC");
                            $(
                                "#modal-subir-acuerdo-responsabilidad-condifencialidad"
                            ).modal("show");
                        }
                    );
                });
            }
            $("#global-loader-modal").removeClass("block");
            $("#global-loader-modal").addClass("none");
            $("#div-busqueda").html("");
            get_jefaturas_subdirecciones();
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
/*FIN PARA FUNCION CONSULTAR EMPLEADO POR ID*/

/*INICIO DE FUNCON PARA LISTAR LOS JEFATURAS*/
function get_jefaturas_subdirecciones() {
    $("#select-jefatura-subdireccion").html(
        "<option value='0'>CARGANDO JEFATURAS...</option>"
    );
    $.ajax({
        url: "/get-jefatura-subdireccion",
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == true) {
                var ht = "";
                ht += '<option value="0">SELECCIONE TIPO DE USUARIO</option>';
                $(response.data).each(function (i, data) {
                    ht +=
                        "<option value=" +
                        data.per_id +
                        ">" +
                        data.per_perfil +
                        "</option>";
                });
                $("#select-jefatura-subdireccion").html(ht);
            }
        },
    });
}
/*FIN DE FUNCON PARA LISTAR LOS JEFATURAS*/

/*INICIO DE FUNCON PARA LISTAR LOS JEFATURAS*/
function get_jefaturas_subdirecciones_m() {
    $("#select-jefatura-subdireccion-m").html(
        "<option value='0'>CARGANDO JEFATURAS...</option>"
    );
    $.ajax({
        url: "/get-jefatura-subdireccion",
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == true) {
                var ht = "";
                ht += '<option value="0">SELECCIONE TIPO DE USUARIO</option>';
                $(response.data).each(function (i, data) {
                    ht +=
                        "<option value=" +
                        data.per_id +
                        ">" +
                        data.per_perfil +
                        "</option>";
                });
                $("#select-jefatura-subdireccion-m").html(ht);
                $(
                    "#select-jefatura-subdireccion-m> option[value='" +
                        id_subdireccion +
                        "'] "
                ).attr("selected", "selected");
            }
        },
    });
}
/*FIN DE FUNCON PARA LISTAR LOS JEFATURAS*/

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE USUARIOS */
$("#btn-guardar-usuario").click(function () {
    $("#btn-guardar-usuario").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Guardando..</span>"
    );
    guardar_usuarios();
});
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE USUARIOS */

/*INICIO FUNCION PARA GUARDAR DE USUARIOS */
function guardar_usuarios() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-usuario")[0]);
    $.ajax({
        url: "/registrar-usuario",
        type: "POST",
        dataType: "json",
        headers: { "X-CSRF-TOKEN": token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == "true") {
                if (response.data == "SFAC") {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha firmado ACUERDO DE CONFIDENCIALIDAD",
                        position: "right",
                        autohide: false,
                    });
                } else if (response.data == "SFAR") {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha firmado ACUERDO DE RESPONSABILIDAD DE USO DE CODIGO QR",
                        position: "right",
                        autohide: false,
                    });
                } else {
                    notif({
                        msg: "<b>Correcto:</b> Usuario registrado",
                        type: "success",
                    });
                    $("#txt-mision").val("");
                    $("#txt-vision").val("");
                    $("#modal-usuario").modal("hide");
                    $("#btn-guardar-usuario").html(
                        "<i class='fa fa-edit'></i> Guardar"
                    );
                    get_usuarios();
                }
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
/*FIN FUNCION PARA GUARDAR DE USUARIOS */

/*INICIO DE FUNCION PARA LISTAR USUARIO POR ID PARA MODIFICARLO*/
function get_usuario_id(id) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar usuarios");
    $.ajax({
        url: "/get-usuario-id/" + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == true) {
                var ht = "";
                $(response.data).each(function (i, data) {
                    id_subdireccion = data.usu_id_tipo;
                    id_estado = data.usu_estado;
                    ht += '<div class="row row-sm">';
                    ht += ' <div class="row row-sm">';
                    ht += '    <div class="col-lg">';
                    ht +=
                        '        <strong>Cedula <span id="va-ced"></span></strong>';
                    ht +=
                        '        <input class="form-control" name="txt-cedula-m" id="txt-cedula-m" placeholder="Ingresar cedula" value="' +
                        data.emp_cedula +
                        '" type="text" readonly>';
                    ht += "    </div>";
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>Nombres</strong>";
                    ht +=
                        '        <input class="form-control" name="txt-nombre-m" id="txt-nombre-m" placeholder="Ingresar Nombre" type="text" value="' +
                        data.emp_nombre +
                        '" onkeypress="mayus(this); " readonly>';
                    ht += "    </div>";
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>Apellidos</strong>";
                    ht +=
                        '        <input class="form-control" name="txt-apellido-m" id="txt-apellido-m" placeholder="Ingresar Apellido" value="' +
                        data.emp_apellido +
                        '" type="text" onkeypress="mayus(this);" readonly>';
                    ht += "    </div>";
                    ht += " </div>";
                    ht += ' <div class="row row-sm mg-t-20">';
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>Corrreo</strong>";
                    ht +=
                        '        <input class="form-control" name="txt-correo-m" id="txt-correo-m" placeholder="INGRESAR CORREO" type="text" value="' +
                        data.usu_correo +
                        '">';
                    ht += "    </div>";
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>clave</strong>";
                    ht +=
                        '        <input class="form-control" name="txt-clave-m" id="txt-clave-m" placeholder="INGRESAR CONTRASEÑA" type="text" value="' +
                        data.usu_clave +
                        '" readonly>';
                    ht += "    </div>";

                    ht += " </div>";
                    ht += ' <div class="row row-sm mg-t-20">';
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>Tipo</strong>";
                    ht +=
                        '        <select name="select-jefatura-subdireccion-m" id="select-jefatura-subdireccion-m" class="form-control" value="' +
                        data.usu_id_tipo +
                        '">';
                    ht +=
                        '            <option value="0">SELECCIONE TIPO DE USUARIO</option>';
                    ht += "        </select>";
                    ht += "    </div>";
                    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
                    ht += "        <strong>Estado</strong>";
                    ht +=
                        '        <select name="select-estado-m" id="select-estado-m" class="form-control">';
                    ht +=
                        '            <option value="0">SELECCIONE ESTADO</option>';
                    ht += '            <option value="A">ACTIVO</option>';
                    ht += '            <option value="I">INACTIVO</option>';
                    ht += "        </select>";
                    ht += "    </div>";
                    ht += " </div>";
                    ht += "</div>";
                });
            }
            $("#div-table-empleado-m").html(ht);
            get_jefaturas_subdirecciones_m();
            $("#select-estado-m> option[value='" + id_estado + "'] ").attr(
                "selected",
                "selected"
            );
            $("#modal-usuario-m").modal("show");
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        },
    });
}
/*FIN DE FUNCION PARA LISTAR USUARIO POR ID PARA MODIFICARLO*/

/*INICIO DEL CLICK DEL BOTON PARA MODIFICAR EL USUARIOS POR MEDIO DEL ID*/
$("#btn-modificar-usuario").click(function () {
    $("#btn-modificar-usuario").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Modificando..</span>"
    );
    modificar_usuario_id();
});
/*FIN DEL CLICK DEL BOTON PARA MODIFICAR EL USUARIOS POR MEDIO DEL ID*/

/*INICIO FUNCION PARA MODIFICAR USUARIOS CON EL ID */
function modificar_usuario_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-usuario-m")[0]);
    $.ajax({
        url: "/modificar-usuario",
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
                    msg: "<b>Correcto:</b> Usuario modificado",
                    type: "success",
                });
                $("#modal-usuario-m").modal("hide");
                $("#btn-modificar-usuario").html(
                    "<i class='fa fa-save'></i> Modificar"
                );
                get_usuarios();
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
/*FIN FUNCION PARA MODIFICAR USUARIOS CON EL ID */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE USUARIOS */
$("#btn-eliminar-usuario").click(function () {
    $("#btn-eliminar-usuario").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Eliminando..</span>"
    );
    eliminar_usuarios_id();
});
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE USUARIOS*/

/*INICIO FUNCION DE ELIMINAR DE USUARIOS*/
function eliminar_usuarios_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-usuario")[0]);
    $.ajax({
        url: "/eliminar-usuario-id",
        type: "POST",
        dataType: "json",
        headers: { "X-CSRF-TOKEN": token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Usuario eliminado",
                    type: "success",
                });
                $("#btn-eliminar-usuario").html(
                    "<i class='fa fa-save'></i> Eliminar"
                );
                $("#modal-eliminar-usuario").modal("hide");
                get_usuarios();
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
/*FIN FUNCION DE ELIMINAR DE USUARIOS*/

/*INICIO DE FUNCION PARA LISTAR USUARIO POR ID PARA MODIFICARLO*/
function get_usuario_cambiar_clave_usuario_id() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    var ht = "";
    ht += '<div class="row row-sm">';
    ht += ' <div class="row row-sm">';
    ht += '    <div class="col-lg mg-t-10 mg-lg-t-0">';
    ht += "        <strong>Nueva clave</strong>";
    ht +=
        '        <input class="form-control" name="txt-clave-nueva-m" id="txt-clave-nueva-m" placeholder="Ingresar nueva contraseña" type="text">';
    ht += "    </div>";
    ht += " </div>";
    ht += "</div>";
    $("#div-table-cambiar-clave").html(ht);
    $("#modal-usuario-cambiar-clave").modal("show");
    $("#global-loader").removeClass("block");
    $("#global-loader").addClass("none");
}
/*FIN DE FUNCION PARA LISTAR USUARIO POR ID PARA MODIFICARLO*/

//INICIO CLICK PARA MODIFICAR LA CONTRASEÑA POR EL ID
$("#btn-cambiar-clave-usuario").click(function () {
    $("#btn-cambiar-clave-usuario").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Modificando..</span>"
    );
    cambiar_clave_usuario_id();
});
//INICIO CLICK PARA MODIFICAR LA CONTRASEÑA POR EL ID

/*INICIO FUNCION PARA MODIFICAR LA CLAVE NUEVA DEL USUARIO CON EL ID */
function cambiar_clave_usuario_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-usuario-cambiar-clave")[0]);
    $.ajax({
        url: "/cambiar-clave-usuario",
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
                    msg: "<b>Correcto:</b> Clave modificada",
                    type: "success",
                });
                $("#modal-usuario-cambiar-clave").modal("hide");
                $("#btn-cambiar-clave-usuario").html(
                    "<i class='fa fa-edit'></i> Modificar"
                );
                //get_usuarios()
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
/*FIN FUNCION PARA MODIFICAR LA CLAVE NUEVA DEL USUARIO CON EL ID */

/*REDIRECCIONAR A LA ASIGNACION DE MENU*/

function asignar_menus(ids) {
    window.location.replace("/usuario/" + ids);
}
