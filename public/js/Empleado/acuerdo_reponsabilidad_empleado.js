$(document).ready(function () {
    $('.dropify').dropify();
})

$("#txt-buscar").on("keyup", function () {
    var txt_buscar = $("#txt-buscar").val();
    if (txt_buscar.length >= 5 && txt_buscar.length <= 10) {
        $("#div-busqueda-empleado").html('<label align="center"><i  class="fa fa-spinner color-letra-sugerencia"> Buscando Datos</i></label>')
        console.log($("#txt-buscar").val())
        var tipo = $("#select-tipo-buscar").val()
        var valor = $("#txt-buscar").val()
        get_empleado_tipo_busqueda(tipo, valor)
    } else {
        $("#div-busqueda-empleado").html('')
        $('#div-form-empleado').html("")
    }
});

/*INICIO PARA FUNCION CONSULTAR EMPLEADO POR TIPO CEDULA O NOMBRE*/
function get_empleado_tipo_busqueda(tipo, valor) {
    console.log("listar empleado")
    $.ajax({
        url: '/get-empleado-tipo/' + tipo + '/' + valor,
        type: "GET",
        dataType: "json",
        success: function (response) {
            var ht = ""
            if (response.respuesta == "true") {
                console.log(response.data)
                ht += '  <table id="table-empleado" border="2" class="table">'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '				<td id="' + data.emp_id + '" class="btn-empleado color-td">' + data.emp_nombre + ' ' + data.emp_apellido + '</td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-busqueda-empleado").html(ht)
                $(".btn-empleado").click(function () {
                    $("#div-busqueda-empleado").html('')
                    $('#div-form-empleado').html("")
                    $("#div-form-empleado").html('<label align="center" class="mar-carg"><i  class="mar-carg fa fa-spinner color-letra-sugerencia"> Cargando Informacion</i></label>')
                    var id = this.id
                    console.log('id empleado=' + id)
                    get_empleado_id(this.id)
                    //$("#txt-id-empleado").val(id)
                    //llenar_tabla_marcaciones($("#txt-id-empleado").val())
                    //$("#txt-buscar-empleado").val("")
                })
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
/*FIN PARA FUNCION CONSULTAR EMPLEADO POR ID*/

var id_empleado = '';
/*INICIO PARA FUNCION CONSULTAR EMPLEADO POR ID*/
function get_empleado_id(id_empl) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar empleado")
    id_empleado = id_empl
    $.ajax({
        url: '/get-empleado-acuerdo-id/' + id_empleado,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                var ht = ""
                console.log(response.data)
                $(response.data).each(function (i, data) {
                    ht += '  <table id="table-empleado" border="1" class="table table-bor">'
                    ht += '	    <thead class="background-thead pad">'
                    ht += '		    <tr align="center">'
                    ht += '				<th align="center" class="border-bottom-0 color-th pad">Foto</th>'
                    ht += '			    <th align="center" class="border-bottom-0 color-th pad">Cedula</th>'
                    ht += '				<th align="center" class="border-bottom-0 color-th pad">Funcionario</th>'
                    ht += '				<th align="center" class="border-bottom-0 color-th pad">Dirección</th>'
                    ht += '			    <th align="center" class="border-bottom-0 color-th pad">Jefatura</th>'
                    ht += '			    <th align="center" class="border-bottom-0 color-th pad">Cargo</th>'
                    ht += '			</tr>'
                    ht += '		</thead>'
                    ht += '		<tbody>'

                    ht += '			<tr>'
                    ht += '				<td class="color-td" align="center"><img class="tam-ima-emp-ta" src="/imagenes_empleados/' + data.emp_ruta_foto + '"></td>'
                    ht += '			    <td class="color-td" align="center">' + data.emp_cedula + '</td>'
                    ht += '				<td class="color-td" align="center">' + data.emp_nombre + ' ' + data.emp_apellido + '</td>'
                    ht += '				<td class="color-td" align="center">' + data.dep_departamento + '</td>'
                    ht += '				<td class="color-td" align="center">' + data.per_perfil + '</td>'
                    ht += '				<td class="color-td" align="center">' + data.emp_cargo + '</td>'
                    ht += '			</tr>'
                    ht += '		</tbody>'
                    ht += '  </table>'
                    ht += '<div>'

                    ht += '<div class="row row-sm">'
                    ht += '     <div class="col-sm-6">'
                    ht += '        <div class="ac-st">'
                    ht += '            <div class="card-body">'
                    ht += '                 <h5 class="card-title mb-3">Acuerdo de Confidencialidad</h5>'
                    ht += '                 <p class="card-text">Generar y subir el acuerdo de Confidencialidad firmado.</p>'
                    ht += '                 <table id="table-empleado" border="1" class="table table-bor">'
                    ht += '	                    <thead class="background-thead pad">'
                    ht += '		                    <tr align="center">'
                    ht += '				                <th align="center" class="border-bottom-0 color-th pad">Crear</th>'
                    ht += '			                    <th align="center" class="border-bottom-0 color-th pad">Subir o Descargar Archivo</th>'
                    ht += '				                <th align="center" class="border-bottom-0 color-th pad">estado</th>'
                    ht += '				                <th align="center" class="border-bottom-0 color-th pad">opciones</th>'
                    ht += '			                </tr>'
                    ht += '		                </thead>'
                    ht += '		                <tbody>'
                    ht += '			                <tr>'
                    ht += '				                <td class="color-td" align="center"><a href="imprimir-acuerdo-confidencialidad/' + data.emp_id + '" target="_blank"  id="' + data.emp_id + '"><i class="far fa-file-pdf tam-pdf"></i></a></td>'
                    ht += '			                    <td class="color-td" align="center">'
                    if (data.ac_estado_c == 'P') {
                        ht += '                                 <a class="btn-modal-subir-acuerdo-confidencialidad" id="' + data.emp_id + '"><i class="fas fa-cloud-upload-alt tam-subir"></i></a>'
                    } else {
                        ht += '			                        <a href="/descargar-archivo-ar/' + data.ac_ruta_acuerdo_confidencialidad + '"  id="' + data.emp_id + '"><i class="fas fa-cloud-download-alt tam-descargar"></i></a>'
                    }
                    ht += '                             </td>'
                    if (data.ac_estado_c == 'P') {
                        ht += '				                <td class="color-td" align="center">Firma Pendiente</td>'
                        ht += '				                <td class="color-td" align="center">'
                        ht += '                                <button disabled type="button" id="' + data.emp_id + '" class="tam-btn btn btn-danger btn-modal-eliminar-acuerdo-c"><i class="fa fa-trash tam-icono"></i></button>'
                        ht += '                             </td>'
                    } else {
                        ht += '				                <td class="color-td" align="center">Firmado</td>'
                        ht += '				                <td class="color-td" align="center">'
                        ht += '                                <button type="button" id="' + data.emp_id + '" class="tam-btn btn btn-danger btn-modal-eliminar-acuerdo-c"><i class="fa fa-trash tam-icono"></i></button>'
                        ht += '                             </td>'
                    }
                   
                    ht += '			                </tr>'
                    ht += '		                </tbody>'
                    ht += '                 </table>'
                    ht += '            </div>'
                    ht += '        </div>'
                    ht += '    </div>'
                    ht += '     <div class="col-sm-6">'
                    ht += '        <div class="ac-st">'
                    ht += '            <div class="card-body">'
                    ht += '                <h5 class="card-title mb-3">Acuerdo de Responsabilidad</h5>'
                    ht += '                 <p class="card-text">Generar y subir el acuerdo de Responsabilidad firmado.</p>'
                    ht += '                 <table id="table-empleado" border="1" class="table table-bor">'
                    ht += '	                    <thead class="background-thead pad">'
                    ht += '		                    <tr align="center">'
                    ht += '				                <th align="center" class="border-bottom-0 color-th pad">Crear</th>'
                    ht += '			                    <th align="center" class="border-bottom-0 color-th pad">subir o descargar Archivo</th>'
                    ht += '				                <th align="center" class="border-bottom-0 color-th pad">estado</th>'
                    ht += '				                <th align="center" class="border-bottom-0 color-th pad">opciones</th>'
                    ht += '			                </tr>'
                    ht += '		                </thead>'
                    ht += '		                <tbody>'
                    ht += '			                <tr>'
                    ht += '				                <td class="color-td" align="center"><a href="imprimir-acuerdo-responsabilidad/' + data.emp_id + '" target="_blank"  id="' + data.emp_id + '"><i class="far fa-file-pdf tam-pdf"></i></a></td>'
                    ht += '			                    <td class="color-td" align="center">'
                    if (data.ac_estado_r == 'P') {
                        ht += '                                 <a class="btn-modal-subir-acuerdo-responsabilidad"  id="' + data.emp_id + '"><i class="fas fa-cloud-upload-alt tam-subir"></i></a>'
                    } else {
                        ht += '			                        <a href="/descargar-archivo-ar/' + data.ac_ruta_acuerdo_responsabilidad + '" id="' + data.emp_id + '"><i class="fas fa-cloud-download-alt tam-descargar"></i></a>'
                    }
                    ht += '                             </td>'
                    if (data.ac_estado_r == 'P') {
                        ht += '				                <td class="color-td" align="center">Firma Pendiente</td>'
                        ht += '				                <td class="color-td" align="center">'
                        ht += '                                 <button  disabled type="button" id="' + data.emp_id + '" class="tam-btn btn btn-danger btn-modal-eliminar-acuerdo-r"><i class="fa fa-trash tam-icono"></i></button>'
                        ht += '                             </td>'
                    } else {
                        ht += '				                <td class="color-td" align="center">Firmado</td>'
                        ht += '				                <td class="color-td" align="center">'
                        ht += '                                 <button  type="button" id="' + data.emp_id + '" class="tam-btn btn btn-danger btn-modal-eliminar-acuerdo-r"><i class="fa fa-trash tam-icono"></i></button>'
                        ht += '                             </td>'
                    }


                    ht += '			                </tr>'
                    ht += '		                </tbody>'
                    ht += '                 </table>'
                    ht += '             </div>'
                    ht += '         </div>'
                    ht += '     </div>'
                    ht += ' </div>'
                    ht += '</div>'
                    $("#div-table-empleado").html(ht)

                    $("#div-busqueda-empleado").html('')
                    $(".btn-modal-subir-acuerdo-responsabilidad").click(function () {
                        $("#txt-id-empleado").val(this.id)
                        $("#txt-tipo-acuerdo").val("AR")
                        $("#modal-subir-acuerdo-responsabilidad-condifencialidad").modal("show")
                    })
                    $(".btn-modal-subir-acuerdo-confidencialidad").click(function () {
                        $("#txt-id-empleado").val(this.id)
                        $("#txt-tipo-acuerdo").val("AC")
                        $("#modal-subir-acuerdo-responsabilidad-condifencialidad").modal("show")
                    })

                    $(".btn-modal-eliminar-acuerdo-c").click(function () {
                        $("#txt-id-empleado-e").val(this.id)
                        $("#txt-tipo-acuerdo-e").val("AC")
                        $("#modal-acuerdo-e").modal("show")
                    })

                    $(".btn-modal-eliminar-acuerdo-r").click(function () {
                        $("#txt-id-empleado-e").val(this.id)
                        $("#txt-tipo-acuerdo-e").val("AR")
                        $("#modal-acuerdo-e").modal("show")
                    })
                })
            }
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
            $("#div-busqueda-empleado").html('')
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
/*FIN PARA FUNCION CONSULTAR EMPLEADO POR ID*/

$("#btn-guardar-acuerdo-responsabilidad-confidencialidad").click(function () {
    $("#global-loader-modal").addClass("block");
    $("#global-loader-modal").removeClass("none");
    guardar_acuerdo_responsabilidad_confidencialidad()
})


/**INICIO SUBIR ARCHIVO DEL ACUERDO DE RESPONSABILIDAD Y CONFIDENCIALIDAD */
function guardar_acuerdo_responsabilidad_confidencialidad() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-acuerdo-responsabilidad-confidencialidad")[0]);
    $.ajax({
        url: '/file-acuerdo-responsabilidad',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.respuesta == "true") {
                $("#modal-subir-acuerdo-responsabilidad-condifencialidad").modal('hide')
                notif({
                    msg: "<b>Correcto:</b>Archivo Guardado",
                    type: "success"
                });
                get_empleado_id($("#txt-id-empleado").val())
                $("#global-loader-modal").addClass("none");
                $("#global-loader-modal").removeClass("block");
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
/**FIN SUBIR ARCHIVO DEL ACUERDO DE RESPONSABILIDAD Y CONFIDENCIALIDAD*/

/*INICIO ELIMINAR ARCHIVO DEL ACUERDO DE RESPONSABILIDAD Y CONFIDENCIALIDAD*/

$("#btn-eliminar-acuerdo").click(function () {
    $("#global-loader-modal").addClass("block");
    $("#global-loader-modal").removeClass("none");
    eliminar_acuerdo_responsabilidad_confidencialidad()
})

/*FIN ELIMINAR ARCHIVO DEL ACUERDO DE RESPONSABILIDAD Y CONFIDENCIALIDAD*/

/*INICIO FUNCION DE ELIMINAR ACUERDO DE RESPONSABILIDAD Y CONFIDENCIALIDAD*/
function eliminar_acuerdo_responsabilidad_confidencialidad() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-acuerdo-e")[0]);
    $.ajax({
        url: '/eliminar-acuerdo-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                $("#modal-acuerdo-e").modal('hide')
                notif({
                    msg: "<b>Correcto:</b> Acuerdo Eliminado",
                    type: "success"
                });
                $("#btn-eliminar-acuerdo").html("<i class='fa fa-delete'></i> Eliminar")
                get_empleado_id(id_empleado)
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
/*FIN FUNCION DE ELIMINAR ACUERDO DE RESPONSABILIDAD Y CONFIDENCIALIDAD*/
