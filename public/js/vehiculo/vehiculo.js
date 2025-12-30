$(document).ready(function () {

})

function get_vehiculo() {
    // Cambiar el texto del botón mientras se carga
    $("#btn-consultar-p").html("<span class='spinner-border spinner-border-sm margin-spiner color-btn-nuevo'></span><span class='color-btn-nuevo'> Consultando...!</span>");
    $("#div-table-placa-provisional").html("<span class='spinner-border spinner-border-sm margin-spiner'></span><span > Cargando la información... espere un momento....</span>");

    var placa = $("#txt-placa").val();
    var ht = "";

    $.ajax({
        url: '/consultar-vehiculo/' + placa,
        type: "GET",
        dataType: "json",
        success: function (response) {
            // Verificar el status de la respuesta
            let status = response.status;

            // Verificar si el cuerpo de la respuesta está vacío
            if (response.body === '{}') {
                alert(response.message || "No se encontró información.");
            } else if (status === 200 && response.data) {
                $(response.data).each(function (i, data) {
                    ht += '<div class="card">';
                    ht += '<div class="card-body">';
                    ht += '<form class="form" novalidate="" id="form-m-empleado" method="POST" enctype="multipart/form-data"></form>';
                    ht += '<table id="table-placa-provisional" border="1" class="table table-bor">';
                    ht += '<tbody>';
                    ht += createTableRow('Cedula:', data.identBenef, 'Nombre del Propietario:', data.propietario, 'Oficina:', 'Manta');
                    ht += createTableRow('VIN O Chasis:', data.chasis, 'Clase de Transporte Terrestre:', data.clase_transporte);
                    ht += createTableRow('Marca:', data.marcaDesc, 'SubClase de Transporte Terrestre:', data.clase_transporte);
                    ht += createTableRow('Modelo:', data.modeloDesc, 'Ambito de Operación:', data.tipoServicio);
                    ht += createTableRow('Año Fab:', data.anio, 'Tipo de Transporte:', data.clase_transporte);
                    ht += createTableRow('Fecha de Matrícula:', data.fechaMatricula, 'Clase de Servicio:', data.clase_servicio);
                    ht += createTableRow('Fecha de Caducidad:', data.fechaCaducidad, 'Color 1:', data.color_1);
                    ht += createTableRow('Nro de Motor:', data.motor, 'Indicador de Ortopedico:', 'No sabemos');
                    ht += createTableRow('Combustible:', data.combustible, 'Carroceria:', data.carroceria);
                    ht += createTableRow('Tipo de Vehiculo:', data.tipoVehiculo, 'Tipo de Peso:', data.tipoPeso);
                    ht += '</tbody>';
                    ht += '</table>';
                    ht += '</form>';
                    ht += '</div>';
                    ht += '</div>';
                });
                $("#div-table-placa-provisional").html(ht);
            }

            // Restaurar el texto del botón
            $("#btn-consultar-p").html("<i class='fa fa-search color-btn-nuevo'></i><strong class='color-btn-nuevo'> Consultar</strong>");
            //$("#div-table-placa-provisional").html("");
        },
        error: function (xhr, status, error) {
            // Manejo de errores en caso de fallo de la solicitud
            alert("Hubo un error al consultar la información....!");
            $("#btn-consultar-p").html("<i class='fa fa-search color-btn-nuevo'></i><strong class='color-btn-nuevo'> Consultar</strong>");
            $("#div-table-placa-provisional").html("");
        }
    });
}

// Función para crear filas en la tabla de manera más eficiente
function createTableRow(label1, value1, label2, value2) {
    return `
        <tr>
            <td width="20%" class="color-td" align="left"><strong>${label1}</strong></td>
            <td class="color-td" align="left">${value1}</td>
            <td width="20%" class="color-td" align="left"><strong>${label2}</strong></td>
            <td class="color-td" align="left">${value2}</td>
        </tr>`;
}

