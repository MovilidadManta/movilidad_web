$(document).ready(function () {
   

    get_categoria_menu_c()
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
function get_categoria_menu_c() {
    $("#div-categoria").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Cargando..</span>")
    $.ajax({
        url: '/get-categoria-centro-comercial',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<div class="btn-group-vertical w" role="group" aria-label="Vertical radio toggle button group">'
                ht += '<input type="radio" class="btn-check" id="0" autocomplete="off" checked="">'
                ht += '<label class="list-group-item btn la btn-outline-danger btn-categoria-c" id="0" for="vbtn-radio1">TODAS</label>'
                $(response.data).each(function (i, data) {
                    ht += '<input type="radio" class="btn-check color-btn btn-categoria-c" id=' + data.ca_id + ' autocomplete="off">'
                    ht += '<label class="list-group-item btn btn-outline-danger color-btn btn-categoria-c" id=' + data.ca_id + ' for="vbtn-radio1">' + data.ca_categoria + '</label>'
                })
                ht += '</div>'


                /*ht += '<li class="list-group-item"><a class="color-btn btn-categoria-c" id="0"> TODAS</a></li>'
                $(response.data).each(function (i, data) {
                    ht += '<li class="list-group-item"><a class="color-btn btn-categoria-c" id=' + data.ca_id + '>' + data.ca_categoria + '</a></li>'
                })*/
                $("#div-categoria").html(ht)
                $('.btn-categoria-c').click(function () {
                    get_turismo_categoria_id(this.id)
                })
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS CATEGORIAS*/

/*INICIO DE FUNCION PARA LISTA TURISMO */
function get_turismo_categoria_id(cat) {
    $("#div-table-turismo").html("<div class='col-md-12'><span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo '> Cargando Informacion.. Por favor respere...</span> </div>")
    console.log("listar turismos")
    $.ajax({
        url: '/get-turismo-c/' + cat,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ""
                $(response.data).each(function (i, data) {
                    ht += '   <div class="col-sm-4 ">';
                    ht += '       <div class="row g-0 hei-comercial">';
                    ht += '           <div class="tam-im-comercio">';
                    ht +=
                        '               <img src="/imagenes_turismo/' +
                        data.tu_ruta_foto +
                        '" class="img-fluid rounded-start tam-img-comercial" alt="...">';
                    ht += '           </div>'
                    ht += '           <div class="col-md-12">'
                    ht += '               <div class="card-body">'
                    ht += '                   <h5 class="card-title color-titu-pag tex-alig-comer">' + data.tu_titulo + '</h5>'
                    ht += '                   <p class="card-text justify tex-alig-parra-comer">' + data.tu_descripcion + '</p>'
                    ht += '                   <p class="card-text tam-mar-local"><small class="text-muted"></small></p>'
                    ht += '                   <a class="btn-noticia btn-ri btn-mar-com" href="/centro-comercial-id/' + data.tu_id + '" target="_blank">Ver mas</a>'
                    ht += '                </div>'
                    ht += '            </div>'
                    ht += '       </div>'
                    ht += '   </div>'
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