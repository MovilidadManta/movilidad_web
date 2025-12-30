let btnReporte = document.getElementById('btn_reporte_aportes');

$(document).ready(function () {
    configure_select_two_dates('select_fecha_inicio', 'select_fecha_fin');
});

btnReporte.addEventListener('click', () => {
    getTableReporte();
});

function getTableReporte() {
    let fechaInicio = document.getElementById('select_fecha_inicio');
    let fechaFin = document.getElementById('select_fecha_fin');

    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");

    $.ajax({
        url: `/aporte_ciudadano/get/${fechaInicio.value.replaceAll("-", "")}/${fechaFin.value.replaceAll("-", "")}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = "";

            html = configureTableHtml("table_aporte_ciudadano",
                ['CÉDULA', 'APELLIDOS Y NOMBRES', 'ORGANIZACIÓN', 'DIRECCIÓN', 'TELÉFONO', 'CORREO', 'FECHA'],
                ['ac_cedula', 'ac_apellidos_nombres', 'ac_organizacion', 'ac_direccion', 'ac_telefono', 'ac_email', 'ac_fecha'],
                response
            );

            $('#optionsDownload').fadeOut();

            if (response.length > 0) {
                $('#optionsDownload').fadeIn();
                $("#downloadExcel").attr("href", `/aporte_ciudadano/excel/${$("#select_fecha_inicio").val().replaceAll("-", "")}/${$("#select_fecha_fin").val().replaceAll("-", "")}`);
                $("#downloadPDF").attr("href", `/aporte_ciudadano/pdf/${$("#select_fecha_inicio").val().replaceAll("-", "")}/${$("#select_fecha_fin").val().replaceAll("-", "")}`);
            }

            $("#div_table_aportes_ciudadanos").html(html);

            $("#table_aporte_ciudadano").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}