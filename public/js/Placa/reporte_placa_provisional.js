$(document).ready(function () {

})

$("#btn-reporte-placa-provisional").click(function () {
    $("#btn-reporte-placa-provisional").html("<span class='spinner-border spinner-border-sm margin-spiner color-btn-nuevo'></span><span class='color-btn-nuevo'> Buscando...!</span>");
    $("#div-table-placa-provisional").html("<span class='spinner-border spinner-border-sm margin-spiner'></span><span > Cargando la información... espere un momento....</span>");
    var fecha_inicio = $("#select-fecha-inicio").val()
    var fecha_fin = $("#select-fecha-fin").val()

    $.ajax({
        url: '/get-placa-provisional/' + fecha_inicio + '/' + fecha_fin,
        type: "GET",
        dataType: "json",
        success: function (response) {
            // Check if there is data returned from the server
            if (response.respuesta) {
                var ht = ""
                ht += '<div class="card">';
                ht += '<div class="card-body">';
                ht += '  <div class="table-responsive">'
                ht += '  <table id="table-placa-provisional" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Id</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Placa</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">CI Propietario</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">Propietario</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Fecha</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Usuario</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">estado</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '				<td align="center" class="color-td">' + data.pp_id + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.pp_placa + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.pp_cedula_propietario + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.pp_nombre_propietario + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.pp_fecha_created + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.pp_id_usuario + '</td>'
                    if (data.pp_estado == "A") {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-success me-1">Aprobado</span></td>'
                    } else if (data.pp_estado == "P") {
                        ht += '				<td align="center" class="color-td"><span class="badge bg-danger me-1">Pendiente</span></td>'
                    }
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                ht += '</div>'
                ht += '</div>';
                ht += '</div>';
                $("#div-table-placa-provisional").html(ht)
                $('#table-placa-provisional').DataTable();
                $("#btn-reporte-placa-provisional").html("<i class='fa fa-search color-btn-nuevo'></i><strong class='color-btn-nuevo'> Buscar</strong>");
            } else {
                alert('No data found!');
                $("#btn-reporte-placa-provisional").html("<i class='fa fa-search color-btn-nuevo'></i><strong class='color-btn-nuevo'> Buscar</strong>");
                $("#div-table-placa-provisional").html("");
            }
        },
        error: function () {
            alert('Error retrieving data');
            $("#btn-reporte-placa-provisional").html("<i class='fa fa-search color-btn-nuevo'></i><strong class='color-btn-nuevo'> Buscar</strong>");
            $("#div-table-placa-provisional").html("");
        }
    });
});
