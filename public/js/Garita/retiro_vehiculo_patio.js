const select_tipo_ingreso = document.getElementById("select_tipo_ingreso");
const btn_search_vehiculos = document.getElementById("btn_search_vehiculos");
const fecha_inicio = document.getElementById("select_fecha_inicio");
const fecha_fin = document.getElementById("select_fecha_fin");

$(document).ready(function () {
    configure_select_two_dates('select_fecha_inicio', 'select_fecha_fin');
    fecha_inicio.value = `${fecha_inicio.valueAsDate.getFullYear()}-${(fecha_inicio.valueAsDate.getMonth() + 1).toString().padStart(2, '0')}-01`;
    getConfTipoIngresoVehicular();
});

btn_search_vehiculos.addEventListener("click", () => {
    getRetiroVehiculoPatio();
});

function getConfTipoIngresoVehicular() {
    select_tipo_ingreso.innerHTML = "<option value='0'>TODOS</option>";
    $.ajax({
        url: `/garita/tipo_ingreso_vehicular/list_habilitados`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            response.forEach(r => {
                select_tipo_ingreso.innerHTML += `<option value="${r.tiv_id}">${r.tiv_nombre}</option>`;
            });
        }
    });
}

function getRetiroVehiculoPatio() {
    $("#global-loader").addClass("block");
    $("#global-loader").removeClass("none");
    $.ajax({
        url: `/garita/retiro_vehiculo_patio/list/${fecha_inicio.value.replaceAll("-", "")}/${fecha_fin.value.replaceAll("-", "")}/${select_tipo_ingreso.value}`,
        type: "GET",
        dataType: "json",
        success: function (response) {
            console.log(response);
            let html = configureTableHtml("table_retiro_patio_vehiculo",
                ['#', 'TIPO DE INGRESO', 'TIPO DE VEHÍCULO', 'PLACA', 'C.I PROPIETARIO', 'DESCRIPCIÓN', 'FECHAS', 'VALOR', 'OPCIONES'
                ],
                ['ivp_id', 'tiv_nombre', 'tv_nombre', 'ivp_vehiculo_placa',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `${item.ivp_conductor_identificacion} -> ${item.ivp_conductor_nombres}`;
                        }
                    },
                    'ivp_descripcion',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            let render = `<p><b class="tittle_ingresado">Ingresado:</b> ${item.ivp_fecha_update}</p>`;
                            if (item.rvp_fecha_retiro) render += `<p><b>Salida:</b> ${item.rvp_fecha_retiro}</p>`;
                            return render;
                        }
                    },
                    'tv_valor',
                    {
                        align: 'center',
                        class: 'color-td',
                        functionValue: function (item) {
                            return `
                            <button type="button" class="btn btn-info" Onclick ='show_documentos_iv(${item.ivp_id})'>Liquidar con descuento</button>
                            <button type="button" class="tam-btn btn btn-info" Onclick ='show_documentos_vehiculo(${item.ivp_id},${item.tiv_id})'><div class="tooltip"><span class="tooltiptext">Ver documentos</span><i class="fa fa-bars tam-icono"></i></div></button>
                            <button type="button" class="tam-btn btn btn-warning" Onclick ='show_ficha_ingreso_iv(${item.ivp_id})'><div class="tooltip"><span class="tooltiptext">Ver ficha de ingreso</span><i class="fa fa-id-card-o tam-icono"></i></div></button>
                            <button type="button" class="tam-btn btn btn-primary" Onclick ='show_documentos_iv(${item.ivp_id})'><div class="tooltip"><span class="tooltiptext">Editar datos del propietario del vehiculo conductor</span><i class="fa fa-user tam-icono"></i></div></button>
                            <button type="button" class="btn btn-primary" Onclick ='show_mod_ingreso_vehiculo_patio(${item.ivp_id})'><div class="tooltip">Editar datos</button>
                            `;
                        }
                    },
                ], response
            );

            $("#div_table_retiro_vehiculo_patio").html(html);

            $("#table_retiro_patio_vehiculo").DataTable({
                "order": [[0, 'desc']]
            });

            $("#global-loader").removeClass("block");
            $("#global-loader").addClass("none");
        }
    });
}