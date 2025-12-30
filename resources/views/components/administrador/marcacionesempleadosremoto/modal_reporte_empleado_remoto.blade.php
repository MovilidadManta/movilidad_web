<div class="modal" id="{{$idModalMarcacionesEmpleadoRemoto}}">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title" id="title_{{$idModalMarcacionesEmpleadoRemoto}}"></h1>
                <button
                    aria-label="Close"
                    class="close"
                    data-bs-dismiss="modal"
                    type="button"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input
                    type="hidden"
                    name="csrf-token"
                    value="{{csrf_token()}}"
                    id="csrf_token_{{$idModalMarcacionesEmpleadoRemoto}}"
                >
                <form
                    class="form"
                    novalidate
                    id="form_{{$idModalMarcacionesEmpleadoRemoto}}"
                    method="POST"
                >
                    <div class="row" style="margin-bottom: 1em;">
                        <div class="col-xs-4 col-md-1 mg-t-10">
                            <strong>Fecha Inicio</strong>
                        </div>
                        <div class="col-xs-8 col-md-2">
                            <input class="form-control" name="fecha_inicio" id="input_fecha_inicio_{{$idModalMarcacionesEmpleadoRemoto}}"
                                type="date">
                            <span class="badge bg-danger" data-for="input_fecha_inicio_{{$idModalMarcacionesEmpleadoRemoto}}"></span>
                        </div>
                        <div class="col-xs-4 col-md-1 mg-t-10">
                            <strong>Fecha Fin</strong>
                        </div>
                        <div class="col-xs-8 col-md-2 mg-b-10">
                            <input class="form-control" name="fecha_fin" id="input_fecha_fin_{{$idModalMarcacionesEmpleadoRemoto}}"
                                type="date">
                            <span class="badge bg-danger" data-for="input_fecha_fin_{{$idModalMarcacionesEmpleadoRemoto}}"></span>
                        </div>
                        <div class="col-xs-12 col-md-2 text-end">
                            <a class="btn background-btn-nuevo pad-nu" id="btn_reporte_marcaciones_remotas_empleado_{{$idModalMarcacionesEmpleadoRemoto}}">
                                <i class="fa fa-search color-btn-nuevo"></i>
                                <strong class="color-btn-nuevo">Buscar</strong>
                            </a>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row row-sm">
                                    <div class="card-body">
                                        <div class="col-md-12 marg" id="optionsDownload_{{$idModalMarcacionesEmpleadoRemoto}}" style="display: none">
                                            <a id="downloadPDF_{{$idModalMarcacionesEmpleadoRemoto}}" target="_blank" href="">
                                                <i class="far fa-file-pdf tam-pdf"></i>
                                            </a>
                                            <a id="downloadExcel_{{$idModalMarcacionesEmpleadoRemoto}}" target="_blank" href="">
                                                <i class="far fa-file-excel tam-excell"></i>
                                            </a>
                                        </div>
                                        <div class="table-responsive">
                                            <div id="div_table_marcaciones_empleado_remotas_{{$idModalMarcacionesEmpleadoRemoto}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>