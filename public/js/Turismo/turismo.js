$(document).ready(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $('.dropify').dropify();
    get_turismo()
})
//$("#global-loader").addClass("none");
//$("#global-loader").removeClass("block");

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE TURISMO */
$("#btn-añadir-turismo").click(function () {
    $('#txt-titulo').val('')
    $('#txt-descripcion').val('')
    $('#select-categoria').val('0')
    $('#btn-guardar-turismo').html('<i class="fa fa-save"></i> Guardar')
    //get_categoria_select()
    $("#modal-turismo").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE  TURISMO */


$('#select-tipo').change(function () {
    if ($('#select-tipo').val() == 'T') {
        get_categoria_menu_t()
    } else {
        get_categoria_menu_c()
    }
})




/*INICIO DE FUNCION PARA LISTAR LAS CATEGORIAS*/
function get_categoria_menu_t() {
    $("#select-categoria").html("<option value='0'>Cargando Categorías..</option>")
    $.ajax({
        url: '/get-categoria-turismo',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Categoría</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_categoria + '</option>'
                })
                $("#select-categoria").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS CATEGORIAS*/


/*INICIO DE FUNCION PARA LISTAR LAS CATEGORIAS*/
function get_categoria_menu_t_m(id_ca) {
    $("#select-categoria-m").html("<option value='0'>Cargando Categorías..</option>")
    $.ajax({
        url: '/get-categoria-turismo',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Categoría</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_categoria + '</option>'
                })
                $("#select-categoria-m").html(ht)
                $("#select-categoria-m> option[value='" + id_ca + "'] ").attr('selected', 'selected');
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS CATEGORIAS*/


/*INICIO DE FUNCION PARA LISTAR LAS CATEGORIAS*/
function get_categoria_menu_c() {
    $("#select-categoria").html("<option value='0'>Cargando Categorías..</option>")
    $.ajax({
        url: 'get-categoria-centro-comercial',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Categoría</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_categoria + '</option>'
                })
                $("#select-categoria").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS CATEGORIAS*/

/*INICIO DE FUNCION PARA LISTAR LAS CATEGORIAS*/
function get_categoria_menu_c_m(id_ca) {
    $("#select-categoria-m").html("<option value='0'>Cargando Categorías..</option>")
    $.ajax({
        url: 'get-categoria-centro-comercial',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Categoría</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_categoria + '</option>'
                })
                $("#select-categoria-m").html(ht)
                $("#select-categoria-m> option[value='" + id_ca + "'] ").attr('selected', 'selected');

            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS CATEGORIAS*/


/*INICIO DE FUNCION PARA LISTAR LAS CATEGORIAS*/
function get_categoria_select() {
    $("#select-categoria").html("<option value='0'>Cargando Cooperativas..</option>")
    $.ajax({
        url: '/get-categoria',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Categoria</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_categoria + '</option>'
                })
                $("#select-categoria").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS CATEGORIAS*/

/*INICIO DE FUNCION PARA LISTAR LAS CATEGORIAS*/
function get_categoria_select_m(id_categoria) {
    $("#select-categoria-m").html("<option value='0'>Cargando Categorias..</option>")
    $.ajax({
        url: '/get-categoria',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Categoria</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_categoria + '</option>'
                })
                $("#select-categoria-m").html(ht)
                $("#select-categoria-m> option[value='" + id_categoria + "'] ").attr('selected', 'selected');
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS CATEGORIAS*/



/*INICIO DE FUNCION PARA LISTA TURISMO */
function get_turismo() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar turismos")
    $.ajax({
        url: '/get-turismo',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-turismo" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th width="15%" align="center" class="border-bottom-0 color-th">FOTO</th>'
                ht += '				<th width="20%" align="center" class="border-bottom-0 color-th">TITULO</th>'
                ht += '				<th width="45%" align="center" class="border-bottom-0 color-th">DESCRIPCION</th>'
                ht += '			    <th width="10%" align="center" class="border-bottom-0 color-th">CATEGORIA</th>'
                ht += '			    <th width="10%" align="center" class="border-bottom-0 color-th">estado</th>'
                ht += '			    <th width="10%" align="center" class="border-bottom-0 color-th">tipo</th>'
                ht += '				<th width="10%" align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '			    <td align="center" class="color-td"> <img class="tam-ima-slider-ta" src="/imagenes_turismo/' + data.tu_ruta_foto + '"></td>'
                    ht += '			    <td align="center" class="color-td"> ' + data.tu_titulo + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.tu_descripcion + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.ca_categoria + '</td>'
                    if (data.tu_estado == 'A') {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-success me-1">Activo</span></td>'
                    } else {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-danger me-1">Inactivo</span></td>'
                    }
                    if (data.tu_tipo == 'T') {
                        ht += '				<td align="center" class="color-td">Turismo</td>'
                    } else {
                        ht += '				<td align="center" class="color-td">Centro Comercial</td>'
                    }
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" id="' + data.tu_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.tu_id + '-' + data.tu_ruta_foto + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-turismo").html(ht)

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR TURISMO */
                $(".btn-modal-eliminar").click(function () {
                    var id = this.id
                    var id_ = id.split('-')
                    $("#txt-id-turismo").val(id_[0])
                    $("#txt-foto-anterior-e").val(id_[1])
                    $("#modal-turismo-e").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR TURISMO*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR TURISMO*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-turismo-m").val(this.id)
                    get_turismos_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  TURISMO*/

            }
            $("#table-turismo").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR TURISMO */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE TURISMO */
$("#btn-guardar-turismo").click(function () {
    if (
        $('#txt-titulo').val() == '' &&
        $('#select-tipo').val() == '0' &&
        $('#select-categoria').val() == '0' &&
        $('#select-estado').val() == '0' &&
        $('#txt-descripcion').val() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos están vacíos",
            position: "right",
            autohide: false
        });
    }  else if ($('#select-tipo').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo tipo no ha sido seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($('#select-categoria').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo categoría no ha sido seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($('#select-estado').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo estado no ha sido seleccionado",
            position: "right",
            autohide: false
        });
    }else if ($('#txt-titulo').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Nombre esta vacío",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-descripcion').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo descripción esta vacío",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-guardar-turismo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
        guardar_turismos()
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE TURISMO */

/*INICIO FUNCION PARA GUARDAR DE TURISMO */
function guardar_turismos() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-turismo")[0]);
    $.ajax({
        url: '/registrar-turismo',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Turismo registrada",
                    type: "success"
                });
                $("#txt-titulo").val("")
                $("#txt-descripcion").val("")
                $("#txt-abreviatura").val("")
                $("#select-categoria").val("0")
                $("#select-tipo").val("0")
                $("#select-estado").val("0")
                var drEvent2 = $('#txt-file-foto').dropify();
                drEvent2 = drEvent2.data('dropify');
                drEvent2.resetPreview();
                drEvent2.clearElement();
                $("#modal-turismo").modal('hide')
                $("#btn-guardar-turismo").html("<i class='fa fa-save'></i> Guardar")
                get_turismo()
            } else if (response.respuesta == 'imagen_vacia') {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>Subir una imagen de turismo",
                    position: "right",
                    autohide: false
                });
                $("#btn-guardar-turismo").html("<i class='fa fa-save'></i> Guardar")
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
/*FIN FUNCION PARA GUARDAR DE TURISMO */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE TURISMO */
$("#btn-eliminar-turismo").click(function () {
    $("#btn-eliminar-turismo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Eliminando..</span>")
    eliminar_turismo_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE TURISMO*/

/*INICIO FUNCION DE ELIMINAR DE TURISMO*/
function eliminar_turismo_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-turismo-e")[0]);
    $.ajax({
        url: '/eliminar-turismo-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Turismo eliminado",
                    type: "success"
                });
                $("#btn-eliminar-turismo").html("<i class='fa fa-delete'></i> Eliminar")
                $("#modal-turismo-e").modal('hide')
                get_turismo()
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
/*FIN FUNCION DE ELIMINAR DE TURISMO*/


/*INICIO PARA FUNCION CONSULTAR TURISMO POR ID*/
function get_turismos_id(id_turismo) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar turismos por id")

    $.ajax({
        url: '/get-turismo-id/' + id_turismo,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    var drEvent = $('#txt-file-foto-m').dropify(
                        {
                            defaultFile: '/imagenes_turismo/' + data.tu_ruta_foto
                        });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = '/imagenes_turismo/' + data.tu_ruta_foto;
                    drEvent.destroy();
                    drEvent.init();
                    $("#txt-titulo-m").val(data.tu_titulo)
                    $("#txt-descripcion-m").val(data.tu_descripcion)
                    $("#select-categoria-m").val(data.tu_categoria)
                    $("#select-estado-m").val(data.tu_estado)
                    $("#select-tipo-m").val(data.tu_tipo)
                    $('#select-tipo-m').change(function () {
                        if ($('#select-tipo-m').val() == 'T') {
                            get_categoria_menu_t_m(data.tu_id_categoria)
                        } else {
                            get_categoria_menu_c_m(data.tu_id_categoria)
                        }
                    })
                    $('#select-tipo-m').change()

                    $("#txt-foto-anterior").val(data.tu_ruta_foto)
                    //get_categoria_select_m(data.tu_id_categoria)
                })
                $("#modal-turismo-m").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR TURISMO POR ID*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DE TURISMO */
$("#btn-modificar-turismo").click(function () {
    if (
        $('#txt-titulo-m').val() == '' &&
        $('#select-tipo-m').val() == '0' &&
        $('#select-categoria-m').val() == '0' &&
        $('#select-estado-m').val() == '0' &&
        $('#txt-descripcion-m').val() == ''
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos están vacíos",
            position: "right",
            autohide: false
        });
    } else if ($('#select-tipo-m').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo tipo no ha sido seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($('#select-categoria-m').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo categoría no ha sido seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($('#select-estado-m').val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo estado no ha sido seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-titulo-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo Nombre esta vacío",
            position: "right",
            autohide: false
        });
    } else if ($('#txt-descripcion-m').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo descripción esta vacío",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-modificar-turismo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Modificando..</span>")
        modificar_turismo()
    }
})
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DE TURISMO */

/*INICIO DE FUNCION PARA MODIFICAR DE TURISMO  POR ID */
function modificar_turismo() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-turismo-m")[0]);
    $.ajax({
        url: '/modificar-turismo',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Turismo modificado",
                    type: "success"
                });
                $("#modal-turismo-m").modal('hide')
                $("#btn-modificar-turismo").html("<i class='fa fa-edit'></i> Modificar")
                get_turismo()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar turismos",
                    position: "right",
                    autohide: false
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
/*FIN DE FUNCION PARA MODIFICAR DE TURISMO  POR ID */




