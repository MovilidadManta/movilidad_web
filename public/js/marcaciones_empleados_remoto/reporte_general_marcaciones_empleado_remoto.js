const nameFechaInicioEmpleado = "date_fecha_inicio";
const nameFechaFinEmpleado = "date_fecha_fin";
const id_table_marcaciones_empleados_remotos = "table_marcaciones_empleados_remoto"
const btnBuscarMarcacionesRemotas = document.getElementById("btn_reporte_general_marcaciones_remotas_empleado");
const input_fecha_inicio = document.getElementById(nameFechaInicioEmpleado);
const input_fecha_fin = document.getElementById(nameFechaFinEmpleado);

$(document).ready(function () {
    configure_select_two_dates(nameFechaInicioEmpleado, nameFechaFinEmpleado);
    setInputValidations(nameFechaInicioEmpleado, ['notEmpty'], []);
    setInputValidations(nameFechaFinEmpleado, ['notEmpty'], []);
});


btnBuscarMarcacionesRemotas.addEventListener("click", () => {

    let errores = '';
    errores += input_fecha_inicio.validateInput();
    errores += input_fecha_fin.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede buscar las marcaciones, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $.ajax({
            url: `/reporte_marcaciones_empleado_remoto/get_marcaciones_remotas_empleados/${$("#date_fecha_inicio").val().replaceAll("-", "")}/${$("#date_fecha_fin").val().replaceAll("-", "")}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let html = configureTableHtml(id_table_marcaciones_empleados_remotos,
                    ['#', 'CÉDULA', 'EMPLEADO', 'DEPARTAMENTO', 'PUESTO DE TRABAJO',
                        'FECHA MARCACIÓN', 'TIPO MARCACIÓN', 'ARCHIVO EVIDENCIA'],
                    ['me_id', 'emp_cedula',
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                return `${item.emp_apellido} ${item.emp_nombre}`;
                            }
                        }, 'dep_departamento', 'ca_cargo',
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                return `${item.me_fecha_marcacion.substr(0, 19)}`;
                            }
                        },
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                let tipo_marcacion = "SALIDA";
                                if (item.me_tipo_marcacion == 1) {
                                    tipo_marcacion = "ENTRADA";
                                }
                                if (item.me_tipo_marcacion == 2) {
                                    tipo_marcacion = "SALIDA AL ALMUERZO";
                                }
                                if (item.me_tipo_marcacion == 3) {
                                    tipo_marcacion = "ENTRADA DEL ALMUERZO";
                                }
                                return `${tipo_marcacion}`;
                            }
                        },
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                return `<a href="/reporte_marcaciones_empleado_remoto/get_imagen/${item.me_archivo_evidencia_marca}" alt="${item.me_archivo_evidencia_marca}" target="blank">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-picture-o" aria-hidden="true"></i>
                                    </button>
                                </a>
                                `;
                            }
                        }
                    ], response
                );

                $("#optionsDownload").fadeOut();

                if (response.length > 0) {
                    $("#optionsDownload").fadeIn();
                    $("#downloadExcel").attr("href", `/reporte_marcaciones_empleado_remoto/get_excel_marcaciones_remotas_empleado/${$("#date_fecha_inicio").val().replaceAll("-", "")}/${$("#date_fecha_fin").val().replaceAll("-", "")}`);
                    $("#downloadPDF").attr("href", `/reporte_marcaciones_empleado_remoto/get_pdf_marcaciones_remotas_empleado/${$("#date_fecha_inicio").val().replaceAll("-", "")}/${$("#date_fecha_fin").val().replaceAll("-", "")}`);
                }

                $("#div_table_general_marcaciones_remotas").html(html);

                $(`#${id_table_marcaciones_empleados_remotos} `).DataTable({
                    "order": [[2, 'asc']]
                });

                $("#global-loader").removeClass("block");
                $("#global-loader").addClass("none");
            }
        });
    }
});