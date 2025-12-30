const btnSearchPlaca = document.getElementById('btn_buscar_placa');
const txtPlacaSearch = document.getElementById('txt_nro_placa');

/* Controles para mostrar info */
const placa_actual = document.getElementById('txt_placa_actual');
const anio_matriculado = document.getElementById('txt_anio_matriculado');

const color = document.getElementById('txt_color_1');
const chasis = document.getElementById('txt_chasis');
const motor = document.getElementById('txt_motor');
const ramv = document.getElementById('txt_ramv');
const marca = document.getElementById('txt_marca');
const modelo = document.getElementById('txt_modelo');
const anio = document.getElementById('txt_anio');
const nombre_propietario = document.getElementById('txt_nombre_propietario');
const cedula_propietario = document.getElementById('txt_cedula_propietario');
const cilindraje = document.getElementById('txt_cilindraje');
const tipo_servicio = document.getElementById('txt_tipo_servicio');
const clase_servicio = document.getElementById('txt_clase_servicio');
const clase_transporte = document.getElementById('txt_clase_transporte');

const btnAprobar = document.getElementById('btn_aprobar');
/* ------ Mensaje de aprobar ------ */
const txtMensajeEmergente = document.getElementById('txt_message_emergente');
/* ------ Fin de mensaje aprobar ------ */

/* Controles modal aprobar RTV */
const name_modal_aprobar_rtv = "modal_aprobar_rtv";
const clase_servicio_aprobar = document.getElementById(`txt_clase_servicio_${name_modal_aprobar_rtv}`);
const clase_transporte_aprobar = document.getElementById(`txt_clase_transporte_${name_modal_aprobar_rtv}`);
const tipo_servicio_aprobar = document.getElementById(`txt_tipo_servicio_${name_modal_aprobar_rtv}`);
const numero_revision_aprobar = document.getElementById(`txt_numero_revision_${name_modal_aprobar_rtv}`);
const solicitud_aprobar = document.getElementById(`txt_solicitud_${name_modal_aprobar_rtv}`);
const placa_aprobar = document.getElementById(`txt_placa_${name_modal_aprobar_rtv}`);
const vin_aprobar = document.getElementById(`txt_vin_${name_modal_aprobar_rtv}`);
const orden_generada_aprobar = document.getElementById(`txt_orden_generada_${name_modal_aprobar_rtv}`);
const mensaje_orden_aprobar = document.getElementById(`txt_mensaje_orden_${name_modal_aprobar_rtv}`);
const btnAprobarRTV = document.getElementById('btn_aprobar_rtv');

const btnAprobarManyRTV = document.getElementById('btn_aprobar_many');
const txtPlacasList = document.getElementById('txt_placas');
const txtPlacasListMano = document.getElementById('txt_placas_mano');
const txtPlacasErrores = document.getElementById('txt_placas_errores');
const txtPlacasOk = document.getElementById('txt_placas_ok');

const btnAprobarNumeroOrdenRTV = document.getElementById('btn_aprobar_numero_orden');
const txtNumeroOrdenAprobar = document.getElementById('txt_numero_orden_aprobar');
const txtMensajeAntAprobar = document.getElementById('txt_mensaje_ant_aprobar');

const btnAnularNumeroOrdenRTV = document.getElementById('btn_anular_numero_orden');
const txtNumeroOrdenAnular = document.getElementById('txt_numero_orden_anular');
const txtIdInstitucionAnular = document.getElementById('txt_id_institucion_anular');
const txtMotivoAnular = document.getElementById('txt_motivo_anular');
const txtMensajeAntAnular = document.getElementById('txt_mensaje_ant_anular');

const cmbCommentOne = document.getElementById('cmb_comment_one');
const cmbCommentMany = document.getElementById('cmb_comment_many');
const cmbCommentAprobar = document.getElementById('cmb_comment_numero_orden');
const cmbCommentAnular = document.getElementById('cmb_comment_anular');

const btnReporteDiario = document.getElementById('btn_reporte_aprobados_diarios');

const btnReporteApi = document.getElementById('btn_reporte_aprobados_api');

const btnConteoDiario = document.getElementById('btn_refrescar_conteo_diarios');
/* Fin Controles modal aprobar RTV */

$(document).ready(function () {
    configure_select_two_dates('select_fecha_inicio_aprobar', 'select_fecha_fin_aprobar');
    configure_select_two_dates('select_fecha_inicio_api', 'select_fecha_fin_api');
});


function last_secuencial() {
    $.ajax({
        url: '/aprobacion_rtv/last_secuencial',
        type: "GET",
        dataType: "json",
        success: function (response) {
            solicitud_aprobar.value = response;
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud:", error);
        }
    });
}

function clearControlsSearchPlaca() {
    placa_actual.value = "";
    anio_matriculado.value = "";
    color.value = "";
    chasis.value = "";
    motor.value = "";
    ramv.value = "";
    marca.value = "";
    modelo.value = "";
    anio.value = "";
    nombre_propietario.value = "";
    cedula_propietario.value = "";
    cilindraje.value = "";
    tipo_servicio.value = "";
    clase_servicio.value = "";
    clase_transporte.value = "";
}

btnSearchPlaca.addEventListener('click', () => {
    btnSearchPlaca.disabled = true;
    clearControlsSearchPlaca();
    $.ajax({
        url: `/aprobacion_rtv/placa/${txtPlacaSearch.value}`,
        type: "GET",
        dataType: "json",
        success: function (response) {

            if (response.message != "OK") {
                txtMensajeEmergente.innerText = response.message;
                $("#modal_message_emergente").modal("show");
                return;
            }

            const data = response.data.data;
            placa_actual.value = data.placaActual ?? txtPlacaSearch.value.toUpperCase();
            anio_matriculado.value = data.anio_matriculado ?? "";
            color.value = data.color_1 ?? "";
            chasis.value = data.chasis ?? "";
            motor.value = data.motor ?? "";
            ramv.value = data.canvcp ?? "";
            marca.value = data.marcaDesc ?? "";
            modelo.value = data.modeloDesc ?? "";
            anio.value = data.anio ?? "";
            nombre_propietario.value = data.nombreBenef ?? "";
            cedula_propietario.value = data.identBenef ?? "";
            cilindraje.value = data.cilindraje ?? "";
            tipo_servicio.value = data.tipoServicio ?? "";
            clase_servicio.value = data.clase_servicio ?? "";
            clase_transporte.value = data.clase_transporte ?? "";
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud:", error);
        },
        complete: function () {
            // Esto se ejecuta siempre, haya éxito o error
            btnSearchPlaca.disabled = false;
        }
    });
});

btnAprobar.addEventListener('click', () => {

    last_secuencial();

    if (placa_actual.value == "") {
        txtMensajeEmergente.innerText = "Por favor indique una placa para aprobar";
        $("#modal_message_emergente").modal("show");
        return;
    }

    clase_servicio_aprobar.value = clase_servicio.value;
    clase_transporte_aprobar.value = clase_transporte.value;
    tipo_servicio_aprobar.value = tipo_servicio.value;
    numero_revision_aprobar.value = "1";
    solicitud_aprobar.value = "";
    placa_aprobar.value = placa_actual.value;
    vin_aprobar.value = chasis.value;
    orden_generada_aprobar.value = "";
    mensaje_orden_aprobar.value = "";
    btnAprobarRTV.disabled = false;

    $(`#${name_modal_aprobar_rtv}`).modal("show");
});

btnAprobarRTV.addEventListener('click', () => {

    if (placa_aprobar.value == "") {
        txtMensajeEmergente.innerText = "Por favor indique una placa para la aprobación";
        $("#modal_message_emergente").modal("show");
        return;
    }

    const token = $(`#csrf_token_${name_modal_aprobar_rtv}`).val();
    const datos = new FormData($(`#form_${name_modal_aprobar_rtv}`)[0]);
    datos.append("comment", cmbCommentOne.value);
    btnAprobarRTV.disabled = true;

    $.ajax({
        url: '/aprobacion_rtv/aprobar_rtv',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {

            if (response.message != "OK") {
                txtMensajeEmergente.innerText = response.message;
                $("#modal_message_emergente").modal("show");
                btnAprobarRTV.disabled = false;
                return;
            }

            orden_generada_aprobar.value = response.orden_generada;
            mensaje_orden_aprobar.value = response.mensaje_orden;
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

btnAprobarManyRTV.addEventListener('click', () => {
    if (txtPlacasList.value == "") {
        txtMensajeEmergente.innerText = "Por favor indique las placas para la aprobación";
        $("#modal_message_emergente").modal("show");
        return;
    }

    txtPlacasErrores.value = "";
    txtPlacasOk.value = "";
    txtPlacasListMano.value = "";

    let tipoServicio_many;
    let claseServicio_many;
    let claseTransporte_many;
    let placa_many;
    let revision_many;
    let solicitud_many;
    let vin_many;

    const texto = txtPlacasList.value;

    // Dividir el texto por saltos de línea (\n)
    const lineas = texto.split(/\r?\n/).map(linea => linea.trim());

    // Mostrar cada línea en consola
    lineas.forEach((linea, indice) => {
        $.ajax({
            url: `/aprobacion_rtv/placa/${linea}`,
            type: "GET",
            dataType: "json",
            success: function (response) {

                if (response.message != "OK") {
                    txtPlacasErrores.value += `${linea} -> ${response.message} \r\n`;
                    return;
                }

                const data = response.data.data;

                tipoServicio_many = data.tipoServicio ?? "";
                claseServicio_many = data.clase_servicio ?? "";
                claseTransporte_many = data.clase_transporte ?? "";
                placa_many = data.placaActual;
                revision_many = 1;
                solicitud_many = 1;
                vin_many = data.chasis ?? "";

                if (tipoServicio_many.trim() == "" ||
                    claseServicio_many.trim() == "" ||
                    claseTransporte_many.trim() == "") {
                    txtPlacasListMano.value += `${linea} \r\n`;
                    txtPlacasErrores.value += `${linea} -> Realizar a mano \r\n`;
                } else {
                    const token = $(`#csrf_token_${name_modal_aprobar_rtv}`).val();
                    const datos = new FormData();
                    datos.append("clase_servicio", claseServicio_many);
                    datos.append("clase_transporte", claseTransporte_many);
                    datos.append("tipo_servicio", tipoServicio_many);
                    datos.append("numero_revision", revision_many);
                    datos.append("solicitud", solicitud_many);
                    datos.append("placa", placa_many);
                    datos.append("vin", vin_many);
                    datos.append("comment", cmbCommentMany.value);

                    $.ajax({
                        url: '/aprobacion_rtv/aprobar_rtv',
                        type: 'POST',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': token },
                        contentType: false,
                        processData: false,
                        data: datos,
                        success: function (response) {
                            if (response.message != "OK") {
                                txtPlacasErrores.value += `${placa_many} -> ${response.message} \r\n`;
                                return;
                            }

                            txtPlacasOk.value += `${placa_many} Orden Generada: ${response.orden_generada} ANT ${response.mensaje_orden ?? 'ANT NO FINALIZO'} \r\n`;
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
                }


            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud:", error);
            },
            complete: function () {
                // Esto se ejecuta siempre, haya éxito o error
                btnSearchPlaca.disabled = false;
            }
        });
    });

});

btnAprobarNumeroOrdenRTV.addEventListener("click", () => {
    if (txtNumeroOrdenAprobar.value == "") {
        txtMensajeEmergente.innerText = "Por favor indique el número de orden";
        $("#modal_message_emergente").modal("show");
        return;
    }

    const token = $(`#csrf_token_${name_modal_aprobar_rtv}`).val();
    const datos = new FormData();
    datos.append("numero_orden", txtNumeroOrdenAprobar.value.trim());
    datos.append("comment", cmbCommentAprobar.value);

    $.ajax({
        url: '/aprobacion_rtv/aprobar_numero_orden',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.message != "OK") {
                txtMensajeEmergente.innerText = response.message;
                $("#modal_message_emergente").modal("show");
                return;
            }

            txtMensajeAntAprobar.value = response.mensaje_orden;
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

btnAnularNumeroOrdenRTV.addEventListener("click", () => {
    if (txtNumeroOrdenAnular.value.trim() == "") {
        txtMensajeEmergente.innerText = "Por favor indique el Número de orden";
        $("#modal_message_emergente").modal("show");
        return;
    }

    if (txtIdInstitucionAnular.value.trim() == "") {
        txtMensajeEmergente.innerText = "Por favor indique el Identificador de Institución";
        $("#modal_message_emergente").modal("show");
        return;
    }

    if (txtMotivoAnular.value.trim() == "") {
        txtMensajeEmergente.innerText = "Por favor indique el Motivación de la anulación";
        $("#modal_message_emergente").modal("show");
        return;
    }

    const token = $(`#csrf_token_${name_modal_aprobar_rtv}`).val();
    const datos = new FormData();
    datos.append("numero_orden", txtNumeroOrdenAnular.value.trim());
    datos.append("id_institucion", txtIdInstitucionAnular.value.trim());
    datos.append("motivo", txtMotivoAnular.value.trim());
    datos.append("comment", cmbCommentAnular.value);

    $.ajax({
        url: '/aprobacion_rtv/anular_orden',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response);
            if (response.message != "OK") {
                txtMensajeEmergente.innerText = response.message;
                $("#modal_message_emergente").modal("show");
                return;
            }

            txtMensajeAntAnular.value = response.result_anular == "S" ? "ANULADO CON EXITO" : "NO SE ANULO LA ORDEN";
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

btnReporteDiario.addEventListener("click", () => {
    $.ajax({
        url: `/aprobacion_rtv/report_table/${$("#select_fecha_inicio_aprobar").val().replaceAll("-", "")}/${$("#select_fecha_fin_aprobar").val().replaceAll("-", "")}/${$("#select_estado_reporte_diario").val()}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response);

            let html = configureTableHtml("table_reporte_diario",
                ['Fecha / Hora', 'Placa', 'Orden', 'Comentario'],
                ['pr_fecha', 'pr_placa', 'pr_result', 'pr_comment']
                , response
            );

            $('#optionsDownload_aprobar').fadeOut();

            if (response.length > 0) {
                $('#optionsDownload_aprobar').fadeIn();
                $("#downloadExcel").attr("href", `/aprobacion_rtv/report_excel/${$("#select_fecha_inicio_aprobar").val().replaceAll("-", "")}/${$("#select_fecha_fin_aprobar").val().replaceAll("-", "")}/${$("#select_estado_reporte_diario").val()}`);
            }

            $("#div_table_reporte_diario").html(html);

            $("#table_reporte_diario").DataTable({
                "order": [[0, 'desc']]
            });

        }
    });
});

btnReporteApi.addEventListener("click", () => {
    $.ajax({
        url: `/aprobacion_rtv/report_api/${$("#select_fecha_inicio_api").val().replaceAll("-", "")}/${$("#select_fecha_fin_api").val().replaceAll("-", "")}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response);

            let html = configureTableHtml("table_reporte_api",
                ['Fecha / Hora', 'Placa', 'Orden'],
                ['fecha', 'placa', 'orden']
                , response
            );

            $('#optionsDownload_aprobar').fadeOut();

            if (response.length > 0) {
                $('#optionsDownload_api').fadeIn();
                $("#downloadExcelApi").attr("href", `/aprobacion_rtv/report_excel_api/${$("#select_fecha_inicio_api").val().replaceAll("-", "")}/${$("#select_fecha_fin_api").val().replaceAll("-", "")}`);
            }

            $("#div_table_reporte_api").html(html);

            $("#table_reporte_api").DataTable({
                "order": [[0, 'desc']]
            });

        }
    });
});

btnConteoDiario.addEventListener("click", () => {
    $.ajax({
        url: `/aprobacion_rtv/get_curent_date`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response);

            let html = configureTableHtml("table_conteo_diario",
                ['Comentario', 'Total'],
                ['comentario', 'total']
                , response
            );

            $("#div_table_conteo_diario").html(html);

            $("#table_conteo_diario").DataTable({
                "order": [[0, 'desc']]
            });

        }
    });
});