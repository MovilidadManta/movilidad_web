$(document).ready(function () {
    get_categoria_menu_t()
    var categoria = 0
    get_turismo_categoria_id(categoria)
})

/*INICIO DE FUNCION PARA LISTAR LAS CATEGORIAS*/
/*function get_categoria_menu() {
    $("#div-categoria").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Cargando..</span>")
    $.ajax({
        url: '/get-categoria-turismo',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<li class="list-group-item"><a class="color-btn btn-categoria" id="0"> Todas</a></li>'
                $(response.data).each(function (i, data) {
                    ht += '<li class="list-group-item"><a class="color-btn btn-categoria" id=' + data.ca_id + '>' + data.ca_categoria + '</a></li>'
                })
                $("#div-categoria").html(ht)
                $('.btn-categoria').click(function () {
                    get_turismo_categoria_id(this.id)
                })
            }
        }
    })
}*/
/*FIN DE FUNCON PARA LISTAR LAS CATEGORIAS*/


/*INICIO DE FUNCION PARA LISTAR LAS CATEGORIAS*/
function get_categoria_menu_t() {
    $("#div-categoria").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Cargando..</span>")
    $.ajax({
        url: '/get-categoria-turismo',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<div class="btn-group-vertical w" role="group" aria-label="Vertical radio toggle button group">'
                ht += '<input type="radio" class="btn-check" id="0" autocomplete="off" checked="">'
                ht += '<label class="list-group-item btn la btn-outline-danger btn-categoria-t" id="0" for="vbtn-radio1">TODAS</label>'
                $(response.data).each(function (i, data) {
                    ht += '<input type="radio" class="btn-check color-btn btn-categoria-c" id=' + data.ca_id + ' autocomplete="off">'
                    ht += '<label class="list-group-item btn btn-outline-danger color-btn btn-categoria-t" id=' + data.ca_id + ' for="vbtn-radio1">' + data.ca_categoria + '</label>'
                })
                ht += '</div>'

                /*ht += '<li class="list-group-item"><a class="color-btn btn-categoria-t" id="0"> Todas</a></li>'
                $(response.data).each(function (i, data) {
                    ht += '<li class="list-group-item"><a class="color-btn btn-categoria-t" id=' + data.ca_id + '>' + data.ca_categoria + '</a></li>'
                })*/
                $("#div-categoria").html(ht)
                $('.btn-categoria-t').click(function () {
                    get_turismo_categoria_id(this.id)
                })
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS CATEGORIAS*/


/*INICIO DE FUNCION PARA LISTA TURISMO */
function get_turismo_categoria_id(cat) {
    $("#div-table-turismo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Cargando..</span>")
    console.log("listar turismos")
    $.ajax({
        url: '/get-turismo-t/' + cat,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                $(response.data).each(function (i, data) {
                    ht += ' <div class="col-12 col-sm-12 hei">'
                    ht += '     <div class="row g-0">'
                    ht += '         <div class="col-md-4">'
                    ht += '             <img src="/imagenes_turismo/' + data.tu_ruta_foto + '" class="img-fluid rounded-start tam-img-turismo zoom" alt="...">'
                    ht += '         </div>'
                    ht += '         <div class="col-md-8">'
                    ht += '             <div class="card-body">'
                    ht += '                 <h5 class="card-title color-titu-pag">' + data.tu_titulo + '</h5>'
                    ht += '                     <p class="card-text justify parrafo-tu">' + data.tu_descripcion + '</p>'
                    //ht += '                     <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>'
                    ht += '                     <a class="btn-noticia btn-ri" href="/turismo-id/' + data.tu_id + '" target="_blank">Ver mas</a>'
                    ht += '             </div>'
                    ht += '          </div>'
                    ht += '       </div>'
                    ht += '     </div>'
                })
                $("#div-table-turismo").html(ht)

                /* INICIO CLICK PARA ABRIR EL MODAL DE ELIMINAR TURISMO */
                $(".btn-modal-eliminar").click(function () {
                    var id = this.id
                    var id_ = id.split('-')
                    $("#txt-id-turismo").val(id_[0])
                    $("#txt-foto-anterior-e").val(id_[1])
                    $("#modal-turismo-e").modal("show")
                })
                /* FIN CLICK PARA ABRIR EL MODAL DE ELIMINAR TURISMO*/

                /*INICIO CLICK PARA ABRIR EL MODAL DE ACTUALIZAR TURISMO*/
                $(".btn-modal-editar").click(function () {
                    $("#txt-id-turismo-m").val(this.id)
                    get_turismos_id(this.id)
                })
                /*FIN CLICK PARA ABRIR EL MODAL DE ACTUALIZAR  TURISMO*/

            }
            $("#table-turismo").DataTable()
            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    })
}
/*FIN DE FUNCION PARA LISTAR TURISMO */

