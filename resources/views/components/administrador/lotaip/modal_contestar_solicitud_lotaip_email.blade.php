<div class="modal" id="modal-contestar-solicitud-lotaip-email">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Constestación a solicitud de LOTAIP</h6><button aria-label="Close" class="close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{csrf_token()}}" id="csrf-token">
                <form class="form" novalidate id="form-contestacion-solicitud-lotaip-email" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="hidden-id-solicitud" id="hidden-id-solicitud">
                    <input type="hidden" name="hidden-numero-solicitud" id="hidden-numero-solicitud">
                    <input type="hidden" name="hidden-email-solicitud" id="hidden-email-solicitud">

                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-md-12 mg-t-10">
                                <div id="div-correo-message" class="mg-t-10 block">
                                    <strong id="email_text_send-email">El email se enviara al siguiente correo:</strong>
                                    <p id="correo_mostrar_email"></p>
                                </div>
                                <div id="div-correo-archivo" class="mg-t-10 block">
                                    <strong>Archivo</strong>
                                    <div>
                                        <button type="button" class="btn btn-info form_lotaip_fisico_save" id="btn_add_file_email"><i class="fa fa-plus" aria-hidden="true"></i>Agregar</button>
                                        <table border="1" class="table table-bor">
                                            <thead class="background-thead pad">
                                                <tr align="center">
                                                    <th align="center" class="border-bottom-0 color-th pad"><strong>Archivo: </strong></th>
                                                    <th align="center" class="border-bottom-0 color-th pad"><strong>Descripcion:</strong></th>
                                                    <th align="center" class="border-bottom-0 color-th pad">Acciones: </strong></th>
                                                </tr>
                                            </thead>
                                            <tbody style="border-top: 2px solid #fff;" id="tbody_files_email">
                                                <tr>
                                                    <td class="color-td" align="center" colspan="3">No existen archivos cargados</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div id="div-correo-respuesta" class="mg-t-10 block">
                                    <strong>Respuesta</strong>
                                    <input type="hidden" id="txt-respuesta" name="txt-respuesta">
                                    <div id="summernote" class="form_lotaip_fisico_save">

                                    </div>
                                    <textarea id="txt-respuesta-email-show" readonly style="display: none;" name="txt-respuesta-show" class="form-control form_lotaip_fisico_show" rows="6" style="resize: none"></textarea>
                                </div>
                            </div>

                            <div id='div-forma-recepcion'></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi form_lotaip_fisico_save" id="btn-guardar-contestacion-solicitud-lotaip-email"
                    onclick="guardar_contestacion_solicitud_lotaip_email()" type="button"><i class="fa fa-save"></i>
                    Enviar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button"><i
                        class="fas fa-times"></i> Salir</button>
            </div>
        </div>
    </div>
</div>