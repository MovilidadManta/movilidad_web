let iframe_view_document = document.getElementById('iframe_visor_orden_cuerpo');

$(document).ready(function () {
    configure_select_two_dates('select_fecha_inicio', 'select_fecha_fin');

    $('#btn_reporte_orden_cuerpo').on("click", function () {
        getReportesOC();
    });
});

function getReportesOC() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: `/orden_cuerpo/report_dates/${$("#select_fecha_inicio").val().replaceAll("-", "")}/${$("#select_fecha_fin").val().replaceAll("-", "")}/${$("#select_estado_orden_cuerpo").val()}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table_orden_cuerpo",
                ['#', 'FECHA DE CREACIÓN', 'TITULO', 'ESTADO', 'ARCHIVO'
                ],
                ['oc_id', 'oc_fecha',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            datos = JSON.parse(item.oc_datos);
                            const title = datos.find(i => i.name === "title_document");
                            return `
                                <p>${title.text}</p>
                            `;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.oc_firma) {
                                value = '<span class="badge bg-success me-1">APROBADO</span>';
                            } else {
                                value = '<span class="badge bg-warning me-1">NO APROBADO</span>';
                            }
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `
                                <button type="button" onClick="view_orden_cuerpo_pdf(${item.oc_id})" class="tooltip"><span class="tooltiptext">Ver certificado</span> <i class="far fa-file-pdf tam-pdf"></i></button>
                            `;
                        }
                    }
                ], response
            );

            $('#optionsDownload').fadeOut();

            if (response.length > 0) {
                $('#optionsDownload').fadeIn();
                $("#downloadExcel").attr("href", `/orden_cuerpo/report_dates/get_excel/${$("#select_fecha_inicio").val().replaceAll("-", "")}/${$("#select_fecha_fin").val().replaceAll("-", "")}/${$("#select_estado_orden_cuerpo").val()}`);
                $("#downloadPDF").attr("href", `/orden_cuerpo/report_dates/get_pdf/${$("#select_fecha_inicio").val().replaceAll("-", "")}/${$("#select_fecha_fin").val().replaceAll("-", "")}/${$("#select_estado_orden_cuerpo").val()}`);
            }

            $("#div_table_reporte_orden_cuerpo").html(html);

            $("#table_orden_cuerpo").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

iframe_view_document.addEventListener('load', () => {
    iframe_view_document.style.display = "block";
});

function view_orden_cuerpo_pdf(id) {
    iframe_view_document.style.display = "none";
    iframe_view_document.src = `/orden_cuerpo/show_pdf_orden_cuerpo/${id}`;
    $("#modal_view_pdf_orden_cuerpo").modal("show");
}