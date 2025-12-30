$(document).ready(function () {
    login()
})

$("#txt-clave").keypress(function (tecla) {
    if (tecla.which == 13) {
        $("#btn-iniciar-sesion").attr('disabled', true);
        var usuario = $("#txt-usuario").val()
        var contraseña = $("#txt-clave").val()
        if (usuario != "") {
            if (contraseña != "") {
                console.log("btn-iniciar-sesion")
                $("#btn-iniciar-sesion").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Verificando Informacion</span>")
                iniciar_sesion()
            } else {
                $("#txt-clave").focus()
                $("#btn-iniciar-sesion").attr('disabled', false);

            }
        }
        else {
            $("#txt-usuario").focus()
            $("#btn-iniciar-sesion").attr('disabled', false);
        }
    }
});

$("#btn-iniciar-sesion").click(function () {
    $("#btn-iniciar-sesion").attr('disabled', true);
    var usuario = $("#txt-usuario").val()
    var contraseña = $("#txt-clave").val()
    if (usuario != "") {
        if (contraseña != "") {
            console.log("btn-iniciar-sesion")
            $("#btn-iniciar-sesion").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Verificando Informacion</span>")
            iniciar_sesion()
        } else {
            $("#txt-clave").focus()
            $("#btn-iniciar-sesion").attr('disabled', false);
        }
    }
    else {
        $("#txt-usuario").focus()
        $("#btn-iniciar-sesion").attr('disabled', false);

    }
})

//Inicio funcion para iniciar sesion
function iniciar_sesion() {
    var datos = new FormData($("#login-form")[0]);
    var token = $("#token").val()
    //var user = $("#form_username_email").val()
    //$("#btn-siguiente").html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Validando E-mail')
    $.ajax({
        url: '/iniciar-sesion',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response)
            $("#btn-iniciar-sesion").attr('disabled', false);
            if (response.usuario == false) {
                notif({
                    type: "error",
                    msg: "<b>Error: </b>Usuario Incorrecto",
                    position: "center",
                    autohide: false
                });
                $("#btn-iniciar-sesion").html("Iniciar Sesión")
            } else if (response.clave == false) {
                notif({
                    type: "error",
                    msg: "<b>Error: </b>Clave Incorrecta",
                    position: "center",
                    autohide: false
                });
                $("#btn-iniciar-sesion").html("Iniciar Sesión")
            } else if (response.respuesta == true) {
                location.href = "/home";
            }
        }
    })
}
//fin funcion para iniciar sesion