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
                    <h1 class="content-title mb-0 my-auto color-titulo">Nómina de Empleado</h1>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-añadir-empleado">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo">Añadir</strong>
                    </a>
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
            <div class="card box-sha">
                <div class="card-body">
                    <div class="row row-sm">
                        <!--<div class="card-header">
									<h3 class="card-title"></h3>
								</div>-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <div id="div-table-empleado"></div>
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

<!-- INICIO MODAL NOTIFICAR EMPLEADO-->
<div class="modal" id="modal-notificacion">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Notificación</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form class="form" novalidate id="form-notificacion-empleado" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                    <input type="hidden" name="txt-id-empleado" id="txt-id-empleado">
                    <div class="row">
                        <div class="col-md-12 mg-t-10">
                            <strong>Fecha de Terminación</strong>
                            <input class="form-control" name="txt-fecha-terminacion" id="txt-fecha-terminacion"
                                placeholder="Ingresar fecha de terinacion" type="date"
                                onkeypress="mayus(this);"></input>
                        </div>
                        <div class="col-md-12 mg-t-10">
                            <strong>Causa de Salida</strong>
                            <select name="select-causa" id="select-causa" class="form-control">
                                <option data-bs-toggle="tooltip" data-bs-original-title="Tooltip on the bottom"
                                    value="0">SELECCIONE CAUSA</option>
                                <option value="1" title="A.- POR RENUNCIA VOLUNTARIA FORMALMENTE PRESENTADA">A.- POR
                                    RENUNCIA VOLUNTARIA FORMALMENTE PRESENTADA</option>
                                <option value="2"
                                    title="B.- POR INCAPACIDAD ABSOLUTA O PERMANENTE DECLARADA JURIDICAMENTE">B.- POR
                                    INCAPACIDAD ABSOLUTA O PERMANENTE DECLARADA JURIDICAMENTE</option>
                                <option value="3" title="C.- POR SUPRESIÓN DEL PUESTO">C.- POR SUPRESIÓN DEL PUESTO
                                </option>
                                <option value="4"
                                    title="D.- POR PÉRDIDAS DE LOS DERECHOS DE CIUDADANIA DECLARADA MEDIANTE SENTENCIA EJECUTORIADA">
                                    D.- POR PÉRDIDAS DE LOS DERECHOS DE CIUDADANIA DECLARADA MEDIANTE SENTENCIA
                                    EJECUTORIADA</option>
                                <option value="5"
                                    title="E.- POR REMOCIÓN, TRATANDOSE DE LOS SERVIDORES DE LIBRE NOMBRAMIENTO Y REMOCIÓN, DE PERIODO FIJO, EN CASO DE CENSACIÓN DEL NOMBRAMIENTO PROVISIONAL Y POR FALTA DE REQUISITOS O TRÁMITE ADECUADO PARA OCUPAR EL PUESTO. LA REMOCIÓN NO CONSTITUYE SANCIÓN">
                                    E.- POR REMOCIÓN, TRATANDOSE DE LOS SERVIDORES DE LIBRE NOMBRAMIENTO Y REMOCIÓN, DE
                                    PERIODO FIJO, EN CASO DE CENSACIÓN DEL NOMBRAMIENTO PROVISIONAL Y POR FALTA DE
                                    REQUISITOS O TRÁMITE ADECUADO PARA OCUPAR EL PUESTO. LA REMOCIÓN NO CONSTITUYE
                                    SANCIÓN</option>
                                <option value="6" title="F.- POR DESTITUCIÓN">F.- POR DESTITUCIÓN</option>
                                <option value="7" title="G.- POR REVOCATORIA DEL MANDATO">G.- POR REVOCATORIA DEL
                                    MANDATO</option>
                                <option value="8" title="H.- POR REVOCATORIA DEL MANDATO">H.- POR TERMINO DE PLAZO
                                    CONTRACTUAL</option>
                                <option value="9" title="I.- POR REVOCATORIA DEL MANDATO">I.- POR FALLECIMIENTO</option>
                                <option value="10" title="J.- POR REVOCATORIA DEL MANDATO">J.- POR VISTO BUENO</option>
                                <option value="11" title="K.- POR REVOCATORIA DEL MANDATO">K.- POR SUMARIO
                                    ADMINISTRATIVO
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn-guardar-notificacion" type="button"><i
                        class="fa fa-save"></i> Notificar</button>
                <button class="btn btn-success-gradient btn-movi" id="btn-modal-eliminar-notificacion" type="button"><i
                        class="fa fa-trash"></i> Quitar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL NOTIFICAR EMPLEADO-->

<!--INICIO MODAL ELIMINAR NOTIFICACION -->
<div class="modal show" id="modal-notificacion-e" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <form class="form" novalidate id="form-notificacion-e" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                    <input type="hidden" id="txt-id-empleado-e" name="txt-id-empleado-e">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button> <i
                        class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar la Notificacion</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal"
                        type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-notificacion" type="button"><i
                            class="fa fa-times-circle"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR CATALOGO -->


@endsection

@section('js')
<script type='text/javascript' src='/js/Empleado/empleado.js'></script>
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