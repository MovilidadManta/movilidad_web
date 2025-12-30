$(document).ready(function () {

})

function mayus(e) {
    e.value = e.value.toUpperCase();
}

$("#txt-buscar").on("keyup", function () {
    var txt_buscar = $("#txt-buscar").val();
    if (txt_buscar.length >= 5 && txt_buscar.length <= 20) {
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

var id = ''
var id_empleado = '';

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
                    id = this.id
                    id_empleado = this.id
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

var id_empleado = {}
/*INICIO PARA FUNCION CONSULTAR EMPLEADO POR ID*/
function get_empleado_id(id_empl) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    id_empleado = id_empl
    $.ajax({
        url: '/get-empleado-qr/' + id_empleado,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                var ht = ""
                console.log(response.data)
                $(response.data).each(function (i, data) {
                    ht += '<div class="text-wrap mg-t-10">'
                    ht += '		<div class="example">'
                    ht += '			<div class="row row-xs wd-xl-80p btn-list btn-animation">'
                    ht += '             <a class="ms-2 mb-1 btn background-btn-nuevo pad-nu float-btn-nuevo btn-generar-qr" id="' + data.id_empleado_hash + '-' + data.emp_id + '-' + data.emp_cedula + '">'
                    ht += '                 <i class="fa fa-qrcode color-btn-nuevo"></i>'
                    ht += '                 <strong class="color-btn-nuevo">Generar QR</strong>'
                    ht += '             </a>'
                    ht += '			</div>'
                    ht += '		</div>'
                    ht += '	</div>'

                    ht += '<div class="text-wrap">'
                    ht += '     <div class="example">'
                    ht += '         <div class="panel panel-primary tabs-style-2">'
                    ht += '             <h5 class="card-title mb-3">Información Personal</h5>'
                    ht += '                 <table class="table table-bordered">'
                    ht += '                     <tr>'
                    ht += '                         <td width="15%"><strong>Nombres y Apellidos:</strong></td>'
                    ht += '                         <td width="35%">' + data.emp_nombre + ' ' + data.emp_apellido + '</td>'
                    ht += '                         <td width="15%"><strong> Cédula:</strong></td>'
                    ht += '                         <td width="35%">' + data.emp_cedula + '</td>'
                    ht += '                     </tr>'

                    ht += '                     <tr>'
                    ht += '                         <td width="15%"><strong> Dirección:</strong></td>'
                    ht += '                         <td width="35%">' + data.dep_departamento + '</td>'
                    ht += '                         <td width="15%"><strong>Jefatura:</strong></td>'
                    ht += '                         <td width="35%">' + data.per_perfil + '</td>'
                    ht += '                     </tr>'

                    ht += '                     <tr>'
                    ht += '                         <td width="15%"><strong> Cargo:</strong></td>'
                    ht += '                         <td width="35%">' + data.emp_cargo + '</td>'
                    ht += '                         <td width="15%"><strong>Telefono:</strong></td>'
                    ht += '                         <td width="35%">' + data.emp_telefono + '</td>'
                    ht += '                     </tr>'
                    ht += '                 </table>'
                    ht += '             </div>'
                    ht += '         </div>'
                    ht += '     </div>'

                    ht += '     <div class="text-wrap ta">'
                    ht += '         <div class="example">'
                    ht += '             <div class="panel panel-primary tabs-style-2">'
                    ht += '                 <table class="table table-bordered">'
                    ht += '                     <tr>'
                    ht += '                         <td class="color-td" align="center" width="15%"><strong> Foto:</strong></td>'
                    ht += '                         <td class="color-td" align="center" width="15%"><img class="tam-ima-emp-ta" src="/imagenes_empleados/' + data.emp_ruta_foto + '"></td>'
                    ht += '                         <td class="color-td" width="20%"><button class="btn btn-success-gradient btn-movi btn-descargar-foto" id="' + data.emp_ruta_foto + '" type="button"><i class="fa fa-save"></i> Descargar Foto</button></td>'
                    ht += '                         <td class="color-td" align="center" width="15%"><strong>QR</strong></td>'
                    if (data.cre_estado == 'I') {
                        ht += '                         <td class="color-td" align="center" width="15%">No se ha generado QR</td>'
                    } else if (data.cre_estado == 'A') {
                        ht += '                         <td class="color-td" align="center" width="20%"><img class="" src="/Imagenes/QR/' + data.cre_nombre_qr + '"></td>'
                    }
                    if (data.cre_estado == 'A') {
                        ht += '                         <td class="color-td" width="15%"><button class="btn btn-success-gradient btn-movi btn-descargar-qr" id="' + data.cre_nombre_qr + '" type="button"><i class="fa fa-save"></i> Descargar QR</button></td>'
                    }else{
                        ht += '                         <td class="color-td" width="15%"></td>'
                    }
                    ht += '                     </tr>'
                    ht += '                 </table>'
                    ht += '                 </div>'
                    ht += '             </div>'
                    ht += '         </div>'
                    ht += '     </div>'
                    ht += '</div>'
                    $("#div-empleado").html(ht)
                    $("#div-busqueda-empleado").html('')
                    $(".btn-generar-qr").click(function () {
                        id_ = this.id
                        id = id_.split("-");
                        generar_qr_empleado(id[0], id[1], id[2])
                    })

                    /**INICIO CLICK PARA LLAMAR A A FUNCION PARA DESCARGAR LA FOTO */
                    $(".btn-descargar-foto").click(function () {
                        location.href = "/descargar-foto-empleado/" + this.id
                    })
                    /**FIN CLICK PARA LLAMAR A A FUNCION PARA DESCARGAR LA FOTO */

                    /**INICIO CLICK PARA LLAMAR A A FUNCION PARA DESCARGAR QR DEL EMPLEQADO */
                    $(".btn-descargar-qr").click(function () {
                        location.href = "/descargar-qr-empleado/" + this.id
                    })
                    /**FIN CLICK PARA LLAMAR A A FUNCION PARA DESCARGAR QR DEL EMPLEQADO */
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

/*INICIO FUNCION PARA GENERAR QR */
function generar_qr_empleado(id_encripado, id, cedula) {
    var token = $("#csrf-token").val();
    $.ajax({
        url: '/generar-qr',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        data: {
            id_encrip: id_encripado,
            id: id,
            cedula: cedula
        },
        success: function (response) {
            console.log(response)
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b>QR generado correctamente",
                    type: "success"
                });
            }
            get_empleado_id(id_empleado)
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
/*FIN FUNCION PARA PARA GENERAR QR */



/*INICIO FUNCION PARA DESCARGAR FOTO*/
function decargar_foto_empleado_id(ruta) {
    $.ajax({
        url: '/descargar-foto-empleado/' + ruta,
        type: "GET",
        dataType: "json",
        success: function (response) {
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
/*FIN FUNCION PARA DESCARGAR FOTO*/

