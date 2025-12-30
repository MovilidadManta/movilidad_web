$(document).ready(function () {
    get_permisos();
});

/*INICIO DE FUNCION PARA LISTAR MENUS */
function get_permisos() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar menu");
    $.ajax({
        url: "/get_permisos",
        type: "GET",
        dataType: "json",
        success: function (response) {
            var ht = "";
            ht += '  <table id="table-menu" border="2" class="table">';
            ht += '	    <thead class="background-thead">';
            ht += '		    <tr align="center">';
            ht += '				<th align="center" class="border-bottom-0 color-th">Id</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">JEFE</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">EMPLEADO</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">TIPO PERMISO</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">ESTADO</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">FECHA SOLICITUD</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">FECHA INICIO</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">FECHA FIN</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">HORA INICIO</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">HORA FIN</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">TOTAL HORAS</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">OBSERVACIÓN RECHAZO</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">ARCHIVO</th>';
            ht +=
                '			    <th align="center" class="border-bottom-0 color-th">FORMULARIO</th>';

            ht += "			</tr>";
            ht += "		</thead>";
            ht += "		<tbody>";
            $(response).each(function (i, data) {
                ht += "			<tr>";
                ht +=
                    '			    <td align="center" class="color-td">' +
                    data.id +
                    "</td>";
                ht +=
                    '<td align="center" class="color-td">' +
                    data.jefe +
                    "</td>";
                ht +=
                    '				<td align="center" class="color-td">' +
                    data.empleado +
                    "</td>";
                ht +=
                    '				<td align="center" class="color-td">' +
                    data.tipo_permiso +
                    "</td>";
                if (data.estado == "INGRESADO") {
                    ht +=
                        '<td class="color-td" align="center"><span class="badge bg-warning me-1">INGRESADO</span></td>';
                } else if (data.estado == "RECHAZADO") {
                    ht +=
                        '<td class="color-td" align="center"><span class="badge bg-danger me-1">RECHAZO</span></td>';
                } else if (data.estado == "APROBADO") {
                    ht +=
                        '<td class="color-td" align="center"><span class="badge bg-success me-1">APROBADO</span></td>';
                }
                ht +=
                    '				<td align="center" class="color-td">' +
                    data.fecha_solicitud +
                    "</td>";
                ht +=
                    '				<td align="center" class="color-td">' +
                    data.fecha_inicio +
                    "</td>";

                ht +=
                    '				<td align="center" class="color-td">' +
                    data.fecha_final +
                    "</td>";
                ht +=
                    '				<td align="center" class="color-td">' +
                    data.hora_inicio +
                    "</td>";
                ht +=
                    '				<td align="center" class="color-td">' +
                    data.hora_final +
                    "</td>";
                ht +=
                    '				<td align="center" class="color-td">' +
                    data.total_horas +
                    "</td>";
                if (data.observacion_rechazo != null) {
                    ht +=
                        '				<td align="center" class="color-td">' +
                        data.observacion_rechazo +
                        "</td>";
                } else {
                    ht += '<td align="center" class="color-td">Sin Información</td>'
                }

                if (data.documento != null) {
                    let ruta = "'" + data.documento + "'";
                    ht +=
                        '<td align="center" class="color-td"><a href="javascript:void(0)" onclick="descargar_archivo(' +
                        ruta +
                        ')">                <i class="far fa-file-pdf tam-pdf"></i>                          </a></td>';
                } else {
                    ht += "<td></td>";
                }

                if (data.formulario != null) {
                    let ruta = "'" + data.formulario + "'";
                    ht +=
                        '<td align="center" class="color-td"><a href="javascript:void(0)" onclick="descargar_archivo(' +
                        ruta +
                        ')">                <i class="far fa-file-pdf tam-pdf"></i>                        </a></td>';
                } else {
                    ht += "<td></td>";
                }


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

            /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  MENU*/
            $("#table-menu").DataTable({
                "order": [[0, 'desc']]
            });
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        },
    });
}

function descargar_archivo(ruta) {
    let r = btoa(unescape(encodeURIComponent(ruta)));

    var url = "/descargar_archivo_per/" + r;
    console.log(url);
    var a = document.createElement("a");
    a.target = "_blank";
    a.href = url;
    a.click();
}
