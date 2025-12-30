$(document).ready(function () {
})
//$("#global-loader").addClass("none");
//$("#global-loader").removeClass("block");

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE CONTACTANOS */
$("#btn-guardar-contactano").click(function () {
    $("#btn-guardar-contactano").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Guardando..</span>")
    let nombre = $("#txt-nombre").val();
    let apellidos = $("#txt-apellido").val();
    let correo = $("#txt-correo").val();
    let mensajes = $("#txt-mensaje").val();
    if (nombre == "") {
        Swal.fire("Alerta!", "Estimado por favor ingrese sus nombres", "error");
        $("#btn-guardar-contactano").html("Enviar");
        $("#txt-nombre").focus();
    } else if (apellidos == "") {
        Swal.fire(
            "Alerta!",
            "Estimado por favor ingrese sus apellidos",
            "error"
        );
        $("#btn-guardar-contactano").html("Enviar");
        $("#txt-apellido").focus();
    } else if (correo == "") {
        Swal.fire(
            "Alerta!",
            "Estimado por favor ingrese su correo electonico",
            "error"
        );
        $("#btn-guardar-contactano").html("Enviar");
        $("#txt-correo").focus();
    } else if (mensajes == "") {
        Swal.fire(
            "Alerta!",
            "Estimado por favor ingrese un mensaje de texto",
            "error"
        );
        $("#btn-guardar-contactano").html("Enviar");
        $("#txt-mensaje").focus();
    } else {
        guardar_contactanos();
    }
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DE CONTACTANOS */

/*INICIO FUNCION PARA GUARDAR DE CONTACTANOS */
function guardar_contactanos() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-contactano")[0]);
    $.ajax({
        url: '/registrar-contactano-pagina',
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
                    'Correcto!',
                    'Mensaje Guardado',
                    'success'
                  )
                /*notif({
                    msg: "<b>Correcto:</b> Mision y Vision registrado",
                    type: "success"
                });*/
                $("#txt-nombre").val("")
                $("#txt-apellido").val("")
                $("#txt-correo").val("")
                $("#txt-mensaje").val("")
                $("#btn-guardar-contactano").html("Enviar")
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
/*FIN FUNCION PARA GUARDAR DE CONTACTANOS */




