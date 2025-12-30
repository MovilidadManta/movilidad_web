let año_current = 2023;
const regex = /^[0-9]*$/;
$(document).ready(function () {
    get_literal_lotaips($("#id-lotaip").val(), $("#year-lotaip").val());
});

$(".btn-pagina-año").click(function () {
    $(".cargando").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Cargando Información...</span>"
    );
    var id_lotaip = this.id;
    var id_lo = id_lotaip.split("-");
    //alert('hola'+id_lotaip)
    get_literal_lotaips(id_lo[0], id_lo[1]);
});

/*INICIO DE FUNCION PARA LISTAR LOTAIP */
function get_literal_lotaips(id, año) {
    $("#v-pills-" + año_current).html("");
    $(".cargando").html(
        "<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Cargando Información...</span>"
    );
    console.log("listar literales lotaip");
    $.ajax({
        url: "/get-literal-lotaip/" + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data);
            var ht = "";
            $(response.data_meses).each(function (i, datam) {
                ht += '<div class="accordion-item">';
                ht +=
                    '     <h2 class="accordion-header" id="heading-' +
                    datam +
                    '">';
                if (datam == 1) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "         Enero";
                    ht += "     </button>";
                } else if (datam == 2) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "         Febrero";
                    ht += "     </button>";
                } else if (datam == 3) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "          Marzo";
                    ht += "     </button>";
                } else if (datam == 4) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "          Abril";
                    ht += "     </button>";
                } else if (datam == 5) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "         Mayo";
                    ht += "     </button>";
                } else if (datam == 6) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "         Junio";
                    ht += "     </button>";
                } else if (datam == 7) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "         Julio";
                    ht += "     </button>";
                } else if (datam == 8) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "         Agosto";
                    ht += "     </button>";
                } else if (datam == 9) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "         Septiembre";
                    ht += "     </button>";
                } else if (datam == 10) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "         Octubre";
                    ht += "     </button>";
                } else if (datam == 11) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "         Noviembre";
                    ht += "     </button>";
                } else if (datam == 12) {
                    ht +=
                        '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' +
                        datam +
                        '" aria-expanded="false" aria-controls="collapseOne">';
                    ht += "         Diciembre";
                    ht += "     </button>";
                }
                ht += "  </h2>";
                ht +=
                    '     <div id="collapse-' +
                    datam +
                    '" class="accordion-collapse collapse color" aria-labelledby="headingOne" data-bs-parent="#accordionExample">';
                ht += '         <div class="accordion-body">';
                $(response.data).each(function (i, data) {
                    if (data.ldl_extension_archivo == "link") {
                        ht += `
                            <table class="table" border="0">
                            <tbody>
                                <tr>
                                    <td style="padding: 2px !important;vertical-align: middle !important;" width="90%">
                                        <ul class="ul-pad">
                                            <li>
                                                <a href="${data.ldl_ruta_archivo}" target="_blank">${data.li_literal}</a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                            </table>

                        `;
                    }
                    else {
                        if (data.ldl_mes == datam) {
                            ht += '     <table class="table" border="0">';
                            ht += "         <tbody>";
                            ht += "             <tr>";
                            ht +=
                                '                 <td style="padding: 2px !important;vertical-align: middle !important;" width="90%">';
                            ht += '                     <ul class="ul-pad">';
                            ht +=
                                "                         <li>" +
                                data.li_literal +
                                "</li>";
                            ht += "                     </ul>";
                            ht += "                 </td>";
                            if (data.ldl_extension_archivo == "pdf") {
                                ht +=
                                    '<td width="10%"><a href="/archivos_lotaip/' +
                                    data.ldl_ruta_archivo +
                                    '" target="_blank"><img class="aligncenter" style="color: #f44336; max-width: 40%;" src="/Imagenes/pdf.png" /></a></td>';
                                //ht +='<td width="10%"><a href="#"><img class="aligncenter" style="color: #f44336; max-width: 40%;" src="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/04/pdf.png" /></a></td>';
                            } else if (data.ldl_extension_archivo == "xlsx") {
                                ht +=
                                    '<td width="10%"><a href="/archivos_lotaip/' +
                                    data.ldl_ruta_archivo +
                                    '" target="_blank"><img class="aligncenter" style="color: #f44336; max-width: 40%;" src="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/04/sobresalir.png" /></a></td>';
                                //ht +='<td width="10%"><a href="#"><img class="aligncenter" style="color: #f44336; max-width: 40%;" src="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/04/sobresalir.png" /></a></td>';
                            }
                            ht += "              </tr>";
                            ht += "         </tbody>";
                            ht += "       </table>";
                        }
                    }
                });
                ht += "          </div>";
                ht += "     </div>";
                ht += "</div>";
            });
            año_current = año;
            $("#v-pills-" + año).html(ht);
            $(".cargando").html("");
        },
    });
}
/*FIN DE FUNCION PARA LISTAR LOTAIP */

/*INICIO FUNCION PARA GUARDAR SOLICITUD DE LOTAIP */
function guardar_solicitud_lotaip() {
    $("#btn-guardar-solicitud-lotaip").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Enviando solicitud..</span>")

    if ($("#txt-nombre").val() == "") {
        Swal.fire("Alerta!", "Estimado por favor ingrese sus nombres", "error");
        $("#btn-guardar-solicitud-lotaip").html("Enviar solicitud")
        $("#txt-nombre").focus();
    } else if ($("#txt-cedula").val() == "") {
        Swal.fire(
            "Alerta!",
            "Estimado por favor ingrese su cédula",
            "error"
        );
        $("#btn-guardar-solicitud-lotaip").html("Enviar solicitud")
        $("#txt-apellido").focus();
    } else if ($("#txt-email").val() == "") {
        Swal.fire(
            "Alerta!",
            "Estimado por favor ingrese su correo electonico",
            "error"
        );
        $("#btn-guardar-solicitud-lotaip").html("Enviar solicitud")
        $("#txt-correo").focus();
    } else if ($("#txt-mensaje").val() == "") {
        Swal.fire(
            "Alerta!",
            "Estimado por favor ingrese un mensaje de texto",
            "error"
        );
        $("#btn-guardar-solicitud-lotaip").html("Enviar solicitud")
        $("#txt-mensaje").focus();
    } else if ($("#txt-telefono").val() == "") {
        Swal.fire(
            "Alerta!",
            "Estimado por favor ingrese un numero de teléfono",
            "error"
        );
        $("#btn-guardar-solicitud-lotaip").html("Enviar solicitud")
        $("#txt-mensaje").focus();
    } else {
        var token = $("#csrf-token").val();
        var datos = new FormData($("#form-solicitud-lotaip")[0]);
        $.ajax({
            url: '/registrar-solicitud-lotaip',
            type: 'POST',
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': token },
            contentType: false,
            processData: false,
            data: datos,
            success: function (response) {
                console.log(response.data)
                if (response.respuesta == "true") {
                    Swal.fire(
                        'Solitud enviada correctamente !',
                        'Su solicitud esta siendo procesada, en el transcurso 48 horas recibira la atención requerida',
                        'success'
                    )
                    /*notif({
                        msg: "<b>Correcto:</b> Mision y Vision registrado",
                        type: "success"
                    });*/
                    $("#txt-nombre").val("")
                    $("#txt-cedula").val("")
                    $("#txt-email").val("")
                    $("#txt-mensaje").val("")
                    $("#txt-telefono").val("")
                    $("#txt-file").val("")
                    $("#btn-guardar-solicitud-lotaip").html("Enviar solicitud")
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

$("#select-forma-recepcion").on("change", function () {
    $("#div-email").fadeOut();
    if ($(this).val() == 2) {
        $("#div-email").fadeIn();
    }
});
$("#select-formato-entrega").on("change", function () {
    $("#select-formato-digital").fadeOut();
    $("#div-otros").fadeOut();
    $('#select-formato-digital').val('0');
    if ($(this).val() == 3) {
        $("#select-formato-digital").fadeIn();
    }
});
$("#select-formato-digital").on("change", function () {
    $("#div-otros").fadeOut();
    if ($(this).val() == 4) {
        $("#div-otros").fadeIn();
    }
});

$('.input-number').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});

$("#btn-enviar-solicitud-lotaip").click(function () {
    if (
        $('#txt-nombre').val() == '' &&
        $('#txt-apellido').val() == '' &&
        $('#txt-cedula').val() == '' &&
        $('#txt-telefono').val() == '' &&
        $('#txt-direccion').val() == '' &&
        $('#txt-peticion').val() == '' &&
        $('#select-forma-recepcion').val() == '0' &&
        $('#select-formato-entrega').val() == '0'
    ) {
        Swal.fire(
            "Alerta!",
            "Los campos estan vacíos",
            "error"
        );
    } else if ($('#txt-nombre').val() == '') {
        Swal.fire(
            "Alerta!",
            "Campo Nombres esta vacío",
            "error"
        );
    } else if ($('#txt-apellido').val() == '') {
        Swal.fire(
            "Alerta!",
            "Campo Apellidos esta vacío",
            "error"
        );
    } else if ($('#txt-cedula').val() == '') {
        Swal.fire(
            "Alerta!",
            "Campo Cédula esta vacío",
            "error"
        );
    } else if ($('#txt-telefono').val() == '') {
        Swal.fire(
            "Alerta!",
            "Campo Télefono esta vacío",
            "error"
        );
    } else if ($('#txt-direccion').val() == '') {
        Swal.fire(
            "Alerta!",
            "Campo Dirección domiciliaria esta vacío",
            "error"
        );
    } else if ($('#txt-peticion').val() == '') {
        Swal.fire(
            "Alerta!",
            "Campo Petición concreta esta vacío",
            "error"
        );
    } else if ($('#select-forma-recepcion').val() == '0') {
        Swal.fire(
            "Alerta!",
            "Campo Forma de recepción de la información solicitada no esta seleccionado",
            "error"
        );
    } else if ($('#select-forma-recepcion').val() == 2 && $('#txt-email').val() == '') {
        Swal.fire(
            "Alerta!",
            "Campo Email esta vacío",
            "error"
        );
    } else if ($('#select-forma-recepcion').val() == 2 && !$('#txt-email').val().match(
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    )) {
        Swal.fire(
            "Alerta!",
            "Campo Email no tiene un formato valido",
            "error"
        );
    } else if ($('#select-formato-entrega').val() == '0') {
        Swal.fire(
            "Alerta!",
            "Campo Formato de entrega no esta seleccionado",
            "error"
        );
    } else if ($('#select-formato-entrega').val() == 3 && $('#select-formato-digital').val() == '0') {
        Swal.fire(
            "Alerta!",
            "Seleccione un formato eletrónico",
            "error"
        );
    } else if ($('#select-formato-digital').val() == 4 && $('#txt-otros-especifico').val() == '') {
        Swal.fire(
            "Alerta!",
            "Especifique otro formato electronico",
            "error"
        );
    } else {
        $("#btn-enviar-solicitud-lotaip").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
        if ($('#select-forma-recepcion').val() == '1') {
            $('#txt-email').val('');
        }
        if ($('#select-formato-entrega').val() != '3') {
            $('#select-formato-digital').val(0);
            $('#txt-otros-especifico').val('');
        }
        if ($('#select-formato-digital').val() != '4') {
            $('#txt-otros-especifico').val('');
        }
        send_solicitud_lotaip();
    }
})

$("#btn-nueva-solicitud-lotaip").click(function () {
    $('.form-solicitud-lotaip').fadeIn();
    $('.frame-lotaip').fadeOut();
})

function send_solicitud_lotaip() {
    let token = $("#csrf-token").val();
    let datos = new FormData($("#form-solicitud-acceso-lotaip")[0]);
    $.ajax({
        url: '/enviar-solicitud-lotaip',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log('response', response)
            if (response.respuesta == "true") {
                Swal.fire(
                    'Solitud enviada correctamente !',
                    'Su solicitud esta siendo procesada, en el transcurso 48 horas recibira la atención requerida',
                    'success'
                )

                $("#txt-nombre").val("")
                $("#txt-apellido").val("")
                $("#txt-cedula").val("")
                $("#txt-telefono").val("")
                $("#txt-direccion").val("")
                $("#txt-email").val("")
                $("#txt-peticion").val("")
                $("#select-forma-recepcion").val(0)
                $("#select-formato-entrega").val(0)
                $("#select-formato-digital").val(0)
                $("#txt-otros-especifico").val("")
                $("#div-email").fadeOut();
                $("#select-formato-digital").fadeOut();
                $("#div-otros").fadeOut();

                $("#btn-enviar-solicitud-lotaip").html("Enviar solicitud")

                $('.form-solicitud-lotaip').fadeOut();
                $('.frame-lotaip').fadeIn();
                $('#frame-pdf-lotaip').attr('src', `/archivos_solicitudes_lotaip/${response.archivo}`);
            }
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.status === 0) {
            alert('Not connect: Verify Network.');
        } else if (jqXHR.status == 404) {
            alert('Requested page not found [404]');
        } else if (jqXHR.status == 500) {
            console.log(jqXHR);
            alert('Internal Server Error [500]. Intente nuevamente');
        } else if (textStatus === 'timeout') {
            alert('Time out error.');
        } else if (textStatus === 'abort') {
            alert('Ajax request aborted.');
        }
    });
}
/*FIN FUNCION PARA GUARDAR SOLICITUD DE LOTAIP */
