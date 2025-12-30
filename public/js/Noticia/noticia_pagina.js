$(document).ready(function () {
    noticia(1, 0, 4)
})

$(".btn-paginacion").click(function () {
    $("#div-noticia-paginacion").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Cargando Información de Noticias...</span>")
    var id = this.id
    const id_ = id.split('-');
    noticia(id_[0], id_[1], id_[2])
})

/*INICIO DE FUNCION PARA LISTAR NOTICIAS EN PAGINACION */
function noticia(id, desde, hasta) {
    let no_tipo = document.getElementById('no_tipo').value;
    let url_web = document.getElementById('url_web').value;
    $("#div-noticia-paginacion").html("<span class='spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span > Cargando Información de Noticias...</span>")
    console.log("listar noticias paginacion")
    $.ajax({
        url: '/get-noticia-paginacion/' + id + '/' + desde + '/' + hasta + '/' + no_tipo,
        type: "GET",
        dataType: "json",
        success: function (response) {
            var ht = ''
            $(response.data).each(function (i, data) {
                ht += `
                    <div class="rt-col-md-3 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no" data-id="1943">
                        <div class="rt-holder sha-no">
                            <div class="rt-img-holder">
                                <a class="" href="/noticia/${data.id_noticia_hash}/${no_tipo}" target="_blank">
                                    <img src="/imagenes_noticias/${data.no_ruta_foto}" class="img-border-ra tam-img-no rt-img-responsive jetpack-lazy-image--handled" alt="" data-lazy-loaded="1" loading="eager">
                                </a>
                            </div>
                            <div class="rt-detail pad-no pad-h">
                                <h5 class="entry-title text-ali-titu">
                                    <a class="color-ti" target="_blank" href="/noticia/${data.id_noticia_hash}/${no_tipo}">${data.no_titulo}</a>
                                </h5>
                                <div class="post-meta-user  "><span class="date"><i class="fa fa-clock-o"></i><strong>${data.no_fecha}</strong></span></div>
                                <div class="tpg-excerpt">
                                    <p class="text-ali-des">${data.no_descripcion}</p>
                                </div>
                                <div class="btn-le">
                                    <span class="btn-social btn-social-facebook">
                                        <a href="http://www.facebook.com/sharer.php?u=${url_web}/noticia/${data.id_noticia_hash}/${no_tipo}&t=Noticia ${no_tipo == 1 ? 'DTM' : 'TTM'}: ${data.no_titulo}" target="_blank" class="facebook">
                                            <i class="fa fa-facebook-official" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>
                                <div class="btn-le">
                                    <span class="btn-social btn-social-twitter">
                                        <a href="https://twitter.com/intent/tweet?text=Noticia ${no_tipo == 1 ? 'DTM' : 'TTM'}: ${data.no_titulo}&url=${url_web}/noticia/${data.id_noticia_hash}/${no_tipo}&via=${no_tipo == 1 ? 'MantaAMT' : 'TerminaldeManta'}&hashtags=#ElCambioSigue" target="_blank" class="twitter">
                                            <i class="fa fa-twitter-square" aria-hidden="true"></i>
                                        </a>
                                    </span>
                                </div>
                                <div class="post-meta btn-ri">
                                    <span class="read-more">
                                        <a class="btn-noticia" href="/noticia/${data.id_noticia_hash}/${no_tipo}" target="_blank">Leer más</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            })
            $('#div-noticia-paginacion').html(ht)
        }
    })
}
/*FIN DE FUNCION PARA LISTAR NOTICIAS EN PAGINACION */

