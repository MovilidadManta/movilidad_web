let btnAgregarBodega = document.getElementById('btn-añadir-bodega');
let btnGuardarBodega = document.getElementById('btn-guardar-bodega-modal_agregar_bodega');
let btnModificarBodega = document.getElementById('btn-guardar-bodega-modal_modificar_bodega');
let selectEmpresaAgregar = document.getElementById('select-empresa-modal_agregar_bodega');
let selectEmpresaModificar = document.getElementById('select-empresa-modal_modificar_bodega');
let btnDeleteBodega = document.getElementById('btn-delete-bodega');

$(document).ready(function () {
    getBodegas();

    btnAgregarBodega.addEventListener('click', () => {
        $("#modal_agregar_bodega").modal("show");
    });

    btnGuardarBodega.addEventListener('click', agregarBodegaModal);
    btnModificarBodega.addEventListener('click', modificarBodegaModal);

    $.ajax({
        url: '/bodegas/getempresas',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = '';
            $(response).each(function (i, dat) {
                html +=
                    '<option value="' +
                    dat.id +
                    '">' +
                    dat.empresa +
                    "</option>";
            });
            selectEmpresaAgregar.innerHTML += html;
            selectEmpresaModificar.innerHTML += html;
        }
    });
});

function getBodegas() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/bodegas/getbodegas',
        type: "GET",
        dataType: "json",
        success: function (response) {
            let html = configureTableHtml("table-bodegas",
                ['ID', 'EMPRESA', 'ARCHIVO', 'UBICACIÓN', 'FECHA CREACIÓN', 'ESTADO', 'OPCIONES'
                ],
                ['id', 'empresa', 'archivo', , 'ubicacion', 'created_at',
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
                            <button type="button" class="tam-btn btn btn-warning btn-modal-editar" Onclick ="show_mod_bodega(${item.id},'${item.archivo}','${item.ubicacion}',${item.id_empresa},${item.estado})"><i class="fa fa-edit tam-icono"></i></button>
                            <button type="button" class="tam-btn btn btn-danger btn-modal-eliminar" Onclick ="show_delete_bodega(${item.id})"><i class="fa fa-trash tam-icono"></i></button>
                            `;
                        }
                    },
                ], response
            );

            $("#div-table-bodega").html(html);

            $("#table-bodegas").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}

function agregarBodegaModal() {
    if ($('#select-empresa-modal_agregar_bodega').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese una Empresa",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#txt-archivo-modal_agregar_bodega').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un nombre de archivo",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#txt-ubicacion-modal_agregar_bodega').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un nombre de ubicación",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-bodega-modal_agregar_bodega").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");
        let empresa = document.getElementById('select-empresa-modal_agregar_bodega');
        let archivo = document.getElementById('txt-archivo-modal_agregar_bodega');
        let ubicacion = document.getElementById('txt-ubicacion-modal_agregar_bodega');
        let estado = document.getElementById('chk_estado-modal_agregar_bodega');
        let token = $("#csrf-token-modal_agregar_bodega").val();
        let datos = new FormData();
        datos.append('archivo', archivo.value);
        datos.append('ubicacion', ubicacion.value);
        datos.append('id_empresa', empresa.value);
        datos.append('estado', estado.checked);
        $.ajax({
            url: '/bodegas/store',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Bodega Registrada",
                        type: "success",
                        zindex: 99999
                    });
                    empresa.value = 0;
                    archivo.value = "";
                    ubicacion.value = "";
                    estado.checked = true;
                    estado.dispatchEvent(new Event('change'));
                    $("#modal_agregar_bodega").modal('hide');
                    $("#btn-guardar-bodega-modal_agregar_bodega").html("<i class='fa fa-save'></i> Guardar");
                    getBodegas();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido registrar la Bodega",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-bodega-modal_agregar_bodega").html("<i class='fa fa-save'></i> Guardar");
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

//show_mod_bodega(${item.id},'${item.archivo}','${item.ubicacion}',${item.id_empresa},${item.estado})
function show_mod_bodega(id, archivo, ubicacion, id_empresa, estado) {
    let idE = document.getElementById('id-bodega-modal_modificar_bodega');
    let empresa = document.getElementById('select-empresa-modal_modificar_bodega');
    let archivoE = document.getElementById('txt-archivo-modal_modificar_bodega');
    let ubicacionE = document.getElementById('txt-ubicacion-modal_modificar_bodega');
    let estadoE = document.getElementById('chk_estado-modal_modificar_bodega');

    idE.value = id;
    empresa.value = id_empresa;
    archivoE.value = archivo;
    ubicacionE.value = ubicacion;
    estadoE.checked = estado;

    estadoE.dispatchEvent(new Event('change'));

    $("#modal_modificar_bodega").modal("show");

}

function modificarBodegaModal() {
    if ($('#select-empresa-modal_modificar_bodega').val() == 0) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese una Empresa",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#txt-archivo-modal_modificar_bodega').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un nombre de archivo",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else if (
        $('#txt-ubicacion-modal_modificar_bodega').val().trim() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Por favor ingrese un nombre de ubicación",
            position: "right",
            autohide: false,
            zindex: 99999
        });
    } else {
        $("#btn-guardar-bodega-modal_modificar_bodega").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>");
        let id = document.getElementById('id-bodega-modal_modificar_bodega');
        let empresa = document.getElementById('select-empresa-modal_modificar_bodega');
        let archivo = document.getElementById('txt-archivo-modal_modificar_bodega');
        let ubicacion = document.getElementById('txt-ubicacion-modal_modificar_bodega');
        let estado = document.getElementById('chk_estado-modal_modificar_bodega');
        let token = $("#csrf-token-modal_modificar_bodega").val();
        let datos = new FormData();
        datos.append('id', id.value);
        datos.append('archivo', archivo.value);
        datos.append('ubicacion', ubicacion.value);
        datos.append('id_empresa', empresa.value);
        datos.append('estado', estado.checked);
        $.ajax({
            url: '/bodegas/update',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                if (response.respuesta == "true") {
                    notif({
                        msg: "<b>Correcto:</b> Bodega Modificada",
                        type: "success",
                        zindex: 99999
                    });
                    id.value = "";
                    empresa.value = 0;
                    archivo.value = "";
                    ubicacion.value = "";
                    estado.checked = true;
                    estado.dispatchEvent(new Event('change'));
                    $("#modal_modificar_bodega").modal('hide');
                    $("#btn-guardar-bodega-modal_modificar_bodega").html("<i class='fa fa-save'></i> Guardar");
                    getBodegas();
                } else {
                    notif({
                        type: "warning",
                        msg: "<b>Aviso: </b>No se ha podido modificar la Bodega",
                        position: "right",
                        autohide: false,
                        zindex: 99999
                    });
                    $("#btn-guardar-bodega-modal_modificar_bodega").html("<i class='fa fa-save'></i> Guardar");
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

function show_delete_bodega(id) {
    $('#txt-id-delete-bodega').val(id);
    $("#modal_confirm_delete_bodega").modal("show");
}

btnDeleteBodega.addEventListener('click', function () {
    let id = $('#txt-id-delete-bodega').val();
    let token = $("#csrf-token-modal_confirm_delete_bodega").val();
    $.ajax({
        url: `/bodegas/delete/${id}`,
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Bodega Eliminada",
                    type: "success",
                    zindex: 99999
                });
                $('#txt-id-delete-bodega').val('');
                $("#modal_confirm_delete_bodega").modal('hide');
                getBodegas();
            } else {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>No se ha podido eliminar la Bodega",
                    position: "right",
                    autohide: false,
                    zindex: 99999
                });
                $("#modal_confirm_delete_bodega").modal('hide');
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
