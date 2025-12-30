@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .ql-toolbar.ql-snow {
        border: 1px solid #cecdcf !important;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #00BCD4 !important;
        border: 1px solid #03A9F4 !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        border-right: 1px solid #fff !important;
        color: #fff !important;
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Gestión notificaciones</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
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
                            <div class="row">
                                <div class="form-group">
                                    <label for="De:">De:</label>
                                    <input type="hidden" id="user_" value="{{Session::get('id_cedula')}}">
                                    <label for="">{{ Session::get('nombres') }} {{Session::get('apellidos')}}</label>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">PARA: </label>
                                    <select class="js-example-basic-multiple" id="users_to" name="states[]" multiple="multiple">
                                        <option value="0">Seleccione un usuario</option>
                                        <option value="todos">Todos</option>
                                        @foreach($usuario as $u)

                                        @if($u->emp_cedula != Session::get('id_cedula'))
                                        <option value="{{$u->emp_cedula}}">{{$u->emp_nombre}} {{$u->emp_apellido}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">ASUNTO: </label>
                                    <input type="text" class="form-control" id="ip_asunto" placeholder="Asunto">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">MENSAJE: </label>
                                    <!--<div class="ql-wrapper ql-wrapper-demo">
                                        <div id="quillEditor">

                                        </div>
                                    </div>-->
                                    <div id="summernote">

                                    </div>
                                </div>
                                <div>
                                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn_enviar">
                                        <strong class="color-btn-nuevo">Enviar</strong>
                                    </a>
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

<!-- INICIO MODAL AÑADIR USUARIOS -->
<div class="modal" id="modal-usuario">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Agregar Usuario</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-usuario" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-empleado" id="txt-id-empleado">
                    <div class="col-md-10 col-lg-8 col-xl-6 mx-auto d-block bus-emp-bo">
                        <div class="form-group">
                            <strong>Tipo de busqueda</strong>
                            <select name="select-tipo-buscar" id="select-tipo-buscar" class="form-control">
                                <option value="0">Seleccione tipo de busqueda</option>
                                <option value="1">Cedula</option>
                                <option value="2">Nombres</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="main-content-label tx-11 tx-medium tx-gray-600">Cedula/Nombres</label>
                            <div class="pos-relative">
                                <input class="form-control pd-r-80" type="text" id="txt-buscar-emp" name="txt-buscar-emp">
                                <div id="div-busqueda"></div>
                            </div>
                        </div>
                        <!--<a class="btn background-btn-nuevo pad-nu margin-top-bu btn-movi" id="btn-reporte-empleado">
                                    <i class="fas fa-neuter color-btn-nuevo"></i>
                                    <strong class="color-btn-nuevo">Buscar</strong>
                                </a>-->
                    </div>
                    <div id="div-table-empleado">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-usuario" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL AÑADIR USUARIOS -->

<!--INICIO MODAL ELIMINAR USUARIOS -->
<div class="modal show" id="modal-eliminar-usuario" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-eliminar-usuario" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-usuario" name="txt-id-usuario">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el usuario</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-usuario" type="button"><i class="fa fa-save"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR USUARIOS -->

<!-- INICIO MODAL MODIFICAR USUARIOS -->
<div class="modal" id="modal-usuario-m">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Modificar Usuario</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-usuario-m" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-modificar-usuario" id="txt-id-modificar-usuario">
                    <div id="div-table-empleado-m">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-modificar-usuario" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL MODIFICAR USUARIOS -->

<!-- INICIO MODAL CAMBIAR CONTRASEÑA USUARIOS -->
<div class="modal" id="modal-usuario-cambiar-clave">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <!-- Loader -->
            <div id="global-loader-modal" class="none">
                <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
                <img src="/valex/assets/img/logo-movilidad.png" class="loader loader-img tam" alt="Loader">
            </div>
            <!-- /Loader -->
            <div class="modal-header">
                <h6 class="modal-title">Modificar Clave</h6><button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-usuario-cambiar-clave" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="txt-id-cambiar-clave-usuario" id="txt-id-cambiar-clave-usuario">
                    <div id="div-table-cambiar-clave">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-cambiar-clave-usuario" type="button"><i class="fa fa-edit"></i> Modificar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL CAMBIAR CONTRASEÑA USUARIOS -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Notificacion/notificacion.js'></script>
<script src="/valex/assets/plugins/quill/quill.min.js"></script>
<!-- INTERNAL Summernote Editor js -->
<script src="/valex/assets/plugins/summernote-editor/summernote1.js"></script>
<script src="/valex/assets/js/summernote.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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

        $('.js-example-basic-multiple').select2();
    });


    $("#btn_enviar").click(function() {
        let user = $("#user_").val();
        let users_to = [];
        $('#users_to :selected').each(function(i, sel) {
            users_to.push($(sel).val());
        });
        let asunto = $("#ip_asunto").val();
        let mensaje = $(".note-editable").html();
        let tipo = 2;

        let token = $("#csrf-token").val();
        let datos = {
            user: user,
            mensaje: mensaje,
            users_to: users_to,
            asunto: asunto,
            tipo: tipo
        };

        $.ajax({
            url: "/save_noti",
            type: "POST",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": token,
            },
            data: datos,
            success: function(res) {
                if (res.respuesta) {
                    window.location.reload()
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
    })
</script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif