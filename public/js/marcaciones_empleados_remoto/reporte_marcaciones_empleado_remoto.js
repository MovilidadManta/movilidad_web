const modal_empleado_remoto = "modal_reporte_empleado_remoto";
const nameInputBuscarEmpleado = "txt_search_emp_remoto";
const nameFechaInicioEmpleado = "date_fecha_inicio";
const nameFechaFinEmpleado = "date_fecha_fin";
const id_table_empleados_remotos = "table_empleados_remoto"
const id_table_marcaciones_empleados_remotos = "table_marcaciones_empleados_remoto"
const nameFechaInicioMarcacionesEmpleado = `input_fecha_inicio_${modal_empleado_remoto}`;
const nameFechaFinMarcacionesEmpleado = `input_fecha_fin_${modal_empleado_remoto}`;
const btnReporteMarcacionesEmpleados = document.getElementById(`btn_reporte_marcaciones_remotas_empleado_${modal_empleado_remoto}`);
const InputBuscarEmpleadoRemoto = document.getElementById(nameInputBuscarEmpleado);
const btnBuscarMarcacionesRemotas = document.getElementById("btn_reporte_marcaciones_remotas_empleado");
const txtSearchEmpleado = document.getElementById(nameInputBuscarEmpleado);
const input_fecha_inicio = document.getElementById(nameFechaInicioEmpleado);
const input_fecha_fin = document.getElementById(nameFechaFinEmpleado);
const input_fecha_inicio_marcaciones_remoto = document.getElementById(nameFechaInicioMarcacionesEmpleado);
const input_fecha_fin_marcaciones_remoto = document.getElementById(nameFechaFinMarcacionesEmpleado);

let cer_id_busqueda = 0;
const titleMarcacionesRemotas = document.getElementById(`title_${modal_empleado_remoto}`);

$(document).ready(function () {
    configure_select_two_dates(nameFechaInicioEmpleado, nameFechaFinEmpleado);
    configure_select_two_dates(nameFechaInicioMarcacionesEmpleado, nameFechaFinMarcacionesEmpleado);
    setInputValidations(nameFechaInicioEmpleado, ['notEmpty'], []);
    setInputValidations(nameFechaFinEmpleado, ['notEmpty'], []);
    setInputValidations(nameInputBuscarEmpleado, ['notEmpty'], []);

    setInputValidations(nameFechaInicioMarcacionesEmpleado, ['notEmpty'], []);
    setInputValidations(nameFechaFinMarcacionesEmpleado, ['notEmpty'], []);

    cargarBusquedaEmpleado();
});

function cargarBusquedaEmpleado() {
    let ajaxPrev = null;
    custom_search_input(nameInputBuscarEmpleado, {
        formatResult: function (item) {
            return {
                value: item.emp_id,
                text: `[${item.emp_cedula}] ${item.emp_apellido} ${item.emp_nombre}`,
                html: `[${item.emp_cedula}] ${item.emp_apellido} ${item.emp_nombre}`
            }
        },
        datasets: function (item) {
            return {
                cedula: item.emp_cedula,
                nombre: item.emp_nombre,
                apellido: item.emp_apellido,
                telefono: item.emp_telefono,
                direccion: item.emp_direccion,
                ruta_foto: item.emp_ruta_foto,
                sexo: item.emp_sexo,
                cargo: item.emp_cargo,
                fecha_nacimiento: item.emp_fecha_nacimiento,
                tipo_sangre: item.emp_tipo_sangre,
                departamento: item.dep_departamento,
                cargo: item.ca_cargo,
                edad: item.emp_edad,
                estado_ruta_foto: item.emp_estado_ruta_foto
            }
        },
        search: function (text, callback) {
            if (ajaxPrev != null)
                ajaxPrev.abort();

            let ajax = $.ajax(
                `/reporte_marcaciones_empleado_remoto/get_empleados/10/${text}`
            ).done(function (res) {
                callback(res.respuesta ? res.data : []);
            });

            ajaxPrev = ajax;
        }
    });
}

txtSearchEmpleado.addEventListener('changeAsing', (e) => {

});

btnBuscarMarcacionesRemotas.addEventListener("click", () => {

    let errores = '';

    errores += txtSearchEmpleado.validateInput();
    errores += input_fecha_inicio.validateInput();
    errores += input_fecha_fin.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede buscar el empleado remoto, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $.ajax({
            url: `/reporte_marcaciones_empleado_remoto/get_conf_marcaciones_empleados/${$("#date_fecha_inicio").val().replaceAll("-", "")}/${$("#date_fecha_fin").val().replaceAll("-", "")}/${InputBuscarEmpleadoRemoto.dataset.value}`,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let html = configureTableHtml(id_table_empleados_remotos,
                    ['#', 'CÉDULA', 'EMPLEADO', 'F. DE NACIMIENTO', 'DEPARTAMENTO', 'PUESTO DE TRABAJO', 'FECHA DE INICIO', 'FECHA DE FIN', 'ESTADO', 'OPCIONES'],
                    ['cer_id', 'emp_cedula',
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                return `${item.emp_apellido} ${item.emp_nombre}`;
                            }
                        }, 'emp_fecha_nacimiento', 'dep_departamento', 'ca_cargo', 'cer_fecha_inicio',
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                return item.cer_tiene_fecha_fin
                                    ? item.cer_fecha_fin
                                    : 'INDEFINIDO';
                            }
                        },
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                return item.cer_estado
                                    ? '<span class="badge bg-success me-1">Activo</span>'
                                    : '<span class="badge bg-danger me-1">Inactivo</span>';
                            }
                        },
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                let render = "";
                                if (item.cer_estado) {
                                    render += `<button type="button" class="btn btn-info btn-modal-editar tooltip" Onclick="show_marcaciones_remotas_id(${item.cer_id}, '${item.emp_apellido}', '${item.emp_nombre}')" ><span class="tooltiptext">Ver Marcaciones</span><i class="fa fa-eye icon_elevated"></i></button>`;
                                }
                                return render;

                            }
                        },
                    ], response
                );

                $("#optionsDownload").fadeOut();

                if (response.length > 0) {
                    $("#optionsDownload").fadeIn();
                    $("#downloadExcel").attr("href", `/reporte_marcaciones_empleado_remoto/get_excel_conf_remoto_empleado/${$("#date_fecha_inicio").val().replaceAll("-", "")}/${$("#date_fecha_fin").val().replaceAll("-", "")}/${InputBuscarEmpleadoRemoto.dataset.value}`);
                    $("#downloadPDF").attr("href", `/reporte_marcaciones_empleado_remoto/get_pdf_conf_remoto_empleado/${$("#date_fecha_inicio").val().replaceAll("-", "")}/${$("#date_fecha_fin").val().replaceAll("-", "")}/${InputBuscarEmpleadoRemoto.dataset.value}`);
                }

                $("#div_table_marcaciones_remotas").html(html);

                $(`#${id_table_empleados_remotos} `).DataTable({
                    "order": [[0, 'desc']]
                });

                $("#global-loader").removeClass("block");
                $("#global-loader").addClass("none");
            }
        });
    }
});

function show_marcaciones_remotas_id(cer_id, emp_apellido, emp_nombre) {
    cer_id_busqueda = cer_id;
    titleMarcacionesRemotas.innerText = `Marcaciones Remotas de ${emp_apellido} ${emp_nombre}`;

    $(`#${nameFechaInicioMarcacionesEmpleado}`).val($("#date_fecha_inicio").val());
    $(`#${nameFechaFinMarcacionesEmpleado}`).val($("#date_fecha_fin").val());

    btnReporteMarcacionesEmpleados.dispatchEvent(new Event("click"));

    $(`#${modal_empleado_remoto}`).modal("show");
}

btnReporteMarcacionesEmpleados.addEventListener("click", () => {

    let errores = '';

    errores += input_fecha_inicio_marcaciones_remoto.validateInput();
    errores += input_fecha_fin_marcaciones_remoto.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede buscar las marcaciones del empleado, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $.ajax({
            url: `/reporte_marcaciones_empleado_remoto/get_marcaciones_remotas_empleados/${$(`#${nameFechaInicioMarcacionesEmpleado}`).val().replaceAll("-", "")}/${$(`#${nameFechaFinMarcacionesEmpleado}`).val().replaceAll("-", "")}/${cer_id_busqueda}`,
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

                $(`#optionsDownload_${modal_empleado_remoto}`).fadeOut();

                if (response.length > 0) {
                    $(`#optionsDownload_${modal_empleado_remoto}`).fadeIn();
                    $(`#downloadExcel_${modal_empleado_remoto}`).attr("href", `/reporte_marcaciones_empleado_remoto/get_excel_marcaciones_remotas_empleado/${$(`#${nameFechaInicioMarcacionesEmpleado}`).val().replaceAll("-", "")}/${$(`#${nameFechaFinMarcacionesEmpleado}`).val().replaceAll("-", "")}/${cer_id_busqueda}`);
                    $(`#downloadPDF_${modal_empleado_remoto}`).attr("href", `/reporte_marcaciones_empleado_remoto/get_pdf_marcaciones_remotas_empleado/${$(`#${nameFechaInicioMarcacionesEmpleado}`).val().replaceAll("-", "")}/${$(`#${nameFechaFinMarcacionesEmpleado}`).val().replaceAll("-", "")}/${cer_id_busqueda}`);
                }

                $(`#div_table_marcaciones_empleado_remotas_${modal_empleado_remoto}`).html(html);

                $(`#${id_table_marcaciones_empleados_remotos} `).DataTable({
                    "order": [[0, 'desc']]
                });

                $("#global-loader").removeClass("block");
                $("#global-loader").addClass("none");
            }
        });
    }
});