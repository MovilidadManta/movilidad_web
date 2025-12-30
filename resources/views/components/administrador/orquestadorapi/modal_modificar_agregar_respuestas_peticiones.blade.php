<div class="modal" id="modal_configurar_respuestas">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Configurar Respuestas - <span id="title_modal_configurar_respuestas"></span></h6>
                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf_token_configurar_respuestas">
                <input type="hidden" id="p_id_peticion">
                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_response" aria-expanded="true" aria-controls="collapse_response">
                              Respuestas
                          </button>
                        </h2>
                        <div id="collapse_response" class="accordion-collapse collapse show" aria-labelledby="1" data-bs-parent="#accordionSeries">
                          <div class="accordion-body">
                              <div class="row mb-3">
                                  <div class="col-xs-12 col-md-6">
                                      <strong>Código Respuesta:</strong>
                                      <input
                                        class="form-control"
                                        name="txt_codigo_respuesta"
                                        data-label='Código Respuesta'
                                        id="txt_codigo_respuesta"
                                        placeholder="Código Respuesta"
                                        type="text"
                                        >
                                      <span class="badge bg-danger" data-for="txt_codigo_respuesta"></span>
                                  </div>
                                  <div class="col-xs-12 col-md-6">
                                    <strong>Código API:</strong>
                                    <input
                                      class="form-control"
                                      name="txt_codigo_api"
                                      data-label='Código API'
                                      id="txt_codigo_api"
                                      placeholder="Código API"
                                      type="text"
                                      >
                                    <span class="badge bg-danger" data-for="txt_codigo_api"></span>
                                  </div>
                                  <div class="col-xs-12">
                                    <strong>Formato Respuesta:</strong>
                                    <textarea class="form-control"
                                        data-label='Formato respuesta'
                                        placeholder="Formato Respuesta"
                                        name="txt_formato_respuesta"
                                        id="txt_formato_respuesta"
                                        rows="3"
                                    ></textarea>
                                    <span class="badge bg-danger" data-for="txt_formato_respuesta"></span>
                                  </div>
                                  <div class="col-xs-12">
                                    <strong>Formato API:</strong>
                                    <textarea class="form-control"
                                        data-label='Formato API'
                                        placeholder="Formato API"
                                        name="txt_formato_api"
                                        id="txt_formato_api"
                                        rows="3"
                                    ></textarea>
                                    <span class="badge bg-danger" data-for="txt_formato_api"></span>
                                  </div>
                                  <div class="col-xs-12 mb-3">
                                    <strong>Orden:</strong>
                                    <input
                                      class="form-control"
                                      name="txt_orden"
                                      data-label='Orden'
                                      id="txt_orden"
                                      placeholder="Orden"
                                      type="text"
                                      >
                                    <span class="badge bg-danger" data-for="txt_orden"></span>
                                  </div>
                                  <div class="col-xs-12 d-flex justify-content-center align-items-center">
                                      <button class="btn btn-success" id="btn_nuevo_respuesta" type="button"><i class="fa fa-plus"></i> Nuevo</button>
                                        
                                      <button class="btn btn-success-gradient btn-movi" id="btn_guardar_respuesta" type="button"><i class="fa fa-save"></i> Guardar</button>
                                  </div>
                              </div>
                              <div class="row">
                                  <table border="2" class="table">
                                      <thead class="background-thead">
                                          <tr align="center">
                                              <th align="center" class="border-bottom-0 color-th">Codigo Respuesta</th>
                                              <th align="center" class="border-bottom-0 color-th">Codigo API</th>
                                              <th align="center" class="border-bottom-0 color-th">Orden</th>
                                              <th align="center" class="border-bottom-0 color-th">Opciones</th>
                                          </tr>
                                      </thead>
                                      <tbody id="tbody_configurar_respuestas">
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