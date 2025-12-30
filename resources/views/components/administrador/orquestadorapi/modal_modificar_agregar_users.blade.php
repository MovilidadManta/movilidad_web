<div class="modal" id="{{$idModalDocumento}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title">Agregar/Modificar Usuarios</h1>
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
                    id="csrf_token_{{$idModalDocumento}}"
                >
                <form
                    class="form"
                    novalidate
                    id="form_{{$idModalDocumento}}"
                    method="POST"
                >
                    <input type="hidden" name="id" id="id_{{$idModalDocumento}}">
                    <input type="hidden" name="e_id" id="e_id_{{$idModalDocumento}}">
                    <div class="row">
                        <div class="col-xs-12">
                            <strong>USERNAME</strong>
                            <input
                                class="form-control"
                                name="txt_username"
                                data-label='Username'
                                id="txt_username_{{$idModalDocumento}}"
                                placeholder="Ingresar Username"
                                type="text"
                            >
                            <span class="badge bg-danger" data-for="txt_username_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12">
                            <strong>PASSWORD</strong>
                            <input
                                class="form-control"
                                name="txt_password"
                                data-label='Password'
                                id="txt_password_{{$idModalDocumento}}"
                                placeholder="Ingresar Password"
                                type="password"
                            >
                            <span class="badge bg-danger" data-for="txt_password_{{$idModalDocumento}}"></span>
                        </div>
                        <div class="col-xs-12 mg-t-10">
                            <div style="margin-left: 35px;">
                                <input class="form-check-input" type="checkbox" id="chk_control_peticiones_{{$idModalDocumento}}" name="u_control_peticiones" checked>
                                <label for="">Control de peticiones: <span id="text_check_control_peticiones_estado_{{$idModalDocumento}}">Activo</span></label>
                            </div>
                        </div>
                        <div class="col-xs-12 mg-t-10">
                            <div style="margin-left: 35px;">
                                <input class="form-check-input" type="checkbox" id="chk_ips_{{$idModalDocumento}}" name="u_control_ips" checked>
                                <label for="">Control Ips: <span id="text_check_ips_estado_{{$idModalDocumento}}">Activo</span></label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_user" type="button"><i class="fa fa-save"></i> <span id="text_save_user">Guardar</span></button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load", function (event) {
        const checkEstadoControlPeticiones = document.getElementById('chk_control_peticiones_{{$idModalDocumento}}');
        const textCheckEstadoControlPeticiones = document.getElementById('text_check_control_peticiones_estado_{{$idModalDocumento}}');
        checkEstadoControlPeticiones.addEventListener('change', (e)=>{
            textCheckEstadoControlPeticiones.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstadoControlPeticiones.innerHTML = "Activo";
        });

        const checkEstadoIps = document.getElementById('chk_ips_{{$idModalDocumento}}');
        const textCheckEstadoIps = document.getElementById('text_check_ips_estado_{{$idModalDocumento}}');
        checkEstadoIps.addEventListener('change', (e)=>{
            textCheckEstadoIps.innerHTML = "Inactivo";
            if(e.target.checked)
                textCheckEstadoIps.innerHTML = "Activo";
        });
    });
</script>