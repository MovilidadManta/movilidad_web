const name_modal_agregar_modificar_empleado_remoto = "modal_agregar_modificar_empleado_remoto";
const btnNuevoEmpleadoRemoto = document.getElementById("btn_add_empleado_remoto");
const nameTextSearchEmpleado = `txt_search_emp_${name_modal_agregar_modificar_empleado_remoto}`;
const nameFotoEmpleado = `foto_empleado_${name_modal_agregar_modificar_empleado_remoto}`;
const namefechaInicioEmpleado = `cer_fecha_inicio_${name_modal_agregar_modificar_empleado_remoto}`;
const nameFechaFinEmpleado = `cer_fecha_fin_${name_modal_agregar_modificar_empleado_remoto}`;
const ConfEmpleadoRemotoId = document.getElementById(`cer_id_${name_modal_agregar_modificar_empleado_remoto}`);
const txtSearchEmpleado = document.getElementById(nameTextSearchEmpleado);
const txtFechaNacimientoEmpleado = document.getElementById(`txt_fecha_nacimiento_empleado_${name_modal_agregar_modificar_empleado_remoto}`);
const txtDepartamentoEmpleado = document.getElementById(`txt_departamento_empleado_${name_modal_agregar_modificar_empleado_remoto}`);
const txtPuestoTrabajoEmpleado = document.getElementById(`txt_cargo_empleado_${name_modal_agregar_modificar_empleado_remoto}`);
const fecha_inicio_empleado = document.getElementById(namefechaInicioEmpleado);
const fecha_fin_empleado = document.getElementById(nameFechaFinEmpleado);
const elementFotoEmpleado = document.getElementById(nameFotoEmpleado);
const checkHabilitarFechaFin = document.getElementById(`check_habilitar_fecha_fin_${name_modal_agregar_modificar_empleado_remoto}`);
const btnGuardarEmpleadoRemoto = document.getElementById("btn_guardar_empleado_remoto");
const idDeleteEmpleadoRemoto = document.getElementById("cer_id_delete");
const btnDeleteEmpleadoRemoto = document.getElementById("btn_delete_empleado_remoto");
const id_table_empleados_remotos = "table_empleados_remoto";
let bool_cargo_empleado = false;
let accionFormulario = "ADD";

$(document).ready(function () {
    configure_select_two_dates(namefechaInicioEmpleado, nameFechaFinEmpleado);
    const minimoFechaInicial = fecha_inicio_empleado.value;
    fecha_inicio_empleado.setAttribute('min', minimoFechaInicial);
    setInputValidations(namefechaInicioEmpleado, ['notEmpty'], []);
    setInputValidations(nameFechaFinEmpleado, ['notEmpty'], []);
    ConfEmpleadoRemotoId.value = 0;
    getListarEmpleadosRemoto();
});

function clearModalEmpleadoRemoto() {
    ConfEmpleadoRemotoId.value = 0;
    txtSearchEmpleado.value = "";
    txtSearchEmpleado.dataset.value = "";
    txtSearchEmpleado.dataset.text = "";
    txtFechaNacimientoEmpleado.value = "";
    txtDepartamentoEmpleado.value = "";
    txtPuestoTrabajoEmpleado.value = "";
    fecha_inicio_empleado.value = `${new Date().getFullYear()}-${(new Date().getMonth() + 1).toString().padStart(2, '0')}-${new Date().getDate().toString().padStart(2, '0')}`;
    fecha_fin_empleado.value = fecha_inicio_empleado.value;
    if (checkHabilitarFechaFin.classList.contains("on")) {
        checkHabilitarFechaFin.dispatchEvent(new Event('click'));
    };
    $(`#${nameFotoEmpleado}`).attr("src", elementFotoEmpleado.dataset.src);
}

checkHabilitarFechaFin.addEventListener("click", () => {
    $(`#${checkHabilitarFechaFin.id}`).toggleClass('on');

    fecha_fin_empleado.disabled = true;
    if (checkHabilitarFechaFin.classList.contains("on")) {
        fecha_fin_empleado.disabled = false;
    }
});

btnNuevoEmpleadoRemoto.addEventListener("click", () => {
    accionFormulario = "ADD";
    $(`#${name_modal_agregar_modificar_empleado_remoto}`).modal("show");
    $(`#${btnGuardarEmpleadoRemoto.id}`).html("<i class='fa fa-save'></i> Guardar");
    txtSearchEmpleado.readOnly = false;
    cargarBusquedaEmpleado();
    clearModalEmpleadoRemoto()
});

function cargarBusquedaEmpleado() {
    if (!bool_cargo_empleado) {
        let ajaxPrev = null;
        custom_search_input(nameTextSearchEmpleado, {
            formatResult: function (item) {
                return {
                    value: item.emp_id,
                    text: `[${item.emp_cedula}] ${item.emp_apellido} ${item.emp_nombre}`,
                    html: `[${item.emp_cedula}] ${item.emp_apellido} ${item.emp_nombre}`
                }
            },
            datasets: function (item) {
                return {
                    cedula: item.emp_cedula,
                    nombre: item.emp_nombre,
                    apellido: item.emp_apellido,
                    telefono: item.emp_telefono,
                    direccion: item.emp_direccion,
                    ruta_foto: item.emp_ruta_foto,
                    sexo: item.emp_sexo,
                    cargo: item.emp_cargo,
                    fecha_nacimiento: item.emp_fecha_nacimiento,
                    tipo_sangre: item.emp_tipo_sangre,
                    departamento: item.dep_departamento,
                    cargo: item.ca_cargo,
                    edad: item.emp_edad,
                    estado_ruta_foto: item.emp_estado_ruta_foto
                }
            },
            search: function (text, callback) {
                if (ajaxPrev != null)
                    ajaxPrev.abort();

                let ajax = $.ajax(
                    `/get_search_empleado_busq/10/${text}`
                ).done(function (res) {
                    callback(res.respuesta ? res.data : []);
                });

                ajaxPrev = ajax;
            }
        });
        bool_cargo_empleado = true;
    }
}

txtSearchEmpleado.addEventListener('changeAsing', (e) => {
    $(`#txt_fecha_nacimiento_empleado_${name_modal_agregar_modificar_empleado_remoto}`).val(e.target.dataset.fecha_nacimiento);
    $(`#txt_departamento_empleado_${name_modal_agregar_modificar_empleado_remoto}`).val(e.target.dataset.departamento);
    $(`#txt_cargo_empleado_${name_modal_agregar_modificar_empleado_remoto}`).val(e.target.dataset.cargo);
    if (e.target.dataset.estado_ruta_foto == 'true') {
        $(`#${nameFotoEmpleado}`).attr("src", `/imagenes_empleados/${e.target.dataset.ruta_foto}`);
    } else {
        $(`#${nameFotoEmpleado}`).attr("src", `https://ui-avatars.com/api/?name=${e.target.dataset.nombre} ${e.target.dataset.apellido}&background=0D8ABC&color=fff`);
    }
    $(`#${nameFotoEmpleado}`).css("max-height", `325px`);
});

setInputValidations(nameTextSearchEmpleado, ['notEmpty'], [
    {
        function: function (item) {
            return item.value.trim() != "" && (item.dataset.value == undefined || item.dataset.value.trim() == "");
        },
        message: "Debe buscar y seleccionar un empleado"
    }
]);

function getListarEmpleadosRemoto() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/conf_empleados_remoto/list',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml(id_table_empleados_remotos,
                ['#', 'CÉDULA', 'EMPLEADO', 'F. DE NACIMIENTO', 'DEPARTAMENTO', 'PUESTO DE TRABAJO', 'FECHA DE INICIO', 'FECHA DE FIN', 'ESTADO', 'OPCIONES'],
                ['cer_id', 'emp_cedula',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `${item.emp_apellido} ${item.emp_nombre}`;
                        }
                    }, 'emp_fecha_nacimiento', 'dep_departamento', 'ca_cargo', 'cer_fecha_inicio',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return item.cer_tiene_fecha_fin
                                ? item.cer_fecha_fin
                                : 'INDEFINIDO';
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return item.cer_estado
                                ? '<span class="badge bg-success me-1">Activo</span>'
                                : '<span class="badge bg-danger me-1">Inactivo</span>';
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let render = "";
                            if (item.cer_estado) {
                                render += `<button type="button" class="btn btn-warning btn-modal-editar tooltip" Onclick="show_mod_empleado_remoto(${item.cer_id}, ${item.emp_id}, '${item.emp_cedula}','${item.emp_apellido}', '${item.emp_nombre}', '${item.emp_fecha_nacimiento}', '${item.emp_ruta_foto}','${item.dep_departamento}','${item.ca_cargo}', '${item.cer_fecha_inicio}', '${item.cer_fecha_fin}', ${item.cer_tiene_fecha_fin})" ><span class="tooltiptext">Editar</span><i class="fa fa-edit tam-icono icon_elevated"></i></button>`;
                                render += `<button type="button" class="btn btn-danger btn-modal-eliminar tooltip" Onclick="show_delete_empleado_remoto(${item.cer_id})"><span class="tooltiptext">Eliminar</span><i class="fa fa-trash tam-icono icon_elevated"></i></button>`;
                            }
                            return render;

                        }
                    },
                ], response
            );

            $("#div_table_empleados_remotos").html(html);

            $(`#${id_table_empleados_remotos}`).DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function show_mod_empleado_remoto(cer_id, emp_id, emp_cedula, emp_apellido, emp_nombre, emp_fecha_nacimiento,
    emp_ruta_foto, dep_departamento, ca_cargo,
    cer_fecha_inicio, cer_fecha_fin, cer_tiene_fecha_fin) {
    accionFormulario = "MOD";
    ConfEmpleadoRemotoId.value = cer_id;
    txtSearchEmpleado.dataset.value = emp_id;
    txtSearchEmpleado.dataset.text = `[${emp_cedula}] ${emp_apellido} ${emp_nombre}`;
    txtSearchEmpleado.value = `[${emp_cedula}] ${emp_apellido} ${emp_nombre}`;
    txtSearchEmpleado.dataset.cedula = emp_cedula;

    txtSearchEmpleado.dataset.nombre = emp_nombre;
    txtSearchEmpleado.dataset.apellido = emp_apellido;
    txtSearchEmpleado.dataset.cedula = emp_cedula;
    txtSearchEmpleado.dataset.ruta_foto = emp_ruta_foto;
    txtSearchEmpleado.dataset.fecha_nacimiento = emp_fecha_nacimiento;
    txtSearchEmpleado.dataset.cargo = ca_cargo;
    txtSearchEmpleado.dataset.departamento = dep_departamento;
    txtSearchEmpleado.readOnly = true;
    $(`#${nameFotoEmpleado}`).attr("src", elementFotoEmpleado.dataset.src);

    verificarImagen(emp_ruta_foto).then(existe => {
        txtSearchEmpleado.dataset.estado_ruta_foto = existe;
        txtSearchEmpleado.dispatchEvent(new Event("changeAsing"));
    });

    fecha_inicio_empleado.value = cer_fecha_inicio;
    fecha_fin_empleado.value = cer_fecha_fin == 'null' ? cer_fecha_inicio : cer_fecha_fin;
    checkHabilitarFechaFin.classList.remove("on");

    if (cer_tiene_fecha_fin) {
        checkHabilitarFechaFin.dispatchEvent(new Event("click"));
    }

    $(`#${name_modal_agregar_modificar_empleado_remoto}`).modal("show");
    $(`#${btnGuardarEmpleadoRemoto.id}`).html("<i class='fa fa-save'></i> Modificar");
}

async function verificarImagen(emp_ruta_foto) {
    const url = `/imagenes_empleados/${emp_ruta_foto}`;

    try {
        const response = await fetch(url, { method: "HEAD" });
        // Si el servidor responde 200–299, existe
        return response.ok;
    } catch (e) {
        return false;
    }
}

btnGuardarEmpleadoRemoto.addEventListener("click", () => {
    let errores = '';

    errores += txtSearchEmpleado.validateInput();
    errores += fecha_inicio_empleado.validateInput();
    if (checkHabilitarFechaFin.classList.contains("on")) {
        errores += fecha_fin_empleado.validateInput();
    }

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede agregar el empleado remoto, favor verifique la información",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $(`#${btnGuardarEmpleadoRemoto.id}`).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'>Guardando Empleado remoto...</span>");
        const token = $(`#csrf_token_${name_modal_agregar_modificar_empleado_remoto}`).val();
        const datos = new FormData($(`#form_${name_modal_agregar_modificar_empleado_remoto}`)[0]);
        datos.append("emp_id", txtSearchEmpleado.dataset.value);
        datos.append("cer_tiene_fecha_fin", checkHabilitarFechaFin.classList.contains("on"));

        if (accionFormulario == "ADD") {
            $.ajax({
                url: '/conf_empleados_remoto/store',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnGuardarEmpleadoRemoto.id}`).html("<i class='fa fa-save'></i> Guardar");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha guardado con éxito el empleado remoto",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarEmpleadosRemoto();
                        $(`#${name_modal_agregar_modificar_empleado_remoto}`).modal("hide");
                    } else if (response.respuesta == "false" && response.cod && response.cod == "HAVE_ACTIVE") {
                        $(`#${btnGuardarEmpleadoRemoto.id}`).html("<i class='fa fa-save'></i> Guardar");
                        notif({
                            type: "error",
                            msg: "<b>Aviso: </b>El empleado tiene una configuración activa no se pudo guardar",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
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
                url: '/conf_empleados_remoto/update',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': token },
                contentType: false,
                processData: false,
                data: datos,
                success: function (response) {
                    if (response.respuesta == "true") {
                        $(`#${btnGuardarEmpleadoRemoto.id}`).html("<i class='fa fa-save'></i> Guardar");
                        notif({
                            type: "success",
                            msg: "<b>Aviso: </b>Se ha modificado con éxito el empleado remoto",
                            position: "right",
                            autohide: true,
                            zindex: 99999
                        });
                        getListarEmpleadosRemoto();
                        $(`#${name_modal_agregar_modificar_empleado_remoto}`).modal("hide");
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

function show_delete_empleado_remoto(cer_id) {
    idDeleteEmpleadoRemoto.value = cer_id;
    $('#modal_confirm_delete_empleado_remoto').modal("show");
}

btnDeleteEmpleadoRemoto.addEventListener("click", () => {
    const token = $(`#csrf_token_${name_modal_agregar_modificar_empleado_remoto}`).val();
    const datos = new FormData();
    $("#modal_confirm_delete_empleado_remoto").modal('hide');
    datos.append("cer_id", idDeleteEmpleadoRemoto.value);
    datos.append("cer_estado", false);
    $.ajax({
        url: `/conf_empleados_remoto/change_state`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Configuración de empleado remoto eliminada!",
                    type: "success",
                    zindex: 99999
                });
                idDeleteEmpleadoRemoto.value = 0;
                getListarEmpleadosRemoto();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la configuración de empleado remoto",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
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