<div class="modal" id="{{$idModalEmpleadoRemoto}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h1 class="modal-title" id="title_{{$idModalEmpleadoRemoto}}">Agregar Empleado Remoto</h1>
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
                    id="csrf_token_{{$idModalEmpleadoRemoto}}"
                >
                <form
                    class="form"
                    novalidate
                    id="form_{{$idModalEmpleadoRemoto}}"
                    method="POST"
                >
                    <input type="hidden" name="cer_id" id="cer_id_{{$idModalEmpleadoRemoto}}">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="container_modal_foto_empleado text-center">
                                <img id="foto_empleado_{{$idModalEmpleadoRemoto}}" class="foto_empleado" src="Imagenes/utilitarios/usuario.png" data-src="Imagenes/utilitarios/usuario.png" alt="Foto del empleado">
                            </div>
                        </div>
                        <div class="col-xs-12 mg-t-10 mg-lg-t-0">
                            <strong>Empleado</strong>
                            <input id="txt_search_emp_{{$idModalEmpleadoRemoto}}" class="form-control input-mayus" data-label='Empleado' data-noresults_text="No se encontraron resultados" data-wait_search="Buscando Empleados..." type="text" autocomplete="off" placeholder="Buscar por cédula o nombre"
                            value=""
                            data-value=""
                            data-text=""
                            >
                            <span class="badge bg-danger" data-for="txt_search_emp_{{$idModalEmpleadoRemoto}}"></span>
                        </div>
                        <div class="col-xs-12 mg-t-10 mg-lg-t-0">
                            <strong>F. Nacimiento</strong>
                            <input class="form-control" name="txt_fecha_nacimiento_empleado" id="txt_fecha_nacimiento_empleado_{{$idModalEmpleadoRemoto}}"
                            value=""
                            type="text" 
                            readonly>
                            <span class="badge bg-danger" data-for="txt_fecha_nacimiento_empleado_{{$idModalEmpleadoRemoto}}"></span>
                        </div>
                        <div class="col-xs-12 mg-t-10 mg-lg-t-0">
                            <strong>Departamento</strong>
                            <input class="form-control" name="txt_departamento_empleado" id="txt_departamento_empleado_{{$idModalEmpleadoRemoto}}"
                            value=""
                            type="text" 
                            readonly>
                            <span class="badge bg-danger" data-for="txt_departamento_empleado_{{$idModalEmpleadoRemoto}}"></span>
                        </div>
                        <div class="col-xs-12 mg-t-10 mg-lg-t-0">
                            <strong>Puesto de trabajo</strong>
                            <input class="form-control" name="txt_cargo_empleado" id="txt_cargo_empleado_{{$idModalEmpleadoRemoto}}"
                            value=""
                            type="text" 
                            readonly>
                            <span class="badge bg-danger" data-for="txt_cargo_empleado_{{$idModalEmpleadoRemoto}}"></span>
                        </div>
                        <div class="col-xs-12 mg-t-10 mg-lg-t-0">
                            <strong>Fecha Inicio</strong>
                            <input class="form-control" name="cer_fecha_inicio" id="cer_fecha_inicio_{{$idModalEmpleadoRemoto}}"
                            value=""
                            type="date" >
                            <span class="badge bg-danger" data-for="cer_fecha_inicio_{{$idModalEmpleadoRemoto}}"></span>
                        </div>
                        <div class="col-xs-12 mg-t-10 mg-lg-t-0">
                            <strong>Habilitar Fecha Fin</strong>
                            <div class="main-toggle main-toggle-success" id="check_habilitar_fecha_fin_{{$idModalEmpleadoRemoto}}">
                                <span></span>
                            </div>
                        </div>
                        <div class="col-xs-12 mg-t-10 mg-lg-t-0">
                            <strong>Fecha Fin</strong>
                            <input class="form-control" name="cer_fecha_fin" id="cer_fecha_fin_{{$idModalEmpleadoRemoto}}""
                            value=""
                            type="date"
                            disabled>
                            <span class="badge bg-danger" data-for="cer_fecha_fin_{{$idModalEmpleadoRemoto}}"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success-gradient btn-movi" id="btn_guardar_empleado_remoto" type="button"><i class="fa fa-save"></i> Guardar</button>
                <button class="btn ripple btn-dark-gradient" data-bs-dismiss="modal" type="button">
                    <i class="fas fa-times"></i> Salir
                </button>
            </div>
        </div>
    </div>
</div>