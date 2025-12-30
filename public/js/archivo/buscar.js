let selectUnidadProductoraDocumento = document.getElementById('cup_id');
let selectUnidadProductoraSerieDocumento = document.getElementById('cups_id');
let selectConfiguracionDocumento = document.getElementById('cd_id');
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
    let datos = new FormData($("#form_buscar_documentos")[0]);

    $("#div_table_buscar_documentos").hide();
    $("#div_table_buscar_documentos_charge").show();

    $.ajax({
        url: '/buscar-documentos/getDocumentos',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            let html = configureTableHtml("table_buscar_documentos",
                ['#', 'BODEGA', 'UNIDAD PRODUCTORA', 'DOCUMENTO', 'CÓDIGO', 'CAMPOS', 'PDF', 'OPCIONES'],
                ['d_id', 'bodega', 'cup_nombre', 'cd_nombre', 'd_codigo',
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
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = "";
                            if (item.d_ruta_archivo != "") {
                                value = `<button type="button" onClick="view_documento_pdf('/lista-bodegas/getDocumento${item.d_ruta_archivo}')" class="tooltip"><i class="far fa-file-pdf tam-pdf"></i></button>'`;
                            }
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `
                            <button type="button" class="btn btn-info tooltip" Onclick ="show_detail_file(${item.d_id})"><span class="tooltiptext">Ver detalle</span><i class="fa fa-info icon_detail"></i></button>
                                `;
                        }
                    },
                ], response
            );

            $("#div_table_buscar_documentos").html(html);

            $("#table_buscar_documentos").DataTable({
                "language": {
                    "emptyTable": "No existen documentos disponibles"
                },
                "searching": false,
                "lengthChange": false,
                "order": [[0, 'desc']]
            });

            $("#div_table_buscar_documentos").show();
            $("#div_table_buscar_documentos_charge").hide();
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

function show_detail_file(id) {
    $.ajax({
        url: `/buscar-documentos/detail-document/${id}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            const bodega = document.getElementById('modal_detail_archivo_bodega');
            const unidadProductora = document.getElementById('modal_detail_archivo_unidad_productora');
            const serie = document.getElementById('modal_detail_archivo_serie');
            const TipoDocumento = document.getElementById('modal_detail_archivo_documento');
            const codigoDocumento = document.getElementById('modal_detail_archivo_codigo_documento');
            const nombreDocumento = document.getElementById('modal_detail_archivo_nombre_documento');
            const nroFolios = document.getElementById('modal_detail_archivo_nro_folio');
            const comentario = document.getElementById('modal_detail_archivo_comentario');
            const campos = document.getElementById('modal_detail_archivo_campos');
            const ubicacion = document.getElementById('modal_detail_archivo_ubicacion');
            const link = document.getElementById('modal_detail_archivo_link');
            let camposValor = "";
            let ubicacionValor = "";

            bodega.innerText = response.bodega;
            unidadProductora.innerText = response.cup_nombre;
            serie.innerText = response.cups_nombre;
            TipoDocumento.innerText = response.cd_nombre;
            codigoDocumento.innerText = response.d_codigo;
            nombreDocumento.innerText = response.d_nombre_archivo_original;
            nroFolios.innerText = response.d_nro_folio;
            comentario.innerText = response.d_comentario;

            JSON.parse(response.campos_unidades).forEach(c => {
                camposValor += `<span class="bold">${c.dc_nombre}: </span> ${c.dc_valor} \n`;
            });

            response.padre_medios.forEach(u => {
                ubicacionValor += `<span class="bold">${u.tipo}: </span> ${u.descripcion}(${u.codigo}) \n`;
            });


            campos.innerHTML = camposValor;
            ubicacion.innerHTML = ubicacionValor;

            link.href = `/lista-bodegas/${response.id_bodega}/${response.ma_id}`;

            $("#modal_detail_archivo").modal("show");
        }
    });
}

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