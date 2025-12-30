<div class="modal" id="{{$idModalDocumento}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Tipo de Vehículo</h1>
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
                    id="csrf_token_modal_add_mod_tipo_vehiculo"
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
                            <strong>VALOR</strong>
                            <input class="form-control pd-r-80" type="text" id="txt_valor_{{$idModalDocumento}}" 
                            name="valor" 
                            placeholder="INGRESE EL VALOR PARA EL CAMPO"
                            data-label='Valor'
                            maxlength="5"
                            style="text-transform: uppercase;">
                            <span class="badge bg-danger" data-for="txt_valor_{{$idModalDocumento}}"></span>
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
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_tipo_vehiculo" type="button"><i class="fa fa-save"></i> <span id="text_save_tipo_vehiculo">Guardar</span></button>
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