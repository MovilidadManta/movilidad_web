let selectUnidadProductoraDocumento = document.getElementById('cup_id');
let selectUnidadProductoraSerieDocumento = document.getElementById('cups_id');
let selectConfiguracionDocumento = document.getElementById('cd_id');
let bodega = document.getElementById('bodega');
let txtBusqueda = document.getElementById('txt_busqueda');
let btnBusqueda = document.getElementById('btn_buscar_documento');
let loadPrimeraVez = true;

$(document).ready(function () {
    getUnidadProductoraDocumento();

    $('#txt_busqueda').on('keypress', function (e) {
        // Verificamos si la tecla presionada es "Enter"
        if (e.which === 13) {
            // Cancelamos el envío del formulario
            e.preventDefault();
        }
    });
});

selectUnidadProductoraDocumento.addEventListener('change', (e) => {
    let valuesSerie = selectUnidadProductoraDocumento.querySelector(`option[value^="${e.target.value}"]`);
    let values = JSON.parse(valuesSerie.dataset.serie);
    selectUnidadProductoraSerieDocumento.innerHTML = "";
    selectUnidadProductoraSerieDocumento.innerHTML += "<option value='0' data-serie='[]'>TODOS</option>";
    values.forEach(v => {
        selectUnidadProductoraSerieDocumento.innerHTML += `<option value='${v.cups_id}'>${v.cups_nombre}</option>`;
    });
    selectUnidadProductoraSerieDocumento.dispatchEvent(new Event('change'));
});

selectUnidadProductoraSerieDocumento.addEventListener('change', (e) => {
    getUnidadProductoraDocumentoDoc(e.target.value);
});

btnBusqueda.addEventListener('click', () => {
    let token = $("#csrf_token").val();
    let datos = new FormData($("#form_reporte_documentos")[0]);

    $("#div_table_reporte_documentos").hide();
    $("#div_table_reporte_documentos_charge").show();

    $.ajax({
        url: '/buscar-documentos/getDocumentos',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            let html = configureTableHtml("table_reporte_documentos",
                ['#', 'BODEGA', 'UNIDAD PRODUCTORA', 'SERIE', 'DOCUMENTO', 'CÓDIGO', 'NRO FOLIOS', 'COMENTARIOS', 'CAMPOS'],
                ['d_id', 'bodega', 'cup_nombre', 'cups_nombre', 'cd_nombre', 'd_codigo', 'd_nro_folio', 'd_comentario',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '<p style="white-space: pre-line;">';
                            JSON.parse(item.campos_unidades).forEach(c => {
                                value += `[${c.dc_nombre},${c.dc_valor}] \n`;
                            });
                            value += '</p>'
                            return value;
                        }
                    }
                ], response
            );

            $('#optionsDownload').fadeOut();

            if (response.length > 0) {
                $('#optionsDownload').fadeIn();
                $("#downloadExcel").attr("href", `/buscar-documentos/get_excel_reporte_archivos/${bodega.value}/${selectUnidadProductoraDocumento.value}/${selectUnidadProductoraSerieDocumento.value}/${selectConfiguracionDocumento.value}/${txtBusqueda.value}`);
                $("#downloadPDF").attr("href", `/buscar-documentos/get_pdf_reporte_archivos/${bodega.value}/${selectUnidadProductoraDocumento.value}/${selectUnidadProductoraSerieDocumento.value}/${selectConfiguracionDocumento.value}/${txtBusqueda.value}`);
                //$("#downloadExcel").attr("download", `Reporte_Permisos_${$("#select-fecha-inicio").val().replaceAll("-", "")}_${$("#select-fecha-fin").val().replaceAll("-", "")}.xlsx`);
            }

            $("#div_table_reporte_documentos").html(html);

            $("#table_reporte_documentos").DataTable({
                "language": {
                    "emptyTable": "No existen documentos disponibles"
                },
                "searching": false,
                "lengthChange": false,
                "order": [[0, 'desc']]
            });

            $("#div_table_reporte_documentos").show();
            $("#div_table_reporte_documentos_charge").hide();
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 0) {
            alert('Not connect: Verify Network.');
        } else if (jqXHR.status == 404) {
            alert('Requested page not found [404]');
        } else if (jqXHR.status == 500) {
            alert('Internal Server Error [500]. Intente nuevamente');
        } else if (textStatus === 'timeout') {
            alert('Time out error.');
        } else if (textStatus === 'abort') {
            alert('Ajax request aborted.');
        }
    });
});

function getUnidadProductoraDocumento() {
    $.ajax({
        url: `/lista-bodegas/getUnidadProductora/0`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            selectUnidadProductoraDocumento.innerHTML = "";
            selectUnidadProductoraDocumento.innerHTML += "<option value='0' data-serie='[]'>TODOS</option>";
            response.forEach(v => {
                selectUnidadProductoraDocumento.innerHTML += `<option value='${v.cup_id}' data-serie='${JSON.stringify(JSON.parse(v.campos_serie))}'>${v.cup_nombre}</option>`;
            });
            selectUnidadProductoraDocumento.dispatchEvent(new Event('change'));
        }
    });
}

function getUnidadProductoraDocumentoDoc(id) {
    $.ajax({
        url: `/lista-bodegas/getUnidadProductoraSerieDocumento/${id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            selectConfiguracionDocumento.innerHTML = "";
            selectConfiguracionDocumento.innerHTML += "<option value='0' data-serie='[]'>TODOS</option>";
            response.forEach(v => {
                selectConfiguracionDocumento.innerHTML += `<option value='${v.cd_id}'>${v.cd_nombre}</option>`;
            });
            selectConfiguracionDocumento.dispatchEvent(new Event('change'));

            if (loadPrimeraVez) {
                btnBusqueda.dispatchEvent(new Event('click'));
                loadPrimeraVez = false;
            }
        }
    });
}

function view_documento_pdf(ruta) {
    let iframe = document.getElementById('iframe_documento_pdf');
    iframe.style.display = "none";
    iframe.src = ruta;
    $("#modal_view_pdf").modal("show");

    iframe.addEventListener('load', () => {
        iframe.style.display = "block";
    });
}