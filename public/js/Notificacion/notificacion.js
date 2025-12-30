$(document).ready(function () {
    //$("#global-loader").addClass("block");
    //$("#global-loader").removeClass("none");
    //  get_usuarios();
    var id_empleado = "";
});

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
                    '				<th align="center" class="border-bottom-0 color-th">:::</th>';
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
                        '<td class="color-td" align="center"><label class="ckbox"><input type="checkbox" class="mb-2"></input></label> </td>';
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
                        '<button type="button" onclick="asignar_menus(' +
                        data.usu_id +
                        ')" class="tam-btn btn btn-info"><i class="fa fa-check-circle-o"></i></button>';

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
