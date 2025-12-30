<div class="modal" id="modal-contestar-solicitud-lotaip-fisico">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Constestación a solicitud de LOTAIP</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-contestacion-solicitud-lotaip-fisico" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="hidden-id-solicitud" id="hidden-id-solicitud-fisico">

                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-md-12 mg-t-10">
                                <div class="mg-t-10 block">
                                    <strong id="text_respuesta_archivo_fisico">Archivo de recibo</strong>
                                    <div class="d-flex justify-content-center">
                                        <iframe id="frame-recibido-lotaip" class="frame-recibido-lotaip" src="" title="PDF recibido solicitud"></iframe>
                                    </div>
                                </div>
                                <div class="mg-t-10 form_lotaip_fisico_save">
                                    <strong>Archivo</strong>
                                    <input type="file" class="dropify" name="txt-file" id="txt-file-fisico"
                                        data-max-file-size="3M" />
                                </div>
                                <div id="div-correo-respuesta" class="mg-t-10 block">
                                    <strong>Respuesta</strong>
                                    <textarea id="txt-respuesta-fisico" name="txt-respuesta" class="form-control" rows="6" style="resize: none"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi form_lotaip_fisico_save" id="btn-guardar-contestacion-solicitud-lotaip-fisico"
                    onclick="guardar_contestacion_solicitud_lotaip_fisico()" type="button"><i class="fa fa-save"></i>
                    Enviar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>