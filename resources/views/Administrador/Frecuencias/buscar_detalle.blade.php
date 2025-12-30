@if(Session::get('usuario'))
@extends('Administrador.Layout.app')
@section('css')
<link rel="stylesheet" href="{{asset('lib/Switch/dist/checkbox.css')}}">
<link rel="stylesheet" href="{{asset('lib/Switch/css/SimpleSwitch.css')}}">

.30
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .ui-widget {
        z-index: 1000000 !important;
    }

    .flex {
        display: flex;
    }

    .fdirecionC {
        flex-direction: column;
    }

    .jc-end {
        justify-content: end;
    }

    .jc-spaceb {
        justify-content: space-between;
    }

    .select2-container {
        width: 100% !important;
    }

    .mtop15 {
        margin-top: 1.5em;
    }

    .ss {
        font-size: 1.2em;
        margin-right: 10px;
        font-weight: 800;
    }

    .verde {
        color: #4CAF50;
    }

    .rojo {
        color: #F44336;
    }

    .tsaldo {
        display: flex;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
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
                                <h3>Buscar detalle de frecuencias</h3>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row row-sm">
                                                <div class="col-lg-3">
                                                    <p class="mg-b-10">COOPERATIVAS:</p>
                                                    <div class="SumoSelect sumo_somename" tabindex="0" role="button" aria-expanded="true">
                                                        <select class="js-example-basic-single" name="state" id="s_coop" onchange="buscar_disco();">
                                                            <option value="0">Seleccione una Cooperativa</option>
                                                            @foreach ($cooperativas as $c)
                                                            <option value="{{$c->CP_ID}}">{{$c->CP_NOMBRE}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <p class="mg-b-10">DISCO:</p>
                                                    <div class="SumoSelect sumo_somename" tabindex="0" role="button" aria-expanded="true">
                                                        <select class="js-example-basic-single" name="state" id="s_disco">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="mtop15">
                                                        <button class="btn btn-primary btn-block" onclick="buscar_detalle_frecuencia()">Buscar</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2" id="csaldo" style="display: none;">
                                                    <div class="mtop15 flex fdirecionC">
                                                        <h4 class="flex justify-content-center">Su saldo</h4>
                                                        <span class="tsaldo" id="tsaldo">$0.50</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div id="tabla">

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





@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let tipo_coop = 0; // default todos
    let tipo = 1 //  1 default uso
    let origen = 1 // 1 default monitor que significa automaticas 
    let f_i = "";
    let f_f = "";

    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    const buscar_disco = () => {
        let cooperativa = $("#s_coop").val();
        _AJAX_('/get_disco/' + cooperativa, 'GET', '', '', 0);
    }

    const buscar_detalle_frecuencia = () => {
        let coop = $("#s_coop option:selected").text();
        let disco = $("#s_disco").val();

        let data = {
            coop,
            disco
        }
        let token = $("#csrf-token").val();
        _AJAX_('/get_detalle_f', 'POST', token, data, 0);

    }

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
                        let html = '<div class="table-responsive"><table class="table table-striped mg-b-0 text-md-nowrap"><thead>'
                        html += '<tr><th></th><th>PLACA</th><th>DISCO</th><th>COOPERATIVA</th><th>TOTAL</th><th>SALDO_INICIAL</th><th>SALDO_FINAL</th><th>FECHA</th><th>ORIGEN</th><th>TIPO</th></tr></thead><tbody>'
                        $.each(res.frecuencias, function(index, u) {
                            if (u.TIPO == 'RECARGA') {
                                html += '<tr class="table-success"><th></th><th scope="row">' + u.PLACA + '</th>'
                            } else {
                                html += '<tr><th></th><th scope="row">' + u.PLACA + '</th>'
                            }
                            html += ' <td>' + u.DISCO + '</td>'
                            html += '<td>' + u.COOPERATIVA + '</td>'
                            html += '<td>'
                            if (u.TIPO == 'RECARGA') {
                                html += '<span class="ss verde">+</span>'
                            } else {
                                html += '<span class="ss rojo">-</span>'
                            }
                            html += u.TOTAL + '</td>'
                            html += '<td>$' + u.SALDO_INICIAL + '</td>'
                            html += '<td>' + u.SALDO_FINAL + '</td>'
                            html += '<td>' + u.FECHA + '</td>'
                            html += '<td>' + u.ORIGEN + '</td>'
                            html += '<td>' + u.TIPO + '</td>'
                            html += '</tr>'
                        });
                        html += '</tbody></table></div>';

                        $("#tabla").html(html);

                        $.each(res.saldos, function(index, u) {
                            $("#tsaldo").html(u.ND_SALDO)
                        })
                        $("#csaldo").show();
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
                        let html = "<option value=''>Seleccione un Disco</option>";

                        $.each(res, function(index, u) {
                            html += "<option value='" + u.disco + "'>" + u.disco + "</option>"
                        });
                        $("#s_disco").html(html);

                    } else if (p == 1) {
                        let total_salidas = 0;
                        let total_saldo = 0;
                        let html = '<div class="table-responsive"><table class="table table-striped mg-b-0 text-md-nowrap"><thead>'
                        html += '<tr><th>COOPERATIVA</th><th>DISCO</th><th>PLACA</th><th>VALOR</th><th>SALIDAS</th><th>FECHA Y HORA SALIDA</th></tr></thead><tbody>'



                        $.each(res, function(index, u) {
                            html += '<tr><th scope="row">' + u.CP_NOMBRE + '</th>'
                            html += ' <td>' + u.ND_DISCO + '</td>'
                            html += '<td>' + u.ND_PLACA + '</td>'
                            html += '<td>' + u.salidas + '</td>'
                            html += '<td>$' + u.valor + '</td>'
                            html += '<td>' + u.fecha_salida + '</td>'
                            html += '</tr>'
                            total_salidas += parseInt(u.salidas)
                            total_saldo += parseFloat(u.valor)
                        });
                        html += '</tbody></table></div>';

                        $("#tabla").html(html);
                        $("#total_s").html(total_salidas);
                        $("#total_ss").html("$ " + total_saldo);
                        $("#fecha_s").html(f_i + " " + f_f);
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