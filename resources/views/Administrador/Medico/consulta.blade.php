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
            <button type="button" onclick="open_modal('modal-create');" class="btn btn-primary">Nuevo</button>
        </div>
    </div>

</div>

<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0"></h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <p class="tx-12 tx-gray-500 mb-2">Busqueda de pacientes</p>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="input-group">
                        <input type="text" class="w25" id="ip_paciente" placeholder="Ingrese los apellidos o el  número de cédula">
                        <span class="input-group-btn">
                            <button class="btn ripple btn-primary" id="btn_buscar_p" onclick="buscar_paciente();" type="button"><i class="fa-solid fa-hospital-user"></i> Buscar paciente</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0"></h4>
                </div>
                <p class="tx-12 tx-gray-500 mb-2">Resultados de busqueda (2)</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered border text-nowrap mb-0" id="removecolumns-edit">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Departamento</th>
                                <th>Cargo</th>
                                <th>E-mail</th>
                                <th name="bstable-actions"></th>
                            </tr>
                        </thead>
                        <tbody id="tpaciente">


                        </tbody>
                    </table>
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