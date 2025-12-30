<div class="modal" id="{{$idModalDocumento}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Tipo de Ingreso Vehícular</h1>
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
                    id="csrf_token_modal_add_mod_tipo_ingreso_vehicular"
                >
                <form
                    class="form"
                    novalidate
                    id="form_{{$idModalDocumento}}"
                    method="POST"
                >
                    <input type="hidden" name="id" id="id_{{$idModalDocumento}}">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>NOMBRE</strong>
                            <input class="form-control pd-r-80" type="text" id="txt_nombre_{{$idModalDocumento}}" 
                            name="nombre" 
                            placeholder="INGRESE EL NOMBRE PARA EL CAMPO"
                            data-label='Nombre'
                            maxlength="20"
                            style="text-transform: uppercase;">
                            <span class="badge bg-danger" data-for="txt_nombre_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>DÍAS RETENCIÓN</strong>
                            <input class="form-control pd-r-80" type="text" id="txt_dias_retencion_{{$idModalDocumento}}" 
                            name="dias_retencion" 
                            placeholder="INGRESE LOS DÍAS DE RETENCIÓN PARA EL CAMPO"
                            data-label='Dias Retención'
                            maxlength="3"
                            style="text-transform: uppercase;">
                            <span class="badge bg-danger" data-for="txt_dias_retencion_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>OBSERVACION</strong>
                            <textarea class="form-control"
                                        data-label='Observación'
                                        placeholder="INGRESE LA OBSERVACIÓN"
                                        name="observacion"
                                        id="txt_observacion_{{$idModalDocumento}}"
                                        rows="3"
                                        maxlength="200"
                                        style="text-transform: uppercase;"
                            ></textarea>
                            <span class="badge bg-danger" data-for="txt_observacion_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12 mg-t-10">
                            <div style="margin-left: 35px;">
                                <input class="form-check-input" type="checkbox" id="chk_estado_{{$idModalDocumento}}" name="estado" checked>
                                <label for="">Estado: <span id="text_check_estado_{{$idModalDocumento}}">Activo</span></label>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="documentos_requeridos">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_documentos_requeridos" aria-expanded="true" aria-controls="collapse_documentos_requeridos">
                            Documentos requeridos
                        </button>
                      </h2>
                      <div id="collapse_documentos_requeridos" class="accordion-collapse collapse show" aria-labelledby="documentos_requeridos" data-bs-parent="#accordionSeries">
                        <div id="container_documentos_requeridos" class="accordion-body container_documentos_requeridos">
                        </div>
                      </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_tipo_ingreso_vehicular" type="button"><i class="fa fa-save"></i> <span id="text_save_tipo_ingreso_vehicular">Guardar</span></button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        let checkEstado = document.getElementById('chk_estado_{{$idModalDocumento}}');
        let textCheckEstado = document.getElementById('text_check_estado_{{$idModalDocumento}}');
        checkEstado.addEventListener('change', (e)=>{
            textCheckEstado.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstado.innerHTML = "Activo";
        });
    });
</script>