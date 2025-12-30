<div class="modal" id="modal-aprobar-certificado-medico">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Aprobar certificado médico</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-aprobar-certificado-medico" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="hidden-id-ficha-medica" id="hidden-id-ficha-medica">
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-md-12 mg-t-10">
                                <div class="mg-t-10 block">
                                    <strong>Archivo de certificado médico</strong>
                                    <div class="d-flex justify-content-center">
                                        <iframe id="frame-certificado-medico" class="frame-certificado-medico" src="" title="PDF certificado médico" style="width: 100%; height: 55vh;"></iframe>
                                    </div>
                                </div>
                                <div class="mg-t-10 form_ficha_medica_save">
                                    <strong>Archivo</strong>
                                    <input type="file" class="dropify" name="txt-file" id="txt-file-certificado"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        data-max-file-size="3M" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi form_ficha_medica_save" id="btn-guardar-aprobacion-certificado-medico"
                    onclick="guardar_aprobacion_certificado_medico()" type="button"><i class="fa fa-save"></i>
                    Aprobar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>