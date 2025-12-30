$(document).ready(function () {
    //$('.dropify').dropify();
    get_literal_lotaips()
})


/*INICIO DE FUNCION PARA LISTAR LITERAL LOTAIP */
function get_literal_lotaips() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    console.log("listar lotaip")
    $.ajax({
        url: '/get-literal-lotaip',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                ht += '  <table id="table-lotaip" border="2" class="table dataTable no-footer">'
                ht += '	    <thead class="background-thead">'
                ht += '		    <tr align="center">'
                ht += '				<th align="center" class="border-bottom-0 color-th">Id</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Literales</th>'
                ht += '				<th align="center" class="border-bottom-0 color-th">Opciones</th>'
                ht += '			</tr>'
                ht += '		</thead>'
                ht += '		<tbody>'
                $(response.data).each(function (i, data) {
                    ht += '			<tr>'
                    ht += '			    <td align="center" class="color-td">' + data.li_id + '</td>'
                    ht += '			    <td align="center" class="color-td">' + data.li_literal + '</td>'
                    ht += '				<td class="color-td" align="center">'
                    ht += '              <button type="button" id="' + data.li_id + '" class="tam-btn btn btn-warning btn-modal-editar"><i class="fa fa-edit tam-icono"></i></button>'
                    ht += '              <button type="button" id="' + data.li_id + '" class="tam-btn btn btn-danger btn-modal-eliminar"><i class="fa fa-trash tam-icono"></i></button>'
                    ht += '             </td>'
                    ht += '			</tr>'
                })
                ht += '		</tbody>'
                ht += '  </table>'
                $("#div-table-lotaip").html(ht)
                $("#table-lotaip").DataTable()

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR NOSOTROS (MISION Y VISION) */
                $(".btn-modal-eliminar").click(function () {
                    $("#txt-id-indicador").val(this.id)
                    $("#modal-eliminar-indicador").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR NOSOTROS (MISION Y VISION)*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR LITERAL LOTAIP*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-literal-lotaip-m").val(this.id)
                    get_literal_lotaip_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  LITERAL LOTAIP*/

            }
            $("#table-lotaip").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR LITERAL LOTAIP */

/**INICIO DE CLIC DEL BOTON DEL MODAL PARA AÑADIR EL LITERAL LOTAIP */
$('#btn-añadir-literal-lotaip').click(function () {
    $('#modal-literal-lotaip').modal('show')
})
/**FIN DE CLIC DEL BOTON DEL MODAL PARA AÑADIR EL LITERAL LOTAIP */

// INICIO BOTON CLICK PARA GUARDAR LOS DATOS DE LITERAL LOTAIP 
$('#btn-guardar-literal-lotaip').click(function () {
    var inp = $('#txt-literal').val()
    if ($('#txt-literal').val() == '') {
        notif({
            type: "warning",
            msg: "<b>Aviso: </b>Los campos están vacios",
            position: "right",
            autohide: false
        });
    }
    else {
        $("#btn-guardar-literal-lotaip").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Guardando..</span>")
        guardar_literal_lotaip()

    }
})

// FIN BOTON CLICK PARA GUARDAR LOS DATOS DE LITERAL LOTAIP 

/*INICIO FUNCION PARA GUARDAR LITERAL LOTAIP */
function guardar_literal_lotaip() {
    var token = $("#csrf-token").val();
    var datos = new FormData($("#form-literal-lotaip")[0]);
    $.ajax({
        url: '/registrar-literal-lotaip',
        type: 'POST',
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': token },
        contentType: false,
        processData: false,
        data: datos,
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == "true") {
                notif({
                    msg: "<b>Correcto:</b> Literal LOTAIP registrado",
                    type: "success"
                });
                $("#txt-literal-lotaip").val("")
                $("#modal-literal-lotaip").modal('hide')
                $("#btn-guardar-literal-lotaip").html("<i class='fa fa-save'></i> Guardar")
                get_literal_lotaips()
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
/*FIN FUNCION PARA GUARDAR LITERAL LOTAIP */


/*INICIO PARA FUNCION CONSULTAR LITERAL LOTAIP POR ID*/
function get_literal_lotaip_id(id_literal) {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    
    $.ajax({
        url: '/get-literal-lotaip-id/' + id_literal,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.respuesta == true) {
                $(response.data).each(function (i, data) {
                   
                    $("#txt-literal-m").val(data.li_literal)
                   
                })
                $("#modal-literal-lotaip-m").modal("show")
                $("#global-loader").addClass("none");
                $("#global-loader").removeClass("block");
            }
        }
    })
}
/*FIN PARA FUNCION CONSULTAR LITERAL LOTAIP POR ID*/