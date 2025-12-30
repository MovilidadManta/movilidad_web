$(document).ready(function () {
    $('.dropify').dropify();
    get_catalogo()
})

function mayus(e) {
    e.value = e.value.toUpperCase();
}

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
            ht += '  <table id="table-catalogo-c" border="2" class="table tam-tabl dataTable no-footer">'
            ht += '	    <thead class="background-thead">'
            ht += '		    <tr align="center">'
            ht += '				<th align="center" class="border-bottom-0 color-th">Codigo</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Categoria</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Marca</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Modelo</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Descripcion</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Observacion</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
            ht += '			</tr>'
            ht += '		</thead>'
            ht += '		<tbody>'
            $(response.data).each(function (i, data) {
                ht += '			<tr>'
                ht += '			    <td align="center" class="color-td">' + data.cat_codigo + '</td>'
                if (data.cat_categoria == 0) {
                    ht += '			    <td align="center" class="color-td">SC</td>'
                } else if (data.cat_categoria == 1) {
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
                }else if (data.cat_categoria == 21) {
                    ht += '			    <td align="center" class="color-td">LECTOR DE HUELLA</td>'
                }else if (data.cat_categoria == 22) {
                    ht += '			    <td align="center" class="color-td">BIOMETRICO</td>'
                }else if (data.cat_categoria == 23) {
                    ht += '			    <td align="center" class="color-td">TELEFONO IP</td>'
                } else if (data.cat_categoria == 24) {
                    ht += '			    <td align="center" class="color-td">TODO EN UNO</td>'
                }
                ht += '			    <td align="center" class="color-td">' + data.cat_marca + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.cat_modelo + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.cat_descripcion + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.cat_observacion + '</td>'
                ht += '				<td class="color-td" align="center">'
                ht += '              <button type="button" id="' + data.cat_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                ht += '              <button type="button" id="' + data.cat_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                ht += '             </td>'
                ht += '			</tr>'
            })
            ht += '		</tbody>'
            ht += '  </table>'
            $("#div-table-catalogo").html(ht)

            /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR CATALOGOS */
            $(".btn-modal-eliminar").click(function () {
                var id = this.id
                $("#txt-id-catalogo").val(id)
                $("#modal-catalogo-e").modal("show")
            })
            /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR CATALOGOS*/

            /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR CATALOGOS*/
            $(".btn-modal-editar").click(function () {
                $("#txt-id-catalogo-m").val(this.id)
                get_catalogo_id(this.id)
            })
            /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  CATALOGOS*/

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
            $("#table-catalogo-c").DataTable()
        }

    })

}
/*FIN DE FUNCION PARA FUNCION PARA LISTAR CATALOGOS*/

/*INICIO CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE CATALOGOS */
$("#btn-añadir-catalogo").click(function () {
    $("#modal-catalogo").modal("show")
})
/*FIN CLICK AL BOTON AÑADIR PARA ABRIR EL MODAL DE CATALOGOS */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE CATALOGOS */
$('#btn-guardar-catalogo').click(function () {
    $("#btn-guardar-catalogo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
    guardar_catalogo()
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE CATALOGOS */

/*INICIO FUNCION PARA GUARDAR CATALOGO */
function guardar_catalogo() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-catalogo")[0]);
    $.ajax({
        url: '/registrar-catalogo',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)

            $("#modal-catalogo").modal('hide')
            if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Catalogo registrado",
                    type: "success"
                });
                $('#txt-codigo-m').val("")
                $('#select-categoria-m').val("")
                $('#txt-marca-m').val("")
                $('#txt-modelo-m').val("")
                $('#txt-descripcion-m').val("")
                $('#txt-serie-m').val("")
                $('#txt-mac-ethernet-m').val("")
                $('#txt-mac-wifi-m').val("")
                $('#txt-ip-m').val("")
                $('#txt-anydesk-m').val("")
                $('#select-area-m').val("")
                $('#txt-ubicacion-m').val("")
                $('#txt-fecha-compra-m').val("")
                $('#txt-periodo-garantia-m').val("")
                $('#txt-proveedor-m').val("")
                $('#select-estado-m').val("")
                $('#txt-ram-m').val("")
                $('#txt-sistema-operativo-m').val("")
                $('#select-tipo-sistema-operativo-m').val("")
                $('#txt-usuario-sistema-m').val("")
                $('#txt-observacion-m').val("")
                $('#txt-disco-duro-m').val("")
                $('#txt-programa-m').val("")
                $("#btn-guardar-catalogo").html("<i class='fa fa-save'></i> Guardar")
                get_catalogo()
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar catalogo",
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
/*FIN FUNCION PARA GUARDAR CATALOGO */

/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE CATALOGO */
$("#btn-eliminar-catalogo").click(function () {
    $("#btn-eliminar-catalogo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Eliminando..</span>")
    eliminar_catalogos_id()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA ELIMINAR DE catalogo*/

/*INICIO FUNCION DE ELIMINAR DE catalogo*/
function eliminar_catalogos_id() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-catalogo-e")[0]);
    $.ajax({
        url: '/eliminar-catalogo-id',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            if (response.data == "eliminado") {
                notif({
                    msg: "<b>Correcto:</b> catalogo eliminada",
                    type: "success"
                });
                $("#btn-eliminar-catalogo").html("<i class='fa fa-delete'></i> Eliminar")
                $("#modal-catalogo-e").modal('hide')
                get_catalogo()
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

/*INICIO DE FUNCION PARA LISTAR CATALOGOS */
function get_catalogo_id() {
    $("#global-loader").removeClass("none");
    $("#global-loader").addClass("block");
    var id = $("#txt-id-catalogo-m").val()
    $.ajax({
        url: '/get-catalogo-id/' + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            $(response.data).each(function (i, data) {
                $('#txt-codigo-m').val(data.cat_codigo)
                $('#select-categoria-m').val(data.cat_categoria)
                $('#txt-marca-m').val(data.cat_marca)
                $('#txt-modelo-m').val(data.cat_modelo)
                $('#txt-descripcion-m').val(data.cat_descripcion)
                $('#txt-serie-m').val(data.cat_numero_serie)
                $('#txt-mac-ethernet-m').val(data.cat_mac_ethernet)
                $('#txt-mac-wifi-m').val(data.cat_mac_wifi)
                $('#txt-ip-m').val(data.cat_ip)
                $('#txt-anydesk-m').val(data.cat_id_anydesk)
                $('#select-area-m').val(data.cat_id_area)
                $('#txt-ubicacion-m').val(data.cat_ubicacion)
                $('#txt-fecha-compra-m').val(data.cat_fecha_compra)
                $('#txt-periodo-garantia-m').val(data.cat_periodo_garantia)
                $('#txt-proveedor-m').val(data.cat_proveedor)
                $('#select-estado-m').val(data.cat_id_estado)
                $('#txt-ram-m').val(data.cat_ram)
                $('#txt-sistema-operativo-m').val(data.cat_so)
                $('#select-tipo-sistema-operativo-m').val(data.cat_tipo_so)
                $('#txt-usuario-sistema-m').val(data.cat_usuario_sistema)
                $('#txt-observacion-m').val(data.cat_observacion)
                $('#txt-disco-duro-m').val(data.cat_disco_duro)
                $('#txt-programa-m').val(data.cat_programa)
                $("#modal-catalogo-m").modal('show')
                $("#global-loader").removeClass("block");
                $("#global-loader").addClass("none");
            })
        }
    })
}
/*FIN DE FUNCION PARA FUNCION PARA LISTAR CATALOGOS*/


/*INICIO DEL CLICK DEL BOTON DEL MODAL PARA MODIFICAR EL CATALOGO */
$("#btn-modificar-catalogo").click(function () {
    $("#btn-modificar-catalogo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Modificando..</span>")
    modificar_catalogo()
})
/*FIN DEL CLICK DEL BOTON DEL MODAL PARA MODIFICAR EL CATALOGO */

/*INICIO FUNCION PARA GUARDAR CATALOGO */
function modificar_catalogo() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-catalogo-m")[0]);
    $.ajax({
        url: '/modificar-catalogo',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            console.log(response)
            $('#txt-codigo-m').val("")
            $('#select-categoria-m').val("")
            $('#txt-marca-m').val("")
            $('#txt-modelo-m').val("")
            $('#txt-descripcion-m').val("")
            $('#txt-serie-m').val("")
            $('#txt-mac-ethernet-m').val("")
            $('#txt-mac-wifi-m').val("")
            $('#txt-ip-m').val("")
            $('#txt-anydesk-m').val("")
            $('#select-area-m').val("")
            $('#txt-ubicacion-m').val("")
            $('#txt-fecha-compra-m').val("")
            $('#txt-periodo-garantia-m').val("")
            $('#txt-proveedor-m').val("")
            $('#select-estado-m').val("")
            $('#txt-ram-m').val("")
            $('#txt-sistema-operativo-m').val("")
            $('#select-tipo-sistema-operativo-m').val("")
            $('#txt-usuario-sistema-m').val("")
            $('#txt-observacion-m').val("")
            $('#txt-disco-duro-m').val("")
            $('#txt-programa-m').val("")

            if (response.respuesta == 'true') {
                $("#modal-catalogo-m").modal('hide')
                notif({
                    msg: "<b>Correcto:</b> catalogo registrado",
                    type: "success"
                });
                //$("#select-direccion").val("0")
                //$("#select-jefatura-subdireccion").val("0")
                //$("#select-indicador").val("0")
                document.getElementById('form-catalogo').reset();
                $("#btn-modificar-catalogo").html("<i class='fa fa-save'></i> Modificar")
                get_catalogo()
                //location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar catalogo",
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
/*FIN FUNCION PARA GUARDAR CATALOGO*/


