<div class="modal" id="{{$idModalDocumento}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Configurar Peticiones - <span id="title_modal_{{$idModalDocumento}}"></span></h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf_token_{{$idModalDocumento}}">
                <input type="hidden" name="u_id" id="u_id_{{$idModalDocumento}}">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_peticiones" aria-expanded="true" aria-controls="collapse_response">
                              Peticiones
                          </button>
                        </h2>
                        <div id="collapse_peticiones" class="accordion-collapse collapse show" aria-labelledby="1" data-bs-parent="#accordionSeries">
                          <div class="accordion-body">
                            <div class="row mb-3">
                                <div class="col-xs-12 col-md-9">
                                    <strong>Peticion:</strong>
                                    <input id="select_peticion_{{$idModalDocumento}}" data-label='Peticion' class="form-control input-mayus" data-noresults_text="No se encontraron resultados" data-wait_search="Buscando Peticiones..." type="text" autocomplete="off" placeholder="Buscar peticion..."
                                    value=""
                                    data-value=""
                                    data-text=""
                                    >
                                    <span class="badge bg-danger" data-for="select_peticion_{{$idModalDocumento}}"></span>
                                </div>
                                <div class="col-xs-12 col-md-3 d-flex justify-content-end align-items-end">
                                    <button class="btn btn-success-gradient btn-movi" id="btn_guardar_peticion_{{$idModalDocumento}}" type="button"><i class="fa fa-save"></i> Guardar</button>
                                </div>
                            </div>
                              <div class="row">
                                  <table border="2" class="table">
                                      <thead class="background-thead">
                                          <tr align="center">
                                              <th align="center" class="border-bottom-0 color-th">Modulo</th>
                                              <th align="center" class="border-bottom-0 color-th">Peticion</th>
                                              <th align="center" class="border-bottom-0 color-th">Opciones</th>
                                          </tr>
                                      </thead>
                                      <tbody id="tbody_control_peticiones">
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>