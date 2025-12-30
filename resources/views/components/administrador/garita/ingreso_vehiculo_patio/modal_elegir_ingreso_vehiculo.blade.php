<div class="modal" id="{{$idModalTipoIngreso}}">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Tipo de Ingreso</h1>
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
                <div class="container-fluid">
                    <div class="row justify-content-between">
                        <input id="tiv_id_{{$idModalTipoIngreso}}" name="tiv_id" type="hidden" value="0">
                        @foreach ($tipoIngreso as $tipo)
                            <div class="col-12 col-md-4">
                                <x-administrador.garita.ingreso_vehiculo_patio.components_ingreso.card_tipo_ingreso id="{{$tipo->tiv_id}}" srcImage="{{$tipo->ruta_imagen}}" titulo="{{$tipo->tiv_nombre}}" descripcion="{{$tipo->tiv_observacion}}">
                                </x-administrador.garita.ingreso_vehiculo_patio.components_ingreso.card_tipo_ingreso>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <strong>Descripción del ingreso</strong>
                            <textarea class="form-control" name="ivp_descripcion" id="ivp_descripcion_{{$idModalTipoIngreso}}" cols="30" rows="10" style="text-transform: uppercase;" maxlength="200"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi btn-grow" id="btn_siguiente-{{$idModalTipoIngreso}}" type="button" disabled>Siguiente  <i class="fa fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>