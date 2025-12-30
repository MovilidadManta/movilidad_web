$(document).ready(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    get_empleados()

    var maxLength = 50;
    $('#select-causa > option').text(function (i, text) {
        if (text.length > maxLength) {
            return text.substr(0, maxLength) + '...';
        }
    });

    $("#select-causa").change(function (event) {
        $.each($(this).find('option'), function (key, value) {
            $(value).removeClass('active');
        })
        $('option:selected').addClass('active');

    });

    $("#select-causa").tooltip({
        placement: 'right',
        trigger: 'hover',
        container: 'body',
        title: function (e) {
            return $(this).find('.active').attr('title');
        }
    });
})

function showIETooltip(e) {
    if (!e) { var e = window.event; }
    var obj = e.srcElement;
    var objHeight = obj.offsetHeight;
    var optionCount = obj.options.length;
    var eX = e.offsetX;
    var eY = e.offsetY;

    //vertical position within select will roughly give the moused over option...
    var hoverOptionIndex = Math.floor(eY / (objHeight / optionCount));

    var tooltip = document.getElementById('dvDiv');
    tooltip.innerHTML = obj.options[hoverOptionIndex].title;

    mouseX = e.pageX ? e.pageX : e.clientX;
    mouseY = e.pageY ? e.pageY : e.clientY;

    tooltip.style.left = mouseX + 10;
    tooltip.style.top = mouseY;

    tooltip.style.display = 'block';

    var frm = document.getElementById("frm");
    frm.style.left = tooltip.style.left;
    frm.style.top = tooltip.style.top;
    frm.style.height = tooltip.offsetHeight;
    frm.style.width = tooltip.offsetWidth;
    frm.style.display = "block";
}
function hideIETooltip(e) {
    var tooltip = document.getElementById('dvDiv');
    var iFrm = document.getElementById('frm');
    tooltip.innerHTML = '';
    tooltip.style.display = 'none';
    iFrm.style.display = 'none';
}

/*INICIO DE FUNCION PARA LISTAR LOS DEPARTAMENTOS DEL MODIFICAR EN EL SELECT*/
function get_departamentos_modificar() {
    $("#select-departamento").html("<option value='0'>Cargando departamentos...</option>")
    $.ajax({
        url: '/get-departamento',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option id="0">Seleccione Departamento</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.dep_id + '>' + data.dep_departamento + '</option>'
                })
                $("#select-m-departamento").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS DEPARTAMENTOS DEL MODIFCAR EN EL SELECT*/


/*INICIO DE FUNCON PARA LISTAR LOS PERFILES*/
function get_perfiles_modificar() {
    $("#select-perfil").html("<option value='0'>Cargando perfiles...</option>")
    $.ajax({
        url: '/get-perfil',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option id="0">Seleccione Perfil</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.per_id + '>' + data.per_perfil + '</option>'
                })
                $("#select-m-perfil").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS PERFILES*/

/*INICIO DE FUNCION PARA LISTAR LOS EMPLEADOS */
function get_empleados() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar empleado")
    $.ajax({
        url: '/get-empleado',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-empleado" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Foto</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Cedula</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Funcionario</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">dirección</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">jefatura</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">cargo</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Telefono</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">tipo sangre</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody class="tam-em">'
                $(response.data).each(function (i, data) {
                    if (data.emp_estado == "I") {
                        ht += '			<tr class="inactivo">'
                        if (data.emp_estado_ruta_foto == true) {
                            ht += '				<td class="color-td" align="center"><img class="tam-ima-emp-ta" src="/imagenes_empleados/' + data.emp_ruta_foto + '"></td>'
                        } else {
                            ht += '				<td class="color-td" align="center"><img class="tam-ima-emp-ta" src="https://ui-avatars.com/api/?name=' + data.emp_nombre + ' ' + data.emp_apellido + '&background=0D8ABC&color=fff"></td>'
                        }
                        ht += '			    <td class="color-td" align="center">' + data.emp_cedula + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.emp_apellido + ' ' + data.emp_nombre + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.dep_departamento + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.per_perfil + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.emp_cargo + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.emp_telefono + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.emp_tipo_sangre + '</td>'
                        ht += '				<td class="color-td" align="center">'
                        ht += '                 <button type="button" id="' + data.emp_id + '-' + data.emp_id_empleado_biometrico + '" class="tam-btn btn btn-warning btn-vista-editar"><i class="fa fa-edit tam-icono"></i></button>'
                        ht += '                 <button type="button" id="' + data.emp_id + '-' + data.emp_estado + '" class="tam-btn btn btn-dark btn-notificar-empleado background-btn-nuevo"><i class="fa fa-user-times tam-icono "></i></button>'
                        ht += '				</td>'
                        ht += '			</tr>'

                    } else if (data.emp_estado == "A") {
                        ht += '			<tr>'
                        if (data.emp_estado_ruta_foto == true) {
                            ht += '				<td class="color-td" align="center"><img class="tam-ima-emp-ta" src="/imagenes_empleados/' + data.emp_ruta_foto + '"></td>'
                        } else {
                            ht += '				<td class="color-td" align="center"><img class="tam-ima-emp-ta" src="https://ui-avatars.com/api/?name=' + data.emp_nombre + ' ' + data.emp_apellido + '&background=0D8ABC&color=fff"></td>'
                        }
                        ht += '			    <td class="color-td" align="center">' + data.emp_cedula + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.emp_apellido + ' ' + data.emp_nombre + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.dep_departamento + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.per_perfil + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.ca_cargo + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.emp_telefono + '</td>'
                        ht += '				<td class="color-td" align="center">' + data.emp_tipo_sangre + '</td>'
                        ht += '				<td class="color-td" align="center">'
                        ht += '                 <button type="button" id="' + data.emp_id + '-' + data.emp_id_empleado_biometrico + '" class="tam-btn btn btn-warning btn-vista-editar"><i class="fa fa-edit tam-icono"></i></button>'
                        ht += '                 <button type="button" id="' + data.emp_id + '-' + data.emp_estado + '" class="tam-btn btn btn-dark btn-notificar-empleado background-btn-nuevo"><i class="fa fa-user-times tam-icono "></i></button>'
                        ht += '				</td>'
                        ht += '			</tr>'
                    }

                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-empleado").html(ht)

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR */
                $(".btn-vista-eliminar").click(function () {
                    $("#txt-id-empleado").val(this.id)
                    $("#modal-eliminar-empleado").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR */

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR */
                $(".btn-vista-editar").click(function () {
                    $("#txt-id-modificar-empleado").val(this.id)
                    //get_departamentos_modificar()
                    //get_perfiles_modificar()
                    var id = this.id.split('-');
                    id_empleado = id[0]
                    id_empleado_biometrico = id[1]
                    location.href = "/modificar-nomina/" + id_empleado
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR */

                /* INICIO CLICK PARA ABRIR EL MODAL DE NOTIFICAR EL EMPLEADO */
                $(".btn-notificar-empleado").click(function () {
                    var id = this.id
                    var id_ = id.split('-')
                    $("#txt-id-empleado").val(id_[0])
                    $("#txt-id-empleado-e").val(id_[0])
                    if (id_[1] == 'I') {
                        $("#btn-guardar-notificacion").addClass('none')
                        $("#btn-modal-eliminar-notificacion").removeClass('none')
                        $("#btn-modal-eliminar-notificacion").addClass('block')
                    } else if (id_[1] == 'A') {
                        $("#btn-guardar-notificacion").removeClass('none')
                        $("#btn-guardar-notificacion").addClass('block')
                        $("#btn-modal-eliminar-notificacion").addClass('none')
                    }
                    $("#modal-notificacion").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE NOTIFICAR EL EMPLEADO */

                //INICIO CLICK PARA DESCARGAR LA IMAGEN EN PNG DEL QR DEL EMPLEADO
                $('.btn-qr').click(function () {
                    $ruta = this.id
                    location.href = "/descargar-qr/" + $ruta + ".png";
                })
                //FIN CLICK PARA DESCARGAR LA IMAGEN EN PNG DEL QR DEL EMPLEADO

            }
            $("#table-empleado").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR LOS EMPLEADOS */

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE EMPLEADO */
$("#btn-añadir-empleado").click(function () {
    $("#select-departamento").html("<option value='0'>Cargando</option>")
    $("#select-perfil").html("<option value='0'>Cargando</option>")
    //get_departamentos()
    // get_perfiles()
    location.href = "/registrar-nomina";
    //$("#modal-empleado").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE EMPLEADO */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR EL EMPLEADO */
$("#btn-eliminar-empleado").click(function () {
    eliminar_empleado_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR EL EMPLEADO */

/*INICIO FUNCION DE ELIMINAR EMPLEADO*/
function eliminar_empleado_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-eliminar-empleado")[0]);
    $.ajax({
        url: '/eliminar-empleado-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> Empleado eliminado",
                    type: "success"
                });
                $("#modal-eliminar-empleado").modal('hide')
                get_empleados()
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
/*FIN FUNCION DE ELIMINAR EMPLEADO*/

/*INICIO PARA FUNCION CONSULTAR EMPLEADO POR ID*/
function get_empleado_id($id_empleado) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar empleado")
    var id_empleado = $id_empleado
    $.ajax({
        url: '/get-empleado-id/' + id_empleado,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {

                    $("#txt-id-modificar-empleado").val(data.emp_id)
                    $("#txt-m-cedula").val(data.emp_cedula)
                    $("#txt-m-nombre").val(data.emp_nombre)
                    $("#txt-m-apellido").val(data.emp_apellido)
                    $("#txt-m-telefono").val(data.emp_telefono)
                    $("#select-m-departamento").val(data.emp_id_departamento)
                    $("#select-m-perfil").val(data.emp_id_perfil)
                    $("#select-m-tipo-contrato").val(data.emp_tipo_contrato)
                    $("#txt-m-remuneracion").val(data.emp_remuneracion)
                    $("#txt-m-direccion").val(data.emp_direccion)
                    $("#txt-m-observacion").val(data.emp_observacion)
                    //const input = document.getElementById('txt-m-ruta-foto');
                    //var input = document.getElementById("txt-m-ruta-foto");
                    var input = document.getElementsByTagName("input")[0];
                    console.log(input)
                    $('.file-upload-image-m').attr('src', '/imagenes_empleados/' + data.emp_ruta_foto);
                    $('.image-upload-wrap-m').hide();

                    $('.file-upload-content').show();
                    $("#txt-m-estado-imagen").val("false_")
                })
                $("#modal-modificar-empleado").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR EMPLEADO POR ID*/

/*INICO DE FUNCION PARA CARGAR LA IMAGEN DEL EMPLEADO A MODIFICAR*/
function readURL_M(input) {
    debugger
    if (input.files && input.files[0]) {
        debugger
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#txt-m-estado-imagen").val("true")
            $('.image-upload-wrap-m').hide();

            $('.file-upload-image').attr('src', e.target.result);
            $('.file-upload-content').show();

            $('.image-title').html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);

    } else {
        removeUpload_M();
    }
}

function removeUpload_M() {
    $("#txt-m-estado-imagen").val("false")
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap-m').show();
}

$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});
$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});

/*INICO DE FUNCION PARA CARGAR LA IMAGEN DEL EMPLEADO A MODIFICAR*/

/*INICIO DE DAR CLICK PARA MODIFICAR LOS DATOS DEL EMPLEADO */
$(".btn-modificar-empleado").click(function () {
    modificar_empleado()
})
/*FIN DE DAR CLICK PARA MODIFICAR LOS DATOS DEL EMPLEADO */

/*INICIO DE FUNCION PARA MODIFICAR EL EMPLEADO POR ID */
function modificar_empleado() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-m-empleado")[0]);
    $.ajax({
        url: '/modificar-empleado',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == 'empleado_registrado') {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>Empleado ya esta registrado",
                    position: "right",
                    autohide: false
                });
                console.log(resul)
            } else if (response.respuesta == 'imagen_vacia') {
                notif({
                    type: "error",
                    msg: "<b>Error: </b>Error al cargar foto",
                    position: "right",
                    autohide: false
                });
            } else if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Empleado modificado",
                    type: "success"
                });
                $("#txt-m-cedula").val("")
                $("#txt-m-nombre").val("")
                $("#txt-m-apellido").val("")
                $("#txt-m-telefono").val("")
                $("#select-m-departamento").val("0")
                $("#select-m-perfil").val("0")
                $("#select-m-tipo-contrato").val("0")
                $("#txt-m-remuneracion").val("")
                $("#txt-m-direccion").val("")
                $("#txt-m-observacion").val("")
                $("#modal-modificar-empleado").modal('hide')
                get_empleados()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar empleado",
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
/*FIN DE FUNCION PARA MODIFICAR EL EMPLEADO POR ID */

/*INICIO CLICK AL BOTON NOTIFICAR AL EMPLEADO */
$("#btn-guardar-notificacion").click(function () {

    guardar_notificacion_empleado()
})
/*FIN CLICK AL BOTON NOTIFICAR AL EMPLEADO */

/*INICIO FUNCION PARA GUARDAR NOTIFICACION */
function guardar_notificacion_empleado() {
    $("#btn-guardar-notificacion").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Notificando..</span>")
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-notificacion-empleado")[0]);
    $.ajax({
        url: '/registrar-notificacion-empleado',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            $("#modal-notificacion").modal("hide")
            if (response.respuesta == 'true') {
                if (response.data == "I") {
                    notif({
                        msg: "<b>Correcto:</b>Ya se envio una Notificacion",
                        type: "Warning"
                    });
                    $("#txt-fecha-terminacion").val("")
                    $("#select-causa").val("0")
                    $("#btn-guardar-notificacion").html("<i class='fa fa-save color-btn-nuevo'></i><strong class='color-btn-nuevo'> Notificar")
                } else {
                    notif({
                        msg: "<b>Correcto:</b>Registro de notificacion registrado",
                        type: "success"
                    });
                    $("#txt-fecha-terminacion").val("")
                    $("#select-causa").val("0")
                    $("#btn-guardar-notificacion").html("<i class='fa fa-save color-btn-nuevo'></i><strong class='color-btn-nuevo'> Notificar")
                    get_empleados()
                }
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar  notificacion",
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
/*FIN FUNCION PARA GUARDAR NOTIFICACION*/


/* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR EL NOTIFICAR EL EMPLEADO */
$("#btn-modal-eliminar-notificacion").click(function () {
    $("#modal-notificacion-e").modal("show")
})
/* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR EL NOTIFICAR EL EMPLEADO */

/* INICIO CLICK AL BOTON PARA ELIMINAR LA NOTIFICACION DEL EMPLEADO */
$("#btn-eliminar-notificacion").click(function () {
    eliminar_notificacion()
})
/* FIN CLICK PARA ELIMINAR EL MODAL DE NOTIFICAR EL EMPLEADO */

/*INICIO FUNCION PARA ELIMINAR NOTIFICACION*/
function eliminar_notificacion() {
    $("#btn-eliminar-notificacion").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Eliminando..</span>")
    //$("#btn-eliminar-notificacion").html('<label align="center"><i  class="fa fa-spinner color-letra-sugerencia"> Eliminando</i></label>')
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-notificacion-e")[0]);
    $.ajax({
        url: '/eliminar-notificacion',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                $("#modal-notificacion-e").modal('hide')
                $("#modal-notificacion").modal('hide')
                notif({
                    msg: "<b>Correcto:</b> Notificacion eliminada",
                    type: "success"
                });
                $("#btn-eliminar-notificacion").html("<i class='fa fa-times-circle'></i> Eliminar</button> Quitar")
                get_empleados()
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
/*FIN FUNCION PARA ELIMINAR LA NOTIFICACION */







