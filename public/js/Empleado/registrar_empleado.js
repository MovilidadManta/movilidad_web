$(document).ready(function () {
    $('.dropify').dropify();
    get_direcciones()
    //get_perfiles()
})
function mayus(e) {
    e.value = e.value.toUpperCase();
}

/*INICIO DE FUNCION PARA LISTAR LOS DEPARTAMENTOS EN EL SELECT*/
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
                ht += '<option value="0">SELECCIONE DIRECCIÓN</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.dep_id + '>' + data.dep_departamento + '</option>'
                })
                $("#select-direccion").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS DEPARTAMENTOS EN EL SELECT*/

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
                ht += '<option value="0">SELECCIONE JEFATURA</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.per_id + '>' + data.per_perfil + '</option>'
                })
                $("#select-jefatura-subdireccion").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS PERFILES*/

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS */
$("#select-jefatura-subdireccion").change(function () {
    console.log($("#select-jefatura-subdireccion").val())
    var id_direccion = $("#select-direccion").val()
    var id_jefatura = $("#select-jefatura-subdireccion").val()
    get_cargos(id_direccion,id_jefatura)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS */

function get_cargo_in() {
    $("#text-cargo").val($("#select-cargo option:selected").text());
}
/*INICIO DE FUNCON PARA LISTAR LOS CARGOS*/
function get_cargos(id_direccion,id_jefatura) {
    $("#select-cargo").html("<option value='0'>CARGANDO CARGOS...</option>")
    $.ajax({
        url: '/get-cargo/' + id_direccion+'/'+id_jefatura,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE CARGO</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id + '>' + data.ca_cargo + '</option>'
                })
                $("#select-cargo").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS CARGOS*/

/*INICIO CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS SUPERIOR */
$("#select-cargo").change(function () {
    console.log($("#select-cargo").val())
    var id_cargo = $("#select-cargo").val()
    get_cargos_superior(id_cargo)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS SUPERIOR*/


/*INICIO DE FUNCON PARA LISTAR LOS CARGOS*/
function get_cargos_superior(id_cargo) {
    $("#select-cargo-superior").html("<option value='0'>CARGANDO CARGOS...</option>")
    $.ajax({
        url: '/get-cargo-superior/' + id_cargo,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">SELECCIONE CARGO SUPERIOR</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.ca_id+ '>' + data.ca_cargo + '</option>'
                })
                $("#select-cargo-superior").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS CARGOS*/

/**INICIO PARA ESCIRIBIR EN EL INPUT TXT-CEDULA Y VALIDAR SI LA CEDULA ES VALIDA E INVALIDA */
$("#txt-cedula").on("keyup", function () {
    var cedula = $("#txt-cedula").val();

    if (cedula.length == 10) {
        console.log($("#txt-cedula").val())
        validar(cedula)
    } else if (cedula.length <= 9) {
        document.getElementById("va-ced").innerHTML = ("");
        $("#txt-cedula").html('')
    }
});
/**FIN PARA ESCIRIBIR EL DECIMO NUMERO EN EL INPUT TXT-CEDULA Y VALIDAR SI LA CEDULA ES VALIDA E INVALIDA */

/**INICIO DE FUNCION DE VALIDAR CEDULA */
function validar(cedula) {
    // var cad = document.getElementById("ced").value.trim();
    var cad = cedula.trim();
    console.log("cedula = " + cad)
    var total = 0;
    var longitud = cad.length;
    var longcheck = longitud - 1;

    if (cad !== "" && longitud === 10) {
        for (i = 0; i < longcheck; i++) {
            if (i % 2 === 0) {
                var aux = cad.charAt(i) * 2;
                if (aux > 9) aux -= 9;
                total += aux;
            } else {
                total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
            }
        }

        total = total % 10 ? 10 - total % 10 : 0;

        if (cad.charAt(longitud - 1) == total) {
            document.getElementById("va-ced").innerHTML = (" Válida");
        } else {
            document.getElementById("va-ced").innerHTML = (" Inválida");
            $('#txt-cedula').val("")
        }
    }
}
/**FIN DE FUNCION DE VALIDAR CEDULA */

/*$("#select-tipo-contrato").change(function(){
    var tipo_contrato = $("#select-tipo-contrato").val()
    if(tipo_contrato == 1){
        document.getElementById("select-tipo-contrato").disabled = true;
    }
})*/

/** INICIO CLICK AL INPUT CHECKBOX PARA AGREGAR EL SLECT GRUPO PRIORITARIO */
$('#checkbox-prioridad').on('click', function () {
    if ($(this).is(':checked')) {
        // Hacer algo si el checkbox ha sido seleccionado
        // alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
        var ht = ""
        var ht2 = ""
        //ht += '<div class="row row-sm card-body">'
        ht += '     <div class="col-lg ">'
        ht += '         <strong>Grupo prioritario</strong>'
        ht += '         <select name="select-prioridad" id="select-prioridad" class="form-control">'
        ht += '             <option value="0">SELECIONE PRIORIDAD</option>'
        ht += '             <option value="1">DISCAPACIDAD</option>'
        ht += '             <option value="2">SUDTITUTO</option>'
        ht += '             <option value="3">ENFERMEDAD CATASTROFICA</option>'
        ht += '             <option value="4">MATERNIDAD</option>'
        ht += '             <option value="5">ESTADO DE GESTACION</option>'
        ht += '             <option value="6">ADULTO MAYOR</option>'
        ht += '         </select>'
        ht += '     </div>'
        ht2 += '  <table id="table-empleado" border="2" class="table">'
        ht2 += '	    <thead class="background-thead">'
        ht2 += '		    <tr align="center">'
        ht2 += '				<th align="center" class="border-bottom-0 color-th pad">Prioridad</th>'
        ht2 += '				<th align="center" class="border-bottom-0 color-th pad">Descripcion</th>'
        ht2 += '			    <th align="center" class="border-bottom-0 color-th pad">Valor</th>'
        ht2 += '				<th align="center" class="border-bottom-0 color-th pad">Descripcion</th>'
        ht2 += '			    <th align="center" class="border-bottom-0 color-th pad">Valor</th>'
        ht2 += '				<th align="center" class="border-bottom-0 color-th pad">Opciones</th>'
        ht2 += '			</tr>'
        ht2 += '		</thead>'
        ht2 += '		<tbody  id="div-tbody">'
        ht2 += '		</tbody>'
        ht2 += '	</table>'

        //ht += '</div>'
        $("#div-table-prioridad").html(ht2)
        $("#div-select-grupo-prioridad").html(ht)
        var id_prioridad = ""
        console.log($(this).val())
        $("#select-prioridad").change(function () {
            id_prioridad = $(this).val()
            if (id_prioridad == 1) {
                var ht = ""
                ht += '         <strong>Porcentaje</strong>'
                ht += '         <input class="form-control" name="txt-porcentaje" id="txt-porcentaje" placeholder="Ingresar Porcentaje" type="text" >'
                $("#div-opcion-1").html(ht)
                var ht2 = ""
                ht2 += '         <strong>Tipo</strong>'
                ht2 += '         <input class="form-control" name="txt-tipo-discapacidad" id="txt-tipo-discapacidad" placeholder="Ingresar tipo de discapacidad" type="text" onkeypress="mayus(this);">'
                $("#div-opcion-2").html(ht2)
                $("#div-btn-add").addClass('block')
                $("#div-btn-add").removeClass('none')
            } else if (id_prioridad == 2) {
                var ht = ""
                ht += '         <strong>Nombre</strong>'
                ht += '         <input class="form-control" name="txt-nombre-sustituto" id="txt-nombre-sustituto" placeholder="Ingresar nombre" type="text" onkeypress="mayus(this);">'
                $("#div-opcion-1").html(ht)
                var ht2 = ""
                ht2 += '         <strong>Grado de cargo</strong>'
                ht2 += '         <input class="form-control" name="txt-grado-cargo" id="txt-grado-cargo" placeholder="Ingresar grado de cargo" type="text" onkeypress="mayus(this);">'
                $("#div-opcion-2").html(ht2)
                $("#div-btn-add").addClass('block')
                $("#div-btn-add").removeClass('none')
            } else if (id_prioridad == 3) {
                var ht = ""
                ht += '         <strong>Nombre</strong>'
                ht += '         <input class="form-control" name="txt-enfermedad" id="txt-enfermedad" placeholder="Ingresar Enfermedad" type="text" onkeypress="mayus(this);">'
                $("#div-opcion-1").html(ht)
                $("#div-btn-add").addClass('block')
                $("#div-btn-add").removeClass('none')
            } else if (id_prioridad == 4) {
                var ht = ""
                ht += '     <strong>Fecha Inicio</strong>'
                ht += '     <input class="form-control" name="txt-fecha-inicio-maternidad" id="txt-fecha-inicio-maternidad" placeholder="" type="date">'
                $("#div-opcion-1").html(ht)
                ht2 += '     <strong>Fecha Fin</strong>'
                ht2 += '     <input class="form-control" name="txt-fecha-fin-maternidad" id="txt-fecha-fin-maternidad" placeholder="" type="date">'
                $("#div-opcion-2").html(ht2)
                $("#div-btn-add").addClass('block')
                $("#div-btn-add").removeClass('none')
            } else if (id_prioridad == 5) {
                var ht = ""
                ht += '     <strong>Fecha Inicio</strong>'
                ht += '     <input class="form-control" name="txt-fecha-inicio-gestacion" id="txt-fecha-inicio-gestacion" placeholder="" type="date">'
                $("#div-opcion-1").html(ht)
                ht2 += '     <strong>Fecha Fin</strong>'
                ht2 += '     <input class="form-control" name="txt-fecha-fin-gestacion" id="txt-fecha-fin-gestacion" placeholder="" type="date">'
                $("#div-opcion-2").html(ht2)
                $("#div-btn-add").addClass('block')
                $("#div-btn-add").removeClass('none')
            } else if (id_prioridad == 6) {
                var ht = ""
                ht += '     <strong>Edad</strong>'
                ht += '     <input class="form-control" name="txt-edad-adulto-mayor" id="txt-edad-adulto-mayor" placeholder="Ingresar Edad" type="text">'
                $("#div-opcion-1").html(ht)
                $("#div-btn-add").addClass('block')
                $("#div-btn-add").removeClass('none')
            }
        })

        $("#btn-añadir-prioridad").click(function () {
            if (id_prioridad == 1) {
                var ht = ""
                ht += '		    <tr align="center" >'
                ht += '				<td align="center" id="' + id_prioridad + '" value= "DISCAPACIDAD" class="border-bottom-0 border id_prioridad">DISCAPACIDAD</td>'
                ht += '			    <td align="center" id="txt-descripcion-1-' + id_prioridad + '" value="PORCENTAJE" class="border-bottom-0 border">PORCENTAJE</td>'
                ht += '				<td align="center" id="txt-valor-1-' + id_prioridad + '" class="border-bottom-0 border">' + $("#txt-porcentaje").val() + '</td>'
                ht += '			    <td align="center" id="txt-descripcion-2-' + id_prioridad + '" value="TIPO DISCAPACIDAD" class="border-bottom-0 border">TIPO DISCAPACIDAD</td>'
                ht += '				<td align="center" id="txt-valor-2-' + id_prioridad + '" class="border-bottom-0 border">' + $("#txt-tipo-discapacidad").val() + '</td>'
                ht += '				<td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                ht += '			</tr>'
            } else if (id_prioridad == 2) {
                var ht = ""
                ht += '		    <tr align="center" >'
                ht += '				<td align="center" id="' + id_prioridad + '" class="id_prioridad" class="border-bottom-0 border">SUSTITUTO</td>'
                ht += '			    <td align="center" id="txt-descripcion-1-' + id_prioridad + '" class="border-bottom-0 border">NOMBRE</td>'
                ht += '				<td align="center" id="txt-valor-1-' + id_prioridad + '" class="border-bottom-0 border">' + $("#txt-nombre-sustituto").val() + '</td>'
                ht += '			    <td align="center" id="txt-descripcion-2-' + id_prioridad + '" class="border-bottom-0 border">CARGO</td>'
                ht += '				<td align="center" id="txt-valor-2-' + id_prioridad + '" class="border-bottom-0 border">' + $("#txt-grado-cargo").val() + '</td>'
                ht += '				<td align="center"  class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                ht += '			</tr>'
            } else if (id_prioridad == 3) {
                var ht = ""
                ht += '		    <tr align="center" id="' + id_prioridad + '" class="id_prioridad">'
                ht += '				<td align="center" class="border-bottom-0 border">ENFERMEDAD CATASTROFICA</td>'
                ht += '			    <td align="center" id="txt-descripcion-1-' + id_prioridad + '" class="border-bottom-0 border">NOMBRE</td>'
                ht += '				<td align="center" class="border-bottom-0 border">' + $("#txt-enfermedad").val() + '</td>'
                ht += '			    <td align="center" class="border-bottom-0 border"></td>'
                ht += '				<td align="center" class="border-bottom-0 border"></td>'
                ht += '				<td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                ht += '			</tr>'
            } else if (id_prioridad == 4) {
                var ht = ""
                ht += '		    <tr align="center" id="' + id_prioridad + '" class="id_prioridad">'
                ht += '				<td align="center" id="txt-descripcion-1-' + id_prioridad + '" class="border-bottom-0 border">MATERNIDAD</td>'
                ht += '			    <td align="center" class="border-bottom-0 border">FECHA INICIO</td>'
                ht += '				<td align="center" class="border-bottom-0 border">' + $("#txt-fecha-inicio-maternidad").val() + '</td>'
                ht += '			    <td align="center" class="border-bottom-0 border">FECHA FIN</td>'
                ht += '				<td align="center" class="border-bottom-0 border">' + $("#txt-fecha-fin-maternidad").val() + '</td>'
                ht += '				<td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                ht += '			</tr>'
            } else if (id_prioridad == 5) {
                var ht = ""
                ht += '		    <tr align="center" id="' + id_prioridad + '" class="id_prioridad">'
                ht += '				<td align="center" id="txt-descripcion-1-' + id_prioridad + '" class="border-bottom-0 border">ESTADO DE GESTACION</td>'
                ht += '			    <td align="center" class="border-bottom-0 border">FECHA INICIO</td>'
                ht += '				<td align="center" class="border-bottom-0 border">' + $("#txt-fecha-inicio-gestacion").val() + '</td>'
                ht += '			    <td align="center" class="border-bottom-0 border">FECHA FIN</td>'
                ht += '				<td align="center" class="border-bottom-0 border">' + $("#txt-fecha-fin-gestacion").val() + '</td>'
                ht += '				<td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                ht += '			</tr>'
            } else if (id_prioridad == 6) {
                var ht = ""
                ht += '		    <tr align="center" id="' + id_prioridad + '" class="id_prioridad">'
                ht += '				<td align="center" id="txt-descripcion-1-' + id_prioridad + '" class="border-bottom-0 border">ADULTO MAYOR</td>'
                ht += '			    <td align="center" class="border-bottom-0 border">EDAD</td>'
                ht += '				<td align="center" class="border-bottom-0 border">' + $("#txt-edad-adulto-mayor").val() + '</td>'
                ht += '			    <td align="center" class="border-bottom-0 border"></td>'
                ht += '				<td align="center" class="border-bottom-0 border"></td>'
                ht += '				<td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                ht += '			</tr>'
            }
            $("#div-tbody").append(ht)
            $(document).on('click', '.borrar', function (event) {
                event.preventDefault();
                $(this).closest('tr').remove();
            });

        })

    } else {
        $("#div-select-grupo-prioridad").html("")
        $("#div-opcion-1").html("")
        $("#div-opcion-2").html("")
        $("#div-btn-add").addClass('none')
        $("#div-btn-add").removeClass('block')
        $("#div-table-prioridad").html("")
    }
});
/** FIN CLICK AL INPUT CHECKBOX PARA AGREGAR EL SLECT GRUPO PRIORITARIO */

/*INICIO BOTON CLICK PARA GUARDAR LOS DATOS DEL EMPLEADO */
$("#btn-guardar-empleado").click(function () {
    if (
        $("#txt-cedula").val() == "" &&
        $("#txt-nombre").val() == "" &&
        $("#txt-apellido").val() == "" &&
        $("#txt-telefono").val() == "" &&
        $("#select-sexo").val() == "0" &&
        $("#txt-fecha-nacimiento").val() == '' &&
        $("#txt-edad").val() == "" &&
        $("#txt-tipo-sangre").val() == "" &&
        $("#txt-direccion-domicilio").val() == "" &&
        $("#select-direccion").val() == "0" &&
        $("#select-jefatura-subdireccion").val() == "0" &&
        $("#txt-cargo").val() == "" &&
        $("#select-regimen-contrato").val() == "0" &&
        $("#select-tipo-contrato").val() == "0" &&
        $("#txt-remuneracion").val() == "" &&
        $("#txt-fecha-ingreso").val() == "" &&
        $("#txt-fecha-salida").val() == "" &&
        $("#txt-observacion").val() == ""
    ) {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos estan vacios",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-cedula").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo cedula esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-nombre").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo nombre esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-apellido").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo apellido esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-telefono").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo telefono esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#select-sexo").val() == '0') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo sexo no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-fecha-nacimiento").val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo fecha de nacimiento esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-edad").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo edad esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-tipo-sangre").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo tipo de sangre esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-direccion-domicilio").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo domicilio esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#select-direccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo direccion no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#select-direccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo direccion no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#select-jefatura-subdireccion").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo jefatura no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-cargo").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo cargo esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#select-regimen-contrato").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo regimen no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#select-tipo-contrato").val() == "0") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo mosalidad contractual no esta seleccionado",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-remuneracion").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo remuneracion esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-fecha-ingreso").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo fecha no esta seleccionada",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-observacion").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo observacion esta vacio",
            position: "right",
            autohide: false
        });
    } else if ($("#txt-titulo").val() == "") {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Campo titulo esta vacio",
            position: "right",
            autohide: false
        });
    } else {
        $("#btn-guardar-empleado").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Guardando..</span>")
        var prioridades = []
        $('.id_prioridad').each(function () {
            prioridades.push($(this).attr("id"))
        })
        //console.log(prioridades.join(","))
        console.log("id prioridades: " + prioridades)
        n = prioridades.length
        console.log(n)
        var prioridades_ = []
        for (var i = 0; i <= n - 1; i++) {
            var array_1 = {
                'id_prioridad': prioridades[i],
                'descripcion': $("#txt-descripcion-1-" + prioridades[i]).html(),
                'valor': $("#txt-valor-1-" + prioridades[i]).html()
            }
            var array_2 = {
                'id_prioridad': prioridades[i],
                'descripcion': $("#txt-descripcion-2-" + prioridades[i]).html(),
                'valor': $("#txt-valor-2-" + prioridades[i]).html()
            }
            prioridades_.push(array_1)
            prioridades_.push(array_2)
        }
        var prioridades_data = JSON.stringify(prioridades_)
        console.log("prioridades_:" + prioridades_)
        $("#txt-prioridad").val(prioridades_data)
        guardar_empleado()
    }
    //guardar_empleado()
})
/*FIN BOTON CLICK PARA GUARDAR LOS DATOS DEL EMPLEADO */
$("#div-opcion-1").html("")
$("#div-opcion-2").html("")
$("#div-btn-add").addClass('none')
$("#div-btn-add").removeClass('block')
$("#select-prioridad").val(0)

/**INICIO CLICK PARA CALCULAR LA EDAD */
$("#txt-fecha-nacimiento").change(function () {
    var fecha = $("#txt-fecha-nacimiento").val()
    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }
    $("#txt-edad").val(edad)
    console.log("edad " + edad);
})
/**FIN CLICK PARA CALCULAR LA EDAD */


$("#btn-guardar-o").click(function () {
    /*var prioridades = []
    $('.id_prioridad').each(function () {
        prioridades.push($(this).attr("id"))
    })
    //console.log(prioridades.join(","))
    console.log("id prioridades: " + prioridades)
    n = prioridades.length
    console.log(n)
    var prioridades_ = []
    for (var i = 0; i <= n - 1; i++) {
        var array_1 = {
            'id_prioridad': prioridades[i],
            'descripcion': $("#txt-descripcion-1-" + prioridades[i]).html(),
            'valor': $("#txt-valor-1-" + prioridades[i]).html()
        }
        var array_2 = {
            'id_prioridad': prioridades[i],
            'descripcion': $("#txt-descripcion-2-" + prioridades[i]).html(),
            'valor': $("#txt-valor-2-" + prioridades[i]).html()
        }
        prioridades_.push(array_1)
        prioridades_.push(array_2)
    }
    var prioridades_data = JSON.stringify(prioridades_)
    console.log("tarea:" + prioridades_data)
    alert($("#txt-data-prioridad").val(prioridades_data))*/
    var fecha = $("#txt-fecha-nacimiento").val()
    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }
    console.log("edad " + edad);
    $("#txt-edad").val(edad)
})



/*INICIO FUNCION PARA GUARDAR EL EMPLEADO */
function guardar_empleado() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-empleado")[0]);



    $.ajax({
        url: '/registrar-empleado',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        /* data :{
             cedula:$("#txt-cedula").val(),
             nombre:$("#txt-nombre").val(),
             apellido:$("#txt-apellido").val(),
             telefono:$("#txt-telefono").val(),
             sexo:$("#select-sexo").val(),
             jefatura_subdireccion:$("#select-jefatura-subdireccion").val(),
             tipo_contrato:$("#select-tipo-contrato").val(),
             regimen_contrato:$("#select-regimen-contrato").val(),
             remuneracion:$("#txt-remuneracion").val(),
             fecha_ingreso:$("#txt-fecha-ingreso").val(),
             fecha_salida:$("#txt-fecha-salida").val(),
             txt_direccion_domicilio:$("#txt-direccion-domicilio").val(),
             observacion:$("#txt-observacion").val(),
             cargo:$("#txt-cargo").val(),
             edad:$("#txt-edad").val(),
             ruta_foto:$("#txt-ruta-foto").val(),
             estado_imagen:$("#txt-estado-imagen").val(),
             prioridades_data:prioridades_data
         },*/
        data: datos,
        success: function (response) {
            if (response.data == 'empleado_registrado') {
                notif({
                    type: "warning",
                    msg: "<b>Aviso: </b>Empleado ya esta registrado",
                    position: "right",
                    autohide: false
                });
            } else if (response.respuesta == 'imagen_vacia') {
                notif({
                    type: "error",
                    msg: "<b>Error: </b>Error al cargar foto",
                    position: "right",
                    autohide: false
                });
            } else if (response.respuesta == 'true') {
                notif({
                    msg: "<b>Correcto:</b> Empleado registrado",
                    type: "success"
                });
                $("#txt-cedula").val("")
                $("#txt-nombre").val("")
                $("#txt-apellido").val("")
                $("#txt-telefono").val("")
                $("#select-direccion").val("0")
                $("#select-jefatura-subdireccion").val("0")
                $("#select-tipo-contrato").val("0")
                $("#txt-remuneracion").val("")
                $("#txt-direccion-domicilio").val("")
                $("#txt-cargo").val("")
                $("#txt-observacion").val("")
                $("#txt-edad").val("")
                $("#txt-titulo").val("")
                $("#div-select-grupo-prioridad").html("")

                $(".div-opcion-1").html("")
                $(".div-opcion-2").html("")
                $("#btn-guardar-empleado").html("<i class='fa fa-save'></i> Guardar")
                //$("#modal-empleado").modal('hide')
                location.href = "/nomina";
            } else {
                notif({
                    type: "danger",
                    msg: "<b>Error: </b>Error al registrar empleado",
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
/*FIN FUNCION PARA GUARDAR EL EMPLEADO */





