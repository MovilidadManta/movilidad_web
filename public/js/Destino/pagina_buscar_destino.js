$(document).ready(function () {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    get_destino_select()
    //get_cooperativa_select()
})

/*INICIO DE FUNCION PARA LISTAR LAS DESTINO*/
function get_destino_select() {
    $("#select-destino").html("<option value='0'>CARGANDO DESTINOS</option>")
    $.ajax({
        url: '/get-destino',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">TODOS</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.de_id + '>Manta - ' + data.de_destino + '</option>'
                })
                $("#select-destino").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS DESTINO*/


/*INICIO DE FUNCION PARA LISTAR LAS COOPERATIVAS*/
$("#select-destino").change(function () {
    get_cooperativa_select($("#select-destino").val())
})


function get_cooperativa_select(id_de) {
    $("#select-cooperativa").html("<option value='0'>CARGANDO COOPERATIVAS..</option>")
    $.ajax({
        url: '/get-destino-cooperativa/' + id_de,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                ht += '<option value="0">TODOS</option>'
                $(response.data).each(function (i, data) {
                    ht += '<option value=' + data.co_id + '>' + data.co_nombre + '</option>'
                })
                $("#select-cooperativa").html(ht)
            }
        }
    })
}
/*FIN DE FUNCON PARA LISTAR LAS COOPERATIVAS*/


$("#btn-buscar-destino").click(function () {
    $("#btn-buscar-destino").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Cargando Informacion..</span>")
    var id_de = $("#select-destino").val()
    var id_coop = $("#select-cooperativa").val()
    $.ajax({
        url: '/get-buscar-destino/' + id_de + '/' + id_coop,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            if (response.respuesta == true) {
                var ht = ''
                $(response.data).each(function (i, data) {
                    let horasSalida = '';
                    let horariosEncomienda = '';
                    let tableHorariosEncomienda = '';
                    let datosCopperativa = '';

                    datosCopperativa = `
                        <h5 class="color-titu-pag" align="center"><strong>Datos de la Cooperativa</strong></h5>
                        <table class="table">
                            <tr>
                                <td width='20%' class="color-titu-pag"><strong> Telefono:</strong></td>
                                <td width='30%'>
                    `;

                    if (data.co_celular.trim().length > 2) {
                        datosCopperativa += `
                            <span class="btn-social btn-social-whatsapp">
                                <a href="https://api.whatsapp.com/send?text=Buenas tardes, estimados señores ${data.co_nombre}, tengo una consulta&phone=+593${data.co_celular.substring(1)}" target="_blank" class="whatsapp">
                                    <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                </a>
                            </span>
                        `;
                    }

                    datosCopperativa += `
                            ${data.co_celular} - ${data.co_convencional}
                            </td>
                                <td width='20%' class="color-titu-pag"><strong>Email:</strong></td>
                                <td width='30%'>${data.co_correo}</td>
                            </tr>
                        </table>
                        <table class="table">
                            <tr>
                                <td class="color-titu-pag" width="20%"><strong> Ubicación:</strong></td>
                                <td width="80%">${data.co_ubicacion}</td>
                            </tr>
                        </table>
                    `;

                    $(data.data_hora_salida).each(function (i, data) {
                        horasSalida += `<div class="col-md-5  color-hora" align="center">${data.hs_hora_salida}</div>`;
                    });

                    $(data.data_horarios_encomienda).each(function (i, ho) {
                        horariosEncomienda += `
                            <tr>
                                <td width="30%" class="color-td" align="center">${ho.ho_dias}</td>
                                <td width="30%" class="color-td" align="center">${ho.ho_desde} - ${ho.ho_hasta}</td>
                                <td width="30%" class="color-td" align="center">${data.co_ubicacion_encomienda}</td>
                            </tr>`;
                    });

                    tableHorariosEncomienda = `
                        <div class="card-title color-titu-pag">
                            <h5 class="marg-b" align="center"><strong><i class="fa fa-archive"></i> Horarios de Encomienda</strong></h5>
                        </div>
                        <div class="col-md-12">
                            <table border="1" class="table table-bor">
                                <thead class="background-thead pad">
                                    <tr align="center">
                                        <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-sun-o"></i> Días:</strong></th>
                                        <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-clock-o"></i> Horario</strong></th>
                                        <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-map-marker"></i> Ubicación</strong></th>
                                    </tr>
                                </thead>
                                <tbody style="border-top: 2px solid #fff;">
                                    ${horariosEncomienda}
                                </tbody>
                            </table>
                        </div>
                    `;

                    ht += ` 
                    <div class="rt-col-md-12 rt-col-sm-6 rt-col-xs-12 even-grid-item rt-grid-item margin-b-no">
                        <div class="rt-holder sha-no">
                            <div class="rt-detail pad-25">
                                <div class="row">
                                    <div class="card-title color-titu-pag">
                                        <h5 class="marg-b" align="center"><strong><i class="fa fa-bus"></i> ${data.co_nombre}</strong></h5>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4 offset-md-4 boton-h">
                                            <img src="/imagenes_cooperativa/${data.co_ruta_foto}" alt="">
                                        </div>
                                        ${datosCopperativa}
                                        <h5 class="color-titu-pag" align="center"><strong>Destinos</strong> </h5>
                                        <table border="1" class="table table-bor">
                                            <thead class="background-thead pad">
                                                <tr align="center">
                                                    <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-road"></i> Ruta: </strong></th>
                                                    <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-clock-o"></i> Horas de Salida:</strong></th>
                                                    <th align="center" class="border-bottom-0 color-th pad"><strong><i class="fa fa-dollar"></i> Precio: </strong></th>
                                                </tr>
                                            </thead>
                                            <tbody style="border-top: 2px solid #fff;">
                                                <tr>
                                                    <td width="30%" class="color-td" align="center">Manta - ${data.de_destino}</td>
                                                    <td width="30%" class="color-td" align="center">
                                                        <div class="container">
                                                            <div class="row ">
                                                                <div class="col-md-12 offset-md-0">
                                                                    <div class="row offset-md-1">
                                                                        ${horasSalida}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td width="30%" class="color-td" align="center">$${parseFloat(data.dc_precio).toFixed(2)}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    ${horariosEncomienda != '' ? tableHorariosEncomienda : ''}
                                </div>
                            </div>
                        </div>
                    </div>

                    `;
                })
                $("#div-destino").html(ht)
                $("#btn-buscar-destino").html("<i class='fa fa-search color-btn-nuevo'></i><strong class='color-btn-nuevo'> Buscar</strong>")
            }
        }
    })
})

