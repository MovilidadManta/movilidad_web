let btnAgregarJefatura = document.getElementById('btn-añadir-jefatura');
let btnGuardarJefatura = document.getElementById('btn-guardar-jefatura-modal_agregar_jefatura');
let btnModificarJefatura = document.getElementById('btn-guardar-jefatura-modal_modificar_jefatura');
let selectDireccionAgregar = document.getElementById('select-direccion-modal_agregar_jefatura');
let selectDireccionModificar = document.getElementById('select-direccion-modal_modificar_jefatura');
let btnDeleteJefatura = document.getElementById('btn-delete-jefatura');
$(document).ready(function () {
    getJefaturaOrganigrama();

    btnAgregarJefatura.addEventListener('click', () => {
        $("#modal_agregar_jefatura").modal("show");
    });

    btnGuardarJefatura.addEventListener('click', agregarJefaturaModal);
    btnModificarJefatura.addEventListener('click', modificarJefaturaModal);

    $.ajax({
        url: '/direccion-organizacional/getActiveAll',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = '';
            $(response).each(function (i, dat) {
                html +=
                    '<option value="' +
                    dat.dep_id +
                    '">' +
                    dat.dep_departamento +
                    "</option>";
            });
            selectDireccionAgregar.innerHTML += html;
            selectDireccionModificar.innerHTML += html;
        }
    });
});

function getJefaturaOrganigrama() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/jefatura-organizacional/getAll',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table-jefatura-organizacional",
                ['ID', 'DEPARTAMENTO', 'PERFIL', 'ESTADO DIRECCIÓN', 'ESTADO', 'OPCIONES'
                ],
                ['per_id', 'dep_departamento', 'per_perfil',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.per_estado_direccion == 1) {
                                value = 'Con Dirección';
                            } else {
                                value = 'Sin Dirección';
                            }
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.per_estado) {
                                value = '<span class="badge bg-success me-1">Activo</span>';
                            } else {
                                value = '<span class="badge bg-warning me-1">Inactivo</span>';
                            }
                            return value;
                        }
                    },
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `
                            <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ="show_mod_jefatura(${item.per_id},'${item.per_perfil}',${item.per_id_direccion},${item.per_estado_direccion},${item.per_estado})"><i class="fa fa-edit tam-icono"></i></button>
                            <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_jefatura(${item.per_id})"><i class="fa fa-trash tam-icono"></i></button>
                            `;
                        }
                    },
                ], response
            );

            $("#div-table-jefaturas").html(html);

            $("#table-jefatura-organizacional").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function agregarJefaturaModal() {
    if ($('#select-direccion-modal_agregar_jefatura').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese una Dirección",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#txt-perfil-modal_agregar_jefatura').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un Perfil",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#select-estado-direccion-modal_agregar_jefatura').val().trim() == '-1'
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor seleccione un Estado",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-jefatura-modal_agregar_jefatura").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");
        let direccion = document.getElementById('select-direccion-modal_agregar_jefatura');
        let perfil = document.getElementById('txt-perfil-modal_agregar_jefatura');
        let estado_direccion = document.getElementById('select-estado-direccion-modal_agregar_jefatura');
        let checkJefatura = document.getElementById('chk_jefatura-modal_agregar_jefatura');
        let token = $("#csrf-token-modal_agregar_jefatura").val();
        let datos = new FormData();
        datos.append('perfil', perfil.value);
        datos.append('id_direccion', direccion.value);
        datos.append('estado_direccion', estado_direccion.value);
        datos.append('estado', checkJefatura.checked ? 1 : 0);
        $.ajax({
            url: '/jefatura-organizacional/store',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Jefatura Organizacional Registrada",
                        type: "success",
                        zindex: 99999
                    });
                    direccion.value = 0;
                    perfil.value = "";
                    estado_direccion.value = -1;
                    checkJefatura.checked = true;
                    checkJefatura.dispatchEvent(new Event('change'));
                    $("#modal_agregar_jefatura").modal('hide');
                    $("#btn-guardar-jefatura-modal_agregar_jefatura").html("<i class='fa fa-save'></i> Guardar");
                    getJefaturaOrganigrama();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido registrar la Jefatura Organizacional",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-jefatura-modal_agregar_jefatura").html("<i class='fa fa-save'></i> Guardar");
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

function show_mod_jefatura(id, perfil, id_direccion, estado_direccion, estado) {
    let idE = document.getElementById('id-jefatura-modal_modificar_jefatura');
    let perfilE = document.getElementById('txt-perfil-modal_modificar_jefatura');
    let direccionE = document.getElementById('select-direccion-modal_modificar_jefatura');
    let estado_direccionE = document.getElementById('select-estado-direccion-modal_modificar_jefatura');
    let checkJefatura = document.getElementById('chk_jefatura-modal_modificar_jefatura');

    idE.value = id;
    perfilE.value = perfil;
    direccionE.value = id_direccion;
    estado_direccionE.value = estado_direccion;
    checkJefatura.checked = estado;

    checkJefatura.dispatchEvent(new Event('change'));

    $("#modal_modificar_jefatura").modal("show");

}

function modificarJefaturaModal() {
    if ($('#select-direccion-modal_modificar_jefatura').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor seleccione una Dirección",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#txt-perfil-modal_modificar_jefatura').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un Perfil",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#select-estado-direccion-modal_modificar_jefatura').val().trim() == '-1'
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor seleccione un Estado",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-jefatura-modal_modificar_jefatura").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");
        let idJefatura = document.getElementById('id-jefatura-modal_modificar_jefatura');
        let direccion = document.getElementById('select-direccion-modal_modificar_jefatura');
        let perfil = document.getElementById('txt-perfil-modal_modificar_jefatura');
        let estado_direccion = document.getElementById('select-estado-direccion-modal_modificar_jefatura');
        let checkJefatura = document.getElementById('chk_jefatura-modal_modificar_jefatura');
        let token = $("#csrf-token-modal_modificar_jefatura").val();
        let datos = new FormData();
        datos.append('id', idJefatura.value);
        datos.append('perfil', perfil.value);
        datos.append('id_direccion', direccion.value);
        datos.append('estado_direccion', estado_direccion.value);
        datos.append('estado', checkJefatura.checked ? 1 : 0);
        $.ajax({
            url: '/jefatura-organizacional/update',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Jefatura Organizacional Modificada",
                        type: "success",
                        zindex: 99999
                    });
                    direccion.value = 0;
                    perfil.value = "";
                    estado_direccion.value = 0;
                    checkJefatura.checked = true;
                    checkJefatura.dispatchEvent(new Event('change'));
                    $("#modal_modificar_jefatura").modal('hide');
                    $("#btn-guardar-jefatura-modal_modificar_jefatura").html("<i class='fa fa-save'></i> Guardar");
                    getJefaturaOrganigrama();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido modificar la Jefatura Organizacional",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-jefatura-modal_modificar_jefatura").html("<i class='fa fa-save'></i> Guardar");
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

function show_delete_jefatura(id) {
    $('#txt-id-delete-jefatura').val(id);
    $("#modal_confirm_delete_jefatura").modal("show");
}

btnDeleteJefatura.addEventListener('click', function () {
    let id = $('#txt-id-delete-jefatura').val();
    let token = $("#csrf-token-modal_confirm_delete_jefatura").val();
    $.ajax({
        url: `/jefatura-organizacional/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Jefatura Eliminada",
                    type: "success",
                    zindex: 99999
                });
                $('#txt-id-delete-jefatura').val('');
                $("#modal_confirm_delete_jefatura").modal('hide');
                getJefaturaOrganigrama();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la Jefatura",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_jefatura").modal('hide');
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

