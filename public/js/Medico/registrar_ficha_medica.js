let txtSearchEmpleado = document.getElementById('txt-search-emp');
let txtDiagnosticoEmpleado = document.getElementById('txt-search-diagnostico');
let txtFechaInicioCertificado = document.getElementById('txt-fecha-inicio-certificado');
let txtFechaFinCertificado = document.getElementById('txt-fecha-fin-certificado');
let iframe_view_document = document.getElementById('iframe_visor_certificado');
let selectCertificado = document.getElementById('select-certificado-ficha');
let cm_id_delete = 0;
let dm_id_delete = 0;
let me_id_delete = 0;

$(document).ready(function () {
    let estadoFotoEmpleado = document.getElementById('estado_foto_empleado');
    let urlFotoEmpleado = document.getElementById('url_foto_empleado');
    let urlTextFotoEmpleado = document.getElementById('apellidos_nombres_empleado');
    let divEmpleados = document.getElementById('div-datos-empleados');
    let fm_id = document.getElementById('fm_id');
    if (fm_id.value.trim() == "") {
        setFechasCertificadoMedico();
    }

    if (fm_id.value.trim() != "") {
        if (estadoFotoEmpleado.value) {
            $('#foto_empleado').attr("src", `/imagenes_empleados/${urlFotoEmpleado.value}`);
        } else {
            $('#foto_empleado').attr("src", `https://ui-avatars.com/api/?name=${urlTextFotoEmpleado.value}&background=0D8ABC&color=fff`);
        }
        $('#foto_empleado').css("max-height", `${divEmpleados.offsetHeight}px`);

        validateTipoCertificado(selectCertificado.value);
    }

    //txtFechaInicioCertificado.setAttribute('min', txtFechaInicioCertificado.value);
    DatesHorarioCertificado();
});

txtFechaInicioCertificado.addEventListener('change', (e) => {
    let dateParse = Date.parse(e.target.value);
    let dateParseFin = Date.parse(txtFechaFinCertificado.value);

    txtFechaFinCertificado.setAttribute('min', e.target.value);

    if (dateParseFin < dateParse) {
        txtFechaFinCertificado.value = e.target.value;
    }
});

txtFechaFinCertificado.addEventListener('change', (e) => {
    let dateParse = Date.parse(e.target.value);
    let dateParseInicio = Date.parse(txtFechaInicioCertificado.value);

    if (dateParse < dateParseInicio) {
        e.target.value = txtFechaInicioCertificado.value;
    }
});

selectCertificado.addEventListener('change', (e) => {
    validateTipoCertificado(e.target.value);
});

txtSearchEmpleado.addEventListener('changeAsing', (e) => {
    let divEmpleados = document.getElementById('div-datos-empleados');
    $('#txt-edad-empleado').val(e.target.dataset.edad);
    $('#txt-departamento-empleado').val(e.target.dataset.departamento);
    $('#txt-cargo-empleado').val(e.target.dataset.cargo);
    $('#txt-fecha-nacimiento-empleado').val(e.target.dataset.fecha_nacimiento);
    $('#txt-tipo-sangre-empleado').val(e.target.dataset.tipo_sangre);
    console.log(e.target.dataset.estado_ruta_foto);
    if (e.target.dataset.estado_ruta_foto == 'true') {
        $('#foto_empleado').attr("src", `/imagenes_empleados/${e.target.dataset.ruta_foto}`);
    } else {
        $('#foto_empleado').attr("src", `https://ui-avatars.com/api/?name=${e.target.dataset.nombre} ${e.target.dataset.apellido}&background=0D8ABC&color=fff`);
    }
    $('#foto_empleado').css("max-height", `${divEmpleados.offsetHeight}px`);
});


txtDiagnosticoEmpleado.addEventListener('changeAsing', (e) => {
    validateCIE10();
});

function DatesHorarioCertificado() {
    let txtDesde = document.getElementById('txt-hora-inicio-certificado');
    let txtHasta = document.getElementById('txt-hora-fin-certificado');
    txtDesde.addEventListener('change', (e) => {
        txtHasta.min = '00:00';
        txtHasta.disabled = false;
        if (txtFechaInicioCertificado.value == txtFechaFinCertificado.value) {
            txtHasta.min = e.target.value
        }
    });
    txtHasta.addEventListener('change', (e) => {
        if (txtFechaInicioCertificado.value == txtFechaFinCertificado.value) {
            if (txtFechaInicioCertificado.value == txtFechaFinCertificado.value) {
                txtHasta.min = txtDesde.value;
            }
            if (e.target.value < e.target.min) {
                e.target.value = '';
                notif({
                    type: "warning",
                    msg: `<b>Aviso: </b>Seleccione una fecha superior a ${e.target.min}`,
                    position: "right",
                    autohide: true,
                    zindex: 99999
                });
            }
        }
    });
}

function validateTipoCertificado(value) {
    txtFechaInicioCertificado.readOnly = false;
    txtFechaFinCertificado.readOnly = false;
    $('.controls_horas_certificado').fadeOut();
    if (value == 3) {
        txtFechaInicioCertificado.readOnly = true;
        txtFechaFinCertificado.readOnly = true;
    }
    if (value == 2)
        $('.controls_horas_certificado').fadeIn();
}

function validateCIE10() {
    let notifCie10 = document.getElementById('txt-search-diagnostico-warning');
    notifCie10.innerHTML = txtDiagnosticoEmpleado.validateWarnings();
}

function setFechasCertificadoMedico() {
    const fecha = new Date();
    let mes = fecha.getMonth() + 1; //obteniendo mes
    let dia = fecha.getDate(); //obteniendo dia
    const ano = fecha.getFullYear(); //obteniendo año
    if (dia < 10)
        dia = '0' + dia; //agrega cero si el menor de 10
    if (mes < 10)
        mes = '0' + mes //agrega cero si el menor de 10
    let fechaFicha = document.getElementById('txt-fecha-ficha');
    fechaFicha.value = ano + "-" + mes + "-" + dia;

    $("#txt-fecha-inicio-certificado").val(ano + "-" + mes + "-" + dia);
    $("#txt-fecha-fin-certificado").val(ano + "-" + mes + "-" + dia);
}

//Causas medicas
let btnAgregarModificarCausaMedica = document.getElementById('btn-guardar-causa-medica');

function add_causa_medica() {
    $('#causa-medica-hidden-id').val('');
    $(`#causa-medica-txt-descripcion`).val('');
    $('#causa-medica-txt-descripcion').focus();
    $('#text-save-causas-medicas').html('Guardar');
    $("#modal-causas-medicas").modal("show");
}

btnAgregarModificarCausaMedica.addEventListener('click', () => {
    if ($(`#causa-medica-txt-descripcion`).val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Descripción esta vació",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $('#text-save-causas-medicas').html('Guardando...');
        if ($('#causa-medica-hidden-id').val().trim() != "") {
            modificarCausaMedica();
        } else {
            agregarCausaMedica();
        }
    }
});

function selectTrCausa(tr) {
    $("#modal_administrar_causas").modal('hide');
    let txtCausa = document.getElementById('txt-search-causa');
    txtCausa.dataset.value = tr.dataset.cm_id;
    txtCausa.value = tr.dataset.cm_descripcion;
    txtCausa.dataset.text = tr.dataset.cm_descripcion;
    selectFirstTr_modal_administrar_causas();
}

function update_causa_medica(id, descripcion) {
    $('#causa-medica-hidden-id').val(id);
    $('#causa-medica-txt-descripcion').val(descripcion);
    $('#causa-medica-txt-descripcion').focus();
    $('#text-save-causas-medicas').html('Modificar');
    $("#modal-causas-medicas").modal("show");
}

function agregarCausaMedica() {
    let token = $("#csrf-token-modal-causas-medicas").val();
    let datos = new FormData($("#form-modal-causas-medicas")[0]);
    $.ajax({
        url: '/agregar_causa_medica',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Se agrego la causa medica",
                    type: "success",
                    zindex: 99999
                });
                $("#modal-causas-medicas").modal('hide');
                LoadDataModal_modal_administrar_causas();
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

function modificarCausaMedica() {
    let token = $("#csrf-token-modal-causas-medicas").val();
    let datos = new FormData($("#form-modal-causas-medicas")[0]);
    $.ajax({
        url: '/modify_causa_medica',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Se modifico la causa medica",
                    type: "success",
                    zindex: 99999
                });
                $("#modal-causas-medicas").modal('hide');
                LoadDataModal_modal_administrar_causas();
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

function delete_causa_medica(id) {
    cm_id_delete = id;
    $("#modal_confirmacion_deshabilitar_causa_medica").modal("show");
}

let btnDeshabilitarCausaMedica = document.getElementById('btn_confirm_deshabilitar_causa');

btnDeshabilitarCausaMedica.addEventListener('click', () => {
    var token = $("#csrf-token").val();
    var datos = new FormData();
    datos.append("id", cm_id_delete);
    $.ajax({
        url: '/deshabilitar_causa_medica',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                cm_id_delete = 0;
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>Se ha eliminado con éxisto la causa médica",
                    position: "right",
                    autohide: true,
                    zindex: 99999
                });
                $("#modal_confirmacion_deshabilitar_causa_medica").modal("hide");
                LoadDataModal_modal_administrar_causas();
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
//Fin Causas medicas

//Diagnosticos
let btnAgregarModificarDiagnosticoMedico = document.getElementById('btn-guardar-diagnostico-medico');

function add_diagnostico_medico() {
    $('#diagnostico-medico-hidden-id').val('');
    $(`#diagnostico-medico-txt-cie10`).val('');
    $(`#diagnostico-medico-txt-descripcion`).val('');
    $(`#diagnostico-medico-rb-requiere-cie10`).prop("checked", true);
    $('#diagnostico-medico-txt-cie10').focus();
    $('#text-save-diagnostico-medico').html('Guardar');
    $("#modal-diagnosticos-medicos").modal("show");
}

btnAgregarModificarDiagnosticoMedico.addEventListener('click', () => {
    if ($(`#diagnostico-medico-txt-descripcion`).val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Descripción esta vació",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $('#text-save-diagnostico-medico').html('Guardando...');
        if ($('#diagnostico-medico-hidden-id').val().trim() != "") {
            modificarDiagnosticoMedico();
        } else {
            agregarDiagnosticoMedico();
        }
    }
});

function selectTrDiagnostico(tr) {
    $("#modal_administrar_diagnosticos").modal('hide');
    let txtDiagnostico = document.getElementById('txt-search-diagnostico');
    txtDiagnostico.dataset.value = tr.dataset.dm_id;
    txtDiagnostico.dataset.cie10 = tr.dataset.dm_cie10;
    txtDiagnostico.dataset.requierecie10 = tr.dataset.dm_requiere_cie10
    txtDiagnostico.value = `${tr.dataset.dm_cie10 ? `[${tr.dataset.dm_cie10}]` : ''} ${tr.dataset.dm_descripcion}`;
    txtDiagnostico.dataset.text = `${tr.dataset.dm_cie10 ? `[${tr.dataset.dm_cie10}]` : ''} ${tr.dataset.dm_descripcion}`;
    selectFirstTr_modal_administrar_diagnosticos();
    validateCIE10();
}

function update_diagnostico_medico(id, cie10, descripcion, requierecie10) {
    $('#diagnostico-medico-hidden-id').val(id);
    $(`#diagnostico-medico-txt-cie10`).val(cie10);
    $(`#diagnostico-medico-txt-descripcion`).val(descripcion);
    $(`#diagnostico-medico-rb-requiere-cie10`).prop("checked", requierecie10);
    $('#diagnostico-medico-txt-cie10').focus();
    $('#text-save-diagnostico-medico').html('Modificar');
    $("#modal-diagnosticos-medicos").modal("show");
}

function agregarDiagnosticoMedico() {
    let token = $("#csrf-token-modal-diagnostico-medico").val();
    let datos = new FormData($("#form-modal-diagnostico-medico")[0]);
    $.ajax({
        url: '/agregar_diagnostico_medico',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Se agrego el diagnostico medico",
                    type: "success",
                    zindex: 99999
                });
                $("#modal-diagnosticos-medicos").modal('hide');
                LoadDataModal_modal_administrar_diagnosticos();
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

function modificarDiagnosticoMedico() {
    let token = $("#csrf-token-modal-diagnostico-medico").val();
    let datos = new FormData($("#form-modal-diagnostico-medico")[0]);
    $.ajax({
        url: '/modify_diagnostico_medico',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Se modifico el diagnostico medico",
                    type: "success",
                    zindex: 99999
                });
                $("#modal-diagnosticos-medicos").modal('hide');
                LoadDataModal_modal_administrar_diagnosticos();
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

function delete_diagnostico_medico(id) {
    dm_id_delete = id;
    $("#modal_confirmacion_deshabilitar_diagnostico").modal("show");
}

let btnDeshabilitarDiagnosticoMedico = document.getElementById('btn_confirm_deshabilitar_diagnostico');

btnDeshabilitarDiagnosticoMedico.addEventListener('click', () => {
    var token = $("#csrf-token").val();
    var datos = new FormData();
    datos.append("id", dm_id_delete);
    $.ajax({
        url: '/deshabilitar_diagnostico_medico',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                dm_id_delete = 0;
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>Se ha eliminado con éxito el diagnóstico médico",
                    position: "right",
                    autohide: true,
                    zindex: 99999
                });
                $("#modal_confirmacion_deshabilitar_diagnostico").modal("hide");
                LoadDataModal_modal_administrar_diagnosticos();
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
//Fin Diagnosticos

//Medicos 
let btnAgregarModificarMedicosConsulta = document.getElementById('btn-guardar-medico-consulta');

function add_medico_consulta() {
    $('#medico-consulta-hidden-id').val('');
    $(`#medico-consulta-txt-cedula`).val('');
    $(`#medico-consulta-txt-apellidos`).val('');
    $(`#medico-consulta-txt-nombres`).val('');
    $(`#medico-consulta-select-sexo`).val('I');
    $(`#medico-consulta-txt-centro_medico`).val('');
    $('#medico-consulta-txt-cedula').focus();
    $('#text-save-medico-consulta').html('Guardar');
    $("#modal-medicos-consulta").modal("show");
}

btnAgregarModificarMedicosConsulta.addEventListener('click', () => {
    if ($(`#medico-consulta-txt-apellidos`).val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Apellidos esta vació",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $('#text-save-medico-consulta').html('Guardando...');
        if ($('#medico-consulta-hidden-id').val().trim() != "") {
            modificarMedicoConsulta();
        } else {
            agregarMedicoConsulta();
        }
    }
});

function selectTrMedicoConsulta(tr) {
    $("#modal_administrar_medicos").modal('hide');
    let txtMedico = document.getElementById('txt-search-medico');
    txtMedico.dataset.value = tr.dataset.me_id;
    txtMedico.value = `${tr.dataset.me_cedula.trim() != '' ? `[${tr.dataset.me_cedula.trim()}]` : ''} ${tr.dataset.me_apellidos} ${tr.dataset.me_nombres}`;
    txtMedico.dataset.text = `${tr.dataset.me_cedula.trim() != '' ? `[${tr.dataset.me_cedula.trim()}]` : ''} ${tr.dataset.me_apellidos} ${tr.dataset.me_nombres}`;
    selectFirstTr_modal_administrar_medicos();
}

function update_medico_consulta(id, cedula, apellidos, nombres, sexo, centro_medico) {
    $('#medico-consulta-hidden-id').val(id);
    $(`#medico-consulta-txt-cedula`).val(cedula);
    $(`#medico-consulta-txt-apellidos`).val(apellidos);
    $(`#medico-consulta-txt-nombres`).val(nombres);
    $(`#medico-consulta-select-sexo`).val(sexo);
    $(`#medico-consulta-txt-centro_medico`).val(centro_medico);
    $('#medico-consulta-txt-cedula').focus();
    $('#text-save-medico-consulta').html('Modificar');
    $("#modal-medicos-consulta").modal("show");
}

function agregarMedicoConsulta() {
    let token = $("#csrf-token-modal-medicos-consulta").val();
    let datos = new FormData($("#form-modal-medicos-consulta")[0]);
    $.ajax({
        url: '/agregar_medico_consulta_ficha',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Se agrego el médico",
                    type: "success",
                    zindex: 99999
                });
                $("#modal-medicos-consulta").modal('hide');
                LoadDataModal_modal_administrar_medicos();
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

function modificarMedicoConsulta() {
    let token = $("#csrf-token-modal-medicos-consulta").val();
    let datos = new FormData($("#form-modal-medicos-consulta")[0]);
    $.ajax({
        url: '/modify_medico_consulta_ficha',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Se modifico el médico",
                    type: "success",
                    zindex: 99999
                });
                $("#modal-medicos-consulta").modal('hide');
                LoadDataModal_modal_administrar_medicos();
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

function delete_medico_consulta(id) {
    me_id_delete = id;
    $("#modal_confirmacion_deshabilitar_medico").modal("show");
}

let btnDeshabilitarMedico = document.getElementById('btn_confirm_deshabilitar_medico');

btnDeshabilitarMedico.addEventListener('click', () => {
    var token = $("#csrf-token").val();
    var datos = new FormData();
    datos.append("id", me_id_delete);
    $.ajax({
        url: '/deshabilitar_medico_consulta_ficha',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                me_id_delete = 0;
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>Se ha eliminado con éxito el médico",
                    position: "right",
                    autohide: true,
                    zindex: 99999
                });
                $("#modal_confirmacion_deshabilitar_medico").modal("hide");
                LoadDataModal_modal_administrar_medicos();
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
//Fin Medicos

let ajaxPrev = null;
custom_search_input('txt-search-emp', {
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

let ajaxPrevCausa = null;
custom_search_input('txt-search-causa', {
    formatResult: function (item) {
        return {
            value: item.cm_id,
            text: item.cm_descripcion,
            html: item.cm_descripcion
        }
    },
    search: function (text, callback) {
        if (ajaxPrevCausa != null)
            ajaxPrevCausa.abort();

        let ajax = $.ajax(
            `/get_search_causa_consulta_medica/0/10/${text}`
        ).done(function (res) {
            callback(res.respuesta ? res.data : []);
        });
        ajaxPrevCausa = ajax;
    },
    searchButton: {
        display: true,
        icon: 'fa fa-search',
        width: 32,
        eventClick: modal_administrar_causas
    }
});

function modal_administrar_causas() {
    $("#modal_administrar_causas").modal("show");
}



let ajaxPrevDiagnostico = null;
custom_search_input('txt-search-diagnostico', {
    formatResult: function (item) {
        return {
            value: item.dm_id,
            text: `${item.dm_cie10.trim() != "" ? `[${item.dm_cie10.trim()}]` : ''} ${item.dm_descripcion}`,
            html: `${item.dm_cie10.trim() != "" ? `[${item.dm_cie10.trim()}]` : ''} ${item.dm_descripcion}`
        }
    },
    datasets: function (item) {
        return {
            cie10: item.dm_cie10,
            requierecie10: item.dm_requiere_cie10
        }
    },
    search: function (text, callback) {
        if (ajaxPrevDiagnostico != null)
            ajaxPrevDiagnostico.abort();

        let ajax = $.ajax(
            `/get_search_diagnostico_consulta_medica/0/100/${text}`
        ).done(function (res) {
            callback(res.respuesta ? res.data : []);
        });

        ajaxPrevDiagnostico = ajax;
    },
    searchButton: {
        display: true,
        icon: 'fa fa-search',
        width: 32,
        eventClick: modal_administrar_diagnosticos
    }
});
function modal_administrar_diagnosticos() {
    $("#modal_administrar_diagnosticos").modal("show");
}

let ajaxPrevMedico = null;
custom_search_input('txt-search-medico', {
    formatResult: function (item) {
        return {
            value: item.me_id,
            text: `${item.me_cedula.trim() != "" ? `[${item.me_cedula.trim()}]` : ''} ${item.me_apellidos} ${item.me_nombres}`,
            html: `${item.me_cedula.trim() != "" ? `[${item.me_cedula.trim()}]` : ''} ${item.me_apellidos} ${item.me_nombres}`
        }
    },
    search: function (text, callback) {
        if (ajaxPrevDiagnostico != null)
            ajaxPrevDiagnostico.abort();

        let ajax = $.ajax(
            `/get_search_medico_consulta_ficha/0/10/${text}`
        ).done(function (res) {
            callback(res.respuesta ? res.data : []);
        });

        ajaxPrevDiagnostico = ajax;
    },
    searchButton: {
        display: true,
        icon: 'fa fa-search',
        width: 32,
        eventClick: modal_administrar_medicos
    }
});
function modal_administrar_medicos() {
    $("#modal_administrar_medicos").modal("show");
}

setInputValidations('txt-search-emp', ['notEmpty'], [
    {
        function: function (item) {
            return item.value.trim() != "" && (item.dataset.value == undefined || item.dataset.value.trim() == "");
        },
        message: "Debe buscar y seleccionar un empleado"
    }
]);

setInputValidations('select-certificado-ficha', [], [
    {
        function: function (item) {
            return item.value == 0;
        },
        message: "Debe seleccionar un Certificado"
    }
]);

setInputValidations('txt-search-causa', ['notEmpty'], [
    {
        function: function (item) {
            return item.value.trim() != "" && (item.dataset.value == undefined || item.dataset.value.trim() == "");
        },
        message: "Debe buscar y seleccionar una causa médica"
    }
]);

setInputValidations('txt-search-medico', [], []);

setInputValidations('txt-search-diagnostico', ['notEmpty'], [
    {
        function: function (item) {
            return item.value.trim() != "" && (item.dataset.value == undefined || item.dataset.value.trim() == "");
        },
        message: "Debe buscar y seleccionar un diagnóstico médico"
    }
], [
    {
        function: function (item) {
            return item.dataset.requierecie10 == "true" && item.dataset.cie10.trim() == "";
        },
        message: "Este diagnóstico no cuenta con un código CIE10"
    }
]);

setInputValidations('txt-observacion-ficha', [], []);

setInputValidations('txt-hora-inicio-certificado', ['notEmpty'], []);

setInputValidations('txt-hora-fin-certificado', ['notEmpty'], []);

$("#btn-guardar-ficha-medica").click(function () {
    let txtBuscarEmpleado = document.getElementById('txt-search-emp');
    let txtCertificado = document.getElementById('select-certificado-ficha');
    let txtCausa = document.getElementById('txt-search-causa');
    let txtMedico = document.getElementById('txt-search-medico');
    let txtDiagnostico = document.getElementById('txt-search-diagnostico');
    let txtObservacion = document.getElementById('txt-observacion-ficha');
    let txtHoraInicio = document.getElementById('txt-hora-inicio-certificado');
    let txtHoraFin = document.getElementById('txt-hora-fin-certificado');

    let errores = '';

    errores += txtBuscarEmpleado.validateInput();
    errores += txtCertificado.validateInput();
    errores += txtCausa.validateInput();
    errores += txtMedico.validateInput();
    errores += txtDiagnostico.validateInput();
    errores += txtObservacion.validateInput();
    if (txtCertificado.value == 2) {
        errores += txtHoraInicio.validateInput();
        errores += txtHoraFin.validateInput();
    }

    if (errores.trim() != "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>No se puede generar el certificado, favor verifique los datos ingresados",
            position: "right",
            autohide: true,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-ficha-medica").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Generando certificado..</span>");
        $("#modal_confirmacion_generacion_certificado").modal("show");
    }
})

$("#btn_confirm_generate_certificate").click(function () {
    let txtBuscarEmpleado = document.getElementById('txt-search-emp');
    let txtCausa = document.getElementById('txt-search-causa');
    let txtMedico = document.getElementById('txt-search-medico');
    let txtDiagnostico = document.getElementById('txt-search-diagnostico');
    let fm_id = document.getElementById('fm_id');
    $("#modal_confirmacion_generacion_certificado").modal("hide");
    if (fm_id.value.trim() == "") {
        save_certificado_medico(txtBuscarEmpleado.dataset.value, txtCausa.dataset.value, txtMedico.dataset.value, txtDiagnostico.dataset.value);
    } else {
        modificar_certificado_medico(txtBuscarEmpleado.dataset.value, txtCausa.dataset.value, txtMedico.dataset.value, txtDiagnostico.dataset.value);
    }
});

function save_certificado_medico(id_empleado, id_causa, id_medico, id_diagnostico) {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-registrar-ficha-medica")[0]);
    datos.append("emp_id", id_empleado);
    datos.append("cm_id", id_causa);
    if (id_medico != undefined && id_medico.trim() != "")
        datos.append("me_id", id_medico);
    datos.append("dm_id", id_diagnostico);
    $.ajax({
        url: '/registrar-certificado-medico',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == "true") {
                iframe_view_document.style.display = "none";
                iframe_view_document.src = `/show_certificado_medico/${response.data}`;
                $("#modal_view_pdf_certificado").modal("show");
                $("#btn-guardar-ficha-medica").html('<i class="fa fa-save"></i> MODIFICAR');
                let fm_id = document.getElementById('fm_id');
                fm_id.value = response.data;
                notif({
                    type: "success",
                    msg: "<b>Aviso: </b>Se ha guardado con éxito el certificado",
                    position: "right",
                    autohide: true,
                    zindex: 99999
                });
                location.href = "/ficha_medica";
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

function modificar_certificado_medico(id_empleado, id_causa, id_medico, id_diagnostico) {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-registrar-ficha-medica")[0]);
    datos.append("emp_id", id_empleado);
    datos.append("cm_id", id_causa);
    if (id_medico != undefined && id_medico.trim() != "")
        datos.append("me_id", id_medico);
    datos.append("dm_id", id_diagnostico);
    $.ajax({
        url: '/modificar-certificado-medico',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == "true") {
                iframe_view_document.style.display = "none";
                iframe_view_document.src = `/show_certificado_medico/${response.data}`;
                $("#modal_view_pdf_certificado").modal("show");
                $("#btn-guardar-ficha-medica").html('<i class="fa fa-save"></i> MODIFICAR FICHA MÉDICA');
                let fm_id = document.getElementById('fm_id');
                fm_id.value = response.data;
                notif({
                    type: "success",
                    msg: "<b>Aviso: </b>Se ha guardado con éxito el certificado",
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


$("#btn-volver-listado-fichas").click(function () {
    location.href = "/ficha_medica";
});

$("#btn_cancelar_generate_certificate").click(function () {
    let fm_id = document.getElementById('fm_id');
    let texto = "GUARDAR";
    if (fm_id.value.trim() != "")
        texto = "MODIFICAR";
    $("#btn-guardar-ficha-medica").html(`<i class="fa fa-save"></i> ${texto}`);
});

iframe_view_document.addEventListener('load', () => {
    iframe_view_document.style.display = "block";
});