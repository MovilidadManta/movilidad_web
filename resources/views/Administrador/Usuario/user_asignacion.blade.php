@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
<style>
    .c_grab {
        cursor: pointer;
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
                    @foreach($json_data as $u)
                    <h2 class="content-title mb-0 my-auto color-titulo">{{$u->emp_nombre}} {{$u->emp_apellido}}</h2>
                    @endforeach
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn_guardar_asignacion">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Guardar</strong>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <!-- breadcrumb -->
    <input type="hidden" id="json_menus" value='{{$umenus}}'>
    <input type="hidden" id="id_user" value='{{$ced}}'>
    <div class="row">
        <!-- Loader -->
        <div class="load_moda" id="load_m">
            <!--<img src="valex/assets/img/loader.svg" class="loader-img" alt="Loader">-->
            <img src="/valex/assets/img/logo-movilidad.png" class="loader_2 loader-img tam" alt="loader_2">
        </div>
        <!-- /Loader -->

        <div class="col-lg-4 col-xl-3">
            <div class="card">
                <div class="main-content-left main-content-left-mail card-body">
                    <a class="btn btn-primary btn-compose" id="btnCompose" href="/proyectos"><i class="fa fa-plus mx-2"></i> Nuevo proyecto</a>
                    <div class="main-mail-menu">
                        <nav class="nav main-nav-column">
                            @foreach($proyectos as $p)
                            @if($loop->index==0)
                            <input type="hidden" value="{{$p->pro_id}}" id="ip_idp_default">
                            <a id="p_{{$p->pro_id}}" class="c_grab nav-link thumb active" onclick="Get_menus({{$p->pro_id}})"><i class="fe fe-database"></i> {{$p->pro_nombre}}</a>
                            @else
                            <a id="p_{{$p->pro_id}}" class="c_grab nav-link thumb" onclick="Get_menus({{$p->pro_id}})"><i class="fe fe-database"></i> {{$p->pro_nombre}}</a>
                            @endif
                            @endforeach
                        </nav>
                    </div><!-- main-mail-menu -->
                    <div class="card custom-card mt-3 pb-0 mb-0">
                        <div class="card-header font-weight-bold"><i class="fe fe-hard-drive me-2"></i>Storage</div>
                        <div class="card-body pt-0">
                            <div class="progress fileprogress mg-b-10">
                                <div class="progress-bar progress-bar-xs wd-15p" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="text-muted font-weight-semibold tx-13 mb-1">26.24 GB Used of 128GB</div>
                            <div class="tx-13 text-primary font-weight-semibold">Upgrade Storage</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xl-9">

            <div class="text-muted mb-2 tx-16">Menus</div>
            <div class="row" id="content_menu">
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <a href="file-manager-list.html">
                            <div class="card-body">
                                <div class="tx-16 mb-1">
                                    <svg class="file-manager-icon me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <rect width="9" height="9" x="2" y="2" fill="#f74f75" rx="1"></rect>
                                        <rect width="9" height="9" x="2" y="13" fill="#fa95ac" rx="1"></rect>
                                        <rect width="9" height="9" x="13" y="2" fill="#fa95ac" rx="1"></rect>
                                        <rect width="9" height="9" x="13" y="13" fill="#fa95ac" rx="1"></rect>
                                    </svg>
                                    Image
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-muted mb-2 tx-16">Submenus</div>
            <div class="row" id="content_submenu">

            </div>
        </div>
    </div>
</div>
<!-- Container closed -->



@endsection

@section('js')
<!--<script type='text/javascript' src='/js/Usuario/usuario.js'></script>-->
<script>
    let menu_activo = 0;
    let json_menu_ = []
    if ($("#json_menus").val() != "") {
        json_menu_ = JSON.parse($("#json_menus").val());
    }
    $(document).ready(function() {
        let id = $("#ip_idp_default").val();
        Get_menus(id);
        menu_activo = id;
    });

    function Get_menus(id) {
        $("#load_m").show();
        $("#p_" + menu_activo).removeClass('active');
        $.ajax({
            url: "/get_menus/" + id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                //console.log(response.data);
                if (response.respuesta == true) {
                    let ht = '';
                    $(response.data).each(function(i, data) {
                        ht += '<div class="col-md-6 col-xl-3">'
                        ht += '<div class="card"><a href="javascript:void(0);" onclick="ver_submenus(' + data.me_id + ')"><div class="card-body">'
                        ht += '<div class="mb-1" style="display: flex;justify-content: center;">';
                        ht += data.me_menu
                        ht += '</div></div></a></div></div>';
                    });
                    $("#content_menu").html(ht);
                    $("#p_" + id).addClass('active');
                    menu_activo = id;
                    $("#load_m").hide();

                }
            },
        });
    }

    function ver_submenus(id) {
        $("#load_m").show();
        console.log(json_menu_);
        $.ajax({
            url: "/get_submenu/" + id,
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log(response.data);
                if (response.respuesta) {
                    let ht = '';
                    let aux = 0;
                    $(response.data).each(function(i, data) {
                        ht += ' <div class="col-xl-3 col-md-4 col-sm-6"><div class="card p-0 "><div class="d-flex align-items-center px-3 pt-3">'
                        ht += '<label class="custom-control form-checkbox">'
                        $(json_menu_).each(function(i, res) {
                            if (res.um_id_submenu == data.sme_id) {
                                ht += '<input type="checkbox" class="custom-control-input" name="example-checkbox2" onchange="agregar_sel({{$ced}},' + data.sme_id + ')" value="' + data.sme_id + '" checked>'
                                return false;
                            }
                        })
                        if (aux == 0) {
                            ht += '<input type="checkbox" class="custom-control-input" name="example-checkbox2" onchange="agregar_sel({{$ced}},' + data.sme_id + ')" value="' + data.sme_id + '">'
                        }
                        ht += '<span class="custom-control-label"></span></label></div>'
                        ht += '<div class="card-body pt-0 text-center">'
                        ht += '<h6 class="mb-1 font-weight-semibold">' + data.sme_submenu + '</h6>'
                        ht += '<span class="text-muted tx-11">' + data.sme_link + '</span></div></div></div>'
                    });
                    $("#content_submenu").html(ht);
                    $("#load_m").hide();

                }
            },
        });
    }


    function agregar_sel(id_user, id_submenu) {
        let aux_ = 0;
        if (json_menu_.length == 0) {
            let obj = {
                um_id: '',
                um_id_usuario: id_user,
                um_id_submenu: id_submenu,
                um_estado: 0
            };

            json_menu_.push(obj);
        } else {
            json_menu_.forEach((element, p) => {
                if (element.um_id_submenu == id_submenu) {
                    if (element.um_id == 0) {
                        aux_ = 1;
                        json_menu_.splice(p, 1);
                        console.log(id_submenu + " se elimino");
                    } else {
                        if (element.um_estado == 2) {
                            element.um_estado = 1;
                        } else {
                            element.um_estado = 2;
                        }
                        aux_ = 1;
                    }

                }
            });
            if (aux_ == 0) {
                let obj = {
                    um_id: 0,
                    um_id_usuario: id_user,
                    um_id_submenu: id_submenu,
                    um_estado: 0
                };
                json_menu_.push(obj);
            }
        }
        console.log(json_menu_);
        //$("#tramites_selec").show();
        //cont_tramites();
    }

    $("#btn_guardar_asignacion").click(function() {
        var token = $("#csrf-token").val();
        let id = $("#id_user").val();
        // json_menu_ = JSON.parse($("#json_menus").val())
        let datos = {
            dat: json_menu_,
            ced: id,
        };
        $.ajax({
            url: "/store_asignacion_menu",
            type: "POST",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": token
            },
            data: datos,
            success: function(response) {
                if (response.respuesta == "true") {
                    $("#json_menus").val(response.data);
                    json_menu_ = JSON.parse($("#json_menus").val());
                    Swal.fire(
                        "Estimado",
                        "se guardo la asignación correctamente.",
                        "success"
                    );
                }
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