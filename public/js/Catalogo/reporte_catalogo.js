$(document).ready(function () {
   
})

$("#btn-reporte-empleado").click(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    get_catalogo_reporte()
})

/*INICIO DE FUNCION PARA LISTAR EN REPORTE DE LOS catalogoS POR FECHAS*/
function get_catalogo_reporte() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    var id_categoria = $("#select-categoria").val()
    var id_area = $("#select-area").val()
    var id_estado = $("#select-estado").val()

    $.ajax({
        url: '/get-reporte-catalogo/' + id_categoria + '/' + id_area + '/' + id_estado ,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            var ht = ""
            ht += ' <div class="row">'
            ht += '     <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">'
            ht += '         <div class="card">'
            ht += '             <div class="card-body">'
            if (response.data != null) {
                ht += '                 <div class="col-md-12 marg">'
                ht += '                     <h3>Existen '+response.total_equipo+' equipos de computacion</h3>'
                //ht += '                     <a href=""><i class="far fa-file-excel tam-excell"></i></a>'
                ht += '                 </div>'
                ht += '                 <div class="col-md-12 marg">'
                ht += '                     <a target="_blank" href="/imprimir-pdf-catalogo/' + id_categoria + '/' + id_area+ '/' + id_estado +'"><i class="far fa-file-pdf tam-pdf"></i></a>'
                ht += '                     <a target="_blank" href="/imprimir-excel-catalogo/' + id_categoria + '/' + id_area+ '/' + id_estado +'"><i class="far fa-file-excel tam-excell"></i></a>'
                //ht += '                     <a href=""><i class="far fa-file-excel tam-excell"></i></a>'
                ht += '                 </div>'
            }
            ht += '                 <table id="table-reporte-catalogo" border="2" class="table ">'
            ht += '	                    <thead class="background-thead">'
            ht += '		                    <tr align="center">'
            ht += '				                <th align="center" class="border-bottom-0 color-th">Codigo</th>'
            ht += '			                    <th align="center" class="border-bottom-0 color-th">categoria</th>'
            ht += '				                <th align="center" class="border-bottom-0 color-th">marca</th>'
            ht += '				                <th align="center" class="border-bottom-0 color-th">modelo</th>'
            ht += '				                <th align="center" class="border-bottom-0 color-th">descripcion</th>'
            ht += '			                    <th align="center" class="border-bottom-0 color-th">observacion</th>'
            ht += '			                </tr>'
            ht += '		                </thead>'
            ht += '		                <tbody>'
            $(response.data).each(function (i, data) {
                ht += '			        <tr>'
                //ht += '				        <td class="color-td" align="center">foto</td>'
                ht += '			            <td class="color-td" align="center">' + data.cat_codigo + '</td>'
                ht += '				        <td class="color-td" align="center">' + data.cat_categoria+'</td>'
                ht += '				        <td class="color-td" align="center">' + data.cat_marca + '</td>'
                ht += '				        <td class="color-td" align="center">' + data.cat_modelo + '</td>'
                ht += '				        <td class="color-td" align="center">' + data.cat_descripcion + '</td>'
                ht += '				        <td class="color-td" align="center">' + data.cat_observacion + '</td>'
                ht += '			        </tr>'
            })
            ht += '		                </tbody>'
            ht += '                 </table>'
            ht += '             </div>'
            ht += '         </div>'
            ht += '     </div>'
            ht += ' </div>'
            $("#div-table-reporte-catalogo").html(ht)

            $("#table-reporte-catalogo").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR EN REPORTE DE LOS EMPLEADOS POR FECHAS*/



