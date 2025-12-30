@extends('Administrador.Layout.app')

@section('css')
    <script src="https://kit.fontawesome.com/2afebe029b.js" crossorigin="anonymous"></script>
    <style>
        .flex {
            display: flex;
        }

        .jcontent-center {
            justify-content: center
        }

        .center {
            text-align: center;
        }

        .inum {
            font-size: 1.3rem;
            color: #FF9800;
        }

        .inum:focus {
            color: #FF9800;
        }

        .spro {
            font-style: oblique;
            font-weight: 500;
            margin-left: 1%;
            margin-top: 0.2em;
        }

        .rojo {
            color: red;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .dfc {
            display: flex;
            flex-direction: column;
        }

        .ldias {
            position: absolute;
            margin: 0 -16px;
            width: 100%;
            height: 100%;
            background: #dddddd4a;
        }

        .cload {
            display: flex;
            justify-content: center;
            height: 100%;
        }

        .cen {
            display: flex;
            align-items: center;
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
                        <h2 class="content-title mb-0 my-auto color-titulo">Gestión de vacaciones</h2>
                        <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                    </div>
                    <div class="col-md-6">
                    </div>

                </div>
            </div>


        </div>
        <!-- breadcrumb -->
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="px-3 pt-3  pb-2 pt-0">
                        <div>
                            <h6 class="mb-3 fs-12 text-fixed-white">PARA APROBAR HOY</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div>
                                    <h4 class="fs-20 fw-bold mb-1 text-fixed-white">{{ $total_hoy->sum }}</h4>
                                    <p class="mb-0 fs-12 text-fixed-white op-7">Empleados con periodos para aprobar</p>
                                </div> <a href="javascript:void(0)" onclick="open_modal('modal_aprobar','',2)"><span
                                        class="float-end my-auto ms-auto"> <i
                                            class="fas fa-arrow-circle-up text-fixed-white"></i> </span></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="px-3 pt-3  pb-2 pt-0">
                        <div>
                            <h6 class="mb-3 fs-12 text-fixed-white">TOTAL POR APROBAR</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div>
                                    <h4 class="fs-20 fw-bold mb-1 text-fixed-white">{{ $total->sum }}</h4>
                                    <p class="mb-0 fs-12 text-fixed-white op-7">Empleados con periodos para aprobar</p>
                                </div> <a href="javascript:void(0)" onclick="open_modal('modal_aprobar','',2)"><span
                                        class="float-end my-auto ms-auto"> <i
                                            class="fas fa-arrow-circle-up text-fixed-white"></i> </span></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- row -->
        <div class="row row-cols-2">
            <div class="col">
                <!--div-->
                <div class="card">
                    <div class="card-body">
                        <div class="row row-sm">
                            <!--<div class="card-header">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <h3 class="card-title"></h3>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>-->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div id="div-table">
                                        <table id="tbl_va"
                                            class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="wd-lg-25p">CEDULA</th>
                                                    <th class="wd-lg-25p tx-right">EMPLEADO</th>
                                                    <th class="wd-lg-25p tx-right">FECHA DE INGRESO</th>
                                                    <th class="wd-lg-25p tx-right">TIPO </th>
                                                    <th class="wd-lg-25p tx-right">SALDO DIAS DE VACACIONES</th>
                                                    <th class="wd-lg-25p tx-right">:::</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($empleados as $v)
                                                    <tr>
                                                        <td>{{ $v->emp_cedula }}</td>
                                                        <td class="tx-right tx-medium ">{{ $v->emp_nombre }}
                                                            {{ $v->emp_apellido }}</td>
                                                        <td class="tx-right tx-medium ">{{ $v->emp_fecha_ingreso }}</td>
                                                        @if ($v->emp_id_regimen_contractual == 1)
                                                            <td class="tx-right tx-medium ">CODIGO DE TRABAJO</td>
                                                        @elseif($v->emp_id_regimen_contractual == 2)
                                                            <td class="tx-right tx-medium ">LOEP</td>
                                                        @elseif($v->emp_id_regimen_contractual == 3)
                                                            <td class="tx-right tx-medium ">LOSEP</td>
                                                        @endif
                                                        <td class="tx-right tx-medium ">{{ $v->dias }}</td>
                                                        <td class="tx-right tx-medium ">
                                                            <div class="btn-group mb-2 mt-2">
                                                                <button type="button"
                                                                    class="btn btn-secondary dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fe fe-more-vertical"></i>
                                                                </button>
                                                                <ul class="dropdown-menu" style="">
                                                                    <li><a class="dropdown-item" href="javascript:void(0);"
                                                                            onclick="open_modal('modal-dias', '{{ $v->emp_cedula }}',1)"><i
                                                                                class="fa-solid fa-person-arrow-down-to-line"></i>
                                                                            Más detalle</a></li>
                                                                    <li><a class="dropdown-item" href="javascript:void(0);"
                                                                            onclick="open_modal('modal-descontar',{{ $v->emp_cedula }},0)"><i
                                                                                class="fa-solid fa-person-arrow-down-to-line"></i>
                                                                            Descontar dias</a></li>
                                                                    <li><a class="dropdown-item"
                                                                            href="javascript:void(0);"><i
                                                                                class="fa-solid fa-user-pen"></i> Editar
                                                                            dias</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

    <!-- INICIO MODAL AÑADIR organigramaS -->
    <div class="modal" id="modal-descontar" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h1 class="modal-title">Descontar dias</h1><button aria-label="Close" class="close"
                        data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="ip_cedula">
                        <div class="col-md-12 mg-t-10">
                            <div class="flex jcontent-center">
                                <div class="center">
                                    <h2>DIAS DISPONIBLES</h2>
                                    <h1 id="dias">50</h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mg-t-10">
                            <div class="flex jcontent-center">
                                <div class="center">
                                    <strong>DÍAS A DESCONTAR</strong>
                                    <input type="number" id="dias_d" class="inum form-control"
                                        placeholder="Ingrese el número de días">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <div id="summernote">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success-gradient btn-movi" id="btnguardar_dias" onclick="descontar_dias()"
                        type="button"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                            class="fas fa-times"></i> Salir</button>
                </div>
            </div>
        </div>
    </div>
    <!--FIN MODAL AÑADIR organigramaS -->

    <!-- INICIO MODAL AÑADIR organigramaS -->
    <div class="modal fade effect-rotate-bottom" id="modal-dias" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h1 class="modal-title">Detalle de vacaciones -</h1>
                    <div class="fw-semibold fs-16" id="s_name"></div><button aria-label="Close" class="close"
                        data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="ip_cedula_det">
                        <div class="row">
                            <div class="d-flex w-100">
                                <div class="me-4">
                                    <span class="avatar avatar-lg avatar-rounded">
                                        <img id="im_empleado" alt="img">
                                    </span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between w-100 flex-wrap">
                                    <div class="me-3">
                                        <p class="text-muted mb-0">Cédula</p>
                                        <p class="fw-semibold fs-16 mb-0" id="s_cedula">25</p>
                                    </div>
                                    <div class="me-3">
                                        <p class="text-muted mb-0">Fecha de ingreso</p>
                                        <p class="fw-semibold fs-16 mb-0" id="s_fecha_ingreso">1253</p>
                                    </div>
                                    <div class="me-3">
                                        <p class="text-muted mb-0">Dias para el nuevo periodo</p>
                                        <p class="fw-semibold fs-16 mb-0" id="s_fecha_aprovacion">367</p>
                                    </div>
                                    <div class="me-3">
                                        <p class="text-muted mb-0">Total de Dias</p>
                                        <p class="fw-semibold fs-16 mb-0" id="s_dias">367</p>
                                    </div>
                                </div>
                            </div>
                            <div>

                            </div>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <div id="dv" class="table-responsive">
                                <table class="table text-nowrap table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Periodo</th>
                                            <th scope="col">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_periodos">
                                        <tr>
                                            <th scope="row">IN-2032</th>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2 avatar-rounded"> <img
                                                            src="../assets/images/faces/15.jpg" alt="img"> </div>
                                                    <div>
                                                        <div class="lh-1"> <span>Mark Cruise</span> </div>
                                                        <div class="lh-1"> <span
                                                                class="fs-11 text-muted">markcruise24@gmail.com</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-success-transparent"><i
                                                        class="ri-check-fill align-middle me-1"></i>Paid</span></td>
                                            <td>Jul 26,2022</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">IN-2014</th>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2 avatar-rounded"> <img
                                                            src="../assets/images/faces/5.jpg" alt="img"> </div>
                                                    <div>
                                                        <div class="lh-1"> <span>Samantha Julie</span> </div>
                                                        <div class="lh-1"> <span
                                                                class="fs-11 text-muted">julie453@gmail.com</span> </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-danger-transparent"><i
                                                        class="ri-close-fill align-middle me-1"></i>Cancelled</span> </td>
                                            <td>Feb 1,2022</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">IN-2036</th>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2 avatar-rounded"> <img
                                                            src="../assets/images/faces/11.jpg" alt="img"> </div>
                                                    <div>
                                                        <div class="lh-1"> <span>Simon Cohen</span> </div>
                                                        <div class="lh-1"> <span
                                                                class="fs-11 text-muted">simon@gmail.com</span> </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light text-dark"><i
                                                        class="ri-reply-line align-middle me-1"></i>Refunded</span> </td>
                                            <td>Apr 24,2022</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success-gradient btn-movi" id="btnguardar_dias" onclick="descontar_dias()"
                        type="button"><i class="fa fa-save"></i> Guardar</button>
                    <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                            class="fas fa-times"></i> Salir</button>
                </div>
            </div>
        </div>
    </div>
    <!--FIN MODAL AÑADIR organigramaS -->

    <div class="modal fade " id="modal_aprobar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">APROBACIÓN DE DIAS VACACIONES </h6> <button
                        type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="load_dias" class="ldias" style="display: none">
                        <div class="cload">
                            <div class="cen">
                                <i class="fas fa-spinner fa-spin"></i>
                                <span>Espere un momento</span>
                            </div>
                        </div>

                    </div>
                    <div id="dias_c">

                    </div>
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button> </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/valex/assets/plugins/quill/quill.min.js"></script>
    <!-- INTERNAL Summernote Editor js -->
    <script src="/valex/assets/plugins/summernote-editor/summernote1.js"></script>
    <script src="/valex/assets/js/summernote.js"></script>
    <script>
        $(function() {
            'use strict'
            var icons = Quill.import('ui/icons');
            icons['bold'] = '<i class="la la-bold" aria-hidden="true"><\/i>';
            icons['italic'] = '<i class="la la-italic" aria-hidden="true"><\/i>';
            icons['underline'] = '<i class="la la-underline" aria-hidden="true"><\/i>';
            icons['strike'] = '<i class="la la-strikethrough" aria-hidden="true"><\/i>';
            icons['list']['ordered'] = '<i class="la la-list-ol" aria-hidden="true"><\/i>';
            icons['list']['bullet'] = '<i class="la la-list-ul" aria-hidden="true"><\/i>';
            icons['link'] = '<i class="la la-link" aria-hidden="true"><\/i>';
            icons['image'] = '<i class="la la-image" aria-hidden="true"><\/i>';
            icons['video'] = '<i class="la la-film" aria-hidden="true"><\/i>';
            icons['code-block'] = '<i class="la la-code" aria-hidden="true"><\/i>';
            var toolbarOptions = [
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                ['bold', 'italic', 'underline', 'strike'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                ['link', 'image', 'video']
            ];
            var quill = new Quill('#quillEditor', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow'
            });

            $('#summernote').summernote();

            //$('.js-example-basic-multiple').select2();
        });
        const detalle_dias = (cedula) => {

        }
        const descontar_dias = () => {
            let dias = $("#dias").html();
            let dias_d = $("#dias_d").val();
            let cedula = $("#ip_cedula").val();
            let observacion = $(".note-editable").html()
            if (dias_d == '') {
                alert("Por favor ingrese el valor a descontar");
                return;
            } else if (parseFloat(dias_d) > parseFloat(dias)) {
                alert("No tiene suficientes dias!");
                return;
            } else {
                // let t_dias = parseFloat(dias) - parseFloat(dias_d);
                let datos = {
                    dias_d,
                    cedula,
                    observacion
                };
                let token = $("#csrf-token").val();
                _AJAX_("/descontar_dias", "POST", token, datos, 0);
                //alert("Le quedan " + (dias - dias_d) + " dias");
            }



        }
        const open_modal = (modal, cedula, tipo) => {
            if (tipo == 0) {
                $("#ip_cedula").val(cedula);
                _AJAX_('/getdias/' + cedula, 'GET', '', '', 0);
            } else if (tipo == 1) {
                $("#ip_cedula_det").val(cedula);
                _AJAX_('/get_periodos/' + cedula, 'GET', '', '', 1);
                //$("#" + modal).modal("show");
            } else if (tipo == 2) {
                _AJAX_('/get_dias_periodos', 'GET', '', '', 3);
            }
        };
        $("#tbl_va").DataTable();
        const aprobar = (id) => {
            $("#load_dias").show();
            let datos = {
                id
            };
            let token = $("#csrf-token").val();
            _AJAX_("/aprobar_dias", "POST", token, datos, 5);
        }

        const denegar = (id) => {
            $("#load_dias").show();
            let datos = {
                id
            };
            let token = $("#csrf-token").val();
            _AJAX_("/denegar_dias", "POST", token, datos, 6);
        }

        function _AJAX_(ruta, tipo, token, datos, p) {
            if (tipo == "POST") {
                $.ajax({
                    url: ruta,
                    type: tipo,
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": token,
                    },
                    data: datos,
                    success: function(res) {
                        if (p == 0) {
                            if (res.respuesta) {
                                // _AJAX_("/Get_vacaciones", "GET", "", "", 1);
                                notif({
                                    msg: "<b>Correcto:</b> Se descontaron los dias correctamente!",
                                    type: "success",
                                });
                                _AJAX_("/get_vacaciones", "GET", "", "", 2);



                                /* onload_btn("btn_add", "Guardar categoria");
                                 $("#ip_categoria").val("");
                                 close_modal("modal-create");*/
                            }
                        } else if (p == 1) {
                            if (res.res) {
                                _AJAX_("/GET_tipos_enf", "GET", "", "", 0);
                                notif({
                                    msg: "<b>Correcto:</b> La categoria elimino manera correcta!",
                                    type: "success",
                                });
                                onload_btn("btn_delete", "Si, eliminar!");
                                $("#ip_id_ca").val("");
                                close_modal("modal-delete");
                            }
                        } else if (p == 2) {
                            if (res.res) {
                                _AJAX_("/GET_tipos_enf", "GET", "", "", 0);
                                notif({
                                    msg: "<b>Correcto:</b> La categoria se actualizo de manera correcta!",
                                    type: "success",
                                });
                                onload_btn("btn_edit", "Editar categoria");
                                $("#ip_idcate").val("");
                                $("#categoria").val("");
                                close_modal("modal-edit");
                            }
                        } else if (p == 4) {
                            //console.log(res.data);
                            onload_btn("btn_buscar_p",
                                '<i class="fa-solid fa-hospital-user"></i> Buscar paciente');
                            if (res.respuesta) {
                                let html = ''
                                $(res.data).each(function(i, data) {
                                    html += '<tr>'
                                    html += '<td>' + data.emp_nombre + '</td>'
                                    html += '<td>' + data.emp_apellido + '</td>'
                                    html += '<td>' + data.per_perfil + '</td>'
                                    html += '<td>' + data.ca_cargo + '</td>'
                                    html += '<td>' + data.correo + '</td>'
                                    html += '<td name="bstable-actions"><div class="btn-list">'
                                    html += '<a  href="consulta/' + data.emp_cedula +
                                        '" id="bEdit" type="button" class="btn btn-sm btn-primary"><i class="fa-solid fa-hand-holding-medical"></i> Atender</a>'
                                    //   html += '<button id="bDel" type="button" class="btn  btn-sm btn-danger"><span class="fe fe-trash-2"> </span></button>'
                                    /*    <button id="bAcep" type="button" class="btn  btn-sm btn-primary">
                                            <span class="fe fe-check-circle"> </span>
                                        </button>
                                        <button id="bCanc" type="button" class="btn  btn-sm btn-danger" style="display:none;">
                                            <span class="fe fe-x-circle"> </span>
                                        </button>
                                    </div>*/
                                    html += '</td></tr>'
                                })

                                $("#tpaciente").html(html);
                            }

                        } else if (p == 5) {
                            if (res.respuesta) {
                                _AJAX_('/get_dias_periodos', 'GET', '', '', 3);

                            }
                        } else if (p == 6) {
                            if (res.respuesta) {
                                _AJAX_('/get_dias_periodos', 'GET', '', '', 3);

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
                    url: ruta,
                    type: tipo,
                    dataType: "json",
                    success: function(res) {
                        let html_ = "";

                        if (p == 0) {
                            $("#dias").html(res.dias[0].saldo);
                            $("#modal-descontar").modal("show");
                            // table_responsive("#table_re");
                        } else if (p == 1) {
                            // $("#dias").html(res.dias[0].saldo);
                            $("#s_cedula").html(res.cedula);
                            $("#s_name").html(res.empleado);
                            $("#s_fecha_ingreso").html(res.fecha_ingreso);
                            $("#s_fecha_aprovacion").html(res.dias_faltantes_para_acreditar)
                            $("#s_dias").html(res.dias_proximo_acreditar)
                            $("#im_empleado").attr('src', '/imagenes_empleados/' + res.cedula + ".jpeg");
                            let html = '';
                            let total = 0;
                            let total_activo = 0;


                            $(res.periodos).each(function(i, data) {
                                html += '<div class="accordion" id="accordionVacaciones">'
                                html +=
                                    '<div class = "accordion-item" > <h2 class = "accordion-header" id = "heading_' +
                                    data.id_periodo + '" >'
                                html +=
                                    '<button class = "accordion-button collapsed" type = "button" data-bs-toggle = "collapse" data-bs-target= "#collapse_' +
                                    data.id_periodo +
                                    '" aria-expanded = "false" aria-controls = "collapseOne" > '
                                if (data.estado == 0) {
                                    html += data.periodo +
                                        '<span class="badge bg-danger-transparent" style="margin-left: 10%;"> ' +
                                        data.valor +
                                        '</span><span class="spro"> Proximamente</span>'
                                } else {
                                    html += data.periodo +
                                        '<span class="badge bg-success-transparent" style="margin-left: 10%;"> ' +
                                        data.valor +
                                        '</span>'
                                    total_activo += parseFloat(data.valor);
                                }
                                html += '</button></h2 >'
                                html += '<div id = "collapse_' + data.id_periodo +
                                    '"class = "accordion-collapse collapse" aria-labelledby = "heading_' +
                                    data.id_periodo +
                                    '" data-bs-parent = "#accordionVacaciones" style = "" >'
                                html += '<div class = "accordion-body" > '

                                html += '<ol class="list-group">'
                                $(res.descuentos).each(function(i, v) {
                                    if (v.id_periodo == data.id_periodo) {
                                        html +=
                                            '<li class="list-group-item"> <span class="rojo">-</span>' +
                                            v.valor +
                                            ' - ' + v
                                            .observacion + '</li>'
                                    }
                                });
                                html += '</ol>'
                                html += '</div></div> </div> </div> '
                                /* html += '<tr><td><div class="d-flex align-items-center"><span>' + data
                                     .periodo + '</span></div></td>'
                                 if (data.estado == 0) {
                                     html += '<td> <span class="badge bg-danger-transparent"> ' + data
                                         .valor + '</span><span> Proximamente</span></td> </tr> '
                                 } else {
                                     html += '<td> <span class="badge bg-success-transparent"> ' + data
                                         .valor + '</span> </td> </tr> '
                                     total_activo += parseFloat(data.valor);
                                 }*/

                                total += parseFloat(data.valor);
                                //<td><span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Paid</span></td>
                            });

                            // html += '<tr><td></td><td> <span>' + total + ' Dias </span></td></tr>'
                            $("#dv").html(html);
                            $("#s_dias").html(total_activo)

                            $("#modal-dias").modal("show");
                            //table_responsive("#table_re");
                        } else if (p == 2) {
                            $("#dias_d").val("");
                            $(".note-editable").html("");
                            $("#modal-descontar").modal("hide");

                            let tabla =
                                '<table id="tbl_va" class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap"><thead><tr><th class="wd-lg-25p">CEDULA</th><th class="wd-lg-25p tx-right">EMPLEADO</th><th class="wd-lg-25p tx-right">FECHA DE INGRESO</th><th class="wd-lg-25p tx-right">TIPO </th><th class="wd-lg-25p tx-right">SALDO DIAS DE VACACIONES</th><th class="wd-lg-25p tx-right">:::</th></tr></thead><tbody>';


                            $(res).each(function(i, data) {

                                let m1 = "'modal-dias'";
                                let m2 = "'modal-descontar'"
                                let ced = "'" + data.emp_cedula + "'";

                                tabla += '<tr><td>' + data.emp_cedula + '</td>'
                                tabla += '<td class="tx-right tx-medium ">' + data.emp_nombre + ' ' +
                                    data.emp_apellido + '</td>'
                                tabla += '<td class="tx-right tx-medium ">' + data.emp_fecha_ingreso +
                                    '</td>'
                                if (data.emp_id_regimen_contractual == 1) {
                                    tabla += '<td class="tx-right tx-medium ">CODIGO DE TRABAJO</td>'
                                } else if (data.emp_id_regimen_contractual == 2) {
                                    tabla += '<td class="tx-right tx-medium ">LOEP</td>'
                                } else if (data.emp_id_regimen_contractual == 3) {
                                    tabla += '<td class="tx-right tx-medium ">LOSEP</td>'
                                }
                                tabla += '<td class="tx-right tx-medium ">' + data.dias + '</td>'
                                tabla +=
                                    '<td class="tx-right tx-medium "><div class="btn-group mb-2 mt-2"><button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> <i class="fe fe-more-vertical"></i></button> <ul class="dropdown-menu" style="">'
                                tabla +=
                                    '<li><a class="dropdown-item" href="javascript:void(0);" onclick="open_modal(' +
                                    m1 + ', ' + ced +
                                    ',1)"><i class="fa-solid fa-person-arrow-down-to-line"></i>Más detalle</a></li>'
                                tabla +=
                                    '<li><a class="dropdown-item" href="javascript:void(0);" onclick="open_modal(' +
                                    m2 + ',' + ced +
                                    ' ,0)"><i class="fa-solid fa-person-arrow-down-to-line"></i>Descontar dias</a></li>'
                                tabla +=
                                    '<li><a class="dropdown-item" href="javascript:void(0);"><i class="fa-solid fa-user-pen"></i> Editardias</a></li>'
                                tabla += '</ul></div></td></tr>'
                            });
                            tabla += ' </tbody></table>'
                            $("#div-table").html(tabla);
                            $("#tbl_va").DataTable();

                        } else if (p == 3) {
                            let html = '';
                            if (res.length != 0) {
                                html +=
                                    '<table class="table mg-b-0 text-md-nowrap"><thead><tr><th>ID</th> <th>EMPLEADO </th><th>FECHA INGRESO </th> <th>PERIODO </th> <th> TIPO DE CONTRATO </th> <th> DIAS </th><th>:::</th> </tr> </thead> <tbody> '
                                $(res).each(function(i, data) {
                                    html += '<tr><th scope="row">' + data.id + '</th>'
                                    html += '<td> ' + data.emp_nombre + ' ' + data.emp_apellido +
                                        '</td>'
                                    html += '<td> ' + data.emp_fecha_ingreso + ' </td>'
                                    html += '<td> ' + data.id_periodo + ' </td>'
                                    html += '<td> ' + data.emp_id_regimen_contractual + ' </td>'
                                    html += '<td> ' + data.valor + ' </td>'
                                    html +=
                                        '<td> <div class="dfc"> <a href="javascript::void(0);" onclick="aprobar(' +
                                        data.id +
                                        ')"><i class="fa-solid fa-circle-check"></i></a> <a href="javascript::void(0);" onclick="denegar(' +
                                        data.id +
                                        ')"><i class="fa-solid fa-trash-can"></i></a></div></td>'
                                    html += '</tr>'
                                })
                                html += '</tbody></table>'
                            }
                            $("#dias_c").html(html);
                            $("#modal_aprobar").modal("show");
                            $("#load_dias").hide();


                        }
                    },
                }).fail(function(jqXHR, textStatus, errorthrown) {
                    $("#btn_add").html(
                        '<i class="fa fa-plus-square color-btn-nuevo"></i><strong class="color-btn-nuevo">Añadir</strong>'
                    );
                    $("#btn_add").removeClass("disable_a");
                    $("#load_m").hide();
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
