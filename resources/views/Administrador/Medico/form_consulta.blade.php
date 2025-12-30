@extends('Administrador.Layout.app')

@section('css')
<script src="https://kit.fontawesome.com/2afebe029b.js" crossorigin="anonymous"></script>
<style>
    .input-group {
        width: auto !important;
    }

    .w25 {
        width: 25em;
    }
</style>
@endsection

@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1"> <i class="fa-solid fa-stethoscope"></i> Consulta médica</h2>
        </div>
    </div>
    <div class="d-flex my-xl-auto right-content">
        <div class="mb-xl-0">
            <div class="btn-group mb-2 mt-2">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
                    <i class="fe fe-more-vertical"></i>
                </button>
                <ul class="dropdown-menu" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(5px, 42px);" data-popper-placement="bottom-start">
                    <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>

                    <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>
                </ul>
            </div>
            <button type="button" onclick="open_modal('modal-create');" class="btn btn-primary">TERMINAR CONSULTA</button>
        </div>
    </div>

</div>

<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="main-contact-info-header pt-3">
                    @foreach($paciente as $p)

                    <div class="media">
                        <div class="main-img-user">
                            <img alt="avatar" src="/imagenes_empleados/{{$p->emp_cedula}}.jpeg">
                        </div>
                        <div class="media-body">
                            <h5>{{$p->emp_nombre}} {{$p->emp_apellido}}</h5>
                            <p>{{$p->ca_cargo}} - {{$p->per_perfil}} </p>
                            <!-- <nav class="contact-info">
                                <a href="javascript:void(0);" class="contact-icon border tx-inverse" data-bs-toggle="tooltip" title="" data-bs-original-title="Call" aria-label="Call"><i class="fe fe-phone"></i></a>
                                <a href="javascript:void(0);" class="contact-icon border tx-inverse" data-bs-toggle="tooltip" title="" data-bs-original-title="Video" aria-label="Video"><i class="fe fe-video"></i></a>
                                <a href="javascript:void(0);" class="contact-icon border tx-inverse" data-bs-toggle="tooltip" title="" data-bs-original-title="message" aria-label="message"><i class="fe fe-message-square"></i></a>
                                <a href="javascript:void(0);" class="contact-icon border tx-inverse" data-bs-toggle="tooltip" title="" data-bs-original-title="Add to Group" aria-label="Add to Group"><i class="fe fe-user-plus"></i></a>
                                <a href="javascript:void(0);" class="contact-icon border tx-inverse" data-bs-toggle="tooltip" title="" data-bs-original-title="Block" aria-label="Block"><i class="fe fe-slash"></i></a>
                            </nav>-->
                        </div>
                    </div>
                    @endforeach

                    <div class="main-contact-action btn-list pt-3">
                        <a href="javascript:void(0);" class="btn ripple btn-primary text-white btn-icon" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Edit Profile" aria-label="Edit Profile"><i class="fe fe-edit"></i></a>
                        <a href="javascript:void(0);" class="btn ripple btn-secondary text-white btn-icon" data-bs-placement="top" data-bs-toggle="tooltip" title="" data-bs-original-title="Delete Profile" aria-label="Delete Profile"><i class="fe fe-trash-2"></i></a>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li><a href="#tab4" class="nav-link " data-bs-toggle="tab">Historial</a></li>
                                        <li><a href="#tab4" class="nav-link active" data-bs-toggle="tab">Notas de padecimiento</a></li>
                                        <li><a href="#tab5" class="nav-link" data-bs-toggle="tab">Exploracion Topografica</a></li>
                                        <li><a href="#tab6" class="nav-link" data-bs-toggle="tab">Diagnóstico y Tratamiento</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab4">
                                        <div class="col-12 col-sm-6 col-lg-6 col-xl-6">
                                            <div class="card card-warning">
                                                <div class="card-header pb-0">
                                                    <h5 class="card-title mb-0 pb-0">Signos vitales</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade active show" id="tasktab-1" role="tabpanel">
                                                            <div class="">
                                                                <div class="tasks">
                                                                    <div class=" task-line primary">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            XML Import &amp; Export
                                                                        </a>
                                                                        <div class="time">
                                                                            12:00 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input checked="" type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line pink">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Database Optimization
                                                                        </a>
                                                                        <div class="time">
                                                                            02:13 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line success">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Create Wireframes
                                                                        </a>
                                                                        <div class="time">
                                                                            06:20 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line warning">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Develop MVP
                                                                        </a>
                                                                        <div class="time">
                                                                            10: 00 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks mb-0">
                                                                    <div class="task-line teal">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Design Evommerce
                                                                        </a>
                                                                        <div class="time">
                                                                            10: 00 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="tasktab-2" role="tabpanel">
                                                            <div class="">
                                                                <div class="tasks">
                                                                    <div class=" task-line teal">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Management meeting
                                                                        </a>
                                                                        <div class="time">
                                                                            06:30 AM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line danger">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Connect API to pages
                                                                        </a>
                                                                        <div class="time">
                                                                            08:00 AM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line purple">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Icon change in Redesign App
                                                                        </a>
                                                                        <div class="time">
                                                                            11:20 AM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line warning">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Test new features in tablets
                                                                        </a>
                                                                        <div class="time">
                                                                            02: 00 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line success">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Design Logo
                                                                        </a>
                                                                        <div class="time">
                                                                            04: 00 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="tasktab-3" role="tabpanel">
                                                            <div class="">
                                                                <div class="tasks">
                                                                    <div class=" task-line info">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Design a Landing Page
                                                                        </a>
                                                                        <div class="time">
                                                                            06:12 AM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line danger">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Food Delivery Mobile Application
                                                                        </a>
                                                                        <div class="time">
                                                                            3:00 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line warning">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Export Database values
                                                                        </a>
                                                                        <div class="time">
                                                                            03:20 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line pink">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Write Simple Python Script
                                                                        </a>
                                                                        <div class="time">
                                                                            04: 00 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="tasks">
                                                                    <div class="task-line success">
                                                                        <a href="javascript:void(0);" class="span">
                                                                            Write Simple Anugalr Program
                                                                        </a>
                                                                        <div class="time">
                                                                            05: 00 PM
                                                                        </div>
                                                                    </div>
                                                                    <label class="checkbox">
                                                                        <span class="check-box">
                                                                            <span class="ckbox"><input type="checkbox"><span></span></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab5">
                                        <p>dignissimos ducimus qui blanditiis praesentium voluptatum
                                            deleniti atque corrupti quos dolores et quas molestias
                                            excepturi sint occaecati cupiditate non provident, similique
                                            sunt in culpa qui officia deserunt mollitia animi, id est
                                            laborum et dolorum fuga.</p>
                                        <p>Et harum quidem rerum facilis est et expedita distinctio. Nam
                                            libero tempore, cum soluta nobis est eligendi optio cumque
                                            nihil impedit quo minus id quod maxime</p>
                                        <p class="mb-0">placeat facere possimus, omnis voluptas
                                            assumenda est, omnis dolor repellendus.</p>
                                    </div>
                                    <div class="tab-pane" id="tab6">
                                        <p>praesentium voluptatum deleniti atque corrupti quos dolores
                                            et quas molestias excepturi sint occaecati cupiditate non
                                            provident,</p>
                                        <p class="mb-0">similique sunt in culpa qui officia deserunt
                                            mollitia animi, id est laborum et dolorum fuga. Et harum
                                            quidem rerum facilis est et expedita distinctio. Nam libero
                                            tempore, cum soluta nobis est eligendi optio cumque nihil
                                            impedit quo minus id quod maxime placeat facere possimus,
                                            omnis voluptas assumenda est, omnis dolor repellendus.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear una enfermedad</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="ip_categoria" class="col-form-label">Categoria:</label>
                        <select class="form-control" id="cmb_categoria">
                            <option value="0">Selecciones un tipo</option>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ip_enfermedad" class="col-form-label">Enfermedad:</label>
                        <input type="text" class="form-control" id="ip_enfermedad">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary" id="btn_add" onclick="save_enfermedad()">Guardar enfermedad</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type='text/javascript' src='/js/Medico/app_demo.js'></script>

<script>
    $("#ip_paciente").keypress(function(tecla) {
        if (tecla.which == 13) {
            buscar_paciente();
        }
    });
    const buscar_paciente = () => {
        load_btn("btn_buscar_p");
        let paciente = $("#ip_paciente").val();
        if (paciente == "") {
            alert_error();
            $("#ip_paciente").focus();
            onload_btn("btn_buscar_p", '<i class="fa-solid fa-hospital-user"></i> Buscar paciente');
        } else {
            let datos = {
                paciente
            };
            let token = $("#csrf-token").val();
            _AJAX_("/Get_paciente", "POST", token, datos, 4);
        }

    }
    table_responsive("#table_re");
    const save_enfermedad = () => {
        load_btn("btn_add");
        let categoria = $("#cmb_categoria").val();
        let enfermedad = $("#ip_enfermedad").val();
        let token = $("#csrf-token").val();
        if (categoria == "") {
            alert_error();
            $("#cmb_categoria").focus();
            onload_btn("btn_add", "Guardar enfermedad");
        } else if (enfermedad == "") {
            alert_error();
            $("#ip_enfermedad").focus();
            onload_btn("btn_add", "Guardar enfermedad");
        } else {
            let datos = {
                categoria,
                enfermedad
            };
            let token = $("#csrf-token").val();
            _AJAX_("/store_enfermedad", "POST", token, datos, 3);
        }
    }
</script>
@endsection