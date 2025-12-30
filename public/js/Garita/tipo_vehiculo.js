let btnAnadirRegistro = document.getElementById('btn_add_tipo_vehiculo');
let btnBorrarRegistro = document.getElementById('btn_confirm_delete_tipo_vehiculo');
let btnCancelBorrarRegistro = document.getElementById('btn_cancelar_delete_tipo_vehiculo');
let modalConfirmDeleteRegister = "#modal_confirmacion_delete_tipo_vehiculo";
let id_table_tipo_vehiculo = 'table_tipo_vehiculo';
let idTipoVehiculoToDelete = 0;

//controles formulario ingresar o modificar convocatoria de arrendamiento
let btnSaveTipoVehiculo = document.getElementById('btn_guardar_tipo_vehiculo');
let txtNombre = document.getElementById('txt_nombre_modal_add_mod_tipo_vehiculo');
let txtValor = document.getElementById('txt_valor_modal_add_mod_tipo_vehiculo');
let txtObservacion = document.getElementById('txt_observacion_modal_add_mod_tipo_vehiculo');
let idInput = document.getElementById('id_modal_add_mod_tipo_vehiculo');
let formulario = document.getElementById('form_modal_add_mod_tipo_vehiculo');
let estado_tipo_vehiculo = document.getElementById('chk_estado_modal_add_mod_tipo_vehiculo');
let accionFormulario = "ADD";
//------------------------------------

$(document).ready(function () {
    getListarTipoVehiculos();
    $('.dropify').dropify();

    set_type_input('txt_valor_modal_add_mod_tipo_vehiculo', "decimal");
    setInputValidations('txt_nombre_modal_add_mod_tipo_vehiculo', ['notEmpty'], []);
    setInputValidations('txt_valor_modal_add_mod_tipo_vehiculo', ['notEmpty'], [
        {
            function: function (item) {
                return item.value == 0;
            },
            message: "El valor debe ser mayor a 0"
        }
    ]);
});

btnSaveTipoVehiculo.addEventListener('click', () => {
    let errores = '';

    errores += txtNombre.validateInput();
    errores += txtValor.validateInput();

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar el tipo de vehiculo, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $(`#${btnSaveTipoVehiculo.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando Tipo de Vehículo..</span>");
        const token = $("#csrf_token_modal_add_mod_tipo_vehiculo").val();
        const datos = new FormData($("#form_modal_add_mod_tipo_vehiculo")[0]);

        if (accionFormulario == "ADD") {
            $.ajax({
                url: '/garita/tipo_vehiculo/store',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveTipoVehiculo.id}`).html("<i class='fa fa-save'></i> <span id='text_save_tipo_vehiculo'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito el tipo de vehiculo",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarTipoVehiculos();
                        $("#modal_add_mod_tipo_vehiculo").modal("hide");
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
        }

        if (accionFormulario == "MOD") {
            $.ajax({
                url: '/garita/tipo_vehiculo/update',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnSaveTipoVehiculo.id}`).html("<i class='fa fa-save'></i> <span id='text_save_tipo_vehiculo'>Guardar</span>");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito el tipo de vehículo",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarTipoVehiculos();
                        $("#modal_add_mod_tipo_vehiculo").modal("hide");
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
        }
    }
});

btnAnadirRegistro.addEventListener('click', () => {
    $("#modal_add_mod_tipo_vehiculo").modal("show");

    accionFormulario = "ADD";
    txtNombre.value = "";
    txtValor.value = "";
    txtObservacion.value = "";
    estado_tipo_vehiculo.checked = true;
});

function getListarTipoVehiculos() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/garita/tipo_vehiculo/list',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml(id_table_tipo_vehiculo,
                ['#', 'NOMBRE', 'VALOR', 'OBSERVACIONES', 'ESTADO', 'OPCIONES'],
                ['tv_id', 'tv_nombre', 'tv_valor', 'tv_observacion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return item.tv_estado
                                ? '<span class="badge bg-success me-1">Activo</span>'
                                : '<span class="badge bg-danger me-1">Inactivo</span>';
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `<button type="button" class="btn btn-warning btn-modal-editar tooltip" Onclick ="show_mod_tipo_vehiculo(${item.tv_id}, '${item.tv_nombre}','${item.tv_valor}', '${item.tv_observacion}', ${item.tv_estado})"><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>
                                    <button type="button" class="btn btn-danger btn-modal-eliminar tooltip" Onclick ="show_delete_tipo_vehiculo(${item.tv_id})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>`;

                        }
                    },
                ], response
            );

            $("#div_table_tipo_vehiculos").html(html);

            $(`#${id_table_tipo_vehiculo}`).DataTable({
                "order": [[0, 'asc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

btnCancelBorrarRegistro.addEventListener('click', () => {
    idTipoVehiculoToDelete = 0;
    $(modalConfirmDeleteRegister).modal("hide");
});

function show_mod_tipo_vehiculo(id, nombre, valor, observacion, estado) {
    accionFormulario = "MOD";
    idInput.value = id;
    txtNombre.value = nombre;
    txtValor.value = valor;
    txtObservacion.value = observacion;
    estado_tipo_vehiculo.checked = estado;

    $("#modal_add_mod_tipo_vehiculo").modal("show");
}

function show_delete_tipo_vehiculo(id) {
    idTipoVehiculoToDelete = id;
    $("#modal_confirmacion_delete_tipo_vehiculo").modal("show");
}

btnBorrarRegistro.addEventListener('click', () => {
    let id = idTipoVehiculoToDelete;
    let token = $("#csrf-token").val();
    const datos = new FormData();
    $("#modal_confirmacion_delete_tipo_vehiculo").modal('hide');
    $.ajax({
        url: `/garita/tipo_vehiculo/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Tipo de Vehiculo Eliminado!",
                    type: "success",
                    zindex: 99999
                });
                idTipoVehiculoToDelete = 0;
                getListarTipoVehiculos();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar el tipo de vehiculo",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirmacion_delete_tipo_vehiculo").modal('hide');
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