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


/*INICIO PARA FUNCION CONSULTAR EMPLEADO POR ID*/
function get_empleado_id(id_empl) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    id_empleado = id_empl
    $.ajax({
        url: '/get-paz-salvo-empleado/' + id_empleado,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                var ht = ""
                console.log(response.data)
                $(response.data).each(function (i, data) {
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
                    ht += '                     <tr>'
                    ht += '                         <td width="10%"><strong> Fecha de Ingreso:</strong></td>'
                    ht += '                         <td width="20%">' + data.emp_fecha_ingreso + '</td>'
                    ht += '                         <td width="10%" class="align-midle" rowspan="2"><strong>Firma del'
                    ht += '                         servidor:</strong></td>'
                    ht += '                         <td width="10%" rowspan="2"><strong></strong></td>'
                    ht += '                     </tr>'
                    ht += '                     <tr>'
                    ht += '                         <td width="10%"><strong> Fecha de salida:</strong></td>'
                    ht += '                         <td width="20%">' + data.emp_fecha_salida + '</td>'
                    ht += '                     </tr>'
                    ht += '                 </table>'
                    ht += '             </div>'
                    ht += '         </div>'
                    ht += '     </div>'
                    ht += '     <div class="text-wrap ta">'
                    ht += '         <div class="example">'
                    ht += '             <div class="panel panel-primary tabs-style-2">'
                    ht += '                 <div class=" tab-menu-heading">'
                    ht += '                     <div class="tabs-menu1">'
                    ht += '                     <!-- Tabs -->'
                    ht += '                         <ul class="nav panel-tabs main-nav-line">'
                    ht += '                             <li><a href="#jefe_inmediato" id="btn-jefe-inmediato" class="nav-link active" data-bs-toggle="tab">Jefe Inmediato</a>'
                    ht += '                             </li>'
                    ht += '                             <li><a href="#tthh" class="nav-link" data-bs-toggle="tab">Talento Humano</a></li>'
                    ht += '                             <li><a href="#contabilidad" class="nav-link" data-bs-toggle="tab">Contabilidad</a></li>'
                    ht += '                             <li><a href="#almacen_bodega" class="nav-link" data-bs-toggle="tab">Almacen y Bodega</a></li>'
                    ht += '                             <li><a href="#tecnologia" class="nav-link" data-bs-toggle="tab">Recursos Técnologicos</a></li>'
                    ht += '                         </ul>'
                    ht += '                     </div>'
                    ht += '                 </div>'
                    ht += '                 <div class="tab-content">'
                    ht += '                     <div class="tab-pane active jefe-inmediato" id="jefe_inmediato">'
                    ht += '                     </div>'

                    ht += '                     <div class="tab-pane" id="tthh">'
                    ht += '                     </div>'

                    ht += '                     <div class="tab-pane" id="contabilidad">'

                    ht += '                     </div>'

                    ht += '                     <div class="tab-pane" id="almacen_bodega">'
                    ht += '                     </div>'
                    ''
                    ht += '                     <div class="tab-pane" id="tecnologia">'
                    ht += '                     </div>'

                    ht += '                 </div>'
                    ht += '             </div>'
                    ht += '         </div>'
                    ht += '     </div>'
                    ht += '</div>'
                    $("#div-empleado").html(ht)


                    $("#div-busqueda-empleado").html('')
                    $("#btn-jefe-inmediato").click(function () {
                        get_jefe_inmediato_empleado_id()
                    })

                    $("#btn-jefe-inmediato").click()

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

/*INICIO PARA FUNCION CONSULTAR EMPLEADO JEFE INMEDIATO POR ID*/
function get_jefe_inmediato_empleado_id() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: '/get-paz-salvo-empleado-jefe-inmediato/' + id_empleado,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                var ht = ""
                console.log(response.data)
                //$(response.data).each(function (i, data) {
                ht += '<div class="col-md-12">'
                ht += '    <form class="form" novalidate id="form-jefe-inmediato" method="POST"'
                ht += '        enctype="multipart/form-data">'
                ht += '        <input type="hidden" name="txt-id-empleado-jefe-inmediato" id="txt-id-empleado-jefe-inmediato">'
                ht += '        <input type="hidden" name="txt-id-empleado-ji" id="txt-id-empleado-ji">'
                ht += '        <div class="text-wrap card-body">'
                ht += '            <div class="example">'
                ht += '                <div class="panel panel-primary tabs-style-2">'
                ht += '                    <h5 class="card-title mb-3" align="center">JEFE INMEDIATO</h5>'
                ht += '                    <table class="table table-bordered">'
                ht += '                        <tr>'
                ht += '                            <td width="15%"><strong>Entrego los archivos fisicos:</strong></td>'
                ht += '                            <td width="15%" colspan="2">'
                ht += '                                <select name="select-entrega-archivo-fisico" id="select-entrega-archivo-fisico" class="form-control">'
                ht += '                                    <option value="0">SELECCIONE </option>'
                ht += '                                    <option value="1">SI </option>'
                ht += '                                    <option value="2">NO </option>'
                ht += '                                </select>'
                ht += '                            </td>'
                ht += '                            <td width="10%" class="align-midle"><strong>Nombres:</strong></td>'
                ht += '                            <td width="50%" class="align-midle">JULIAN ANDRES CEDEPA CARDIALOGO HUMILDE</td>'
                ht += '                        </tr>'
                ht += '                        <tr>'
                ht += '                            <td width="15%" class="align-midle"><strong>Fecha de entrega:</strong></td>'
                ht += '                            <td width="25%" colspan="2">'
                ht += '                                <input class="form-control" name="txt-fecha-entrega" id="txt-fecha-entrega" placeholder="Ingresar fecha de compra" type="date"></input>'
                ht += '                            </td>'
                ht += '                            <td width="10%" class="align-midle"><strong>Cargo:</strong></td>'
                ht += '                            <td width="50%" class="align-midle">ANALISTA DE TECNOLOGIA 3</td>'
                ht += '                        </tr>'
                ht += '                        <tr>'
                ht += '                            <td width="15%" class="align-midle"><strong>Entrego informe Final:</strong></td>'
                ht += '                            <td width="20%">'
                ht += '                                <select name="select-informe-final" id="select-informe-final" class="form-control">'
                ht += '                                    <option value="0">SELECCIONE</option>'
                ht += '                                    <option value="1">SI</option>'
                ht += '                                    <option value="2">NO</option>'
                ht += '                                </select>'
                ht += '                             </td>'
                ht += '                            <td width="5%">'
                ht += '                                 <input type="file" name="txt-ruta-informe-final" id="txt-ruta-informe-final" />'
                ht += '                            </td>'
                ht += '                            <td width="10%" class="align-midle"><strong>Firma:</strong></td>'
                ht += '                            <td width="50%"></td>'
                ht += '                        </tr>'
                ht += '                        <tr>'
                ht += '                            <td width="15%" class="align-midle"><strong>Observacion:</strong></td>'
                ht += '                            <td width="85%" colspan="4">'
                ht += '                                <input class="form-control" name="txt-observacion-ji" id="txt-observacion-ji" placeholder="Ingresar observacion" type="text" onkeypress="mayus(this);"></input>'
                ht += '                            </td>'
                ht += '                        </tr>'
                ht += '                    </table>'
                ht += '                </div>'
                ht += '            </div>'
                ht += '        </div>'

                ht += '        <div class="col-md-12 mg-t-10" align="right">'
                ht += '            <button class="btn btn-primary btn btn-success-gradient btn-movi" id="btn-guardar-jefe-inmediato" type="button"><i class="fa fa-save"></i>Guardar</button>'
                ht += '        </div>'
                ht += '    </form>'
                ht += '</div>'
                $(".jefe-inmediato").html(ht)
                $('#txt-id-empleado-ji').val(id_empleado)
                $(response.data).each(function (i, data) {
                    $('#txt-observacion-ji').val(data.ji_observacion)
                    $('#txt-id-empleado-jefe-inmediato').val(data.ji_id_empleado)
                    $('#select-entrega-archivo-fisico').val(data.ji_archivo_fisico)
                    $('#txt-fecha-entrega').val(data.ji_fecha_entrega)
                    $('#select-informe-final').val(data.ji_informe_final)
                    //$('#txt-ruta-informe-final').val(data.ji_nombre_informe_final)
                })

                $('#btn-guardar-jefe-inmediato').click(function () {
                    guardar_jefe_inmediato()
                })

                $("#div-busqueda-empleado").html('')
                //})
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
/*FIN PARA FUNCION CONSULTAR EMPLEADO JEFE INMEDIATO POR ID*/



/*INICIO FUNCION PARA GUARDAR EMPLEADO JEFE INMEDIATO */
function guardar_jefe_inmediato() {

    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-jefe-inmediato")[0]);
    $.ajax({
        url: '/registrar-jefe-inmediato',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Datos registrado",
                    type: "success"
                });

                $("#btn-guardar-jefe-inmediato").html("<i class='fa fa-save'></i> Guardar")
                get_jefe_inmediato_empleado_id()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar jefe-inmediato",
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
/*FIN FUNCION PARA GUARDAR EMPLEADO JEFE INMEDIATO */