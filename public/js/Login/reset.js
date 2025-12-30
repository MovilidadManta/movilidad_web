$("#btn_cambiar").click(function () {
    let contrasena = $("#ip_pass").val();
    let new_contrasena = $("#ip_newpass").val();
    let con_contrasena = $("#ip_conpass").val();

    if (new_contrasena != con_contrasena) {
        alert("La contrasena nueva no coincide con la confirmacion");
        return;
    } else if (contrasena == "") {
        alert("Por favor debe ingresar la contrasena actual");
        return;
    } else if (new_contrasena == "" && con_contrasena == "") {
        alert("La nueva contrasena esta vacio y no esta confirmada");
        return;
    } else if (con_contrasena == "") {
        alert("La contrasena de confirmacion esta vacio!");
        return;
    } else {
        let dat = {
            contrasena,
            new_contrasena,
            con_contrasena,
        };
        cambiar_contra(dat);
    }
});
function cambiar_contra(data) {
    var token = $("#csrf-token").val();
    $.ajax({
        url: "/cambiar_pass",
        type: "POST",
        dataType: "json",
        headers: { "X-CSRF-TOKEN": token },
        data: data,
        success: function (response) {
            console.log(response);
            $("#btn-iniciar-sesion").attr("disabled", false);
            if (response.clave == false) {
                notif({
                    type: "error",
                    msg: "<b>Error: </b>Clave Incorrecta",
                    position: "center",
                    autohide: false,
                });
                $("#btn-iniciar-sesion").html("Iniciar Sesión");
            } else if (response.respuesta == true) {
                console.log(response.sql);
                //location.href = "/cerrar-sesion";
            }
        },
    });
}
