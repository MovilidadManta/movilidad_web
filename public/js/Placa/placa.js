$(document).ready(function () {
    //get_data_vehiculo()

})

function get_vehiculo() {
    // Cambiar el texto del botón mientras se carga
    $("#btn-consultar-p").html("<span class='spinner-border spinner-border-sm margin-spiner color-btn-nuevo'></span><span class='color-btn-nuevo'> Generando...!</span>");
    $("#div-table-placa-provisional").html("<span class='spinner-border spinner-border-sm margin-spiner'></span><span > Cargando la información... espere un momento....</span>");

    var placa = $("#txt-placa").val();
    var ht = "";

    $.ajax({
        url: '/consultar-vehiculo-placa-provisional/' + placa,
        type: "GET",
        dataType: "json",
        success: function (response) {
            // Verificar el status de la respuesta
            let status = response.status;

            // Verificar si el cuerpo de la respuesta está vacío
            if (response.body === '{}') {
                alert(response.message || "No se encontró información....¡¡");
            } else if (status === 200 && response.data) {
                console.log(response)
                $("#data_api").val(response.data['clase_transporte']);
                $(response.data).each(function (i, data) {
                    let placaActual = data.placaActual ?? placa.toUpperCase();
                    ht += '<div class="card">';
                    ht += '<div class="card-body">';
                    ht += '<form class="form" novalidate="" id="form-m-empleado" method="POST" enctype="multipart/form-data"></form>';
                    ht += '<h1 class="placa">' + placaActual + '</h1>';
                    ht += '<table id="table-placa-provisional" border="1" class="table table-bor">';
                    ht += '<tbody>';
                    ht += createTableRow('Cedula:', data.identBenef, 'Nombre del Propietario:', data.propietario, 'Oficina:', 'Manta');
                    ht += createTableRow('Marca:', data.marcaDesc, 'Modelo:', data.modeloDesc, 'Año Fab.:', data.anio);
                    ht += createTableRow('VIN O Chasis:', data.chasis, 'Nro de Motor:', data.motor, 'Clase de Transporte:', data.clase_transporte);
                    ht += createTableRow('Fecha de Matrícula:', data.fechaMatricula, 'Fecha de Caducidad:', data.fechaCaducidad, 'Color:', data.color_1);
                    ht += '</tbody>';
                    ht += '</table>';
                    ht += '</form>';
                    ht += '</div>';
                    ht += '</div>';
                    ht += ' <div class="col-md-12 mg-t-10 mg-lg-t-0 marg-a" align="right">'
                    ht += '     <a class="btn background-btn-nuevo pad-nu" id="btn-consultar-p" onclick="imprimir_placa_provisional(\'' + placaActual + '\', \'' + response.id + '\')"'
                    ht += '          target="_blank">'
                    ht += '         <i class="fa fa-print color-btn-nuevo"></i>'
                    ht += '         <strong class="color-btn-nuevo">Imprimir</strong>'
                    ht += '     </a>'
                    ht += `
                     <a class="btn background-btn-nuevo pad-nu" id="btn-consultar-p" onclick="imprimir_placa_provisional_v2('${placaActual}', '${response.id}')" target="_blank">
                        <i class="fa fa-print color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Imprimir v2</strong>
                     </a>
                    `;
                    ht += ' </div>'
                });
                $("#div-table-placa-provisional").html(ht);
            }

            // Restaurar el texto del botón
            $("#btn-consultar-p").html("<i class='fa fa-save color-btn-nuevo'></i><strong class='color-btn-nuevo'> Generar</strong>");
            //$("#div-table-placa-provisional").html("");
        },
        error: function (xhr, status, error) {
            // Manejo de errores en caso de fallo de la solicitud
            alert("Hubo un error al consultar la información....!");
            $("#btn-consultar-p").html("<i class='fa fa-save color-btn-nuevo'></i><strong class='color-btn-nuevo'> Generar</strong>");
            $("#div-table-placa-provisional").html("");
            $("#txt-placa").val("")
        }
    });
}

// Función para crear filas en la tabla de manera más eficiente
function createTableRow(label1, value1, label2, value2, label3, value3) {
    return `
        <tr>
            <td width="20%" class="color-td" align="left"><strong>${label1}</strong></td>
            <td class="color-td" align="left">${value1}</td>
            <td width="20%" class="color-td" align="left"><strong>${label2}</strong></td>
            <td class="color-td" align="left">${value2}</td>
            <td width="20%" class="color-td" align="left"><strong>${label3}</strong></td>
            <td class="color-td" align="left">${value3}</td>
        </tr>`;
}

function guardar_placa_provisional() {
    var token = $("#csrf-token").val();
    var datos = [{
        'placa': 'GTD1420',
        'data': $("#data_api").val()
    }]

    $.ajax({
        url: "/save-placa-provisional",
        type: "POST",
        dataType: "json",
        headers: { "X-CSRF-TOKEN": token },
        data: datos,
        success: function (response) {
            console.log(response.data);
            if (response.respuesta == "true") {
                alert("Registrado corectamente")
            }
        },
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 0) {
            alert("Not connect: Verify Network.");
        } else if (jqXHR.status == 404) {
            alert("Requested page not found [404]");
        } else if (jqXHR.status == 500) {
            alert("Internal Server Error [500]. Intente nuevamente");
        } else if (textStatus === "timeout") {
            alert("Time out error.");
        } else if (textStatus === "abort") {
            alert("Ajax request aborted.");
        }
    });
}

/*INICIO PARA FUNCION IMPRIMIR PLACA PROVISIONALES */
function imprimir_placa_provisional(placa, id) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");

    $.ajax({
        url: '/imprimir-placa-provisional/' + placa + '/' + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $("#div-table-placa-provisional").html("");
                $("#txt-placa").val("")

                // Abrir el PDF en una nueva pestaña utilizando la nueva ruta
                let nombreArchivo = placa + '_' + id + '.pdf';
                window.location.href = '/descargar-ftp/' + nombreArchivo;
                //window.open('/descargar-ftp/' + filename, '_blank');
                $("#global-loader").addClass("none").removeClass("block");
            }
        }
    });
}

function imprimir_placa_provisional_v2(placa, id) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");

    $.ajax({
        url: '/imprimir_placa_provisional_v2/' + placa + '/' + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $("#div-table-placa-provisional").html("");
                $("#txt-placa").val("")

                // Abrir el PDF en una nueva pestaña utilizando la nueva ruta
                let nombreArchivo = placa + '_' + id + '.pdf';
                window.location.href = '/descargar-ftp-v2/' + nombreArchivo;
                //window.open('/descargar-ftp/' + filename, '_blank');
                $("#global-loader").addClass("none").removeClass("block");
            }
        }
    });
}
/*FIN PARA FUNCION IMPRIMIR PLACA PROVISIONALES */
