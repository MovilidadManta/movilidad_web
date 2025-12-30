$("#btn-reporte-test").click(function () {
    $("#btn-reporte-test").html("<span class='spinner-border spinner-border-sm margin-spiner color-btn-nuevo'></span><span class='color-btn-nuevo'> Buscando...!</span>");
    $("#div-table-test").html("<span class='spinner-border spinner-border-sm margin-spiner'></span><span > Cargando la información... espere un momento....</span>");
    var fecha_inicio = $("#select-fecha-inicio").val()
    var fecha_fin = $("#select-fecha-fin").val()

    $.ajax({
        url: '/get-test/' + fecha_inicio + '/' + fecha_fin,
        type: "GET",
        dataType: "json",
        success: function (response) {
            // Check if there is data returned from the server
            if (response.respuesta == true) {
                var ht = ""
                ht += '<div class="card">';
                ht += '<div class="card-body">';
                ht += '             <div class="col-md-12 marg">';
                ht += '                 <a target="_blank" href="/imprimir-pdf-ficha/' + fecha_inicio + "/" + fecha_fin + '"><i class="far fa-file-pdf tam-pdf"></i></a>';
                ht += '                 <a target="_blank" href="/imprimir-excel-ficha/' + fecha_inicio + "/" + fecha_fin + '"><i class="far fa-file-excel tam-excell"></i></a>';
                //ht += '                     <a href=""><i class="far fa-file-excel tam-excell"></i></a>'
                ht += "             </div>";
                ht += '  <div class="table-responsive">'
                ht += '  <table id="table-test" border="2" class="table">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '			    <th align="center" class="border-bottom-0 color-th">ID</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">PROYECTO</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">CEDULA</th>'
                ht += '			    <th align="center" class="border-bottom-0 color-th">NOMBRES</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">FECHA DE TEST</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">CALIFICACIÓN</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '				<td align="center" class="color-td">' + data.id + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.proyecto + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.emp_cedula + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.nombre_completo + '</td>'
                    ht += '				<td align="center" class="color-td">' + data.date_end_test + '</td>'
                    ht += '				<td align="center" class="color-td">' + Number.parseFloat(data
                        .total_calificacion)
                        .toFixed(2) + '</td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                ht += '</div>'
                ht += '</div>';
                ht += '</div>';
                $("#div-table-test").html(ht)
                $('#table-test').DataTable();
                $("#btn-reporte-test").html("<i class='fa fa-search color-btn-nuevo'></i><strong class='color-btn-nuevo'> Buscar</strong>");
            } else {
                alert('No data found!');
                $("#btn-reporte-test").html("<i class='fa fa-search color-btn-nuevo'></i><strong class='color-btn-nuevo'> Buscar</strong>");
                $("#div-table-test").html("");
            }
        },
        error: function () {
            alert('Error retrieving data');
            $("#btn-reporte-test").html("<i class='fa fa-search color-btn-nuevo'></i><strong class='color-btn-nuevo'> Buscar</strong>");
            $("#div-table-test").html("");
        }
    });
});