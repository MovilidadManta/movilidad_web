$(document).ready(function () {
    get_ip()
})


/*INICIO DE FUNCION PARA LISTAR IP */
function get_ip() {
    $("#div-table-catalogo").html("<span class='color-btn-nuevo spinner-border spinner-border-sm margin-spiner' role='status' aria-hidden='true'></span><span class='color-btn-nuevo'> Cargando..</span>")
    $("#global-loader").removeClass("none");
    $("#global-loader").addClass("block");
    $.ajax({
        url: '/get-ip',
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            var ht = ""
            ht += '  <table id="table-ip" border="2" class="table tam-tabl dataTable no-footer">'
            ht += '	    <thead class="background-thead">'
            ht += '		    <tr align="center">'
            ht += '				<th align="center" class="border-bottom-0 color-th">Nombres</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Categoría</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Marca</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">Modelo</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">MAC ETHERNET</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">MAC WIFI</th>'
            ht += '				<th align="center" class="border-bottom-0 color-th">IP</th>'
            ht += '			</tr>'
            ht += '		</thead>'
            ht += '		<tbody>'
            $(response.data).each(function (i, data) {
                ht += '			<tr>'
                if(data.emp_apellido== null){
                ht += '			    <td align="center" class="color-td">SIN INFORMACIÓN</td>'
                }else{
                    ht += '			    <td align="center" class="color-td">' + data.emp_apellido + ' '+data.emp_nombre+'</td>'
                }
                if (data.cat_categoria == 0) {
                    ht += '			    <td align="center" class="color-td">SC</td>'
                } else if (data.cat_categoria == 1) {
                    ht += '			    <td align="center" class="color-td">LAPTOP</td>'
                } else if (data.cat_categoria == 2) {
                    ht += '			    <td align="center" class="color-td">IMPRESORA</td>'
                } else if (data.cat_categoria == 3) {
                    ht += '			    <td align="center" class="color-td">MOUSE</td>'
                } else if (data.cat_categoria == 4) {
                    ht += '			    <td align="center" class="color-td">ROUTER</td>'
                } else if (data.cat_categoria == 5) {
                    ht += '			    <td align="center" class="color-td">TECLADO</td>'
                } else if (data.cat_categoria == 6) {
                    ht += '			    <td align="center" class="color-td">MONITOR</td>'
                } else if (data.cat_categoria == 7) {
                    ht += '			    <td align="center" class="color-td">CONVERTIDOR</td>'
                } else if (data.cat_categoria == 8) {
                    ht += '			    <td align="center" class="color-td">UPS</td>'
                } else if (data.cat_categoria == 9) {
                    ht += '			    <td align="center" class="color-td">REGULADOR</td>'
                } else if (data.cat_categoria == 10) {
                    ht += '			    <td align="center" class="color-td">TV</td>'
                } else if (data.cat_categoria == 11) {
                    ht += '			    <td align="center" class="color-td">SWICH O COMMUTADOR</td>'
                } else if (data.cat_categoria == 12) {
                    ht += '			    <td align="center" class="color-td">SERVIDOR</td>'
                } else if (data.cat_categoria == 13) {
                    ht += '			    <td align="center" class="color-td">ACCES POINTS</td>'
                } else if (data.cat_categoria == 14) {
                    ht += '			    <td align="center" class="color-td">DISCO DURO</td>'
                } else if (data.cat_categoria == 15) {
                    ht += '			    <td align="center" class="color-td">MEMORIA RAM</td>'
                } else if (data.cat_categoria == 16) {
                    ht += '			    <td align="center" class="color-td">FUENTE</td>'
                } else if (data.cat_categoria == 17) {
                    ht += '			    <td align="center" class="color-td">CPU</td>'
                } else if (data.cat_categoria == 18) {
                    ht += '			    <td align="center" class="color-td">PARLANTES</td>'
                } else if (data.cat_categoria == 19) {
                    ht += '			    <td align="center" class="color-td">SCANNER</td>'
                } else if (data.cat_categoria == 20) {
                    ht += '			    <td align="center" class="color-td">SERVIDOR</td>'
                } else if (data.cat_categoria == 21) {
                    ht += '			    <td align="center" class="color-td">LECTOR DE HUELLA</td>'
                } else if (data.cat_categoria == 22) {
                    ht += '			    <td align="center" class="color-td">BIOMETRICO</td>'
                }
                ht += '			    <td align="center" class="color-td">' + data.cat_marca + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.cat_modelo + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.cat_mac_ethernet + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.cat_mac_wifi + '</td>'
                ht += '			    <td align="center" class="color-td">' + data.cat_ip + '</td>'
                ht += '			</tr>'
            })
            ht += '		</tbody>'
            ht += '  </table>'
            $("#div-table-ip").html(ht)

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
            $("#table-ip").DataTable()
        }

    })

}
/*FIN DE FUNCION PARA FUNCION PARA LISTAR CATALOGOS*/



