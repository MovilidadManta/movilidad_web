$(document).ready(function () {

})

$("#btn-reporte-empleado").click(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    get_consolidado_reporte()
})

/*INICIO DE FUNCION PARA LISTAR EN REPORTE DE LOS INDICADORES*/
function get_consolidado_reporte() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar empleado")
    var fecha_inicio = $("#select-fecha-inicio").val()
    var fecha_fin = $("#select-fecha-fin").val()
    $.ajax({
        url: '/get-reporte-consolidado/' + fecha_inicio + '/' + fecha_fin,
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
                ht += '                     <a target="_blank" href="/imprimir-pdf/' + $("#select-fecha-inicio").val() + '/' + $("#select-fecha-fin").val() + '"><i class="far fa-file-pdf tam-pdf"></i></a>'
                //ht += '                     <a href=""><i class="far fa-file-excel tam-excell"></i></a>'
                ht += '                 </div>'
            }
            $(response.data_year).each(function (i, data_year) {
                $(response.data_mes).each(function (i, data_mes) {
                    ht += '<table border="2" class="table table-bordered">'
                    ht += '<tr>'
                    ht += '    <th>' + data_year.year + '- ' + data_mes.mes + '</th>'
                    ht += '</tr>'
                    ht += '</table>'
                    $(response.data_jefatura).each(function (i, data_jefatura) {
                        ht += '<table border="2" class="table table-bordered">'
                        ht += '<tr>'
                        ht += '    <th rowspan="4" width="15%" class="midle">' + data_jefatura.jefatura + '</th>'
                        ht += '</tr>'

                        $(response.data_indicador).each(function (i, data_indicador) {
                            if (data_indicador.id_indicador == data.in_id) {
                                ht += '<tr>'
                                ht += '    <td class="pad-td">'
                                ht += '        <table border="0" cellpadding="1" class="table table-bordered mar-bot">'
                                ht += '            <tr>'
                                ht += '                <th rowspan="4" width="50%" class="midle">' + data.in_indicador + '</th>'
                                ht += '            </tr>'
                                ht += '            <tr>'
                                ht += '                <td width="30%">INTRAPROVINCIAL</td>'
                                ht += '                <td width="10%">02 JUNIO</td>'
                                ht += '                <td width="10%">14615</td>'
                                ht += '            </tr>'
                                ht += '            <tr>'
                                ht += '                <td width="30%">INTERPROVINCIAL</td>'
                                ht += '                <td width="10%">02-JUNIO</td>'
                                ht += '                <td width="10%">20879</td>'
                                ht += '            </tr>'
                                ht += '            <tr>'
                                ht += '                <td width="30%">ALTOS FLUJOS</td>'
                                ht += '                <td width="10%">02-JUNIO</td>'
                                ht += '                <td width="10%">6263</td>'
                                ht += '            </tr>'
                                ht += '        </table>'
                                ht += '    </td>'
                                ht += '</tr>'
                            }
                        })
                        ht += '</table>'
                    })
                })
            })
            ht += '             </div>'
            ht += '         </div>'
            ht += '     </div>'
            ht += ' </div>'
            $("#div-table-reporte-consolidado").html(ht)

            $("#table-consolidado").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR EN REPORTE DE LOS INDICADORES*/
