$(document).ready(function () {
    get_direcciones()
})

$("#btn-reporte-empleado").click(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    get_empleado_reporte()
})
$("#sel_niveles").change(function () {
    console.log($("#sel_niveles").val());
});

/*INICIO DE FUNCION PARA LISTAR EN REPORTE DE LOS EMPLEADOS POR FECHAS*/
function get_empleado_reporte() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar empleado");
    let niveles = $("#sel_niveles").val();

    if (niveles == 0) {
        var id_direccion = $("#select-direccion").val();
        var id_jefatura = $("#select-jefatura-subdireccion").val();
        var fecha_inicio = $("#select-fecha-inicio").val();
        if (fecha_inicio == "") {
            fecha_inicio = "0";
        }
        var fecha_fin = $("#select-fecha-fin").val();
        if (fecha_fin == "") {
            fecha_fin = "0";
        }

        var regimen_contractual = $("#select-regimen-contrato").val();
        $.ajax({
            url:
                "/get-reporte-empleado/" +
                id_direccion +
                "/" +
                id_jefatura +
                "/" +
                fecha_inicio +
                "/" +
                fecha_fin +
                "/" +
                regimen_contractual,
            type: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response.data);
                var ht = "";
                ht += ' <div class="row">';
                ht +=
                    '     <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">';
                ht += '         <div class="card">';
                ht += '             <div class="card-body">';
                if (response.data != null) {
                    ht += '                 <div class="col-md-12 marg">';
                    ht +=
                        "                     <h3>La Nomina tiene " +
                        response.total_empleado +
                        " empleados registrados</h3>";
                    //ht += '                     <a href=""><i class="far fa-file-excel tam-excell"></i></a>'
                    ht += "                 </div>";
                    ht += '                 <div class="col-md-12 marg">';
                    ht +=
                        '                     <a target="_blank" href="/imprimir-pdf/' +
                        id_direccion +
                        "/" +
                        id_jefatura +
                        "/" +
                        fecha_inicio +
                        "/" +
                        fecha_fin +
                        "/" +
                        regimen_contractual +
                        '"><i class="far fa-file-pdf tam-pdf"></i></a>';
                    ht +=
                        '                     <a target="_blank" href="/imprimir-excel/' +
                        id_direccion +
                        "/" +
                        id_jefatura +
                        "/" +
                        fecha_inicio +
                        "/" +
                        fecha_fin +
                        "/" +
                        regimen_contractual +
                        '"><i class="far fa-file-excel tam-excell"></i></a>';
                    //ht += '                     <a href=""><i class="far fa-file-excel tam-excell"></i></a>'
                    ht += "                 </div>";
                }
                ht +=
                    '                 <table id="table-empleado" border="2" class="table ">';
                ht += '	                    <thead class="background-thead">';
                ht += '		                    <tr align="center">';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Foto</th>';
                ht +=
                    '			                    <th align="center" class="border-bottom-0 color-th">Cedula</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Funcionario</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Dirección</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Jefatura</th>';
                ht +=
                    '			                    <th align="center" class="border-bottom-0 color-th">Cargo</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Salario</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Telefono</th>';
                ht += "			                </tr>";
                ht += "		                </thead>";
                ht += "		                <tbody>";
                $(response.data).each(function (i, data) {
                    ht += "			        <tr>";
                    //ht += '				        <td class="color-td" align="center">foto</td>'
                    ht +=
                        '				        <td class="color-td" align="center"><img class="tam-ima-emp-ta" src="http://sgi.movilidadmanta.gob.ec/imagenes_empleados/' +
                        data.emp_ruta_foto +
                        '" alt=""></td>';
                    ht +=
                        '			            <td class="color-td" align="center">' +
                        data.emp_cedula +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.emp_nombre +
                        " " +
                        data.emp_apellido +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.dep_departamento +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.per_perfil +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.ca_cargo +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">$' +
                        data.emp_remuneracion +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.emp_telefono +
                        "</td>";
                    ht += "			        </tr>";
                });
                ht += "		                </tbody>";
                ht += "                 </table>";
                ht += "             </div>";
                ht += "         </div>";
                ht += "     </div>";
                ht += " </div>";
                $("#div-table-reporte-empleado").html(ht);

                $("#table-empleado").DataTable();
                $("#global-loader").removeClass("block");
                $("#global-loader").addClass("none");
            },
        });
    } else {
        $.ajax({
            url: "/get-reporte-empleado_ni/" + niveles,
            type: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response.data);
                var ht = "";
                ht += ' <div class="row">';
                ht +=
                    '     <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">';
                ht += '         <div class="card">';
                ht += '             <div class="card-body">';
                ht += '                 <div class="col-md-12 marg">';
                ht +=
                    "                     <h3>La Nomina tiene " +
                    response.total_empleado +
                    " empleados registrados</h3>";
                //ht += '                     <a href=""><i class="far fa-file-excel tam-excell"></i></a>'
                ht += "                 </div>";
                ht += '                 <div class="col-md-12 marg">';
                ht +=
                    '                     <a target="_blank" href="/imprimir-pdf_nivel/' +
                    niveles +
                    '"><i class="far fa-file-pdf tam-pdf"></i></a>';
                ht +=
                    '<a target="_blank" href="/imprimir-excel_nivel/' +
                    niveles +
                    '"><i class="far fa-file-excel tam-excell"></i></a>';
                //ht += '                     <a href=""><i class="far fa-file-excel tam-excell"></i></a>'
                ht += "                 </div>";
                ht +=
                    '                 <table id="table-empleado" border="2" class="table ">';
                ht += '	                    <thead class="background-thead">';
                ht += '		                    <tr align="center">';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Foto</th>';
                ht +=
                    '			                    <th align="center" class="border-bottom-0 color-th">Cedula</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Funcionario</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Correo</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Dirección</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Jefatura</th>';
                ht +=
                    '			                    <th align="center" class="border-bottom-0 color-th">Cargo</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Salario</th>';
                ht +=
                    '				                <th align="center" class="border-bottom-0 color-th">Telefono</th>';
                ht += "			                </tr>";
                ht += "		                </thead>";
                ht += "		                <tbody>";
                $(response.data).each(function (i, data) {
                    ht += "			        <tr>";
                    //ht += '				        <td class="color-td" align="center">foto</td>'
                    ht +=
                        '				        <td class="color-td" align="center"><img class="tam-ima-emp-ta" src="/imagenes_empleados/' +
                        data.emp_ruta_foto +
                        '" alt=""></td>';
                    ht +=
                        '			            <td class="color-td" align="center">' +
                        data.emp_cedula +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.emp_nombre +
                        " " +
                        data.emp_apellido +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.usu_correo +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.dep_departamento +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.per_perfil +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.emp_cargo +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">$' +
                        data.emp_remuneracion +
                        "</td>";
                    ht +=
                        '				        <td class="color-td" align="center">' +
                        data.emp_telefono +
                        "</td>";
                    ht += "			        </tr>";
                });
                ht += "		                </tbody>";
                ht += "                 </table>";
                ht += "             </div>";
                ht += "         </div>";
                ht += "     </div>";
                ht += " </div>";
                $("#div-table-reporte-empleado").html(ht);

                $("#table-empleado").DataTable();
                $("#global-loader").removeClass("block");
                $("#global-loader").addClass("none");
            },
        });
    }
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
