let elementTitle = document.getElementById('title_formulario');
let selectRevision = document.getElementById('select-certificado-ficha');

$(document).ready(function () {
    configure_select_two_dates('select-fecha-inicio', 'select-fecha-fin');

    $('#btn-reporte-certificados').on("click", function () {
        getCertificadosMedicos();
    });
});

selectRevision.addEventListener('change', e => {
    elementTitle.innerHTML = 'Reporte de Certificados Médicos';
    if (e.target.value == 3) {
        elementTitle.innerHTML = 'Reporte de Atenciones Medicas';
    }
});

function getCertificadosMedicos() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: `/get-data-certificados-medicos/${$("#select-fecha-inicio").val().replaceAll("-", "")}/${$("#select-fecha-fin").val().replaceAll("-", "")}/${$("#select-certificado-ficha").val() == 0 ? '' : $("#select-certificado-ficha").val()}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table-certificados-medicos",
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

            $('#optionsDownload').fadeOut();

            if (response.length > 0) {
                $('#optionsDownload').fadeIn();
                $("#downloadExcel").attr("href", `/get_excel_certificados_medicos/${$("#select-fecha-inicio").val().replaceAll("-", "")}/${$("#select-fecha-fin").val().replaceAll("-", "")}/${$("#select-certificado-ficha").val() == 0 ? '' : $("#select-certificado-ficha").val()}`);
                $("#downloadPDF").attr("href", `/get_pdf_permisos_medicos/${$("#select-fecha-inicio").val().replaceAll("-", "")}/${$("#select-fecha-fin").val().replaceAll("-", "")}/${$("#select-certificado-ficha").val() == 0 ? '' : $("#select-certificado-ficha").val()}`);
                //$("#downloadExcel").attr("download", `Reporte_Permisos_${$("#select-fecha-inicio").val().replaceAll("-", "")}_${$("#select-fecha-fin").val().replaceAll("-", "")}.xlsx`);
            }

            $("#div-table-reporte-certificados").html(html);

            $("#table-certificados-medicos").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
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