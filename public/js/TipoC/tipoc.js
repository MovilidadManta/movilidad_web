let btnAgregarContenedor = document.getElementById('btn-añadir-contenedor');
let btnGuardarContenedor = document.getElementById('btn-guardar-contenedor-modal_agregar_contenedor');
let btnModificarContenedor = document.getElementById('btn-guardar-contenedor-modal_modificar_contenedor');
let btnDeleteContenedor = document.getElementById('btn-delete-contenedor');

$(document).ready(function () {
    getContenedores();

    btnAgregarContenedor.addEventListener('click', () => {
        $.ajax({
            url: '/tipos-contenedores/getNumeracion',
            type: "GET",
            dataType: "json",
            success: function (response) {
                $('#txt-numeracion-modal_agregar_contenedor').val(response.numeracion);
                $("#modal_agregar_contenedor").modal("show");
            }
        });
    });

    btnGuardarContenedor.addEventListener('click', agregarContenedorModal);
    btnModificarContenedor.addEventListener('click', modificarContenedorModal);

    set_type_input('txt-numeracion-modal_agregar_contenedor', 'number');
    set_type_input('txt-numeracion-modal_modificar_contenedor', 'number');
});

function getContenedores() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/tipos-contenedores/getAll',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table-contenedores",
                ['ID', 'TIPO', 'LETRA', 'NUMERACIÓN', 'FECHA CREACIÓN', 'ESTADO', 'OPCIONES'
                ],
                ['id', 'tipo', 'letra', , 'numeracion', 'created_at',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let value = '';
                            if (item.estado) {
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
                            <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ="show_mod_contenedor(${item.id},'${item.tipo}','${item.letra}',${item.numeracion},${item.estado})"><i class="fa fa-edit tam-icono"></i></button>
                            <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_contenedor(${item.id})"><i class="fa fa-trash tam-icono"></i></button>
                            `;
                        }
                    },
                ], response
            );

            $("#div-table-contenedor").html(html);

            $("#table-contenedores").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function agregarContenedorModal() {
    if (
        $('#txt-tipo-modal_agregar_contenedor').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un Tipo de Contenedor",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#txt-letra-modal_agregar_contenedor').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un Alias de Contenedor",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#txt-numeracion-modal_agregar_contenedor').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese una Numeración de Contenedor",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-contenedor-modal_agregar_contenedor").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");
        let tipo = document.getElementById('txt-tipo-modal_agregar_contenedor');
        let letra = document.getElementById('txt-letra-modal_agregar_contenedor');
        let numeracion = document.getElementById('txt-numeracion-modal_agregar_contenedor');
        let estado = document.getElementById('chk_estado-modal_agregar_contenedor');
        let token = $("#csrf-token-modal_agregar_contenedor").val();
        let datos = new FormData();
        datos.append('tipo', tipo.value);
        datos.append('letra', letra.value);
        datos.append('numeracion', numeracion.value);
        datos.append('estado', estado.checked);
        $.ajax({
            url: '/tipos-contenedores/store',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Tipo de Contenedor Registrado",
                        type: "success",
                        zindex: 99999
                    });
                    tipo.value = "";
                    letra.value = "";
                    numeracion.value = "";
                    estado.checked = true;
                    estado.dispatchEvent(new Event('change'));
                    $("#modal_agregar_contenedor").modal('hide');
                    $("#btn-guardar-contenedor-modal_agregar_contenedor").html("<i class='fa fa-save'></i> Guardar");
                    getContenedores();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido registrar el Tipo de Contenedor",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-contenedor-modal_agregar_contenedor").html("<i class='fa fa-save'></i> Guardar");
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

//show_mod_contenedor(${item.id},'${item.tipo}','${item.letra}',${item.numeracion},${item.estado})
function show_mod_contenedor(id, tipo, letra, numeracion, estado) {
    let idE = document.getElementById('id-contenedor-modal_modificar_contenedor');
    let tipoE = document.getElementById('txt-tipo-modal_modificar_contenedor');
    let letraE = document.getElementById('txt-letra-modal_modificar_contenedor');
    let numeracionE = document.getElementById('txt-numeracion-modal_modificar_contenedor');
    let estadoE = document.getElementById('chk_estado-modal_modificar_contenedor');

    idE.value = id;
    tipoE.value = tipo;
    letraE.value = letra;
    numeracionE.value = numeracion;
    estadoE.checked = estado;

    estadoE.dispatchEvent(new Event('change'));

    $("#modal_modificar_contenedor").modal("show");

}

function modificarContenedorModal() {
    if (
        $('#txt-tipo-modal_modificar_contenedor').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un Tipo de Contenedor",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#txt-letra-modal_modificar_contenedor').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un Alias de Contenedor",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#txt-numeracion-modal_modificar_contenedor').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese una Numeración de Contenedor",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-contenedor-modal_modificar_contenedor").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");
        let id = document.getElementById('id-contenedor-modal_modificar_contenedor');
        let tipo = document.getElementById('txt-tipo-modal_modificar_contenedor');
        let letra = document.getElementById('txt-letra-modal_modificar_contenedor');
        let numeracion = document.getElementById('txt-numeracion-modal_modificar_contenedor');
        let estado = document.getElementById('chk_estado-modal_modificar_contenedor');
        let token = $("#csrf-token-modal_modificar_contenedor").val();
        let datos = new FormData();
        datos.append('id', id.value);
        datos.append('tipo', tipo.value);
        datos.append('letra', letra.value);
        datos.append('numeracion', numeracion.value);
        datos.append('estado', estado.checked);
        $.ajax({
            url: '/tipos-contenedores/update',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Tipo de Contenedor Modificado",
                        type: "success",
                        zindex: 99999
                    });
                    tipo.value = "";
                    letra.value = "";
                    numeracion.value = "";
                    estado.checked = true;
                    estado.dispatchEvent(new Event('change'));
                    $("#modal_modificar_contenedor").modal('hide');
                    $("#btn-guardar-contenedor-modal_modificar_contenedor").html("<i class='fa fa-save'></i> Guardar");
                    getContenedores();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido modificar el Tipo de Contenedor",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-contenedor-modal_modificar_contenedor").html("<i class='fa fa-save'></i> Guardar");
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

function show_delete_contenedor(id) {
    $('#txt-id-delete-contenedor').val(id);
    $("#modal_confirm_delete_contenedor").modal("show");
}

btnDeleteContenedor.addEventListener('click', function () {
    let id = $('#txt-id-delete-contenedor').val();
    let token = $("#csrf-token-modal_confirm_delete_contenedor").val();
    $.ajax({
        url: `/tipos-contenedores/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Tipo de Contenedor Eliminado",
                    type: "success",
                    zindex: 99999
                });
                $('#txt-id-delete-contenedor').val('');
                $("#modal_confirm_delete_contenedor").modal('hide');
                getContenedores();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar el Tipo de Contenedor",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_contenedor").modal('hide');
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