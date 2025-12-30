@extends('Administrador.Layout.app')

@section('css')
@endsection

@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="left-content">
        <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Enfermedades</h2>
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
                <p class="tx-12 tx-gray-500 mb-2">Listado de tipos de enfermedades</p>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="div-table">
                    <table class="table mg-b-0 text-md-nowrap" id="table_re">
                        <thead class="background-thead">
                            <tr>
                                <th class="color-th">ID</th>
                                <th class="color-th">CATEGORIA</th>
                                <th class="color-th">ENFERMEDAD</th>
                                <th class="color-th">ESTADO</th>
                                <th class="color-th">OPCION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enfermedades as $t)
                            <tr>
                                <th scope="row">{{$t->id}}</th>
                                <td>{{$t->categoria}}</td>
                                <td>{{$t->enfermedad}}</td>
                                @if($t->estado)
                                <td class="color-td" align="center"><span class="badge bg-success me-1">Activo</span></td>
                                @else
                                <td class="color-td" align="center"><span class="badge bg-danger me-1">Inactivo</span></td>
                                @endif
                                <td>
                                    @if($t->estado)
                                    <a href="#" onclick="editar_data({{$t->id}},'{{$t->enfermedad}}')"><i class="fa fa-edit"></i> Editar</a>
                                    <a href="#" onclick="delete_data({{$t->id}},'{{$t->enfermedad}}')"><i class="fa fa-trash-o"></i> Eliminar</a>
                                    @else
                                    <a href="#"><i class="fa fa-reply" aria-hidden="true"></i> recuperar</a>
                                    @endif

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
                            @foreach($tipos as $t)
                            <option value="{{$t->id}}">{{$t->categoria}}</option>
                            @endforeach
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