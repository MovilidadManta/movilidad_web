let btnReporte = document.getElementById('btn-reporte-certificados');
let tipoReporte = document.getElementById('tipo_reporte');
let tipoCertificadoMedico = document.getElementById('select-certificado-ficha');
const btnBackDetail = document.getElementById('backpageDetail');
const myPieChart = prepareGraphicPie('chartReport');

/** PIE CHART **/
let datapie = {};

$(document).ready(function () {
    configure_select_two_dates('select-fecha-inicio', 'select-fecha-fin');

    $("#downloadExcel").attr("href", `/reportes_medicos/excel`);
});

btnReporte.addEventListener('click', () => {
    getTableReporte();
});

tipoReporte.addEventListener('change', e => {
    tipoCertificadoMedico.disabled = false;
    if (e.target.value == 2) {
        tipoCertificadoMedico.value = 0;
        tipoCertificadoMedico.disabled = true;
    }
});

function getTableReporte() {
    let tipoReporte = document.getElementById('tipo_reporte');
    let fechaInicio = document.getElementById('select-fecha-inicio');
    let fechaFin = document.getElementById('select-fecha-fin');
    let nroTop = document.getElementById('select-nro-top');
    let selectTipoCertificado = document.getElementById('select-certificado-ficha');

    btnBackDetail.click();

    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");

    $.ajax({
        url: `/reportes_medicos/get_report/${tipoReporte.value}/${fechaInicio.value.replaceAll("-", "")}/${fechaFin.value.replaceAll("-", "")}/${nroTop.value}/${selectTipoCertificado.value == 0 ? '' : selectTipoCertificado.value}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = "";
            let labels = [];
            let data = [];
            let colors = [];
            if (tipoReporte.value == 0) {

                html = configureTableHtml("table_reporte_medico",
                    ['CODIGO CIE10', 'DIAGNOSTICO', 'CANTIDAD', 'OPCIONES'],
                    ['dm_cie10', 'dm_descripcion', 'conteo', {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `<button type="button" onClick="renderTableDetails('permiso_atencion_empleados_medica','${item.dm_cie10}',${tipoReporte.value},'${fechaInicio.value.replaceAll("-", "")}','${fechaFin.value.replaceAll("-", "")}',${nroTop.value},${selectTipoCertificado.value})" class="tooltip btn_details"><span class="tooltiptext">Ver detalles</span> <i class="fa fa-list-ul"></i></button>`;
                        }
                    }],
                    response
                );

                response.forEach((r, i) => {
                    labels.push(`[${r.dm_cie10}] ${r.dm_descripcion}`);
                    data.push(r.conteo);
                    colors.push(generarColorHexadecimalAleatorio(i));
                });

                datapie = {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors
                    }]
                };

                myPieChart.render(datapie);
            }

            if (tipoReporte.value == 1) {

                html = configureTableHtml("table_reporte_medico",
                    ['CÉDULA', 'APELLIDOS Y NOMBRES', 'CANTIDAD', 'OPCIONES'],
                    ['emp_cedula', 'empleado', 'conteo',
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                return `<button type="button" onClick="renderTableDetails('permiso_atencion_empleados_medica','${item.emp_cedula}',${tipoReporte.value},'${fechaInicio.value.replaceAll("-", "")}','${fechaFin.value.replaceAll("-", "")}',${nroTop.value},${selectTipoCertificado.value})" class="tooltip btn_details"><span class="tooltiptext">Ver detalles</span> <i class="fa fa-list-ul"></i></button>`;
                            }
                        }],
                    response
                );

                response.forEach((r, i) => {
                    labels.push(`[${r.emp_cedula}] ${r.empleado}`);
                    data.push(r.conteo);
                    colors.push(generarColorHexadecimalAleatorio(i));
                });

                datapie = {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors
                    }]
                };

                myPieChart.render(datapie);
            }

            if (tipoReporte.value == 2) {

                html = configureTableHtml("table_reporte_medico",
                    ['CÉDULA', 'APELLIDOS Y NOMBRES', 'DÍAS DE PERMISO', 'OPCIONES'],
                    ['emp_cedula', 'empleado', 'horas',
                        {
                            align: 'center',
                            class: 'color-td',
                            functionValue: function (item) {
                                return `<button type="button" onClick="renderTableDetails('permiso_atencion_medica','${item.emp_cedula}',${tipoReporte.value},'${fechaInicio.value.replaceAll("-", "")}','${fechaFin.value.replaceAll("-", "")}',${nroTop.value},${selectTipoCertificado.value})" class="tooltip btn_details"><span class="tooltiptext">Ver detalles</span> <i class="fa fa-list-ul"></i></button>`;
                            }
                        }
                    ],
                    response
                );

                response.forEach((r, i) => {
                    labels.push(`[${r.emp_cedula}] ${r.empleado}`);
                    data.push(r.horas);
                    colors.push(generarColorHexadecimalAleatorio(i));
                });

                datapie = {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors
                    }]
                };

                myPieChart.render(datapie);
            }

            $('#optionsDownload').fadeOut();

            if (response.length > 0) {
                $('#optionsDownload').fadeIn();
                $("#downloadExcel").attr("href", `/reportes_medicos/excel/${tipoReporte.value}/${fechaInicio.value.replaceAll("-", "")}/${fechaFin.value.replaceAll("-", "")}/${nroTop.value}/${selectTipoCertificado.value == 0 ? '' : selectTipoCertificado.value}`);
                //$("#downloadExcel").attr("href", `/reportes_medicos/excel2`);
            }

            $("#div_table_reporte_medicos").html(html);

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

btnBackDetail.addEventListener('click', e => {
    e.preventDefault();
    $('#div_table_reporte_medicos_detail').fadeOut();
    $('#optionsDownload_details').fadeOut();
    $('#div_table_reporte_medicos').fadeIn();
    $('#optionsDownload').fadeIn();
});

function renderTableDetails(tipo, cedula, tipoReporte, fechaInicio, fechaFin, nroTop, selectTipoCertificado) {
    $('#div_table_reporte_medicos').fadeOut();
    $('#optionsDownload').fadeOut();
    $.ajax({
        url: `/reportes_medicos/get_report_details/${tipo}/${cedula}/${tipoReporte}/${fechaInicio}/${fechaFin}/${nroTop}/${selectTipoCertificado == 0 ? '' : selectTipoCertificado}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table_detail_certificados",
                ['FECHA DE RECEPCIÓN', 'CÉDULA', 'EMPLEADO', 'JEFE', 'TIPO DE CERTIFICADO', 'TIPO DE PERMISO', 'DEPARTAMENTO', 'CARGO', 'FECHA INICIO CERTIFICADO',
                    'FECHA FIN CERTIFICADO', 'TIEMPO DE PERMISO', 'ENTIDAD QUE CERTIFICA', 'MEDICO QUE CERTIFICA', 'CAUSA', 'CIE 10', 'DIAGNOSTICO',
                    'OBSERVACIÓN', 'ARCHIVO', 'FORMULARIO'
                ],
                ['fm_fecha_recepcion', 'emp_cedula',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `${item.emp_apellido} ${item.emp_nombre}`;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return item.jefe || '';
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let certificadoValue = 'CERTIFICADO POR DÍAS';
                            if (item.fm_tipo_certificado == 2)
                                certificadoValue = 'CERTIFICADO POR HORAS';
                            if (item.fm_tipo_certificado == 3)
                                certificadoValue = 'REVISIÓN MÉDICA';
                            return certificadoValue;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return item.tipo_permiso || '';
                        }
                    },
                    'dep_departamento', 'emp_cargo',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '-';
                            if (item.fm_tipo_certificado == 1)
                                value = item.fm_fecha_inicio_certificado;
                            if (item.fm_tipo_certificado == 2)
                                value = `${item.fm_fecha_inicio_certificado} ${item.fm_hora_inicio_certificado}`;
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '-';
                            if (item.fm_tipo_certificado == 1)
                                value = item.fm_fecha_fin_certificado;
                            if (item.fm_tipo_certificado == 2)
                                value = `${item.fm_fecha_fin_certificado} ${item.fm_hora_fin_certificado}`;
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return item.total_horas || '';
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let entidad = '';
                            if (item.entidad_certifica == 1) entidad = 'IESS';
                            if (item.entidad_certifica == 2) entidad = 'PARTICULAR';
                            if (item.entidad_certifica == 3) entidad = 'MINISTERIO DE SALUD';
                            return entidad;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.me_apellidos.trim() != "NO ASIGNADO")
                                value = `${item.me_apellidos} ${item.me_nombres}`;
                            return value;
                        }
                    },
                    "cm_descripcion", "dm_cie10", "dm_descripcion", "fm_observacion",
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.documento)
                                value = `<a href="javascript:void(0)" onclick="descargar_archivo('${item.documento}')"><i class="far fa-file-pdf tam-pdf"></i></a>`;
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.formulario)
                                value = `<a href="javascript:void(0)" onclick="descargar_archivo('${item.formulario}')"><i class="far fa-file-pdf tam-pdf"></i></a>`;
                            return value;
                        }
                    }
                ], response
            );

            $('#div_table_reporte_medicos_detail').fadeIn();
            $('#optionsDownload_details').fadeIn();

            $("#downloadExcelDetail").attr("href", `/reportes_medicos/get_report_details_excel/${tipo}/${cedula}/${tipoReporte}/${fechaInicio}/${fechaFin}/${nroTop}/${selectTipoCertificado == 0 ? '' : selectTipoCertificado.value}`);

            $("#div_table_reporte_medicos_detail").html(html);

            $("#table_detail_certificados").DataTable({
                "order": [[0, 'desc']]
            });
        }
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
