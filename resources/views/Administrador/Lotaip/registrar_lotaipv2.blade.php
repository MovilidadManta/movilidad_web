@if(Session::get('usuario'))
@extends('Administrador.Layout.app')

@section('css')
<style>
    .file-drop-area {
        margin-left: 40px;
        position: relative;
        display: flex;
        align-items: center;
        width: 450px;
        max-width: 100%;
        padding: 25px;
        border: 1px dashed rgb(59 57 57 / 40%);
        border-radius: 3px;
        transition: 0.2s;

        &.is-active {
            background-color: rgba(255, 255, 255, 0.05);
        }
    }

    .fake-btn {
        flex-shrink: 0;
        background-color: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 3px;
        padding: 8px 15px;
        margin-right: 10px;
        font-size: 12px;
        text-transform: uppercase;
    }

    .file-msg {
        font-size: small;
        font-weight: 300;
        line-height: 1.4;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        cursor: pointer;
        opacity: 0;

        &:focus {
            outline: none;
        }
    }

    .verde {
        color: #4CAF50;
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
                    <h2 class="content-title mb-0 my-auto color-titulo">Literales LOTAIP {{$id}}</h2>
                    <!--<span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Form-Elements</span>-->
                </div>
                <div class="col-md-6">
                    <a class="btn background-btn-nuevo pad-nu float-btn-nuevo" id="btn-nuevo-literal-lotaip">
                        <i class="fa fa-plus-square color-btn-nuevo"></i>
                        <strong class="color-btn-nuevo"> Nuevo</strong>
                    </a>
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
                        <div class="card-body">
                            <div class="panel panel-primary tabs-style-1">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            @php
                                            $aux=0;
                                            $aux_=0;
                                            @endphp
                                            @foreach(json_decode($meses) as $m)
                                            @php $aux_ = $aux+1; @endphp
                                            @if($aux==0)
                                            <li class="nav-item"><a href="#tab{{$aux_}}" class="nav-link active" data-bs-toggle="tab">{{$m}}</a></li>
                                            @else
                                            <li class="nav-item"><a href="#tab{{$aux_}}" class="nav-link" data-bs-toggle="tab">{{$m}}</a></li>
                                            @endif
                                            @php
                                            $aux++;
                                            @endphp
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                    <div class="tab-content">
                                        @php
                                        $auxc =0;
                                        $auxc_ =0;
                                        @endphp
                                        <input type="hidden" id="ip_id_lotaip" value='{{$id}}' />

                                        @foreach(json_decode($meses) as $m)
                                        @php $auxc_ = $auxc+1; @endphp
                                        @if($auxc==0)
                                        <div class="tab-pane active" id="tab{{$auxc_}}">
                                            <input type="hidden" name="ip_id_mes{{$id}}" value='{{$auxc_}}' />
                                            <div class="">
                                                <ul class="list-group wd-md-100p users-list-group">
                                                    @foreach($literales as $l)
                                                    <li class="list-group-item d-sm-flex d-block align-items-center">
                                                        <div>
                                                            <h6 class="tx-15 mb-1 tx-inverse tx-semibold mg-b-0">{{$l->li_literal}}
                                                                <input type="hidden" value="{{$l->li_id}}" id="ip_id_literal_lotaip_{{$l->li_id}}">
                                                        </div>
                                                        <div class="file-drop-area">
                                                            <span class="fake-btn">Buscar un archivo</span>
                                                            <span class="file-msg">o arrastre aqui el archivo</span>
                                                            <input class="file-input" id="file_{{$l->li_id}}" onchange="subir_documento({{$l->li_id}})" type="file" accept="application/pdf">
                                                        </div>
                                                        <div id="t_{{$l->li_id}}" style="display:none">
                                                            <div class="d-flex float-start ms-auto">
                                                                <a href="/archivos_lotaip/9_1_20230703153002reporteJasper.pdf.pdf" target="_blank" class="btn pad-nu"> <i class="far fa-file-pdf color-icono-pdf"></i> <strong class="color-btn-nuevo"></strong> </a>
                                                                <span class="verde">
                                                                    <i class="fa fa-check-circle"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <button type="button" id="13" class="tam-btn btn btn-info"><i class="fa fa-edit tam-icono"></i></button>
                                                            </div>
                                                        </div>

                                                    </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                        @else
                                        <div class="tab-pane" id="tab{{$auxc_}}">
                                            <input type="text" name="ip_id_mes{{$id}}" value='{{$auxc_}}'>
                                            <div class="">
                                                <ul class="list-group wd-md-100p users-list-group">
                                                    @foreach($literales as $l)
                                                    <li class="list-group-item d-sm-flex d-block align-items-center">
                                                        <div>
                                                            <h6 class="tx-15 mb-1 tx-inverse tx-semibold mg-b-0">{{$l->li_literal}}
                                                            </h6><span class="d-block tx-13 text-muted">{{$l->li_id}}</span>
                                                        </div>
                                                        <div class="d-flex float-start ms-auto">
                                                            <a href="/archivos_lotaip/9_1_20230703153002reporteJasper.pdf.pdf" target="_blank" class="btn pad-nu"> <i class="far fa-file-pdf color-icono-pdf"></i> <strong class="color-btn-nuevo"></strong> </a>
                                                            <a href="javascript:void(0);" class="btn btn-light btn-icon">
                                                                <div class=""><i class="bx bx-minus"></i></div>
                                                            </a>
                                                        </div>
                                                    </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                        @php
                                        $auxc++;
                                        @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                <div id="div-table-lotaip">
                                    <form class="form" novalidate id="form-literal-lotaip" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                                        <input type="hidden" name="txt-id-lotaip" id="txt-id-lotaip" value="{{$id}}">
                                        <input type="hidden" name="txt-id-literal-rendicion-cuenta-e" id="txt-id-literal-rendicion-cuenta-e">
                                        <input type="hidden" name="ip_id_lotaip_datelle" id="ip_id_lotaip_datelle">
                                        <div class="row row-sm card-body">
                                            <div class="col-lg">
                                                <strong>Literal</strong>
                                                <select name="select-literal-lotaip" id="select-literal-lotaip" class="form-control form-select select2">
                                                    <option value="0">SELECCIONE LITERAL</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row row-sm card-body">
                                            <div class="col-lg">
                                                <strong>Mes</strong>
                                                <select name="select-mes" id="select-mes" class="form-control">
                                                    <option value="0">SELECCIONE MES</option>
                                                    <option value="1">ENERO</option>
                                                    <option value="2">FEBRERO</option>
                                                    <option value="3">MARZO</option>
                                                    <option value="4">ABRIL</option>
                                                    <option value="5">MAYO</option>
                                                    <option value="6">JUNIO</option>
                                                    <option value="7">JULIO</option>
                                                    <option value="8">AGOSTO</option>
                                                    <option value="9">SEPTIEMBRE</option>
                                                    <option value="10">OCTUBRE</option>
                                                    <option value="11">NOVIEMBRE</option>
                                                    <option value="12">DICIEMBRE</option>
                                                </select>
                                            </div>
                                            <div class="col-lg mg-t-10 mg-lg-t-0">
                                                <strong>Archivo</strong>
                                                <input class="dropify" type="file" name="txt-ruta-archivo" id="txt-ruta-archivo" data-max-file-size="3M">
                                            </div>
                                            <div class="col-lg mg-t-10 mg-lg-t-0 marg-a">
                                                <a class="btn background-btn-nuevo pad-nu " id="btn-añadir-literal-lotaip">
                                                    <i class="fa fa-plus-square color-btn-nuevo"></i>
                                                    <strong class="color-btn-nuevo"> Añadir</strong>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="div-table-detalle-lotaip">
                                            <!--<table id="table-empleado" border="2" class="table">
                                                <thead class="background-thead">
                                                    <tr align="center">
                                                        <th align="center" class="border-bottom-0 color-th pad">Mes</th>
                                                        <th align="center" class="border-bottom-0 color-th pad">archivo</th>
                                                        <th align="center" class="border-bottom-0 color-th pad">Opciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-table-detalle-lotaip">

                                                </tbody>
                                            </table>-->
                                        </div>
                                        <!--<div class="row row-sm">
                        <div class="col-lg">
                            <strong>Año</strong>
                            <select class="form-control" id="select-ano" name="select-ano" placeholder="" >
                                <option value="0">Seleccione año</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                    </div>-->
                                    </form>
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
<!--INICIO MODAL ELIMINAR LITERAL DE LOTAIP -->
<div class="modal show" id="modal-eliminar-literal-lotaip" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-eliminar-literal-lotaip" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="txt-id-literal-lotaip-e" name="txt-id-literal-lotaip-e">
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                    <i class="icon icon ion-ios-close-circle-outline tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                    <h4 class="tx-danger mg-b-20">Seguro de eliminar el literal de LOTAIP</h4>
                    <!--<p class="mg-b-20 mg-x-20">There are many variations of passages of Lorem Ipsum available, but
					the majority have suffered alteration.</p>-->
                    <button aria-label="Close" class="btn ripple btn-danger pd-x-25" data-bs-dismiss="modal" type="button">Salir</button>
                    <button class="btn btn-success-gradient" id="btn-eliminar-literal-lotaip" type="button">
                        <i class="fa fa-times-circle"></i>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--FIN MODAL ELIMINAR ELIMINAR LITERAL DE LOTAIP -->
@endsection

@section('js')
<script type="text/javascript" src="/js/Lotaip/registrar_lotaip.js"></script>
<script>
    function subir_documento(id_literal) {
        let anio = $("#ip_id_lotaip").val();
        let mes = $("#ip_id_mes" + id_literal).val();
        alert("subir documento")
    }

    var $fileInput = $('.file-input');
    var $droparea = $('.file-drop-area');

    // highlight drag area
    $fileInput.on('dragenter focus click', function() {
        $droparea.addClass('is-active');
    });

    // back to normal state
    $fileInput.on('dragleave blur drop', function() {
        $droparea.removeClass('is-active');
    });

    // change inner text
    $fileInput.on('change', function() {
        var filesCount = $(this)[0].files.length;
        var $textContainer = $(this).prev();

        if (filesCount === 1) {
            // if single file is selected, show file name
            var fileName = $(this).val().split('\\').pop();
            $textContainer.text(fileName);
        } else {
            // otherwise show number of files
            $textContainer.text(filesCount + ' files selected');
        }
    });
</script>
@endsection

@else
<script>
    location.href = "/login";
</script>
@endif