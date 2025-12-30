let btnAgregarDireccion = document.getElementById('btn-añadir-direccion');
let btnGuardarDireccion = document.getElementById('btn-guardar-departamento-modal_agregar_direccion');
let btnModificarDireccion = document.getElementById('btn-guardar-departamento-modal_modificar_direccion');
let btnDeleteDireccion = document.getElementById('btn-delete-direccion');
$(document).ready(function () {
    getDireccionOrganigrama();

    btnAgregarDireccion.addEventListener('click', () => {
        $("#modal_agregar_direccion").modal("show");
    });

    btnGuardarDireccion.addEventListener('click', agregarDireccionModal);
    btnModificarDireccion.addEventListener('click', modificarDireccionModal);
});

function getDireccionOrganigrama() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/direccion-organizacional/getAll',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table-direccion-organizacional",
                ['ID', 'DEPARTAMENTO', 'ESTADO', 'OPCIONES'
                ],
                ['dep_id', 'dep_departamento',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.dep_estado) {
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
                            <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ="show_mod_departamento(${item.dep_id},'${item.dep_departamento}',${item.dep_estado})"><i class="fa fa-edit tam-icono"></i></button>
                            <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_direccion(${item.dep_id})"><i class="fa fa-trash tam-icono"></i></button>
                            `;
                        }
                    },
                ], response
            );

            $("#div-table-direccion").html(html);

            $("#table-direccion-organizacional").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function agregarDireccionModal() {
    if (
        $('#txt-departamento-modal_agregar_direccion').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un departamento",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-departamento-modal_agregar_direccion").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");
        let departamento = document.getElementById('txt-departamento-modal_agregar_direccion');
        let checkdepartamento = document.getElementById('chk_departamento-modal_agregar_direccion');
        let token = $("#csrf-token-modal_agregar_direccion").val();
        let datos = new FormData();
        datos.append('departamento', departamento.value);
        datos.append('estado', checkdepartamento.checked);
        $.ajax({
            url: '/direccion-organizacional/store',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Dirección Organizacional Registrada",
                        type: "success",
                        zindex: 99999
                    });
                    departamento.value = "";
                    checkdepartamento.checked = true;
                    $("#modal_agregar_direccion").modal('hide');
                    $("#btn-guardar-departamento-modal_agregar_direccion").html("<i class='fa fa-save'></i> Guardar");
                    getDireccionOrganigrama();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido registrar la Dirección Organizacional",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-departamento-modal_agregar_direccion").html("<i class='fa fa-save'></i> Guardar");
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

function show_mod_departamento(id, departamento, estado) {
    let idE = document.getElementById('id-departamento-modal_modificar_direccion');
    let departamentoE = document.getElementById('txt-departamento-modal_modificar_direccion');
    let checkdepartamento = document.getElementById('chk_departamento-modal_modificar_direccion');

    idE.value = id;
    departamentoE.value = departamento;
    checkdepartamento.checked = estado;

    checkdepartamento.dispatchEvent(new Event('change'));

    $("#modal_modificar_direccion").modal("show");

}

function modificarDireccionModal() {
    if (
        $('#txt-departamento-modal_modificar_direccion').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un departamento",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-departamento-modal_modificar_direccion").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");
        let id = document.getElementById('id-departamento-modal_modificar_direccion');
        let departamento = document.getElementById('txt-departamento-modal_modificar_direccion');
        let checkdepartamento = document.getElementById('chk_departamento-modal_modificar_direccion');
        let token = $("#csrf-token-modal_modificar_direccion").val();
        let datos = new FormData();
        datos.append('id', id.value);
        datos.append('departamento', departamento.value);
        datos.append('estado', checkdepartamento.checked);
        $.ajax({
            url: '/direccion-organizacional/update',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Dirección Organizacional Modificada",
                        type: "success",
                        zindex: 99999
                    });
                    departamento.value = "";
                    checkdepartamento.checked = true;
                    $("#modal_modificar_direccion").modal('hide');
                    $("#btn-guardar-departamento-modal_modificar_direccion").html("<i class='fa fa-save'></i> Guardar");
                    getDireccionOrganigrama();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido modificar la Dirección Organizacional",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-departamento-modal_modificar_direccion").html("<i class='fa fa-save'></i> Guardar");
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

function show_delete_direccion(id) {
    $('#txt-id-delete-direccion').val(id);
    $("#modal_confirm_delete_direccion").modal("show");
}

btnDeleteDireccion.addEventListener('click', function () {
    let id = $('#txt-id-delete-direccion').val();
    let token = $("#csrf-token-modal_confirm_delete_direccion").val();
    $.ajax({
        url: `/direccion-organizacional/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Dirección Eliminada",
                    type: "success",
                    zindex: 99999
                });
                $('#txt-id-delete-direccion').val('');
                $("#modal_confirm_delete_direccion").modal('hide');
                getDireccionOrganigrama();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la Direccion",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_direccion").modal('hide');
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
