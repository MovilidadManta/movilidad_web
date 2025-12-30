$(document).ready(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $('.dropify').dropify();
    get_tipo_permiso()
    //get_campos()
})

/*INICIO DE FUNCION PARA LISTAR LOS DEPARTAMENTOS DEL MODIFICAR EN EL SELECT*/
function get_campos() {
    $("#select-campo-tipo-permiso").html("<option value='0'>Cargando campos...</option>")
    $.ajax({
        url: '/get-campo',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option id="0">Seleccione Campo</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_tipo + '</option>'
                })
                $("#select-campo-tipo-permiso").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS DEPARTAMENTOS DEL MODIFCAR EN EL SELECT*/


/*INICIO DE FUNCION PARA LISTAR tipo-permisoS */
function get_tipo_permiso() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");

    $.ajax({
        url: '/get-tipo-permiso',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log("Data de Permisos" + response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-tipo-permiso" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Id</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Tipo de permiso </th>'
                //ht += '			    <th align="center" class="border-bottom-0 color-th">Notas</th>'
                //ht += '			    <th align="center" class="border-bottom-0 color-th">Estado Documento</th>'
                //ht += '			    <th align="center" class="border-bottom-0 color-th">Estado enfermedad</th>'
                //ht += '			    <th align="center" class="border-bottom-0 color-th">Estado permiso por hora</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">fecha de created</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">fecha de update</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Estado</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Configuración</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '				<td align="center" class="color-td">' + data.id + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.tipo_permiso + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.fecha_created + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.fecha_update + '</td>'
                    //ht += '				<td align="center" class="color-td">' + data.notas + '</td>'
                    //ht += '				<td align="center" class="color-td">' + data.estado_documento + '</td>'
                    //ht += '				<td align="center" class="color-td">' + data.estado_enfermedad + '</td>'
                    //ht += '				<td align="center" class="color-td">' + data.estado_permisoxhora + '</td>'
                    if (data.estado == 1) {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-success me-1">Activo</span></td>'
                    } else if (data.estado == 0) {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-danger me-1">Inactivo</span></td>'
                    }
                    ht += '				<td class="color-td" align="center">'
                    ht += '                 <div class="text-wrap" >'
                    ht += '                         <div class="row row-xs wd-xl-80p">'
                    ht += '                             <div class="btn-group mb-2 mt-2">'
                    ht += '                                 <button type="button" class="btn btn-outline-primary dropdown-toggle btn-opcion" id="btn-opcion-' + data.id + '" data-bs-toggle="dropdown" aria-expanded="false"><i class="fe fe-settings"></i></button>'
                    ht += '                                     <ul class="dropdown-menu">'
                    ht += '                                         <li><a class="dropdown-item"  id="' + data.id + '" onclick="open_modal_campo_permiso(this.id)" href="javascript:void(0);">Campos</a></li>'
                    ht += '                                         <li><a class="dropdown-item"  id="' + data.id + '" onclick="open_modal_articulos_permisos(this.id)" href="javascript:void(0);">Articulos</a></li>'
                    ht += '                                         <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>'
                    ht += '                                         <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>'
                    ht += '                                     </ul>'
                    ht += '                             </div>'
                    ht += '                         </div>'
                    ht += '                 </div >'
                    ht += '             </td>'
                    ht += '				<td class="color-td" align="center">'
                    ht += '                 <button type="button" id="' + data.id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '                 <button type="button" id="' + data.id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '             </td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-tipo-permiso").html(ht)

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR tipo-permisoS */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-tipo-permiso").val(this.id)
                    $("#modal-tipo-permiso-e").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR tipo-permisos*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR tipo-permisoS*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-tipo-permiso-m").val(this.id)
                    get_cooperativa_select_m()
                    get_tipo - permisos_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  tipo-permisoS*/


            }
            $("#table-tipo-permiso").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR tipo-permisoS */

function open_modal_campo_permiso(id) {
    $("#modal-campo-tipo-permiso").modal("show")
    get_campos()
    get_campo_tipo_permiso(id)
}

//INICIO MODAL PARA CONFIGURAR CAMPOS DEL TIPO DE PERMISO
function get_campo_tipo_permiso(id) {
    $("#btn-opcion-" + id).html("<span class='spinner-border spinner-border-sm margin-spiner'></span><span ></span>")
    $("#div-table-tipo-permiso-campo").html("<span class='spinner-border spinner-border-sm margin-spiner'></span><span > Cargando la información... espere un momento....</span>")
    $("#txt-id-tipo-permiso").val(id)
    //$("#global-loader").addClass("block");
    //$("#global-loader").removeClass("none");
    $.ajax({
        url: '/get-campo-tipo-permiso/' + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                console.log("llegue")
                var ht = ""
                ht += '  <table id="table-tipo-permiso-campo" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Nro</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Campo</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Estado</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '				<td align="center" class="color-td">' + data.tpc_id + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.ca_tipo + '</td>'
                    if (data.tpc_estado == 1) {
                        ht += '				<td class="color-td" align="center"><span class="badge bg-success me-1">Activo</span></td>'
                    } else {
                        ht += '				<td class="color-td" align="center"><span class="badge bg-danger me-1">Inactivo</span></td>'
                    }
                    ht += '				<td class="color-td" align="center">'
                    ht += '                 <button type="button" id="1" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '                 <button type="button" id="2" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '             </td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-tipo-permiso-campo").html(ht)

                $("#btn-guardar-campo-tipo-permiso").click(function () {
                    $("#btn-guardar-campo-tipo-permiso").html("<span class='spinner-border spinner-border-sm margin-spiner color-btn-nuevo'></span><span class='color-btn-nuevo'> Cargando...!</span>")
                    guardar_campo_tipo_permiso(id)
                })
            }
            $("#btn-opcion-" + id).html("<i class='fe fe-settings'></i>")
            $("#table-tipo-permiso-campo").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
//FIN MODAL PARA CONFIGURAR CAMPOS DEL TIPO DE PERMISO



//INICIO GUARDAR CAMPO DEL TIPO DE PERMISO
function guardar_campo_tipo_permiso(id) {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-campo-tipo-permiso")[0]);
    $.ajax({
        url: '/save-campo-tipo-permiso',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                notif({
                    msg: "<b>Correcto:</b> Campo tipo permiso registrado",
                    type: "success"
                });
                $("#btn-guardar-campo-tipo-permiso").html("<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir</strong>")
                //$("#modal-campo-tipo-permiso").modal("hide")
                get_campo_tipo_permiso(id)
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
//FIN GUARDAR CAMPO DEL TIPO DE PERMISO

//INICIO ABRIR MODAL ARTICULOS DE TIPOS DE PERMISOS
function open_modal_articulos_permisos(id) {
    $("#modal-articulo-tipo-permiso").modal("show")
    get_articulo_tipo_permiso(id)
}
//FIN ABRIR MODAL ARTICULOS DE TIPOS DE PERMISOS

//INICIO MODAL PARA CONFIGURAR ARTICULOS DEL TIPO DE PERMISO
function get_articulo_tipo_permiso(id) {
    $("#btn-opcion-" + id).html("<span class='spinner-border spinner-border-sm margin-spiner'></span><span ></span>")
    $("#div-table-tipo-permiso-articulo").html("<span class='spinner-border spinner-border-sm margin-spiner'></span><span > Cargando la información... espere un momento....</span>")
    $("#txt-id-tipo-permiso-articulo").val(id)
    //$("#global-loader").addClass("block");
    //$("#global-loader").removeClass("none");
    $.ajax({
        url: '/get-articulo-tipo-permiso/' + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                console.log("llegue")
                var ht = ""
                ht += '  <table id="table-tipo-permiso-articulo" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Nro</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Articulo</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Estado</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '				<td align="center" class="color-td">' + data.art_id + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.art_articulo + '</td>'
                    if (data.art_estado == 1) {
                        ht += '				<td class="color-td" align="center"><span class="badge bg-success me-1">Activo</span></td>'
                    } else if (data.art_estado == 0) {
                        ht += '				<td class="color-td" align="center"><span class="badge bg-danger me-1">Inactivo</span></td>'
                    }
                    ht += '				<td class="color-td" align="center">'
                    ht += '                 <button type="button" id="1" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '                 <button type="button" id="2" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '             </td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
            }
            $("#div-table-tipo-permiso-articulo").html(ht)
            $("#btn-opcion-" + id).html("<i class='fe fe-settings'></i>")
            $("#table-tipo-permiso-articulo").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
//FIN MODAL PARA CONFIGURAR CAMPOS DEL TIPO DE PERMISO

//INICIO GUARDAR CAMPO DEL TIPO DE PERMISO
function guardar_articulo_tipo_permiso() {
    $("#btn-guardar-articulo-tipo-permiso").html("<span class='spinner-border spinner-border-sm margin-spiner color-btn-nuevo'></span><span class='color-btn-nuevo'> Guardando...!</span>")
    var id = $("#txt-id-tipo-permiso-articulo").val()
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-articulo-tipo-permiso")[0]);
    $.ajax({
        url: '/save-articulo-tipo-permiso',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                $("#txt-articulo").val("")
                notif({
                    msg: "<b>Correcto:</b> Articulo del permiso registrado",
                    type: "success"
                });
                $("#btn-guardar-articulo-tipo-permiso").html("<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir</strong>")
                get_articulo_tipo_permiso(id)

                /*Swal.fire({
                    title: "Muy bien!",
                    text: "Articulo guardado correctamente!",
                    icon: "success"
                });*/
                //$("#modal-articulo-tipo-permiso").modal("hide")

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
//FIN GUARDAR CAMPO DEL TIPO DE PERMISO
