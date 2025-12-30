$(document).ready(function () {
    $('.dropify').dropify();
})

$("#txt-buscar").on("keyup", function () {
    var txt_buscar = $("#txt-buscar").val();
    if (txt_buscar.length > 5) {
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

var id_empleado = ''
/*INICIO PARA FUNCION CONSULTAR EMPLEADO POR ID*/
function get_empleado_id(id) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar empleado")
    id_empleado = id
    $.ajax({
        url: '/get-empleado-id/' + id_empleado,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                var ht = ""
                console.log(response.data)
                $(response.data).each(function (i, data) {
                    ht += '<div class="text-wrap">'
                    ht += '     <div class="example">'
                    ht += '         <h5 class="card-title mb-3">Información Personal</h5>'
                    ht += '         <div class="panel panel-primary tabs-style-2 row">'
                    ht += '         <div class="col-md-9">'
                    ht += '             <table class="table table-bordered">'
                    ht += '                 <tr>'
                    ht += '                     <td width="15%"><strong>Nombres:</strong></td>'
                    ht += '                     <td width="35%">' + data.emp_nombre + ' ' + data.emp_apellido + '</td>'
                    ht += '                     <td width="15%"><strong> Cédula:</strong></td>'
                    ht += '                     <td width="35%">' + data.emp_cedula + '</td>'
                    ht += '                 </tr>'

                    ht += '                 <tr>'
                    ht += '                     <td width="15%"><strong> Dirección:</strong></td>'
                    ht += '                     <td width="35%">' + data.dep_departamento + '</td>'
                    ht += '                     <td width="15%"><strong>Jefatura:</strong></td>'
                    ht += '                     <td width="35%">' + data.per_perfil + '</td>'
                    ht += '                  </tr>'

                    ht += '                  <tr>'
                    ht += '                      <td width="15%"><strong> Cargo:</strong></td>'
                    ht += '                      <td width="35%">' + data.emp_cargo + '</td>'
                    ht += '                      <td width="15%"><strong>Telefono:</strong></td>'
                    ht += '                      <td width="35%">' + data.emp_telefono + '</td>'
                    ht += '                   </tr>'
                    ht += '             </table>'
                    ht += '         </div>'

                    ht += '         <div class="col-md-3">'

                    ht += '             <table class="table table-bordered">'
                    ht += '                 <tr class="background-thead pad">'
                    ht += '                     <td colspan="2" class="border-bottom-0 color-th pad sorting" align="center" width="100%"><strong>NUMERO DE INVENTARIO</strong></td>'
                    ht += '                 </tr>'

                    ht += '                 <tr>'
                    ht += '                     <td colspan="2" align="center" width="100%"><strong>MOV-INV-001</strong></td>'
                    ht += '                 </tr>'

                    ht += '                 <tr>'
                    ht += '                     <td width="15%"><strong>Fecha:</strong></td>'
                    ht += '                     <td width="15%"><strong>25-25-2012</strong></td>'
                    ht += '                  </tr>'

                    ht += '             </table>'
                    ht += '         </div>'
                    ht += '         </div>'

                    ht += '         </div>'

                    ht += '     </div>'
                    ht += '</div>'

                    ht += '<div class="text-wrap mg-t-10">'
                    ht += '		<div class="example">'
                    ht += '			<div class="row row-xs wd-xl-80p btn-list btn-animation">'
                    ht += '             <a class="ms-2 mb-1 btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-catalogo">'
                    ht += '                 <i class="fa fa-plus-square color-btn-nuevo"></i>'
                    ht += '                 <strong class="color-btn-nuevo">Añadir</strong>'
                    ht += '             </a>'
                    ht += '			</div>'
                    ht += '		</div>'
                    ht += '	</div>'

                    ht += '<div class="text-wrap mg-t-10">'
                    ht += '     <div class="example">'
                    ht += '         <div class="panel panel-primary tabs-style-2">'
                    ht += '             <h5 class="card-title mb-3">Equipos y Suministros de computación</h5>'
                    ht += '             <table id="table-catalogo" border="1" class="table table-bor top">'
                    ht += '	                <thead class="background-thead pad">'
                    ht += '                     <tr align="center">'
                    ht += '                         <th align="center" class="border-bottom-0 color-th pad">Codigo</th>'
                    ht += '                         <th align="center" class="border-bottom-0 color-th pad">Marca</th>'
                    ht += '                         <th align="center" class="border-bottom-0 color-th pad">Modelo</th>'
                    ht += '                         <th align="center" class="border-bottom-0 color-th pad">Descripcion</th>'
                    ht += '                         <th align="center" class="border-bottom-0 color-th pad">Fecha de Entrega</th>'
                    ht += '                         <th align="center" class="border-bottom-0 color-th pad">oPCIONES</th>'
                    ht += '                     </tr>'
                    ht += '		             </thead>'
                    ht += '		             <tbody>'
                    $(response.data_2).each(function (i, data) {
                        ht += '                 <tr>'
                        ht += '                     <td class="color-td" align="center">' + data.cat_codigo + '</td>'
                        ht += '                     <td class="color-td" align="center">' + data.cat_marca + '</td>'
                        ht += '                     <td class="color-td" align="center">' + data.cat_modelo + '</td>'
                        ht += '                     <td class="color-td" align="center">' + data.cat_descripcion + '</td>'
                        ht += '                     <td class="color-td" align="center">' + data.inv_fecha_entrega + '</td>'
                        ht += '				        <td class="color-td" align="center">'
                        ht += '                         <button type="button" id="' + data.inv_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                        ht += '                     </td>'
                        ht += '                 </tr>'
                    })
                    ht += '		            </tbody>'
                    ht += '             </table>'
                    ht += '         </div>'
                    ht += '     </div>'
                    ht += '</div>'
                })
                $("#div-table-empleado").html(ht)
                //$("#div-table-empleado-catalogo").html(ht)
                $("#table-catalogo").DataTable()

                ht = ''


                $("#div-busqueda-empleado").html('')

                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-catalogo-inventario-e").val(this.id)
                    $("#modal-catalogo-inventario-e").modal("show")
                })

                $("#btn-añadir-catalogo").click(function () {
                    get_catalogo()
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

/*INICIO DE FUNCION PARA LISTAR CATALOGOS */
function get_catalogo() {
    $("#div-table-catalogo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Cargando..</span>")
    console.log("listar catalogos")
    $("#global-loader").removeClass("none");
    $("#global-loader").addClass("block");
    $.ajax({
        url: '/get-catalogo',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            var ht = ""
            ht += '  <table id="table-catalogo-list" border="2" class="table tam-tabl dataTable no-footer">'
            ht += '	    <thead class="background-thead">'
            ht += '		    <tr align="center">'
            ht += '				<th align="center" class="border-bottom-0 color-th">Codigo</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Categoria</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Marca</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Modelo</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Descripcion</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">estado custodio</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Observacion</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
            ht += '			</tr>'
            ht += '		</thead>'
            ht += '		<tbody>'
            $(response.data).each(function (i, data) {
                ht += '			<tr>'
                ht += '			    <td align="center" class="color-td">' + data.cat_codigo + '</td>'
                if (data.cat_categoria == 1) {
                    ht += '			    <td align="center" class="color-td">LAPTOP</td>'
                } else if (data.cat_categoria == 2) {
                    ht += '			    <td align="center" class="color-td">IMPRESORA</td>'
                } else if (data.cat_categoria == 3) {
                    ht += '			    <td align="center" class="color-td">MOUSE</td>'
                } else if (data.cat_categoria == 4) {
                    ht += '			    <td align="center" class="color-td">ROUTER</td>'
                } else if (data.cat_categoria == 5) {
                    ht += '			    <td align="center" class="color-td">TECLADO</td>'
                } else if (data.cat_categoria == 6) {
                    ht += '			    <td align="center" class="color-td">MONITOR</td>'
                } else if (data.cat_categoria == 7) {
                    ht += '			    <td align="center" class="color-td">CONVERTIDOR</td>'
                } else if (data.cat_categoria == 8) {
                    ht += '			    <td align="center" class="color-td">UPS</td>'
                } else if (data.cat_categoria == 9) {
                    ht += '			    <td align="center" class="color-td">REGULADOR</td>'
                } else if (data.cat_categoria == 10) {
                    ht += '			    <td align="center" class="color-td">TV</td>'
                } else if (data.cat_categoria == 11) {
                    ht += '			    <td align="center" class="color-td">SWICH O COMMUTADOR</td>'
                } else if (data.cat_categoria == 12) {
                    ht += '			    <td align="center" class="color-td">SERVIDOR</td>'
                } else if (data.cat_categoria == 13) {
                    ht += '			    <td align="center" class="color-td">ACCES POINTS</td>'
                } else if (data.cat_categoria == 14) {
                    ht += '			    <td align="center" class="color-td">DISCO DURO</td>'
                } else if (data.cat_categoria == 15) {
                    ht += '			    <td align="center" class="color-td">MEMORIA RAM</td>'
                } else if (data.cat_categoria == 16) {
                    ht += '			    <td align="center" class="color-td">FUENTE</td>'
                } else if (data.cat_categoria == 17) {
                    ht += '			    <td align="center" class="color-td">CPU</td>'
                } else if (data.cat_categoria == 18) {
                    ht += '			    <td align="center" class="color-td">PARLANTES</td>'
                } else if (data.cat_categoria == 19) {
                    ht += '			    <td align="center" class="color-td">SCANNER</td>'
                } else if (data.cat_categoria == 20) {
                    ht += '			    <td align="center" class="color-td">SERVIDOR</td>'
                } else if (data.cat_categoria == 21) {
                    ht += '			    <td align="center" class="color-td">LECTOR DE HUELLA</td>'
                } else if (data.cat_categoria == 22) {
                    ht += '			    <td align="center" class="color-td">BIOMETRICO</td>'
                } else if (data.cat_categoria == 23) {
                    ht += '			    <td align="center" class="color-td">TELEFONO IP</td>'
                } else if (data.cat_categoria == 24) {
                    ht += '			    <td align="center" class="color-td">TODO EN UNO</td>'
                }
                ht += '			    <td align="center" class="color-td">' + data.cat_marca + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.cat_modelo + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.cat_descripcion + '</td>'
                if (data.cat_estado_custodio == 'NA') {
                    ht += '				<td class="color-td" align="center"><span class="badge bg-danger me-1">No Asignado</span></td>'
                } else if (data.cat_estado_custodio == 'A') {
                    ht += '				<td class="color-td" align="center"><span class="badge bg-success me-1">Asignado</span></td>'
                }
                ht += '			    <td align="center" class="color-td">' + data.cat_observacion + '</td>'
                ht += '				<td align="center" class="color-td">'
                /*ht += '				    <a id=' + data.cat_id + ' class=" color-add-li btn-guardar-inventarioo">'
                ht += '	                    <i class="fa fa-plus-square font-size-li color-add-li"></i>'
                ht += '	                    <strong class="font-size-li"></strong>'
                ht += '	                </a>'*/
                ht += '	                <a class=" btn background-btn-nuevo pad-nu float-btn-nuevo btn-guardar-inventario" style="padding: 5px 10px !important;" id=' + data.cat_id + '><i class="fa fa-plus-square color-btn-nuevo"></i><strong class="color-btn-nuevo"> Añadir</strong></a>'
                ht += '				</td>'
                ht += '			</tr>'
            })
            ht += '		</tbody>'
            ht += '  </table>'
            $("#div-table-catalogo").html(ht)

            $("#modal-catalogo").modal("show")

            /* INICIO CLICK PARA ABRIR EL MODAL DE GUARDAR CATALGO AL INVENTARIO */
            $(".btn-guardar-inventario").click(function () {
                var id = this.id
                $("#txt-id-catalogo").val(id)
                $("#txt-id-empleado").val(id_empleado)
                $("#" + id).html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'></span>")
                guardar_catalogo_inventario(id)
            })
            /* FIN CLICK PARA ABRIR EL MODAL DE GUARDAR CATALGO AL INVENTARIO */

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
            $("#table-catalogo-list").DataTable()
        }
    })
}
/*FIN DE FUNCION PARA FUNCION PARA LISTAR CATALOGOS*/


/*INICIO FUNCION PARA GUARDAR CATALOGO DE INVENTARIO */
function guardar_catalogo_inventario(id) {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-catalogo-inventario")[0]);
    $.ajax({
        url: '/registrar-catalogo-inventario',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {

            console.log(response)
            if (response.respuesta == 'true') {
                if (response.data == 'A') {
                    $('#modal-mensaje-asignacion').modal('show')
                    $("#" + id).html("<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir</strong>")
                } else {
                    //$('#modal-mensaje-custodio').modal('show')
                    get_catalogo()
                    $('#modal-mensaje-custodio').modal('show')
                    $("#" + id).html("<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir</strong>")

                    //$("#select-direccion").val("0")
                    //$("#select-jefatura-subdireccion").val("0")
                    //$("#select-indicador").val("0")
                    //$("#btn-guardar-catalogo-inventario").html("<i class='fa fa-save'></i> Guardar")
                    get_empleado_id(id_empleado)
                    //location.href = "/nomina";
                }
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar catalogo inventario",
                    position: "right",
                    autohide: false
                });
                $("#" + id).html("<i class='fa fa-plus-square color-btn-nuevo'></i><strong class='color-btn-nuevo'> Añadir</strong>")
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
/*FIN FUNCION PARA GUARDAR CATALOGO DE INVENTARIO */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE CATALOGO */
$("#btn-eliminar-catalogo-inventario").click(function () {
    $("#btn-eliminar-catalogo-inventario").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Eliminando..</span>")
    eliminar_catalogos_inventario_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE catalogo*/

/*INICIO FUNCION DE ELIMINAR DE catalogo*/
function eliminar_catalogos_inventario_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-catalogo-inventario-e")[0]);
    $.ajax({
        url: '/eliminar-catalogo-inventario-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                $("#modal-catalogo-inventario-e").modal('hide')
                notif({
                    msg: "<b>Correcto:</b> catalogo eliminada",
                    type: "success"
                });
                $("#btn-eliminar-catalogo-inventario").html("<i class='fa fa-delete'></i> Eliminar")
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
/*FIN FUNCION DE ELIMINAR DE catalogo*/

/**INICIO CLICK PARA CERAR EL MENSAJE DE ASIGNACION DE CUSTODIO YA AGREGADO */
$('#btn-cerrar').click(function () {
    $('#modal-mensaje-asignacion').modal('hide')
})
/**INICIO CLICK PARA CERAR EL MENSAJE DE ASIGNACION DE CUSTODIO YA AGREGADO */

/**INICIO CLICK PARA CERAR EL MENSAJE DE ASIGNACION DE CUSTODIO AGREGADO*/
$('#btn-cerrar-g').click(function () {
    $('#modal-mensaje-custodio').modal('hide')
})
/**INICIO CLICK PARA CERAR EL MENSAJE DE ASIGNACION DE CUSTODIO AGREGADO*/

