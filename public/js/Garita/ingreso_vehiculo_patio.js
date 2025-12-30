const btnAgregarIngresoVehiculoPatio = document.getElementById('btn_add_ingreso_vehiculo_patio');
const btnDeleteIngresoVehiculoPatio = document.getElementById('btn_delete_ingreso_vehiculo_patio');
//---------------------------------------------------------------------

function limpiarCamposIngresoVehiculo() {
    id_ingreso_vehiculo_patio.value = "";
    txt_articulo.value = "";
    txt_numeral.value = "";
    txt_literal.value = "";
    txt_resolucion.value = "";
    txt_autoridad.value = "";
    txt_oficio.value = "";
    txt_cedula_conductor.value = "";
    txt_nombre_conductor.value = "";
    txt_tipo_licencia_conductor.value = "-1";
    txt_placa_vehiculo.value = "";
    txt_tipo_placa_vehiculo.value = "-1";
    txt_marca_vehiculo.value = "";
    txt_modelo_vehiculo.value = "";
    txt_color1_vehiculo.value = "";
    txt_ramv_vehiculo.value = "";
    txt_chasis_vehiculo.value = "";
    txt_motor_vehiculo.value = "";
    txt_servicio_vehiculo.value = "-1";
    select_medio_ingreso.value = "-1";
    txt_medio_ingreso_empresa.value = "";
    txt_medio_ingreso_datos_translado.value = "";

    txt_cedula_agente_retiene.value = "";
    txt_nombre_agente_retiene.value = "";
    txt_email_agente_retiene.value = "";
    txt_cedula_agente_ingresa.value = "";
    txt_nombre_agente_ingresa.value = "";
    txt_cedula_responsable.value = "";
    txt_nombre_responsable.value = "";
    txt_email_responsable.value = "";

    select_medio_ingreso.dispatchEvent(new Event("change"));
}

$(document).ready(function () {

    getIngresoVehiculoPatio();

    setInputValidations('txt_medio_ingreso_empresa_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
    setInputValidations('txt_medio_ingreso_datos_translado_modal_agregar_ingreso_vehiculo_patio', ['notEmpty'], []);
});

btnAgregarIngresoVehiculoPatio.addEventListener('click', () => {
    /*
    txtTitulo.value = "";
    txtDescripcion.value = "";
    txtDetalleTitulo.value = "";
    SelectDetalleTipo.value = 1;
    .card_ingreso
    */
    accionFormulario = "ADD";
    clearClickeado();
    descripcion_ingreso_vehicular.value = "";
    containerInventarioVehiculo.innerHTML = "";
    containerDocumentosVehiculo.innerHTML = "";

    limpiarCamposIngresoVehiculo();
    sectionDatosGenerales.dispatchEvent(new Event("click"));
    inputImagenes.clearImagenes();
    $("#modal_tipo_ingreso").modal("show");
});

function getIngresoVehiculoPatio() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/garita/ingreso_vehiculo_patio/list',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table_ingreso_patio_vehiculo",
                ['#', 'TIPO DE INGRESO', 'TIPO DE VEHÍCULO', 'PLACA', 'C.I PROPIETARIO', 'DESCRIPCIÓN', 'FECHAS', 'VALOR', 'ESTADO', 'OPCIONES'
                ],
                ['ivp_id', 'tiv_nombre', 'tv_nombre', 'ivp_vehiculo_placa',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `${item.ivp_conductor_identificacion} -> ${item.ivp_conductor_nombres}`;
                        }
                    }, 'ivp_descripcion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let render = `<p><b class="tittle_ingresado">Ingresado:</b> ${item.ivp_fecha_update}</p>`;
                            if (item.rvp_fecha_retiro) render += `<p><b>Salida:</b> ${item.rvp_fecha_retiro}</p>`;
                            return render;
                        }
                    },
                    'tv_valor',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return item.ivp_estado
                                ? '<span class="badge bg-success me-1">Activo</span>'
                                : '<span class="badge bg-danger me-1">Inactivo</span>';
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `
                            <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ='show_mod_ingreso_vehiculo_patio(${item.ivp_id})'><i class="fa fa-edit tam-icono"></i></button>
                            <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_ingreso_vehiculo_patio(${item.ivp_id})"><i class="fa fa-trash tam-icono"></i></button>
                            `;
                        }
                    },
                ], response
            );

            $("#div_table_ingreso_vehiculo_patio").html(html);

            $("#table_ingreso_patio_vehiculo").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function show_delete_ingreso_vehiculo_patio(id) {
    idIngresoVehiculoPatioToDelete = id;
    $("#modal_confirm_delete_ingreso_vehiculo_patio").modal("show");
}

btnDeleteIngresoVehiculoPatio.addEventListener('click', function () {
    let id = idIngresoVehiculoPatioToDelete;
    let token = $("#csrf-token-modal_confirm_delete_ingreso_vehiculo_patio").val();
    $.ajax({
        url: `/garita/ingreso_vehiculo_patio/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Ingreso al patio eliminado!",
                    type: "success",
                    zindex: 99999
                });
                idIngresoVehiculoPatioToDelete = 0;
                $("#modal_confirm_delete_ingreso_vehiculo_patio").modal('hide');
                getIngresoVehiculoPatio();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar el ingreso al patio!",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_ingreso_vehiculo_patio").modal('hide');
            }
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
