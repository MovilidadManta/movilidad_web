$(document).ready(function () {
    configure_select_two_dates('select-fecha-inicio', 'select-fecha-fin');

    $('#btn-reporte-permisos').on("click", function () {
        getPermisosTrabajo();
    });
});

function getPermisosTrabajo() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: `/get_permisos/${$("#select-fecha-inicio").val().replaceAll("-", "")}/${$("#select-fecha-fin").val().replaceAll("-", "")}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table-permisos-empleados",
                ['Id', 'JEFE', 'EMPLEADO', 'TIPO PERMISO', 'ESTADO',
                    'FECHA SOLICITUD', 'FECHA INICIO', 'FECHA FIN', 'HORA INICIO', 'HORA FIN',
                    'TOTAL HORAS', 'OBSERVACIÓN RECHAZO'
                ],
                ['id', 'jefe', 'empleado', 'tipo_permiso',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.estado == "INGRESADO") {
                                value = '<span class="badge bg-warning me-1">INGRESADO</span>';
                            } else if (item.estado == "RECHAZADO") {
                                value = '<span class="badge bg-danger me-1">RECHAZO</span>';
                            } else if (item.estado == "APROBADO") {
                                value = '<span class="badge bg-success me-1">APROBADO</span>';
                            }
                            return value;
                        }
                    },
                    'fecha_solicitud', 'fecha_inicio', 'fecha_final', 'hora_inicio', 'hora_final', 'total_horas',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.observacion_rechazo != null) {
                                value = item.observacion_rechazo;
                            } else {
                                value = 'Sin Información'
                            }
                            return value;
                        }
                    }
                ], response
            );
            console.log(html);

            $('#optionsDownload').fadeOut();

            if (response.length > 0) {
                $('#optionsDownload').fadeIn();
                $("#downloadExcel").attr("href", `/get_excel_permisos/${$("#select-fecha-inicio").val().replaceAll("-", "")}/${$("#select-fecha-fin").val().replaceAll("-", "")}`);
                $("#downloadPDF").attr("href", `/get_pdf_permisos/${$("#select-fecha-inicio").val().replaceAll("-", "")}/${$("#select-fecha-fin").val().replaceAll("-", "")}`);
                //$("#downloadExcel").attr("download", `Reporte_Permisos_${$("#select-fecha-inicio").val().replaceAll("-", "")}_${$("#select-fecha-fin").val().replaceAll("-", "")}.xlsx`);
            }

            $("#div-table-reporte-empleado").html(html);

            $("#table-permisos-empleados").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

