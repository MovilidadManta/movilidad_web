@if(Session::get('usuario'))
@extends('Administrador.Layout.app')
@section('css')
<link rel="stylesheet" href="{{asset('lib/Switch/dist/checkbox.css')}}">
<link rel="stylesheet" href="{{asset('lib/Switch/css/SimpleSwitch.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />
<script src="https://code.highcharts.com/highcharts.js"></script>
<style>
    .ui-widget {
        z-index: 1000000 !important;
    }

    .flex {
        display: flex;
    }

    .jc-end {
        justify-content: end;
    }

    .jc-spaceb {
        justify-content: space-between;
    }
</style>
@endsection

@section('content')
<!-- main-content -->

<!-- container -->
<div class="main-container">
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto col-md-12">
            <div class="d-flex">
                <div class="col-md-6">
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestión de frecuencias</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm">
                        <!--<div class="card-header">
									<h3 class="card-title"></h3>
								</div>-->
                        <div class="card-body">
                            <div class="flex jc-spaceb">
                                <h3>Estadisticas de frecuencias <a href="http://192.168.0.105/freeboard/index-dev.html?load=01.json" target="_black">Ir ver mas</a></h3>
                                <a href="#">Avanzada</a>
                            </div>
                            <div class="row flex jc-end">
                                <div class="col-lg-2">
                                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-9">
                                    <div id="container" style="width:100%; height:400px;"></div>

                                    <div class="card">
                                        <div class="card-body">
                                            <div id="tabla">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <div id="tabla-tasas">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mt-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <h3>{{$cooperativas[0]->u}}</h3>
                                                <span>Cooperativas</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <h3>{{$unidades[0]->u}}</h3>
                                                <span>Unidades</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <h3 id="total_s"></h3>
                                                <span>Total de salidas</span>
                                                <br>
                                                <span id="fecha_s"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <h3 id="total_ss"></h3>
                                                <span>Total en dolares</span>
                                                <br>
                                                <span id="fecha_ss"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <!--<div class="table-responsive">
                                <div id="div-table-eventos"></div>
                            </div>-->
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->
</div>
<!-- Container closed -->

<!-- INICIO MODAL AÑADIR USUARIOS -->
<div class="modal" id="modal_created">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Agregar eventos</h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 col-lg-12 col-xl-12 mx-auto d-block bus-emp-bo">
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            TITULO
                        </label>
                        <div class="pos-relative">
                            <input class="form-control pd-r-80" type="text" id="ip_titulo" name="ip_titulo">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            EVENTO
                        </label>
                        <div class="pos-relative">
                            <textarea class="form-control" placeholder="Ingrese información del evento" id="ip_contenido" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    FECHA INICIO
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                    <input class="form-control" id="ip_fini" placeholder="YYYY-MM-DD" type="date">
                                </div><!-- input-group -->
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="main-content-label tx-11 tx-medium tx-gray-600">
                                    FECHA CADUCA
                                </label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                    </div>
                                    <input class="form-control" id="ip_ffin" placeholder="YYYY-MM-DD" type="date">
                                </div><!-- input-group -->
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            IMAGEN (jpg;jpeg)
                        </label>
                        <input type="file" class="dropify" name="txt-ruta-foto" id="txt-ruta-foto" accept="image/jpeg" data-max-file-size="3M" />
                    </div>
                    <div class="form-group">
                        <label class="main-content-label tx-11 tx-medium tx-gray-600">
                            TIPO DE EVENTO
                        </label>
                        <select class="form-control" id="select-tipo">
                            <option value="S">Seleccione el destino</option>
                            <option value="0">Evento en Transito</option>
                            <option value="1">Evento en Terminal</option>
                            <option value="2">Evento en Intranet</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_save" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR USUARIOS -->

<!--INICIO MODAL ELIMINAR USUARIOS -->
<div class="modal show" id="modal_delete_proyecto" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" id="ip_id_proyecto_delete" name="ip_id_proyecto_delete">
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">×</span>
                </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="tx-danger mg-b-20">Seguro de eliminar el proyecto</h4>
                <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                <button class="btn btn-success-gradient" id="btn-eliminar-proyecto" type="button"><i class="fa fa-save"></i> Eliminar</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR USUARIOS -->

<!-- INICIO MODAL MODIFICAR USUARIOS -->
<div class="modal" id="modal_editar_proyecto">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Modificar Proyecto</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="ip_id_proyecto_edit" id="ip_id_proyecto_edit">
                <div class="row">
                    <input type="text" class="form-control" id="ip_proyecto_edit">

                    <span class="margin-r">Estado</span>
                    <input type="checkbox" data-type="simple-switch" id="chk_estado_2" data-material="true">
                    <label for="" id="l_estado_h">activo</label>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-proyecto" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR USUARIOS -->



@endsection

@section('js')
<script type='text/javascript' src="{{asset('lib/Switch/js/SimpleSwitch.min.js')}}"></script>
<script src="/valex/assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script>
    let tipo_coop = 0; // default todos
    let tipo = 1 //  1 default uso
    let origen = 1 // 1 default monitor que significa automaticas 
    let f_i = "";
    let f_f = "";

    $(function() {

        var start = moment();
        var end = moment();



        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Ultimos 7 Días': [moment().subtract(6, 'days'), moment()],
                'Ultimos 30 Días': [moment().subtract(29, 'days'), moment()],
                'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                'Ultimo Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

        $(".main-body").addClass('sidenav-toggled')

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            console.log(start.format('YYYY-MM-DD'))
            console.log(end.format('YYYY-MM-DD'))
            f_i = start.format('YYYY-MM-DD')
            f_f = end.format('YYYY-MM-DD')
            _AJAX_('/f_semanal', 'GET', '', '', 0);
            _AJAX_('/f_data/' + f_i + '/' + f_f, 'GET', '', '', 1);
            _AJAX_('/tasas_report/' + f_i + '/' + f_f, 'GET', '', '', 2);
        }
    });




    const _AJAX_ = (ruta_AJX, tipo, token, datos, p) => {
        if (tipo == "POST") {
            $.ajax({
                url: ruta_AJX,
                type: tipo,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": token
                },
                data: datos,
                success: function(res) {
                    if (p == 0) {
                        if (res.respuesta) {
                            get_contenedors_b(datos.id_bodega).then(result => {
                                if (result.length > 0) {
                                    result.forEach(function(i, v) {

                                    });
                                }

                            })

                            console.log("ruta de folder new:" +
                                res.ruta);

                            $("#modal-create").modal("hide");
                        }
                    }
                },
            }).fail(function(jqXHR, textStatus, errorthrown) {
                if (jqXHR.status === 0) {
                    alert("Not connect: Verify Network.");
                } else if (jqXHR.status == 404) {
                    alert("Requested page not found [404]");
                } else if (jqXHR.status == 500) {
                    alert("Internal Server Error [500].");
                } else if (textStatus === "parsererror") {
                    alert("Requested JSON parse failed.");
                } else if (textStatus === "timeout") {
                    alert("Time out error.");
                } else if (textStatus === "abort") {
                    alert("Ajax request aborted.");
                } else {
                    alert("Uncaught Error: " + jqXHR.responseText);
                }
            });
        } else if (tipo == "GET") {
            $.ajax({
                url: ruta_AJX,
                type: tipo,
                dataType: "json",
                success: function(res) {
                    let html_ = "";
                    if (p == 0) {
                        let dias = [];
                        let total = [];
                        let total2 = [];

                        $.each(res.automaticas, function(index, u) {
                            total.push(parseInt(u.total));
                        });
                        $.each(res.manuales, function(index, u) {
                            dias.push(u.dia);

                            total2.push(parseInt(u.total));
                        });

                        // Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
                        Highcharts.chart('container', {
                            chart: {
                                type: 'spline'
                            },
                            title: {
                                text: 'Frecuencias de automativas vs manuales de los ultimos 8 días '
                            },
                            xAxis: {
                                categories: dias,
                                accessibility: {
                                    description: 'Months of the year'
                                }
                            },
                            yAxis: {
                                title: {
                                    text: 'Frecuencias'
                                }

                            },
                            tooltip: {
                                crosshairs: true,
                                shared: true
                            },
                            plotOptions: {
                                spline: {
                                    marker: {
                                        radius: 4,
                                        lineColor: '#666666',
                                        lineWidth: 1
                                    }
                                }
                            },
                            series: [{
                                name: 'Automaticas',
                                marker: {
                                    symbol: 'square'
                                },
                                data: total

                            }, {
                                name: 'Manuales',
                                marker: {
                                    symbol: 'diamond'
                                },
                                data: total2
                            }]
                        });




                    } else if (p == 1) {
                        let total_salidas = 0;
                        let total_saldo = 0;
                        let html = '<div class="table-responsive"><table id="detalle_fre" class="display nowrap"><thead>'
                        html += '<tr><th>COOPERATIVA</th><th>DISCO</th><th>PLACA</th><th>VALOR</th><th>FECHA Y HORA SALIDA</th><th>TIPO</th></tr></thead><tbody>'
                        $.each(res, function(index, u) {
                            html += '<tr><th scope="row">' + u.COOPERATIVA + '</th>'
                            html += ' <td>' + u.DISCO + '</td>'
                            html += '<td>' + u.PLACA + '</td>'
                            html += '<td>$' + u.TOTAL + '</td>'
                            html += '<td>' + u.fecha_salida + '</td>'
                            html += '<td>' + u.TIPO + '</td>'
                            html += '</tr>'
                            total_salidas += parseInt(u.SALIDAS)
                            total_saldo += parseFloat(u.TOTAL)
                        });
                        html += '</tbody></table></div>';

                        $("#tabla").html(html);
                        $("#total_s").html(res.length);
                        $("#total_ss").html("$ " + total_saldo);
                        $("#fecha_s").html(f_i + " " + f_f);

                        $('#detalle_fre').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'excel', 'print'
                            ]
                        });
                    } else if (p == 2) {
                        let total_salidas = 0;
                        let total_saldo = 0;
                        let html = '<div class="table-responsive"><table id="detalle_tasas" class="display nowrap"><thead>'
                        html += '<tr><th>FECHA</th><th>TASA</th><th>PUERTA</th></tr></thead><tbody>'
                        $.each(res, function(index, u) {
                            html += '<tr><th scope="row">' + u.TS_FECHAUSO + '</th>'
                            html += ' <td>' + parseFloat(u.TS_VALOR) + '</td>'
                            html += '<td>' + u.PRI_DES + '</td>'
                            html += '</tr>'
                        });
                        html += '</tbody></table></div>';

                        $("#tabla-tasas").html(html);
                        $('#detalle_tasas').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'excel', 'print'
                            ]
                        });
                    }
                },
            }).fail(function(jqXHR, textStatus, errorthrown) {
                if (jqXHR.status === 0) {
                    alert("Not connect: Verify Network.");
                } else if (jqXHR.status == 404) {
                    alert("Requested page not found [404]");
                } else if (jqXHR.status == 500) {
                    alert("Internal Server Error [500].");
                } else if (textStatus === "parsererror") {
                    alert("Requested JSON parse failed.");
                } else if (textStatus === "timeout") {
                    alert("Time out error.");
                } else if (textStatus === "abort") {
                    alert("Ajax request aborted.");
                } else {
                    alert("Uncaught Error: " + jqXHR.responseText);
                }
            });
        }
    }
</script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif