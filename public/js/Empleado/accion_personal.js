$(document).ready(function () {
    configure_select_two_dates('select-fecha-inicio', 'select-fecha-fin');

    $('#btn-reporte-accion-personal').on("click", function () {
        getAccionPersonal();
    });
});
let iframe_view_document = document.getElementById('iframe_visor_pdf');

function getAccionPersonal() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: `/get_list_acciones_personal/${$("#select-fecha-inicio").val().replaceAll("-", "")}/${$("#select-fecha-fin").val().replaceAll("-", "")}/${$("#select-tipo-accion").val() == 0 ? '' : $("#select-tipo-accion").val()}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table-acciones-empleados",
                ['FECHA DE REGISTRO', 'SECUENCIAL', 'TIPO DE ACCIÓN', 'CÉDULA', 'EMPLEADO', 'DEPARTAMENTO', 'CARGO', 'PDF'
                ],
                ['ap_fecha_accion_personal', 'ap_secuencial', 'tap_descripcion', 'emp_cedula',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `${item.apellido_empleado} ${item.nombre_empleado}`;
                        }
                    },
                    'departamento_empleado', 'cargo_empleado',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `<button type="button" onClick="view_accion_personal_pdf(${item.ap_id})" class="tooltip"><span class="tooltiptext">Ver PDF</span> <i class="far fa-file-pdf tam-pdf"></i></a>`;
                        }
                    }
                ], response
            );

            $("#div-table-accion-personal").html(html);

            $("#table-acciones-empleados").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function view_accion_personal_pdf(id) {
    iframe_view_document.style.display = "none";
    iframe_view_document.src = `/view_accion_personal/${id}`;
    $("#modal_view_pdf_accion").modal("show");
}

iframe_view_document.addEventListener('load', () => {
    iframe_view_document.style.display = "block";
});