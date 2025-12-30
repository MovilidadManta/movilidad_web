@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
<style>
    .file-upload {
        background-color: #ffffff;
        width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
    }

    .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }

    .drag-text {
        text-align: center;
    }

    .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
    }

    .file-upload-image {
        max-height: 200px;
        max-width: 200px;
        margin: auto;
        padding: 20px;
    }

    .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .remove-image:active {
        border: 0;
        transition: all .2s ease;
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Registrar Empleado</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
            </div>
        </div>
        <!--<div class="d-flex my-xl-auto right-content">
                <div class="pe-1 mb-xl-0">
                    <button type="button" class="btn btn-info btn-icon me-2 btn-b"><i class="mdi mdi-filter-variant"></i></button>
                </div>
                <div class="pe-1 mb-xl-0">
                    <button type="button" class="btn btn-danger btn-icon me-2"><i class="mdi mdi-star"></i></button>
                </div>
                <div class="pe-1 mb-xl-0">
                    <button type="button" class="btn btn-warning  btn-icon me-2"><i class="mdi mdi-refresh"></i></button>
                </div>
                <div class="mb-xl-0">
                    <div class="btn-group dropdown">
                        <button type="button" class="btn btn-primary">14 Aug 2019</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuDate" x-placement="bottom-end">
                            <a class="dropdown-item" href="javascript:void(0);">2015</a>
                            <a class="dropdown-item" href="javascript:void(0);">2016</a>
                            <a class="dropdown-item" href="javascript:void(0);">2017</a>
                            <a class="dropdown-item" href="javascript:void(0);">2018</a>
                        </div>
                    </div>
                </div>
            </div>-->

    </div>
    <!-- breadcrumb -->



    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <!--div-->
            <form class="form" id="form-empleado" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <input type="hidden" name="txt-estado-imagen" id="txt-estado-imagen">
                <input type="hidden" name="txt-prioridad" id="txt-prioridad">
                <input type="hidden" name="txt-usuario" id="txt-usuario" value="{{Session::get('usuario')}}">
                <div class="card box-sha">
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="card-header top-linea">
                                <h4 class="ti-color">Información Personal</h4>
                            </div>
                            <div class="row row-sm card-body">
                                <div class="col-lg">
                                    <strong>Cédula <span id="va-ced"></span></strong>
                                    <input class="form-control" name="txt-cedula" id="txt-cedula"
                                        placeholder="Ingresar cédula" type="text">
                                </div>
                                <div class="col-lg mg-t-10 mg-lg-t-0">
                                    <strong>Nombres</strong>
                                    <input class="form-control" name="txt-nombre" id="txt-nombre"
                                        placeholder="Ingresar Nombre" type="text" onkeypress="mayus(this);">
                                </div>
                                <div class="col-lg mg-t-10 mg-lg-t-0">
                                    <strong>Apellidos</strong>
                                    <input class="form-control" name="txt-apellido" id="txt-apellido"
                                        placeholder="Ingresar Apellido" type="text" onkeypress="mayus(this);">
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg mg-t-10 mg-lg-t-0">
                                    <strong>Teléfono</strong>
                                    <input class="form-control" name="txt-telefono" id="txt-telefono"
                                        placeholder="Ingresar Teléfono" type="text">
                                </div>
                                <div class="col-lg mg-t-10 mg-lg-t-0">
                                    <strong>Género</strong>
                                    <select name="select-sexo" id="select-sexo" class="form-control">
                                        <option value="0">SELECCIONE GENERO</option>
                                        <option value="M">MASCULINO</option>
                                        <option value="F">FEMENINO</option>
                                    </select>
                                </div>
                                <div class="col-lg mg-t-10 mg-lg-t-0">
                                    <strong>Fecha nacimiento</strong>
                                    <input class="form-control" name="txt-fecha-nacimiento" id="txt-fecha-nacimiento"
                                        type="date">
                                </div>
                                <div class="col-lg mg-t-10 mg-lg-t-0">
                                    <strong>Edad</strong>
                                    <input class="form-control" name="txt-edad" id="txt-edad"
                                        placeholder="Ingresar Edad" type="text">
                                </div>
                                <div class="col-lg mg-t-10 mg-lg-t-0">
                                    <strong>Tipo de sangre</strong>
                                    <input class="form-control" name="txt-tipo-sangre" id="txt-tipo-sangre"
                                        placeholder="Ingresar tipo de sangre" type="text" onkeypress="mayus(this);">
                                </div>
                            </div>

                            <div class="row row-sm mg-t-20">
                                <div class="col-lg">
                                    <strong>Dirección</strong>
                                    <textarea class="form-control" name="txt-direccion-domicilio"
                                        id="txt-direccion-domicilio" placeholder="Ingresar Direccion" rows="4"
                                        onkeypress="mayus(this);"></textarea>
                                </div>
                                <div class="col-lg mg-t-10 mg-lg-t-0">
                                    <strong>Foto</strong>
                                    <input type="file" class="dropify" name="txt-ruta-foto" id="txt-ruta-foto"
                                        data-max-file-size="3M" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                    <div class="card box-sha">
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="card-header top-linea">
                                    <h4 class="ti-color">Datos del contrato</h4>
                                </div>
                                <div class="row row-sm card-body">
                                    <div class="col-lg">
                                        <strong>Dirección</strong>
                                        <select name="select-direccion" id="select-direccion"
                                            class="form-control form-select select2">
                                            <option value="0">SELECCIONE DIRECCIÓN</option>
                                        </select>
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Jefatura/SubDirección</strong>
                                        <select name="select-jefatura-subdireccion" id="select-jefatura-subdireccion"
                                            class="form-control">
                                            <option value="0">SELECCIONE JEFATURA</option>
                                        </select>
                                    </div>

                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Cargo</strong>
                                        <input type="hidden" class="form-control" name="text-cargo" id="text-cargo"
                                            placeholder="Ingresar Cargo" type="text" onkeypress="mayus(this);">
                                        <select name="select-cargo" id="select-cargo" onchange="get_cargo_in()"
                                            class="form-control">
                                            <option value="0">SELECCIONE CARGO</option>
                                        </select>
                                    </div>
                                    <!--<div class="col-lg mg-t-10 mg-lg-t-0">
                                <strong>Cargo Superior</strong>
                                <select name="select-cargo-superior" id="select-cargo-superior" class="form-control">
                                    <option value="0">SELECCIONE CARGO SUPERIOR</option>
                                </select>
                            </div>-->
                                </div>
                                <div class="row row-sm ">
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Regimen Contractual</strong>
                                        <select name="select-regimen-contrato" id="select-regimen-contrato"
                                            class="form-control">
                                            <option value="0">SELECCIONE REGIMEN</option>
                                            <option value="1">CODIGO DE TRABAJO</option>
                                            <option value="2">LOEP</option>
                                            <option value="3">LOSEP</option>
                                            <option value="4">PROFESIONAL</option>
                                        </select>
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Modalidad Contractual</strong>
                                        <select name="select-tipo-contrato" id="select-tipo-contrato"
                                            class="form-control">
                                            <option value="0">SELECCIONE MODALIDAD</option>
                                            <option value="1">NOMBRAMIENTO DE LIBRE REMOCIÓN</option>
                                            <option value="2">OCASIONAL</option>
                                            <option value="3">NOMBRAMIENTO PROVISIONAL</option>
                                            <option value="4">INDEFINIDO</option>
                                            <option value="5">COLECTIVO</option>
                                            <option value="6">NOMBRAMIENTO PERMANENTE</option>
                                            <option value="7">SERVICIOS PROFESIONALES</option>
                                            <option value="8">COMISIÓN DE SERVICIOS</option>
                                            <option value="9">CONVENIO INSTITUCIONALES</option>
                                        </select>
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Remuneración</strong>
                                        <input class="form-control" name="txt-remuneracion" id="txt-remuneracion"
                                            placeholder="Ingresar Remuneracion" type="text">
                                    </div>
                                </div>

                                <div class="row row-sm mg-t-20">
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Fecha de Ingreso</strong>
                                        <input class="form-control" name="txt-fecha-ingreso" id="txt-fecha-ingreso"
                                            placeholder="Ingresar cedula" type="date">
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0">
                                        <strong>Fecha de Salida</strong>
                                        <input class="form-control" name="txt-fecha-salida" id="txt-fecha-salida"
                                            placeholder="Ingresar Nombre" type="date">
                                    </div>
                                    <div class="col-lg">
                                        <strong>Titulo</strong>
                                        <input class="form-control" name="txt-titulo" id="txt-titulo"
                                            placeholder="Ingresar Titulo" onkeypress="mayus(this);"></input>
                                    </div>
                                </div>

                                <div class="row row-sm mg-t-20">
                                    <div class="col-lg">
                                        <strong>Observación</strong>
                                        <textarea class="form-control" name="txt-observacion" id="txt-observacion"
                                            placeholder="Ingresar observación" rows="2"
                                            onkeypress="mayus(this);"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                    <div class="card box-sha">
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="card-header top-linea">
                                    <table>
                                        <tr class="flex-tr-tab">
                                            <td align="left">
                                                <h4 class="ti-color">Datos de Prioridad</h4>
                                            </td>
                                            <td align="center">
                                                <label
                                                    class="custom-control custom-control-ta form-checkbox custom-control-md">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="checkbox-prioridad" id="checkbox-prioridad">
                                                    <span
                                                        class="custom-control-label custom-control-label-md  tx-17"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row row-sm card-body">
                                    <div class="col-lg" id="div-select-grupo-prioridad">
                                        <!--<strong>Grupo prioritario</strong>
                            <select name="select-grupo-prioridad" id="select-grupo-prioridad" class="form-control">
                                <option value="0">Seleccione grupo</option>
                                <option value="1">Discapacidad</option>
                                <option value="2">Sustituto</option>
                                <option value="3">Enfermedad catastrófica</option>
                                <option value="4">Maternidad</option>
                                <option value="5">Estado de gestación</option>
                                <option value="6">Adulto mayor</option>
                            </select>-->
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0" id="div-opcion-1">
                                        <!--<strong>Porcentaje</strong>
                            <input class="form-control" name="txt-porcentaje" id="txt-porcentaje" placeholder="Ingresar Porcentaje" type="text">-->
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0 " id="div-opcion-2">
                                        <!--<strong>Porcentaje</strong>
                            <input class="form-control" name="txt-porcentaje" id="txt-porcentaje" placeholder="Ingresar Porcentaje" type="text">-->
                                    </div>
                                    <div class="col-lg mg-t-10 mg-lg-t-0 none marg-a" id="div-btn-add">
                                        <a class="btn background-btn-nuevo pad-nu " id="btn-añadir-prioridad">
                                            <i class="fa fa-plus-square color-btn-nuevo"></i>
                                            <strong class="color-btn-nuevo">Añadir</strong>
                                        </a>
                                    </div>
                                </div>
                                <div class="row row-sm card-body">
                                    <div class="col-lg" id="div-table-prioridad">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-12 cen ubica" align="center">
                    <button class="btn btn-primary btn btn-success-gradient btn-movi" id="btn-guardar-empleado"
                        type="button"><i class="fa fa-save"></i> Guardar</button>
                    <!--<button class="btn btn-primary btn btn-success-gradient btn-movi" id="btn-guardar-o" type="button"><i class="fa fa-save"></i> Guardaeeeeeeer</button>-->
                    <!--<button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>-->
                </div>


            </form>
        </div>
        <!--/div-->
    </div>
    <!-- row closed -->
</div>
<!-- Container closed -->

@endsection

@section('js')
<script type='text/javascript' src='/js/Empleado/registrar_empleado.js'></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#txt-estado-imagen").val("true")
                $('.image-upload-wrap').hide();

                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();

                $('.image-title').html(input.files[0].name);
            };

            reader.readAsDataURL(input.files[0]);

        } else {
            removeUpload();
        }
    }

    function removeUpload() {
        $("#txt-estado-imagen").val("false")
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }

    $('.image-upload-wrap').bind('dragover', function() {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function() {
        $('.image-upload-wrap').removeClass('image-dropping');
    });
</script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif