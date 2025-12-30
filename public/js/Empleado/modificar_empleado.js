$(document).ready(function () {
    $('.dropify').dropify();
    var id_empleado = $("#txt-id-empleado").val()
    var id_perfil = 0
    var id_cargo = 0
    var id_cargo_superior = 0
    var id_ca = 0
    get_empleado_id(id_empleado)
})

function mayus(e) {
    e.value = e.value.toUpperCase();
}



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
                ht += '				<td align="center" id="txt-valor-1-' + id_prioridad + '" class="border-bottom-0 border">' + $("#txt-enfermedad").val() + '</td>'
                ht += '			    <td align="center" id="txt-descripcion-2-' + id_prioridad + '" class="border-bottom-0 border"></td>'
                ht += '				<td align="center" id="txt-valor-2-' + id_prioridad + '" class="border-bottom-0 border"></td>'
                ht += '				<td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                ht += '			</tr>'
            } else if (id_prioridad == 4) {
                var ht = ""
                ht += '		    <tr align="center" id="' + id_prioridad + '" class="id_prioridad">'
                ht += '				<td align="center"   class="border-bottom-0 border">MATERNIDAD</td>'
                ht += '			    <td align="center" id="txt-descripcion-1-' + id_prioridad + '" class="border-bottom-0 border">FECHA INICIO</td>'
                ht += '				<td align="center" id="txt-valor-1-' + id_prioridad + '" class="border-bottom-0 border">' + $("#txt-fecha-inicio-maternidad").val() + '</td>'
                ht += '			    <td align="center" id="txt-descripcion-2-' + id_prioridad + '" class="border-bottom-0 border">FECHA FIN</td>'
                ht += '				<td align="center" id="txt-valor-2-' + id_prioridad + '" class="border-bottom-0 border">' + $("#txt-fecha-fin-maternidad").val() + '</td>'
                ht += '				<td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                ht += '			</tr>'
            } else if (id_prioridad == 5) {
                var ht = ""
                ht += '		    <tr align="center" id="' + id_prioridad + '" class="id_prioridad">'
                ht += '				<td align="center"  class="border-bottom-0 border">ESTADO DE GESTACION</td>'
                ht += '			    <td align="center" id="txt-descripcion-1-' + id_prioridad + '" class="border-bottom-0 border">FECHA INICIO</td>'
                ht += '				<td align="center" id="txt-valor-1-' + id_prioridad + '" class="border-bottom-0 border">' + $("#txt-fecha-inicio-gestacion").val() + '</td>'
                ht += '			    <td align="center" id="txt-descripcion-2-' + id_prioridad + '"class="border-bottom-0 border">FECHA FIN</td>'
                ht += '				<td align="center" id="txt-valor-2-' + id_prioridad + '" class="border-bottom-0 border">' + $("#txt-fecha-fin-gestacion").val() + '</td>'
                ht += '				<td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                ht += '			</tr>'
            } else if (id_prioridad == 6) {
                var ht = ""
                ht += '		    <tr align="center" id="' + id_prioridad + '" class="id_prioridad">'
                ht += '				<td align="center"  class="border-bottom-0 border">ADULTO MAYOR</td>'
                ht += '			    <td align="center" id="txt-descripcion-1-' + id_prioridad + '" class="border-bottom-0 border">EDAD</td>'
                ht += '				<td align="center" id="txt-valor-1-' + id_prioridad + '" class="border-bottom-0 border">' + $("#txt-edad-adulto-mayor").val() + '</td>'
                ht += '			    <td align="center" id="txt-descripcion-2-' + id_prioridad + '"class="border-bottom-0 border"></td>'
                ht += '				<td align="center" id="txt-valor-2-' + id_prioridad + '" class="border-bottom-0 border"></td>'
                ht += '				<td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                ht += '			</tr>'
            }
            $("#div-tbody").append(ht)
            $(document).on('click', '.borrar', function (event) {
                event.preventDefault();
                $(this).closest('tr').remove();
            });
            $("#div-opcion-1").html("")
            $("#div-opcion-2").html("")
            $("#div-btn-add").addClass('none')
            $("#div-btn-add").removeClass('block')
            $("#select-prioridad").val(0)
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



/*INICIO PARA FUNCION CONSULTAR EMPLEADO POR ID*/
function get_empleado_id($id_empleado) {

    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar empleado")
    var id_empleado = $id_empleado
    $.ajax({
        url: '/get-empleado-modificar-id/' + id_empleado,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                    $("#txt-id-modificar-empleado").val(data.emp_id)
                    $("#txt-cedula").val(data.emp_cedula)
                    $("#txt-nombre").val(data.emp_nombre)
                    $("#txt-apellido").val(data.emp_apellido)
                    $("#txt-telefono").val(data.emp_telefono)
                    $("#select-tipo-contrato").val(data.emp_tipo_contrato)
                    $("#txt-remuneracion").val(data.emp_remuneracion)
                    $("#select-direccion").val(data.emp_id_departamento)
                    $("#select-jefatura-subdireccion").val(data.emp_id_perfil)
                    $("#txt-observacion").val(data.emp_observacion)
                    $("#select-sexo").val(data.emp_sexo)
                    $("#txt-fecha-nacimiento").val(data.emp_fecha_nacimiento)
                    $("#txt-fecha-ingreso").val(data.emp_fecha_ingreso)
                    $("#txt-fecha-salida").val(data.emp_fecha_salida)
                    $("#txt-titulo").val(data.emp_titulo)
                    $("#txt-edad").val(data.emp_edad)
                    $("#txt-direccion-domicilio").val(data.emp_direccion)
                    $("#txt-tipo-sangre").val(data.emp_tipo_sangre)
                    get_direcciones(data.emp_id_departamento)
                    id_jefatura = data.emp_id_perfil

                    id_cargo = data.emp_id_cargo
                    //get_cargos(data.emp_id_departamento,data.emp_id_perfil,data.emp_id_cargo)
                    $("#select-regimen-contrato").val(data.emp_id_regimen_contractual)
                    var drEvent = $('#txt-ruta-foto').dropify(
                        {
                            defaultFile: '/imagenes_empleados/' + data.emp_ruta_foto
                        });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = '/imagenes_empleados/' + data.emp_ruta_foto;
                    drEvent.destroy();
                    drEvent.init();
                })
                if (response.data_prioridad != "vacio") {
                    $('#checkbox-prioridad').click()
                    var ht = ""

                    $(response.data_prioridad).each(function (i, data) {
                        id_prioridad = data.id_prioridad
                        ht += '		    <tr align="center" >'
                        if (id_prioridad == 1) {
                            ht += '				<td align="center" id="' + id_prioridad + '" value= "" class="border-bottom-0 border id_prioridad">DISCAPACIDAD</td>'
                        } else if (id_prioridad == 2) {
                            ht += '				<td align="center" id="' + id_prioridad + '" value= "" class="border-bottom-0 border id_prioridad">SUSTITUTO</td>'
                        } else if (id_prioridad == 3) {
                            ht += '				<td align="center" id="' + id_prioridad + '" value= "" class="border-bottom-0 border id_prioridad">ENFERMEDAD CATASTROFICA</td>'
                        } else if (id_prioridad == 4) {
                            ht += '				<td align="center" id="' + id_prioridad + '" value= "" class="border-bottom-0 border id_prioridad">MATERNIDAD</td>'
                        } else if (id_prioridad == 5) {
                            ht += '				<td align="center" id="' + id_prioridad + '" value= "" class="border-bottom-0 border id_prioridad">ESTADO DE GESTACION</td>'
                        } else if (id_prioridad == 6) {
                            ht += '				<td align="center" id="' + id_prioridad + '" value= "" class="border-bottom-0 border id_prioridad">ADULTO MAYOR</td>'
                        }
                        ht += '			    <td align="center" id="txt-descripcion-1-' + id_prioridad + '"  class="border-bottom-0 border">' + data.descripcion_1.replace(/['"]+/g, '') + '</td>'
                        ht += '				<td align="center" id="txt-valor-1-' + id_prioridad + '" class="border-bottom-0 border">' + data.valor_1.replace(/['"]+/g, '').toUpperCase() + '</td>'
                        ht += '			    <td align="center" id="txt-descripcion-2-' + id_prioridad + '"  class="border-bottom-0 border">' + data.descripcion_2.replace(/['"]+/g, '') + '</td>'
                        ht += '				<td align="center" id="txt-valor-2-' + id_prioridad + '" class="border-bottom-0 border">' + data.valor_2.replace(/['"]+/g, '').toUpperCase() + '</td>'
                        ht += '				<td align="center" class="border-bottom-0 border"><input type="button" class="borrar" value="Eliminar" /></td>'
                        ht += '			</tr>'
                    })
                    $("#div-tbody").html(ht)
                    $(document).on('click', '.borrar', function (event) {
                        event.preventDefault();
                        $(this).closest('tr').remove();
                    });


                    $("#global-loader").addClass("none");
                    $("#global-loader").removeClass("block");
                }

                /*INICIO BOTON CLICK PARA MODIFICAR LOS DATOS DEL EMPLEADO */
                $("#btn-modificar-empleado").click(function () {
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
                        $("#btn-modificar-empleado").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span >Guardando..</span>")
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

                        $("#txt-prioridad-modificar").val(prioridades_data)
                        modificar_empleado()
                    }
                    //guardar_empleado()
                })
                /*FIN BOTON CLICK PARA MODIFICAR LOS DATOS DEL EMPLEADO */
                $("#modal-modificar-empleado").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR EMPLEADO POR ID*/

/*INICIO DE FUNCION PARA LISTAR LOS DEPARTAMENTOS EN EL SELECT*/
function get_direcciones(id_direc) {
    $("#select-direccion").html("<option value='0'>Cargando direcciones..</option>")
    $.ajax({
        url: '/get-direccion',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Dirección</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.dep_id + '>' + data.dep_departamento + '</option>'
                })
                $("#select-direccion").html(ht)
                $("#select-direccion> option[value='" + id_direc + "'] ").attr('selected', 'selected');
                $("#select-direccion").change()
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
var id_jefatura = 0
function get_jefaturas_subdirecciones(id_direccion) {
    $("#select-jefatura-subdireccion").html("<option value='0'>Cargando Jefaturas...</option>")
    $.ajax({
        url: '/get-jefatura-subdireccion/' + id_direccion,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">Seleccione Jefatura</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.per_id + '>' + data.per_perfil + '</option>'
                })
                $("#select-jefatura-subdireccion").html(ht)
                $("#select-jefatura-subdireccion> option[value='" + id_jefatura + "'] ").attr('selected', 'selected');
                $("#select-jefatura-subdireccion").change()
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
    get_cargos(id_direccion, id_jefatura)
})
/*FIN CLICK PARA LLAMAR A FUNCION QUE CONSULTA LOS CARGOS */


/*INICIO DE FUNCON PARA LISTAR LOS CARGOS*/
var id_cargo = 0
function get_cargos(id_direccion, id_jefatura) {
    $("#select-cargo-m").html("<option value='0'>CARGANDO CARGOS...</option>")

    $.ajax({
        url: '/get-cargo/' + id_direccion + '/' + id_jefatura,
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
                $("#select-cargo-m").html(ht);
                $("#text-cargo-m").val(id_cargo);
                //$("#select-cargo-superior").html(ht)
                $("#select-cargo-m> option[value='" + id_cargo + "'] ").attr('selected', 'selected');
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LOS CARGOS*/


/*INICIO FUNCION PARA MODIFICAR EL EMPLEADO */
function modificar_empleado() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-empleado-modificar")[0]);
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

    $("#txt-prioridad-modificar").val(prioridades_data)

    $.ajax({
        url: '/modificar-empleado',
        type: 'POST',
        dataType: 'json',
        contentType: false,
        processData: false,
        headers: { 'X-CSRF-TOKEN': token },
        data: datos,
        success: function (response) {
            if (response.respuesta == 'imagen_vacia') {
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
/*FIN FUNCION PARA MODIFICAR EL EMPLEADO */