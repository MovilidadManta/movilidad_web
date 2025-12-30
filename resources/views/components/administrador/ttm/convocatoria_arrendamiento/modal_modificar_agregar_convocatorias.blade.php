<div class="modal" id="{{$idModalDocumento}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Convocatorias</h1>
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
                    id="csrf_token_modal_add_mod_convocatoria"
                >
                <form
                    class="form"
                    novalidate
                    id="form_{{$idModalDocumento}}"
                    method="POST"
                >
                    <input type="hidden" name="id" id="id_{{$idModalDocumento}}">
                    <input type="hidden" name="archivo_old" id="archivo_old_{{$idModalDocumento}}">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>DESCRIPCIÓN</strong>
                            <textarea class="form-control"
                                        data-label='Descripción'
                                        placeholder="INGRESE LA DESCRIPCIÓN"
                                        name="descripcion"
                                        id="txt_descripcion_{{$idModalDocumento}}"
                                        rows="3"
                            ></textarea>
                            <span class="badge bg-danger" data-for="txt_descripcion_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>Archivo</strong>
                            <input type="file" class="dropify" name="file" id="txt_file_archivo_{{$idModalDocumento}}"
                                        data-label='Archivo'            
                                        accept=".pdf"
                                        data-max-file-size="3M" />
                            <span class="badge bg-danger" data-for="txt_file_archivo_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12 mg-t-10">
                            <div style="margin-left: 35px;">
                                <input class="form-check-input" type="checkbox" id="chk_estado_{{$idModalDocumento}}" name="estado" checked>
                                <label for="">Estado: <span id="text_check_estado_{{$idModalDocumento}}">Activo</span></label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_convocatoria_arrendamiento" type="button"><i class="fa fa-save"></i> <span id="text_save_convocatoria_arrendamiento">Guardar</span></button>
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