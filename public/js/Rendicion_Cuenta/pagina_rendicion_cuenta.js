$(document).ready(function () {
    get_literal_rendicion_cuenta($("#id-rendicion-cuenta").val(), $("#year-rendicion-cuenta").val())
})

$(".btn-pagina-año").click(function () {
    var id_lotaip = this.id
    var id_lo = id_lotaip.split('-')
    //alert('hola'+id_lotaip)

    get_literal_rendicion_cuenta(id_lo[0], id_lo[1])
})

/*INICIO DE FUNCION PARA LISTAR LOTAIP */
function get_literal_rendicion_cuenta(id, año) {
    $('#v-pills-' + año).html("")
    $(".cargando").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Cargando Información...</span>")
    $.ajax({
        url: '/get-literal-rendicion-cuenta-id/' + id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            var ht = ''
            $(response.data_meses).each(function (i, datam) {
                ht += '<div class="accordion-item">'
                ht += '     <h2 class="accordion-header" id="heading-' + datam + '">'
                if (datam == 1) {
                    ht += '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' + datam + '" aria-expanded="false" aria-controls="collapseOne">'
                    ht += '         Fase 1 Planificación y facilitación del proceso desde la asamblea ciudadana'
                    ht += '     </button>'
                } else if (datam == 2) {
                    ht += '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' + datam + '" aria-expanded="false" aria-controls="collapseOne">'
                    ht += '         Fase 2 Evaluación de la gestión y redacción del informe de la institución'
                    ht += '     </button>'
                } else if (datam == 3) {
                    ht += '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' + datam + '" aria-expanded="false" aria-controls="collapseOne">'
                    ht += '          Fase 3 Evaluación del Informe Institucional'
                    ht += '     </button>'
                } else if (datam == 4) {
                    ht += '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' + datam + '" aria-expanded="false" aria-controls="collapseOne">'
                    ht += '          Fase 4: Incorporación de la Opinión Ciudadana'
                    ht += '     </button>'
                } else if (datam == 5) {
                    ht += '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' + datam + '" aria-expanded="false" aria-controls="collapseOne">'
                    ht += '         Resoluciones'
                    ht += '     </button>'
                } else if (datam == 6) {
                    ht += '     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' + datam + '" aria-expanded="false" aria-controls="collapseOne">'
                    ht += '         Anexos'
                    ht += '     </button>'
                }
                ht += '  </h2>'
                ht += '     <div id="collapse-' + datam + '" class="accordion-collapse collapse color" aria-labelledby="headingOne" data-bs-parent="#accordionExample">'
                ht += '         <div class="accordion-body">'
                $(response.data).each(function (i, data) {
                    if (data.rcd_id_fase == datam) {
                        ht += '     <table class="table" border="0">'
                        ht += '         <tbody>'
                        ht += '             <tr>'
                        ht += '                 <td style="padding: 2px !important;vertical-align: middle !important;" width="90%">'
                        ht += '                     <ul class="ul-pad">'
                        ht += '                         <li>' + data.lrc_literal + '</li>'
                        ht += '                     </ul>'
                        ht += '                 </td>'
                        if (data.rcd_extension_archivo == "pdf") {
                            ht += '                 <td width="10%"><a href="/archivos_rendicion_cuenta/' + data.rcd_ruta_archivo + '" target="_blank"><img class="aligncenter" style="color: #f44336; max-width: 40%;" src="/Imagenes/pdf.png"></a></td>'
                        } else if (data.rcd_extension_archivo == "xlsx") {
                            ht += '                 <td width="10%"><a href="/archivos_rendicion_cuenta/' + data.rcd_ruta_archivo + '" target="_blank"><img class="aligncenter" style="color: #f44336; max-width: 40%;" src="https://web.movilidadmanta.gob.ec/wp-content/uploads/2022/04/sobresalir.png" /></a></td>'
                        }
                        ht += '              </tr>'
                        ht += '         </tbody>'
                        ht += '       </table>'
                    }
                })
                ht += '          </div>'
                ht += '     </div>'
                ht += '</div>'
            })
            $('#v-pills-' + año).html(ht)
            $(".cargando").html("")
        }
    })
}
/*FIN DE FUNCION PARA LISTAR LOTAIP */

