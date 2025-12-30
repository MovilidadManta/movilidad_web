$(document).ready(function () {
    configure_select_two_dates('select-fecha-inicio', 'select-fecha-fin');

    $('#btn-reporte-transacciones').on("click", function () {
        getTransacciones();
    });
});


function getTransacciones() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: `/orquestadorapi/transacciones/get/${$("#select-fecha-inicio").val().replaceAll("-", "")}/${$("#select-fecha-fin").val().replaceAll("-", "")}/${$("#txt_usuario").val()}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table_transacciones",
                ['ID', 'FECHA', 'UUID', 'MODULO', 'PETICION', 'FORMATO', 'VERBO', 'URL', 'CODIGO', 'RESPUESTA',
                    'RESPUESTA API', 'IP', 'RUC', 'NOMBRE EMPRESA'
                ],
                ['t_id', 't_fecha', 't_uuid', 'p_modulo', 'p_peticion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let formato = 'SOAP';
                            if (item.p_format_api == 2)
                                formato = 'API';
                            return formato;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let verbo = 'GET';
                            if (item.p_verb_send == 2)
                                verbo = 'POST';
                            if (item.p_verb_send == 3)
                                verbo = 'PUT';
                            if (item.p_verb_send == 4)
                                verbo = 'DELETE';
                            return verbo;
                        }
                    },
                    'ps_url', 't_code',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return escapeXML(item.t_body);
                        }
                    },
                    't_body_api', 't_ip', 'e_ruc',
                    'e_nombre_empresa'
                ], response
            );

            $("#div_table_transacciones").html(html);

            $("#table_transacciones").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}


function escapeXML(xml) {
    console.log(String(xml));
    return String(xml)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}