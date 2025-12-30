$(document).ready(function () {
    get_direcciones()
})

$("#btn-enviar-correo").click(function () {
    //$("#global-loader").addClass("block");
    //$("#global-loader").removeClass("none");
    enviar_correo()
})

/*INICIO DE FUNCION PARA ENVIAR CORREO A LOS EMPLEADOS*/
function enviar_correo() {
    //$("#global-loader").addClass("block");
    //$("#global-loader").removeClass("none");
    var id_direccion = $("#select-direccion").val()
    var id_jefatura = $("#select-jefatura-subdireccion").val()
    var regimen_contractual = $("#select-regimen-contrato").val();

    $.ajax({
        url: '/enviar-correo-empleado/' + id_direccion + '/' + id_jefatura + '/'  + regimen_contractual+ '/'  + $('#txt-mensaje').val(),
        type: "GET",
        dataType: "json",
        success: function (response) {
            
        }
    })
}
/*FIN DE FUNCION PARA LISTAR EN REPORTE DE LOS EMPLEADOS POR FECHAS*/

/*INICIO DE FUNCION PARA LISTAR LAS DIRECCIONES EN EL SELECT*/
function get_direcciones() {
    $("#select-direccion").html("<option value='0'>CARGANDO DIRECCIONES..</option>")
    $.ajax({
        url: '/get-direccion',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">TODOS</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.dep_id + '>' + data.dep_departamento + '</option>'
                })
                $("#select-direccion").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS DIRECCIONES EN EL SELECT*/

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */
$("#select-direccion").change(function () {
    console.log($("#select-direccion").val())
    var id_direccion = $("#select-direccion").val()
    get_jefaturas_subdirecciones(id_direccion)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LAS JEFATURAS DE ACUERDO A LA DIRECCION */

/*INICIO DE FUNCON PARA LISTAR LOS PERFILES*/
function get_jefaturas_subdirecciones(id_direccion) {
    $("#select-jefatura-subdireccion").html("<option value='0'>CARGANDO JEFATURAS...</option>")
    $.ajax({
        url: '/get-jefatura-subdireccion/' + id_direccion,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">TODOS</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.per_id + '>' + data.per_perfil + '</option>'
                })
                $("#select-jefatura-subdireccion").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS PERFILES*/
